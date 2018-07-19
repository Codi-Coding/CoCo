<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<?php if($g5['tmpl'] == 'g4_basic_g4' && !defined('G5_IS_ADMIN')) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php } else { ?>
<!doctype html>
<?php } ?>
<?php ///*** Do not remove the line below
echo "<!-- ".BUILDER_NAME; echo " ".BUILDER_VERSION_NUMBER; if(defined('BUILDER_VERSION_CLASS') and BUILDER_VERSION_CLASS) echo " ".BUILDER_VERSION_CLASS; echo ", ".BUILDER_VERSION_DATE.", ".BUILDER_HOME." -->".PHP_EOL; ///goodbuilder
?>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php
echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">'.PHP_EOL;
echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge">'.PHP_EOL; /// 추가

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
if(defined('G5_USE_SEO_META') && G5_USE_SEO_META) include_once G5_PLUGIN_PATH.'/seo/seo_meta.php';
?>
<?php if(0) { ?><title><?php echo $g5_head_title; ?></title><?php } ?>
<?php /// New
if($site_name == '') $site_name = $config['cf_title'];
if($index_title)
    echo "<title>"._t($index_title)."</title>\n";
else if($g5[title])
    /// echo "<title>$g5[title] > $group[gr_subject] > $site_name</title>\n";
    echo "<title>"._t($g5[title])." > "._t($site_name)."</title>\n";
else
    echo "<title>"._t($site_name)."</title>\n";
?>
<?php
if (defined('G5_IS_ADMIN')) {
    if(!defined('_THEME_PREVIEW_'))
        echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin.css">'.PHP_EOL;
} else {
    $shop_css = '_shop';
    echo '<link rel="stylesheet" href="'.$g5['mobile_tmpl_url'].'/css/'.'default.css?ver='.G5_CSS_VER.'">'.PHP_EOL;
    /// echo '<link rel="stylesheet" href="'.$g5['mobile_tmpl_url'].'/css/'.'style.css?ver='.G5_CSS_VER.'">'.PHP_EOL;
    add_stylesheet('<link rel="stylesheet" href="'.$g5['mobile_tmpl_url'].'/css/'.'style.css?ver='.G5_CSS_VER.'">', 0);
}
if($g5['def_font'] and file_exists($g5['path'].'/font/font_'.$g5['def_font'].'.css')) {
    if(!($g5['def_font_g4_no_use'] && preg_match('/^g4_/', $g5['tmpl'])))
    echo '<link rel="stylesheet" href="'.$g5['url'].'/font/'.'font_'.$g5['def_font'].'.css">'.PHP_EOL;
}
?>
<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
// 통화, 환율 관련 전역변수 선언
var g5_def_currency  = "<?php echo $g5['def_currency']; ?>";
var g5_currency  = "<?php echo $g5['currency']; ?>";
var g5_exchange_rate = "<?php echo $g5['exchange_rate']; ?>";
var g5_use_currency_conversion = "<?php if(defined('G5_USE_CURRENCY_CONVERSION') && G5_USE_CURRENCY_CONVERSION) echo '1'; else echo '0'; ?>";
<?php
if ($is_admin) {
    echo 'var g5_admin_url = "'.G5_ADMIN_URL.'";'.PHP_EOL;
}
?>
// g4 자바스크립트에서 사용했던 전역변수 선언 추가. 호환성 고려
var g5_bbs       = "<?php echo $g5['bbs']?>";
var g5_bbs_img   = "<?php echo $g5['bbs_img']?>";
var g5_charset   = "<?php echo $g5['charset']?>";
var g5_is_gecko  = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;
var g5_is_ie     = navigator.userAgent.toLowerCase().indexOf("msie") != -1;
<?php if ($is_admin) { echo "var g5_admin = '{$g5['admin']}';".PHP_EOL; } ?>
</script>
<?php if(1) { ?>
<?php include_once $g5['locale_path'].'/basic/lang_js_var.inc.php'; ?>
<?php if (defined('_SHOP_') || defined('_CONTENTS_')) { ?>
<?php include_once $g5['locale_path'].'/basic/lang_shop_js_var.inc.php'; ?>
<?php } ?>
<?php } ?>
<?php if(0) { ?>
<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<?php } ?>
<script src="<?php echo G5_JS_URL ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery-migrate-1.2.1.js"></script>
<?php
if (defined('_SHOP_')) {
    if(!G5_IS_MOBILE) {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.shop.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php
    }
} else {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>
<script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
<!--<script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>-->
<script src="<?php echo $g5['legacy_url'] ?>/js/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>

<?php
if($g5['lang_button_ok']) include_once G5_PATH.'/locale/basic/lang_button.inc.php';
?>

<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg">'.$sr_admin_msg.get_text($member['mb_nick']).'님 로그인 중 ';
    echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
}
?>
