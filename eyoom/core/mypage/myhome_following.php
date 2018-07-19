<?php
if (!defined('_GNUBOARD_')) exit;

$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = 10;
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

// 팔로워
if($user['cnt_following'] > 0) {
	$following = array_slice($eb->get_user_info($user['following']),$from_record,$page_rows);
}
if(!$eyoomer['following']) $eyoomer['following'] = array();

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/mypage/myhome_following.skin.php');

$tpl->define(array(
	'myhome_following_pc' => 'skin_pc/mypage/' . $eyoom['mypage_skin'] . '/myhome_following.skin.html',
	'myhome_following_mo' => 'skin_mo/mypage/' . $eyoom['mypage_skin'] . '/myhome_following.skin.html',
	'myhome_following_bs' => 'skin_bs/mypage/' . $eyoom['mypage_skin'] . '/myhome_following.skin.html',
));