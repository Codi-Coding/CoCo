<?php
$sub_menu = '400300';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

/**
 * submit & list & item view buttons
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="button" value="복사하기" id="btn_submit" class="btn-e btn-e-lg btn-e-red" onclick="_copy();">' ;
$frm_submit .= ' </div>';

$atpl->assign(array(
	'frm_submit' 	=> $frm_submit
));

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";