<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$list = array();

// 검색
$sql_search = "";
if ($stx) {
	if($sfl == 'a.od_id') {
		$stx = str_replace("-", "", $stx);
	}
	$sql_search .= " and $sfl like '%$stx%' ";
}

//조회기간이 있으면
$sql_date = '';
if(isset($fr_date) && $fr_date && isset($to_date) && $to_date) {
	$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
	$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);
	$sql_date .= "and SUBSTRING(a.pt_datetime,1,10) between '$fr_day' and '$to_day'";
	$qstr .= '&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date;

} else {
	$fr_date = $to_date = '';
}

$sql_common = " from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_order_table']} b on ( a.od_id = b.od_id ) where a.pt_id = '{$member['mb_id']}' and a.ct_status = '취소' and a.ct_select = '1' and b.od_refund_price > 0 $sql_date $sql_search ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_'.MOBILE_.'page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select a.*, a.pt_commission as commission, a.pt_incentive as incentive, SUBSTRING(a.pt_datetime,1,16) as date $sql_common order by a.pt_datetime desc, a.ct_id desc limit $from_record, $rows ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['num'] = $total_count - ($page - 1) * $rows - $i;
	$list[$i]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
	$list[$i]['inquiry'] = './inquiryview.php?no='.$row['od_id'];
	$list[$i]['sale'] = $row['pt_sale'];
	$list[$i]['qty'] = $row['ct_qty'];
	$list[$i]['point'] = $row['pt_point'];

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

	//매출
	$netsale = $row['pt_sale'] - $row['commission'] - $row['pt_point'] + $row['incentive'];
	$list[$i]['netsale'] = $netsale;
	$list[$i]['net'] = $row['pt_net'];
	$list[$i]['vat'] = ($netsale - $row['pt_net']);

	//옵션
	$list[$i]['option'] = $row['ct_option'].' '.number_format($row['ct_qty']).'개';
	if($row['pt_msg1']) {
		$list[$i]['option'] .= '<div>'.get_text($row['pt_msg1']).'</div>';
	}
	if($row['pt_msg2']) {
		$list[$i]['option'] .= '<div>'.get_text($row['pt_msg2']).'</div>';
	}
	if($row['pt_msg3']) {
		$list[$i]['option'] .= '<div>'.get_text($row['pt_msg3']).'</div>';
	}

	//구매회원
	$list[$i]['buyer'] = '비회원';
	if($row['mb_id']) {
		$mb = get_member($row['mb_id'], 'mb_nick, mb_email, mb_homepage');
		if($mb['mb_nick']) {
			$list[$i]['buyer'] = apms_sideview($row['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['wr_homepage']);
		}
	}
}

// 페이징
$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './?ap='.$ap.'&amp;'.$qstr.'&amp;page=';

include_once($skin_path.'/cancelitem.skin.php');

?>
