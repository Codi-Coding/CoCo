<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (defined('G5_USE_CONTENTS') and G5_USE_CONTENTS) {

if(!defined('_THEME_PREVIEW_')) {
    // 테마 경로 설정
    if(defined('G5_THEME_PATH')) {
        define('G5_THEME_CONTENTS_PATH',   G5_THEME_PATH.'/'.G5_CONTENTS_DIR);
        define('G5_THEME_CONTENTS_URL',    G5_THEME_URL.'/'.G5_CONTENTS_DIR);
        define('G5_THEME_MCONTENTS_PATH',  G5_THEME_MOBILE_PATH.'/'.G5_CONTENTS_DIR);
        define('G5_THEME_MCONTENTS_URL',   G5_THEME_MOBILE_URL. '/'.G5_CONTENTS_DIR);
    }

    // 스킨 경로 설정
    if(preg_match('#^theme/(.+)$#', $setting['de_contents_skin'], $match)) {
        define('G5_CONTENTS_SKIN_PATH',  G5_THEME_PATH.'/'.G5_SKIN_DIR.'/contents/'.$match[1]);
        define('G5_CONTENTS_SKIN_URL',   G5_THEME_URL .'/'.G5_SKIN_DIR.'/contents/'.$match[1]);
    } else {
        define('G5_CONTENTS_SKIN_PATH',  G5_PATH.'/'.G5_SKIN_DIR.'/contents/'.$setting['de_contents_skin']);
        define('G5_CONTENTS_SKIN_URL',   G5_URL .'/'.G5_SKIN_DIR.'/contents/'.$setting['de_contents_skin']);
    }

    if(preg_match('#^theme/(.+)$#', $setting['de_contents_mobile_skin'], $match)) {
        define('G5_MCONTENTS_SKIN_PATH', G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/contents/'.$match[1]);
        define('G5_MCONTENTS_SKIN_URL',  G5_THEME_MOBILE_URL .'/'.G5_SKIN_DIR.'/contents/'.$match[1]);
    } else {
        define('G5_MCONTENTS_SKIN_PATH', G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/contents/'.$setting['de_contents_mobile_skin']);
        define('G5_MCONTENTS_SKIN_URL',  G5_MOBILE_URL .'/'.G5_SKIN_DIR.'/contents/'.$setting['de_contents_mobile_skin']);
    }

    define('G5_TMPL_CONTENTS_PATH', G5_TMPL_PATH.'/'.G5_CONTENTS_DIR);
    define('G5_TMPL_CONTENTS_URL',  G5_TMPL_URL.'/'.G5_CONTENTS_DIR);
    define('G5_MOBILE_TMPL_CONTENTS_PATH', G5_MOBILE_TMPL_PATH.'/'.G5_CONTENTS_DIR);
    define('G5_MOBILE_TMPL_CONTENTS_URL',  G5_MOBILE_TMPL_URL.'/'.G5_CONTENTS_DIR);
}

} // use contents
?>
