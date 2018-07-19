<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/search.php');
	return;
}

$g5['title'] = "상품 검색 결과";

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

// QUERY 문에 공통적으로 들어가는 내용
// 상품명에 검색어가 포한된것과 상품판매가능인것만
$sql_common = " from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b ";

$where = array();
$where[] = " (a.ca_id = b.ca_id and a.it_use = 1 and b.ca_use = 1) ";

$search_all = true;
// 상세검색 이라면
if (isset($_GET['qname']) || isset($_GET['qexplan']) || isset($_GET['qid']))
	$search_all = false;

$q       = utf8_strcut(get_search_string(trim($_GET['q'])), 30, "");
$qname   = isset($_GET['qname']) ? trim($_GET['qname']) : '';
$qexplan = isset($_GET['qexplan']) ? trim($_GET['qexplan']) : '';
$qid     = isset($_GET['qid']) ? trim($_GET['qid']) : '';
$qcaid   = isset($_GET['qcaid']) ? trim($_GET['qcaid']) : '';
$qfrom   = isset($_GET['qfrom']) ? preg_replace('/[^0-9]/', '', trim($_GET['qfrom'])) : '';
$qto     = isset($_GET['qto']) ? preg_replace('/[^0-9]/', '', trim($_GET['qto'])) : '';
if (isset($_GET['qsort']))  {
	$qsort = trim($_GET['qsort']);
	$qsort = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $qsort);
} else {
	$qsort = '';
}
if (isset($_GET['qorder']))  {
	$qorder = preg_match("/^(asc|desc)$/i", $qorder) ? $qorder : '';
} else {
	$qorder = '';
}

if(!($qname || $qexplan || $qid))
	$search_all = true;

// 검색범위 checkbox 처리
$qname_check = false;
$qexplan_check = false;
$qid_check = false;

if($search_all) {
	$qname_check = true;
	$qexplan_check = true;
	$qid_check = true;
} else {
	if($qname)
		$qname_check = true;
	if($qexplan)
		$qexplan_check = true;
	if($qid)
		$qid_check = true;
}

if ($q) {
	$arr = explode(" ", $q);
	$detail_where = array();
	for ($i=0; $i<count($arr); $i++) {
		$word = trim($arr[$i]);
		if (!$word) continue;
		
		$concat = array();
		if ($search_all || $qname)
			$concat[] = "a.it_name";
		if ($search_all || $qexplan)
			$concat[] = "a.it_explan2";
		if ($search_all || $qid)
			$concat[] = "a.it_id";
		$concat_fields = "concat(".implode(",' ',",$concat).")";
		
		$detail_where[] = $concat_fields." like '%$word%' ";
		
		// 인기검색어
		insert_popular($concat, $word);
	}
	
	$where[] = "(".implode(" and ", $detail_where).")";
}

if ($qcaid)
	$where[] = " a.ca_id like '$qcaid%' ";

if ($qfrom && $qto)
	$where[] = " a.it_price between '$qfrom' and '$qto' ";

$sql_where = " where " . implode(" and ", $where);

// 상품 출력순서가 있다면
$qsort  = strtolower($qsort);
$qorder = strtolower($qorder);
$order_by = "";
// 아래의 $qsort 필드만 정렬이 가능하게 하여 다른 필드로 하여금 유추해 볼수 없게함
if (($qsort == "it_sum_qty" || $qsort == "it_price" || $qsort == "it_use_avg" || $qsort == "it_use_cnt" || $qsort == "it_update_time") && ($qorder == "asc" || $qorder == "desc")) {
	$order_by = ' order by ' . $qsort . ' ' . $qorder . ' , it_order, it_id desc';
}

// 총몇개 = 한줄에 몇개 * 몇줄
$items = $default['de_search_list_mod'] * $default['de_search_list_row'];
// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;
// 시작 레코드 구함
$from_record = ($page - 1) * $items;

// 검색된 내용이 몇행인지를 얻는다
$sql = " select COUNT(*) as cnt $sql_common $sql_where ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$total_page  = ceil($total_count / $items); // 전체 페이지 계산

$sql = " select b.ca_id, b.ca_name, count(*) as cnt $sql_common $sql_where group by b.ca_id order by b.ca_id ";
$result = sql_query($sql);
$total_cnt = 0;
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$slist[$i]['ca_id'] = $row['ca_id'];
	$slist[$i]['ca_name'] = $row['ca_name'];
	$slist[$i]['cnt'] = $row['cnt'];
	
	$total_cnt += $row['cnt'];
}

// 리스트 유형별로 출력
$list_file = EYOOM_SHOP_PATH.'/'.$default['de_search_list_skin'];

if (file_exists($list_file)) {
	$list = new item_list($list_file, $default['de_search_list_mod'], $default['de_search_list_row'], $default['de_search_img_width'], $default['de_search_img_height']);
	$list->tpl_name = $tpl_name;
	$list->theme = $theme;
	$list->eyoom = $eyoom;
	$list->set_query(" select * $sql_common $sql_where {$order_by} limit $from_record, $items ");
	$list->set_is_page(true);
}

// Paging 
$query_string = 'qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid;
if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
$query_string .= '&amp;qcaid='.$qcaid.'&amp;q='.urlencode($q);
$query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
$paging = $thema->pg_pages($tpl_name,$_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'search.skin.html');

$tpl->assign(array(
	'slist' => $slist,
));

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/search.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');