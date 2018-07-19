<?php
if (!defined('_GNUBOARD_')) exit;

if (!$member['mb_id']) alert('회원만 접근하실 수 있습니다.',G5_URL);

// 내글반응
$sql = "select * from {$g5['eyoom_respond']} where wr_mb_id = '{$eyoomer['mb_id']}' and re_chk = 0 order by regdt desc ";
$result = sql_query($sql, false);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$reinfo = $eb->respond_mention($row['re_type'],$row['mb_name'],$row['re_cnt']);

	// 당일인 경우 시간으로 표시함
	$list[$i]['rid'] = $row['rid'];
	$list[$i]['mb_name'] = $row['mb_name'];
	$list[$i]['mention'] = $reinfo['mention'];
	$list[$i]['wr_subject'] = $row['wr_subject'];
	$list[$i]['chk'] = $row['re_chk'];
	$list[$i]['type'] = $reinfo['type'];
	$list[$i]['href'] = G5_URL.'/bbs/respond_chk.php?rid='.$row['rid'];
	$list[$i]['delete'] = './respond_chk.php?rid='.$row['rid'].'&act=delete'.$get;
	$list[$i]['datetime'] = $row['regdt'];
	$list[$i]['mb_photo'] = $eb->mb_photo($row['mb_id']);
}
unset($i);

$tpl->define(array(
	'respond_pc' => 'skin_pc/mypage/' . $eyoom['mypage_skin'] . '/respond.skin.html',
	'respond_mo' => 'skin_mo/mypage/' . $eyoom['mypage_skin'] . '/respond.skin.html',
	'respond_bs' => 'skin_bs/mypage/' . $eyoom['mypage_skin'] . '/respond.skin.html',
));