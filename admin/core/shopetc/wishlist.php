<?php
$sub_menu = '500140';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

/**
 * 1차 상품 분류 가져오기
 */
$fields = " ca_id, ca_name ";
$cate1 = $shop->get_goods_cate1($fields);

if (!$to_date) $to_date = date("Ymd", time());

if ($sort1 == "") $sort1 = "it_id_cnt";
if ($sort2 == "") $sort2 = "desc";

$sql  = " select a.it_id,
                 b.it_name,
                 COUNT(a.it_id) as it_id_cnt
            from {$g5['g5_shop_wish_table']} a, {$g5['g5_shop_item_table']} b ";
$sql .= " where a.it_id = b.it_id ";
if ($fr_date && $to_date)
{
    $fr = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
    $to = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);
    $sql .= " and a.wi_time between '$fr 00:00:00' and '$to 23:59:59' ";
}

if ($cate_a) {
	$sql_cate = " and (b.ca_id like '{$cate_a}%' or b.ca_id2 like '{$cate_a}%' or b.ca_id3 like '{$cate_a}%') ";
	$w = " (1) and ca_id like '{$cate_a}%' and length(ca_id)=4";
	$cate2 = $shop->get_goods_category($fields, $w);
}
if ($cate_a && $cate_b) {
	$sql_cate = " and (b.ca_id like '{$cate_b}%' or b.ca_id2 like '{$cate_b}%' or b.ca_id3 like '{$cate_b}%') ";
	$w = " (1) and ca_id like '{$cate_b}%' and length(ca_id)=6";
	$cate3 = $shop->get_goods_category($fields, $w);
}
if ($cate_a && $cate_b && $cate_c) {
	$sql_cate = " and (b.ca_id like '{$cate_c}%' or b.ca_id2 like '{$cate_c}%' or b.ca_id3 like '{$cate_c}%') ";
	$w = " (1) and ca_id like '{$cate_c}%' and length(ca_id)=8";
	$cate4 = $shop->get_goods_category($fields, $w);
}

$sql .= $sql_cate;


$sql .= " group by a.it_id, b.it_name
          order by $sort1 $sort2 ";
$result = sql_query($sql);
$total_count = sql_num_rows($result);

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$rank = ($page - 1) * $rows;

$sql = $sql . " limit $from_record, $rows ";
$result = sql_query($sql);

$qstr1 = $qstr.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;sel_ca_id='.$sel_ca_id;
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    // $s_mod = icon("수정", "./itemqaform.php?w=u&amp;iq_id={$row['iq_id']}&amp;$qstr");
    // $s_del = icon("삭제", "javascript:del('./itemqaupdate.php?w=d&amp;iq_id={$row['iq_id']}&amp;$qstr');");

    $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
    $num = $rank + $i + 1;

    $wish_list[$i] = $row;
    $wish_list[$i]['num'] = $num;
    $wish_list[$i]['image'] = str_replace('"', "'", get_it_image($row['it_id'], 160, 160));
    $wish_list[$i]['href'] = $href;
}

// Paging
$paging = $thema->pg_pages($tpl_name,"./?dir=shopetc&amp;pid=wishlist&amp;".$qstr1."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'wish_list' => $wish_list,
));