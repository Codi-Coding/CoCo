<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/search.php');
    return;
}

// QUERY 문에 공통적으로 들어가는 내용
// 상품명에 검색어가 포한된것과 상품판매가능인것만
$sql_common = " from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b ";

$where = array();
$where[] = " (a.ca_id = b.ca_id and a.it_use = 1 and b.ca_use = 1 and b.as_menu_show <> '1') ";

$search_all = true;
// 상세검색 이라면
if (isset($_GET['qname']) || isset($_GET['qexplan']) || isset($_GET['qid']) || isset($_GET['qtag']) || isset($_GET['qbasic']))
    $search_all = false;

$q		 = ($stx) ? $stx : $_GET['q'];
$qname   = isset($_GET['qname']) ? trim($_GET['qname']) : '';
$qexplan = isset($_GET['qexplan']) ? trim($_GET['qexplan']) : '';
$qid     = isset($_GET['qid']) ? trim($_GET['qid']) : '';
$qbasic  = isset($_GET['qbasic']) ? trim($_GET['qbasic']) : '';
$qtag    = isset($_GET['qtag']) ? trim($_GET['qtag']) : '';
$qcaid   = isset($_GET['qcaid']) ? preg_replace('#[^a-z0-9]#i', '', trim($_GET['qcaid'])) : '';
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

if(!($qname || $qexplan || $qid || $qtag || $qbasic))
    $search_all = true;

// 검색범위 checkbox 처리
$qname_check = false;
$qexplan_check = false;
$qid_check = false;
$qtag_check = false;
$qbasic_check = false;

if($search_all) {
    $qname_check = true;
    $qexplan_check = true;
    $qid_check = true;
    $qtag_check = true;
    $qbasic_check = true;
} else {
    if($qname)
        $qname_check = true;
    if($qexplan)
        $qexplan_check = true;
    if($qid)
        $qid_check = true;
    if($qtag)
        $qtag_check = true;
    if($qbasic)
        $qbasic_check = true;
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
        if ($search_all || $qtag)
            $concat[] = "a.pt_tag";
        if ($search_all || $qbasic)
            $concat[] = "a.it_basic";
		$concat_fields = "concat(".implode(",' ',",$concat).")";

        $detail_where[] = $concat_fields." like '%$word%' ";

        // 인기검색어
		insert_popular($concat, $word);

	}

    $where[] = "(".implode(" and ", $detail_where).")";
}

// 분류
$ca_qstr = '';
if ($qcaid) {
    $where[] = " a.ca_id like '$qcaid%' ";
	$ca_qstr .= '&amp;ca_id='.urlencode($qcaid);
}

if ($qfrom && $qto)
    $where[] = " a.it_price between '$qfrom' and '$qto' ";

$sql_where = " where " . implode(" and ", $where);

// 상품 출력순서가 있다면
$qsort  = strtolower($qsort);
$qorder = strtolower($qorder);

// 아래의 $qsort 필드만 정렬이 가능하게 하여 다른 필드로 하여금 유추해 볼수 없게함
if (($qsort == "it_sum_qty" || $qsort == "it_price" || $qsort == "it_use_avg" || $qsort == "it_use_cnt" || $qsort == "it_update_time" || $qsort == "pt_good" || $qsort == "pt_comment") &&
    ($qorder == "asc" || $qorder == "desc")) {
    $order_by = ' order by ' . $qsort . ' ' . $qorder . ' , it_order, pt_num desc, it_id desc';
} else {
    $order_by = ' order by it_order, pt_num desc, it_id desc';
}

// 분류
$category = array();

$field = "b.ca_id, b.ca_name, b.as_min, b.as_max, b.as_grade, b.as_equal, b.as_menu_show, count(*) as cnt";
$sql = " select $field $sql_common $sql_where group by b.ca_id order by b.ca_id ";
$result = sql_query($sql);
$z=0;
for ($i=0; $row=sql_fetch_array($result); $i++) {

	if(!$is_admin && $row['as_menu_show']) { // 접근제한
		if(apms_auth($row['as_grade'], $row['as_equal'], $row['as_min'], $row['as_max'], 1)) continue;
	}

	$category[$z] = $row;
	$z++;
}

// Page ID
$pid = ($pid) ? $pid : 'isearch';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 리스트
$list = array();
$skin_row = array();
$skin_row = apms_rows('search_'.MOBILE_.'set');
$skin_name = $default['de_'.MOBILE_.'search_list_skin'];
$thumb_w = $default['de_'.MOBILE_.'search_img_width'];
$thumb_h = $default['de_'.MOBILE_.'search_img_height'];
$list_mods = $default['de_'.MOBILE_.'search_list_mod'];
$list_rows = $default['de_'.MOBILE_.'search_list_row'];

// 스킨설정
$wset = array();
if($skin_row['search_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['search_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$skin_path = G5_SKIN_PATH.'/apms/search/'.$skin_name;
$skin_url = G5_SKIN_URL.'/apms/search/'.$skin_name;

// 스킨 체크
list($skin_path, $skin_url) = apms_skin_thema('shop/search', $skin_path, $skin_url); 

// 설정값 불러오기
$is_search_sub = false;
@include_once($skin_path.'/config.skin.php');

if(!$list_mods) $list_mods = 3;
if(!$list_rows) $list_rows = 1;

$items = $list_mods * $list_rows;

// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;

// 시작 레코드 구함
$from_record = ($page - 1) * $items;

// 검색된 내용이 몇행인지를 얻는다
$sql = " select COUNT(*) as cnt $sql_common $sql_where ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$total_page  = ceil($total_count / $items); // 전체 페이지 계산

$num = $total_count - ($page - 1) * $items;
$result = sql_query(" select * $sql_common $sql_where {$order_by} limit $from_record, $items ");
for ($i=0; $row=sql_fetch_array($result); $i++) { 
	$list[$i] = $row;
	$list[$i]['href'] = './item.php?it_id='.$row['it_id'].$ca_qstr;
	$list[$i]['num'] = $num;
	$num--;
}

$admin_href = ($is_admin) ? G5_ADMIN_URL.'/shop_admin/configform.php#anc_scf_etc' : '';

$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];

if($search_all) {
	$qname = $qexplan = $qid = $qtag = $qbasic = 1;
}
$query_string = 'ca_id='.$ca_id.'&amp;q='.urlencode($q);
$query_string .= '&amp;qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid.'&amp;qtag='.$qtag;
if($qcaid) $query_string .= '&amp;qcaid='.$qcaid;
if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
$query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;

$list_page = $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=';

$g5['title'] = "상품검색";

if($is_search_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$lm = 'search'; // 리스트 모드
$ls = $skin_name; // 리스트 스킨

// 셋업
$setup_href = '';
if (is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
    $setup_href = './skin.setup.php?skin=search&amp;name='.urlencode($ls).'&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/search.skin.php');

if($is_search_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>