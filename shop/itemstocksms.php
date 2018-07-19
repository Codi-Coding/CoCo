<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/itemstocksms.php');
    return;
}

// 상품정보
$sql = " select it_id, ca_id, it_name, it_soldout, it_stock_sms
            from {$g5['g5_shop_item_table']}
            where it_id = '$it_id' ";
$it = sql_fetch($sql);

if(!$it['it_id'])
    alert_close('자료가 없습니다.');

if(!$it['it_soldout'] || !$it['it_stock_sms'])
    alert_close('재입고SMS 알림을 신청할 수 없는 자료입니다.');

$ca_id = ($ca_id) ? $ca_id : $it['ca_id'];
$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
$at = apms_ca_thema($ca_id, $ca, 1);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

$item_skin = apms_itemview_skin($at['item'], $ca_id, $it['ca_id']);

$wset = array();
if($ca['as_'.MOBILE_.'item_set']) {
	$wset = apms_unpack($ca['as_'.MOBILE_.'item_set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$item_skin_path = G5_SKIN_PATH.'/apms/item/'.$item_skin;
$item_skin_url = G5_SKIN_URL.'/apms/item/'.$item_skin;

$g5['title'] = '재입고 알림 (SMS)';
include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');
include_once($item_skin_path.'/itemstocksms.skin.php');
@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');

?>