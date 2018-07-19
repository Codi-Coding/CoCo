<?php
if (!defined('_GNUBOARD_')) exit;

$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = 20;
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$bo_info = $eb->get_bo_subject(); // 게시판 정보 가져오기
$sql = "select * from {$g5['eyoom_new']} where 1 and wr_id = wr_parent and mb_id = '{$user['mb_id']}' order by bn_datetime desc limit {$from_record}, $page_rows ";

$result = sql_query($sql, false);

/**
 * 썸네일 가로사이즈
 */
$thumb_width = 500;

for ($i=0; $row=sql_fetch_array($result); $i++) {
	// 익명으로 작성한 글이면 표시하지 않음
	$level = $row['wr_1'] ? $eb->level_info($row['wr_1']):'';
    if($level['anonymous'] && $member['mb_id'] != $user['mb_id']) continue;

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
	} else {
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

$tpl->define(array(
	'myhome_myposts_pc' => 'skin_pc/mypage/' . $eyoom['mypage_skin'] . '/myhome_myposts.skin.html',
	'myhome_myposts_mo' => 'skin_mo/mypage/' . $eyoom['mypage_skin'] . '/myhome_myposts.skin.html',
	'myhome_myposts_bs' => 'skin_bs/mypage/' . $eyoom['mypage_skin'] . '/myhome_myposts.skin.html',
));