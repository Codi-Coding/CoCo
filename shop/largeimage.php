<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/largeimage.php');
    return;
}

$it_id = $_GET['it_id'];
$no = $_GET['no'];

$sql = " select it_id, ca_id, it_name, it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10
            from {$g5['g5_shop_item_table']} where it_id='$it_id' ";
$row = sql_fetch($sql);

if(!$row['it_id'])
    alert_close('자료가 없습니다.');

if(!$ca_id) $ca_id = $row['ca_id'];

if(!defined('THEMA_PATH')) {
	$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
	$at = apms_ca_thema($ca_id, $ca, 1);
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
	$item_skin = apms_itemview_skin($at['item'], $ca_id, $row['ca_id']);

	// 스킨설정
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

$imagefile = G5_DATA_PATH.'/item/'.$row['it_img'.$no];
$imagefileurl = G5_DATA_URL.'/item/'.$row['it_img'.$no];
$size = getimagesize($imagefile);

$g5['title'] = "{$row['it_name']} ($it_id)";
include_once(G5_PATH.'/head.sub.php');
include_once($item_skin_path.'/largeimage.skin.php');
include_once(G5_PATH.'/tail.sub.php');
?>