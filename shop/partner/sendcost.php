<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$list = array();

// 검색
$sql_search = "";
if ($stx) {
	if($sfl == "od_id") {
		$stx = str_replace("-", "", $stx);
	}
	$sql_search .= " and {$sfl} like '%$stx%' ";
}

//조회기간이 있으면
$sql_date = '';
if(isset($fr_date) && $fr_date && isset($to_date) && $to_date) {
	$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
	$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);
	$sql_date .= "and SUBSTRING(sc_datetime,1,10) between '$fr_day' and '$to_day'";
	$qstr .= '&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date;

} else {
	$fr_date = $to_date = '';
}

$rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];

$sql_common = " from {$g5['apms_sendcost']} where pt_id = '{$member['mb_id']}' and sc_flag = '1' $sql_search $sql_date ";

$row = sql_fetch(" select count(*) as cnt {$sql_common} ");
$total_count = $row['cnt'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
$page = ($page > 1) ? $page : 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$start_rows = ($page - 1) * $rows; // 시작 열을 구함
$list_num = $total_count - ($page - 1) * $rows;
$result = sql_query(" select * $sql_common order by sc_id desc limit $start_rows, $rows ", false);
for ($i=0; $row=sql_fetch_array($result); $i++) { 

	$list[$i] = $row;
	$list[$i]['num'] = $list_num;
	$list[$i]['inquiry'] = './inquiryview.php?no='.$row['od_id'];
	$list[$i]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];

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

	if(!$list[$i]['it_name']) {
		$it = apms_it($row['it_id']);
		$list[$i]['it_name'] = $it['it_name'];
	}

	$list_num--;
}

//print_r2($list);

// 페이징
$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './?ap='.$ap.$qstr.'&amp;page=';

include_once($skin_path.'/sendcost.skin.php');

?>
