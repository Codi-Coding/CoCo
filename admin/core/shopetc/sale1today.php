<?php
$sub_menu = '500110';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$date = preg_replace('/[^0-9]/i', '', $date);

$date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $date);

$sql = " select od_id,
                mb_id,
                od_name,
                od_settle_case,
                od_cart_price,
                od_receipt_price,
                od_receipt_point,
                od_cancel_price,
                od_misu,
                (od_cart_price + od_send_cost + od_send_cost2) as orderprice,
                (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           from {$g5['g5_shop_order_table']}
          where SUBSTRING(od_time,1,10) = '$date'
          order by od_id desc ";
$result = sql_query($sql);

unset($tot);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    if ($row['mb_id'] == '') { // 비회원일 경우는 주문자로 링크
        $href = EYOOM_ADMOIN_URL."/?dir=shop&amp;pid=orderlist&amp;sel_field=od_name&amp;search=".$row['od_name'];
    } else { // 회원일 경우는 회원아이디로 링크
        $href = EYOOM_ADMOIN_URL."/?dir=shop&amp;pid=orderlist&amp;sel_field=mb_id&amp;search=".$row['mb_id'];
    }

    $receipt_bank = $receipt_card = $receipt_vbank = $receipt_iche = $receipt_hp = 0;
    if($row['od_settle_case'] == '무통장')
        $receipt_bank = $row['od_receipt_price'];
    if($row['od_settle_case'] == '가상계좌')
        $receipt_vbank = $row['od_receipt_price'];
    if($row['od_settle_case'] == '계좌이체')
        $receipt_iche = $row['od_receipt_price'];
    if($row['od_settle_case'] == '휴대폰')
        $receipt_hp = $row['od_receipt_price'];
    if($row['od_settle_case'] == '신용카드')
        $receipt_card = $row['od_receipt_price'];
        
    $sale_list[$i] = $row;
    $sale_list[$i]['href'] = $href;
    $sale_list[$i]['receipt_bank'] = $receipt_bank;
    $sale_list[$i]['receipt_card'] = $receipt_card;
    $sale_list[$i]['receipt_vbank'] = $receipt_vbank;
    $sale_list[$i]['receipt_iche'] = $receipt_iche;
    $sale_list[$i]['receipt_hp'] = $receipt_hp;
        
    $tot['orderprice']    += $row['orderprice'];
    $tot['ordercancel']   += $row['od_cancel_price'];
    $tot['coupon']        += $row['couponprice'] ;
    $tot['receipt_bank']  += $receipt_bank;
    $tot['receipt_vbank'] += $receipt_vbank;
    $tot['receipt_iche']  += $receipt_iche;
    $tot['receipt_card']  += $receipt_card;
    $tot['receipt_hp']    += $receipt_hp;
    $tot['receipt_point'] += $row['od_receipt_point'];
    $tot['misu']          += $row['od_misu'];
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'sale_list' => $sale_list,
	'total_list' => $tot,
));