<?php
$sub_menu = '400400';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$where = array();

$doc = strip_tags($doc);
$sort1 = in_array($sort1, array('od_id', 'od_cart_price', 'od_receipt_price', 'od_cancel_price', 'od_misu', 'od_cash')) ? $sort1 : '';
$sort2 = in_array($sort2, array('desc', 'asc')) ? $sort2 : 'desc';
$sel_field = get_search_string($sel_field);
if( !in_array($sel_field, array('od_id', 'mb_id', 'it_name', 'od_name', 'mb_nick', 'od_tel', 'od_hp', 'od_b_name', 'od_b_tel', 'od_b_hp', 'od_deposit_name', 'od_invoice')) ){   //검색할 필드 대상이 아니면 값을 제거
    $sel_field = '';
}
$od_status = get_search_string($od_status);
$search = get_search_string($search);
if(! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = '';
if(! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = '';

$sql_search = "";
if ($search != "") {
    if ($sel_field != "") {
	    // 상품명 검색
	    if ($sel_field == 'it_name') {
		    $sql = "select od_id from {$g5['g5_shop_cart_table']} where it_name like '%$search%' ";
		    $res = sql_query($sql);
		    for ($i=0; $row=sql_fetch_array($res); $i++) {
			    $s_od_id[$row['od_id']] = $row['od_id'];
		    }
		    
		    if (isset($s_od_id) && is_array($s_od_id)) {
			    $where[] = " find_in_set(od_id, '".implode(',', $s_od_id)."') > 0 ";
		    }
	    } else if ($sel_field == 'mb_nick') {
		    $sql = "select mb_id from {$g5['member_table']} where mb_nick like '%$search%' ";
		    $res = sql_query($sql);
		    for ($i=0; $row=sql_fetch_array($res); $i++) {
			    $s_mb_id[$row['mb_id']] = $row['mb_id'];
		    }
		    
		    if (isset($s_mb_id) && is_array($s_mb_id)) {
			    $where[] = " find_in_set(mb_id, '".implode(',', $s_mb_id)."') > 0 ";
		    }
	    } else {
		    $where[] = " $sel_field like '%$search%' ";
	    }
    }

    if ($save_search != $search) {
        $page = 1;
    }
}

if ($od_status) {
    switch($od_status) {
        case '전체취소':
            $where[] = " od_status = '취소' ";
            break;
        case '부분취소':
            $where[] = " od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0 ";
            break;
        default:
            $where[] = " od_status = '$od_status' ";
            break;
    }

    switch ($od_status) {
        case '주문' :
            $sort1 = "od_id";
            $sort2 = "desc";
            break;
        case '입금' :   // 결제완료
            $sort1 = "od_receipt_time";
            $sort2 = "desc";
            break;
        case '배송' :   // 배송중
            $sort1 = "od_invoice_time";
            $sort2 = "desc";
            break;
    }
}

if ($od_settle_case) {
    $where[] = " od_settle_case = '$od_settle_case' ";
}

if ($od_misu) {
    $where[] = " od_misu != 0 ";
}

if ($od_cancel_price) {
    $where[] = " od_cancel_price != 0 ";
}

if ($od_refund_price) {
    $where[] = " od_refund_price != 0 ";
}

if ($od_receipt_point) {
    $where[] = " od_receipt_point != 0 ";
}

if ($od_coupon) {
    $where[] = " ( od_cart_coupon > 0 or od_coupon > 0 or od_send_coupon > 0 ) ";
}

if ($od_escrow) {
    $where[] = " od_escrow = 1 ";
}

if ($fr_date && $to_date) {
    $where[] = " od_time between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
}

if ($where) {
    $sql_search = ' where '.implode(' and ', $where);
}

if ($sel_field == "")  $sel_field = "od_id";
if ($sort1 == "") $sort1 = "od_id";
if ($sort2 == "") $sort2 = "desc";

$sql_common = " from {$g5['g5_shop_order_table']} $sql_search ";

$sql = " select count(od_id) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select *,
            (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           $sql_common
           order by $sort1 $sort2
           limit $from_record, $rows ";
$result = sql_query($sql);

$qstr1 = "od_status=".urlencode($od_status)."&amp;od_settle_case=".urlencode($od_settle_case)."&amp;od_misu=$od_misu&amp;od_cancel_price=$od_cancel_price&amp;od_refund_price=$od_refund_price&amp;od_receipt_point=$od_receipt_point&amp;od_coupon=$od_coupon&amp;fr_date=$fr_date&amp;to_date=$to_date&amp;sel_field=$sel_field&amp;search=$search&amp;save_search=$search";
if($default['de_escrow_use'])
    $qstr1 .= "&amp;od_escrow=$od_escrow";
$qstr = "$qstr1&amp;sort1=$sort1&amp;sort2=$sort2&amp;page=$page";

// 주문삭제 히스토리 테이블 필드 추가
if(!sql_query(" select mb_id from {$g5['g5_shop_order_delete_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_order_delete_table']}`
                    ADD `mb_id` varchar(20) NOT NULL DEFAULT '' AFTER `de_data`,
                    ADD `de_ip` varchar(255) NOT NULL DEFAULT '' AFTER `mb_id`,
                    ADD `de_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `de_ip` ", true);
}

$k=0;
for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$cnt = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' ");
	$info = sql_fetch(" select it_id, it_name from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' ");
	$row['it_id'] = $info['it_id'];
	$row['it_name'] = $info['it_name'];
	if ($cnt['cnt'] > 1) $row['it_name'] .= " 외 (" . ($cnt['cnt']-1) . ")건";
	$row['image'] = str_replace('"', "'", get_it_image($row['it_id'], 160, 160));
	$row['href'] = G5_SHOP_URL . '/item.php?it_id=' . $row['it_id'];

    // 결제 수단
    $s_receipt_way = $s_br = "";
    if ($row['od_settle_case'])
    {
        $s_receipt_way = $row['od_settle_case'];
        $s_br = '<br />';

        // 간편결제
        if($row['od_settle_case'] == '간편결제') {
            switch($row['od_pg']) {
                case 'lg':
                    $s_receipt_way = 'PAYNOW';
                    break;
                case 'inicis':
                    $s_receipt_way = 'KPAY';
                    break;
                case 'kcp':
                    $s_receipt_way = 'PAYCO';
                    break;
                default:
                    $s_receipt_way = $row['od_settle_case'];
                    break;
            }
        }
    }
    else
    {
        $s_receipt_way = '결제수단없음';
        $s_br = '<br />';
    }

    if ($row['od_receipt_point'] > 0)
        $s_receipt_way .= $s_br."포인트";

    $row['s_receipt_way'] = $s_receipt_way;

    $row['mbinfo'] = sql_fetch("select mb_name, mb_nick, mb_tel, mb_hp, mb_email from {$g5['member_table']} where mb_id='{$row['mb_id']}'");

    $od_cnt = 0;
    if ($row['mb_id'])
    {
        $sql2 = " select count(*) as cnt from {$g5['g5_shop_order_table']} where mb_id = '{$row['mb_id']}' ";
        $row2 = sql_fetch($sql2);
        $od_cnt = $row2['cnt'];
    }

    // 주문 번호에 device 표시
    $od_mobile = '';
    if($row['od_mobile'])
        $od_mobile = '(M)';

    // 주문번호에 - 추가
    switch(strlen($row['od_id'])) {
        case 16:
            $disp_od_id = substr($row['od_id'],0,8).'-'.substr($row['od_id'],8);
            break;
        default:
            $disp_od_id = substr($row['od_id'],0,6).'-'.substr($row['od_id'],6);
            break;
    }

    // 주문 번호에 에스크로 표시
    $od_paytype = '';
    if($row['od_test'])
        $od_paytype .= '<span class="list_test">테스트</span>';

    if($default['de_escrow_use'] && $row['od_escrow'])
        $od_paytype .= '<span class="list_escrow">에스크로</span>';

    $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

    $invoice_time = is_null_time($row['od_invoice_time']) ? G5_TIME_YMDHIS : $row['od_invoice_time'];
    $delivery_company = $row['od_delivery_company'] ? $row['od_delivery_company'] : $default['de_delivery_company'];

    $bg = 'bg'.($i%2);
    $td_color = 0;
    if($row['od_cancel_price'] > 0) {
        $bg .= 'cancel';
        $td_color = 1;
    }

    // 주문상태에 따라 색상 다르게 표시
    switch($row['od_status']) {
	    case '주문': $row['od_color'] = 'red'; break;
	    case '입금': $row['od_color'] = 'blue'; break;
	    case '준비': $row['od_color'] = 'yellow'; break;
	    case '배송': $row['od_color'] = 'green'; break;
	    case '완료': $row['od_color'] = 'default'; break;
	    case '취소': $row['od_color'] = 'brown'; break;
	    case '반품': $row['od_color'] = 'indigo'; break;
	    case '품절': $row['od_color'] = 'dark'; break;
	    default: $row['od_color'] = 'dark'; break;
    }

    $list[$i] = $row;
	$list[$i]['disp_od_id'] = $disp_od_id;
	$list[$i]['uid'] = $uid;
	$list[$i]['od_cnt'] = $od_cnt;

    $tot_itemcount     += $row['od_cart_count'];
    $tot_orderprice    += ($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']);
    $tot_ordercancel   += $row['od_cancel_price'];
    $tot_receiptprice  += $row['od_receipt_price'];
    $tot_couponprice   += $row['couponprice'];
    $tot_misu          += $row['od_misu'];
}
sql_free_result($result);

if (($od_status == '' || $od_status == '완료' || $od_status == '전체취소' || $od_status == '부분취소') == false) {
    $change_status = "";
    if ($od_status == '주문') $change_status = "입금";
    if ($od_status == '입금') $change_status = "준비";
    if ($od_status == '준비') $change_status = "배송";
    if ($od_status == '배송') $change_status = "완료";
}

// Paging
$paging = $thema->pg_pages($tpl_name,"./?dir=shop&amp;pid=orderlist&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";