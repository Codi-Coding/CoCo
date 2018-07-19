<?php
$sub_menu = '800300';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

$theme 	= clean_xss_tags(trim($_POST['theme']));
$type 	= clean_xss_tags(trim($_POST['type']));
if(!$theme) exit;
if(!$type) exit;

switch($type) {
	case 'group':
		$sql = "select gr_id, gr_subject from {$g5['group_table']} where (1) order by gr_subject asc";
		$res = sql_query($sql,false);
		for($i=0;$row=sql_fetch_array($res);$i++) {
			$page_id[$i] = $row['gr_id'];
			$name[$i] = $row['gr_subject'];
		}
		break;

	case 'board':
		$sql = "select a.bo_table, a.bo_subject, b.gr_subject from {$g5['board_table']} as a left join {$g5['group_table']} as b on a.gr_id=b.gr_id where 1 order by b.gr_id asc";
		$res = sql_query($sql,false);
		for($i=0;$row=sql_fetch_array($res);$i++) {
			$page_id[$i] = $row['bo_table'];
			$name[$i] = $row['gr_subject'].' > '.$row['bo_subject'];
		}
		break;

	case 'page':
		$sql = "select co_id, co_subject from {$g5['content_table']} where (1) order by co_subject asc";
		$res = sql_query($sql,false);
		for($i=0;$row=sql_fetch_array($res);$i++) {
			$page_id[$i] = $row['co_id'];
			$name[$i] = $row['co_subject'];
		}
		break;
		
	case 'shop':
		$sql = "select ca_id, ca_name from {$g5['g5_shop_category_table']} where (1) order by ca_id asc";
		$res = sql_query($sql,false);
		for($i=0;$row=sql_fetch_array($res);$i++) {
			$page_id[$i] = $row['ca_id'];
			$name[$i] = $row['ca_name'];
		}
		break;
}

$_value_array = array();
$_value_array['pid'] = implode('|',$page_id);
$_value_array['name'] = implode('|',$name);

include_once EYOOM_CLASS_PATH."/json.class.php";

$json = new Services_JSON();
$output = $json->encode($_value_array);

echo $output;

?>