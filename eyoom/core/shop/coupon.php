<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/coupon.php');
	return;
}

if ($is_guest)
	alert_close('회원만 조회하실 수 있습니다.');
	
$g5['title'] = $member['mb_nick'].' 님의 쿠폰 내역';

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

$sql = " select cp_id, cp_subject, cp_method, cp_target, cp_start, cp_end, cp_type, cp_price
			from {$g5['g5_shop_coupon_table']}
			where mb_id IN ( '{$member['mb_id']}', '전체회원' )
				and cp_start <= '".G5_TIME_YMD."'
				and cp_end >= '".G5_TIME_YMD."'
			order by cp_no ";
$result = sql_query($sql);

for($i=0; $row=sql_fetch_array($result); $i++) {
	if(is_used_coupon($member['mb_id'], $row['cp_id']))
		continue;
		
	if($row['cp_method'] == 1) {
		$sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
		$ca = sql_fetch($sql);
		$cp_target = $ca['ca_name'].'의 상품할인';
	} else if($row['cp_method'] == 2) {
		$cp_target = '결제금액 할인';
	} else if($row['cp_method'] == 3) {
		$cp_target = '배송비 할인';
	} else {
		$sql = " select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['cp_target']}' ";
		$it = sql_fetch($sql);
		$cp_target = "<a href='" . G5_SHOP_URL . "/item.php?it_id={$row['cp_target']}' target='_top'>{$it['it_name']} 상품할인</a>";
	}
	
	if($row['cp_type'])
		$cp_price = $row['cp_price'].'%';
	else
		$cp_price = number_format($row['cp_price']).'원';
		
	$list[$i]['cp_subject'] = $row['cp_subject'];
	$list[$i]['cp_start'] = $row['cp_start'];
	$list[$i]['cp_end'] = $row['cp_end'];
	$list[$i]['cp_target'] = $cp_target;
	$list[$i]['cp_price'] = $cp_price;
}

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'coupon.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/coupon.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

include_once(G5_PATH.'/tail.sub.php');