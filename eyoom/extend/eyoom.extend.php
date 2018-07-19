<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * 관리자모드 경로
 */
$admin_dirname	= $eyoom['admin_dirname'] ? $eyoom['admin_dirname']: 'admin';

/**
 * 관리자모드 테마
 */
$admin_theme	= $eyoom['admin_theme'] ? $eyoom['admin_theme']: 'admin_theme';

/**
 * 이윰관리자 경로상수 정의
 */
define('EYOOM_ADMIN_PATH', 			G5_PATH . '/' . $admin_dirname);
define('EYOOM_ADMIN_URL', 			G5_URL . '/' . $admin_dirname);
define('EYOOM_ADMIN_CORE_PATH',		EYOOM_ADMIN_PATH . '/core');
define('EYOOM_ADMIN_CORE_URL',		EYOOM_ADMIN_URL . '/core');
define('EYOOM_ADMIN_CLASS_PATH', 	EYOOM_ADMIN_PATH . '/classes');
define('EYOOM_ADMIN_CLASS_URL', 	EYOOM_ADMIN_URL . '/classes');
define('EYOOM_ADMIN_INC_PATH', 		EYOOM_ADMIN_PATH . '/inc');
define('EYOOM_ADMIN_INC_URL', 		EYOOM_ADMIN_URL . '/inc');
define('EYOOM_ADMIN_THEME_PATH', 	EYOOM_ADMIN_PATH . '/' . $admin_theme);
define('EYOOM_ADMIN_THEME_URL', 	EYOOM_ADMIN_URL . '/' . $admin_theme);