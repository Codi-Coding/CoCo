<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/personalpay.php');
	return;
}

$g5['title'] = '개인결제 리스트';

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

$list_mod   = 3;
$list_row   = 5;
$img_width  = 230;
$img_height = 230;

$sql_common = " from {$g5['g5_shop_personalpay_table']}
				where pp_use = '1'
					and pp_tno = '' ";

// 총몇개 = 한줄에 몇개 * 몇줄
$items = $list_mod * $list_row;

$sql = "select COUNT(*) as cnt $sql_common ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 전체 페이지 계산
$total_page  = ceil($total_count / $items);
// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;
// 시작 레코드 구함
$from_record = ($page - 1) * $items;

$sql = " select *
			$sql_common
			order by pp_id desc
			limit $from_record, $items";
$result = sql_query($sql);

for ($i=1; $row=sql_fetch_array($result); $i++) {
	if ($list_mod >= 2) { // 1줄 이미지 : 2개 이상
		if ($i%$list_mod == 0) $sct_last = ' sct_last'; // 줄 마지막
		else if ($i%$list_mod == 1) $sct_last = ' sct_clear'; // 줄 첫번째
		else $sct_last = '';
	} else { // 1줄 이미지 : 1개
		$sct_last = ' sct_clear';
	}
	$href = G5_SHOP_URL.'/personalpayform.php?pp_id='.$row['pp_id'].'&amp;page='.$page;
	$list[$i] = $row;
	$list[$i]['href'] = $href;
	$list[$i]['sct_last'] = $sct_last;
}
$count = count($list);

// Paging 
$query_string .= 'ca_id='.$ca_id.'&amp;q='.urlencode($q);
$query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
$paging = $thema->pg_pages($tpl_name,$_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'personalpay.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/personalpay.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');