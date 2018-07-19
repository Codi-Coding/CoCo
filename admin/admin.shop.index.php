<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

@include_once(EYOOM_ADMIN_INC_PATH.'/shop.lib.php');

// 처리할 주문
$od_status = array('주문', '입금', '준비', '배송');
foreach($od_status as $status) {
	$order_status[$status] = get_order_status_sum($status);
	$order_status[$status]['href'] = EYOOM_ADMIN_URL . "/?dir=shop&amp;pid=orderlist&amp;od_status={$status}";
}

// 상품문의
$sql = " select * from {$g5['g5_shop_item_qa_table']} where (1) order by iq_id desc limit 5 ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
    $row1 = sql_fetch($sql1);

    $item_qa[$i] = $row;
    $item_qa[$i]['name'] = get_sideview($row['mb_id'], get_text($row['iq_name']), $row1['mb_email'], $row1['mb_homepage']);
}

// 사용후기
$sql = " select * from {$g5['g5_shop_item_use_table']} where (1) order by is_id desc limit 3 ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
    $row1 = sql_fetch($sql1);
    
    $item_use[$i] = $row;
    $item_use[$i]['name'] = get_sideview($row['mb_id'], get_text($row['is_name']), $row1['mb_email'], $row1['mb_homepage']);
}

// 1:1문의
$sql = " select * from {$g5['qa_content_table']} where (1) and qa_type = '0' order by qa_num limit 3 ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
    $row1 = sql_fetch($sql1);

    $qa_conts[$i] = $row;
    $qa_conts[$i]['name'] = get_sideview($row['mb_id'], get_text($row['qa_name']), $row1['mb_email'], $row1['mb_homepage']);
}

// 지난주 주문현황
$last_arr_order = array();
$last_x_val = array();
for($i=12; $i>=6; $i--) {
    $date = date('Y-m-d', strtotime('-'.$i.' days', G5_SERVER_TIME));

    $last_x_val[] = $date;
    $last_arr_order[] = get_order_date_sum($date);
}

// 이번주 주문현황
$arr_order = array();
$x_val = array();
for($i=6; $i>=0; $i--) {
    $date = date('Y-m-d', strtotime('-'.$i.' days', G5_SERVER_TIME));

    $x_val[] = $date;
    $arr_order[] = get_order_date_sum($date);
}

// 올해 월별 매출현황
$this_year = date('Y');
$this_ord_info = get_year_order_info($this_year);
foreach($this_ord_info as $key => $od_info) {
	${$key} = $od_info;
}
ksort($receiptbank);
ksort($receiptvbank);
ksort($receiptiche);
ksort($receiptcard);
ksort($receipteasy);
ksort($receiptkakao);
ksort($receipthp);
ksort($ordercoupon);
ksort($receiptpoint);
ksort($ordercancel);

// 작년 월별 매출현황
$last_year = date('Y') - 1;
$last_ord_info = get_year_order_info($last_year);
foreach($last_ord_info as $key => $od_info) {
	${'last_'.$key} = $od_info;
}
ksort($last_receiptbank);
ksort($last_receiptvbank);
ksort($last_receiptiche);
ksort($last_receiptcard);
ksort($last_receipteasy);
ksort($last_receiptkakao);
ksort($last_receipthp);
ksort($last_ordercoupon);
ksort($last_receiptpoint);
ksort($last_ordercancel);

// 결제수단별 주문현황
$term = 3;
$info = array();
$info_key = array();
$j = 0;
for($i=($term - 1); $i>=0; $i--) {
    $date = date("Y-m-d", strtotime('-'.$i.' days', G5_SERVER_TIME));
    $info[$date] = get_order_settle_sum($date);

    $day = substr($date, 5, 5).' ('.get_yoil($date).')';
    $info_key[] = $date;
    $od_pg_thead[$j]['day'] = $day;
    $j++;
}
$pg_case = array('신용카드', '계좌이체', '가상계좌', '무통장', '휴대폰', '포인트', '쿠폰', '간편결제', 'KAKAOPAY');
$k =0;
foreach($pg_case as $val) {
	$val_cnt ++;
	$pg_info[$k]['cnt'] 	= $val_cnt;
	$pg_info[$k]['method'] 	= $val;
	$inloop = &$pg_info[$k]['info'];
	
	$j=0;
	foreach($info_key as $date) {
		$inloop[$j]['count'] = $info[$date][$val]['count'];
		$inloop[$j]['price'] = $info[$date][$val]['price'];
		$j++;
	}
	$k++;
}

$atpl->assign(array(
	'x_val'				=> $x_val,
	'last_x_val'		=> $last_x_val,
	'arr_order'			=> $arr_order,
	'last_arr_order'	=> $last_arr_order,
	'order_status'		=> $order_status,
	'item_qa'			=> $item_qa,
	'item_use'			=> $item_use,
	'qa_conts'			=> $qa_conts,
	'od_pg_thead'		=> $od_pg_thead,
	'pg_info'			=> $pg_info,
	'tot'				=> $tot,
	'receiptbank'		=> $receiptbank,
	'receiptvbank'		=> $receiptvbank,
	'receiptiche'		=> $receiptiche,
	'receiptcard'		=> $receiptcard,
	'receipteasy'		=> $receipteasy,
	'receiptkakao'		=> $receiptkakao,
	'receipthp'			=> $receipthp,
	'ordercoupon'		=> $ordercoupon,
	'receiptpoint'		=> $receiptpoint,
	'ordercancel'		=> $ordercancel,
	'last_tot'			=> $last_tot,
	'last_receiptbank'	=> $last_receiptbank,
	'last_receiptvbank'	=> $last_receiptvbank,
	'last_receiptiche'	=> $last_receiptiche,
	'last_receiptcard'	=> $last_receiptcard,
	'last_receipteasy'	=> $last_receipteasy,
	'last_receiptkakao'	=> $last_receiptkakao,
	'last_receipthp'	=> $last_receipthp,
	'last_ordercoupon'	=> $last_ordercoupon,
	'last_receiptpoint'	=> $last_receiptpoint,
	'last_ordercancel'	=> $last_ordercancel,
));