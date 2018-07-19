<?php
class latest extends eyoom
{
	public $bo_new		= 24;
	public $photo		= 'n';
	public $content		= 'n';
	public $img_view	= 'n';
	public $cols		= 3;
	public $img_width	= 500;
	public $img_height	= 0;
	public $skip_cnt	= 0;
	public $ca_view		= 'n';
	public $secret		= 'y';

	public function __construct() {
	}

	// 새글 새댓글 최신글 동시에 추출하기
	public function latest_newpost($skin, $option) {
		$list['write'] = $this->latest_write($skin, $option, false);
		$list['comment'] = $this->latest_comment($skin, $option, false);
		$this->latest_print($skin, $list, 'multiple', 'newpost');
	}

	// 히트수가 높은 순으로 게시물 추출
	public function latest_hot($skin, $option) {
		global $bo_table;
		$where = 1;
		$opt = $this->get_option($option);
		$where .= $opt['where'];
		$where .= " and wr_id = wr_parent";
		$where .= $bo_table ? " and bo_table = '{$bo_table}'":'';
		$orderby = " wr_hit desc ";
		$list = $this->latest_assign($where, $opt['count'], $opt['cut_subject'], $opt['cut_content'], $orderby);
		$this->latest_print($skin, $list, '', 'hotpost');
	}

	// 이윰 최신글 추출
	public function latest_eyoom($skin, $option, $print=true) {
		$where = 1;
		$opt = $this->get_option($option);
		$where .= $opt['where'];
		$where .= " and wr_id = wr_parent";
		$orderby = $opt['best']=='y'? " wr_hit desc ":"";
		$list = $this->latest_assign($where, $opt['count'], $opt['cut_subject'], $opt['cut_content'], $orderby, $opt['bo_direct']);
		if($print === null) $print = true;
		if($print) {
			$this->latest_print($skin, $list,'single','latest');
		} else {
			return $list;
		}
	}

	// 랜덤으로 게시물 추출
	public function latest_random($skin, $option) {
		$where = 1;
		$opt = $this->get_option($option.'||bo_direct=y');
		$where .= $opt['where'];
		$where .= " and wr_id = wr_parent";
		$orderby = " rand() ";
		$list = $this->latest_assign($where, $opt['count'], $opt['cut_subject'], $opt['cut_content'], $orderby, $opt['bo_direct']);
		if($print === null) $print = true;
		if($print) {
			$this->latest_print($skin, $list,'single','latest');
		} else {
			return $list;
		}
	}

	// 최신글 추출
	public function latest_write($skin, $option, $print=true) {
		$where = 1;
		$opt = $this->get_option($option);
		$where .= $opt['where'];
		$where .= " and wr_id = wr_parent";
		$list = $this->latest_assign($where, $opt['count'], $opt['cut_subject'], $opt['cut_content']);
		if($print === null) $print = true;
		if($print) {
			$this->latest_print($skin, $list);
		} else {
			return $list;
		}
	}

	// 최신 댓글 추출
	public function latest_comment($skin, $option, $print=true) {
		$where = 1;
		$opt = $this->get_option($option);
		$where .= $opt['where'];
		$where .= " and wr_id <> wr_parent";
		$list = $this->latest_assign($where, $opt['count'], $opt['cut_subject'], $opt['cut_content']);
		if($print === null) $print = true;
		if($print) {
			$this->latest_print($skin, $list);
		} else {
			return $list;
		}
	}

	// 옵션 값 분석
	protected function option_query($str) {
		if($str) {
			$tmp = explode("||", $str);
			if(is_array($tmp)) {
				foreach($tmp as $set) {
					list($key,$val) = explode("=",$set);
					$outvar[trim($key)] = trim($val);
				}
				return $outvar;
			}
		} else return false;
	}

