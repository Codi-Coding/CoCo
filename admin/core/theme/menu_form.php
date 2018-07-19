<?php
$sub_menu = "800300";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=menu_form_update&amp;smode=1';

$theme 		= clean_xss_tags(trim($_GET['thema']));
$me_code 	= $_GET['id'];
$depth 		= strlen($me_code)/3;

if($theme && $me_code) {
	$sql = "select * from {$g5['eyoom_menu']} where me_theme='{$theme}' and me_code='{$me_code}' and me_shop = '2'";
	$meinfo = sql_fetch($sql, false);
	if($meinfo['me_side'] == 'y') $checked['me_side1'] = 'checked'; else $checked['me_side2'] = 'checked';
	if($meinfo['me_use'] == 'y') $checked['me_use1'] = 'checked'; else $checked['me_use2'] = 'checked';
	if($meinfo['me_use_nav'] == 'y' || !$meinfo['me_use_nav']) $checked['me_use_nav1'] = 'checked'; else $checked['me_use_nav2'] = 'checked';
	if(!$meinfo['me_path']) {
		$meinfo['me_path'] = $thema->get_path($meinfo['me_code']);
	}
	$g5_url = parse_url(G5_URL);
	$meinfo['me_link'] = str_replace($g5_url['path'],'',$meinfo['me_link']);
	if(!preg_match('/(http|https):/i',$meinfo['me_link'])) {
		$meinfo['me_link'] = G5_URL.$meinfo['me_link'];
	}
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'meinfo' => $meinfo,
));