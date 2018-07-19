<?php
if (!defined('_GNUBOARD_')) exit;

if(isset($member['mb_open_date'])) {
	$open_day = date("Y년 m월 j일", strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400);
} else {
	$open_day = date("Y년 m월 j일", G5_SERVER_TIME+$config['cf_open_modify']*86400);
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/register_form.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'register_form.skin.html');

// 소셜로그인
if ($eyoom['use_social_login'] == 'y') {
	if($w != 'u' || $is_guest)  define('IS_GUEST', true);
	
	if((defined('G5_NAVER_OAUTH_CLIENT_ID') && G5_NAVER_OAUTH_CLIENT_ID) || (defined('G5_KAKAO_OAUTH_REST_API_KEY') && G5_KAKAO_OAUTH_REST_API_KEY) || (defined('G5_FACEBOOK_CLIENT_ID') && G5_FACEBOOK_CLIENT_ID) || (defined('G5_GOOGLE_CLIENT_ID') && G5_GOOGLE_CLIENT_ID)) {
		
		$social_oauth_url = G5_PLUGIN_URL.'/oauth/login.php?mode=connect&amp;service=';
		
		include_once(G5_PLUGIN_PATH.'/oauth/functions.php');
		
		// 연동여부 확인
		$nid_ico = '';
		$kko_ico = '';
		$fcb_ico = '';
		$ggl_ico = '';
		
		if($member['mb_id']) {
		    if(!is_social_connected($member['mb_id'], 'naver'))
		        $nid_class = ' sns-icon-not';
		
		    if(!is_social_connected($member['mb_id'], 'kakao'))
		        $kko_class = ' sns-icon-not';
		
		    if(!is_social_connected($member['mb_id'], 'facebook'))
		        $fcb_class = ' sns-icon-not';
		
		    if(!is_social_connected($member['mb_id'], 'google'))
		        $ggl_class = ' sns-icon-not';
		}
		
		$tpl->define(array(
			'oauth_bs' => 'skin_bs/member/' . $eyoom['member_skin'] . '/social_button.skin.html',
		));
		
		$tpl->assign(array(
			'social_oauth_url' => $social_oauth_url,
			'nid_class' => $nid_class,
			'kko_class' => $kko_class,
			'fcb_class' => $fcb_class,
			'ggl_class' => $ggl_class,
		));
	}
}

@include EYOOM_INC_PATH.'/tpl.assign.php';

$tpl->print_($tpl_name);