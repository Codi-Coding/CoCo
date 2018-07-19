<?php
$sub_menu = "800300";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=menu_list_update&amp;smode=1';

$me_id = clean_xss_tags(trim($_GET['id']));

$atpl->assign(array(
	'exist_theme' => $exist_theme,
));