<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/cartoption.php');
    return;
}

$pattern = '#[/\'\"%=*\#\(\)\|\+\&\!\$~\{\}\[\]`;:\?\^\,]#';
$it_id  = preg_replace($pattern, '', $_POST['it_id']);

$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' and it_use = '1' ";
$it = sql_fetch($sql);

if(!$it['it_id'])
    die('no-item');

$pid = ($pid) ? $pid : 'cart'; // Page ID
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$ca = sql_fetch(" select ca_skin_dir, ca_mobile_skin_dir from {$g5['g5_shop_category_table']} where ca_id = '{$it['ca_id']}' ");

$skin_path = G5_SKIN_PATH.'/apms/item/'.$ca['ca_'.MOBILE_.'skin_dir'];
$skin_url = G5_SKIN_URL.'/apms/item/'.$ca['ca_'.MOBILE_.'skin_dir'];
if(is_file($skin_path.'/cartoption.skin.php')) {
	$item_skin_path = $skin_path;
	$item_skin_url = $skin_url;
} else {
	$skin_row = array();
	$skin_row = apms_rows('order_'.MOBILE_.'skin');
	$order_skin_path = G5_SKIN_PATH.'/apms/order/'.$skin_row['order_'.MOBILE_.'skin'];
	$order_skin_url = G5_SKIN_URL.'/apms/order/'.$skin_row['order_'.MOBILE_.'skin'];

	// 스킨 체크
	list($order_skin_path, $order_skin_url) = apms_skin_thema('shop/order', $order_skin_path, $order_skin_url); 

	$skin_path = $order_skin_path;
	$skin_url = $order_skin_url;
}

$it_point = get_item_point($it);

// 장바구니 자료
$cart_id = get_session('ss_cart_id');
$sql = " select * from {$g5['g5_shop_cart_table']} where od_id = '$cart_id' and it_id = '$it_id' order by io_type asc, ct_id asc ";
$result = sql_query($sql);

// 판매가격
$sql2 = " select ct_price, it_name, ct_send_cost from {$g5['g5_shop_cart_table']} where od_id = '$cart_id' and it_id = '$it_id' order by ct_id asc limit 1 ";
$row2 = sql_fetch($sql2);

if(!sql_num_rows($result))
    die('no-cart');

$option_1 = get_item_options($it['it_id'], $it['it_option_subject']);
$option_2 = get_item_supply($it['it_id'], $it['it_supply_subject']);

$io = array();
$option = array();

$option['it_id'] = $it['it_id'];
$option['ct_price'] = $row2['ct_price'];
$option['ct_send_cost'] = $row2['ct_send_cost'];

for($i=0; $row=sql_fetch_array($result); $i++) {
	if(!$row['io_id'])
		$it_stock_qty = get_it_stock_qty($row['it_id']);
	else
		$it_stock_qty = get_option_stock_qty($row['it_id'], $row['io_id'], $row['io_type']);

	if($row['io_price'] < 0)
		$io_price = '('.number_format($row['io_price']).'원)';
	else
		$io_price = '(+'.number_format($row['io_price']).'원)';

	$cls = 'opt';
	if($row['io_type'])
		$cls = 'spl';

	$io[$i] = $row;
	$io[$i]['cls'] = $cls;
	$io[$i]['it_stock_qty'] = $it_stock_qty;
	$io[$i]['io_price'] = $row['io_price'];
	$io[$i]['io_display_price'] = $io_price;
	$io[$i]['pt_msg1'] = $row['pt_msg1'];
	$io[$i]['pt_msg2'] = $row['pt_msg2'];
	$io[$i]['pt_msg3'] = $row['pt_msg3'];
}

$action_url = G5_SHOP_URL.'/cartupdate.php';

include_once($skin_path.'/cartoption.skin.php');

?>