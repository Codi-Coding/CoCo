<?php
if (!defined('_GNUBOARD_')) exit;

$g5['title'] = $member['mb_nick'].' 님의 '.$levelset['gnu_name'].' 내역';
$sum_point1 = $sum_point2 = $sum_point3 = 0;

$sql = " select * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$point1 = $point2 = 0;
	if ($row['po_point'] > 0) {
		$point1 = '+' .number_format($row['po_point']);
		$sum_point1 += $row['po_point'];
	} else {
		$point2 = number_format($row['po_point']);
		$sum_point2 += $row['po_point'];
	}

	$expr = '';
	if($row['po_expired'] == 1)
		$expr = ' txt_expired';
	$row['expr'] = $expr;
	$row['point1'] = $point1;
	$row['point2'] = $point2;

	$list[$i] = $row;
}

if (count($list)>0) {
	if ($sum_point1 > 0) $sum_point1 = "+" . number_format($sum_point1);
	$sum_point2 = number_format($sum_point2);
}

// Paging 
$paging = $thema->pg_pages($tpl_name,$_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/point.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'point.skin.html');

$tpl->assign(array(
	'levelset'	=>	$levelset,
));

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);