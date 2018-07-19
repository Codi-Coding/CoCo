<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/couponzone.php');
    return;
}

// Page ID
$pid = ($pid) ? $pid : 'couponzone';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$skin_row = array();
$skin_row = apms_rows('cz_'.MOBILE_.'skin, cz_'.MOBILE_.'set');
$skin_name = $skin_row['cz_'.MOBILE_.'skin'];

// 스킨설정
$wset = array();
if($skin_row['cz_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['cz_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$skin_path = G5_SKIN_PATH.'/apms/couponzone/'.$skin_name;
$skin_url = G5_SKIN_URL.'/apms/couponzone/'.$skin_name;

// 스킨 체크
list($skin_path, $skin_url) = apms_skin_thema('shop/couponzone', $skin_path, $skin_url); 

// 설정값 불러오기
$is_couponzone_sub = false;
@include_once($skin_path.'/config.skin.php');

$g5['title'] = '쿠폰존';

if($is_couponzone_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$list = array();
$plist = array();

$sql_common = " from {$g5['g5_shop_coupon_zone_table']}
                where cz_start <= '".G5_TIME_YMD."'
                  and cz_end >= '".G5_TIME_YMD."' ";

$sql_order  = " order by cz_id desc ";

// List
$sql = " select * $sql_common and cz_type = '0' $sql_order ";
$result = sql_query($sql);
for($i=0; $row=sql_fetch_array($result); $i++) {

	$list[$i] = $row;

	$list[$i]['cz_img'] = ($row['cz_file'] && is_file(G5_DATA_PATH.'/coupon/'.$row['cz_file'])) ? G5_DATA_URL.'/coupon/'.$row['cz_file'] : '';
	$list[$i]['cz_subject'] = get_text($row['cz_subject']);

	switch($row['cp_method']) {
		case '0':
			$sql3 = " select it_id, it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['cp_target']}' ";
			$row3 = sql_fetch($sql3);
			$list[$i]['it_id'] = $row3['it_id'];
			$list[$i]['it_name'] = get_text($row3['it_name']);
			break;
		case '1':
			$sql3 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
			$row3 = sql_fetch($sql3);
			$list[$i]['ca_id'] = $row3['ca_id'];
			$list[$i]['ca_name'] = get_text($row3['ca_name']);
			break;
	}

	$list[$i]['disabled'] = (is_coupon_downloaded($member['mb_id'], $row['cz_id'])) ? ' disabled' : '';
}

// PList
$sql = " select * $sql_common and cz_type = '1' $sql_order ";
$result = sql_query($sql);
for($i=0; $row=sql_fetch_array($result); $i++) {

	$plist[$i] = $row;

	$plist[$i]['cz_img'] = ($row['cz_file'] && is_file(G5_DATA_PATH.'/coupon/'.$row['cz_file'])) ? G5_DATA_URL.'/coupon/'.$row['cz_file'] : '';
	$plist[$i]['cz_subject'] = get_text($row['cz_subject']);

	switch($row['cp_method']) {
		case '0':
			$sql3 = " select it_id, it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['cp_target']}' ";
			$row3 = sql_fetch($sql3);
			$plist[$i]['it_id'] = $row3['it_id'];
			$plist[$i]['it_name'] = get_text($row3['it_name']);
			break;
		case '1':
			$sql3 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
			$row3 = sql_fetch($sql3);
			$plist[$i]['ca_id'] = $row3['ca_id'];
			$plist[$i]['ca_name'] = get_text($row3['ca_name']);
			break;
	}

	$plist[$i]['disabled'] = (is_coupon_downloaded($member['mb_id'], $row['cz_id'])) ? ' disabled' : '';
}

// 셋업
$setup_href = '';
if (is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=cz&amp;name='.urlencode($skin_name).'&amp;ts='.urlencode(THEMA);
}

// 관리
$admin_href = ($is_admin) ? G5_ADMIN_URL.'/shop_admin/couponzonelist.php' : '';

// 스크립트
add_javascript('<script src="'.G5_JS_URL.'/shop.couponzone.js"></script>', 100);

include_once($skin_path.'/couponzone.skin.php');

if($is_couponzone_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>