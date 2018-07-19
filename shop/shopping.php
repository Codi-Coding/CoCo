<?php
include_once('./_common.php');

if ($is_guest)
    alert_close('회원만 이용가능합니다.');

// 수령완료처리
if($mode == "4") {

	if(!$od_id || !$it_id) {
        alert("값이 제대로 넘어오지 않았습니다.");
	}

	$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_order_table']} where od_id = '$od_id' and mb_id = '{$member['mb_id']}' ");
	if (!$row['cnt']) {
		alert("수령확인하실 주문서가 없습니다.");
	}

	// 개별상품처리
	$sql = " select ct_id from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and it_id = '$it_id' and ct_select = '1' and mb_id = '{$member['mb_id']}' ";
	$result = sql_query($sql);
	for($i=0; $row=sql_fetch_array($result); $i++) {
		apms_order_it($row['ct_id'], $member['mb_id']);
	}

	// 주문서 완료처리
	$sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_status <> '완료' and ct_select = '1' and mb_id = '{$member['mb_id']}' ";
	$row = sql_fetch($sql);
	if(!$row['cnt']) {
		sql_query(" update {$g5['g5_shop_order_table']} set od_status = '완료' where od_id = '$od_id' and mb_id = '{$member['mb_id']}' ");
	}

	// 페이지 이동
	goto_url('./shopping.php?mode=2&amp;page='.$page);
}

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

$g5['title'] = $member['mb_nick'].' 님의 쇼핑리스트';
include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

$list = array();

switch($mode) {
	case '2'	: $ct_status = '배송'; break;
	case '3'	: $ct_status = '입금, 준비'; break;
	default		: $ct_status = '완료'; $mode = 1; break;
}

$sql_common1 = " from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '{$ct_status}') and mb_id = '{$member['mb_id']}' and ct_select = '1' group by od_id, it_id ";

$cnt = sql_query(" select count(*) as cnt $sql_common1 ");
$total_cnt = @sql_num_rows($cnt);

sql_free_result($cnt);

$sql_common2 = " from {$g5['g5_shop_cart_table']} a left join {$g5['member_table']} b on ( a.pt_id = b.mb_id ) where find_in_set(a.ct_status, '{$ct_status}') and a.mb_id = '{$member['mb_id']}' and a.ct_select = '1' group by a.od_id, a.it_id ";

$rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];

$total_count = $total_cnt;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
$page = ($page > 1) ? $page : 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$start_rows = ($page - 1) * $rows; // 시작 열을 구함
$list_num = $total_count - ($page - 1) * $rows;
$result = sql_query(" select a.*, b.mb_nick, b.mb_email, b.mb_homepage $sql_common2 order by a.od_id desc limit $start_rows, $rows ", false);
for ($i=0; $row=sql_fetch_array($result); $i++) { 

	// 주문정보
	$list[$i] = $row;
	$list[$i]['num'] = $list_num;

	// 판매자
	if(USE_PARTNER && $row['pt_id'] && $row['mb_nick']) {
		$list[$i]['seller'] = apms_sideview($row['pt_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);
	}

	// 주문번호에 - 추가
	switch(strlen($row['od_id'])) {
		case 16:
			$disp_od_id = substr($row['od_id'],0,8).'-'.substr($row['od_id'],8);
			break;
		default:
			$disp_od_id = substr($row['od_id'],0,6).'-'.substr($row['od_id'],6);
			break;
	}

	$list[$i]['od_num'] = $disp_od_id; 

	$list[$i]['od_href'] = G5_SHOP_URL.'/orderinquiryview.php?od_id='.$row['od_id'];

	$list[$i]['it_href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];

	$list[$i]['option'] = print_item_options($row['it_id'], $row['od_id'], '', '', '', $ct_status, 1);

	// 상품구분
	if(in_array($row['pt_it'], $g5['apms_automation'])) {
		// 배송불가 - 컨텐츠
		$list[$i]['is_delivery'] = false;

		// 이용정보
		if($mode == "1") {
			$use = sql_fetch(" select use_cnt, use_file, use_datetime from {$g5['apms_use_log']} where od_id = '$od_id' and it_id = '$it_id' and mb_id = '{$member['mb_id']}' ", false);
			$list[$i]['use_cnt'] = $use['use_cnt'];
			$list[$i]['use_date'] = $use['use_datetime'];
			$list[$i]['use_file'] = $use['use_file'];
		}
	} else {
		// 배송가능
		$list[$i]['is_delivery'] = true;

		// 수령확인
		if($mode == "2") {
			$list[$i]['de_confirm'] = G5_SHOP_URL.'/shopping.php?mode=4&amp;od_id='.$row['od_id'].'&amp;it_id='.urlencode($row['it_id']).'&amp;page='.$page;
		}

		// 배송정보
		if(USE_PARTNER && $row['pt_id']) {
			$list[$i]['de_company'] = $row['pt_send'];
			$list[$i]['de_invoice'] = $row['pt_send_num'];
			$list[$i]['de_check'] = get_delivery_inquiry($row['pt_send'], $row['pt_send_num']);
		} else {
			$od = sql_fetch(" select od_delivery_company, od_invoice from {$g5['g5_shop_order_table']} where od_id = '$od_id' and mb_id = '{$member['mb_id']}' ");
			$list[$i]['de_company'] = $od['od_delivery_company'];
			$list[$i]['de_invoice'] = $od['od_invoice'];
			$list[$i]['de_check'] = get_delivery_inquiry($od['od_delivery_company'], $od['od_invoice']);
		}
	}

	$list_num--;
}

$write_page_rows = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['PHP_SELF'].'?mode='.$mode.'&amp;page=';

include_once($skin_path.'/shopping.skin.php');
@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');
?>
