<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/// 사용 기기 설정을 위해 theme.config.php 로드
if( !(isset($config['cf_theme']) && trim($config['cf_theme'])) 
    /*&& preg_match('/^theme_/', $g5['tmpl'])*/ 
    /*&& !(defined('G5_IS_ADMIN') && G5_IS_ADMIN)*/ ) {

    // 테마 설정 로드
    if(is_file(G5_TMPL_PATH.'/theme.config.php'))
        include_once(G5_TMPL_PATH.'/theme.config.php');
    if(is_file(G5_MOBILE_TMPL_PATH.'/theme.config.php'))
        include_once(G5_MOBILE_TMPL_PATH.'/theme.config.php');
}

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
?>
