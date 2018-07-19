<?php
$sub_menu = "800500";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=banner_location_update&amp;smode=1';

$banner_config = G5_DATA_PATH.'/banner/banner.'.$this_theme.'.config.php';
if(file_exists($banner_config)) {
	@include_once($banner_config);
}
$bn_count = count($bn_loccd);
if(!$bn_count) $bn_count = 10;

ksort($bn_loccd);

/**
 * 버튼셋
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= '</div>';

$atpl->assign(array(
	'bn_count' 		=> $bn_count,
	'bn_loccd' 		=> $bn_loccd,
	'frm_submit' 	=> $frm_submit,
));