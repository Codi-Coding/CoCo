<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 컨텐츠상품
$ct_it = implode(",", $g5['apms_automation']);

// 업데이트하기
if($save) {
    for ($i=0; $i<count($_POST['od_id']); $i++) {

		if(!$_POST['od_id'][$i] || !$_POST['it_id'][$i]) continue;

		if($_POST['pt_send'][$i] && $_POST['pt_send_num'][$i]) {
			$ct_status = '배송';
		} else if($_POST['ct_status'][$i] == '입금' || $_POST['ct_status'][$i] == '준비' || $_POST['ct_status'][$i] == '배송') {
			$ct_status = $_POST['ct_status'][$i];
		} else {
			continue;
		}

        $sql = "update {$g5['g5_shop_cart_table']}
                   set pt_send        = '".addslashes($_POST['pt_send'][$i])."',
                       pt_send_num    = '".addslashes($_POST['pt_send_num'][$i])."',
                       ct_status	  = '{$ct_status}'
                 where od_id = '{$_POST['od_id'][$i]}' and it_id = '{$_POST['it_id'][$i]}' and pt_id = '{$member['mb_id']}' and find_in_set(pt_it, '{$ct_it}')=0 and ct_select = '1' ";
        sql_query($sql);
    }
	
	//이동하기
	if($done == "1") { //미배송건은 페이지 없음
		goto_url('./?ap='.$ap.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;done='.$done.'&amp;save_stx='.$stx.'&amp;stx='.$stx);
	} else {
		goto_url('./?ap='.$ap.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;done='.$done.'&amp;save_stx='.$stx.'&amp;stx='.$stx.'&amp;page='.$page);
	}
}

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$list = array();

$fr_date = ($fr_date) ? $fr_date : date("Ymd", G5_SERVER_TIME - 15*86400); //보름전
$to_date = ($to_date) ? $to_date : date("Ymd", G5_SERVER_TIME); //오늘

$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);

// 상태
if(isset($done) && $done) { 
	$ct_status = ($done == "2") ? '배송' : '입금,준비'; 
} else { 
	$ct_status = '입금,준비,배송'; 
} 

// 검색
$sql_search = "";
if ($stx) {
	$stx = str_replace("-", "", $stx);
	$sql_search .= " and od_id like '%$stx%' ";
    if ($save_stx != $stx)
        $page = 1;
}

$sql_common = " from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '{$ct_status}') and find_in_set(pt_it, '{$ct_it}')=0 and pt_id = '{$member['mb_id']}' and ct_select = '1' $sql_search and SUBSTRING(ct_select_time,1,10) between '$fr_day' and '$to_day' group by od_id ";

$cnt = sql_query(" select count(*) as cnt $sql_common ");
$total_cnt = @sql_num_rows($cnt);

sql_free_result($cnt);

$rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];

$total_count = $total_cnt;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
$page = ($page > 1) ? $page : 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$start_rows = ($page - 1) * $rows; // 시작 열을 구함
$list_num = $total_count - ($page - 1) * $rows;
$result = sql_query(" select od_id $sql_common order by od_id desc limit $start_rows, $rows ", false);
for ($i=0; $row=sql_fetch_array($result); $i++) { 

	// 주문정보
	$list[$i] = sql_fetch(" select * from {$g5['g5_shop_order_table']} where od_id = '{$row['od_id']}' ");
	$list[$i]['num'] = $list_num;

	// 배송정보
	$list[$i]['od_id'] = $row['od_id'];

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

	// 주문자
	$list[$i]['od_name'] = apms_sideview($list[$i]['mb_id'], get_text($list[$i]['od_name']), $list[$i]['od_email'], '');

	$list[$i]['inquiry'] = './inquiryview.php?no='.$row['od_id'];

	// 주문상품
	$sql1 = " select a.od_id, a.ct_status, a.it_id, a.it_name, a.ct_send_cost, a.it_sc_type, a.pt_send, a.pt_send_num, b.pt_msg1, b.pt_msg2, b.pt_msg3
			  from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
			  where a.od_id = '{$row['od_id']}' and find_in_set(a.ct_status, '{$ct_status}') and find_in_set(a.pt_it, '{$ct_it}')=0 and a.pt_id = '{$member['mb_id']}' and a.ct_select = '1'
			  group by a.it_id
			  order by a.ct_id ";

	$result1 = sql_query($sql1);
	for($j=0; $row1=sql_fetch_array($result1); $j++) {

		$list[$i]['it'][$j] = $row1;

		// 상품명
		$list[$i]['it'][$j]['name'] = stripslashes($row1['it_name']);
		$list[$i]['it'][$j]['img'] = get_it_image($row1['it_id'], 50, 50);

		// 상품주소
		$list[$i]['it'][$j]['href'] = G5_SHOP_URL.'/item.php?it_id='.$list[$i]['it'][$j]['it_id'];

		// 상품옵션
		$list[$i]['it'][$j]['option'] = print_item_options($row1['it_id'], $row['od_id'], $row1['pt_msg1'], $row1['pt_msg2'], $row1['pt_msg3'], $ct_status, 1);

		// 합계금액 계산
		$sql2 = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
					SUM(ct_qty) as qty
					from {$g5['g5_shop_cart_table']}
					where it_id = '{$row1['it_id']}'
					and od_id = '{$row['od_id']}' ";
		$sum = sql_fetch($sql2);

		// 배송비
		switch($row1['ct_send_cost']) {
			case 1:
				$ct_send_cost = '착불';
				break;
			case 2:
				$ct_send_cost = '무료';
				break;
			default:
				$ct_send_cost = '선불';
				break;
		}

		// 조건부무료
		if($row1['it_sc_type'] == 2) {
			$sendcost = get_item_sendcost($row1['it_id'], $sum['price'], $sum['qty'], $row['od_id']);

			if($sendcost == 0)
				$ct_send_cost = '무료';
		}

		$list[$i]['it'][$j]['sendcost'] = $ct_send_cost;

		$cost = sql_fetch("select sc_price from {$g5['apms_sendcost']} where it_id = '{$row1['it_id']}'	and od_id = '{$row['od_id']}' and pt_id = '{$row['pt_id']}' ", false);

		$list[$i]['it'][$j]['sc_price'] = $cost['sc_price'];

		// 문의전화
		$list[$i]['it'][$j]['tel'] = get_delivery_inquiry($row1['pt_send'], $row1['pt_send_num']);
	}

	// 셀합치기
	$list[$i]['rowspan'] = ($j > 1) ? $j : 0;
	$list_num--;
}

//print_r2($list);

// 페이징
$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './?ap='.$ap.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;done='.$done.'&amp;save_stx='.$stx.'&amp;stx='.$stx.'&amp;page=';

// 스킨
include_once($skin_path.'/delivery.skin.php');

?>