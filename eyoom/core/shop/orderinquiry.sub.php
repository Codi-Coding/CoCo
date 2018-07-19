<?php
if (!defined('_SHOP_')) exit;
if (!defined("_GNUBOARD_")) exit;
if (!defined("_ORDERINQUIRY_")) exit;

$sql = " select *
			from {$g5['g5_shop_order_table']}
			where mb_id = '{$member['mb_id']}'
			order by od_id desc
			$limit ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);
	
	switch($row['od_status']) {
		case '주문':
			$od_status = '입금확인중';
			break;
		case '입금':
			$od_status = '입금완료';
			break;
		case '준비':
			$od_status = '상품준비중';
			break;
		case '배송':
			$od_status = '상품배송';
			break;
		case '완료':
			$od_status = '배송완료';
			break;
		default:
			$od_status = '주문취소';
			break;
	}
	$list[$i]['ct_id'] = $row['ct_id'];
	$list[$i]['od_id'] = $row['od_id'];
	$list[$i]['od_time'] = $row['od_time'];
	$list[$i]['od_cart_count'] = $row['od_cart_count'];
	$list[$i]['od_receipt_price'] = $row['od_receipt_price'];
	$list[$i]['od_misu'] = $row['od_misu'];
	$list[$i]['od_price'] = $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'];
	$list[$i]['href'] = G5_SHOP_URL.'/orderinquiryview.php?od_id='.$row['od_id'].'&amp;uid='.$uid;
	$list[$i]['od_status'] = $od_status;
}

$tpl->define(array(
	'orderinquiry_sub_pc'	=> 'skin_pc/shop/' . $eyoom['shop_skin'] . '/orderinquiry.sub.skin.html',
	'orderinquiry_sub_mo'	=> 'skin_mo/shop/' . $eyoom['shop_skin'] . '/orderinquiry.sub.skin.html',
	'orderinquiry_sub_bs'	=> 'skin_bs/shop/' . $eyoom['shop_skin'] . '/orderinquiry.sub.skin.html',
));