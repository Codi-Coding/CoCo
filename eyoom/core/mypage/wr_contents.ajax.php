<?php
$g5_path = '../../..';
include_once($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

if(!$is_member) exit;

$bo_table = $_POST['bo_table'];
$wr_id = $_POST['wr_id'];
if(!$bo_table) exit;
if(!$wr_id) exit;

$tocken = false;
$write_table = $g5['write_prefix'] . $bo_table;
$sql = "select wr_content,wr_option from {$write_table} where wr_id = '{$wr_id}' limit 1";
$data = sql_fetch($sql, false);
if($data) {
	$html = 0;
	if (strstr($data['wr_option'], 'html1'))
		$html = 1;
	else if (strstr($data['wr_option'], 'html2'))
		$html = 2;

	$content = conv_content($data['wr_content'], $html);
	$wr_content = preg_replace("/<img([^>]*)>/iS","",get_view_thumbnail($content));
	$wr_content = preg_replace("/<embed([^>]*)>/iS","",$wr_content);
	$wr_content = preg_replace("/<object([^>]*)>/iS","",$wr_content);
	$tocken = true;
}

if($tocken) {
	$_value_array = array();
	$_value_array['content'] = $wr_content;

	include_once "../../classes/json.class.php";

	$json = new Services_JSON();
	$output = $json->encode($_value_array);

	echo $output;
}
exit;