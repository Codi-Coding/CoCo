<?php
if (!defined('_SHOP_')) exit;

include_once(G5_SHOP_PATH.'/settle_naverpay.inc.php');

// 보관기간이 지난 상품 삭제
cart_item_clean();

// cart id 설정
set_cart_id($sw_direct);

$s_cart_id = get_session('ss_cart_id');
// 선택필드 초기화
$sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ";
sql_query($sql);

$cart_action_url = G5_SHOP_URL.'/cartupdate.php';

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/cart.php');
	return;
}

$g5['title'] = "장바구니";

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 헤더 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

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
			b.ca_id3
		from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
		where a.od_id = '$s_cart_id' ";
$sql .= " group by a.it_id ";
$sql .= " order by a.ct_id ";
$result = sql_query($sql);
$it_send_cost = 0;
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
	
	if ($i==0) { // 계속쇼핑
		$continue_ca_id = $row['ca_id'];
	}
	$image = get_it_image($row['it_id'], 200);
	$it_options = print_item_options($row['it_id'], $s_cart_id);
	
	// 배송비
	switch($row['ct_send_cost']) {
		case 1: $ct_send_cost = '착불'; break;
		case 2: $ct_send_cost = '무료'; break;
		default: $ct_send_cost = '선불'; break;
	}
	
	// 조건부무료
	if($row['it_sc_type'] == 2) {
		$sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);
		if($sendcost == 0) $ct_send_cost = '무료';
	}
	
	$point      = $sum['point'];
	$sell_price = $sum['price'];
	$list[$i]['image'] = $image;
	$list[$i]['it_id'] = $row['it_id'];
	$list[$i]['it_name'] = get_text($row['it_name']);
	$list[$i]['ct_price'] = $row['ct_price'];
	$list[$i]['it_options'] = $it_options;
	$list[$i]['mod_options'] = $mod_options;
	$list[$i]['sell_price'] = $sell_price;
	$list[$i]['point'] = $point;
	$list[$i]['ct_send_cost'] = $ct_send_cost;
	$list[$i]['sum_qty'] = $sum['qty'];
	
	$tot_point      += $point;
	$tot_sell_price += $sell_price;
}
$count = count($list);

// 배송비 계산
if($count>0) {
	$send_cost = get_sendcost($s_cart_id, 0);
}

// 총계 = 주문상품금액합계 + 배송비
$tot_price = $tot_sell_price + $send_cost;

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'cart.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/cart.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');