	// 옵션셋으로 의미있는 정보로 변경하여 가져옴
	protected function get_option($option) {
		global $g5;
		if($option) {
			$optset = $this->option_query($option);
			$where  = $optset['where'] ? $this->latest_where($optset['where']):'';

			// 특정게시판만 가져오기
			if($optset['bo_table']) {
				$where .= $optset['bo_direct'] != 'y' ? " and bo_table = '{$optset['bo_table']}'":"";
				$this->bo_table = $optset['bo_table'];
			} else {
				// 제외 게시판
				if($optset['bo_exclude']) {
					$bo_exclude = explode(",", $optset['bo_exclude']);
					foreach($bo_exclude as $k => $v) {
						if(!$v) continue;
						$exclude[$k] = trim($v);
					}
					if($exclude) $where .= " and find_in_set(bo_table,'".implode(',',$exclude)."') = 0 ";
				}

				// 포함 게시판
				if($optset['bo_include']) {
					$bo_exclude = explode(",", $optset['bo_include']);
					foreach($bo_exclude as $k => $v) {
						if(!$v) continue;
						$include[$k] = trim($v);
					}
					if($include) $where .= " and find_in_set(bo_table,'".implode(',',$include)."') ";
				}

				// 그룹아이디(gr_id) 가 있을 경우
				if($optset['gr_id']) {
					$res = sql_query("select bo_table from {$g5['board_table']} where gr_id='{$optset['gr_id']}' order by bo_table ");
					for($i=0; $row=sql_fetch_array($res); $i++) {
						// bo_exclude 에 포함되어 있는 게시판이 있다면 제외
						if($exclude && @in_array($row['bo_table'], $exclude)) continue;
						$gr_board[$i] = $row['bo_table'];
					}
					if($gr_board) $where .= " and find_in_set(bo_table,'".implode(',',$gr_board)."') ";
				}
			}

			// 기간설정 period=20 오늘부터 20일전 데이타
			if($optset['period']) {
				$start = date("YmdHis", strtotime("-".$optset['period']." day"));
				$end = date("YmdHis");
				if($optset['bo_direct'] == 'y') $date_field = 'wr_datetime'; else $date_field = 'bn_datetime';
				$where .= " and {$date_field} between date_format(".$start.", '%Y-%m-%d 00:00:00') and date_format(".$end.", '%Y-%m-%d 23:59:59')";
			}

			// 비밀글 추출여부
			if($optset['secret'] == 'n') {
				$where .= " and wr_option not like '%secret%' ";
			}

			// 조건검색
			$opt['where'] = $where;

			// 최신글 헤더 타이틀 
			if($optset['title']) {
				if($optset['bo_table']) {
					$this->header_title = "<a href='".G5_BBS_URL."/board.php?bo_table=".$optset['bo_table']."'>".$optset['title']."</a>";
				} else if($optset['gr_id']) {
					$this->header_title = "<a href='".G5_BBS_URL."/group.php?gr_id=".$optset['gr_id']."'>".$optset['title']."</a>";
				} else {
					$this->header_title = $optset['title'];
				}
			}

			// 출력갯수
			if($optset['count']) $opt['count'] = $optset['count'];

			// 최신글 제목길이
			if($optset['cut_subject']) $opt['cut_subject'] = $optset['cut_subject'];

			// 최신글 출력내용 길이
			if($optset['cut_content']) $opt['cut_content'] = $optset['cut_content'];

			// 게시판에서 직접 가져오기
			if($optset['bo_direct']) $opt['bo_direct'] = $optset['bo_direct'];

			// 베스트글 여부
			if($optset['best']) $opt['best'] = $optset['best'];

			// 타입 [회원랭킹]
			if($optset['type']) $opt['type'] = $optset['type'];

			// 사용자 사진여부
			if($optset['photo']) $this->photo = $optset['photo'];

			// 컨텐츠 출력여부
			if($optset['content']) $this->content = $optset['content'];

			// 이미지 출력여부
			if($optset['img_view']) $this->img_view = $optset['img_view'];

			// 이미지 가로 이미지 수
			if($optset['cols']) $this->cols = $optset['cols'];

			// 이미지 가로사이즈
			if($optset['img_width']) $this->img_width = $optset['img_width'];

			// 이미지 세로사이즈
			if($optset['img_height']) $this->img_height = $optset['img_height'];

			// 최근 skip_cnt수 만큼 글을 스킵 후 다음 글부터 count수 만큼 추출
			if($optset['skip_cnt']) $this->skip_cnt = $optset['skip_cnt'];

			// 카테고리 분류명 표시
			if($optset['ca_view']) $this->ca_view = $optset['ca_view'];
			
			// 별점기능 표시
			if($optset['use_star']) $this->use_star = $optset['use_star'];

			return $opt;

		} else return false;
	}

