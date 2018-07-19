<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/list.php');
	return;
}

$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1'  ";
$ca = sql_fetch($sql);
if (!$ca['ca_id'])
	alert('등록된 분류가 없습니다.');

// 본인인증, 성인인증체크
if(!$is_admin) {
	$msg = shop_member_cert_check($ca_id, 'list');
	if($msg)
		alert($msg, G5_SHOP_URL);
}

$g5['title'] = $ca['ca_name'].' 상품리스트';

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

if ($ca['ca_include_head']) {
	@include_once($ca['ca_include_head']);
} else {
	// 이윰 테일 디자인 출력
	@include_once(EYOOM_SHOP_PATH.'/shop.head.php');
}

/**** list : Start ****/

// 상품 출력순서가 있다면
if ($sort != "")
    $order_by = $sort.' '.$sortodr.' , it_order, it_id desc';
else
    $order_by = 'it_order, it_id desc';

// 상품정렬방식
$sct_sort_href = $_SERVER['PHP_SELF'].'?';

if($ca_id) $sct_sort_href .= 'ca_id='.$ca_id;
else if($ev_id) $sct_sort_href .= 'ev_id='.$ev_id;

if($skin) $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';

// 총몇개 = 한줄에 몇개 * 몇줄
$items = $ca['ca_list_mod'] * $ca['ca_list_row'];

// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;

// 시작 레코드 구함
$from_record = ($page - 1) * $items;

$skin_file = EYOOM_SHOP_PATH.'/'.$ca['ca_skin'];
$list = new item_list($skin_file, $ca['ca_list_mod'], $ca['ca_list_row'], $ca['ca_img_width'], $ca['ca_img_height']);
$list->tpl_name = $tpl_name;
$list->theme = $shop_theme;
$list->eyoom = $eyoom;
$list->set_category($ca['ca_id'], 1);
$list->set_category($ca['ca_id'], 2);
$list->set_category($ca['ca_id'], 3);
$list->set_is_page(true);
$list->set_order_by($order_by);
$list->set_from_record($from_record);
$list->set_view('it_img', true);
$list->set_view('it_id', false);
$list->set_view('it_name', true);
$list->set_view('it_basic', true);
$list->set_view('it_cust_price', true);
$list->set_view('it_price', true);
$list->set_view('it_icon', true);
$list->set_view('sns', true);
$list_package = $list->run();

// where 된 전체 상품수
$total_count = $list->total_count;
// 전체 페이지 계산
$total_page  = ceil($total_count / $items);

/**** list : End ****/

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'list.skin.html');

// Paging 
$qstr1 .= 'ca_id='.$ca_id;
$qstr1 .='&amp;sort='.$sort.'&amp;sortodr='.$sortodr;
$paging = $thema->pg_pages($tpl_name,$_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&amp;page=');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/list.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

if ($ca['ca_include_tail']) {
	@include_once($ca['ca_include_tail']);
} else {
	// 이윰 테일 디자인 출력
	@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');
}