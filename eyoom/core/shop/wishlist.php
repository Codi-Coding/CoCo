<?php
if (!defined('_SHOP_')) exit;

if (!$is_member)
	goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL.'/wishlist.php'));

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/wishlist.php');
	return;
}

$g5['title'] = "위시리스트";

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

$sql  = " select a.wi_id, a.wi_time, b.* from {$g5['g5_shop_wish_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) ";
$sql .= " where a.mb_id = '{$member['mb_id']}' order by a.wi_id desc ";
$result = sql_query($sql);
for ($i=0; $row = sql_fetch_array($result); $i++) {
	$out_cd = '';
	$sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' ";
	$tmp = sql_fetch($sql);
	if($tmp['cnt'])
		$out_cd = 'no';
	
	$it_price = get_price($row);
	
	if ($row['it_tel_inq']) $out_cd = 'tel_inq';
	$image = get_it_image($row['it_id'], 200);
	
	$list[$i]['it_id'] = $row['it_id'];
	$list[$i]['it_name'] = $row['it_name'];
	$list[$i]['wi_time'] = $row['wi_time'];
	$list[$i]['wi_id'] = $row['wi_id'];
	$list[$i]['out_cd'] = $out_cd;
	$list[$i]['image'] = $image;
}

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'wishlist.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/wishlist.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');