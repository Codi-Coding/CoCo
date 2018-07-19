<?php
$sub_menu = '500100';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

/**
 * 1차 상품 분류 가져오기
 */
$fields = " ca_id, ca_name ";
$cate1 = $shop->get_goods_cate1($fields);

if (!$to_date) $to_date = date("Ymd", time());

if ($sort1 == "") $sort1 = "ct_status_sum";
if ($sort2 == "") $sort2 = "desc";

$doc = strip_tags($doc);
$sort1 = strip_tags($sort1);

if( preg_match("/[^0-9]/", $fr_date) ) $fr_date = '';
if( preg_match("/[^0-9]/", $to_date) ) $to_date = '';

$sql  = " select a.it_id,
                 b.*,
                 SUM(IF(ct_status = '쇼핑',ct_qty, 0)) as ct_status_1,
                 SUM(IF(ct_status = '주문',ct_qty, 0)) as ct_status_2,
                 SUM(IF(ct_status = '입금',ct_qty, 0)) as ct_status_3,
                 SUM(IF(ct_status = '준비',ct_qty, 0)) as ct_status_4,
                 SUM(IF(ct_status = '배송',ct_qty, 0)) as ct_status_5,
                 SUM(IF(ct_status = '완료',ct_qty, 0)) as ct_status_6,
                 SUM(IF(ct_status = '취소',ct_qty, 0)) as ct_status_7,
                 SUM(IF(ct_status = '반품',ct_qty, 0)) as ct_status_8,
                 SUM(IF(ct_status = '품절',ct_qty, 0)) as ct_status_9,
                 SUM(ct_qty) as ct_status_sum
            from {$g5['g5_shop_cart_table']} a, {$g5['g5_shop_item_table']} b ";
$sql .= " where a.it_id = b.it_id ";
if ($fr_date && $to_date)
{
    $fr = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
    $to = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);
    $sql .= " and ct_time between '$fr 00:00:00' and '$to 23:59:59' ";
}

if ($cate_a) {
	$cate_id = $cate_a;
	$sql .= " and ((b.ca_id like '{$cate_id}%' or b.ca_id2 like '{$cate_id}%' or b.ca_id3 like '{$cate_id}%') and length(b.ca_id)>=2 ) ";
}
if ($cate_a && $cate_b) {
	$cate_id = $cate_a . $cate_b;
	$sql .= " and ((b.ca_id like '{$cate_id}%' or b.ca_id2 like '{$cate_id}%' or b.ca_id3 like '{$cate_id}%') and length(b.ca_id)>=4 ) ";
}
if ($cate_a && $cate_b && $cate_c) {
	$cate_id = $cate_a . $cate_b . $cate_c;
	$sql .= " and ((b.ca_id like '{$cate_id}%' or b.ca_id2 like '{$cate_id}%' or b.ca_id3 like '{$cate_id}%') and length(b.ca_id)>=6 ) ";
}
if ($cate_a && $cate_b && $cate_c && $cate_d) {
	$cate_id = $cate_a . $cate_b . $cate_c . $cate_d;
	$sql .= " and ((b.ca_id like '{$cate_id}%' or b.ca_id2 like '{$cate_id}%' or b.ca_id3 like '{$cate_id}%') and length(b.ca_id)=8 ) ";
}

$sql .= " group by a.it_id
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

//$qstr = 'page='.$page.'&amp;sort1='.$sort1.'&amp;sort2='.$sort2;
$qstr1 = $qstr.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;sel_ca_id='.$sel_ca_id;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $href = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";
    $num = $rank + $i + 1;
    
    $rank_list[$i] = $row;
    $rank_list[$i]['num'] = $num;
    $rank_list[$i]['href'] = $href;
    $rank_list[$i]['image'] = str_replace('"', "'", get_it_image($row['it_id'], 160, 160) );
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=shopetc&amp;pid=itemsellrank&amp;".$qstr1."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'rank_list' => $rank_list,
));