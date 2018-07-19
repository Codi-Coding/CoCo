<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/event.php');
	return;
}

$sql = " select * from {$g5['g5_shop_event_table']}
			where ev_id = '$ev_id'
			and ev_use = 1 ";
$ev = sql_fetch($sql);
if (!$ev['ev_id'])
	alert('등록된 이벤트가 없습니다.');
	
$g5['title'] = $ev['ev_subject'];

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

$himg = G5_DATA_PATH.'/event/'.$ev_id.'_h';
$timg = G5_DATA_PATH.'/event/'.$ev_id.'_t';

// 상품 출력순서가 있다면
if ($sort != "")
	$order_by = $sort.' '.$sortodr.' , b.it_order, b.it_id desc';
else
	$order_by = 'b.it_order, b.it_id desc';

if ($skin)
	$ev['ev_skin'] = $skin;
	
// 리스트 유형별로 출력
$list_file = EYOOM_SHOP_PATH."/{$ev['ev_skin']}";

if (file_exists($list_file))
{
	@include EYOOM_SHOP_PATH.'/list.sort.skin.php';
	
	// 상품 보기 타입 변경 버튼
	@include EYOOM_SHOP_PATH.'/list.sub.skin.php';
	
	// 총몇개 = 한줄에 몇개 * 몇줄
	$items = $ev['ev_list_mod'] * $ev['ev_list_row'];
	
	// 페이지가 없으면 첫 페이지 (1 페이지)
	if ($page < 1) $page = 1;
	
	// 시작 레코드 구함
	$from_record = ($page - 1) * $items;
	
	$list = new item_list($list_file, $ev['ev_list_mod'], $ev['ev_list_row'], $ev['ev_img_width'], $ev['ev_img_height']);
	$list->tpl_name = $tpl_name;
	$list->theme = $theme;
	$list->eyoom = $eyoom;
	$list->set_event($ev['ev_id']);
	$list->set_is_page(true);
	$list->set_order_by($order_by);
	$list->set_from_record($from_record);
	
	// where 된 전체 상품수
	$total_count = $list->total_count;
	
	// 전체 페이지 계산
	$total_page  = ceil($total_count / $items);
}

// Paging
$qstr .= 'skin='.$skin.'&amp;ev_id='.$ev_id.'&amp;sort='.$sort.'&amp;sortodr='.$sortodr;
$paging = $thema->pg_pages($tpl_name,$_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page=');

$tpl->define(array(
	'list_sort_pc'	=> 'skin_pc/shop/' . $eyoom['shop_skin'] . '/list.sort.skin.html',
	'list_sort_mo'	=> 'skin_mo/shop/' . $eyoom['shop_skin'] . '/list.sort.skin.html',
	'list_sort_bs'	=> 'skin_bs/shop/' . $eyoom['shop_skin'] . '/list.sort.skin.html',
	'list_sub_pc'	=> 'skin_pc/shop/' . $eyoom['shop_skin'] . '/list.sub.skin.html',
	'list_sub_mo'	=> 'skin_mo/shop/' . $eyoom['shop_skin'] . '/list.sub.skin.html',
	'list_sub_bs'	=> 'skin_bs/shop/' . $eyoom['shop_skin'] . '/list.sub.skin.html',
));

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'event.skin.html');

$tpl->assign(array(
	'ev' => $ev,
));

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/event.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');