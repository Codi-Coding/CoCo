<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (defined('G5_USE_SHOP') and G5_USE_SHOP) {

if(!defined('_THEME_PREVIEW_')) {
    // 테마 경로 설정
    if(defined('G5_THEME_PATH')) {
        define('G5_THEME_SHOP_PATH',   G5_THEME_PATH.'/'.G5_SHOP_DIR);
        define('G5_THEME_SHOP_URL',    G5_THEME_URL. '/'.G5_SHOP_DIR);
        define('G5_THEME_MSHOP_PATH',  G5_THEME_MOBILE_PATH.'/'.G5_SHOP_DIR);
        define('G5_THEME_MSHOP_URL',   G5_THEME_MOBILE_URL. '/'.G5_SHOP_DIR);
    }

    // 스킨 경로 설정
    if(preg_match('#^theme/(.+)$#', $default['de_shop_skin'], $match)) {
        define('G5_SHOP_SKIN_PATH',  G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1]);
        define('G5_SHOP_SKIN_URL',   G5_THEME_URL .'/'.G5_SKIN_DIR.'/shop/'.$match[1]);
    } else {
        define('G5_SHOP_SKIN_PATH',  G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$default['de_shop_skin']);
        define('G5_SHOP_SKIN_URL',   G5_URL .'/'.G5_SKIN_DIR.'/shop/'.$default['de_shop_skin']);
    }

    if(preg_match('#^theme/(.+)$#', $default['de_shop_mobile_skin'], $match)) {
        define('G5_MSHOP_SKIN_PATH', G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1]);
        define('G5_MSHOP_SKIN_URL',  G5_THEME_MOBILE_URL .'/'.G5_SKIN_DIR.'/shop/'.$match[1]);
    } else {
        define('G5_MSHOP_SKIN_PATH', G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$default['de_shop_mobile_skin']);
        define('G5_MSHOP_SKIN_URL',  G5_MOBILE_URL .'/'.G5_SKIN_DIR.'/shop/'.$default['de_shop_mobile_skin']);
    }

    define('G5_TMPL_SHOP_PATH', G5_TMPL_PATH.'/'.G5_SHOP_DIR);
    define('G5_TMPL_SHOP_URL',  G5_TMPL_URL.'/'.G5_SHOP_DIR);
    define('G5_MOBILE_TMPL_SHOP_PATH', G5_MOBILE_TMPL_PATH.'/'.G5_SHOP_DIR);
    define('G5_MOBILE_TMPL_SHOP_URL',  G5_MOBILE_TMPL_URL.'/'.G5_SHOP_DIR);
}

// 옵션 ID 특수문자 필터링 패턴
define('G5_OPTION_ID_FILTER', '/[\'\"\\\'\\\"]/');

/// extend/shop.extend.php에서 이동해 옴. 2018.04.12
include_once(G5_LIB_PATH.'/shop.lib.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
} // use shop
?>
