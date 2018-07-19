<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/// 테마형 템플릿 지원. 테마 이름을 'theme_' 로 시작함.
if( !(isset($config['cf_theme']) && trim($config['cf_theme'])) 
    /*&& preg_match('/^theme_/', $g5['tmpl'])*/ 
    /*&& !(defined('G5_IS_ADMIN') && G5_IS_ADMIN)*/
    && !defined('_THEME_PREVIEW_') ) {

    // 테마 설정 로드
    if(is_file(G5_TMPL_PATH.'/theme.config.php'))
        include_once(G5_TMPL_PATH.'/theme.config.php');
    if(is_file(G5_MOBILE_TMPL_PATH.'/theme.config.php'))
        include_once(G5_MOBILE_TMPL_PATH.'/theme.config.php');

    $config['cf_theme'] = $g5['tmpl'];
    $theme_path = G5_TMPL_PATH;
    if(is_dir($theme_path)) {
        define('G5_THEME_PATH',        G5_TMPL_PATH);
        define('G5_THEME_URL',         G5_TMPL_URL);
        if(defined('G5_USE_INTERNAL_MOBILE') && G5_USE_INTERNAL_MOBILE && file_exists(G5_TMPL_PATH.'/'.G5_MOBILE_DIR.'/index.php')) {
            define('G5_THEME_MOBILE_PATH', G5_TMPL_PATH.'/'.G5_MOBILE_DIR);
            define('G5_THEME_MOBILE_URL', G5_TMPL_URL.'/'.G5_MOBILE_DIR);
        } else {
            define('G5_THEME_MOBILE_PATH', G5_MOBILE_TMPL_PATH);
            define('G5_THEME_MOBILE_URL', G5_MOBILE_TMPL_URL);
        }
        define('G5_THEME_LIB_PATH',    G5_TMPL_PATH.'/'.G5_LIB_DIR);
        define('G5_THEME_CSS_URL',     G5_TMPL_URL.'/'.G5_CSS_DIR);
        define('G5_THEME_IMG_URL',     G5_TMPL_URL.'/'.G5_IMG_DIR);
        define('G5_THEME_JS_URL',      G5_TMPL_URL.'/'.G5_JS_DIR);

        define('G5_THEME_MOBILE_LIB_PATH',    G5_THEME_MOBILE_PATH.'/'.G5_LIB_DIR);
        define('G5_THEME_MOBILE_CSS_URL',     G5_THEME_MOBILE_URL.'/'.G5_CSS_DIR);
        define('G5_THEME_MOBILE_IMG_URL',     G5_THEME_MOBILE_URL.'/'.G5_IMG_DIR);
        define('G5_THEME_MOBILE_JS_URL',      G5_THEME_MOBILE_URL.'/'.G5_JS_DIR);
    }
    unset($theme_path);
}

define('G5_TMPL_LIB_PATH',    G5_TMPL_PATH.'/'.G5_LIB_DIR);
define('G5_TMPL_CSS_URL',     G5_TMPL_URL.'/'.G5_CSS_DIR);
define('G5_TMPL_IMG_URL',     G5_TMPL_URL.'/'.G5_IMG_DIR);
define('G5_TMPL_JS_URL',      G5_TMPL_URL.'/'.G5_JS_DIR);

define('G5_MOBILE_TMPL_LIB_PATH',    G5_MOBILE_TMPL_PATH.'/'.G5_LIB_DIR);
define('G5_MOBILE_TMPL_CSS_URL',     G5_MOBILE_TMPL_URL.'/'.G5_CSS_DIR);
define('G5_MOBILE_TMPL_IMG_URL',     G5_MOBILE_TMPL_URL.'/'.G5_IMG_DIR);
define('G5_MOBILE_TMPL_JS_URL',      G5_MOBILE_TMPL_URL.'/'.G5_JS_DIR);

