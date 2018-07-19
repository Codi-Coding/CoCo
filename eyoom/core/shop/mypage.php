<?php
if (!defined('_SHOP_')) exit;

if (!$is_member)
	goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/mypage.php');
	return;
}

$g5['title'] = $member['mb_name'].'님 쇼핑몰 마이페이지';

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

// 쿠폰
$cp_count = 0;
$sql = " select cp_id
			from {$g5['g5_shop_coupon_table']}
			where mb_id IN ( '{$member['mb_id']}', '전체회원' )
				and cp_start <= '".G5_TIME_YMD."'
				and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
	if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
		$cp_count++;
}

// 최근 주문내역
define("_ORDERINQUIRY_", true);
$limit = " limit 0, 5 ";
@include_once(EYOOM_SHOP_PATH.'/orderinquiry.sub.php');

// 최근 위시리스트
$sql = " select *
			from {$g5['g5_shop_wish_table']} a,
				{$g5['g5_shop_item_table']} b
			where a.mb_id = '{$member['mb_id']}'
				and a.it_id  = b.it_id
			order by a.wi_id desc
			limit 0, 3 ";
$result = sql_query($sql);
for ($i=0; $row = sql_fetch_array($result); $i++)
{
	$image = get_it_image($row['it_id'], 200);
	$wishlist[$i]['image'] = $image;
	$wishlist[$i]['it_id'] = $row['it_id'];
	$wishlist[$i]['it_name'] = $row['it_name'];
	$wishlist[$i]['wi_time'] = $row['wi_time'];
}

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'mypage.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/mypage.php');

$tpl->assign(array(
	'wishlist' => $wishlist,
));
// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');