<?php
$sub_menu = '400300';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$action_url = EYOOM_ADMIN_URL . '/?dir=shop&amp;pid=itemlistupdate&amp;smode=1';

/**
 * 1차 상품 분류 가져오기
 */
$fields = " ca_id, ca_name ";
$cate1 = $shop->get_goods_cate1($fields);

$where = " and ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx) $page = 1;
}

if ($sca != "") {
    $sql_search .= " $where (ca_id like '$sca%' or ca_id2 like '$sca%' or ca_id3 like '$sca%') ";
}

if ($cate_a) {
	$sql_cate = " and (ca_id like '{$cate_a}%' or ca_id2 like '{$cate_a}%' or ca_id3 like '{$cate_a}%') ";
	$w = " (1) and ca_id like '{$cate_a}%' and length(ca_id)=4";
	$cate2 = $shop->get_goods_category($fields, $w);
}
if ($cate_a && $cate_b) {
	$sql_cate = " and (ca_id like '{$cate_b}%' or ca_id2 like '{$cate_b}%' or ca_id3 like '{$cate_b}%') ";
	$w = " (1) and ca_id like '{$cate_b}%' and length(ca_id)=6";
	$cate3 = $shop->get_goods_category($fields, $w);
}
if ($cate_a && $cate_b && $cate_c) {
	$sql_cate = " and (ca_id like '{$cate_c}%' or ca_id2 like '{$cate_c}%' or ca_id3 like '{$cate_c}%') ";
	$w = " (1) and ca_id like '{$cate_c}%' and length(ca_id)=8";
	$cate4 = $shop->get_goods_category($fields, $w);
}

$sql_search .= $sql_cate;

if ($sfl == "")  $sfl = "it_name";

$sql_common = " from {$g5['g5_shop_item_table']} where (1) ";
if ($is_admin != 'super') $sql_common .= " and ca_mb_id = '{$member['mb_id']}'";

$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;

$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);
if ($page < 1) { $page = 1; }
$from_record = ($page - 1) * $rows;

if (!$sst) {
    $sst  = "it_id";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";


$sql  = " select * $sql_common $sql_order limit $from_record, $rows ";
$result = sql_query($sql);
$k=0;
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
	$list[$i]['image'] = str_replace("\"","'",get_it_image($row['it_id'], 160, 160));

	// 총판매수
	$sales = sql_fetch("select sum(ct_qty) as qty from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '입금,준비,배송,완료') > 0 and it_id = '{$row['it_id']}' ");
	$list[$i]['sales'] = $sales['qty'];

	$list_num = $total_count - ($page - 1) * $rows;
    $list[$i]['num'] = $list_num - $k;
    $k++;
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=shop&amp;pid=itemlist&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";
