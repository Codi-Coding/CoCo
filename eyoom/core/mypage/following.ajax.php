<?php
$g5_path = '../../..';
include_once($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

if(!$is_member) exit;

$action = $_POST['action'];
$mb_id = $_POST['user'];
if(!$action) exit;
if(!$mb_id) exit;

$tocken = '';
// 나의 팔로윙
$following = $eyoomer['following'];
if(!$following) $following = array();

// 내가 팔로잉한 회원 정보
$user = $eb->get_user_info($mb_id);

if($user['onoff_social'] != 'on') {
	$tocken = 'no';
} else {
	$follower = $user['follower'];
	if(!$follower) $follower = array();

	switch($action) {
		case 'following':
			// 내 팔로잉 목록에 추가하기
			if(!in_array($mb_id,$following)) {
				array_push($following,$mb_id);
				sql_query("update {$g5['eyoom_member']} set following = '".serialize($following)."' where mb_id='{$member['mb_id']}'", false);
				$eb->level_point($levelset['following'],$mb_id,$levelset['follower']);
			}
			// 내가 팔로잉한 회원의 팔로어에 추가하기
			if(!in_array($member['mb_id'],$follower)) {
				array_push($follower,$member['mb_id']);
				sql_query("update {$g5['eyoom_member']} set follower = '".serialize($follower)."' where mb_id='{$mb_id}'", false);

				// 푸시등록
				if($user['onoff_push_social'] == 'on') $eb->set_push("following",$member['mb_id'],$mb_id,$member['mb_nick']);
			}
			$tocken = 'yes';
			break;

		case 'unfollow':
			// 내 팔로잉 에서 회원 언팔로우하기
			if(($key = array_search($mb_id,$following)) !== false) {
				unset($following[$key]);
				sql_query("update {$g5['eyoom_member']} set following = '".serialize($following)."' where mb_id='{$member['mb_id']}'", false);
			}
			// 회원의 팔로어에서 내 팔로어 제거하기
			if(($key = array_search($member['mb_id'],$follower)) !== false) {
				unset($follower[$key]);
				sql_query("update {$g5['eyoom_member']} set follower = '".serialize($follower)."' where mb_id='{$mb_id}'", false);

				// 푸시등록
				if($user['onoff_push_social'] == 'on') $eb->set_push("unfollow",$member['mb_id'],$mb_id,$member['mb_nick']);
			}
			$tocken = 'yes';
			break;
	}

	// 나의 활동
	$act_contents = array();
	$act_contents['mb_nick'] = $user['mb_nick'];
	$act_contents['mb_id'] = $mb_id;
	$eb->insert_activity($member['mb_id'],$action,$act_contents);
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