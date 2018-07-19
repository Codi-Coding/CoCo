<?php
if (!defined('_SHOP_')) exit;

if( isset($sfl) && ! in_array($sfl, array('b.it_name', 'a.it_id', 'a.is_subject', 'a.is_content', 'a.is_name', 'a.mb_id')) ){
    //다른값이 들어가있다면 초기화
    $sfl = '';
}

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/itemuselist.php');
	return;
}

$g5['title'] = '사용후기';

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

$sql_common = " from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) ";
$sql_search = " where a.is_confirm = '1' ";

if(!$sfl)
	$sfl = 'b.it_name';

if ($stx) {
	$sql_search .= " and ( ";
	switch ($sfl) {
		case "a.it_id" :
			$sql_search .= " ($sfl like '$stx%') ";
			break;
		case "a.is_name" :
		case "a.mb_id" :
			$sql_search .= " ($sfl = '$stx') ";
			break;
		default :
			$sql_search .= " ($sfl like '%$stx%') ";
			break;
	}
	$sql_search .= " ) ";
}

if (!$sst) {
	$sst  = "a.is_id";
	$sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
			$sql_common
			$sql_search
			$sql_order ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
			$sql_common
			$sql_search
			$sql_order
			limit $from_record, $rows ";
$result = sql_query($sql);

$thumbnail_width = 500;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$num = $total_count - ($page - 1) * $rows - $i;
	$star = get_star($row['is_score']);
	$is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
	$row2 = sql_fetch(" select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['it_id']}' ");
	
	$list[$i]['it_href'] = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";
	$list[$i]['it_id'] = $row['it_id'];
	$list[$i]['is_content'] = $row['is_content'];
	$list[$i]['is_tcontent'] = $is_content;
	$list[$i]['is_subject'] = $row['is_subject'];
	$list[$i]['is_name'] = $row['is_name'];
	$list[$i]['is_time'] = $row['is_time'];
	$list[$i]['it_name'] = $row2['it_name'];
	$list[$i]['star'] = $star;
}
$count = count($list);

// Paging 
$paging = $thema->pg_pages($tpl_name,$_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=');

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'item_uselist.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/itemuselist.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');