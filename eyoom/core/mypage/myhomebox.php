<?php
if (!defined('_GNUBOARD_')) exit;

if(!$page) {
	// 소셜정보 가져오기
	$friends = $_friends = $user['friends'] ? $eb->get_user_info($user['friends']):'';
	$following = $_following = $user['following'] ? $eb->get_user_info($user['following']):'';
	$follower = $_follower = $user['follower'] ? $eb->get_user_info($user['follower']):'';

	$box_friends = array_slice($_friends,0,12);
	$box_following = array_slice($_following,0,12);
	$box_follower = array_slice($_follower,0,12);
}

// 방명록 : 50개만 뿌리자
$fields = "a.mb_nick, a.mb_name, a.mb_email, a.mb_homepage, a.mb_tel, a.mb_hp, a.mb_point, a.mb_datetime, a.mb_signature, a.mb_profile, b.* ";
$sql = "select $fields from {$g5['member_table']} as a	left join {$g5['eyoom_guest']} as b on a.mb_id = b.mb_id where b.mb_id = '{$user['mb_id']}' order by b.gu_regdt desc limit 0,50";

$res = sql_query($sql, false);
for($i=0; $row=sql_fetch_array($res); $i++) {
	$guest[$i] = $row;
	$guest[$i]['datetime'] = $row['gu_regdt'];
	$guest[$i]['content'] = nl2br($row['content']);
	$guest[$i]['mb_photo'] = $eb->mb_photo($row['gu_id']);
}

$tpl->define(array(
	'myhomebox_pc' => 'skin_pc/mypage/' . $eyoom['mypage_skin'] . '/myhomebox.skin.html',
	'myhomebox_mo' => 'skin_mo/mypage/' . $eyoom['mypage_skin'] . '/myhomebox.skin.html',
	'myhomebox_bs' => 'skin_bs/mypage/' . $eyoom['mypage_skin'] . '/myhomebox.skin.html',
));

$tpl->assign(array(
	'guest'	=> $guest,
	'box_friends'	=> $box_friends,
	'box_following' => $box_following,
	'box_follower'	=> $box_follower,
));