	private function latest_where($expression) {
		$where = $expression;
		$where = preg_replace("/\s+/i","",$where);
		$where = preg_replace("/:/i","=",$where);
		$where = preg_replace("/&/i"," and ",$where);
		$where = preg_replace("/\|/i"," or ",$where);
		$where = preg_replace("/\"/i","'",$where);
		$where = " and " . $where;
		return $where;
	}

	// 최신글 정보 DB에서 가져오기
	protected function latest_assign($where, $cnt, $cut_subject=20, $cut_content=100, $orderby='', $direct='n') {
		global $g5, $eb, $is_admin, $member;

		// skip_cnt만큼 제외하기 위해
		$limit = $this->skip_cnt ? $cnt+$this->skip_cnt: $cnt;

		if($direct == 'n' || $direct == '') {
			if(!$orderby) $orderby = " bn_datetime desc ";
			$sql = "select * from {$g5['eyoom_new']} where $where order by $orderby limit $limit";
		} else if($direct == 'y') {
			if(!$orderby) $orderby = " wr_datetime desc ";
			$sql = "select * from ".$g5['write_prefix'].$this->bo_table." where $where order by $orderby limit $limit";
		}

		$result = sql_query($sql, false);
		for($i=0; $row = sql_fetch_array($result); $i++) {
			if($this->skip_cnt && $i<$this->skip_cnt) continue;
			$list[$i] = $row;
			$bo_table = $direct!='y' ? $row['bo_table']:$this->bo_table;
			$list[$i]['bo_table'] = $bo_table;
			if(!$row['wr_subject']) {
				if(preg_match('/secret/',$row['wr_option']) && (($is_member && !$is_admin && $member['mb_id']!=$row['mb_id']) || !$is_member)) {
					$list[$i]['wr_subject'] = '비밀 댓글입니다.';
					$list[$i]['wr_content'] = '비밀 댓글입니다.';
				} else {
					$list[$i]['wr_subject'] = cut_str(strip_tags(htmlspecialchars_decode($row['wr_content'])), $cut_content, '…');
				}
				$list[$i]['href'] = G5_BBS_URL."/board.php?bo_table={$bo_table}&amp;wr_id={$row['wr_id']}#c_{$row['wr_id']}";
			} else {
				if(preg_match('/secret/',$row['wr_option']) && (($is_member && !$is_admin && $member['mb_id']!=$row['mb_id']) || !$is_member)) {
					$list[$i]['wr_subject'] = '비밀글입니다.';
					$list[$i]['wr_content'] = '비밀글입니다.';
				} else {
					$list[$i]['wr_subject'] = conv_subject($row['wr_subject'], $cut_subject, '…');
					if($this->content == 'y') $list[$i]['wr_content'] = cut_str(strip_tags(htmlspecialchars_decode($row['wr_content'])), $cut_content, '…');

					// 옵션으로 이미지 가져오기
					if($this->img_view == 'y') {
						$list[$i]['image'] = $this->latest_image($row,$direct);
					}
				}
				$list[$i]['href'] = G5_BBS_URL."/board.php?bo_table={$bo_table}&amp;wr_id={$row['wr_parent']}";
			}
			if($this->ca_view == 'y' && $list[$i]['ca_name']) $list[$i]['wr_subject'] = '<span class="ca_name">'.$list[$i]['ca_name'].'</span> '. $list[$i]['wr_subject'];

			$list[$i]['wr_hit'] = $row['wr_hit'];
			if($direct == 'y') {
				$list[$i]['datetime'] = $row['wr_datetime'];
				$wr_1 = $row['wr_1'];
			} else {
				$list[$i]['datetime'] = $row['bn_datetime'];
				$wr_1 = $row['wr_1'] ? $row['wr_1']: $row['mb_level'];
			}

			// new 표시
			if ($list[$i]['datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($this->bo_new * 3600))) $list[$i]['new'] = true;

			// 레벨정보
			$level = $wr_1 ? $eb->level_info($wr_1):'';
			if(is_array($level)) {
				if(!$level['anonymous']) {
					$list[$i]['mb_photo'] = $eb->mb_photo($list[$i]['mb_id']);
					$list[$i]['mb_nick'] = $direct == 'y' ? $list[$i]['wr_name'] : $list[$i]['mb_nick'];
				} else {
					$list[$i]['mb_photo'] = '';
					$list[$i]['mb_id'] = 'anonymous';
					$list[$i]['mb_nick'] = '익명';
					$list[$i]['email'] = '';
					$list[$i]['homepage'] = '';
					$list[$i]['gnu_level'] = '';
					$list[$i]['gnu_icon'] = '';
					$list[$i]['eyoom_icon'] = '';
					$list[$i]['lv_gnu_name'] = '';
					$list[$i]['lv_name'] = '';
				}
			}
			
			// 블라인드 처리
			$wr_4 = unserialize($list[$i]['wr_4']);
			if(!$wr_4) $wr_4 = array();
			if($wr_4['yc_blind'] == 'y') {
				$list[$i]['wr_subject'] = '이 게시물은 블라인드 처리된 글입니다.';
				$list[$i]['wr_content'] = '이 게시물은 블라인드 처리된 글입니다.';
			}
			
			// 게시물에 동영상이 있는지 결정
			$list[$i]['is_video'] = $wr_4['is_video'];
			
			// 별점기능
			if($this->use_star == 'y') {
				$rating = $eb->get_star_rating($wr_4);
				$list[$i]['star'] = $rating['star'];
			}
			
			// 채택 게시판용
			$list[$i]['adopt_cmt_id'] = $wr_4['adopt_cmt_id'];
		}
		return $list;
	}

	public function latest_image($source,$direct='n') {
		global $g5, $eb;
		switch($direct) {
			case 'y':
				$thumb = get_list_thumbnail($this->bo_table, $source['wr_id'], $this->img_width, $this->img_height);
				if($thumb['src']) {
					$image = $thumb['src'];
				} else {
					$video = unserialize($source['wr_4']);
					if($video['thumb_src']) {
						$image = $video['thumb_src'];
					}
				}
				break;
			default :
				$images = unserialize($source['wr_image']);
				unset($g5_root);
				if(is_array($images)) {
					for($k=0;$k<count($images['bf']);$k++) {
						if(!$images['bf'][$k]) continue;
						else {
							$img = $images['bf'][$k];
							break;
						}
					}
					if(!$img) {
						for($j=0;$j<count($images['url']);$j++) {
							if(!$images['url'][$j]) continue;
							else {
								$img = $images['url'][$j];
								if(preg_match('/http/',$img)) {
									$extra_img = true;
								} else {
									$g5_root = G5_ROOT;
									if($g5_root != '/') {
										$img = str_replace(substr($g5_root,1),'',$img);
									}
								}
								break;
							}
						}
					}

					// 파일첨부 또는 에디터 이미지 처리
					if($img && !$extra_img) {
						$imgfile = G5_PATH.$img;
						if(@file_exists($imgfile)) {
							$img_path = explode('/',$img);
							for($i=0;$i<count($img_path)-1;$i++) {
								$path[$i] = $img_path[$i]; 
							}
							if(is_array($path)) {
								$filename = $img_path[count($img_path)-1];
								$filepath = G5_PATH.implode('/',$path);
								$tname = thumbnail($filename, $filepath, $filepath, $this->img_width, $this->img_height,'');
								$image = G5_URL.implode('/',$path).'/'.$tname;
							}
						}
					} else $image = $img; // 외부이미지는 썸네일화 기능을 지원하지 않습니다.
				} else {
					$video = unserialize($source['wr_4']);
					if($video['thumb_src']) {
						$image = $video['thumb_src'];
					}
				}
				break;
		}
		if($image) return $image;
	}

	// 스킨파일 위치에 출력하기
	protected function latest_print($skin, $arr, $mode='single', $folder='latest') {
		global $tpl, $tpl_name, $board;

		if(!$mode) $mode='single';
		if(!$folder) $folder='latest';

		$tpl->define_template($folder,$skin,'latest.skin.html');
		$tpl->assign(array(
			'bo_table' => $this->bo_table,
			'photo' => $this->photo,
			'content' => $this->content,
			'cols' => $this->cols,
			'title' => $this->header_title,
			'respond' => $this->respond,
			'use_star' => $this->use_star,
		));
		if($mode=='single') {
			$tpl->assign(array(
				'loop' => $arr,
			));
		} else if($mode='multiple') {
			$tpl->assign($arr);
		}
		$tpl->print_($tpl_name);
	}

	// 회원 랭킹 
	public function latest_ranking($skin, $option, $type='') {
		global $g5, $config, $tpl, $tpl_name, $eb;
		$where = 1;
		if(!$type) $opt = $this->get_option($option);
		else {
			$opt['count'] = $option;
			$opt['type'] = $type;
		}

		switch($opt['type']) {
			// 오늘의 포인트 랭킹
			case "today_point":
				$start = date("Ymd").'000000';
				$end = date("Ymd").'595959';
				
				$sql = "select mb_id, sum(po_point) as po_point from {$g5['point_table']} where po_point > 0 and mb_id <> '{$config['cf_admin']}' and (date_format(po_datetime, '%Y%m%d%H%i%s') between '{$start}' and '{$end}') group by mb_id order by sum(po_point) desc limit {$opt['count']}";
				$res = sql_query($sql, false);

				for($i=0; $row=sql_fetch_array($res); $i++) {
					$mbinfo = sql_fetch("select a.level, b.* from {$g5['eyoom_member']} as a left join {$g5['member_table']} as b on a.mb_id=b.mb_id where b.mb_id='{$row['mb_id']}'",false);
					$mbinfo['point'] = $row['po_point'];
					$list[$i] = $mbinfo;
					$level_info = $mbinfo['mb_level'].'|'.$mbinfo['level'];
					$level = $eb->level_info($level_info);
					$list[$i]['eyoom_icon'] = $level['eyoom_icon'];
					$list[$i]['grade_icon'] = $level['grade_icon'];
				}
				break;

			// 전체 포인트 랭키
			case "total_point":
				$result = sql_query("select a.level, b.* from {$g5['eyoom_member']} as a left join {$g5['member_table']} as b on a.mb_id=b.mb_id where b.mb_email_certify!='0000-00-00 00:00:00' and b.mb_level!='10' order by b.mb_point desc limit {$opt['count']}", false);
				for ($i=0; $row=sql_fetch_array($result); $i++) {
					$list[$i] = $row;
					$list[$i]['point'] = $row['mb_point'];
					$level_info = $row['mb_level'].'|'.$row['level'];
					$level = $eb->level_info($level_info);
					$list[$i]['eyoom_icon'] = $level['eyoom_icon'];
					$list[$i]['grade_icon'] = $level['grade_icon'];
				}
				break;

			// 레벨 랭킹
			case "level_point":
				$result = sql_query("select a.level,a.level_point,b.* from {$g5['eyoom_member']} as a left join {$g5['member_table']} as b on a.mb_id=b.mb_id where b.mb_email_certify!='0000-00-00 00:00:00' and b.mb_level!='10' order by a.level_point desc limit {$opt['count']}", false);
				for ($i=0; $row=sql_fetch_array($result); $i++) {
					$list[$i] = $row;
					$list[$i]['point'] = $row['level_point'];
					$level_info = $row['mb_level'].'|'.$row['level'];
					$level = $eb->level_info($level_info);
					$list[$i]['eyoom_icon'] = $level['eyoom_icon'];
					$list[$i]['grade_icon'] = $level['grade_icon'];
				}
				break;
		}
		if(!$type){
			$tpl->define_template("ranking",$skin,'ranking.skin.html');
			$tpl->assign('list',$list);
			$tpl->print_($tpl_name);
		} else {
			return $list;
		}
	}

	// 랭킹 SET
	public function latest_rankset($skin,$count) {
		global $tpl, $tpl_name;

		$list['rank_today'] = $this->latest_ranking($skin, $count, 'today_point');
		$list['rank_total'] = $this->latest_ranking($skin, $count, 'total_point');
		$list['rank_level'] = $this->latest_ranking($skin, $count, 'level_point');
		$list['levelset'] = $levelset;
		$tpl->define_template("ranking",$skin,'rankset.skin.html');
		$tpl->assign($list);
		$tpl->print_($tpl_name);
	}

	// 베스트 SET
	public function latest_bestset($skin,$option,$bo_table='') {
		global $tpl, $tpl_name;

		$opt = '';
		$optset = $this->option_query($option);
		$title = $optset['title'] ? $optset['title']:'';
		$_option['today'] = "best=y||period=1";
		$_option['week'] = "best=y||period=7";
		$_option['month'] = "best=y||period=30";

		$opt .= $optset['count'] ? "||count=".$optset['count']:"||count=10";
		$opt .= $optset['cut_subject'] ? "||cut_subject=".$optset['cut_subject']:"||cut_subject=30";
		if($bo_table) {
			$opt .= "||bo_table=".$bo_table;
		} else {
			$opt .= $optset['bo_include'] ? "||bo_include=".$optset['bo_include']:"";
			$opt .= $optset['bo_exclude'] ? "||bo_exclude=".$optset['bo_exclude']:"";
			$opt .= $optset['gr_id'] ? "||gr_id=".$optset['gr_id']:"";
		}
		$opt .= $optset['where'] ? "||where=".$optset['where']:"";

		$_option['today'] .= $opt;
		$_option['week'] .= $opt;
		$_option['month'] .= $opt;

		$list['today'] = $this->latest_eyoom($skin, $_option['today'], false);
		$list['week'] = $this->latest_eyoom($skin, $_option['week'], false);
		$list['month'] = $this->latest_eyoom($skin, $_option['month'], false);
		$tpl->define_template("best",$skin,'bestset.skin.html');
		$tpl->assign($list);
		$tpl->assign(array(
			'title' => $title,
			'bo_table' => $bo_table,
		));
		$tpl->print_($tpl_name);
	}

	public function latest_good($skin,$option,$bo_table='') {
		$where = 1;
		$opt = $this->get_option($option);
		$where .= $opt['where'];
		$where .= " and wr_id = wr_parent and wr_good != 0 ";
		$orderby = " wr_good desc, bn_datetime desc ";
		$list = $this->latest_assign($where, $opt['count'], $opt['cut_subject'], $opt['cut_content'], $orderby, $opt['bo_direct']);
		if($print === null) $print = true;
		if($print) {
			$this->latest_print($skin, $list,'single','latest');
		} else {
			return $list;
		}
	}

	// 쇼핑몰 상품 추출하기
	public function latest_item($skin, $option) {
		global $g5, $config, $tpl, $tpl_name, $eb;
		$where = 1;
		$opt = $this->get_item_option($option);

		$where .= $opt['where'];
		$where .= " and it_soldout = '0'";
		$where .= $opt['type'] ? " and it_type".$opt['type']." = '1'":'';
		if($opt['ca_id']) {
			$length = strlen($opt['ca_id']);
			switch($length) {
				case 2: $where .= " and ca_id = '{$opt['ca_id']}' "; break;
				case 4: $where .= " and ca_id2 = '{$opt['ca_id']}' "; break;
				case 6: $where .= " and ca_id3 = '{$opt['ca_id']}' "; break;
			}
		}
		
		$orderby = " it_time desc ";
		$list = $this->latest_item_assign($where, $opt['count'], $opt['cut_name'], $orderby, $opt['width']);
		$this->latest_print($skin, $list, 'single', 'latest');
	}

	// 상품 추출 옵션
	private function get_item_option($option) {
		global $g5;
		if($option) {
			$optset = $this->option_query($option);
			$where  = $optset['where'] ? $this->latest_where($optset['where']):'';

			// 기간설정 period=20 오늘부터 20일전 데이타
			if($optset['period']) {
				$start = date("YmdHis", strtotime("-".$optset['period']." day"));
				$end = date("YmdHis");
				$where .= " and it_update_time between date_format(".$start.", '%Y-%m-%d 00:00:00') and date_format(".$end.", '%Y-%m-%d 23:59:59')";
			}

			// 조건검색
			$opt['where'] = $where;
		
			// 최신글 헤더 타이틀 
			if($optset['title']) {
				$this->header_title = $optset['title'];
			}
		
			if($optset['it_id']) {
				$opt['it_id'] = $optset['it_id'];
			}
		
			// 출력갯수
			if($optset['count']) $opt['count'] = $optset['count'];
		
			// 최신글 제목길이
			if($optset['cut_name']) $opt['cut_name'] = $optset['cut_name'];
			
			// 상품이미지 가로
			if($optset['width']) $opt['width'] = $optset['width'];
		
			// 타입
			if($optset['type']) $opt['type'] = $optset['type'];

			return $opt;

		} else return false;
	}

	private function latest_item_assign($where, $cnt=5, $cut_name=100, $orderby='', $width=120) {
		global $g5, $eb;

		if(!$orderby) $orderby = " it_time desc ";
		$sql = "select * from {$g5['g5_shop_item_table']} where $where order by $orderby limit $cnt";

		$result = sql_query($sql, false);
		for($i=0; $row = sql_fetch_array($result); $i++) {
			$list[$i] = $row;

			$list[$i]['it_name'] = conv_subject($row['it_name'], $cut_name, '…');
			$list[$i]['href'] = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";
			$list[$i]['datetime'] = $row['it_time'];
			$list[$i]['img'] = get_it_image($row['it_id'], $width, 0, true);
			$list[$i]['star_score'] = get_star_image($row['it_id']);
		}
		return $list;
	}
	
	// 내글반응 최근반응 추출
	public function latest_respond($skin, $option) {
		global $g5, $member, $is_member;

		if(!$is_member) return false;
		$where = 1;
		$opt = $this->get_misc_option($option);

		$where .= $opt['where'];
		$where .= " and wr_mb_id='{$member['mb_id']}' ";

		$orderby = " regdt desc ";
		$list = $this->latest_respond_assign($where, $opt['count'], $opt['cut_subject'], $orderby);
		$this->latest_print($skin, $list, 'single', 'latest');
	}

	private function get_misc_option($option) {
		global $g5;
		if($option) {
			$optset = $this->option_query($option);
			$where  = $optset['where'] ? $this->latest_where($optset['where']):'';

			if($optset['period']) {
				$start = date("YmdHis", strtotime("-".$optset['period']." day"));
				$end = date("YmdHis");
				$where .= " and regdt between date_format(".$start.", '%Y-%m-%d 00:00:00') and date_format(".$end.", '%Y-%m-%d 23:59:59')";
			}

			// 조건검색
			$opt['where'] = $where;
		
			// 최신글 헤더 타이틀 
			if($optset['title']) {
				$this->header_title = $optset['title'];
			}

			// 출력갯수
			if($optset['count']) $opt['count'] = $optset['count'];

			// 최신글 제목길이
			if($optset['cut_subject']) $opt['cut_subject'] = $optset['cut_subject'];

			// 사용자 사진여부
			if($optset['photo']) $this->photo = $optset['photo'];

			return $opt;

		} else return false;
	}

	private function latest_respond_assign($where, $max=5, $cut_subject=20, $orderby='') {
		global $g5, $eb;

		if(!$orderby) $orderby = " regdt desc ";
		$count = sql_fetch("select count(*) as cnt from {$g5['eyoom_respond']} where $where and re_chk = 0");
		$this->respond = $count['cnt'] ? $count['cnt'] : 0;

		$sql = "select * from {$g5['eyoom_respond']} where $where order by $orderby limit $max";
		$result = sql_query($sql, false);
		for($i=0; $row = sql_fetch_array($result); $i++) {
			$reinfo = $eb->respond_mention($row['re_type'],$row['mb_name'],$row['re_cnt']);

			// 당일인 경우 시간으로 표시함
			$list[$i]['mb_name'] = $row['mb_name'];
			$list[$i]['mention'] = $reinfo['mention'];
			$list[$i]['wr_subject'] = conv_subject($row['wr_subject'], $cut_subject, '…');
			$list[$i]['type'] = $reinfo['type'];
			$list[$i]['href'] = G5_BBS_URL.'/respond_chk.php?rid='.$row['rid'];
			$list[$i]['datetime'] = $row['regdt'];
			$list[$i]['mb_photo'] = $eb->mb_photo($row['mb_id']);
			$list[$i]['is_read'] = $row['re_chk']=='0' ? false:true;
		}
		return $list;
	}

	// 읽지않은 메모 가져오기
	public function latest_memo($skin, $option) {
		global $g5, $member, $is_member;

		if(!$is_member) return false;
		$where = 1;
		$opt = $this->get_misc_option($option);

		$where .= $opt['where'];
		$where .= " and a.me_recv_mb_id = '{$member['mb_id']}' ";

		$orderby = " a.me_id desc ";
		$list = $this->latest_memo_assign($where, $opt['count'], $opt['cut_subject'], $orderby);
		$this->latest_print($skin, $list, 'single', 'latest');
	}

	private function latest_memo_assign($where, $max=5, $cut_subject=20, $orderby='') {
		global $g5, $member, $eb;

		if(!$orderby) $orderby = " a.me_id desc ";
		$sql = "select a.*, b.mb_id, b.mb_nick from {$g5['memo_table']} as a left join {$g5['member_table']} as b on (a.me_send_mb_id = b.mb_id) where $where order by $orderby limit $max";
		$result = sql_query($sql, false);
		for($i=0; $row = sql_fetch_array($result); $i++) {
			$list[$i] = $row;

			$list[$i]['mb_name'] = $row['mb_nick'];
			$list[$i]['datetime'] = $row['me_send_datetime'];
			$list[$i]['href']	= G5_BBS_URL.'/memo_view.php?me_id='.$row['me_id'].'&amp;kind=recv';
			$list[$i]['memo'] = conv_subject($row['me_memo'], $cut_subject, '…');
			$list[$i]['mb_photo'] = $eb->mb_photo($row['mb_id']);
			$list[$i]['is_read'] = $row['me_read_datetime']=='0000-00-00 00:00:00' ? false:true;
		}
		return $list;
	}

	// 최근 접속자 추출하기
	public function latest_connect($skin) {
		global $g5, $eb, $config;

		$sql = "
			select a.mb_id, b.mb_nick, b.mb_name, b.mb_email, b.mb_homepage, b.mb_open, b.mb_point, a.lo_ip, a.lo_location, a.lo_url
			from {$g5['login_table']} a left join {$g5['member_table']} b on (a.mb_id = b.mb_id)
			where a.mb_id <> '{$config['cf_admin']}'
			order by a.lo_datetime desc 
		";
		$result = sql_query($sql);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row;

			if ($row['mb_id']) {
				$list[$i]['name'] = cut_str($row['mb_nick'], $config['cf_cut_name']);
				$list[$i]['mb_photo'] = $eb->mb_photo($row['mb_id']);
			} else {
				if ($is_admin)
					$list[$i]['name'] = $row['lo_ip'];
				else
					$list[$i]['name'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['lo_ip']);
			}
			$list[$i]['num'] = sprintf('%03d',$i+1);
		}
		$this->latest_print($skin, $list, 'single', 'latest');
	}

	// 최근 출석체크 내용 추출하기
	public function latest_attendance($skin, $option) {
		global $g5, $eb;

		$opt = $this->get_option($option);

		// 오늘의 1등
		$atd['today'] = sql_fetch("select atd_mb_id, atd_wr_name from {$g5['eyoom_attendance']} where atd_datetime like '".date('Y-m-d')."%' order by ranking asc limit 1", false);

		// 개근 1등 
		$atd['going'] = sql_fetch("select max(atd_count) as count, atd_mb_id, atd_wr_name, atd_datetime, sum(ranking) as rank from {$g5['eyoom_attendance']} where (1) group by atd_mb_id order by count desc, rank asc limit 1", false);

		// 1등 횟수
		$atd['first'] = sql_fetch("select count(*) as count, atd_mb_id, atd_wr_name, sum(ranking) as rank from {$g5['eyoom_attendance']} where ranking=1 group by atd_mb_id order by count desc, rank asc limit 1", false);

		$i=0;
		foreach($atd as $key => $row) {
			$list[$i] = $row;
			$list[$i]['key'] = $key;
			$list[$i]['mb_photo'] = $eb->mb_photo($row['atd_mb_id']);
			$i++;
		}
		$this->latest_print($skin, $list, 'single', 'latest');
	}
}