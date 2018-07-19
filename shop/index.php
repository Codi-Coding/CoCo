<?php
define("_INDEX_", TRUE);
include_once('./_common.php');

if(!$page_id) {
	$page_id = 'index';
}

$is_index = true;
$is_main = true;

// 쇼핑몰 미지정시
if(!defined('IS_SHOP')) {
	define('_SHOP_', true);
	define('IS_SHOP', true);
	// 예약체크
	apms_check_reserve_end();
}

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
	require_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

// Intro
if($default['as_'.MOBILE_.'intro_skin']) {
	$is_intro = false;
	include_once(G5_SHOP_PATH.'/intro.php');
	if($is_intro)
		return;
}

include_once(G5_SHOP_PATH.'/shop.head.php');

if(!isset($config['as_thema']) || !$config['as_thema']) {
	echo '<br><p align=center>아미나빌더가 설치되어 있지 않습니다. <br><br> 관리자 접속후 관리자화면 > 테마관리에서 아미나빌더를 설치해 주세요.</p><br>';
} else {
	if(file_exists(THEMA_PATH.'/shop.index.php')) {
		include_once (THEMA_PATH.'/shop.index.php');
	} else {
		include_once (THEMA_PATH.'/index.php');
	}
}

include_once(G5_SHOP_PATH.'/shop.tail.php');
?>