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

	$sql = " select *, SUBSTRING(pt_datetime,1,4) as sale_date from {$g5['g5_shop_cart_table']} where ct_status = '완료' and pt_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,4) between '$fr_day' and '$to_day'	order by pt_datetime desc ";

} else if($type == 'month') {
	$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2", $fr_date);
	$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2", $to_date);

	$sql = " select *, SUBSTRING(pt_datetime,1,7) as sale_date from {$g5['g5_shop_cart_table']} where ct_status = '완료' and pt_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,7) between '$fr_day' and '$to_day'	order by pt_datetime desc ";

} else {
	$is_week = true;
	$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
	$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);

	$sql = " select *, SUBSTRING(pt_datetime,1,10) as sale_date from {$g5['g5_shop_cart_table']} where ct_status = '완료' and pt_id = '{$member['mb_id']}' and ct_select = '1' and SUBSTRING(pt_datetime,1,10) between '$fr_day' and '$to_day'	order by pt_datetime desc ";
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
	$netsale = $row['pt_sale'] - $row['pt_commission'] - $row['pt_point'] + $row['pt_incentive'];
	$save['count']++;
	$save['sale']    += $row['pt_sale'];
	$save['qty']    += $row['ct_qty'];
	$save['commission']   += $row['pt_commission'];
	$save['point']   += $row['pt_point'];
	$save['incentive']   += $row['pt_incentive'];
	$save['netsale']   += $netsale;
	$save['net']   += $row['pt_net'];
	$save['vat']   += ($netsale - $row['pt_net']);

	$tot['count']++;
	$tot['sale']    += $row['pt_sale'];
	$tot['qty']    += $row['ct_qty'];
	$tot['commission']   += $row['pt_commission'];
	$tot['point']   += $row['pt_point'];
	$tot['incentive']   += $row['pt_incentive'];
	$tot['netsale']   += $netsale;
	$tot['net']   += $row['pt_net'];
	$tot['vat']   += ($netsale - $row['pt_net']);
}

if($i > 0) {
	$list[$z] = $save;
	$y = date('w', strtotime($list[$z]['date'].' 00:00:01'));
	$list[$z]['yoil'] = $yoil[$y];
	if($is_week) {
		$list[$z]['date'] = $list[$z]['date'].'('.$list[$z]['yoil'].')';
	}
}

include_once($skin_path.'/salelist.skin.php');

?>
