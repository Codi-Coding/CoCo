<?php
if (!defined('_GNUBOARD_')) exit;

$nick = get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']);
if($kind == "recv") {
	$kind_str = "보낸";
	$kind_date = "받은";
}
else {
	$kind_str = "받는";
	$kind_date = "보낸";
}

// 푸쉬 알람 파일 삭제
$push_file = G5_DATA_PATH.'/member/push/push.'.$member['mb_id'].'.php';

// 푸쉬파일 삭제
if(@file_exists($push_file)) {
	@unlink($push_file);
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/memo_view.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'memo_view.skin.html');

$tpl->assign('mb',$mb);

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);