<?php
$sub_menu = '400400';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "w");

$action_url1 = EYOOM_ADMIN_URL . '/?dir=shop&amp;pid=orderformcartupdate&amp;smode=1';
$action_url2 = EYOOM_ADMIN_URL . '/?dir=shop&amp;pid=orderformreceiptupdate&amp;smode=1';
$action_url3 = EYOOM_ADMIN_URL . '/?dir=shop&amp;pid=orderformupdate&amp;smode=1';

// 완료된 주문에 포인트를 적립한다.
save_order_point("완료");

//------------------------------------------------------------------------------
// 주문서 정보
//------------------------------------------------------------------------------
$sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
$od = sql_fetch($sql);
if (!$od['od_id']) {
    alert("해당 주문번호로 주문서가 존재하지 않습니다.");
}

$od['mb_id'] = $od['mb_id'] ? $od['mb_id'] : "비회원";
//------------------------------------------------------------------------------

$html_receipt_chk = '<input type="checkbox" id="od_receipt_chk" value="'.$od['od_misu'].'" onclick="chk_receipt_price()">
<label for="od_receipt_chk">결제금액 입력</label><br>';

$qstr1 = "od_status=".urlencode($od_status)."&amp;od_settle_case=".urlencode($od_settle_case)."&amp;od_misu=$od_misu&amp;od_cancel_price=$od_cancel_price&amp;od_refund_price=$od_refund_price&amp;od_receipt_point=$od_receipt_point&amp;od_coupon=$od_coupon&amp;fr_date=$fr_date&amp;to_date=$to_date&amp;sel_field=$sel_field&amp;search=$search&amp;save_search=$search";
if($default['de_escrow_use'])
    $qstr1 .= "&amp;od_escrow=$od_escrow";
$qstr = "$qstr1&amp;sort1=$sort1&amp;sort2=$sort2&amp;page=$page";

// 상품목록
$sql = " select it_id,
                it_name,
                cp_price,
                ct_notax,
                ct_send_cost,
                it_sc_type
           from {$g5['g5_shop_cart_table']}
          where od_id = '{$od['od_id']}'
          group by it_id
          order by ct_id ";
$result = sql_query($sql);

