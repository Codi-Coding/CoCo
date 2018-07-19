<?php
$sub_menu = '500310';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$action_url = EYOOM_ADMIN_URL . '/?dir=shopetc&amp;pid=itemeventlistupdate&amp;smode=1';

/**
 * 1차 상품 분류 가져오기
 */
$fields = " ca_id, ca_name ";
$cate1 = $shop->get_goods_cate1($fields);

// 이벤트제목
if($ev_id) {
    $tmp = sql_fetch(" select ev_subject from {$g5['g5_shop_event_table']} where ev_id = '$ev_id' ");
    $ev_title = $tmp['ev_subject'];
}

// 이벤트 옵션처리
$event_option = "<option value=''>이벤트를 선택하세요</option>";
$sql1 = " select ev_id, ev_subject from {$g5['g5_shop_event_table']} order by ev_id desc ";
$result1 = sql_query($sql1);
while ($row1=sql_fetch_array($result1)) {
    $event_option .= '<option value="'.$row1['ev_id'].'" '.get_selected($ev_id, $row1['ev_id']).' >'.conv_subject($row1['ev_subject'], 20,"…").'</option>';
}

$where = " where ";
$sql_search = "";
if ($search != "") {
    if ($sel_field != "") {
        $sql_search .= " $where $sel_field like '%$search%' ";
        $where = " and ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " $where ca_id like '$sel_ca_id%' ";
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

if ($sel_field == "")  {
    $sel_field = "it_name";
}

$sql_common = " from {$g5['g5_shop_item_table']} a
                left join {$g5['g5_shop_event_item_table']} b on (a.it_id=b.it_id and b.ev_id='$ev_id') ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sort1) {
    $sort1 = "b.ev_id";
}

if (!$sort2) {
    $sort2 = "desc";
}

$sql  = " select a.*, b.ev_id
          $sql_common
          order by $sort1 $sort2
          limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr1 = 'sel_ca_id='.$sel_ca_id.'&amp;sel_field='.$sel_field.'&amp;search='.$search;
$qstr1 = 'ev_id='.$ev_id.'&amp;sel_ca_id='.$sel_ca_id.'&amp;sel_field='.$sel_field.'&amp;search='.$search;
$qstr  = $qstr1.'&amp;sort1='.$sort1.'&amp;sort2='.$sort2.'&amp;page='.$page;

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];

    $sql = " select ev_id from {$g5['g5_shop_event_item_table']}
              where it_id = '{$row['it_id']}'
                and ev_id = '$ev_id' ";
    $ev = sql_fetch($sql);

    $event_list[$i] = $row;
    $event_list[$i]['image'] = str_replace('"', "'", get_it_image($row['it_id'], 160, 160));
    $event_list[$i]['href'] = $href;
    $event_list[$i]['is_ev_item'] = $ev['ev_id'] ? true: false;
}

// Paging
$paging = $thema->pg_pages($tpl_name,"./?dir=shopetc&amp;pid=itemeventlist&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'event_list' => $event_list,
));