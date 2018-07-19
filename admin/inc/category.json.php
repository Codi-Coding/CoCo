<?php
include_once('./_common.php');
include_once(EYOOM_PATH.'/common.php');

$cate_a = $_GET['cate_a'];
$cate_b = $_GET['cate_b'];
$cate_c = $_GET['cate_c'];
$cate_d = $_GET['cate_d'];

if ($cate_a) {
	$opt_value = '::중분류::';
	$where = " ca_id like '{$cate_a}%' and length(ca_id) = 4 ";
}
if ($cate_b) {
	$opt_value = '::소분류::';
	$where = " ca_id like '{$cate_b}%' and length(ca_id) = 6 ";
}
if ($cate_c) {
	$opt_value = '::세분류::';
	$where = " ca_id like '{$cate_c}%' and length(ca_id) = 8 ";
}

$sql = "select ca_id, ca_name from {$g5['g5_shop_category_table']} where {$where} order by ca_order, ca_id ";
$res = sql_query($sql);
$list = array();
$list[0] = $opt_value;
for($i=0; $row=sql_fetch_array($res); $i++) {
	$list[$row['ca_id']] = $row['ca_name'];
}

include_once EYOOM_CLASS_PATH."/json.class.php";

$json = new Services_JSON();
$output = $json->encode($list);

echo $output;

?>