<?php
$sub_menu = '400400';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

include_once (G5_PATH.'/head.sub.php');

$od_id = $_POST['od_id'];
//$od_id = $_GET['od_id'];

$sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
$od = sql_fetch($sql);

if(!$od['od_id'])
    die('<div>주문정보가 존재하지 않습니다.</div>');

// 상품목록
$sql = " select it_id,
                it_name,
                cp_price,
                ct_notax,
                ct_send_cost,
                it_sc_type
           from {$g5['g5_shop_cart_table']}
          where od_id = '$od_id'
          group by it_id
          order by ct_id ";
$result = sql_query($sql);

for($i=0; $row=sql_fetch_array($result); $i++) {
    // 상품이미지
    $image = get_it_image($row['it_id'], 50, 50);

    // 상품의 옵션정보
    $sql = " select ct_id, it_id, ct_price, ct_qty, ct_option, ct_status, cp_price, ct_send_cost, io_type, io_price
                from {$g5['g5_shop_cart_table']}
                where od_id = '$od_id'
                  and it_id = '{$row['it_id']}'
                order by io_type asc, ct_id asc ";
    $res = sql_query($sql);
    $rowspan = sql_num_rows($res);

    // 배송비
    switch($row['ct_send_cost'])
    {
        case 1:
            $ct_send_cost = '착불';
            break;
        case 2:
            $ct_send_cost = '무료';
            break;
        default:
            $ct_send_cost = '선불';
            break;
    }

    // 조건부무료
    if($row['it_sc_type'] == 2) {
        $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

        if($sendcost == 0)
            $ct_send_cost = '무료';

        $save_it_id = $row['it_id'];
    }

    for($k=0; $opt=sql_fetch_array($res); $k++) {
        if($opt['io_type'])
            $opt_price = $opt['io_price'];
        else
            $opt_price = $opt['ct_price'] + $opt['io_price'];

        // 소계
        $ct_price['stotal'] = $opt_price * $opt['ct_qty'];
        $ct_point['stotal'] = $opt['ct_point'] * $opt['ct_qty'];
    }
    
    $item_list[$i] = $row;
    $item_list[$i]['ct_option'] = $opt['ct_option'];
    $item_list[$i]['ct_status'] = $opt['ct_status'];
    $item_list[$i]['ct_qty'] 	= $opt['ct_qty'];
    $item_list[$i]['opt_price'] = $opt_price;
    $item_list[$i]['stotal'] 	= $ct_price['stotal'];
    $item_list[$i]['cp_price'] 	= $opt['cp_price'];
    $item_list[$i]['ptotal'] 	= $ct_point['stotal'];
    $item_list[$i]['ct_send_cost'] 	= $ct_send_cost;
    
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'od' => $od,
	'item_list' => $item_list,
));

// Template define
$atpl->define_template($dir, 'basic', $pid.'.skin.html');

// Template assign
@include_once(EYOOM_ADMIN_INC_PATH.'/atpl.assign.php');
$atpl->print_($tpl_name);
