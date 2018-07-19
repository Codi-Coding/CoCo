<?php
if (!defined('_GNUBOARD_')) exit;

if (!$member['mb_id']) alert('회원만 접근하실 수 있습니다.',G5_URL);

// 타임라인
$bo_info = $eb->get_bo_subject(); // 게시판 정보 가져오기
$where = '1';
switch($eyoomer['view_timeline']) {
	case '2': $where .= " and wr_id = wr_parent "; break;
	case '3': $where .= " and wr_id <> wr_parent "; break;
}

$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = 10;
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$sql = "select * from {$g5['eyoom_new']} where $where and mb_id = '{$eyoomer['mb_id']}' order by bn_datetime desc limit $from_record, $page_rows";
$result = sql_query($sql, false);

/**
 * 썸네일 가로사이즈
 */
$thumb_width = 500;

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;

	$thumb = get_list_thumbnail($row['bo_table'], $row['wr_id'], $thumb_width, 0);
	if($thumb['src']) {
		$list[$i]['img_content'] = '<img class="img-responsive" src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
		$list[$i]['img_src'] = $thumb['src'];
	}
	
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

	if($row['wr_id'] == $row['wr_parent']) {
		$list[$i]['href'] = G5_BBS_URL."/board.php?bo_table={$row['bo_table']}&amp;wr_id={$row['wr_id']}".$query_wmode;
	} else {
		$list[$i]['href'] = G5_BBS_URL."/board.php?bo_table={$row['bo_table']}&amp;wr_id={$row['wr_parent']}".$query_wmode."#c_{$row['wr_id']}";
	}
	$list[$i]['datetime'] = $row['bn_datetime'];
	$list[$i]['bo_info'] = $bo_info[$row['bo_table']];
}
$timeline = count($list);

$tpl->define(array(
	'timeline_pc' => 'skin_pc/mypage/' . $eyoom['mypage_skin'] . '/timeline.skin.html',
	'timeline_mo' => 'skin_mo/mypage/' . $eyoom['mypage_skin'] . '/timeline.skin.html',
	'timeline_bs' => 'skin_bs/mypage/' . $eyoom['mypage_skin'] . '/timeline.skin.html',
));