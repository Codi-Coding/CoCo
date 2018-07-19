<?php
class theme extends qfile
{
	protected $path			= '';
	protected $tmp_path		= '';
	protected $theme_path	= '';
	protected $page_type	= '';
	protected $me_pid		= '';
	protected $bo_new		= 24;

	// Constructor Function
	public function __construct() {
		global $g5, $theme, $shop_theme, $bo_table, $co_id, $gr_id, $board, $pid, $ca_id, $it_id, $faq, $fm_id, $sca, $tag, $po_id, $ev_id;

		$this->tmp_path		= G5_DATA_PATH . '/tmp';
		$this->theme_path	= EYOOM_THEME_PATH;
		
		if($theme) {
			$this->page_type = 'theme';
			$this->me_pid = $theme;
		} else if($shop_theme) {
			$this->page_type = 'shop_theme';
			$this->me_pid = $shop_theme;
		} else if($bo_table) {
			$this->page_type = 'board';
			$this->me_pid = $bo_table;
		} else if($gr_id) {
			$this->page_type = 'group';
			$this->me_pid = $gr_id;
		} else if($co_id) {
			$this->page_type = 'page';
			$this->me_pid = $co_id;
		} else if($pid) {
			$this->page_type = 'pid';
			$this->me_pid = $pid;
		} else if($ca_id) {
			$this->page_type = 'shop';
			$this->me_pid = $ca_id;
		} else if ($it_id) {
			$this->page_type = 'item';
			$this->me_pid = $it_id;
		} else if($fm_id) {
			$this->page_type = 'faq';
			$this->me_pid = $fm_id;
		} else if($tag) {
			$this->page_type = 'tag';
			$this->me_pid = $tag;
		} else if($po_id) {
			$this->page_type = 'poll';
			$this->me_pid = $po_id;
		} else if($ev_id) {
			$this->page_type = 'event';
			$this->me_pid = $ev_id;
		}
	}

	// 사용자 테마설정파일 저장 경로
	protected function theme_userdir() {
		$theme_path = G5_DATA_PATH.'/member/theme';
		if(!@is_dir($theme_path)) {
			@mkdir($theme_path, G5_DIR_PERMISSION);
			@chmod($theme_path, G5_DIR_PERMISSION);
		}
		return $theme_path;
	}

	// 사용자 지정 테마 설정
	public function set_user_theme($arr) {
		global $g5, $eyoom;
		
		$is_shop_theme = false;
		if ($arr['theme']) {
			$tm_name = $arr['theme'];
		} else if ($arr['shop_theme']) {
			$tm_name = $arr['shop_theme'];
			$is_shop_theme = true;
		}

		// 테마정보 가져오기
		$tminfo = sql_fetch("select * from {$g5['eyoom_theme']} where tm_name='{$tm_name}' || tm_alias='{$tm_name}'",false);

		// 지정한 사용자 테마 체크
		if($tminfo['tm_name'] && is_dir($this->theme_path.'/'.$tminfo['tm_name'])) {
			if ($is_shop_theme) {
				$arr['theme'] 		= $eyoom['theme'];
				$arr['shop_theme'] 	= $tminfo['tm_name'];
			} else {
				$arr['theme'] 		= $tminfo['tm_name'];
				$arr['shop_theme'] 	= $eyoom['shop_theme'];
			}
		} else {
			$arr['theme'] 		= $eyoom['theme'];
			$arr['shop_theme'] 	= $eyoom['shop_theme'];
		}
		
		// 유니크 아이디 쿠키 생성
		if(get_cookie('unique_theme_id')) {
			$unique_theme_id = get_cookie('unique_theme_id');
		} else {
			$unique_theme_id = date('YmdHis', time()) . str_pad((int)(microtime()*100), 2, "0", STR_PAD_LEFT);
			set_cookie('unique_theme_id',$unique_theme_id,3600);
		}

		$file = $this->tmp_path . '/' . $_SERVER['REMOTE_ADDR'] . '.' . $unique_theme_id . '.php';
		if(file_exists($file)) {
			include_once($file);
			if ($is_shop_theme) {
				$arr['theme'] 		= $user_config['theme'];
			} else {
				$arr['shop_theme'] 	= $user_config['shop_theme'];
			}
		}
		$_config = $arr;
		

		//파일 생성 및 갱신
		parent::save_file('user_config', $file, $_config);

		// 특정시간이 지난 파일은 자동 삭제
		parent::del_timeover_file($this->tmp_path);

		// 사용자 테마가 없다면 파일삭제
		if(!$_config['theme']) {
			parent::del_file($file);
			return false;
		} else return $_config;
	}

	// 사용자 지정 테마 가져오기
	public function get_user_theme() {
		global $eb;

		$unique_theme_id = get_cookie('unique_theme_id');
		$file = $this->tmp_path . '/' . $_SERVER['REMOTE_ADDR'] . '.' . $unique_theme_id . '.php';

		if(@file_exists($file)) {
			include_once($file);
			return $user_config;
		} else return false;
	}

