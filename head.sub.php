<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 테마 head.sub.php 파일
if(defined('_THEME_PREVIEW_') && _THEME_PREVIEW_ === true) {
	if(defined('G5_THEME_PATH') && is_file(G5_THEME_PATH.'/head.sub.php')) {
	    require_once(G5_THEME_PATH.'/head.sub.php');
		return;
	}
} else if(USE_G5_THEME) {
	if(!defined('G5_IS_ADMIN') && defined('G5_THEME_PATH') && is_file(G5_THEME_PATH.'/head.sub.php')) {
		require_once(G5_THEME_PATH.'/head.sub.php');
	    return;
	}
}

$begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else { // 상태바에 표시될 제목
    $g5_head_title = $g5['title'].' > '.$config['cf_title'];
}

$g5_head_title = apms_get_text($g5_head_title);

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
<!doctype html>
<html lang="<?php echo $aslang['html_lang']; //ko ?>">
<head>
<meta charset="utf-8">
<?php
$body_mode = 'is-pc';
if (G5_IS_MOBILE) {
	$body_mode = 'is-mobile';
	echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} 
echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge">'.PHP_EOL;
if(APMS_PRINT){  //프린트 상태일 때는 검색엔진에서 제외합니다.
	echo '<meta name="robots" content="noindex, nofollow">'.PHP_EOL;
}
if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;

// SEO META
if(!APMS_PRINT)
	include_once(G5_LIB_PATH.'/apms.meta.lib.php');

?>
<title><?php echo $g5_head_title; ?></title>
<?php
if (defined('G5_IS_ADMIN')) {
    echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin.css">'.PHP_EOL;
} else {
    $shop_css = '';
    if (defined('_SHOP_')) $shop_css = '_shop';
    echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/'.(G5_IS_MOBILE?'mobile':'default').$shop_css.'.css?ver='.APMS_SVER.'">'.PHP_EOL;
}
echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/apms.css?ver='.APMS_SVER.'">'.PHP_EOL;
echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/font-awesome/css/font-awesome.min.css?ver='.APMS_SVER.'">'.PHP_EOL;
if($xp['xp_icon'] == 'txt') {
	echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/level/'.$xp['xp_icon_css'].'.css?ver='.APMS_SVER.'">'.PHP_EOL;
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
var g5_pim       = "<?php echo APMS_PIM ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_responsive    = "<?php echo (_RESPONSIVE_) ? 1 : '';?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php if($is_admin || defined('G5_IS_ADMIN')) { ?>
var g5_admin_url = "<?php echo G5_ADMIN_URL; ?>";
<?php } ?>
var g5_purl = "<?php echo $seometa['url']; ?>";
</script>
<script src="<?php echo G5_JS_URL ?>/jquery-1.11.3.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo APMS_LANG_URL ?>/lang.js?ver=<?php echo APMS_SVER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo APMS_SVER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo APMS_SVER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/apms.js?ver=<?php echo APMS_SVER; ?>"></script>
<?php
if(!defined('G5_IS_ADMIN') && $config['cf_add_script']) {
    echo $config['cf_add_script'].PHP_EOL;
}
?>
</head>
<body<?php echo (isset($g5['body_script']) && $g5['body_script']) ? $g5['body_script'].' ' : ''; ?> class="<?php echo (_RESPONSIVE_) ? '' : 'no-';?>responsive <?php echo $body_mode;?>">
<?php
if(APMS_PRINT) {
	@include_once($print_skin_path.'/print.head.php');
}
?>