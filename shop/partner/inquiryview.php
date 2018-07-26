<?php
include_once('./_common.php');

if($is_guest) {
	alert_close('파트너만 이용가능합니다.');
}

$is_auth = ($is_admin == 'super') ? true : false;
$is_partner = (IS_SELLER) ? true : false;

if($is_auth || $is_partner) {
	; // 통과
} else {
	alert_close('판매자(셀러) 파트너만 이용가능합니다.');
}

$no = apms_escape('no', 0);

if(!$no) {
	alert_close('값이 넘어오지 않았습니다.');
}

$od_id = $no;
$od = sql_fetch("select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ");
if (!$od['od_id']) {
    alert_close('조회하실 주문서가 없습니다.');
}

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
		  where a.od_id = '$od_id' and a.pt_id = '{$member['mb_id']}' and a.ct_select = '1' ";
$sql .= " group by a.it_id ";
$sql .= " order by a.ct_id ";
$result = sql_query($sql);

$cart_count = sql_num_rows($result);

if(!$cart_count) {
    alert_close('조회하실 주문정보가 없습니다.');
}

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
				  and od_id = '$od_id' ";
	$sum = sql_fetch($sql);

	$item[$i] = $row;

	$item[$i]['pt_it'] = apms_pt_it($row['pt_it'],1);

	$item[$i]['it_options'] = print_item_options($row['it_id'], $od_id, $row['pt_msg1'], $row['pt_msg2'], $row['pt_msg3'], '', 1);

	// 배송비
	$sc = sql_fetch(" select * from {$g5['apms_sendcost']} where sc_flag = '1' and od_id = '$od_id' and it_id = '{$row['it_id']}' and pt_id = '{$member['mb_id']}' ");
	if($sc['sc_type']) {
		$sc_type = $sc['sc_type'];
		$sc_price = $sc['sc_price'];
	} else {
		$sc_type = '무료';
		$sc_price = 0;
	}

	$point      = $sum['point'];
	$sell_price = $sum['price'];

	$item[$i]['send'] = $sc_type;
	$item[$i]['sendcost'] = $sc_price;
	$item[$i]['point'] = $point;
	$item[$i]['sell_price'] = $sell_price;
	$item[$i]['qty'] = $sum['qty'];
	$item[$i]['qty'] = $sum['qty'];

	$tot_point      += $point;
	$tot_sell_price += $sell_price;

	if(!in_array($row['pt_it'], $g5['apms_automation'])) {
		$arr_it_orderform[] = $row['it_id'];
	}

} // for 끝

// 자동처리 주문서인지 체크
$is_delivery = false;
if(is_array($arr_it_orderform) && !empty($arr_it_orderform)) {
	$is_delivery = true;
}

$buyer = '';
if($od['mb_id']) {
	$mb = get_member($od['mb_id'], 'mb_nick, mb_email, mb_homepage');
	if($mb['mb_nick']) {
		$buyer = ' ('.get_sideview($od['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['wr_homepage']).')';
	}
}

define('G5_IS_ADMIN', true);

$g5['title'] = '주문서';
include_once(G5_PATH.'/head.sub.php');
include_once($skin_path.'/inquiryview.skin.php');
include_once(G5_PATH.'/tail.sub.php');
?>