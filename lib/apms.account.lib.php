<?php
if (!defined('_GNUBOARD_')) exit;

// Pay Means
function apms_pay_flag($flag) {

	switch($flag) {
		case '1'	: $flag = '신청금액'; break;
		case '2'	: $flag = '신청금액 - 부가세'; break;
		case '3'	: $flag = '신청금액 - 부가세 - 제세공과(원천징수 3.3%)'; break;
		case '4'	: $flag = '기타'; break;
		default		: $flag = '미등록'; break;
	}

	return $flag;
}

function apms_pay_amount($row) {

	if($row['pp_means'] == "1") { // 포인트 전환
		$pay = ($row['pp_amount'] - $row['pp_vat']); 
		$shingo = 0;
		$tax = 0; 
	} else {
		switch($row['pp_flag']) {
			case '1'	: 
				$pay = $row['pp_amount']; 
				$shingo = $row['pp_amount']; 
				$tax = 0; 
				break;
			case '2'	: 
				$pay = ($row['pp_amount'] - $row['pp_vat']); 
				$shingo = ($row['pp_amount'] - $row['pp_vat']); 
				$tax = 0; 
				break;
			case '3'	: 
				$shingo = ($row['pp_amount'] - $row['pp_vat']);
				$tax = ceil($shingo * 0.033);
				$pay = ($row['pp_amount'] - $row['pp_vat'] - $tax); 
				break;
			default		: 
				$shingo = 0;
				$tax = 0;
				$pay = 0; 
				break;
		}
	}

	$pp = array('pay'=>$pay, 'shingo'=>$shingo, 'tax'=>$tax);	

	return $pp;
}

// Balance Sheet
function apms_balance_sheet($mb_id, $opt='') {
    global $g5, $apms;

	if(!$mb_id) return;

	$account = array();

	if($mb_id == "@all") { //전체현황
		$pt_sql = ($opt) ? "and mk_id <> ''" : "and pt_id <> ''";
		$mb_sql = ($opt) ? "and mb_id <> '' and pp_field = '1'" : "and mb_id <> '' and pp_field = '0'";
		if($apms['apms_account_no']) {
			if($opt) {
				$pt_sql .= " and find_in_set(mk_id, '{$apms['apms_account_no']}')=0";
			} else {
				$pt_sql .= " and find_in_set(pt_id, '{$apms['apms_account_no']}')=0";
			}
			$mb_sql .= " and find_in_set(mb_id, '{$apms['apms_account_no']}')=0";
		}
	} else {
		$pt_sql = ($opt) ? "and mk_id = '$mb_id'" : "and pt_id = '$mb_id'";
		$mb_sql = ($opt) ? "and mb_id = '$mb_id' and pp_field = '1'" : "and mb_id = '$mb_id' and pp_field = '0'";
	}

	// 전체매출
	$sql = " select sum(pt_sale) as sale,
					sum(pt_commission) as commission,
					sum(pt_point) as point,
					sum(pt_incentive) as incentive,
					sum(pt_net) as net,
					sum(mk_profit) as profit,
					sum(mk_benefit) as benefit
					from {$g5['g5_shop_cart_table']} 
					where ct_status = '완료' and ct_select = '1' $pt_sql";
	$row = sql_fetch($sql);

	$account['sale'] = $row['sale'];
	$account['commission'] = $row['commission'];
	$account['point'] = $row['point'];
	$account['incentive'] = $row['incentive'];
	$account['netsale'] = $row['sale'] - $row['commission'] - $row['point'] + $row['incentive'];
	$account['net'] = $row['net'];
	$account['vat'] = $account['netsale'] - $row['net'];
	$account['profit'] = $row['profit'];
	$account['benefit'] = $row['benefit'];

	//지급액
	$sql = " select sum(pp_amount) as pay from {$g5['apms_payment']} where pp_confirm = '1' $mb_sql";
	$row = sql_fetch($sql);
	$account['payment'] = $row['pay'];

	//요청액
	$sql = " select sum(pp_amount) as request from {$g5['apms_payment']} where pp_confirm = '0' $mb_sql";
	$row = sql_fetch($sql);
	$account['request'] = $row['request'];

	if($opt) {
		//적립액
		$account['netgross'] = $account['profit'] + $account['benefit'];
	} else {
		//배송비
		$sql = " select sum(sc_price) as sendcost from {$g5['apms_sendcost']} where sc_flag = '1' $pt_sql";
		$row = sql_fetch($sql);
		$account['sendcost'] = $row['sendcost'];

		//적립액
		$account['netgross'] = $account['netsale'] + $account['sendcost']  + $row['incentive'];
	}

	//신청가능액 - 잔액
	$account['balance'] = $account['netgross'] - $account['payment'] - $account['request'];

	//보증금	
	$account['deposit'] = $apms['apms_payment'];

	//신청가능액
	$possible = $account['balance'] - $account['deposit'];
	$account['possible'] = ($possible > 0) ? $possible : 0;

	//신청단위 & 자릿수
	if($apms['apms_payment_cut']) {
		$account['unit'] = 1000;
		$account['num'] = 3;
		$account['txt'] = '000';
	} else {
		$account['unit'] = 10000;
		$account['num'] = 4;
		$account['txt'] = '0000';
	}

	// 최대금액
	$account['max'] = ((int)($account['possible'] / $account['unit'])) * $account['unit'];

    return $account;
}

?>