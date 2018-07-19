<?php
if (!defined('_GNUBOARD_')) exit;

define('_MYHOME_',true);

// iOS라면 href에서 wmode 를 off
if($eb->user_agent() != 'ios') $query_wmode = "&amp;wmode=1";

// eyoom.class.php > print_page() 함수에서 $user 정보가 넘어옴

// 내 following 정보에서 user 정보가 있다면 
$myfollowing = $eyoomer['following'];
if(!$myfollowing) $myfollowing = array();
if(in_array($user['mb_id'],$myfollowing)) {
	$user['follow_tocken'] = true;
}

// 방문카운트
$ss_name = 'ss_myhome_'.$user['mb_id'].'_'.$member['mb_id'];
if (!get_session($ss_name) && $is_member) {
    sql_query(" update {$g5['eyoom_member']} set myhome_hit = myhome_hit + 1 where mb_id = '{$user['mb_id']}' ");
    set_session($ss_name, TRUE);
}

switch($userpage) {
	default : 
		// 마이홈 박스
		@include_once(EYOOM_CORE_PATH.'/mypage/myhomebox.php');

		// 유저 게시물 가져오기
		@include_once(EYOOM_CORE_PATH.'/mypage/myhome_myposts.php');
		break;
	case "following":
		@include_once(EYOOM_CORE_PATH.'/mypage/myhome_following.php');
		break;
	case "follower":
		@include_once(EYOOM_CORE_PATH.'/mypage/myhome_follower.php');
		break;
	case "friends":
		@include_once(EYOOM_CORE_PATH.'/mypage/myhome_friends.php');
		break;
	case "guest":
		@include_once(EYOOM_CORE_PATH.'/mypage/myhome_guest.php');
		break;
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/myhome.skin.php');

$tpl->define_template('mypage',$eyoom['mypage_skin'],'myhome.skin.html');

$tpl->assign(array(
	'friends' => $friends,
	'following' => $following,
	'follower' => $follower,
	'page' => $page,
	'userpage' => $userpage,
));

// 본페이지는 eyoom.class.php 파일 내에서 실행됨으로 스킨에 넘길 모든 변수는 assign 해 줘야 함.
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);