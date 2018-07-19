<?php
include_once('./_common.php');
include_once(G5_SHOP_PATH.'/settle_naverpay.inc.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/cart.php');
    return;
}

// 보관기간이 지난 상품 삭제
cart_item_clean();

// cart id 설정
set_cart_id($sw_direct);

$s_cart_id = get_session('ss_cart_id');
// 선택필드 초기화
$sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ";
sql_query($sql);

// Page ID
$pid = ($pid) ? $pid : 'cart';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$skin_row = array();
$skin_row = apms_rows('order_'.MOBILE_.'skin, order_'.MOBILE_.'set');
$order_skin_path = G5_SKIN_PATH.'/apms/order/'.$skin_row['order_'.MOBILE_.'skin'];
$order_skin_url = G5_SKIN_URL.'/apms/order/'.$skin_row['order_'.MOBILE_.'skin'];

// 스킨 체크
list($order_skin_path, $order_skin_url) = apms_skin_thema('shop/order', $order_skin_path, $order_skin_url); 

// 설정값 불러오기
$is_cart_sub = false;
@include_once($order_skin_path.'/config.skin.php');

$g5['title'] = '장바구니';

if($is_cart_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

// 스킨설정
$wset = array();
if($skin_row['order_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['order_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$skin_path = $order_skin_path;
$skin_url = $order_skin_url;

$action_url = G5_SHOP_URL.'/cartupdate.php';

$tot_point = 0;
$tot_sell_price = 0;

// $s_cart_id 로 현재 장바구니 자료 쿼리
$sql = " select a.ct_id,
				a.it_id,
				a.it_name,
				a.ct_price,
				a.ct_point,
				a.ct_qty,
				a.ct_status,
				a.ct_send_cost,
				a.it_sc_type,
				b.ca_id,
				b.ca_id2,
				b.ca_id3,
				b.pt_it,
				b.pt_msg1,
				b.pt_msg2,
				b.pt_msg3
		   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
		  where a.od_id = '$s_cart_id' ";
$sql .= " group by a.it_id ";
$sql .= " order by a.ct_id ";
$result = sql_query($sql);

$cart_count = sql_num_rows($result);

$it_send_cost = 0;

$item = array();

for ($i=0; $row=sql_fetch_array($result); $i++)
{
	// 합계금액 계산
	$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
					SUM(ct_point * ct_qty) as point,
					SUM(ct_qty) as qty
				from {$g5['g5_shop_cart_table']}
				where it_id = '{$row['it_id']}'
				  and od_id = '$s_cart_id' ";
	$sum = sql_fetch($sql);

	$item[$i] = $row;

	$item[$i]['pt_it'] = apms_pt_it($row['pt_it'],1);

	if ($i==0) { // 계속쇼핑
		$continue_ca_id = $row['ca_id'];
	}

	$item[$i]['it_options'] = print_item_options($row['it_id'], $s_cart_id, $row['pt_msg1'], $row['pt_msg2'], $row['pt_msg3']);

	// 배송비
	switch($row['ct_send_cost'])
	{
		case 1:
			$ct_send_cost = '착불';
			break;
		case 2:
			$ct_send_cost = '무료';
			break;
		default:
			$ct_send_cost = '선불';
			break;
	}

	// 조건부무료
	if($row['it_sc_type'] == 2) {
		$sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

		if($sendcost == 0)
			$ct_send_cost = '무료';
	}

	$point      = $sum['point'];
	$sell_price = $sum['price'];

	$item[$i]['ct_send_cost'] = $ct_send_cost;
	$item[$i]['point'] = $point;
	$item[$i]['sell_price'] = $sell_price;
	$item[$i]['qty'] = $sum['qty'];

	$tot_point      += $point;
	$tot_sell_price += $sell_price;

} // for 끝

// 배송비 계산
if ($i > 0) {
	$send_cost = get_sendcost($s_cart_id, 0);
}

// 총계 = 주문상품금액합계 + 배송비
$tot_price = $tot_sell_price + $send_cost; 

// 셋업
$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=order&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/cart.skin.php');

if($is_cart_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>