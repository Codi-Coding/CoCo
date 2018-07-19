<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

if($is_admin != 'super') alert('최고관리자만 설정을 변경할 수 있습니다.');

unset($theme);
$theme 		= clean_xss_tags(trim($_POST['theme']));
$shop_theme = clean_xss_tags(trim($_POST['shop_theme']));
$back_theme = clean_xss_tags(trim($_POST['back_theme']));
$back_pid 	= clean_xss_tags(trim($_POST['back_pid']));
$w 			= clean_xss_tags(trim($_POST['w']));
$bo_table 	= clean_xss_tags(trim($_POST['bo_table']));

$qstr = '';
if($w) $qstr .= "&amp;w={$w}";
if($bo_table && !is_array($bo_table)) $qstr .= "&amp;bo_table={$bo_table}";

if ($theme) {
	$eyoom_basic['theme'] = $theme;
}

// 쇼핑몰 홈테마 변경시, 커뮤니티홈테마는 그대로 
$eyoom_config = array();

// 쇼핑몰 테마인지 구별
if ($shop_theme) {
	// 지정한 테마에 shop 스킨이 존재하는지 체크
	if(preg_match('/pc_/', $shop_theme)) {
		$device = 'pc';
	} else {
		$device = 'bs';
	}
	$shop_dir = G5_PATH.'/eyoom/theme/'.$shop_theme.'/skin_'.$device.'/shop/';
	if(!is_dir($shop_dir)) alert("선택한 테마는 쇼핑몰 테마가 아닙니다.");
	
	$eyoom_basic['shop_theme'] = $shop_theme;
}

// 설정 저장
$eyoom_config = $eyoom_config + $eyoom_basic;
$qfile->save_file('eyoom', eyoom_config, $eyoom_config);

goto_url(EYOOM_ADMIN_URL . "/?dir=theme&amp;pid={$back_pid}{$qstr}&amp;thema={$back_theme}");