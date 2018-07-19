<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/ordercoupon.php');
    return;
}

if($is_guest)
    exit;

$price = (int)preg_replace('#[^0-9]#', '', $_POST['price']);

if($price <= 0)
    die('상품금액이 0원이므로 쿠폰을 사용할 수 없습니다.');

$list = array();

// 쿠폰정보
$sql = " select *
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_method = '2'
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."'
              and cp_minimum <= '$price' ";
$result = sql_query($sql);
$count = sql_num_rows($result);
$z = 0;
for($i=0; $row=sql_fetch_array($result); $i++) {
	// 사용한 쿠폰인지 체크
	if(is_used_coupon($member['mb_id'], $row['cp_id']))
		continue;

	$list[$z] = $row;

	$dc = 0;
	if($row['cp_type']) {
		$dc = floor(($price * ($row['cp_price'] / 100)) / $row['cp_trunc']) * $row['cp_trunc'];
	} else {
		$dc = $row['cp_price'];
	}

	if($row['cp_maximum'] && $dc > $row['cp_maximum'])
		$dc = $row['cp_maximum'];

	$list[$z]['dc'] = $dc;

	$z++;
}

$is_coupon = ($z > 0) ? true : false;

$pid = ($pid) ? $pid : ''; // Page ID
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$skin_row = array();
$skin_row = apms_rows('order_'.MOBILE_.'skin');
$skin_name = $skin_row['order_'.MOBILE_.'skin'];
$order_skin_path = G5_SKIN_PATH.'/apms/order/'.$skin_name;
$order_skin_url = G5_SKIN_URL.'/apms/order/'.$skin_name;

// 스킨 체크
list($order_skin_path, $order_skin_url) = apms_skin_thema('shop/order', $order_skin_path, $order_skin_url); 

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

include_once($skin_path.'/ordercoupon.skin.php');

?>