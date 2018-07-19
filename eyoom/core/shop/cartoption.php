<?php
if (!defined('_SHOP_')) exit;

$it_id = $_POST['it_id'];

$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' and it_use = '1' ";
$it = sql_fetch($sql);
$it_point = get_item_point($it);

if(!$it['it_id'])
	die('no-item');
	
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

for($i=0; $row=sql_fetch_array($result); $i++) {
	if(!$row['io_id'])
		$it_stock_qty = get_it_stock_qty($row['it_id']);
	else
		$it_stock_qty = get_option_stock_qty($row['it_id'], $row['io_id'], $row['io_type']);
		
	$cls = 'opt';
	if($row['io_type']) $cls = 'spl';
	
	$list[$i]['cls'] = $cls;
	$list[$i]['it_stock_qty'] = $it_stock_qty;
	$list[$i]['io_type'] = $row['io_type'];
	$list[$i]['io_id'] = $row['io_id'];
	$list[$i]['ct_option'] = $row['ct_option'];
	$list[$i]['io_price'] = $row['io_price'];
	$list[$i]['ct_qty'] = $row['ct_qty'];
}

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'cart_option.skin.html');

// 변수 할당하기
$tpl->assign(array(
	'row2' => $row2
));

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);
exit;