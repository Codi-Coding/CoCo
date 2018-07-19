<?php
if (!defined('_GNUBOARD_')) exit;

// 게시판 이윰설정 링크생성
$eyoom_href = $extend_href = "";
// 최고관리자 또는 그룹관리자라면
if ($member['mb_id'] && ($is_admin == 'super' || $group['gr_admin'] == $member['mb_id'])) {
	// 게시판 이윰설정 링크
	$eyoom_href = EYOOM_ADMIN_URL.'/?dir=theme&amp;pid=board_form&amp;bo_table='.$bo_table.'&thema='.$theme;
	
	// 확장필드 링크
	$extend_href = EYOOM_ADMIN_URL.'/?dir=board&amp;pid=board_extend&amp;bo_table='.$bo_table.'&thema='.$theme;
}

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
if ($eyoom_board['bo_use_profile_photo']) $colspan++;
if ($eyoom_board['bo_use_rating']) $colspan++;

// 갤러리 스킨의 경우, 가로 이미지 갯수 자동처리
if ($bo_gallery_cols && 12%$bo_gallery_cols == 0) {
	$cols = 12/$bo_gallery_cols;
} else {
	$cols = 4;
}

// 제목에서 구분자로 회원정보 추출
foreach($list as $key => $val) {
	$level = $list[$key]['wr_1'] ? $eb->level_info($list[$key]['wr_1']):'';
	if(is_array($level)) {
		if(!$level['anonymous']) {
			$list[$key]['mb_photo'] = $eb->mb_photo($list[$key]['mb_id']);
			$list[$key]['gnu_level'] = $level['gnu_level'];
			$list[$key]['eyoom_level'] = $levelset['use_eyoom_level'] != 'n' ? $level['eyoom_level']: '';
			$list[$key]['lv_gnu_name'] = $level['gnu_name'];
			$list[$key]['lv_name'] = $level['name'];
			$list[$key]['gnu_icon'] = $level['gnu_icon'];
			$list[$key]['eyoom_icon'] = $levelset['use_eyoom_level'] != 'n' ? $level['eyoom_icon']: '';
		} else {
			$list[$key]['mb_id'] = 'anonymous';
			$list[$key]['wr_name'] = '익명';
			$list[$key]['email'] = '';
			$list[$key]['homepage'] = '';
			$list[$key]['gnu_level'] = '';
			$list[$key]['gnu_icon'] = '';
			$list[$key]['eyoom_icon'] = '';
			$list[$key]['lv_gnu_name'] = '';
			$list[$key]['lv_name'] = '';
		}
	}
	
	/**
	 * 갤러리 게시판의 경우, 목록에서 이미지를 반드시 사용으로 체크해야만 이미지가 출력되도록 기능 개선
	 * 일반 게시판의 경우, 사용하지 않도록 체크하면 속도향상이 기대됨
	 */
	if($eyoom_board['bo_use_list_image']) {
		$thumb = get_list_thumbnail($board['bo_table'], $list[$key]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);
		if($tpl_name == 'bs') {
			if($thumb['src']) {
				$list[$key]['img_content'] = '<img class="img-responsive" src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
				$list[$key]['img_src'] = $thumb['src'];
			} else {
				$list[$key]['img_content'] = '<span style="width:100%;">no image</span>';
			}
		} else {
			if($thumb['src']) {
				$list[$key]['img_content'] = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
				$list[$key]['img_src'] = $thumb['src'];
			} else {
				$list[$key]['img_content'] = '<span style="width:'.$board['bo_gallery_width'].'px;height:'.$board['bo_gallery_height'].'px">no image</span>';
			}
		}
	}
	
	// wr_4 여유필드 unserialize
	$wr_4 = unserialize($list[$key]['wr_4']);
	if(!$wr_4) $wr_4 = array();
	
	/**
	 * 목록에서 동영상이미지 사용을 체크했을 경우
	 * 속도에 영향을 미치지 않도록 썸네일 정보가 이미 있다면 실행하지 않도록 처리
	 */
	if($eyoom_board['bo_use_video_photo'] == '1') {
		/**
		 * 동영상으로 부터 이미지 추출하는 부분
		 * 동영상 경로는 wr_4 필드를 활용하기 
		 */
		if($list[$key]['wr_4'] && !$thumb['src']) {
			$thumb['src'] = $wr_4['thumb_src'];
			if($thumb['src']) {
				if($tpl_name == 'bs') {
					if($thumb['src']) {
						$list[$key]['img_content'] = '<img class="img-responsive" src="'.$thumb['src'].'">';
						$list[$key]['img_src'] = $thumb['src'];
					} else {
						$list[$key]['img_content'] = '<span style="width:100%;">no image</span>';
					}
				} else {
					if($thumb['src']) {
						$list[$key]['img_content'] = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
						$list[$key]['img_src'] = $thumb['src'];
					} else {
						$list[$key]['img_content'] = '<span style="width:'.$board['bo_gallery_width'].'px;height:'.$board['bo_gallery_height'].'px">no image</span>';
					}
				}
			}
		}
		// 게시물에 동영상이 있는지 결정
		$list[$key]['is_video'] = $wr_4['is_video'];
	}
	
	// 외부이미지 썸네일화 하기
	if ($eyoom_board['bo_use_list_image'] && $eyoom_board['bo_use_extimg'] && !$thumb['src']) {
		$thumb = $eb->make_thumb_from_extra_image($board['bo_table'], $list[$key]['wr_id'], $list[$key]['wr_content'], $board['bo_gallery_width'], $board['bo_gallery_height']);
		if($tpl_name == 'bs') {
			if($thumb) {
				$list[$key]['img_content'] = '<img class="img-responsive" src="'.$thumb.'">';
				$list[$key]['img_src'] = $thumb;
			}
		} else {
			if($thumb['src']) {
				$list[$key]['img_content'] = '<img src="'.$thumb.'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
				$list[$key]['img_src'] = $thumb;
			}
		}
	}
	
	/**
	 * 별점기능 사용
	 */
	if($eyoom_board['bo_use_rating'] == '1' && $eyoom_board['bo_use_rating_list'] == '1') {
		$rating = $eb->get_star_rating($wr_4);
		$list[$key]['star'] = $rating['star'];
	}
	
	/**
	 * 채택 게시판용
	 */
	if (preg_match('/adopt/i',$eyoom_board['bo_skin'])) {
		$list[$key]['adopt_cmt_id'] = $wr_4['adopt_cmt_id'];
		$list[$key]['adopt_point'] = $wr_4['adopt_point'];
	}
	
	/**
	 * 목록에서 내용 사용
	 */
	if($board['bo_use_list_content']) {
		$content_length = G5_IS_MOBILE ? 100:150;
		$wr_content = strip_tags($list[$key]['wr_content']);
		if($eyoom_board['bo_use_addon_coding'] == '1') {
			$wr_content = $eb->remove_editor_code($wr_content);
		}
		if($eyoom_board['bo_use_addon_emoticon'] == '1') {
			$wr_content = $eb->remove_editor_emoticon($wr_content);
		}
		if($eyoom_board['bo_use_addon_video'] == '1') {
			$wr_content = $eb->remove_editor_video($wr_content);
		}
		if($eyoom_board['bo_use_addon_soundcloud'] == '1') {
			$wr_content = $eb->remove_editor_sound($wr_content);
		}
		$list[$key]['content'] = cut_str(trim(strip_tags(preg_replace("/\?/","",$wr_content))),$content_length, '…');
	}
	
	// 게시물 view페이지의 wmode(Window Mode) 설정
	if($_wmode) {
		$list[$key]['href'] = $list[$key]['href'].'&wmode=1';
	}
	
	/**
	 * 게시물 블라인드 처리 
	 */
	if(isset($wr_4['yc_blind']) && $wr_4['yc_blind'] == 'y') {
		$yc_data = sql_fetch("select mb_id from {$g5['eyoom_yellowcard']} where bo_table = '{$bo_table}' and wr_id = '{$list[$key]['wr_id']}' and mb_id = '{$member['mb_id']}' ");
		if(!$is_admin && $member['mb_level'] < $eyoom_board['bo_blind_view'] && !$yc_data['mb_id']) $list[$key]['href'] = 'javascript:;';
		$list[$key]['subject'] = '이 게시물은 블라인드 처리된 글입니다.';
		$list[$key]['content'] = '이 게시물은 블라인드 처리된 글입니다.';
	}
	
	/**
	 * 비밀글과 블라인드 처리된 게시물의 이미지 처리
	 */
	if (strstr($list[$key]['wr_option'], 'secret') || $wr_4['yc_blind'] == 'y') {
		$list[$key]['img_content'] = '';
		$list[$key]['img_src'] = '';
	}
	
	/**
	 * 확장필드
	 */
	if ($bo_extend) {
		foreach ($exbo as $ex_fname => $exinfo) {
			unset($ex_value);
			
			switch ($exinfo['ex_form']) {
				case 'text':
				case 'radio':
				case 'select':
				    $list[$key][$ex_fname] = $list[$key][$ex_fname];
					break;
				case 'checkbox':
					$ex_value = explode('^|^', $list[$key][$ex_fname]);
					$list[$key][$ex_fname] = is_array($ex_value) ? implode(', ', $ex_value): $ex_value;
					break;
				case 'address':
					$ex_value = explode('^|^', $list[$key][$ex_fname]);
					unset($ex_value[4]);
					$list[$key][$ex_fname] = is_array($ex_value) ? implode(' ', $ex_value): $ex_value;
					break;
				case 'textarea':
					$list[$key][$ex_fname] = conv_content($list[$key][$ex_fname], $html);
					break;
			}
		}
	}
}

// 카테고리
if ($board['bo_use_category']) {
	// 카테고리별 게시글수 출력 표시 - 비즈팔님이 아이디어를 제공해 주셨습니다.
	$res = sql_query("select distinct ca_name, count(*) as cnt from {$write_table} where wr_id = wr_parent group by ca_name",false);
	$ca_total=0;
	for($i=0;$row=sql_fetch_array($res);$i++) {
		$ca_name = $row['ca_name'] ? $row['ca_name'] : '미분류';
		$ca_count[$ca_name] = $row['cnt'];
		$ca_total += $row['cnt'];
	}

	// 카테고리 정보 재구성
	foreach($categories as $key => $val) {
		$bocate[$key]['ca_name'] = trim($val);
		$bocate[$key]['ca_sca'] = urlencode($bocate[$key]['ca_name']);
		$bocate[$key]['ca_count'] = number_format($ca_count[$val]);
	}
	$decode_sca =urldecode($sca);
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./board.php?bo_table=".$bo_table.$qstr."&amp;page=");

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/list.skin.php');

// Template define
$tpl->define_template('board',$eyoom_board['bo_skin'],'list.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);