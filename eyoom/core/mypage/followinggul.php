<?php
if (!defined('_GNUBOARD_')) exit;

if (!$member['mb_id']) alert('회원만 접근하실 수 있습니다.',G5_URL);

// 팔로윙글
$bo_info = $eb->get_bo_subject();
$where = '1';
switch($eyoomer['view_followinggul']) {
    case '2': $where .= " and wr_id = wr_parent "; $anonymouse_key = 'wr_1'; break;
    case '3': $where .= " and wr_id <> wr_parent "; $anonymouse_key = 'mb_level'; break;
}

$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = 10;
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

if($eyoomer['cnt_following']) {
	/**
	 * 썸네일 가로사이즈
	 */
	$thumb_width = 500;
	
	$sql = "select * from {$g5['eyoom_new']} where $where and find_in_set(mb_id,'".implode(',',$eyoomer['following'])."') order by bn_datetime desc limit $from_record, $page_rows";
	$result = sql_query($sql, false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		// 익명으로 작성한 글이면 표시하지 않음
        $level = $row[$anonymouse_key] ? $eb->level_info($row[$anonymouse_key]):'';
        if($level['anonymous']) continue;

		$list[$i] = $row;
		$list[$i]['mb_photo'] = $eb->mb_photo($row['mb_id']);
		
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
	'following_pc' => 'skin_pc/mypage/' . $eyoom['mypage_skin'] . '/followinggul.skin.html',
	'following_mo' => 'skin_mo/mypage/' . $eyoom['mypage_skin'] . '/followinggul.skin.html',
	'following_bs' => 'skin_bs/mypage/' . $eyoom['mypage_skin'] . '/followinggul.skin.html',
));