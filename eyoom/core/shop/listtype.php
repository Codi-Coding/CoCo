<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/listtype.php');
	return;
}

$type = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $_REQUEST['type']);
if ($type == 1)      $g5['title'] = '히트상품';
else if ($type == 2) $g5['title'] = '추천상품';
else if ($type == 3) $g5['title'] = '최신상품';
else if ($type == 4) $g5['title'] = '인기상품';
else if ($type == 5) $g5['title'] = '할인상품';
else alert('상품유형이 아닙니다.');

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

// 유형별 상품리스트 옵션
$list_mod   = $default['de_listtype_list_mod'];    // 한줄에 이미지 몇개씩 출력
$list_row   = $default['de_listtype_list_row'];    // 한 페이지에 몇라인씩 출력
$img_width  = $default['de_listtype_img_width'];  // 출력이미지 폭

// 상품 출력순서가 있다면
$order_by = ' it_order, it_id desc ';
if ($sort != '')
	$order_by = $sort.' '.$sortodr.' , it_order, it_id desc';
else
	$order_by = 'it_order, it_id desc';

if (!$skin)
    $skin = $default['de_listtype_list_skin'] ? $default['de_listtype_list_skin']: 'list.10.skin.php';
else
    $skin = preg_replace('#\.+[\\\/]#', '', $skin);

// 리스트 유형별로 출력
$list_file = EYOOM_SHOP_PATH.'/'.$skin;

if (file_exists($list_file)) {
	// 총몇개 = 한줄에 몇개 * 몇줄
	$items = $list_mod * $list_row;
	// 페이지가 없으면 첫 페이지 (1 페이지)
	if ($page < 1) $page = 1;
	// 시작 레코드 구함
	$from_record = ($page - 1) * $items;
	
	$list = new item_list();
	$list->tpl_name = $tpl_name;
	$list->theme = $shop_theme;
	$list->eyoom = $eyoom;
	$list->set_type($type);
	$list->set_list_skin($list_file);
	$list->set_list_mod($list_mod);
	$list->set_list_row($list_row);
	$list->set_img_size($img_width, $img_height);
	$list->set_is_page(true);
	$list->set_order_by($order_by);
	$list->set_from_record($from_record);
	$list->set_view('sns', true);
	$list_package = $list->run();
	
	// where 된 전체 상품수
	$total_count = $list->total_count;
	// 전체 페이지 계산
	$total_page  = ceil($total_count / $items);
}

// Paging 
$qstr .= '&amp;type='.$type.'&amp;sort='.$sort;
$paging = $thema->pg_pages($tpl_name,$_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page=');

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'listtype.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/listtype.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');