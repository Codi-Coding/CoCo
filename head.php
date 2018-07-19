<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/head.php');
    return;
}

//Change Mode
$as_href['pc_mobile'] = (G5_DEVICE_BUTTON_DISPLAY) ? get_device_change_url() : '';

// Page Iframe Modal
if(APMS_PIM || $is_layout_sub) {
	include_once(G5_PATH.'/head.sub.php');
	@include_once(THEMA_PATH.'/head.sub.php');
	return;
}

// Head Sub
include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

// Thema Preview
if($is_designer) {
	if (defined('THEMA_PREVIEW')) {
		echo '<div class="hidden-xs font-12" style="position:fixed; left:0; bottom:100px; z-index:1000;"><a class="btn_admin" href="'.G5_URL.'/?pv=1"><span class="white">미리보기 해제</span></a></div>';
	}
}

$page_title = apms_fa($page_title);
$page_desc = apms_fa($page_desc);

$menu = apms_auto_menu();
$menu = apms_multi_menu($menu, $at['id'], $at['multi']);

if($is_member) thema_member();

//Statistics
$stats = apms_stats();

if($is_main && !$hid && !$gid ) {
	$newwin_path = (G5_IS_MOBILE) ? G5_MOBILE_PATH : G5_BBS_PATH;
	@include_once ($newwin_path.'/newwin.inc.php'); // 팝업레이어
}

if(IS_YC) {
	if(IS_SHOP) {
		if(file_exists(THEMA_PATH.'/shop.head.php')) {
			include_once(THEMA_PATH.'/shop.head.php');
		} else {
			include_once(THEMA_PATH.'/head.php');
		}
	} else {
		if(file_exists(THEMA_PATH.'/head.php')) {
			include_once(THEMA_PATH.'/head.php');
		} else {
			include_once(THEMA_PATH.'/shop.head.php');
		}
	}	
} else {
	include_once(THEMA_PATH.'/head.php');
}

?>
