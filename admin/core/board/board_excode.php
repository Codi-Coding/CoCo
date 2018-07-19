<?php
$sub_menu = "300100";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$ex_no = clean_xss_tags(trim($_GET['ex_no']));

if (!$board || !$ex_no) alert("잘못된 접근입니다.");

// 확장필드의 정보 가져오기
$exinfo = sql_fetch("select * from {$g5['eyoom_exboard']} where (1) and ex_no = '{$ex_no}' and bo_table = '{$board['bo_table']}' ");

if ($exinfo['ex_item_value']) {
	$exitem = explode('|', $exinfo['ex_item_value']);
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'exinfo' => $exinfo,
	'exitem' => $exitem,
));