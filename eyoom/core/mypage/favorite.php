<?php
if (!defined('_GNUBOARD_')) exit;

if (!$member['mb_id']) alert('회원만 접근하실 수 있습니다.',G5_URL);

// 관심게시판
$favorite = unserialize($eyoomer['favorite']);
$bo_info = $eb->get_bo_subject();

// 목록보기 권한이 있는 게시물만 리스트에 보이도록 처리
if (is_array($favorite)) {
	$i=0;
	foreach ($favorite as $fa_table) {
		if ($bo_info[$fa_table]['bo_list_level'] > $member['mb_level']) {
			continue;
		} else {
			$fa_bo_table[$i] = $fa_table;
			$i++;
		}
	}	
}

$where = '1';
switch($eyoomer['view_favorite']) {
    case '2': $where .= " and wr_id = wr_parent "; $anonymouse_key = 'wr_1'; break;
    case '3': $where .= " and wr_id <> wr_parent "; $anonymouse_key = 'mb_level'; break;
}

$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = 10;
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

if(is_array($fa_bo_table)) {
	/**
	 * 썸네일 가로사이즈
	 */
	$thumb_width = 500;
	
	$sql = "select * from {$g5['eyoom_new']} where $where and find_in_set(bo_table,'".implode(',',$fa_bo_table)."') order by bn_datetime desc limit $from_record, $page_rows";
	$result = sql_query($sql, false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = $row;
		$level = $row[$anonymouse_key] ? $eb->level_info($row[$anonymouse_key]):'';
		if(!$level['anonymous']) {
			$list[$i]['mb_photo'] = $eb->mb_photo($row['mb_id']);
			$list[$i]['gnu_level'] = $level['gnu_level'];
			$list[$i]['eyoom_level'] = $levelset['use_eyoom_level'] != 'n' ? $level['eyoom_level']: '';
			$list[$i]['lv_gnu_name'] = $level['gnu_name'];
			$list[$i]['lv_name'] = $level['name'];
			$list[$i]['gnu_icon'] = $level['gnu_icon'];
			$list[$i]['eyoom_icon'] = $levelset['use_eyoom_level'] != 'n' ? $level['eyoom_icon']: '';
		} else {
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

		$thumb = get_list_thumbnail($row['bo_table'], $row['wr_id'], $thumb_width, 0);
		if($thumb['src']) {
			$list[$i]['img_content'] = '<img class="img-responsive" src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
			$list[$i]['img_src'] = $thumb['src'];
		}
		
		$comment = &$list[$i]['comment'];

		if(preg_match("/secret/",$row['wr_option']) && !$is_admin && $row['mb_id']!=$member['mb_id']) {
			$list[$i]['wr_subject'] = "비밀글입니다.";
			$list[$i]['wr_content'] = "비밀글입니다.";
			$list[$i]['href'] = "#";
			$list[$i]['secret'] = true;
		} else {
			if($row['wr_video']) {
				$v_url = unserialize($row['wr_video']);
				$video = &$list[$i]['video'];
				foreach($v_url as $key => $video_url) {
					$video[$key] = $eb->video_content($video_url);
				}
			}

			if($row['wr_sound']) {
				$s_url = unserialize($row['wr_sound']);
				$sound = &$list[$i]['sound'];
				foreach($s_url as $key => $sound_url) {
					$sound[$key] = $eb->soundcloud_content($sound_url);
				}
			}

			// 댓글 추출
			@include EYOOM_CORE_PATH.'/mypage/view_comment.php';

			if($row['wr_id'] == $row['wr_parent']) {
				$list[$i]['href'] = G5_BBS_URL."/board.php?bo_table={$row['bo_table']}&amp;wr_id={$row['wr_id']}".$query_wmode;
			} else {
				$list[$i]['href'] = G5_BBS_URL."/board.php?bo_table={$row['bo_table']}&amp;wr_id={$row['wr_parent']}".$query_wmode."#c_{$row['wr_id']}";
			}
		}
		$list[$i]['datetime'] = $row['bn_datetime'];
		$list[$i]['bo_info'] = $bo_info[$row['bo_table']];
	}
}

$tpl->define(array(
	'favorite_pc' => 'skin_pc/mypage/' . $eyoom['mypage_skin'] . '/favorite.skin.html',
	'favorite_mo' => 'skin_mo/mypage/' . $eyoom['mypage_skin'] . '/favorite.skin.html',
	'favorite_bs' => 'skin_bs/mypage/' . $eyoom['mypage_skin'] . '/favorite.skin.html',
));