<?php
$sub_menu = '400200';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "w");

$ca_id = $_GET['id'];
$depth = strlen($ca_id)/2;

$action_url = EYOOM_ADMIN_URL . "/?dir=shop&amp;pid=categoryform_update&amp;smode=1";

if($ca_id) {
	$sql = "select * from {$g5['g5_shop_category_table']} where ca_id='{$ca_id}' ";
	$cainfo = sql_fetch($sql, false);

	if($cainfo['ca_use'] == '1') $checked['ca_use1'] = 'checked'; else $checked['ca_use2'] = 'checked';
	if(!$cainfo['ca_path']) {
		$cainfo['ca_path'] = $thema->get_path($cainfo['ca_id']);
	}
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";
?>