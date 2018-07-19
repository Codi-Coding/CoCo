<?php
if (!defined('_GNUBOARD_')) exit;

// 방명록
$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = 5;
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$fields = "a.mb_nick, a.mb_name, a.mb_email, a.mb_homepage, a.mb_tel, a.mb_hp, a.mb_point, a.mb_datetime, a.mb_signature, a.mb_profile, b.* ";
$sql = "select $fields from {$g5['member_table']} as a	left join {$g5['eyoom_guest']} as b on a.mb_id = b.mb_id where b.mb_id = '{$user['mb_id']}' order by b.gu_regdt desc limit $from_record, $page_rows";

$res = sql_query($sql, false);
for($i=0; $row=sql_fetch_array($res); $i++) {
	$list[$i] = $row;
	$list[$i]['datetime'] = $row['gu_regdt'];
	$list[$i]['content'] = nl2br($row['content']);
	$list[$i]['mb_photo'] = $eb->mb_photo($row['gu_id']);
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/mypage/myhome_guest.skin.php');

$tpl->define(array(
	'myhome_guest_pc' => 'skin_pc/mypage/' . $eyoom['mypage_skin'] . '/myhome_guest.skin.html',
	'myhome_guest_mo' => 'skin_mo/mypage/' . $eyoom['mypage_skin'] . '/myhome_guest.skin.html',
	'myhome_guest_bs' => 'skin_bs/mypage/' . $eyoom['mypage_skin'] . '/myhome_guest.skin.html',
));