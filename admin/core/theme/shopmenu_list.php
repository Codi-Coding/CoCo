<?php
$sub_menu = "800400";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

/**
 * 쇼핑몰 테마만 적용 가능
 */
if (!$shopping_theme) alert("현재 작업중인 [{$this_theme}]테마는 [쇼핑몰] 테마가 아닙니다.");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=shopmenu_list_update&amp;smode=1';

$me_id = clean_xss_tags(trim($_GET['id']));