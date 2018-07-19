<?php
if (!defined('_SHOP_')) exit;

if($is_guest)
	exit;

$price = $_POST['price'];
$send_cost = $_POST['send_cost'];

// 쿠폰정보
$sql = " select *
			from {$g5['g5_shop_coupon_table']}
			where mb_id IN ( '{$member['mb_id']}', '전체회원' )
				and cp_method = '3'
				and cp_start <= '".G5_TIME_YMD."'
				and cp_end >= '".G5_TIME_YMD."'
				and cp_minimum <= '$price' ";
$result = sql_query($sql);
$count = sql_num_rows($result);

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'ordersendcostcoupon.skin.html');

for($i=0; $row=sql_fetch_array($result); $i++) {
	// 사용한 쿠폰인지 체크
	if(is_used_coupon($member['mb_id'], $row['cp_id']))
		continue;
	
	$dc = 0;
	if($row['cp_type']) {
		$dc = floor(($send_cost * ($row['cp_price'] / 100)) / $row['cp_trunc']) * $row['cp_trunc'];
	} else {
		$dc = $row['cp_price'];
	}
	
	if($row['cp_maximum'] && $dc > $row['cp_maximum'])
		$dc = $row['cp_maximum'];
	
	if($dc > $send_cost)
		$dc = $send_cost;
	
	$list[$i]['cp_id'] = $row['cp_id'];
	$list[$i]['cp_subject'] = $row['cp_subject'];
	$list[$i]['dc'] = $dc;
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/ordersendcostcoupon.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);