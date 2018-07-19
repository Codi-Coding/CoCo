<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/coupon.php');
    return;
}

if ($is_guest)
    alert_close('회원만 조회하실 수 있습니다.');

$pid = ($pid) ? $pid : ''; // Page ID
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_coupon_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = $member['mb_nick'].'님의 쿠폰 내역';

if($is_coupon_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

$sql = " select cp_id, cp_subject, cp_method, cp_target, cp_start, cp_end, cp_type, cp_price
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."'
            order by cp_no ";
$result = sql_query($sql);

$cp = array();

$k = 0;
for($i=0; $row=sql_fetch_array($result); $i++) {
	if(is_used_coupon($member['mb_id'], $row['cp_id']))
		continue;

	$cp_href = '';
	if($row['cp_method'] == 1) {
		$sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
		$ca = sql_fetch($sql);
		$cp_target = $ca['ca_name'].'의 상품할인';
		$cp_href = G5_SHOP_URL.'/list.php?ca_id='.$row['cp_target'];
	} else if($row['cp_method'] == 2) {
		$cp_target = '결제금액 할인';
	} else if($row['cp_method'] == 3) {
		$cp_target = '배송비 할인';
	} else {
		$sql = " select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['cp_target']}' ";
		$it = sql_fetch($sql);
		$cp_target = $it['it_name'].' 상품할인';
		$cp_href = G5_SHOP_URL.'/item.php?it_id='.$row['cp_target'];
	}

	if($row['cp_type'])
		$cp_price = $row['cp_price'].'%';
	else
		$cp_price = number_format($row['cp_price']).'원';

	$cp[$k] = $row;
	$cp[$k]['cp_href'] = $cp_href;
	$cp[$k]['cp_target'] = $cp_target;
	$cp[$k]['cp_price'] = $cp_price;

	$k++;
}

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

include_once($skin_path.'/coupon.skin.php');

if($is_coupon_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>