// 주소 참고항목 필드추가
if(!isset($od['od_addr3'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_order_table']}`
                    ADD `od_addr3` varchar(255) NOT NULL DEFAULT '' AFTER `od_addr2`,
                    ADD `od_b_addr3` varchar(255) NOT NULL DEFAULT '' AFTER `od_b_addr2` ", true);
}

// 배송목록에 참고항목 필드추가
if(!sql_query(" select ad_addr3 from {$g5['g5_shop_order_address_table']} limit 1", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_order_address_table']}`
                    ADD `ad_addr3` varchar(255) NOT NULL DEFAULT '' AFTER `ad_addr2` ", true);
}

// 결제 PG 필드 추가
if(!sql_query(" select od_pg from {$g5['g5_shop_order_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_order_table']}`
                    ADD `od_pg` varchar(255) NOT NULL DEFAULT '' AFTER `od_mobile`,
                    ADD `od_casseqno` varchar(255) NOT NULL DEFAULT '' AFTER `od_escrow` ", true);

    // 주문 결제 PG kcp로 설정
    sql_query(" update {$g5['g5_shop_order_table']} set od_pg = 'kcp' ");
}

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

$chk_cnt = 0;
for($i=0; $row=sql_fetch_array($result); $i++) {
    // 상품이미지
    $row['image'] = str_replace('"', "'", get_it_image($row['it_id'], 160, 160));
    $row['href'] = G5_SHOP_URL . '/item.php?it_id=' . $row['it_id'];

    // 상품의 옵션정보
    $sql = " select ct_id, it_id, ct_price, ct_point, ct_qty, ct_option, ct_status, cp_price, ct_stock_use, ct_point_use, ct_send_cost, io_type, io_price
                from {$g5['g5_shop_cart_table']}
                where od_id = '{$od['od_id']}'
                  and it_id = '{$row['it_id']}'
                order by io_type asc, ct_id asc ";
    $res = sql_query($sql);
    $rowspan = sql_num_rows($res);

    // 합계금액 계산
    $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                    SUM(ct_qty) as qty
                from {$g5['g5_shop_cart_table']}
                where it_id = '{$row['it_id']}'
                  and od_id = '{$od['od_id']}' ";
    $sum = sql_fetch($sql);

    // 배송비
    switch($row['ct_send_cost'])
    {
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
    if($row['it_sc_type'] == 2) {
        $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $od['od_id']);

        if($sendcost == 0)
            $ct_send_cost = '무료';
    }

    $loop1[$i] = $row;
    $loop1[$i]['ct_send_cost'] = $ct_send_cost;

    $loop2 = &$loop1[$i]['opt'];

    for($k=0; $opt=sql_fetch_array($res); $k++) {
        if($opt['io_type'])
            $opt_price = $opt['io_price'];
        else
            $opt_price = $opt['ct_price'] + $opt['io_price'];

        // 소계
        $ct_price['stotal'] = $opt_price * $opt['ct_qty'];
        $ct_point['stotal'] = $opt['ct_point'] * $opt['ct_qty'];

        $loop2[$k] = $opt;
        $loop2[$k]['opt_price'] = $opt_price;
        $loop2[$k]['ct_price'] = $ct_price['stotal'];
        $loop2[$k]['ct_point'] = $ct_point['stotal'];
        $loop2[$k]['chk_cnt'] = $chk_cnt;

        $chk_cnt++;
    }
}

// 주문금액 = 상품구입금액 + 배송비 + 추가배송비
$amount['order'] = $od['od_cart_price'] + $od['od_send_cost'] + $od['od_send_cost2'];

// 입금액 = 결제금액 + 포인트
$amount['receipt'] = $od['od_receipt_price'] + $od['od_receipt_point'];

// 쿠폰금액
$amount['coupon'] = $od['od_cart_coupon'] + $od['od_coupon'] + $od['od_send_coupon'];

// 취소금액
$amount['cancel'] = $od['od_cancel_price'];

// 미수금 = 주문금액 - 취소금액 - 입금금액 - 쿠폰금액
//$amount['미수'] = $amount['order'] - $amount['receipt'] - $amount['coupon'];

// 결제방법
$s_receipt_way = $od['od_settle_case'];

if($od['od_settle_case'] == '간편결제') {
    switch($od['od_pg']) {
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

if ($od['od_receipt_point'] > 0)
    $s_receipt_way .= "+포인트";

/**
 * 결제상세정보
 */
if ($od['od_misu'] == 0 && $od['od_receipt_price'] && ($od['od_settle_case'] == '무통장' || $od['od_settle_case'] == '가상계좌' || $od['od_settle_case'] == '계좌이체')) {
	if ($od['od_cash']) {
	    if($od['od_pg'] == 'lg') {
	        require G5_SHOP_PATH.'/settle_lg.inc.php';

	        switch($od['od_settle_case']) {
	            case '계좌이체':
	                $trade_type = 'BANK';
	                break;
	            case '가상계좌':
	                $trade_type = 'CAS';
	                break;
	            default:
	                $trade_type = 'CR';
	                break;
	        }
	        $cash_receipt_script = 'javascript:showCashReceipts(\''.$LGD_MID.'\',\''.$od['od_id'].'\',\''.$od['od_casseqno'].'\',\''.$trade_type.'\',\''.$CST_PLATFORM.'\');';
	    } else if($od['od_pg'] == 'inicis') {
	        $cash = unserialize($od['od_cash_info']);
	        $cash_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid='.$cash['TID'].'&clpaymethod=22\',\'showreceipt\',\'width=380,height=540,scrollbars=no,resizable=no\');';
	    } else {
	        require G5_SHOP_PATH.'/settle_kcp.inc.php';

	        $cash = unserialize($od['od_cash_info']);
	        $cash_receipt_script = 'window.open(\''.G5_CASH_RECEIPT_URL.$default['de_kcp_mid'].'&orderid='.$od_id.'&bill_yn=Y&authno='.$cash['receipt_no'].'\', \'taxsave_receipt\', \'width=360,height=647,scrollbars=0,menus=0\');';
	    }
	}
}

if ($od['od_settle_case'] == '무통장' || $od['od_settle_case'] == '가상계좌' || $od['od_settle_case'] == '계좌이체') {
    if ($od['od_settle_case'] == '무통장')
    {
        // 은행계좌를 배열로 만든후
        $str = explode("\n", $default['de_bank_account']);
        $bank_account .= '<label class="select"><select name="od_bank_account" id="od_bank_account">'.PHP_EOL;
        $bank_account .= '<option value="">선택하십시오</option>'.PHP_EOL;
        for ($i=0; $i<count($str); $i++) {
            $str[$i] = str_replace("\r", "", $str[$i]);
            $bank_account .= '<option value="'.$str[$i].'" '.get_selected($od['od_bank_account'], $str[$i]).'>'.$str[$i].'</option>'.PHP_EOL;
        }
        $bank_account .= '</select><i></i></label>';
    }
    else if ($od['od_settle_case'] == '가상계좌')
        $bank_account = $od['od_bank_account'].'<label class="input"><input type="hidden" name="od_bank_account" value="'.$od['od_bank_account'].'"></label>';
    else if ($od['od_settle_case'] == '계좌이체')
        $bank_account = $od['od_settle_case'];
}

/**
 * 탭메뉴 링크생성
 */
$anchor_skin = "skin_bs/shop/basic/orderform_anchor.skin.html";
adm_pg_anchor('anc_sodr_list', $anchor_skin);
adm_pg_anchor('anc_sodr_pay', $anchor_skin);
adm_pg_anchor('anc_sodr_chk', $anchor_skin);
adm_pg_anchor('anc_sodr_paymo', $anchor_skin);
adm_pg_anchor('anc_sodr_memo', $anchor_skin);
adm_pg_anchor('anc_sodr_orderer', $anchor_skin);
adm_pg_anchor('anc_sodr_taker', $anchor_skin);

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'list' 	=> $loop1,
	'od' 	=> $od,
));
