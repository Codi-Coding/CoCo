<?php
if (!defined('_SHOP_')) exit;

$od_id = isset($od_id) ? preg_replace('/[^A-Za-z0-9\-_]/', '', strip_tags($od_id)) : 0;

if( isset($_GET['ini_noti']) && !isset($_GET['uid']) ){
    goto_url(G5_SHOP_URL.'/orderinquiry.php');
}

// 불법접속을 할 수 없도록 세션에 아무값이나 저장하여 hidden 으로 넘겨서 다음 페이지에서 비교함
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

if (!$is_member) {
	if (get_session('ss_orderview_uid') != $_GET['uid'])
		alert("직접 링크로는 주문서 조회가 불가합니다.\\n\\n주문조회 화면을 통하여 조회하시기 바랍니다.", G5_SHOP_URL);
}

$sql = "select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
if($is_member && !$is_admin)
	$sql .= " and mb_id = '{$member['mb_id']}' ";
$od = sql_fetch($sql);
if (!$od['od_id'] || (!$is_member && md5($od['od_id'].$od['od_time'].$od['od_ip']) != get_session('ss_orderview_uid'))) {
	alert("조회하실 주문서가 없습니다.", G5_SHOP_URL);
}

// 결제방법
$settle_case = $od['od_settle_case'];

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/orderinquiryview.php');
	return;
}

// 테마에 orderinquiryview.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_inquiryview_file = G5_THEME_SHOP_PATH.'/orderinquiryview.php';
    if(is_file($theme_inquiryview_file)) {
        include_once($theme_inquiryview_file);
        return;
        unset($theme_inquiryview_file);
    }
}

$g5['title'] = '주문상세내역';

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

// LG 현금영수증 JS
if($od['od_pg'] == 'lg') {
    if($default['de_card_test']) {
    	echo '<script language="JavaScript" src="http://pgweb.uplus.co.kr:7085/WEB_SERVER/js/receipt_link.js"></script>'.PHP_EOL;
    } else {
		echo '<script language="JavaScript" src="http://pgweb.uplus.co.kr/WEB_SERVER/js/receipt_link.js"></script>'.PHP_EOL;
    }
}

$st_count1 = $st_count2 = 0;
$custom_cancel = false;

$sql = " select it_id, it_name, ct_send_cost, it_sc_type
			from {$g5['g5_shop_cart_table']}
			where od_id = '$od_id'
			group by it_id
			order by ct_id ";
$result = sql_query($sql);

for($i=0; $row=sql_fetch_array($result); $i++) {
	$image = get_it_image($row['it_id'], 200, 0);
	
	$sql = " select ct_id, it_name, ct_option, ct_qty, ct_price, ct_point, ct_status, io_type, io_price
				from {$g5['g5_shop_cart_table']}
				where od_id = '$od_id'
					and it_id = '{$row['it_id']}'
				order by io_type asc, ct_id asc ";
	$res = sql_query($sql);
	$rowspan = sql_num_rows($res) + 1;
	
	// 합계금액 계산
	$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
					SUM(ct_qty) as qty
				from {$g5['g5_shop_cart_table']}
				where it_id = '{$row['it_id']}'
					and od_id = '$od_id' ";
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
		$sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $od_id);
		
		if($sendcost == 0)
			$ct_send_cost = '무료';
	}
	
	$order[$i] = $row;
	$order[$i]['rowspan'] = $rowspan;
	$order[$i]['image'] = $image;
	$order[$i]['ct_send_cost'] = $ct_send_cost;
	
	$loop = &$order[$i]['option'];
	for($k=0; $opt=sql_fetch_array($res); $k++) {
		if($opt['io_type'])
			$opt_price = $opt['io_price'];
		else
			$opt_price = $opt['ct_price'] + $opt['io_price'];
		
		$sell_price = $opt_price * $opt['ct_qty'];
		$point = $opt['ct_point'] * $opt['ct_qty'];
		
		$loop[$k] = $opt;
		$loop[$k]['opt_price'] = $opt_price;
		$loop[$k]['sell_price'] = $sell_price;
		$loop[$k]['point'] = $point;
		
		$tot_point += $point;
		
		$st_count1++;
		if($opt['ct_status'] == '주문')
			$st_count2++;
	}
	$order[$i]['cnt'] = count($loop);
}

// 주문 상품의 상태가 모두 주문이면 고객 취소 가능
if($st_count1 > 0 && $st_count1 == $st_count2)
	$custom_cancel = true;

// 총계 = 주문상품금액합계 + 배송비 - 상품할인 - 결제할인 - 배송비할인
$tot_price = $od['od_cart_price'] + $od['od_send_cost'] + $od['od_send_cost2']
				- $od['od_cart_coupon'] - $od['od_coupon'] - $od['od_send_coupon']
				- $od['od_cancel_price'];

// 결제/배송 정보
$receipt_price  = $od['od_receipt_price']
				+ $od['od_receipt_point'];
$cancel_price   = $od['od_cancel_price'];

