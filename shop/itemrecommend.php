<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/itemrecommend.php');
    return;
}

if (!$is_member)
    alert_close('회원만 메일을 발송할 수 있습니다.');

// 스팸을 발송할 수 없도록 세션에 아무값이나 저장하여 hidden 으로 넘겨서 다음 페이지에서 비교함
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$sql = " select it_name, ca_id from {$g5['g5_shop_item_table']} where it_id='$it_id' ";
$it = sql_fetch($sql);
if (!$it['it_name'])
    alert_close("자료가 없습니다.");

$ca_id = ($ca_id) ? $ca_id : $it['ca_id'];
if(!defined('THEMA_PATH')) {
	$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
	$at = apms_ca_thema($ca_id, $ca, 1);
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
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
}

$g5['title'] =  $it['it_name'].' - 추천하기';
include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');
include_once($item_skin_path.'/itemrecommend.skin.php');
@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');
?>