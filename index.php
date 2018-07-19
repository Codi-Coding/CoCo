<?php
include_once('./_common.php');
define('_INDEX_', true);

if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$is_index = true;
$is_main = true;

// 루트 index를 쇼핑몰 index 설정했을 때
if(IS_YC && isset($default['de_root_index_use']) && $default['de_root_index_use'] && (!isset($ci) || !$ci)) {
    require_once(G5_SHOP_PATH.'/index.php');
    return;
} else {
	if(USE_G5_THEME && defined('G5_THEME_PATH')) {
		require_once(G5_THEME_PATH.'/index.php');
		return;
	}
	define('IS_SHOP', false);
}

// Intro
if($config['as_'.MOBILE_.'intro_skin']) {
	$is_intro = false;
	include_once(G5_BBS_PATH.'/intro.php');
	if($is_intro)
		return;
}

include_once('./_head.php');

if(!isset($config['as_thema']) || !$config['as_thema']) {
	echo '<br><p align=center>아미나빌더가 설치되어 있지 않습니다. <br><br> 관리자 접속후 관리자화면 > 테마관리에서 아미나빌더를 설치해 주세요.</p><br>';
} else {
	if(IS_YC) {
		if(file_exists(THEMA_PATH.'/index.php')) {
			include_once(THEMA_PATH.'/index.php');
		} else {
			include_once(THEMA_PATH.'/shop.index.php');
		}
	} else {
		include_once(THEMA_PATH.'/index.php');
	}
}

include_once('./_tail.php');
?>
