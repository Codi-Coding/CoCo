<?php
$g5_path = '../../..';
include_once($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

if(!$is_member) exit;

$mb_id = $_POST['user'];
if(!$mb_id) exit;

// 유저정보 
$user = $eb->get_user_info($mb_id);
$likes = $user['likes'];
if(!$likes) $likes = array();
if(!in_array($member['mb_id'],$likes)) {
	array_push($likes,$member['mb_id']);
	sql_query("update {$g5['eyoom_member']} set likes = '".serialize($likes)."' where mb_id='{$mb_id}'", false);
	
	// 푸시등록
	if($user['onoff_push_likes'] == 'on') $eb->set_push("likes",$member['mb_id'],$mb_id,$member['mb_nick']);
	$tocken = 'yes';
} else {
	$tocken = 'no';
}

if($tocken) {
	$_value_array = array();
	$_value_array['result'] = $tocken;

	include_once "../../classes/json.class.php";

	$json = new Services_JSON();
	$output = $json->encode($_value_array);

	echo $output;
}
exit;