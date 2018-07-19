<?php
include_once('./_common.php');

if (!$member['mb_id']) alert('회원만 접근하실 수 있습니다.');

$g5['title'] = '나의 환경설정 저장';
if(!$eyoomer['mb_id']) alert('잘못된 접근입니다.');

$set = '';
$set_array = array(
	'main_index',
	'mypage_main',
	'open_page',
	'onoff_social',
	'onoff_push',
	'open_email',
	'open_homepage',
	'open_tel',
	'open_hp',
	'onoff_push_respond',
	'onoff_push_memo',
	'onoff_push_social',
	'onoff_push_likes',
	'onoff_push_guest',
	'favorite',
	'view_timeline',
	'view_favorite',
	'view_followinggul'
);
foreach($set_array as $k => $field) {
	$postval = $field == 'favorite' ? serialize($_POST[$field]):${$field};
	if($postval) $set[$k] = "$field = '".$postval."'";
}

$sql = "UPDATE {$g5['eyoom_member']} SET ".implode(',',$set)." WHERE mb_id = '{$eyoomer['mb_id']}'";
if(sql_query($sql,false)) {
	alert('정상적으로 설정정보를 저장하였습니다.',G5_URL.'/mypage/config.php');
} else {
	alert('처리중 오류가 발생하였습니다.');
}