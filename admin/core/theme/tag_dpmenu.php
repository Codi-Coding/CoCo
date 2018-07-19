<?php
$sub_menu = "800700";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$tg_id 		= clean_xss_tags(trim($_POST['id']));
$tg_dpmenu 	= clean_xss_tags(trim($_POST['yn']));
if(!$tg_id) exit;
if(!$tg_dpmenu) $tg_dpmenu = 'n';

switch($tg_dpmenu) {
	case 'y': $dpmenu = 'n'; break;
	case 'n': $dpmenu = 'y'; break;
}

$sql = "update {$g5['eyoom_tag']} set tg_dpmenu = '{$tg_dpmenu}' where tg_id = '{$tg_id}'";
sql_query($sql);

$_value_array = array();
$_value_array['dpmenu'] = $dpmenu;

include_once EYOOM_CLASS_PATH."/json.class.php";

$json = new Services_JSON();
$output = $json->encode($_value_array);

echo $output;
