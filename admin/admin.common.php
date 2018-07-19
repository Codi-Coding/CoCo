<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

// 관리자 메뉴설정 파일
if (!$smode) @include_once(EYOOM_ADMIN_INC_PATH.'/admin.menu.info.php');

// 관리자 라이브러리 파일 
@include_once(EYOOM_ADMIN_INC_PATH.'/admin.lib.php');

// 관리자 모드 테마
$admin_theme = $eyoom_admin['theme'] ? $eyoom_admin['theme'] : 'admin_basic';
$atpl = new Template($admin_theme);
$atpl->template_dir	= EYOOM_ADMIN_THEME_PATH;

$atpl->assign(array(
	'member' => $member,
));