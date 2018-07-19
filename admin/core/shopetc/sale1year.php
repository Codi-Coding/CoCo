<?php
$sub_menu = '500110';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$fr_year = preg_replace('/[^0-9]/i', '', $fr_year);
$to_year = preg_replace('/[^0-9]/i', '', $to_year);

$sql = " select od_id,
                SUBSTRING(od_time,1,4) as od_date,
                od_send_cost,
                od_settle_case,
                od_receipt_price,
                od_receipt_point,
                od_cart_price,
                od_cancel_price,
                od_misu,
                (od_cart_price + od_send_cost + od_send_cost2) as orderprice,
                (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           from {$g5['g5_shop_order_table']}
          where SUBSTRING(od_time,1,4) between '$fr_year' and '$to_year'
          order by od_time desc ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$date = $row['od_date'];
    $sale_data[$date][$i] = $row;
}

foreach($sale_data as $od_date => $data) {
	$sale_info = get_sale_info($data);
	
	$sale_list[$i]['od_date'] = $od_date;
	$sale_list[$i]['save'] = $sale_info['save'];
	$sale_list[$i]['count'] = $sale_info['count'];
	$i++;
}

function get_sale_info($row_array) {
	global $tot;
	foreach($row_array as $k => $row) {
        $save['orderprice']    += $row['orderprice'];
        $save['ordercancel']   += $row['od_cancel_price'];
        $save['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == '무통장')
            $save['receiptbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $save['receiptvbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $save['receiptiche']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $save['receipthp']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $save['receiptcard']   += $row['od_receipt_price'];
        $save['receiptpoint']  += $row['od_receipt_point'];
        $save['misu']          += $row['od_misu'];

        $tot['ordercount']++;
        $tot['orderprice']    += $row['orderprice'];
        $tot['ordercancel']   += $row['od_cancel_price'];
        $tot['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == '무통장')
            $tot['receiptbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $tot['receiptvbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $tot['receiptiche']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $tot['receipthp']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $tot['receiptcard']   += $row['od_receipt_price'];
        $tot['receiptpoint']  += $row['od_receipt_point'];
        $tot['misu']          += $row['od_misu'];
	}
	
	$output['save'] = $save;
	$output['count'] = count($row_array);
	
	return $output;
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'sale_list' => $sale_list,
	'total_list' => $tot,
));