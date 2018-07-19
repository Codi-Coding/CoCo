<?php
if (!defined('_GNUBOARD_')) exit;

@include EYOOM_PATH.'/common.php';

if (!$member['mb_id']) alert('회원만 접근하실 수 있습니다.');

// 마이박스
@include_once(EYOOM_CORE_PATH.'/mypage/mybox.php');

$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = 20;
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

// 팔로잉
if($eyoomer['cnt_following'] > 0) {
	$following = array_slice($eb->get_user_info($eyoomer['following']),$from_record,$page_rows);
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/mypage/myfollowing.skin.php');

$tpl->assign(array(
	'following' => $following,
));
$tpl->define_template('mypage',$eyoom['mypage_skin'],'following.skin.html');
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);