	// PC/모바일 버전보기 링크 생성하기
	public function get_href($handle) {
		if ($handle == 'bs') {
			return;
		} else {
			switch($handle) {
				case 'pc': $device = 'mobile'; break;
				case 'mo': $device = 'pc'; break;
			}
			if(G5_USE_MOBILE) {
				$seq = 0;
				$p = parse_url(G5_URL);
				$href = $p['scheme'].'://'.$p['host'].$_SERVER['PHP_SELF'];
				if($_SERVER['QUERY_STRING']) {
					$sep = '?';
					foreach($_GET as $key=>$val) {
						if($key == 'device')
							continue;

						$href .= $sep.$key.'='.strip_tags($val);
						$sep = '&amp;';
						$seq++;
					}
				}
				if($seq)
					$href .= '&amp;device='.$device;
				else
					$href .= '?device='.$device;
			}
			return $href;
		}
	}

	// 자동메뉴 연동/생성
	public function menu_create($flag) {
		if(!$flag) $flag = 'g5';
		switch($flag) {
			case 'g5'	: $menu = $this->g5_menu_create(); break;
			case 'eyoom': $menu = $this->eyoom_menu_create(); break;
		}
		return $menu;
	}

	// 그누메뉴 자동생성 : 반복문 안에 SQL문이 반복되어 메뉴가 많을 경우 느려지는 원인이 될 수 있음
	private function g5_menu_create() {
		global $g5, $bo_table, $co_id, $gr_id, $board;

		if($bo_table) {
			$str = "bo_table={$bo_table}";
			$grp = sql_fetch("select gr_id from {$g5['board_table']} where bo_table = '{$bo_table}'");
			$gr_str = "gr_id=".$grp['gr_id'];
		}
		if($gr_id) {
			$gr_str = "gr_id=".$gr_id;
		}
		if($co_id) $str = "co_id={$co_id}";

		$sql = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '2' order by me_order, me_id ";
		$result = sql_query($sql, false);

		for ($i=0; $row=sql_fetch_array($result); $i++) {
			if($str || $gr_str) {
				if((preg_match("/".$gr_str."/i",$row['me_link']) && $gr_str) || (preg_match("/".$str."/i",$row['me_link'])) && $str) {
					if(!defined('_INDEX_')) $row['active'] = true;
				}
			}
			$menu[$i] = $row;

			$loop = &$menu[$i]['submenu'];
			$sql2 = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$row['me_code']}' order by me_order, me_id ";
			$result2 = sql_query($sql2, false);

			for ($k=0; $row2=sql_fetch_array($result2); $k++) {
				if(preg_match("/".$str."/i",$row2['me_link']) && $str!='') { $row2['active'] = true; }

				list($url,$tmp_bo_table) = explode("=",$row2['me_link']);
				$sql = "select count(*) as cnt from {$g5['board_new_table']} where bn_datetime between date_format(".date("YmdHis",G5_SERVER_TIME - ($this->bo_new * 3600)).", '%Y-%m-%d %H:%i:%s') AND date_format(".date("YmdHis",G5_SERVER_TIME).", '%Y-%m-%d %H:%i:%s') and bo_table = '{$tmp_bo_table}' and wr_id = wr_parent";
				$new = sql_fetch($sql,false);

				if($new['cnt']>0) {
					$row2['new'] = true;
					$menu[$i]['new'] = true;
				}

				$loop[$k] = $row2;
			}
			$menu[$i]['cnt'] = count($loop);
		}
		return $menu;
	}

	// 이윰메뉴 
	private function eyoom_menu_create() {
		global $me_shop;
		// 메뉴정보 가져오기
		$menu_package = $this->eyoom_menu($me_shop);
		if(!$menu_package) return false;
		$menu = $this->eyoom_menu_assign($menu_package);
		return $menu;
	}

	// 이윰메뉴 재정의
	private function eyoom_menu_assign($menu_package) {
		global $member, $sca;

		// 새글정보 가져오기
		$new = $this->eyoom_menu_new();
		$ca_new = $this->eyoom_menu_ca_new();

		// 5단계까지 가능하지만 3단계까지 표현
		foreach($menu_package as $key => $menuset) {
			foreach($menuset as $k => $menu_sub) {
				if(!is_array($menu_sub)) {
					// 회원레벨이 허용레벨보다 작다면 보이지 않기
					if($member['mb_level'] < $menuset['me_permit_level']) continue;
					$mk1 = $menuset['me_order'].$key;
					$menu[$mk1][$k] = $menu_sub;
					if($menuset['me_sca']) {
						if($menuset['me_type'] == $this->page_type && $menuset['me_pid'] == $this->me_pid && $menuset['me_sca'] == urldecode($sca)) {
							if(!defined('_INDEX_')) $menu[$mk1]['active'] = true;
						}
					} else {
						if($menuset['me_type'] == $this->page_type && $menuset['me_pid'] == $this->me_pid) {
							if(!defined('_INDEX_')) $menu[$mk1]['active'] = true;
						}
					}

					@ksort($menu);
				} else {
					$cate1 = &$menu[$mk1]['submenu'];
					foreach($menu_sub as $m => $sub) {
						if(!is_array($sub)) {
							// 회원레벨이 허용레벨보다 작다면 보이지 않기
							if($member['mb_level'] < $menu_sub['me_permit_level']) continue;
							$mk2 = $menu_sub['me_order'].$k;
							$cate1[$mk2][$m] = $sub;
							if($menu_sub['me_sca']) {
								if($menu_sub['me_type'] == $this->page_type && $menu_sub['me_pid'] == $this->me_pid && $menu_sub['me_sca'] == urldecode($sca)) {
									if(!defined('_INDEX_')) $menu[$mk1]['active'] = true;
									$cate1[$mk2]['active'] = true;
								}
							} else {
								if($menu_sub['me_type'] == $this->page_type && $menu_sub['me_pid'] == $this->me_pid) {
									if(!defined('_INDEX_')) $menu[$mk1]['active'] = true;
									$cate1[$mk2]['active'] = true;
								}
							}
							@ksort($cate1);
						} else {
							$cate1[$mk2]['sub'] = 'on';
							$cate2 = &$cate1[$mk2]['subsub'];
							foreach($sub as $n => $subsub) {
								if(!is_array($subsub)) {
									// 회원레벨이 허용레벨보다 작다면 보이지 않기
									if($member['mb_level'] < $sub['me_permit_level']) continue;
									$mk3 = $sub['me_order'].$m;
									$cate2[$mk3][$n] = $subsub;
									if($sub['me_sca']) {
										if($sub['me_type'] == $this->page_type && $sub['me_pid'] == $this->me_pid && $sub['me_sca'] == urldecode($sca)) {
											if(!defined('_INDEX_')) $menu[$mk1]['active'] = true;
											$cate1[$mk2]['active'] = true;
											$cate2[$mk3]['active'] = true;
										}
									} else {
										if($sub['me_type'] == $this->page_type && $sub['me_pid'] == $this->me_pid) {
											if(!defined('_INDEX_')) $menu[$mk1]['active'] = true;
											$cate1[$mk2]['active'] = true;
											$cate2[$mk3]['active'] = true;
										}
									}
									@ksort($cate2);
								} else {
									$cate1[$mk2]['sub'] = 'on';
									$cate2[$mk3]['sub'] = 'on';
									$cate3 = &$cate2[$mk3]['ssubsub'];
									foreach($subsub as $o => $ssubsub) {
										if (!is_array($ssubsub)) {
											// 회원레벨이 허용레벨보다 작다면 보이지 않기
											if($member['mb_level'] < $subsub['me_permit_level']) continue;
											$mk4 = $subsub['me_order'].$n;
											$cate3[$mk4][$o] = $ssubsub;
											if($subsub['me_sca']) {
												if($subsub['me_type'] == $this->page_type && $subsub['me_pid'] == $this->me_pid && $subsub['me_sca'] == urldecode($sca)) {
													if(!defined('_INDEX_')) $menu[$mk1]['active'] = true;
													$cate1[$mk2]['active'] = true;
													$cate2[$mk3]['active'] = true;
													$cate3[$mk4]['active'] = true;
												}
											} else {
												if($subsub['me_type'] == $this->page_type && $subsub['me_pid'] == $this->me_pid) {
													if(!defined('_INDEX_')) $menu[$mk1]['active'] = true;
													$cate1[$mk2]['active'] = true;
													$cate2[$mk3]['active'] = true;
													$cate3[$mk4]['active'] = true;
												}
											}
											@ksort($cate3);
										}
									}
									if($subsub['me_type'] == 'board' && $subsub['me_pid']) {
										$tmp_bo_table = $subsub['me_pid'];
										if($sub['me_sca']) {
											if($ca_new[$sub['me_sca']]>0) {
												$cate3[$mk4]['new'] = true;
												$cate2[$mk3]['new'] = true;
												$cate1[$mk2]['new'] = true;
												$menu[$mk1]['new'] = true;
											}
										} else {
											if($new[$tmp_bo_table]>0) {
												$cate3[$mk4]['new'] = true;
												$cate2[$mk3]['new'] = true;
												$cate1[$mk2]['new'] = true;
												$menu[$mk1]['new'] = true;
											}
										}
									}
								}
							}
							if($sub['me_type'] == 'board' && $sub['me_pid']) {
								$tmp_bo_table = $sub['me_pid'];
								if($sub['me_sca']) {
									if($ca_new[$sub['me_sca']]>0) {
										$cate2[$mk3]['new'] = true;
										$cate1[$mk2]['new'] = true;
										$menu[$mk1]['new'] = true;
									}
								} else {
									if($new[$tmp_bo_table]>0) {
										$cate2[$mk3]['new'] = true;
										$cate1[$mk2]['new'] = true;
										$menu[$mk1]['new'] = true;
									}
								}
							}
						}
					}
					if($menu_sub['me_type'] == 'board' && $menu_sub['me_pid']) {
						$tmp_bo_table = $menu_sub['me_pid'];
						if($menu_sub['me_sca']) {
							if($ca_new[$menu_sub['me_sca']]>0) {
								$cate1[$mk2]['new'] = true;
								$menu[$mk1]['new'] = true;
							}
						} else {
							if($new[$tmp_bo_table]>0) {
								$cate1[$mk2]['new'] = true;
								$menu[$mk1]['new'] = true;
							}
						}
					}
				}
			}
			if($menuset['me_type'] == 'board' && $menuset['me_pid']) {
				$tmp_bo_table = $menuset['me_pid'];
				if($menuset['me_sca']) {
					if($ca_new[$menuset['me_sca']]>0) {
						$menu[$mk1]['new'] = true;
					}
				} else {
					if($new[$tmp_bo_table]>0) {
						$menu[$mk1]['new'] = true;
					}
				}
			}
		}
		return $menu;
	}

	// 이윰 New 테이블에서 최근글 정보 가져옴 : 2015-02-25 그림자밟기님이 아이디어를 제공해 주셨습니다.
	private function eyoom_menu_new($bo_new=24) {
		global $g5;
		if(!$bo_new) $bo_new = $this->bo_new;
		$sql = "select bo_table, count(*) as cnt from {$g5['board_new_table']} where bn_datetime between date_format(".date("YmdHis",G5_SERVER_TIME - ($bo_new * 3600)).", '%Y-%m-%d %H:%i:%s') AND date_format(".date("YmdHis",G5_SERVER_TIME).", '%Y-%m-%d %H:%i:%s') and wr_id = wr_parent group by bo_table";
		$res = sql_query($sql, false);
		for($i=0;$row=sql_fetch_array($res);$i++) {
			$new[$row['bo_table']] = $row['cnt'];
		}
		return $new;
	}
	
	// 게시판 분류사용시, 새글정보
	private function eyoom_menu_ca_new($bo_new=24) {
		global $g5;
		if(!$bo_new) $bo_new = $this->bo_new;
		$sql = "select ca_name, count(*) as cnt from {$g5['eyoom_new']} where bn_datetime between date_format(".date("YmdHis",G5_SERVER_TIME - ($bo_new * 3600)).", '%Y-%m-%d %H:%i:%s') AND date_format(".date("YmdHis",G5_SERVER_TIME).", '%Y-%m-%d %H:%i:%s') and wr_id = wr_parent group by ca_name";
		$res = sql_query($sql, false);
		for($i=0;$row=sql_fetch_array($res);$i++) {
			$ca_new[$row['ca_name']] = $row['cnt'];
		}
		return $ca_new;
	}
	
	// 링크로 부터 sca 추출하기
	private function get_sca_from_link($link) {
		$str = parse_url(urldecode($link));
		parse_str($str['query'], $query);
		return $query['sca'];
	}

	// 이윰메뉴 5단계까지 구현
	public function eyoom_menu($me_shop=2) {
		global $g5, $admin_mode, $theme, $shop_theme;

		if(!$admin_mode) $addwhere = " and me_use = 'y' and me_use_nav = 'y' ";
		if(!$me_shop) $me_shop = 2;
		
		$theme_name = $me_shop == 1 || defined('_SHOP_') ? $shop_theme: $theme;
		if ($admin_mode) $theme_name = $theme;
		$addwhere .= " and me_shop = '".$me_shop."' ";
		$sql = "select * from {$g5['eyoom_menu']} where me_theme='{$theme_name}' {$addwhere} order by me_code asc, me_order asc";
		$res = sql_query($sql, false);
		for($i=0;$row=sql_fetch_array($res);$i++) {
			$split = str_split($row['me_code'],3);
			$depth = count($split);

			if($depth==1) $menu[$split[0]] = $row;
			if($depth==2) $menu[$split[0]][$split[1]] = $row;
			if($depth==3) $menu[$split[0]][$split[1]][$split[2]] = $row;
			if($depth==4) $menu[$split[0]][$split[1]][$split[2]][$split[3]] = $row;
			if($depth==5) $menu[$split[0]][$split[1]][$split[2]][$split[3]][$split[4]] = $row;
		}
		return $menu;
	}

	// 서브페이지 좌/우측에 해당 페이지의 서브메뉴 가져오기
	public function submenu_create($flag='') {
		if(!$flag) $flag = 'g5';
		switch($flag) {
			case 'g5'	: $submenu = $this->g5_submenu_create(); break;
			case 'eyoom': $submenu = $this->eyoom_submenu_create(); break;
		}
		return $submenu;
	}

	private function g5_submenu_create($me_code) {
		global $g5;

		$sql = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$me_code}' order by me_order, me_id ";
		$result = sql_query($sql, false);

		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$submenu[$i] = $row;
		}
		return $submenu;
	}

	// 이윰 서브메뉴 생성하기
	private function eyoom_submenu_create() {
		$data = $this->eyoom_pagemenu_info();
		$menu_package = $this->eyoom_submenu($data);
		if(!$menu_package) return false;
		$submenu = $this->eyoom_menu_assign($menu_package);
		return $submenu;
	}

	// 페이지 정보 가져오기
	private function eyoom_pagemenu_info() {
		global $g5, $theme;
		$url = $this->compare_host_from_link($_SERVER['REQUEST_URI']);
		$info = $this->get_meinfo_link($url);
		$sql = "select * from {$g5['eyoom_menu']} where me_theme='{$theme}' and me_type='{$info['me_type']}' and me_pid='{$info['me_pid']}'";
		$data = sql_fetch($sql,false);
		return $data;
	}

	// 이윰 서브메뉴
	public function eyoom_submenu($data) {
		global $g5, $theme;

		if(!$data) $data = $this->eyoom_pagemenu_info();
		if(!$admin_mode) $addwhere = " and me_use = 'y' "; // 감추기 기능 연동 - fm25님이 제보해 주셨습니다.
		$me_code = str_split($data['me_code'],3);
		$sql = "select * from {$g5['eyoom_menu']} where me_theme='{$theme}' and me_code like '{$me_code[0]}%' and length(me_code) > 3 {$addwhere} order by me_code asc, me_order asc";
		$res = sql_query($sql, false);
		for($i=0;$row=sql_fetch_array($res);$i++) {
			$split = str_split($row['me_code'],3);
			$depth = count($split);

			if($depth==2) $menu[$split[1]] = $row;
			if($depth==3) $menu[$split[1]][$split[2]] = $row;
			if($depth==4) $menu[$split[1]][$split[2]][$split[3]] = $row;
			if($depth==5) $menu[$split[1]][$split[2]][$split[3]][$split[4]] = $row;
		}
		return $menu;
	}

	// 이윰배열을 JSON 형식으로 변환
	public function eyoom_menu_json($arr) {
		$output = '';
		if(is_array($arr)) {
			$output .= ',"children":[';
			foreach($arr as $key => $val) {
				if(is_array($val)) {
					if(strlen($val['me_code'])<2) continue;
					unset($blind);
					if($val['me_use'] == 'n') $blind = " <span style='color:#f30;'><i class='fa fa-eye-slash'></i></span>";
					$_output[$val['me_order']] .= '{';
					$_output[$val['me_order']] .= '"id":"'.$val['me_code'].'",';
					$_output[$val['me_order']] .= '"order":"'.$val['me_order'].'",';
					$_output[$val['me_order']] .= '"text":"'.$val['me_name'].$blind.'"';
					if(is_array($val) && count($val)>3) $_output[$val['me_order']] .= $this->eyoom_menu_json($val);
					$_output[$val['me_order']] .= '}';
				}
			}
			@ksort($_output);
			$output .= @implode(',',$_output);
			$output .= ']';
		}
		return $output;
	}

	// 메뉴코드를 단계별로 잘라 배열에 담기
	private function get_splited_code($split=array()) {
		$cnt = count($split);
		if($cnt<1) return false;
		else {
			for($i=0;$i<count($split);$i++) {
				if($i==0) $code[$i] = $split[$i];
				else $code[$i] = $code[$i-1].$split[$i];
			}
		}
		return $code;
	}

	// 메뉴코드에서 위치정보 가져오기 - 반복문 안에 쿼리문으로 권장하지 않은 방법
	// 만들긴 했지만 거의 사용하지 않을 예정 - 관리자모드에서 사용
	public function get_path($me_code) {
		global $g5;

		$split = str_split($me_code,3);
		$code = $this->get_splited_code($split);

		if(is_array($code)) {
			for($i=0;$i<count($code);$i++) {
				$path = sql_fetch("select me_name from {$g5['eyoom_menu']} where me_code='{$code[$i]}'");
				$path_name[$i] = $path['me_name'];
			}
		}
		$path = implode(" &gt; ", $path_name);
		return $path;
	}

	// 메뉴 링크로 부터 메뉴속성 추출하기
	public function get_meinfo_link($url) {
		global $eb;

		if($url['query']) {
			parse_str($url['query'],$query);
			foreach($query as $key => $val) {
				// 잛은글 주소라면
				if($key == 't') {
					$link = $eb->short_url_data($val);
					$info['me_type'] = 'board';
					$info['me_pid'] = $link['bo_table'];
					$info['me_link'] = $url['path'].'board.php?bo_table='.$link['bo_table'].'&amp;wr_id='.$link['wr_id'];
					unset($link);
				} else {
					if(in_array($key,array('theme','shop_theme','bo_table','gr_id','co_id','ca_id','it_id','pid','faq','fm_id','sca','sfl','tag','po_id','ev_id'))) {
						switch($key) {
							case "theme"		: $info['me_type'] = 'theme'; break;
							case "shop_theme"	: $info['me_type'] = 'shop_theme'; break;
							case "bo_table"		: $info['me_type'] = 'board'; break;
							case "gr_id"		: $info['me_type'] = 'group'; break;
							case "co_id"		: $info['me_type'] = 'page'; break;
							case "ca_id"		: $info['me_type'] = 'shop'; break;
							case "it_id"		: $info['me_type'] = 'item'; break;
							case "pid"			: $info['me_type'] = 'pid'; break;
							case "faq"			: $info['me_type'] = 'faq'; break;
							case "fm_id"		: $info['me_type'] = 'faq'; break;
							case "qalist"		: $info['me_type'] = 'qalist'; break;
							case "sca"			: $info['me_type'] = 'board'; break;
							case "sfl"			: $info['me_type'] = 'search'; break;
							case "tag"			: $info['me_type'] = 'tag'; break;
							case "po_id"		: $info['me_type'] = 'poll'; break;
							case "ev_id"		: $info['me_type'] = 'event'; break;
						}
						$info['me_pid']  = $val;
						$info['me_link'] = $url['path']."?".$url['query'];
						$info['me_link'] .= $url['fragment']?'#'.$url['fragment']:'';
						$info['me_sca'] = $query['sca'];
					}
					if($key == 'bo_table') break;
				}
			}
		} else if($url['path']) {
			$info['me_pid'] = basename($url['path']);
			$info['me_type'] = 'userpage';
			$info['me_link'] = $url['path'];
			$info['me_link'] .= $url['fragment']?'#'.$url['fragment']:'';
			
		} else {
			$info['me_pid'] = 'intra';
			$info['me_type'] = 'userpage';
			$info['me_link'] = $url['path'];
			$info['me_link'] .= $url['fragment']?'#'.$url['fragment']:'';
		}
		if(is_array($info)) return $info;
	}

	// 메뉴링크 정보 가져오기
	public function get_menu_link($link) {
		$info = array();
		$url = $this->compare_host_from_link($link);
		if($url) {
			$info = $this->get_meinfo_link($url);
		} else {
			$info['me_pid'] = 'extra';
			$info['me_type'] = 'userpage';
			$info['me_link'] = $link;
			$info['me_sca'] = '';
		}
		if(is_array($info)) return $info;
	}

	// 입력한 링크가 해당 도메인인지 아닌지 검토
	public function compare_host_from_link($link) {
		$url = parse_url($link);
		if($url['host']) {
			$host = preg_replace("/www\./i","",$url['host']);
			$_host = preg_replace("/www\./i","",$_SERVER['HTTP_HOST']);
			if($host != $_host) return false;
		}
		return $url;
	}

	// 서브페이지의 title 및 Path 가져오기
	public function subpage_info($menu_array) {
		global $eyoom, $theme;
		if($eyoom['use_eyoom_menu'] == 'y') {
			$page_info = $this->eyoom_subpage_info($theme);
		} else {
			$page_info = $this->g5_subpage_info($menu_array);
		}
		return $page_info;
	}

	// 이윰메뉴 서브페이지 정보 가져오기
	private function eyoom_subpage_info($theme) {
		global $g5, $tpl, $it_id, $is_admin, $ca_id, $eyoom, $lang_theme, $sca, $board;
		$url = $this->compare_host_from_link($_SERVER['REQUEST_URI']);
		$info = $this->get_meinfo_link($url);
		
		$_sca = $this->get_sca_from_link($info['me_link']);
		if($_sca) {
			$where = " me_theme='{$theme}' and me_type='{$info['me_type']}' and me_pid='{$info['me_pid']}' and me_sca='{$_sca}' ";
		} else {
			if (!$board['bo_use_category']) {
				$where = " me_theme='{$theme}' and me_type='{$info['me_type']}' and me_pid='{$info['me_pid']}' ";
			} else {
				$where = " me_theme='{$theme}' and me_type='{$info['me_type']}' and me_pid='{$info['me_pid']}' and me_sca='' ";
			}
		}
		
		if($it_id) $where .= " and me_link='{$info['me_link']}' ";

		$sql = "select * from {$g5['eyoom_menu']} where $where order by me_code desc";
		$data = sql_fetch($sql,false);
		
		if ($_sca && !$data['me_id']) {
			$where = " me_theme='{$theme}' and me_type='{$info['me_type']}' and me_pid='{$info['me_pid']}' and me_sca='' ";
			
			if($it_id) $where .= " and me_link='{$info['me_link']}' ";
	
			$sql = "select * from {$g5['eyoom_menu']} where $where order by me_code desc";
			$data = sql_fetch($sql,false);
		}

		if($data['me_id']) {
			$me_path = explode(" > ",$data['me_path']);
			$cnt = count($me_path);
			foreach($me_path as $key => $me_name) {
				if($cnt-1 == $key) {
					$active = "class='active'";
				}
				$path .= "<li {$active}>".$me_name."</li>";
			}
			$page_info['title'] = $data['me_name'];
			$page_info['path'] = "<li><a href='".G5_URL."'>Home</a></li>".$path;
			$page_info['subtitle'] = $me_path[0];
			$page_info['sidemenu'] = $data['me_side'];
			$page_info['registed'] = 'y';
			// 메뉴코드 정보
			$me_code = str_split($data['me_code'],3);
			$page_info['cate1'] = $me_code[0];
			$page_info['cate2'] = $me_code[1];
		} else {
			if($it_id || $ca_id) $page_info = $this->shop_subpage_info();
			else $page_info = $this->get_default_page();
		}
		if(!$page_info['title']) {
			if($is_admin) {
				$page_info['title'] = $eyoom['theme_lang_type']=='m' ? $lang_theme[1181] : '미등록페이지';
				$page_info['path'] = "<a href='".EYOOM_ADMIN_URL."/?dir=theme&amp;pid=menu_list' style='color:#f30;'>관리자모드 > 테마관리 > 홈페이지메뉴설정</a> 에서 메뉴를 등록해 주세요.";
			} else {
				$page_info['title'] = $eyoom['theme_lang_type']=='m' ? $lang_theme[1181] : '미등록페이지';
				$page_info['path'] = '메뉴등록이 안된 페이지입니다.';
			}
		}
		return $page_info;
	}

	// 그누메뉴 서브페이지 정보 가져오기
	private function g5_subpage_info($menu_array) {
		global $g5, $bo_table, $co_id, $board, $co, $gr_id, $ca_id, $eyoom, $lang_theme;

		if($bo_table || $co_id) {
			$stx = $bo_table ? "bo_table=".$bo_table : "co_id=".$co_id;
			foreach($menu_array as $key => $menu) {
				if(is_array($menu['submenu'])) {
					foreach($menu['submenu'] as $k => $sub) {
						if(preg_match("/$stx/",$sub['me_link'])) {
							$submenu['cate1']['me_code'] = $menu['me_code'];
							$submenu['cate1']['link'] = $menu['me_link'];
							$submenu['cate1']['name'] = $menu['me_name'];
							$submenu['cate2'] = $sub;
							break;
						}
					}
				}
			}
			if($submenu) {
				$page_info['pr_code'] = $submenu['cate1']['me_code'];
				$page_info['subtitle'] = $submenu['cate1']['name'];
				$page_info['title'] = $submenu['cate2']['me_name'];
				$page_info['path'] = "<li><a href='".G5_URL."'>Home</a></li><li><a href='".$submenu['cate1']['link']."'>" . $submenu['cate1']['name'] . "</a></li><li class='active'>" . $submenu['cate2']['me_name']."</li>";
			}

			if(!$page_info) {
				if($bo_table) {
					$page_info['title'] = $board['bo_subject'];
					$page_info['path'] = "<li><a href='".G5_URL."'>Home</a></li><li class='active'>".$board['bo_subject']."</li>";
				} else if($co_id) {
					$page_info['title'] = $co['co_subject'];
					$page_info['path'] = "<li><a href='".G5_URL."'>Home</a></li><li class='active'>".$co['co_subject']."</li>";
				}
			}
		} else if($gr_id) {
			// Group 페이지 정보
			$sql = "select gr_subject from {$g5['group_table']} where gr_id='{$gr_id}'";
			$group = sql_fetch($sql, false);

			if($group['gr_subject']) {
				$page_info['title'] = $group['gr_subject'];
				$page_info['path'] = "<li><a href='".G5_URL."'>Home</a></li><li class='active'>".$group['gr_subject']."</li>";
			}

		} else {
			// 새글 / 1:1문의 / 내글반응 / 회원관련 페이지 등 정해진 페이지 정보
			if($it_id || $ca_id) $page_info = $this->shop_subpage_info();
			else $page_info = $this->get_default_page();
		}
		
		if(!$page_info['title']) {
			if($is_admin) {
				$page_info['title'] = $eyoom['theme_lang_type']=='m' ? $lang_theme[1181] : '미등록페이지';
				$page_info['path'] = "<a href='".EYOOM_ADMIN_URL."/?dir=theme&amp;pid=menu_list' style='color:#f30;'>관리자모드 > 테마관리 > 홈페이지메뉴설정</a> 에서 메뉴를 등록해 주세요.";
			} else {
				$page_info['title'] = $eyoom['theme_lang_type']=='m' ? $lang_theme[1181] : '미등록페이지';
				$page_info['path'] = '메뉴등록이 안된 페이지입니다.';
			}
		}
		return $page_info;
	}

	// 이미 존재하는 기능페이지 정보
	private function get_default_page() {
		global $is_member, $type, $eyoom, $lang_theme, $board;
		$temp_sname = explode('/',$_SERVER['SCRIPT_NAME']);
		list($key,$ext) = explode('.',$temp_sname[count($temp_sname)-1]);
		parse_str($_SERVER['QUERY_STRING'],$query);
		if($key == 'board' && $query['sfl'] && $query['stx']) $key = 'bo_search';

		switch($key) {
			case 'new'		: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[990] : '새글모음'; break;
			case 'respond'	: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[647] : '내글반응'; break;
			case 'search'	: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[675] : '전체검색'; break;
			case 'bo_search'	: 
				$title = $eyoom['theme_lang_type']=='m' ? $lang_theme[606] : '검색결과';
				$cate_name = $board['bo_subject'];
				break;
			case 'faq'		: $title = $eyoom['theme_lang_type']=='m' ? 'FAQ' : '자주하시는 질문'; break;
			case 'qalist'	:
			case 'qawrite'	:
			case 'qaview'	: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[619] : '1:1문의'; break;
			case 'current_connect'	: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[1085] : '현재접속자'; break;
			case 'register'	: $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[616] : '회원가입'; $title = $eyoom['theme_lang_type']=='m' ? 'Agreement' : '약관동의'; break;
			case 'register_form' : 
				if($is_member) {
					$cate_name = $eyoom['theme_lang_type']=='m' ? 'MemberShip' : '멤버쉽'; $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[614] : '정보수정';
				} else {
					$cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[616] : '회원가입'; $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[614] : '정보입력';
				}
				break;
			case 'register_result': $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[616] : '회원가입'; $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[616] : '회원가입완료'; break;
			case 'cart'		: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[609] : '장바구니'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
			case 'wishlist'	: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[610] : '위시리스트'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
			case 'orderform': $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[383] : '주문하기'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
			case 'orderinquiryview'	: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[1261] : '구매내역 상세보기'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
			case 'orderinquiry'	: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[1261] : '구매내역'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
			case 'listtype':
				switch($type) {
					case 1: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[404] : '히트상품'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
					case 2: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[406] : '추천상품'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
					case 3: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[409] : '최신상품'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
					case 4: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[411] : '인기상품'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
					case 5: $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[413] : '할인상품'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
				}
				break;
			case 'mypage': $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[618] : '마이페이지'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
			case 'personalpay':
			case 'personalpayform':
			case 'personalpayresult': $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[620] : '개인결제'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
			case 'itemqalist': $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[416] : '상품문의'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
			case 'itemuselist': $title = $eyoom['theme_lang_type']=='m' ? $lang_theme[415] : '사용후기'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
			case 'couponzone': $title = $eyoom['theme_lang_type']=='m' ? "Couponzone" : '쿠폰존'; $cate_name = $eyoom['theme_lang_type']=='m' ? $lang_theme[644] : '쇼핑몰'; break;
		}
		
		if(defined('_TAG_')) {
			// 태그 페이지
			if($_GET['tag']) {
				$tag = str_replace('^','&',get_text($_GET['tag']));
				$page_info['title'] = str_replace('*',' <span style="font-weight:normal;color:#aaa;">&gt;</span> ',$tag);
				$page_info['path'] = "<li><a href='".G5_URL."'>Home</a></li><li>태그</li><li>".str_replace('*','</li><li>',$tag)."</li>";
				$page_info['subtitle'] = '태그';
			} else {
				$page_info['title'] = '태그 크라우드';
				$page_info['path'] = "<li><a href='".G5_URL."'>Home</a></li><li>태그</li><li>".$page_info['title']."</li>";
				$page_info['subtitle'] = '태그';
			}
		} else if(!$cate_name) {
			$page_info['title'] = $title;
			$page_info['path'] = "<li><a href='".G5_URL."'>Home</a></li><li class='active'>".$title."</li>";
		} else {
			$page_info['title'] = $title;
			$page_info['path'] = "<li><a href='".G5_URL."'>Home</a></li><li>".$cate_name."</li><li class='active'>".$title."</li>";
			$page_info['subtitle'] = $cate_name;
		}
		return $page_info;
	}

	public function shop_subpage_info() {
		global $g5, $shop, $ca_id, $it_id;

		if($it_id) {
			$row = sql_fetch("select ca_id, ca_id2, ca_id3 from {$g5['g5_shop_item_table']} where it_id='{$it_id}' limit 1");
			if($row['ca_id3']) {
				$ca_id = $row['ca_id3'];
			} else if($row['ca_id2']) {
				$ca_id = $row['ca_id2'];
			} else if($row['ca_id1']) {
				$ca_id = $row['ca_id1'];
			}
			$cate1 = $shop->get_navi($row['ca_id1']);
		}
		$path = $shop->get_navi($ca_id);
		$pageinfo['title'] = $path['title'];
		$pageinfo['path'] = "<li><a href='".G5_URL."'>Home</a></li>".$path['path'];
		$pageinfo['subtitle'] = $cate1['title'];
		$page_info['registed'] = 'y';
		return $pageinfo;
	}

	// Pagenation 정보
	public function pg_pages($tpl_name, $url) {
		global $config;
		if($tpl_name == 'bs'){
			$pg_pages = $config['cf_write_pages'];
			if(G5_IS_MOBILE) $pg_pages = $config['cf_mobile_pages'];
		}
		switch($tpl_name) {
			case 'pc': $pg_pages = $config['cf_write_pages']; break;
			case 'mo': $pg_pages = $config['cf_mobile_pages']; break;
		}
		$pg['pages']= $pg_pages;
		$pg['url']	= $url;
		$pg['tpl']	= $tpl_name;
		return $pg;
	}
}