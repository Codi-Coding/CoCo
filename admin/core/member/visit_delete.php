<?php
$sub_menu = "200820";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

$action_url = EYOOM_ADMIN_URL . '/?dir=member&amp;pid=visit_delete_update&amp;smode=1';

// 최소년도 구함
$sql = " select min(vi_date) as min_date from {$g5['visit_table']} ";
$row = sql_fetch($sql);

$min_year = (int)substr($row['min_date'], 0, 4);
$now_year = (int)substr(G5_TIME_YMD, 0, 4);

for($year=$min_year; $year<=$now_year; $year++) {
	$yearinfo[$i]['year'] = $year; 
}

for($i=1; $i<=12; $i++) {
	$monthinfo[$i]['month'] = $i;	
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=member&amp;pid=mail_list&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'yearinfo' => $yearinfo,
	'monthinfo' => $monthinfo,
));