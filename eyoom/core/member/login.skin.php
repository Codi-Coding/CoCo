<?php
if (!defined('_GNUBOARD_')) exit;

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/login.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'login.skin.html');

// 소셜로그인
if ($eyoom['use_social_login'] == 'y') {
	if((defined('G5_NAVER_OAUTH_CLIENT_ID') && G5_NAVER_OAUTH_CLIENT_ID) || (defined('G5_KAKAO_OAUTH_REST_API_KEY') && G5_KAKAO_OAUTH_REST_API_KEY) || (defined('G5_FACEBOOK_CLIENT_ID') && G5_FACEBOOK_CLIENT_ID) || (defined('G5_GOOGLE_CLIENT_ID') && G5_GOOGLE_CLIENT_ID)) {
		$social_oauth_url = G5_PLUGIN_URL.'/oauth/login.php?service=';
	}	
} else if ($config['cf_social_login_use']) {
	$social_pop_once = false;
	
	$self_url = G5_BBS_URL."/login.php";
	
	//새창을 사용한다면
	if( G5_SOCIAL_USE_POPUP ) {
	    $self_url = G5_SOCIAL_LOGIN_URL.'/popup.php';
	}
}

$tpl->define(array(
	'oauth_bs' => 'skin_bs/member/' . $eyoom['member_skin'] . '/social_button.skin.html',
));

$tpl->assign(array(
	'social_oauth_url' => $social_oauth_url,
	'self_url' => $self_url,
	'social_pop_once' => $social_pop_once,
));

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);