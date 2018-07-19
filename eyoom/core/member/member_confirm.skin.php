<?php
if (!defined('_GNUBOARD_')) exit;

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/member_confirm.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'member_confirm.skin.html');

// 소셜로그인
if ($eyoom['use_social_login'] == 'y') {
	if ($is_guest) define('IS_GUEST', true);
	
	if((defined('G5_NAVER_OAUTH_CLIENT_ID') && G5_NAVER_OAUTH_CLIENT_ID) || (defined('G5_KAKAO_OAUTH_REST_API_KEY') && G5_KAKAO_OAUTH_REST_API_KEY) || (defined('G5_FACEBOOK_CLIENT_ID') && G5_FACEBOOK_CLIENT_ID) || (defined('G5_GOOGLE_CLIENT_ID') && G5_GOOGLE_CLIENT_ID)) {
		$social_oauth_url = G5_PLUGIN_URL.'/oauth/login.php?mode=confirm&amp;service=';
		include_once(G5_PLUGIN_PATH.'/oauth/functions.php');
		
		$tpl->define(array(
			'oauth_bs' => 'skin_bs/member/' . $eyoom['member_skin'] . '/social_button.skin.html',
		));
		
		$tpl->assign('social_oauth_url', $social_oauth_url);
	}
}

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);