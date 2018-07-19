<?php
$sub_menu = '400620';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$action_url = EYOOM_ADMIN_URL . '/?dir=shop&amp;pid=itemstocklistupdate&amp;smode=1';

$doc = strip_tags($doc);
$sort1 = in_array($sort1, array('it_id', 'it_name', 'it_stock_qty', 'it_use', 'it_soldout', 'it_stock_sms')) ? $sort1 : '';
$sort2 = in_array($sort2, array('desc', 'asc')) ? $sort2 : 'desc';
$sel_ca_id = get_search_string($sel_ca_id);
$sel_field = get_search_string($sel_field);
$search = get_search_string($search);

$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and ca_id like '$sel_ca_id%' ";
}

if ($sel_field == "")  $sel_field = "it_name";
if ($sort1 == "") $sort1 = "it_stock_qty";
if ($sort2 == "") $sort2 = "asc";

$sql_common = "  from {$g5['g5_shop_item_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select it_id,
                 it_name,
                 it_use,
                 it_stock_qty,
                 it_stock_sms,
                 it_noti_qty,
                 it_soldout
           $sql_common
          order by $sort1 $sort2
          limit $from_record, $rows ";
$result = sql_query($sql);

$qstr1 = 'sel_ca_id='.$sel_ca_id.'&amp;sel_field='.$sel_field.'&amp;search='.$search;
$qstr = $qstr1.'&amp;sort1='.$sort1.'&amp;sort2='.$sort2.'&amp;page='.$page;

$sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
$result1 = sql_query($sql1);

for ($i=0; $row1=sql_fetch_array($result1); $i++) {
    $len = strlen($row1['ca_id']) / 2 - 1;
    $nbsp = "";
    $cate[$i] = $row1;
    $cate[$i]['len'] = $len;
    for ($j=0; $j<$len; $j++) $nbsp .= "&nbsp;&nbsp;&nbsp;";
    $cate[$i]['nbsp'] = $nbsp;
}

// 리스트
$k = 0;
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $href = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";

    // 선택옵션이 있을 경우 주문대기 수량 계산하지 않음
    $sql2 = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' and io_use = '1' ";
    $row2 = sql_fetch($sql2);

    if(!$row2['cnt']) {
        $sql1 = " select SUM(ct_qty) as sum_qty
                    from {$g5['g5_shop_cart_table']}
                   where it_id = '{$row['it_id']}'
                     and ct_stock_use = '0'
                     and ct_status in ('쇼핑', '주문', '입금', '준비') ";
        $row1 = sql_fetch($sql1);
        $wait_qty = $row1['sum_qty'];
    }

    // 가재고 (미래재고)
    $temporary_qty = $row['it_stock_qty'] - $wait_qty;

    // 통보수량보다 재고수량이 작을 때
    $it_stock_qty = number_format($row['it_stock_qty']);
    $it_stock_qty_st = ''; // 스타일 정의
    if($row['it_stock_qty'] <= $row['it_noti_qty']) {
        $it_stock_qty_st = ' sit_stock_qty_alert';
        $it_stock_qty = ''.$it_stock_qty.' !<span class="sound_only"> 재고부족 </span>';
    }
    
    $list[$i] = $row;
    
    $list[$i]['href'] = $href;
    $list[$i]['wait_qty'] = $wait_qty;
    $list[$i]['temporary_qty'] = $temporary_qty;
    $list[$i]['it_stock_qty_st'] = $it_stock_qty_st;
    $list[$i]['it_stock_qty_str'] = $it_stock_qty;
    $list[$i]['image'] = str_replace('"', "'", get_it_image($row['it_id'], 160, 160));
	
	$list_num = $total_count - ($page - 1) * $rows;
    $list[$i]['num'] = $list_num - $k;
    $k++;
}

$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="일괄수정" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">';
$frm_submit .= '</div>';

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=shop&amp;pid=itemstocklist&amp;".$qstr."&amp;page=");

$atpl->assign(array(
	'cate'  => $cate,
	'frm_submit'  => $frm_submit,
));

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";