$misu = true;
$misu_price = $tot_price - $receipt_price - $cancel_price;

if ($misu_price == 0 && ($od['od_cart_price'] > $od['od_cancel_price'])) {
	$wanbul = " (완불)";
	$misu = false; // 미수금 없음
}
else
{
	$wanbul = display_price($receipt_price);
}

// 결제정보처리
if($od['od_receipt_price'] > 0)
	$od_receipt_price = display_price($od['od_receipt_price']);
else
	$od_receipt_price = '아직 입금되지 않았거나 입금정보를 입력하지 못하였습니다.';

$app_no_subj = '';
$disp_bank = true;
$disp_receipt = false;
if($od['od_settle_case'] == '신용카드' || $od['od_settle_case'] == 'KAKAOPAY' || is_inicis_order_pay($od['od_settle_case']) ) {
	$app_no_subj = '승인번호';
	$app_no = $od['od_app_no'];
	$disp_bank = false;
	$disp_receipt = true;
} else if($od['od_settle_case'] == '간편결제') {
	$app_no_subj = '승인번호';
	$app_no = $od['od_app_no'];
	$disp_bank = false;
	switch($od['od_pg']) {
		case 'lg':
			$easy_pay_name = 'PAYNOW';
			break;
		case 'inicis':
			$easy_pay_name = 'KPAY';
			break;
		case 'kcp':
			$easy_pay_name = 'PAYCO';
			break;
		default:
			break;
	}
} else if($od['od_settle_case'] == '휴대폰') {
	$app_no_subj = '휴대폰번호';
	$app_no = $od['od_bank_account'];
	$disp_bank = false;
	$disp_receipt = true;
} else if($od['od_settle_case'] == '가상계좌' || $od['od_settle_case'] == '계좌이체') {
	$app_no_subj = '거래번호';
	$app_no = $od['od_tno'];
}

// 영수증
if($disp_receipt) {
	if($od['od_settle_case'] == '휴대폰') {
		if($od['od_pg'] == 'lg') {
			require_once G5_SHOP_PATH.'/settle_lg.inc.php';
			$LGD_TID      = $od['od_tno'];
			$LGD_MERTKEY  = $config['cf_lg_mert_key'];
			$LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);
			
			$hp_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
		} else if($od['od_pg'] == 'inicis') {
			$hp_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
		} else {
			$hp_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'mcash_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$od['od_receipt_price'].'\', \'winreceipt\', \'width=500,height=690,scrollbars=yes,resizable=yes\');';
		}
	}
	
	if($od['od_settle_case'] == '신용카드' || is_inicis_order_pay($od['od_settle_case']) )
	{
		if($od['od_pg'] == 'lg') {
			require_once G5_SHOP_PATH.'/settle_lg.inc.php';
			$LGD_TID      = $od['od_tno'];
			$LGD_MERTKEY  = $config['cf_lg_mert_key'];
			$LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);
			
			$card_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
		} else if($od['od_pg'] == 'inicis') {
			$card_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
		} else {
			$card_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'card_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$od['od_receipt_price'].'\', \'winreceipt\', \'width=470,height=815,scrollbars=yes,resizable=yes\');';
		}
	}
	
	if($od['od_settle_case'] == 'KAKAOPAY')
	{
		$card_receipt_script = 'window.open(\'https://mms.cnspay.co.kr/trans/retrieveIssueLoader.do?TID='.$od['od_tno'].'&type=0\', \'popupIssue\', \'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=420,height=540\');';
	}
}

// 현금영수증
// 현금영수증 발급을 사용하는 경우에만
if ($default['de_taxsave_use']) {
	// 미수금이 없고 현금일 경우에만 현금영수증을 발급 할 수 있습니다.
	if ($misu_price == 0 && $od['od_receipt_price'] && ($od['od_settle_case'] == '무통장' || $od['od_settle_case'] == '계좌이체' || $od['od_settle_case'] == '가상계좌')) {
		if ($od['od_cash']) {
			if($od['od_pg'] == 'lg') {
				require_once G5_SHOP_PATH.'/settle_lg.inc.php';
				
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
				require_once G5_SHOP_PATH.'/settle_kcp.inc.php';
				
				$cash = unserialize($od['od_cash_info']);
				$cash_receipt_script = 'window.open(\''.G5_CASH_RECEIPT_URL.$default['de_kcp_mid'].'&orderid='.$od_id.'&bill_yn=Y&authno='.$cash['receipt_no'].'\', \'taxsave_receipt\', \'width=360,height=647,scrollbars=0,menus=0\');';
			}
		}
	}
}

if ($od['od_settle_case'] == '가상계좌' && $od['od_misu'] > 0 && $default['de_card_test'] && $is_admin && $od['od_pg'] == 'kcp') {
	preg_match("/\s{1}([^\s]+)\s?/", $od['od_bank_account'], $matchs);
	$deposit_no = trim($matchs[1]);
}

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'orderinquiryview.skin.html');

$tpl->assign(array(
	'order' => $order,
	'od' => $od
));

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/orderinquiryview.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');