/* templete.extend.theme_device.php로 분리시킴 (G5_IS_MOBILE 상수 호출 전 정의 위해)
//=====================================================================================
// 사용기기 설정
// 테마의 G5_THEME_DEVICE 설정에 따라 사용자 화면 제한됨
// 테마에 별도 설정이 없는 경우 config.php G5_SET_DEVICE 설정에 따라 사용자 화면 제한됨
// pc 설정 시 모바일 기기에서도 PC화면 보여짐
// mobile 설정 시 PC에서도 모바일화면 보여짐
// both 설정 시 접속 기기에 따른 화면 보여짐
//-------------------------------------------------------------------------------------
$is_mobile = false;
$set_device = true;

if(defined('G5_THEME_DEVICE') && G5_THEME_DEVICE != '') {
    switch(G5_THEME_DEVICE) {
        case 'pc':
            $is_mobile  = false;
            $set_device = false;
            break;
        case 'mobile':
            $is_mobile  = true;
            $set_device = false;
            break;
        default:
            break;
    }
}

if(defined('G5_SET_DEVICE') && $set_device) {
    switch(G5_SET_DEVICE) {
        case 'pc':
            $is_mobile  = false;
            $set_device = false;
            break;
        case 'mobile':
            $is_mobile  = true;
            $set_device = false;
            break;
        default:
            break;
    }
}
//==============================================================================

//==============================================================================
// Mobile 모바일 설정
// 쿠키에 저장된 값이 모바일이라면 브라우저 상관없이 모바일로 실행
// 그렇지 않다면 브라우저의 HTTP_USER_AGENT 에 따라 모바일 결정
// G5_MOBILE_AGENT : config.php 에서 선언
//------------------------------------------------------------------------------
if (G5_USE_MOBILE && $set_device) {
    if ($_REQUEST['device']=='pc')
        $is_mobile = false;
    else if ($_REQUEST['device']=='mobile')
        $is_mobile = true;
    else if (isset($_SESSION['ss_is_mobile']))
        $is_mobile = $_SESSION['ss_is_mobile'];
    else if (is_mobile())
        $is_mobile = true;
} else {
    $set_device = false;
}

$_SESSION['ss_is_mobile'] = $is_mobile;
define('G5_IS_MOBILE', $is_mobile);
define('G5_DEVICE_BUTTON_DISPLAY', $set_device);
*/

if (G5_IS_MOBILE) {
    ///$g5['mobile_path'] = G5_PATH.'/'.$g5['mobile_dir'];
}
//==============================================================================

if (G5_IS_MOBILE) {
    $board_skin_path    = get_skin_path('board', $board['bo_mobile_skin']);
    $board_skin_url     = get_skin_url('board', $board['bo_mobile_skin']);
    $member_skin_path   = get_skin_path('member', $config['cf_mobile_member_skin']);
    $member_skin_url    = get_skin_url('member', $config['cf_mobile_member_skin']);
    $new_skin_path      = get_skin_path('new', $config['cf_mobile_new_skin']);
    $new_skin_url       = get_skin_url('new', $config['cf_mobile_new_skin']);
    $search_skin_path   = get_skin_path('search', $config['cf_mobile_search_skin']);
    $search_skin_url    = get_skin_url('search', $config['cf_mobile_search_skin']);
    $connect_skin_path  = get_skin_path('connect', $config['cf_mobile_connect_skin']);
    $connect_skin_url   = get_skin_url('connect', $config['cf_mobile_connect_skin']);
    $faq_skin_path      = get_skin_path('faq', $config['cf_mobile_faq_skin']);
    $faq_skin_url       = get_skin_url('faq', $config['cf_mobile_faq_skin']);

    /// reserved
    $qa_skin_path       = get_skin_path('qa', $config['cf_mobile_qa_skin']);
    $qa_skin_url        = get_skin_url('qa', $config['cf_mobile_qa_skin']);
    $content_skin_path  = get_skin_path('content', $config['cf_mobile_co_skin']);
    $content_skin_url   = get_skin_url('content', $config['cf_mobile_co_skin']);
} else {
    $board_skin_path    = get_skin_path('board', $board['bo_skin']);
    $board_skin_url     = get_skin_url('board', $board['bo_skin']);
    $member_skin_path   = get_skin_path('member', $config['cf_member_skin']);
    $member_skin_url    = get_skin_url('member', $config['cf_member_skin']);
    $new_skin_path      = get_skin_path('new', $config['cf_new_skin']);
    $new_skin_url       = get_skin_url('new', $config['cf_new_skin']);
    $search_skin_path   = get_skin_path('search', $config['cf_search_skin']);
    $search_skin_url    = get_skin_url('search', $config['cf_search_skin']);
    $connect_skin_path  = get_skin_path('connect', $config['cf_connect_skin']);
    $connect_skin_url   = get_skin_url('connect', $config['cf_connect_skin']);
    $faq_skin_path      = get_skin_path('faq', $config['cf_faq_skin']);
    $faq_skin_url       = get_skin_url('faq', $config['cf_faq_skin']);

    /// reserved
    $qa_skin_path       = get_skin_path('qa', $config['cf_qa_skin']);
    $qa_skin_url        = get_skin_url('qa', $config['cf_qa_skin']);
    $content_skin_path  = get_skin_path('content', $config['cf_co_skin']);
    $content_skin_url   = get_skin_url('content', $config['cf_co_skin']);
}
?>
