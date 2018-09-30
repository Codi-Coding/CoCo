<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


if(USE_G5_THEME && defined('G5_THEME_PATH')) {
	require_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}

if (isset($config['cf_analytics']) && $config['cf_analytics']) {
    echo $config['cf_analytics'];
}

if(IS_SHOP) echo '<script src="'.G5_JS_URL.'/sns.js"></script>'.PHP_EOL;

// Page Iframe Modal
if(APMS_PIM || $is_layout_sub) {
	@include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
	return;
}

if(file_exists(THEMA_PATH.'/shop.tail.php')) {
	include_once(THEMA_PATH.'/shop.tail.php');
} else {
	include_once(THEMA_PATH.'/tailtail.php');
}

include_once(G5_PATH."/tail.sub.php"); 

?>