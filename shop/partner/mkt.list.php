<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$list = array();

$fr_date = ($fr_date) ? $fr_date : date("Ym01", G5_SERVER_TIME);
$to_date = ($to_date) ? $to_date : date("Ymd", G5_SERVER_TIME);

unset($save);
unset($tot);

$yoil = array("일","월","화","수","목","금","토");
$is_week = false;
if($type == 'year') {
	$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1", $fr_date);
	$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1", $to_date);

	$sql = " select *, SUBSTRING(pt_datetime,1,4) as sale_date from {$g5['g5_shop_cart_table']} where ct_status = '완료' and mk_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,4) between '$fr_day' and '$to_day'	order by pt_datetime desc ";

} else if($type == 'month') {
	$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2", $fr_date);
	$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2", $to_date);

	$sql = " select *, SUBSTRING(pt_datetime,1,7) as sale_date from {$g5['g5_shop_cart_table']} where ct_status = '완료' and mk_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,7) between '$fr_day' and '$to_day'	order by pt_datetime desc ";

} else {
	$is_week = true;
	$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
	$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);

	$sql = " select *, SUBSTRING(pt_datetime,1,10) as sale_date from {$g5['g5_shop_cart_table']} where ct_status = '완료' and mk_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,10) between '$fr_day' and '$to_day'	order by pt_datetime desc ";
}

$z = 0;
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {

	if ($i == 0) {
		$save['date'] = $row['sale_date'];
	}

	if ($save['date'] != $row['sale_date']) {
		$list[$z] = $save;
		$y = date('w', strtotime($list[$z]['date'].' 00:00:01'));
		$list[$z]['yoil'] = $yoil[$y];
		if($is_week) {
			$list[$z]['date'] = $list[$z]['date'].'('.$list[$z]['yoil'].')';
		}
		$z++;
		unset($save);
		$save['date'] = $row['sale_date'];
	}

	// 매출
	$sale = $row['ct_price'] * $row['ct_qty'];
	if($row['ct_notax']) {
		$net = $sale;
	} else {
		list($net) = apms_vat($sale);
	}
	$save['count']++;
	$save['sale']    += $sale;
	$save['net']    += $net;
	$save['qty']    += $row['ct_qty'];
	$save['profit']   += $row['mk_profit'];
	$save['benefit']   += $row['mk_benefit'];
	$save['total']   += ($row['mk_profit'] + $row['mk_benefit']);

	$tot['count']++;
	$tot['sale']    += $sale;
	$tot['net']    += $net;
	$tot['qty']    += $row['ct_qty'];
	$tot['profit']   += $row['mk_profit'];
	$tot['benefit']   += $row['mk_benefit'];
	$tot['total']   += ($row['mk_profit'] + $row['mk_benefit']);
}

if($i > 0) {
	$list[$z] = $save;
	$y = date('w', strtotime($list[$z]['date'].' 00:00:01'));
	$list[$z]['yoil'] = $yoil[$y];
	if($is_week) {
		$list[$z]['date'] = $list[$z]['date'].'('.$list[$z]['yoil'].')';
	}
}

include_once($skin_path.'/mkt.list.skin.php');

?>
