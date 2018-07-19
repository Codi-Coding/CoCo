<?php
if (!defined('_GNUBOARD_')) {
	$is_item = false;
	include_once('./_common.php');
	include_once(G5_LIB_PATH.'/thumbnail.lib.php');

	$it = apms_it($it_id);
	$ca_id = ($ca_id) ? $ca_id : $it['ca_id'];
	$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
	$at = apms_ca_thema($ca_id, $ca, 1);
	if(!defined('THEMA_PATH')) {
		include_once(G5_LIB_PATH.'/apms.thema.lib.php');
	}

	$item_skin = apms_itemview_skin($at['item'], $ca_id, $it['ca_id']);

	// 출력수
	if(!$rrows || !$rmods) {
		$itemrows = apms_rows('irelation_'.MOBILE_.'mods', 'irelation_'.MOBILE_.'rows');
	}

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
} else {
	$page = 0;
}

$sql_common = " from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it_id}' and b.it_use='1' ";

// 테이블의 전체 레코드수만 얻음
if($is_item) {
	$total_count = $item_relation_count;
} else {
	$sql = " select COUNT(*) as cnt " . $sql_common;
	$row = sql_fetch($sql);
	$total_count = $row['cnt'];
}

$thumb_w = $default['de_'.MOBILE_.'rel_img_width'];
$thumb_h = $default['de_'.MOBILE_.'rel_img_height'];
$rmods = (isset($rmods) && $rmods > 0) ? $rmods : $itemrows['irelation_'.MOBILE_.'mods'];
$rmods = ($rmods > 0) ? $rmods : 3;
$rrows = (isset($rrows) && $rrows > 0) ? $rrows : $itemrows['irelation_'.MOBILE_.'rows'];
$rrows = ($rrows > 0) ? $rrows : 2;

$rows = $rmods * $rrows;

$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if($page > 0) {
	;
} else {
	$page = 1; // 페이지가 없으면 1페이지
}

$from_record = ($page - 1) * $rows; // 시작 레코드 구함

if($from_record < 0)
	$from_record = 0;

$list = array();
$num = $total_count - ($page - 1) * $rrows;
$result = sql_query(" select b.* $sql_common order by b.pt_num desc, b.it_id desc limit $from_record, $rows ");
for ($i=0; $row=sql_fetch_array($result); $i++) { 
	$list[$i] = $row;
	$list[$i]['href'] = './item.php?it_id='.$row['it_id'];
	$list[$i]['num'] = $num;
	$num--;
}

$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './itemrelation.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;rmods='.$rmods.'&amp;rrows='.$rrows.'&amp;page=';

include_once($item_skin_path.'/itemrelation.skin.php');

unset($list);

?>