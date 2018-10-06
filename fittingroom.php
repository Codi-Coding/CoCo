<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/coco.lib.php');

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode('/fittingroom.php'));


$list = array();
$sql  = " select a.fitting_cart_id, a.cart_time, b.* from CoCo_fitting_cart a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) ";
$sql .= " where a.mb_id = '{$member['mb_id']}' order by a.fitting_cart_id desc ";
$result = sql_query($sql);


for ($i=0; $row = sql_fetch_array($result); $i++) {

	$list[$i] = $row;

	$list[$i]['out_cd'] = '';
	$sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' ";
	$tmp = sql_fetch($sql);
	if($tmp['cnt'])
		$list[$i]['out_cd'] = 'no';

	$list[$i]['price'] = get_price($row);

	if ($row['it_tel_inq']) $list[$i]['out_cd'] = 'tel';

	$list[$i]['is_soldout'] = is_soldout($row['it_id']);
}

// Page ID
$pid = ($pid) ? $pid : 'cart';


$codi_row = getCodiRow($member['mb_id']);
$codi = $codi_row['cody'];
$pre_codi_url = $codi_row['image_url'];

// 스킨 체크


include_once('./_head.php');


include_once('skin/fittingroom/fittingroom.skin.php');


include_once('./_tail.php');

?>