<?php
if (!defined('_GNUBOARD_')) exit;

// APMS Config
function apms_config() {
	global $g5;

	$row = sql_fetch(" select * from {$g5['apms']} ", false);

	return $row;
}

// Rows
function apms_rows($fields='*') {
	global $g5;

	$rows = sql_fetch(" select $fields from {$g5['apms_rows']} ", false);

	return $rows;
}

// Check Reserve
function apms_check_reserve_end() {
	global $default, $g5;

	$now = G5_SERVER_TIME;

	if(isset($default['pt_reserve_cache']) && $default['pt_reserve_cache'] > 0) {

		// 판매예약 체크
		if($default['pt_reserve_end'] > 0 && $default['pt_reserve_day'] > 0) {
			$cache = $default['pt_reserve_cache'] * 60;
			$second = $now - $default['pt_reserve'];
			if($cache < $second) {

				// 체크 업데이트
				sql_query(" update {$g5['g5_shop_default_table']} set pt_reserve = '{$now}' ", false);

				// 상품 업데이트
				$start = date("Y-m-d H:i:s", ($now - $default['pt_reserve_day'] * 24 * 60 * 60));
				$result = sql_query(" select it_id from {$g5['g5_shop_item_table']} where it_use = '0' and pt_reserve_use = '1' and pt_reserve > 0 and pt_reserve <= '{$now}' and it_time >= '{$start}' order by pt_reserve ", false);
				for ($i=0; $row=sql_fetch_array($result); $i++) {
					$num = time();
					sql_query(" update {$g5['g5_shop_item_table']} set pt_num = '{$num}', it_use = '1', pt_reserve_use = '0', pt_reserve = '0' where it_id = '{$row['it_id']}' ", false);
				}
			}
		}

		// 판매종료 체크
		$arr_end_it = array();
		$result = sql_query(" select it_id from {$g5['g5_shop_item_table']} where it_use = '1' and pt_end > 0 and pt_end <= '$now' ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$arr_end_it[] = $row['it_id'];		
		}

		if($i > 0) {
			$end_it = implode(",", $arr_end_it);
			sql_query(" update {$g5['g5_shop_item_table']} set it_use = '0' where find_in_set(it_id,'{$end_it}') ", false);
		}
	}

	if(isset($default['pt_auto']) && $default['pt_auto'] > 0 && isset($default['pt_auto_cache']) && $default['pt_auto_cache'] > 0) {
		$cache = $default['pt_auto_cache'] * 60 * 60;
		$second = $now - $default['pt_auto_time'];
		if($cache < $second) {

			// 체크 업데이트
			sql_query(" update {$g5['g5_shop_default_table']} set pt_auto_time = '{$now}' ", false);

			//상태변경
			$ct_status = '완료';
			$now2 = G5_TIME_YMDHIS;
			$ptxt = aslang('log', 'delivery_point');

			$start = date("Y-m-d H:i:s", ($now - $default['pt_auto'] * 24 * 60 * 60));
			$result = sql_query("select * from {$g5['g5_shop_cart_table']} where pt_datetime >= '{$start}' and ct_status = '배송' and ct_select = '1' ", false);
			for ($i=0; $row=sql_fetch_array($result); $i++) {

				$od_id = $row['od_id'];
				$it_id = $row['it_id'];

				// 장바구니 업데이트
				$query = '';

				// 포인트 반영 - 컨텐츠 상품은 설정일과 상관없이 반영함
				if($row['mb_id'] && $row['ct_point'] > 0 && !$row['ct_point_use'] && in_array($row['pt_it'], $g5['apms_automation'])) {
					$po_point = $row['ct_point'] * $row['ct_qty'];
		            $po_content = astxt($ptxt, array($od_id, $it_id, $row['ct_id'])); //주문번호 $od_id ($it_id : $row['ct_id']) 구매완료
					insert_point($row['mb_id'], $po_point, $po_content, "@delivery", $row['mb_id'], "{$od_id},{$row['ct_id']}");
					$query .= ", ct_point_use = '1'";
				}

				// 정산일 반영
				$query .= ", pt_datetime = '$now2'";

				// 히스토리에 남김 - 히스토리에 남길때는 작업|아이디|시간|IP|그리고 나머지 자료
				$ct_history="\n$ct_status|automation|$now2|";
				$query .= ", ct_history = CONCAT(ct_history,'$ct_history')";

				$sql = " update {$g5['g5_shop_cart_table']} 
							set ct_status = '$ct_status'
								$query 
								where od_id = '$od_id' and ct_id = '$ct_id'
							";
				sql_query($sql);

				// 판매량 반영
				$row2 = sql_fetch(" select sum(ct_qty) as sum_qty from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '완료' ");
				sql_query(" update {$g5['g5_shop_item_table']} set it_sum_qty = '{$row2['sum_qty']}' where it_id = '$it_id' ");

				// 개별배송비 반영
				sql_query(" update {$g5['apms_sendcost']} set sc_flag = '1', pt_datetime = '$now2' where od_id = '$od_id' and it_id = '$it_id' ", false);
			}
		}
	}

	return;
}

// Vat
function apms_vat($price) {

	$is_minus = ($price > 0) ? false : true;

	$price = abs($price);
	$net = round($price / 1.1);
	$vat = $price - $net;

	if($is_minus) {
		$net = $net * (-1);
		$vat = $vat * (-1);
	}
	
	$arr = array($net, $vat);

	return $arr;
}

// Item Type
function apms_pt_it($item, $txt='') {
	global $aslang;

	if($txt) {
		$arr = array("", $aslang['it_kind1'], $aslang['it_kind2']);
		$str = $arr[$item];
		if(!$str) $str = $aslang['it_kind1'];
	} else {
		$str = '<option value="1"'.get_selected('1', $item).'>일반상품(배송가능)</option>'.PHP_EOL;
		$str .= '<option value="2"'.get_selected('2', $item).'>컨텐츠상품(배송불가)</option>'.PHP_EOL;
	}

	return $str;
}

// Get Item
function apms_it($it_id, $opt='') {
	global $g5;

	if(!$it_id) return;

	if($opt)  {
		$sql = " select a.*, b.ca_name, b.ca_use from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b where a.it_id = '$it_id' and a.ca_id = b.ca_id ";
	} else {
		$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
	}

	$it = sql_fetch($sql);

	return $it;
}

// 분류리스트
function apms_category($ca_id) {
	global $g5, $member, $is_admin;

	$options = '';
	$field = "ca_id, ca_name, as_min, as_max, as_grade, as_equal, as_menu_show";
	$result = sql_query(" select $field from {$g5['g5_shop_category_table']} where ca_use = '1' order by ca_order, ca_id ");
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		if(!$is_admin && $row['as_menu_show']) { // 접근제한
			if(apms_auth($row['as_grade'], $row['as_equal'], $row['as_min'], $row['as_max'], 1)) continue;
		}

		$len = strlen($row['ca_id']) / 2 - 1;

		$nbsp = "";
		for ($i=0; $i<$len; $i++)
			$nbsp .= "&nbsp;&nbsp;&nbsp;";

		$selected = ($ca_id === $row['ca_id']) ? ' selected' : '';
		$options .= '<option value="'.$row['ca_id'].'"'.$selected.'>'.$nbsp.$row['ca_name'].'</option>'.PHP_EOL;
	}

	return $options;
}

// Payment Item
function apms_it_payment($it_id) {
	global $g5, $member, $is_guest;

	if(!$it_id || $is_guest) return;

    $row = sql_fetch(" select od_id, ct_qty, pt_datetime from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and mb_id = '{$member['mb_id']}' and ct_status = '완료' order by pt_datetime desc, ct_qty desc ");

	return $row;
}

// Used Item
function apms_it_used($od_id, $pt_id, $it_id, $it_name, $file_name) {
	global $g5, $member, $is_guest;

	if(!$it_id || $is_guest) return;

    $row = sql_fetch(" select id from {$g5['apms_use_log']} where od_id = '{$od_id}' and pt_id = '{$pt_id}' and it_id = '{$it_id}' and mb_id = '{$member['mb_id']}' ", false);

	if($row['id']) {
		$sql = " update {$g5['apms_use_log']} 
					set it_name = '".addslashes($it_name)."', 
						use_file = '".addslashes($file_name)."', 
						use_cnt = use_cnt + 1,
						use_datetime = '".G5_TIME_YMDHIS."' 
					where id = '{$row['id']}' ";
	} else {
		$sql = " insert into {$g5['apms_use_log']} 
					set od_id = '{$od_id}', 
						pt_id = '{$pt_id}',
						mb_id = '{$member['mb_id']}',
						it_id = '{$it_id}',
						it_name = '".addslashes($it_name)."',
						use_file = '".addslashes($file_name)."',
						use_cnt = '1',
						use_regdate = '".G5_TIME_YMDHIS."',
						use_datetime = '".G5_TIME_YMDHIS."' ";
	}

	sql_query($sql, false);

	return;
}

// Commission & Incentive
function apms_pt_rate($apms, $pt_it, $pt_id, $pt_commission, $pt_incentive) {
	global $g5;

	$commission = 0;
	$incentive = 0;

	// It
	$type = array("1", "2");
	if(!in_array($pt_it, $type)) {
		$bill = array($commission, $incentive);
		return $bill;
	}

	// Partner
	$pt = apms_partner($pt_id);
	if(!$pt['pt_id']) {
		$bill = array($commission, $incentive);
		return $bill;
	}

	// Fields
	$cc = 'apms_commission_'.$pt_it;
	$pc = 'pt_commission_'.$pt_it;
	$pi = 'pt_incentive_'.$pt_it;

	// Commission
	if($pt_commission) {
		$commission = $pt_commission;
	} else {
		$commission = ($pt[$pc]) ? $pt[$pc] : $apms[$cc];
	}

	// Incentive
	$incentive = ($pt_incentive) ? $pt_incentive : $pt[$pi];

	$bill = array($commission, $incentive);

	return $bill;
}

// 상품옵션별재고 또는 상품재고에서 빼기
function apms_stock($it_id, $ct_qty, $io_id="", $io_type=0) {
    global $g5;

    if($io_id) {
        $sql = " update {$g5['g5_shop_item_option_table']}
                    set io_stock_qty = io_stock_qty - '{$ct_qty}'
                    where it_id = '{$it_id}'
                      and io_id = '{$io_id}'
                      and io_type = '{$io_type}' ";
    } else {
        $sql = " update {$g5['g5_shop_item_table']}
                    set it_stock_qty = it_stock_qty - '{$ct_qty}'
                    where it_id = '{$it_id}' ";
    }
    return sql_query($sql);
}

// Calculate Account
function apms_account($row) {
	
	$account = array();
	
	// Sales
	if($row['io_type']) {
		$account['sale'] = $row['io_price'] * $row['ct_qty'];
	} else {
		$account['sale'] = (($row['ct_price'] + $row['io_price']) * $row['ct_qty']);
	}

	// Commission = Sale * Commission Rate
	$account['commission'] = round($account['sale'] * ($row['pt_commission_rate'] / 100));

	// Point
	$account['point'] = $row['ct_point'] * $row['ct_qty'];

	// Incentive = (Sale - Commission - Point) * Incentive Rate
	$account['incentive'] = round(($account['sale'] - $account['commission'] - $account['point']) * ($row['pt_incentive_rate'] / 100));

	// Net = Sale - Commission - Point + Incentive
	$account['amount'] = $account['sale'] - $account['commission'] - $account['point'] + $account['incentive'];

	if($row['ct_notax']) {
		$account['net'] = $account['amount'];
		$account['vat'] = 0;
	} else {

		list($net, $vat) = apms_vat($account['amount']);

		$account['net'] = $net;
		$account['vat'] = $vat;
	}

	return $account;
}

// Update Order
function apms_order($od_id, $od_status, $od_mk='') {
	global $g5, $is_guest;

	if(!$od_id) return;

	$arr_it_id = array();
	$arr_no_auto = array();
	$account = array();

	$od_ok = ($od_status == "입금") ? true : false;
	$now = G5_TIME_YMDHIS;
	$ptxt = aslang('log', 'delivery_point');

	// APMS
	$mk_id = '';
	$mk_brate = 0;
	if(USE_PARTNER) {
		$apms = sql_fetch(" select * from {$g5['apms']} ", false);
		$od_mk =($is_guest && defined('APMS_MKT') && APMS_MKT) ? APMS_MKT : ''; //비회원주문 처리

		if($od_mk) { // 추천인 아이디가 있으면
			$mk = apms_marketer($od_mk);
			if($mk['pt_id']) {
				$mk_id = $mk['pt_id'];
				$lvl = (isset($mk['pt_level']) && $mk['pt_level'] > 0) ? $mk['pt_level'] : 1;
				$mk_lvrate = (isset($apms['apms_benefit'.$lvl]) && $apms['apms_benefit'.$lvl] > 0) ? $apms['apms_benefit'.$lvl] : 0;
				$mk_brate = ($mk_lvrate + $mk['pt_benefit']);
			}
		}
	} 

	// 장바구니에서 내역가져오기
	$result = sql_query("select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_select = '1' order by pt_id, it_id", false);
    while ($row = sql_fetch_array($result)) {

		$it = apms_it($row['it_id']); //상품정보

		$query = "";
		if($od_ok && in_array($it['pt_it'], $g5['apms_automation'])) { //자동처리 상품일 때 입금상태이면 재고반영, 포인트반영, 결제완료 처리함

			//상태변경
			$ct_status = '완료';

			// 장바구니 업데이트
			$query .= ", ct_status = '$ct_status'";

			// 판매량 반영
			$arr_it_id[] = $row['it_id'];

			// 재고량 반영
			if(!$row['ct_stock_use']) {
				//YC5 관리자용 차용
				apms_stock($row['it_id'], $row['ct_qty'], $row['io_id'], $row['io_type']);
				$query .= ", ct_stock_use = '1'";
			}

			// 포인트 반영 - 컨텐츠 상품은 설정일과 상관없이 반영함
			if($row['mb_id'] && $row['ct_point'] > 0 && !$row['ct_point_use'] && in_array($row['pt_it'], $g5['apms_automation'])) {
				$po_point = $row['ct_point'] * $row['ct_qty'];
	            $po_content = astxt($ptxt, array($od_id, $row['it_id'], $row['ct_id'])); //주문번호 $od_id ($row['it_id'] : $row['ct_id']) 구매완료
				insert_point($row['mb_id'], $po_point, $po_content, "@delivery", $row['mb_id'], "{$od_id},{$row['ct_id']}");
				$query .= ", ct_point_use = '1'";
			}

			// 정산일 반영
			$query .= ", pt_datetime = '$now'";

			// 히스토리에 남김 - 히스토리에 남길때는 작업|아이디|시간|IP|그리고 나머지 자료
			$ct_history="\n$ct_status|automation|$now|";
			$query .= ", ct_history = CONCAT(ct_history,'$ct_history')";

			// 멤버쉽 아이템 체크 - 멤버쉽 함수가 있을 때만 작동
			if (function_exists('apms_membership_order')) {
				apms_membership_order($row, $ct_status, $now);
			}
		} else {
			// 자동처리 아닌 상품
			$arr_no_auto[] = $row['it_id'];
		}

		//커미션, 인센티브
		if(USE_PARTNER) {
			if($it['pt_id']) { // 판매자
				list($commission, $incentive) = apms_pt_rate($apms, $it['pt_it'], $it['pt_id'], $it['pt_commission'], $it['pt_incentive']);
				$row['pt_commission_rate'] = ($commission) ? $commission : 0;
				$row['pt_incentive_rate'] = ($incentive) ? $incentive : 0;

				// 가정산
				$account = apms_account($row);

				$query .= " , pt_id = '{$it['pt_id']}'
							, pt_commission_rate = '{$row['pt_commission_rate']}'
							, pt_incentive_rate = '{$row['pt_incentive_rate']}'
							, pt_sale = '{$account['sale']}'
							, pt_commission = '{$account['commission']}'
							, pt_point = '{$account['point']}'
							, pt_incentive = '{$account['incentive']}'
							, pt_net = '{$account['net']}' ";
			}
			
			if($mk_id && isset($it['pt_marketer']) && $it['pt_marketer'] > 0) { // 추천인

				$mk_prate = ($it['pt_marketer'] / 100);

				if($row['io_type']) {
					$mk_amount = $row['io_price'] * $row['ct_qty'];
				} else {
					$mk_amount = (($row['ct_price'] + $row['io_price']) * $row['ct_qty']);
				}

				if($row['ct_notax']) {
					$mk_net = $mk_amount;
				} else {
					list($mk_net) = apms_vat($mk_amount);
				}

				$mk_profit = floor($mk_net * $mk_prate);
				if($mk_profit > 0) {
					$mk_benefit = floor($mk_profit * ($mk_brate / 100));
					$query .= " , mk_id = '{$mk_id}'
								, mk_profit = '{$mk_profit}'
								, mk_benefit = '{$mk_benefit}'
								, mk_profit_rate = '{$it['pt_marketer']}'
								, mk_benefit_rate = '{$mk_brate}' ";
				}
			}

		}

		if($query) {
			$sql = " update {$g5['g5_shop_cart_table']} 
						set pt_it = '{$it['pt_it']}'
							$query 
						where od_id = '$od_id' and ct_id = '{$row['ct_id']}'
					";
			sql_query($sql);
		}
	}

	// 판매량 일괄반영
	if(is_array($arr_it_id) && !empty($arr_it_id)) {
		$unq_it_id = array_unique($arr_it_id);
		foreach($unq_it_id as $it_id) {
			$row2 = sql_fetch(" select sum(ct_qty) as sum_qty from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '완료' ");
			sql_query(" update {$g5['g5_shop_item_table']} set it_sum_qty = '{$row2['sum_qty']}' where it_id = '$it_id' ");
		}
	}

	// 주문서가 자동처리 상품으로 되어 있으면 주문서도 완료처리
	$is_sendcost = true;
	if($od_ok && is_array($arr_no_auto) && empty($arr_no_auto)) {
		$info = get_order_info($od_id);
		if($info && $info['od_misu'] == 0) {
			sql_query(" update {$g5['g5_shop_order_table']} set od_status = '완료' where od_id = '$od_id' ");
			$is_sendcost = false;
		}
	}

	// 개별배송비처리 - 무료가 아니고 기본배송비가 있는 경우만 체크
	if($is_sendcost) {
		$where_sql = (!empty($g5['apms_automation'])) ? " and pt_it not in (".implode(', ', $g5['apms_automation']).") " : "";
		$sql = " select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_select = '1' $where_sql group by it_id order by ct_id ";
		$result = sql_query($sql);
		for ($i=0; $row=sql_fetch_array($result); $i++) {

			// 합계금액 계산
			$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
							SUM(ct_point * ct_qty) as point,
							SUM(ct_qty) as qty
						from {$g5['g5_shop_cart_table']}
						where it_id = '{$row['it_id']}'
						  and od_id = '$od_id' ";
			$sum = sql_fetch($sql);

			// 배송비
			$sc_price = 0;
			switch($row['ct_send_cost']) {
				case 1:
					$sc_type = '착불';
					break;
				case 2:
					$sc_type = '무료';
					break;
				default:
					$sc_type = '선불';
					$sc_price = $row['it_sc_price'];
					break;
			}

			// 조건부무료
			if($sc_price && $row['it_sc_type'] == 2) {
				$sc_price = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $od_id);

				if($sc_price == 0)
					$sc_type = '무료';
			}

			// 개별배송비 등록
			sql_query(" insert into {$g5['apms_sendcost']} set od_id = '$od_id', it_id = '{$row['it_id']}', it_name = '".addslashes($row['it_name'])."', pt_id = '{$row['pt_id']}', sc_price = '$sc_price', sc_type = '$sc_type', sc_datetime = '".G5_TIME_YMDHIS."' ", false);
		}
	}

	return;
}

// Update Order
function apms_order_it($ct_id, $mb_id='') {
	global $g5;

	if(!$ct_id) return;

	$mb_sql = ($mb_id) ? " and mb_id = '$mb_id' " : '';

	// 장바구니에서 내역가져오기
	$row = sql_fetch("select * from {$g5['g5_shop_cart_table']} where ct_id = '$ct_id' and ct_status = '배송' and ct_select = '1' $mb_sql ", false);

	if(!$row['ct_id']) return;

	$od_id = $row['od_id'];
	$it_id = $row['it_id'];

	//상태변경
	$ct_status = '완료';
	$now = G5_TIME_YMDHIS;

	// 장바구니 업데이트
	$query = '';

	// 포인트 반영 - 컨텐츠 상품은 설정일과 상관없이 반영함
	if($row['mb_id'] && $row['ct_point'] > 0 && !$row['ct_point_use'] && in_array($row['pt_it'], $g5['apms_automation'])) {
		$po_point = $row['ct_point'] * $row['ct_qty'];
		$po_content = aslang('log', 'delivery_point', array($od_id, $it_id, $row['ct_id'])); //주문번호 $od_id ($it_id : $row['ct_id']) 구매완료
		insert_point($row['mb_id'], $po_point, $po_content, "@delivery", $row['mb_id'], "{$od_id},{$row['ct_id']}");
		$query .= ", ct_point_use = '1'";
	}

	// 정산일 반영
	$query .= ", pt_datetime = '$now'";

	// 히스토리에 남김 - 히스토리에 남길때는 작업|아이디|시간|IP|그리고 나머지 자료
	if(!$mb_id) $mb_id = 'automation';
	$ct_history="\n$ct_status|$mb_id|$now|";
	$query .= ", ct_history = CONCAT(ct_history,'$ct_history')";

	$sql = " update {$g5['g5_shop_cart_table']} 
				set ct_status = '$ct_status'
					$query 
					where od_id = '$od_id' and ct_id = '$ct_id'
				";
	sql_query($sql);

	// 멤버쉽 아이템 체크 - 멤버쉽 함수가 있을 때만 작동
	if (function_exists('apms_membership_order')) {
		apms_membership_order($row, $ct_status, $now);
	}

	// 판매량 반영
	$row2 = sql_fetch(" select sum(ct_qty) as sum_qty from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '완료' ");
	sql_query(" update {$g5['g5_shop_item_table']} set it_sum_qty = '{$row2['sum_qty']}' where it_id = '$it_id' ");

	// 개별배송비 반영
	sql_query(" update {$g5['apms_sendcost']} set sc_flag = '1', pt_datetime = '$now' where od_id = '$od_id' and it_id = '$it_id' ", false);

	return;
}

// Auto Account
function apms_account_auto($od_id, $ct_id, $od_status) {
	global $g5;

	if(!$od_id || !$ct_id) return;

	$row = sql_fetch("select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_id = '$ct_id' ", false);

	$query = '';
	if($od_status == '완료') {
		if(in_array($row['pt_it'], $g5['apms_automation']) && $row['mb_id'] && $row['ct_point'] > 0 && !$row['ct_point_use']) { 
			$po_point = $row['ct_point'] * $row['ct_qty'];
			$po_content = aslang('log', 'delivery_point', array($od_id, $row['it_id'], $ct_id)); //주문번호 $od_id ($row['it_id'] : $ct_id) 구매완료
			insert_point($row['mb_id'], $po_point, $po_content, "@delivery", $row['mb_id'], "{$od_id},{$ct_id}");
			$query .= ", ct_point_use = '1'";
		}
		$query .= ", pt_datetime = '".G5_TIME_YMDHIS."'";
	} else if($od_status == '배송') { //배송일 때는 배송일괄처리를 위해 정산일만 업데이트함
		$query .= ", pt_datetime = '".G5_TIME_YMDHIS."'";
	}

	if(USE_PARTNER && $row['pt_id']) {
		// 가정산
		$account = apms_account($row);
		$query .= " , pt_sale = '{$account['sale']}'
					, pt_commission = '{$account['commission']}'
					, pt_point = '{$account['point']}'
					, pt_incentive = '{$account['incentive']}'
					, pt_net = '{$account['net']}' ";
	}

	if($query) {
		$sql = " update {$g5['g5_shop_cart_table']} 
					set pt_it = '{$row['pt_it']}'
						$query 
					where od_id = '$od_id' and ct_id = '{$ct_id}'
				";
		sql_query($sql);
	}

	// 멤버쉽 아이템 체크 - 멤버쉽 함수가 있을 때만 작동
	if (function_exists('apms_membership_order')) {
		apms_membership_order($row, $od_status, G5_TIME_YMDHIS);
	}

	// 개별배송비
	if($row['ct_send_cost'] != "2" && $row['it_sc_price'] > 0) {
		if($od_status == '완료') {
			sql_query(" update {$g5['apms_sendcost']} set sc_flag = '1', pt_datetime = '".G5_TIME_YMDHIS."' where od_id = '$od_id' and it_id = '{$row['it_id']}'", false);
		} else {
			$row1 = sql_fetch("select ct_id from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and it_id = '{$row['it_id']}' and ct_status = '완료' ", false);
			if($row1['ct_id']) { //완료상품이 있으면
				sql_query(" update {$g5['apms_sendcost']} set sc_flag = '1', pt_datetime = '".G5_TIME_YMDHIS."' where od_id = '$od_id' and it_id = '{$row['it_id']}' ", false);
			} else {
				sql_query(" update {$g5['apms_sendcost']} set sc_flag = '0', pt_datetime = '' where od_id = '$od_id' and it_id = '{$row['it_id']}' ", false);
			}
		}
	}

	return;
}

// Partner Info
function apms_partner($mb_id, $fields='*') {
	global $g5;

	if(!$mb_id) return;

	$row = sql_fetch(" select $fields from {$g5['apms_partner']} where pt_id = TRIM('$mb_id') ", false);

	return $row;
}

// Marketer Info
function apms_marketer($mb_id, $fields='*') {
	global $g5;

	if(!$mb_id) return;

	$row = sql_fetch(" select $fields from {$g5['apms_partner']} where pt_id = TRIM('$mb_id') and pt_marketer <> '0' and pt_register <> '' ", false);

	return $row;
}

// Get File
function apms_get_file($dir, $pf_id) {
    global $g5;

	if(!$pf_id) return;

	//파일타입 설정
	switch($dir) {
		case 'item'		: $pf_dir = 1; $dir = 'item'; $pf_url = G5_SHOP_URL; $pf_path = G5_DATA_URL.'/item/'.$pf_id; break;
		case 'partner'	: $pf_dir = 2; $dir = 'partner'; $pf_url = G5_ADMIN_URL.'/apms_admin'; $pf_path = G5_DATA_URL.'/apms/'.$dir; break;
		default			: return;
	}

	$file['count'] = 0;
	$file['torrent'] = 0;
    $sql = " select * from {$g5['apms_file']} where pf_id = '$pf_id' and pf_dir = '$pf_dir' order by pf_no ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) {
        $no = $row['pf_no'];
        $file[$no]['id'] = $pf_id;
		$file[$no]['href'] = $pf_url."/download.php?pf_id=$pf_id&amp;pf=$pf_dir&amp;no=$no";
        $file[$no]['href_view'] = $pf_url."/view.php?pf_id=$pf_id&amp;pf=$pf_dir&amp;no=$no";
		$file[$no]['path'] = $pf_path;
		$file[$no]['guest_use'] = $row['pf_guest_use'];
		$file[$no]['purchase_use'] = $row['pf_purchase_use'];
		$file[$no]['download'] = $row['pf_download'];
		$file[$no]['download_use'] = $row['pf_download_use'];
		$file[$no]['view'] = $row['pf_view'];
		$file[$no]['view_use'] = $row['pf_view_use'];
        $file[$no]['size'] = get_filesize($row['pf_filesize']);
        $file[$no]['datetime'] = $row['pf_datetime'];
        $file[$no]['source'] = addslashes($row['pf_source']);
        $file[$no]['file'] = $row['pf_file'];
        $file[$no]['image_width'] = $row['pf_width'] ? $row['pf_width'] : 640;
        $file[$no]['image_height'] = $row['pf_height'] ? $row['pf_height'] : 480;
        $file[$no]['image_type'] = $row['pf_type'];
		$file[$no]['ext'] = $row['pf_ext'];
		if($row['pf_ext'] == "6") $file['torrent']++;
		$file['count']++;
    }

    return $file;
}

// Delete File
function apms_delete_file($dir, $pf_id) {
	global $g5;

	if(!$pf_id) return;

	//파일타입 설정
	switch($dir) {
		case 'item'		: $pf_dir = 1; $pf_file = G5_DATA_PATH.'/item/'.$pf_id; break;
		case 'partner'	: $pf_dir = 2; $pf_file = G5_DATA_PATH.'/apms/'.$dir; break;
		default			: return;
	}

	// 업로드된 파일이 있다면
	$result = sql_query(" select * from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' ");
	while ($row = sql_fetch_array($result)) {
		// 파일 삭제
		@unlink($pf_file.'/'.$row['pf_file']);
	}

	// 파일테이블 행 삭제
	sql_query(" delete from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' ");
}

function apms_explan_image($num) {
	global $it;

	$img = $it['it_img'.$num];
    $file = G5_DATA_PATH.'/item/'.$img;
    $imgurl = G5_DATA_URL.'/item/'.$img;
    if (is_file($file) && $img != '') {
		$str = '<a href="'.G5_BBS_URL.'/view_image.php?fn='.urlencode(str_replace(G5_URL, "", $imgurl)).'" target="_blank" class="item_image"><img src="'.$imgurl.'" alt=""></a>';
    } else {
		$str = '';
	}

	return $str;
}

function apms_callback_explan_image($m) {
	return apms_explan_image($m[2]);
}

//Show Contents
function apms_explan($explan, $filter=true) {

	if(!$explan) return;

	$explan = preg_replace_callback("/{(이미지|img)\:([0-9]+)[:]?([^}]*)}/is", "apms_callback_explan_image", $explan); //Image
	$explan = apms_content(conv_content($explan, 1, $filter));

	return $explan;
}

// 아이템 썸네일 생성
function apms_it_thumbnail($it, $thumb_width, $thumb_height, $is_create=false, $is_crop=false, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3') {
    global $g5, $config;

	$img = array();
	$limg = array();
	$lalt = array();
	$thumb = array();
	$no_thumb = array('is_thumb'=>false, 'src'=>'', 'alt'=>'', 'org'=>'', 'height'=>'');
	$rows = (isset($it['img_rows']) && $it['img_rows'] > 1) ? $it['img_rows'] : 1;
	$is_thumb_no = (isset($it['is_thumb_no']) && $it['is_thumb_no']) ? true : false;
	$no_img = (isset($it['no_img']) && $it['no_img']) ? $it['no_img'] : '';
	$chk_img = (isset($it['chk_img']) && $it['chk_img']) ? true : false; // Check Image
	$is_thumb = (!$chk_img && isset($it['pt_thumb']) && $it['pt_thumb'] && $rows == "1") ? true : false;

	$make_thumb = true;
	if($is_thumb && isset($it['pt_thumb']) && $it['pt_thumb'] == "1") {
		$z = 0;
		$make_thumb = false;
		unset($it);
	} else if($is_thumb) {
		$tmp_thumb = apms_video_thumbnail($it['pt_thumb'], 1);
		if($tmp_thumb) {
			$z = 1;
			$img[0]['img'] = $tmp_thumb;
			$img[0]['alt'] = '';
			$make_thumb = false;
			unset($it);
		}
	}

	if($make_thumb) {
		$z = 0;
		for($i=1; $i<=10; $i++) {
			$it_img = $it['it_img'.$i];
			$file = G5_DATA_PATH.'/item/'.$it_img;
			if(!is_file($file))
				continue;

			$size = @getimagesize($file);
			if($size[2] < 1 || $size[2] > 3)
				continue;

			$img[$z]['alt'] = get_text($it['it_name']);
			$img[$z]['img'] = G5_DATA_URL.'/item/'.$it_img;
			
			$z++;
			if($z == $rows) break;
		}

		if($z != $rows) {
			$result = sql_query(" select * from {$g5['apms_file']} where pf_id = '{$it['it_id']}' and pf_dir = '1' and pf_ext = '1' and pf_purchase_use <> '1' and pf_view_use = '1' order by pf_no ", false);
			while ($row = sql_fetch_array($result)) {
				$file = G5_DATA_PATH.'/item/'.$it['it_id'].'/'.$row['pf_file'];
				if(!is_file($file))
					continue;

				$size = @getimagesize($file);
				if($size[2] < 1 || $size[2] > 3)
					continue;

				$img[$z]['alt'] = get_text($it['it_name']);
				$img[$z]['img'] = G5_DATA_URL.'/item/'.$it['it_id'].'/'.$row['pf_file'];
			
				$z++;
				if($z == $rows) break;
			}
		}

		if($z != $rows) { //첨부이미지 체크
			$wr_content = $it['it_explan'];
			$matches = get_editor_image($wr_content, false);

			for($i=0; $i<count($matches[1]); $i++) {
				// 이미지 path 구함
				$p = @parse_url($matches[1][$i]);
				if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
					$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
				else
					$data_path = $p['path'];

				$srcfile = G5_PATH.$data_path;

				if(is_file($srcfile)) {
					$size = @getimagesize($srcfile);
					if(empty($size)) {
						continue;
					}

					$img[$z]['img'] = $matches[1][$i];

					preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
					$img[$z]['alt'] = get_text($malt[1]);

					$z++;
					if($z == $rows) break;

				} else {
					$limg[] = $matches[1][$i];
					preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
					$lalt[] = get_text($malt[1]);
				}
			}
		}

		if($z != $rows) { // 링크동영상 체크
			for($i=1; $i < 3; $i++) {
				if($it['pt_link'.$i]) {

					list($link_video) = explode("|", $it['pt_link'.$i]);

					$video = apms_video_info($link_video);

					if(!$video['type']) continue;

					$srcfile = apms_video_img($video['video_url'], $video['vid'], $video['type'], $video['img']);

					if(!$srcfile || $srcfile == 'none') continue;

					$size = @getimagesize($srcfile);
					if(empty($size)) {
						continue;
					}

					$img[$z]['img'] = str_replace(G5_PATH, G5_URL, $srcfile);

					$z++;
					if($z == $rows) break;
				}
			}
		}

		if($z != $rows) { //본문동영상 이미지 체크
			if(preg_match_all("/{(동영상|video)\:([^}]*)}/is", $it['it_explan'], $match)) {
				$match_cnt = count($match[2]);
				for ($i=0; $i < $match_cnt; $i++) {
					$video = apms_video_info(trim(strip_tags($match[2][$i])));

					if(!$video['type']) continue;

					$srcfile = apms_video_img($video['video_url'], $video['vid'], $video['type'], $video['img']);

					if(!$srcfile || $srcfile == 'none') continue;

					$size = @getimagesize($srcfile);
					if(empty($size)) {
						continue;
					}

					$img[$z]['img'] = str_replace(G5_PATH, G5_URL, $srcfile);

					$z++;
					if($z == $rows) break;
				}
			}
		}

		if($z != $rows) { //링크 이미지
			for($i=0; $i < count($limg); $i++) {
				$img[$z]['is_thumb'] = false;
				$img[$z]['img'] = $limg[$i];
				$img[$z]['alt'] = $lalt[$i];

				$z++;
				if($z == $rows) break;
			}
		}
	}

	// Check Image
	if($chk_img) {
		$chk_img = (isset($img[0]['img']) && $img[0]['img']) ? $img[0]['img'] : 0;
		return $chk_img;
	}

    if($z == 0) {
		if($no_img) {
			$img[$z]['org'] = $no_img;
			$img[$z]['img'] = $no_img;
	        $img[$z]['alt'] = '';
		} else {
			if($rows > 1) {
				$thumb[0] = $no_thumb;
			} else {
				$thumb = $no_thumb;
			}
			return $thumb;
		}
	}

	// 썸네일
	$tmp = array();
	$j = 0;
	for($i = 0; $i < count($img); $i++) {
		if($thumb_width > 0 && !$is_thumb_no) {

			$tmpimg = apms_thumbnail($img[$i]['img'], $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

			if(!$tmpimg['src']) continue;

			$tmp[$j]['is_thumb'] = $tmpimg['is_thumb'];
            $tmp[$j]['src'] = $tmpimg['src'];
            $tmp[$j]['height'] = $tmpimg['height'];
		} else {
			$tmp[$j]['is_thumb'] = false;
            $tmp[$j]['src'] = $img[$i]['img'];
            $tmp[$j]['height'] = '';
		}
		$tmp[$j]['org'] = $img[$i]['img'];
		$tmp[$j]['alt'] = $img[$i]['alt'];
		$j++;
	}

	if($j == 0) {
		if($rows > 1) {
			$thumb[0] = $no_thumb;
		} else {
			$thumb = $no_thumb;
		}
	} else {
		$thumb = ($rows > 1) ? $tmp : $tmp[0];
	}

    return $thumb;
}

// 아이템 관련글 썸네일 생성
function apms_it_write_thumbnail($it_id, $wr_content, $thumb_width, $thumb_height, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3') {
    global $g5, $config;

	$fileurl = $alt = "";
	$matches = get_editor_image($wr_content, false);

	$limg = array();
	$lalt = array();
	for($i=0; $i<count($matches[1]); $i++) {
		// 이미지 path 구함
		$p = @parse_url($matches[1][$i]);
		if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
			$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
		else
			$data_path = $p['path'];

		$srcfile = G5_PATH.$data_path;

		if(is_file($srcfile)) {
			$size = @getimagesize($srcfile);
			if(empty($size)) {
				continue;
			}

			$fileurl = $matches[1][$i];
			preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
			$alt = get_text($malt[1]);

			break;
		} else {
			$limg[] = $matches[1][$i];
			preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
			$lalt[] = get_text($malt[1]);
		}
	}
	
	if(!$fileurl) { //본문동영상 이미지 체크
		if(preg_match_all("/{(동영상|video)\:([^}]*)}/is", $wr_content, $match)) {
			$match_cnt = count($match[2]);
			for ($i=0; $i < $match_cnt; $i++) {
				$video = apms_video_info(trim(strip_tags($match[2][$i])));

				if(!$video['type']) continue;

				$srcfile = apms_video_img($video['video_url'], $video['vid'], $video['type']);

				if(!$srcfile || $srcfile == 'none') continue;

				$size = @getimagesize($srcfile);
				if(empty($size)) {
					continue;
				}

				$fileurl = str_replace(G5_PATH, G5_URL, $srcfile);

				break;
			}
		}
	} 

	if(!$fileurl) { //기타

		//링크
		if(count($limg) > 0) {
			$thumb = array('is_thumb'=>false, 'src'=>$limg[0], 'alt'=>$lalt[0], 'org'=>$limg[0], 'height'=>'');
			return $thumb;
		}

		//상품
		$it = apms_it($it_id);
		$thumb = apms_it_thumbnail($it, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

		if(!$thumb['src']) {
			$thumb = array('is_thumb'=>false, 'src'=>'', 'alt'=>'', 'org'=>'', 'height'=>'');
		}

		return $thumb;
	}

	$thumb = apms_thumbnail($fileurl, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
	$thumb['alt'] = $alt;
	$thumb['org'] = $fileurl;

    return $thumb;
}

//----------------------------------------------------------------//
// 태마 관련 함수들
//----------------------------------------------------------------//

// Category Auth
function apms_ca_thema($ca_id, $ca, $opt='') {
	global $g5, $is_admin;

	if(!$ca_id) return;

	$at = array();

	if($opt) {
		$ca = sql_fetch(" select * from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
	}

	if($is_admin != 'super') {

		if($ca['as_partner'] && !IS_PARTNER) {
			alert(aslang('alert', 'is_partner'), G5_URL); //파트너만 이용가능합니다.
		}

		apms_auth($ca['as_grade'], $ca['as_equal'], $ca['as_min'], $ca['as_max']);
	}

	$title = $ca['as_title'];
	$desc = $ca['as_desc'];
	$wide = $ca['as_wide'];
	$list = $ca['ca_'.MOBILE_.'skin'];
	$item = $ca['ca_'.MOBILE_.'skin_dir'];
	$img_w = $ca['ca_'.MOBILE_.'img_width'];
	$img_h = $ca['ca_'.MOBILE_.'img_height'];
	$list_mod = $ca['ca_'.MOBILE_.'list_mod'];
	$list_row = $ca['ca_'.MOBILE_.'list_row'];
	$nav1 = $ca['ca_name'];

	$ca_code = substr($ca_id,0,2);
	if($ca_id != $ca_code) {
		$nav2 = $nav1;
		$ca = sql_fetch(" select ca_name, as_thema, as_color, as_mobile_thema, as_mobile_color, as_wide, as_multi from {$g5['g5_shop_category_table']} where ca_id = '{$ca_code}' ", false);
		$nav1 = $ca['ca_name'];
	} 

	$at = $ca;
	$at['group'] = false;
	$at['id'] = $ca_code;
	$at['title'] = $title;
	$at['desc'] = $desc;
	$at['wide'] = $wide;
	$at['multi'] = $ca['as_multi'];
	$at['thema'] = $ca['as_'.MOBILE_.'thema'];
	$at['colorset'] = $ca['as_'.MOBILE_.'color'];
	$at['list'] = $list;
	$at['item'] = $item;
	$at['img_width'] = $img_w;
	$at['img_height'] = $img_h;
	$at['list_mods'] = $list_mod;
	$at['list_rows'] = $list_row;
	$at['name'] = $ca['ca_name'];
	$at['nav1'] = $nav1;
	$at['nav2'] = $nav2;
	$at['nav3'] = '';

	return $at;
}

// Item View Skin
function apms_itemview_skin($skin, $ca_id, $it_ca) {
	global $g5;

	if($it_ca != $ca_id) {
		$row = sql_fetch(" select ca_skin_dir, ca_mobile_skin_dir from {$g5['g5_shop_category_table']} where ca_id = '{$it_ca}' ");
		$skin = $row['ca_'.MOBILE_.'skin_dir'];
	}

	return $skin;
}

// Get Thema Widget Item List
function thema_widget_item_list($type, $ca_id, $it, $new=24, $thumb_width=0, $thumb_height=0, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3') {
    global $g5, $config, $is_admin, $aslang;

	// 배열전체를 복사
	$list = $it;
	unset($it);

	if($type == "item") {
		$mb_id = ($list['pt_id']) ? $list['pt_id'] : $config['cf_admin'];
		$list['new'] = ($list['pt_num'] >= (G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['date'] = $list['pt_num'];
		$list['photo'] = apms_photo_url($mb_id); //회원사진
		$list['subject'] = $list['it_name'];
		$list['comment'] = $list['pt_comment'];
		$list['content'] = $list['it_explan'];
        $list['category'] = $list['ca_name'];
        $list['hit'] = $list['it_hit'];
        $list['good'] = $list['pt_good'];
        $list['nogood'] = $list['pt_nogood'];
		if($thumb_width > 0) $list['img'] = apms_it_thumbnail($list, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

		$list['href'] = G5_SHOP_URL.'/item.php?it_id='.$list['it_id'];
		if($ca_id) $list['href'] .= '&amp;ca_id='.$ca_id;

	} else if($type == "itemcomment") {
		$list['reply_name'] = ($list['wr_comment_reply'] && $list['wr_re_name']) ? $list['wr_re_name'] : '';
		$list['new'] = ($list['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['photo'] = apms_photo_url($list['mb_id']); //회원사진
		$list['name'] = $list['wr_name'];
		$list['date'] = strtotime($list['wr_datetime']);
		$list['secret'] = (strstr($list['wr_option'], "secret")) ? true : false;
		if($list['secret']) {
			$list['subject'] = $list['wr_subject'] = $list['wr_content'] = $aslang['cmt_secret']; //비밀댓글입니다.
		} else {
			$list['subject'] = apms_cut_text($list['wr_content'], 60);
		}
		$list['content'] = $list['wr_content'];
		$list['wr_content'] = '';
		if($thumb_width > 0) $list['img'] = apms_it_write_thumbnail($list['it_id'], $list['wr_content'], $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

		$list['href'] = G5_SHOP_URL.'/item.php?it_id='.$list['it_id'];
		if($ca_id) $list['href'] .= '&amp;ca_id='.$ca_id;
		$list['href'] .= '#icv';

	} else if($type == "itemqa") {
		$list['new'] = ($list['iq_time'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['photo'] = apms_photo_url($list['mb_id']); //회원사진
		$list['name'] = $list['iq_name'];
		$list['date'] = strtotime($list['iq_time']);
		$list['secret'] = ($list['iq_secret']) ? true : false;
		if($list['secret']) {
			$list['subject'] = $list['iq_subject'] = $list['iq_question'] = $aslang['iq_secret']; //비밀글로 보호된 문의입니다.
			if($thumb_width > 0) $list['img'] = apms_it_write_thumbnail($list['it_id'], $list['iq_question'], $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
		} else {
			$list['subject'] = $list['iq_subject'];
		}
		$list['content'] = $list['iq_question'];
		$list['iq_question'] = '';
		$list['answer'] = ($list['iq_answer']) ? true : false;

		$list['href'] = G5_SHOP_URL.'/itemqaview.php?iq_id='.$list['iq_id'];
		if($ca_id) $list['href'] .= '&amp;ca_id='.$ca_id;

	} else if($type == "itemuse") {
		$list['new'] = ($list['is_time'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($new * 3600))) ? true : false;
		$list['photo'] = apms_photo_url($list['mb_id']); //회원사진
		$list['name'] = $list['is_name'];
		$list['date'] = strtotime($list['is_time']);
		$list['subject'] = $list['is_subject'];
		$list['content'] = $list['is_content'];
		$list['is_content'] = '';
		$list['star'] = apms_get_star($list['is_score']);
		if($thumb_width > 0) $list['img'] = apms_it_write_thumbnail($list['it_id'], $list['is_content'], $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

		$list['href'] = G5_SHOP_URL.'/itemuseview.php?is_id='.$list['is_id'];
		if($ca_id) $list['href'] .= '&amp;ca_id='.$ca_id;
	}

    return $list;
}

// 신상품 목록
function apms_chk_new_item($s='') {
	global $g5;

	$list = array();

	if($g5['cache_newpost_time'] > 0) {
		$chk_date = G5_SERVER_TIME - ($g5['cache_newpost_time'] * 3600);
	} else {
		return $list;
	}

	$ca = array();
	$arr = array();

	//신상품 및 신규 등록 자료 체크
	$field = array("ca_id", "ca_id2", "ca_id3");
	for($j = 0; $j < 3; $j++) {
	    $result = sql_query(" select distinct {$field[$j]} from {$g5['g5_shop_item_table']} where it_use = '1' and ca_id <> '' and pt_num >= '{$chk_date}'", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {

			$n = $field[$j];

			$ca = substr($row[$n],0,2);
			if($ca) array_push($arr, $ca);

			$ca = substr($row[$n],0,4);
			if($ca)	array_push($arr, $ca);

			$ca = substr($row[$n],0,6);
			if($ca)	array_push($arr, $ca);
		}
	}

	if(count($arr) > 0) {
		$arr = array_unique($arr);
		$arr = implode("|",$arr);
		$arr = explode("|",$arr);
		$arr_cnt = count($arr);
		for($i = 0; $i < $arr_cnt; $i++) {
			$key = $arr[$i];
			$list[$key] = true;
		}
	} 

	return $list;
}

//----------------------------------------------------------------//
// 추출 관련 함수들
//----------------------------------------------------------------//

// 장바구니
function apms_cart_rows($arr='') {
	global $g5;

	$list = array();

	$cart_id = get_session('ss_cart_id');

	if($cart_id) {
		$thumb_w = (isset($arr['thumb_w']) && $arr['thumb_w'] > 0) ? $arr['thumb_w'] : 50;
		$thumb_h = (isset($arr['thumb_h']) && $arr['thumb_h'] > 0) ? $arr['thumb_h'] : 50;
		$no_img = (isset($arr['no_img']) && $arr['no_img']) ? $arr['no_img'] : '';
		$result = sql_query(" select * from {$g5['g5_shop_cart_table']} where od_id = '{$cart_id}' group by it_id ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row;
			$list[$i]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
			$list[$i]['alt'] = get_text($row['it_name']);

			$it = apms_it($row['it_id']);
			$it['no_img'] = $no_img;
			$thumb = apms_it_thumbnail($it, $thumb_w, $thumb_h, false, true);

			$list[$i]['img'] = $thumb['src'];
		}
	}

	return $list;
}

// 오늘본 아이템
function apms_today_rows($arr='') {
	global $g5;

	$list = array();

	$tv_idx = get_session("ss_tv_idx");

	if($tv_idx) {
		$thumb_w = (isset($arr['thumb_w']) && $arr['thumb_w'] > 0) ? $arr['thumb_w'] : 50;
		$thumb_h = (isset($arr['thumb_h']) && $arr['thumb_h'] > 0) ? $arr['thumb_h'] : 50;
		$no_img = (isset($arr['no_img']) && $arr['no_img']) ? $arr['no_img'] : '';
		$i = 0;
		for ($k=1;$k<=$tv_idx;$k++) {
			$tv_it_idx = $tv_idx - ($k - 1);
			$tv_it_id = get_session("ss_tv[$tv_it_idx]");

			$row = sql_fetch(" select * from {$g5['g5_shop_item_table']} where it_id = '$tv_it_id' ");
			if(!$row['it_id'])
				continue;

			$list[$i] = $row;
			$list[$i]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
			$list[$i]['alt'] = get_text($row['it_name']);

			$row['no_img'] = $no_img;
			$thumb = apms_it_thumbnail($row, $thumb_w, $thumb_h, false, true);

			$list[$i]['img'] = $thumb['src'];

			$i++;
		}
	}

	return $list;
}

// 아이템 기준 - 등록일
function apms_item_rows($arr) {
	global $g5, $demo_config, $is_demo;

	$list = array();

	//정리
	$type = (isset($arr['type']) && $arr['type']) ? apms_escape_string($arr['type']) : '';
	$pt_list = (isset($arr['pt_list']) && $arr['pt_list']) ? apms_escape_string($arr['pt_list']) : '';
	$ex_pt = (isset($arr['ex_pt']) && $arr['ex_pt']) ? apms_escape_string($arr['ex_pt']) : '';
	$ca_id = (isset($arr['ca_id']) && $arr['ca_id']) ? apms_escape_string($arr['ca_id']) : '';
	$ex_ca = (isset($arr['ex_ca']) && $arr['ex_ca']) ? apms_escape_string($arr['ex_ca']) : '';
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = (isset($arr['page']) && $arr['page'] > 1) ? $arr['page'] : 1;
	$sort = (isset($arr['sort']) && $arr['sort']) ? $arr['sort'] : '';
	$newtime = (isset($arr['newtime']) && $arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = (isset($arr['thumb_w']) && $arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = (isset($arr['thumb_h']) && $arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$thumb_no = (isset($arr['thumb_no']) && $arr['thumb_no']) ? true : false;
	$img_rows = (isset($arr['img_rows']) && $arr['img_rows'] > 0) ? $arr['img_rows'] : 0;
	$no_img = (isset($arr['no_img']) && $arr['no_img']) ? $arr['no_img'] : '';

	$sql_where = (isset($arr['where']) && $arr['where']) ? 'and '.$arr['where'] : '';
	$sql_orderby = (isset($arr['orderby']) && $arr['orderby']) ? $arr['orderby'].',' : '';
	$sql_main = (isset($arr['main']) && $arr['main']) ? "and pt_main = '".apms_escape_string($arr['main'])."'" : "";

	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and it_type{$type} = '1'" : "";
	$sql_type .= apms_chk_item_type($arr);

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(pt_id, '{$ex_pt}')=0" : "";

	//데모
	if($is_demo) {
		if(!$ca_id && isset($demo_config['ca_id']) && $demo_config['ca_id']) $ca_id = $demo_config['ca_id'];
	}

	// 분류
	$sql_ca = ($ca_id) ? "and (ca_id like '$ca_id%' or ca_id2 like '$ca_id%' or ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (ca_id not like '$ex_ca%' and ca_id2 not like '$ex_ca%' and ca_id3 not like '$ex_ca%')" : "";

	// 정렬
	switch($sort) { 
		case 'hp'			: $orderby = 'it_price desc'; break;
		case 'lp'			: $orderby = 'it_price asc'; break;
		case 'qty'			: $orderby = 'it_sum_qty desc'; break;
		case 'use'			: $orderby = 'it_use_cnt desc'; break;
		case 'hit'			: $orderby = 'it_hit desc'; break;
		case 'star'			: $orderby = 'it_use_avg desc'; break;
		case 'comment'		: $orderby = 'pt_comment desc'; break;
		case 'good'			: $orderby = 'pt_good desc'; break;
		case 'nogood'		: $orderby = 'pt_nogood desc'; break;
		case 'like'			: $orderby = '(pt_good - pt_nogood) desc'; break;
		case 'rdm'			: $orderby = 'rand()'; $page = 1; break;
		default				: $orderby = 'it_order, pt_num desc, it_id desc'; break;
	}

	// 기간(일수,today,yesterday,month,prev)
	$dayterm = (isset($arr['dayterm']) && $arr['dayterm'] > 0) ? $arr['dayterm'] : 0;
	$term = (isset($arr['term']) && $arr['term']) ? $arr['term'] : '';
	$term = ($term == 'day' && $dayterm > 0) ? $dayterm : $term;
	$sql_term = apms_sql_term($term, 'it_time'); 

	$sql_common = "from {$g5['g5_shop_item_table']} where it_use = '1' and it_soldout <> '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term $sql_main $sql_where";
	if($page > 1) {
		$total = sql_fetch("select count(*) as cnt $sql_common ", false);
		$total_count = $total['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}
	$result = sql_query(" select *  $sql_common order by $sql_orderby $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$row['is_thumb_no'] = $thumb_no;
		$row['img_rows'] = $img_rows;
		$row['no_img'] = $no_img;

		$list[$i] = thema_widget_item_list('item', $ca_id, $row, $newtime, $thumb_w, $thumb_h, false, true);
	}

	return $list;
}

// 파트너 기준 - 아이템 등록일
function apms_item_partner_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$type = (isset($arr['type']) && $arr['type']) ? apms_escape_string($arr['type']) : '';
	$pt_list = (isset($arr['pt_list']) && $arr['pt_list']) ? apms_escape_string($arr['pt_list']) : '';
	$ex_pt = (isset($arr['ex_pt']) && $arr['ex_pt']) ? apms_escape_string($arr['ex_pt']) : '';
	$ca_id = (isset($arr['ca_id']) && $arr['ca_id']) ? apms_escape_string($arr['ca_id']) : '';
	$ex_ca = (isset($arr['ex_ca']) && $arr['ex_ca']) ? apms_escape_string($arr['ex_ca']) : '';
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = (isset($arr['page']) && $arr['page'] > 1) ? $arr['page'] : 1;
	$sort = (isset($arr['sort']) && $arr['sort']) ? $arr['sort'] : '';
	$no_photo = (isset($arr['no_photo']) && $arr['no_photo']) ? $arr['no_photo'] : '';

	$sql_where = (isset($arr['where']) && $arr['where']) ? 'and '.$arr['where'] : '';
	$sql_orderby = (isset($arr['orderby']) && $arr['orderby']) ? $arr['orderby'].',' : '';
	$sql_main = (isset($arr['main']) && $arr['main']) ? "and pt_main = '".apms_escape_string($arr['main'])."'" : "";

	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and it_type{$type} = '1'" : "";
	$sql_type .= apms_chk_item_type($arr);

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(pt_id, '{$ex_pt}')=0" : "";

	// 분류
	$sql_ca = ($ca_id) ? "and (ca_id like '$ca_id%' or ca_id2 like '$ca_id%' or ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (ca_id not like '$ex_ca%' and ca_id2 not like '$ex_ca%' and ca_id3 not like '$ex_ca%')" : "";

	// 정렬
	switch($sort) { 
		case 'cnt'			: $orderby = 'cnt desc'; break;
		case 'use'			: $orderby = 'use desc'; break;
		case 'hit'			: $orderby = 'hit desc'; break;
		case 'comment'		: $orderby = 'comment desc'; break;
		case 'good'			: $orderby = 'good desc'; break;
		case 'nogood'		: $orderby = 'nogood desc'; break;
		case 'like'			: $orderby = '(good - nogood) desc'; break;
		case 'rdm'			: $orderby = 'rand()'; $page = 1; break;
		default				: $orderby = 'qty desc'; break;
	}

	// 기간(일수,today,yesterday,month,prev)
	$dayterm = (isset($arr['dayterm']) && $arr['dayterm'] > 0) ? $arr['dayterm'] : 0;
	$term = (isset($arr['term']) && $arr['term']) ? $arr['term'] : '';
	$term = ($term == 'day' && $dayterm > 0) ? $dayterm : $term;
	$sql_term = apms_sql_term($term, 'it_time'); 

	$sql_common = "from {$g5['g5_shop_item_table']} where it_use = '1' and it_soldout <> '1' and pt_id <> '' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term $sql_main $sql_where";
	if($page > 1) {
		$row = sql_fetch(" SELECT COUNT(DISTINCT `pt_id`) AS `cnt` $sql_common ");
		$total_count = $row['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}
	$result = sql_query(" select pt_id, count(*) as cnt, sum(it_sum_qty) as qty, sum(it_use_cnt) as use, sum(it_hit) as hit, sum(pt_comment) as comment, sum(pt_good) as good, sum(pt_nogood) as nogood $sql_common group by pt_id order by $sql_orderby $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = get_member($row['pt_id']);
		$list[$i]['photo'] = apms_photo_url($lsit[$i]['mb_id']);
		if(!$list[$i]['photo'] && $no_photo) {
			$list[$i]['photo'] = $no_photo; // no-photo
		}
		$m = 'xp_grade'.$list[$i]['mb_level'];
		$list[$i]['grade'] = $xp[$m];
		$list[$i]['name'] = ($list[$i]['mb_open']) ? apms_sideview($list[$i]['mb_id'], get_text($list[$i]['mb_nick']), $list[$i]['mb_email'], $list[$i]['mb_homepage']) : apms_sideview($list[$i]['mb_id'], get_text($list[$i]['mb_nick']), '', '');
		$list[$i]['cnt'] = $row['cnt'];
		$list[$i]['qty'] = $row['qty'];
		$list[$i]['use'] = $row['use'];
		$list[$i]['hit'] = $row['hit'];
		$list[$i]['comment'] = $row['comment'];
		$list[$i]['good'] = $row['good'];
		$list[$i]['nogood'] = $row['nogood'];
	}

	return $list;
}

// 판매기준 - 판매일
function apms_sale_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$type = (isset($arr['type']) && $arr['type']) ? apms_escape_string($arr['type']) : '';
	$pt_list = (isset($arr['pt_list']) && $arr['pt_list']) ? apms_escape_string($arr['pt_list']) : '';
	$ex_pt = (isset($arr['ex_pt']) && $arr['ex_pt']) ? apms_escape_string($arr['ex_pt']) : '';
	$ca_id = (isset($arr['ca_id']) && $arr['ca_id']) ? apms_escape_string($arr['ca_id']) : '';
	$ex_ca = (isset($arr['ex_ca']) && $arr['ex_ca']) ? apms_escape_string($arr['ex_ca']) : '';
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = (isset($arr['page']) && $arr['page'] > 1) ? $arr['page'] : 1;
	$sort = (isset($arr['sort']) && $arr['sort']) ? $arr['sort'] : '';
	$newtime = (isset($arr['newtime']) && $arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = (isset($arr['thumb_w']) && $arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = (isset($arr['thumb_h']) && $arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$thumb_no = (isset($arr['thumb_no']) && $arr['thumb_no']) ? true : false;
	$img_rows = (isset($arr['img_rows']) && $arr['img_rows'] > 0) ? $arr['img_rows'] : 0;
	$no_img = (isset($arr['no_img']) && $arr['no_img']) ? $arr['no_img'] : '';

	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and b.it_type{$type} = '1'" : "";
	$sql_type .= apms_chk_item_type($arr, 'b.');

	// 분류
	$sql_ca = ($ca_id) ? "and (b.ca_id like '$ca_id%' or b.ca_id2 like '$ca_id%' or b.ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (b.ca_id not like '$ex_ca%' and b.ca_id2 not like '$ex_ca%' and b.ca_id3 not like '$ex_ca%')" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(b.pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(b.pt_id, '{$ex_pt}')=0" : "";

	// 정렬
	switch($sort) { 
		case 'cnt'			: $orderby = 'cnt desc'; break;
		case 'qty'			: $orderby = 'qty desc'; break;
		default				: $orderby = 'sale desc'; break;
	}

	$dayterm = (isset($arr['dayterm']) && $arr['dayterm'] > 0) ? $arr['dayterm'] : 0;
	$term = (isset($arr['term']) && $arr['term']) ? $arr['term'] : '';
	$term = ($term == 'day' && $dayterm > 0) ? $dayterm : $term;
	$sql_term = apms_sql_term($term, 'a.ct_select_time'); // 기간(일수,today,yesterday,month,prev)

	$sql_common = "from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) 
					where b.it_use = '1' and b.it_soldout <> '1' and a.ct_status = '완료' and a.ct_select = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";

	if($page > 1) {
		$row = sql_fetch(" SELECT COUNT(DISTINCT `a.pt_id`) AS `cnt` $sql_common ");
		$total_count = $row['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}
	$result = sql_query(" select b.*, count(*) as cnt, sum(a.pt_sale) as sale, sum(a.ct_qty) as qty $sql_common group by a.it_id order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$row['is_thumb_no'] = $thumb_no;
		$row['img_rows'] = $img_rows;
		$row['no_img'] = $no_img;

		$list[$i] = thema_widget_item_list('item', $ca_id, $row, $newtime, $thumb_w, $thumb_h, false, true);
	}

	return $list;
}

// 파트너 기준 - 판매일
function apms_sale_partner_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$type = (isset($arr['type']) && $arr['type']) ? apms_escape_string($arr['type']) : '';
	$pt_list = (isset($arr['pt_list']) && $arr['pt_list']) ? apms_escape_string($arr['pt_list']) : '';
	$ex_pt = (isset($arr['ex_pt']) && $arr['ex_pt']) ? apms_escape_string($arr['ex_pt']) : '';
	$ca_id = (isset($arr['ca_id']) && $arr['ca_id']) ? apms_escape_string($arr['ca_id']) : '';
	$ex_ca = (isset($arr['ex_ca']) && $arr['ex_ca']) ? apms_escape_string($arr['ex_ca']) : '';
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = (isset($arr['page']) && $arr['page'] > 1) ? $arr['page'] : 1;
	$sort = (isset($arr['sort']) && $arr['sort']) ? $arr['sort'] : '';
	$no_photo = (isset($arr['no_photo']) && $arr['no_photo']) ? $arr['no_photo'] : '';

	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and b.it_type{$type} = '1'" : "";
	$sql_type .= apms_chk_item_type($arr, 'b.');

	// 분류
	$sql_ca = ($ca_id) ? "and (b.ca_id like '$ca_id%' or b.ca_id2 like '$ca_id%' or b.ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (b.ca_id not like '$ex_ca%' and b.ca_id2 not like '$ex_ca%' and b.ca_id3 not like '$ex_ca%')" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(b.pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(b.pt_id, '{$ex_pt}')=0" : "";

	// 정렬
	switch($sort) { 
		case 'cnt'	: $orderby = 'cnt desc'; break;
		case 'qty'	: $orderby = 'qty desc'; break;
		default		: $orderby = 'sale desc'; break;
	}

	$dayterm = (isset($arr['dayterm']) && $arr['dayterm'] > 0) ? $arr['dayterm'] : 0;
	$term = (isset($arr['term']) && $arr['term']) ? $arr['term'] : '';
	$term = ($term == 'day' && $dayterm > 0) ? $dayterm : $term;
	$sql_term = apms_sql_term($term, 'a.ct_select_time'); // 기간(일수,today,yesterday,month,prev)

	$sql_common = "from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) 
					where a.pt_id <> '' and a.ct_status = '완료' and a.ct_select = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";

	if($page > 1) {
		$row = sql_fetch(" SELECT COUNT(DISTINCT `a.pt_id`) AS `cnt` $sql_common ");
		$total_count = $row['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}
	$result = sql_query(" select a.pt_id, count(*) as cnt, sum(a.pt_sale) as sale, sum(a.ct_qty) as qty $sql_common group by a.pt_id order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = get_member($row['pt_id']);
		$list[$i]['photo'] = apms_photo_url($lsit[$i]['mb_id']);
		if(!$list[$i]['photo'] && $no_photo) {
			$list[$i]['photo'] = $no_photo; // no-photo
		}
		$m = 'xp_grade'.$list[$i]['mb_level'];
		$list[$i]['grade'] = $xp[$m];
		$list[$i]['name'] = ($list[$i]['mb_open']) ? apms_sideview($list[$i]['mb_id'], get_text($list[$i]['mb_nick']), $list[$i]['mb_email'], $list[$i]['mb_homepage']) : apms_sideview($list[$i]['mb_id'], get_text($list[$i]['mb_nick']), '', '');
		$list[$i]['cnt'] = $row['cnt'];
		$list[$i]['sale'] = $row['sale'];
		$list[$i]['qty'] = $row['qty'];
	}
	return $list;
}

// 마케터 기준 - 판매일
function apms_mkt_partner_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$type = (isset($arr['type']) && $arr['type']) ? apms_escape_string($arr['type']) : '';
	$pt_list = (isset($arr['pt_list']) && $arr['pt_list']) ? apms_escape_string($arr['pt_list']) : '';
	$ex_pt = (isset($arr['ex_pt']) && $arr['ex_pt']) ? apms_escape_string($arr['ex_pt']) : '';
	$ca_id = (isset($arr['ca_id']) && $arr['ca_id']) ? apms_escape_string($arr['ca_id']) : '';
	$ex_ca = (isset($arr['ex_ca']) && $arr['ex_ca']) ? apms_escape_string($arr['ex_ca']) : '';
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = (isset($arr['page']) && $arr['page'] > 1) ? $arr['page'] : 1;
	$sort = (isset($arr['sort']) && $arr['sort']) ? $arr['sort'] : '';
	$no_photo = (isset($arr['no_photo']) && $arr['no_photo']) ? $arr['no_photo'] : '';

	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and b.it_type{$type} = '1'" : "";
	$sql_type .= apms_chk_item_type($arr, 'b.');

	// 분류
	$sql_ca = ($ca_id) ? "and (b.ca_id like '$ca_id%' or b.ca_id2 like '$ca_id%' or b.ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (b.ca_id not like '$ex_ca%' and b.ca_id2 not like '$ex_ca%' and b.ca_id3 not like '$ex_ca%')" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(b.mk_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(b.mk_id, '{$ex_pt}')=0" : "";

	// 정렬
	switch($sort) { 
		case 'cnt'	: $orderby = 'cnt desc'; break;
		case 'qty'	: $orderby = 'qty desc'; break;
		default		: $orderby = 'profit desc'; break;
	}

	$dayterm = (isset($arr['dayterm']) && $arr['dayterm'] > 0) ? $arr['dayterm'] : 0;
	$term = (isset($arr['term']) && $arr['term']) ? $arr['term'] : '';
	$term = ($term == 'day' && $dayterm > 0) ? $dayterm : $term;
	$sql_term = apms_sql_term($term, 'a.ct_select_time'); // 기간(일수,today,yesterday,month,prev)

	$sql_common = "from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) 
					where a.mk_id <> '' and a.ct_status = '완료' and a.ct_select = '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";

	if($page > 1) {
		$row = sql_fetch(" SELECT COUNT(DISTINCT `a.mk_id`) AS `cnt` $sql_common ");
		$total_count = $row['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}
	$result = sql_query(" select a.mk_id, count(*) as cnt, sum(a.mk_profit + a.mk_benefit) as profit, sum(a.ct_qty) as qty $sql_common group by a.mk_id order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = get_member($row['mk_id']);
		$list[$i]['photo'] = apms_photo_url($lsit[$i]['mb_id']);
		if(!$list[$i]['photo'] && $no_photo) {
			$list[$i]['photo'] = $no_photo; // no-photo
		}
		$m = 'xp_grade'.$list[$i]['mb_level'];
		$list[$i]['grade'] = $xp[$m];
		$list[$i]['name'] = ($list[$i]['mb_open']) ? apms_sideview($list[$i]['mb_id'], get_text($list[$i]['mb_nick']), $list[$i]['mb_email'], $list[$i]['mb_homepage']) : apms_sideview($list[$i]['mb_id'], get_text($list[$i]['mb_nick']), '', '');
		$list[$i]['cnt'] = $row['cnt'];
		$list[$i]['profit'] = $row['profit'];
		$list[$i]['qty'] = $row['qty'];
	}
	return $list;
}

// 이벤트 기준 - 아이템
function apms_item_event_rows($arr) {
	global $g5;

	$list = array();

	//정리
	$ev_id = (isset($arr['ev_id']) && $arr['ev_id']) ? apms_escape_string($arr['ev_id']) : '';

	if(!$ev_id) return;

	$type = (isset($arr['type']) && $arr['type']) ? apms_escape_string($arr['type']) : '';
	$pt_list = (isset($arr['pt_list']) && $arr['pt_list']) ? apms_escape_string($arr['pt_list']) : '';
	$ex_pt = (isset($arr['ex_pt']) && $arr['ex_pt']) ? apms_escape_string($arr['ex_pt']) : '';
	$ca_id = (isset($arr['ca_id']) && $arr['ca_id']) ? apms_escape_string($arr['ca_id']) : '';
	$ex_ca = (isset($arr['ex_ca']) && $arr['ex_ca']) ? apms_escape_string($arr['ex_ca']) : '';
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 4;
	$page = (isset($arr['page']) && $arr['page'] > 1) ? $arr['page'] : 1;
	$sort = (isset($arr['sort']) && $arr['sort']) ? $arr['sort'] : '';
	$newtime = (isset($arr['newtime']) && $arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = (isset($arr['thumb_w']) && $arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = (isset($arr['thumb_h']) && $arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$thumb_no = (isset($arr['thumb_no']) && $arr['thumb_no']) ? true : false;
	$img_rows = (isset($arr['img_rows']) && $arr['img_rows'] > 0) ? $arr['img_rows'] : 0;
	$no_img = (isset($arr['no_img']) && $arr['no_img']) ? $arr['no_img'] : '';

	$start_rows = 0;

	// 타입
	$sql_type = ($type) ? "and b.it_type{$type} = '1'" : "";
	$sql_type .= apms_chk_item_type($arr, 'b.');

	// 분류
	$sql_ca = ($ca_id) ? "and (b.ca_id like '$ca_id%' or b.ca_id2 like '$ca_id%' or b.ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (b.ca_id not like '$ex_ca%' and b.ca_id2 not like '$ex_ca%' and b.ca_id3 not like '$ex_ca%')" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(b.pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(b.pt_id, '{$ex_pt}')=0" : "";

	// 정렬
	switch($sort) { 
		case 'hp'		: $orderby = 'b.it_price desc'; break;
		case 'lp'		: $orderby = 'b.it_price asc'; break;
		case 'qty'		: $orderby = 'b.it_sum_qty desc'; break;
		case 'use'		: $orderby = 'b.it_use_cnt desc'; break;
		case 'hit'		: $orderby = 'b.it_hit desc'; break;
		case 'star'		: $orderby = 'b.it_use_avg desc'; break;
		case 'comment'	: $orderby = 'b.pt_comment desc'; break;
		case 'good'		: $orderby = 'b.pt_good desc'; break;
		case 'nogood'	: $orderby = 'b.pt_nogood desc'; break;
		case 'like'		: $orderby = '(b.pt_good - b.pt_nogood) desc'; break;
		case 'rdm'		: $orderby = 'rand()'; $page = 1; break;
		default			: $orderby = 'b.it_order, b.pt_num desc'; break;
	}

	$dayterm = (isset($arr['dayterm']) && $arr['dayterm'] > 0) ? $arr['dayterm'] : 0;
	$term = (isset($arr['term']) && $arr['term']) ? $arr['term'] : '';
	$term = ($term == 'day' && $dayterm > 0) ? $dayterm : $term;
	$sql_term = apms_sql_term($term, 'b.it_time'); // 기간(일수,today,yesterday,month,prev)

	$sql_common = "from `{$g5['g5_shop_event_item_table']}` a left join `{$g5['g5_shop_item_table']}` b on (a.it_id = b.it_id) 
					where a.ev_id = '{$ev_id}' and b.it_use = '1' and b.it_soldout <> '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";

	if($page > 1) {
		$total = sql_fetch("select count(*) as cnt $sql_common ", false);
		$total_count = $total['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}

	$result = sql_query(" select * $sql_common order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$row['is_thumb_no'] = $thumb_no;
		$row['img_rows'] = $img_rows;
		$row['no_img'] = $no_img;

		$list[$i] = thema_widget_item_list('item', $ca_id, $row, $newtime, $thumb_w, $thumb_h, false, true);
	}

	return $list;
}

// 포스트 기준 - 아이템
function apms_item_post_rows($arr) {
	global $g5, $demo_config, $is_demo;

	$list = array();

	//정리
	$type = (isset($arr['type']) && $arr['type']) ? apms_escape_string($arr['type']) : '';
	$pt_list = (isset($arr['pt_list']) && $arr['pt_list']) ? apms_escape_string($arr['pt_list']) : '';
	$ex_pt = (isset($arr['ex_pt']) && $arr['ex_pt']) ? apms_escape_string($arr['ex_pt']) : '';
	$ca_id = (isset($arr['ca_id']) && $arr['ca_id']) ? apms_escape_string($arr['ca_id']) : '';
	$ex_ca = (isset($arr['ex_ca']) && $arr['ex_ca']) ? apms_escape_string($arr['ex_ca']) : '';
	$mode = (isset($arr['mode']) && $arr['mode']) ? $arr['mode'] : 'comment';
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 5;
	$page = (isset($arr['page']) && $arr['page'] > 1) ? $arr['page'] : 1;
	$sort = (isset($arr['sort']) && $arr['sort']) ? $arr['sort'] : '';
	$newtime = (isset($arr['newtime']) && $arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = (isset($arr['thumb_w']) && $arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = (isset($arr['thumb_h']) && $arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$thumb_no = (isset($arr['thumb_no']) && $arr['thumb_no']) ? true : false;
	$img_rows = (isset($arr['img_rows']) && $arr['img_rows'] > 0) ? $arr['img_rows'] : 0;
	$no_img = (isset($arr['no_img']) && $arr['no_img']) ? $arr['no_img'] : '';

	$start_rows = 0;

	//데모
	if($is_demo) {
		if(!$ca_id && isset($demo_config['ca_id']) && $demo_config['ca_id']) $ca_id = $demo_config['ca_id'];
	}

	// 타입
	$sql_type = ($type) ? "and b.it_type{$type} = '1'" : "";
	$sql_type .= apms_chk_item_type($arr, 'b.');

	// 분류
	$sql_ca = ($ca_id) ? "and (b.ca_id like '$ca_id%' or b.ca_id2 like '$ca_id%' or b.ca_id3 like '$ca_id%')" : "";
	$sql_ca_ex = ($ex_ca) ? "and (b.ca_id not like '$ex_ca%' and b.ca_id2 not like '$ex_ca%' and b.ca_id3 not like '$ex_ca%')" : "";

	// 파트너
	$sql_pt = ($pt_list) ? "and find_in_set(b.pt_id, '{$pt_list}')" : "";
	$sql_pt_ex = ($ex_pt) ? "and find_in_set(b.pt_id, '{$ex_pt}')=0" : "";

	// 정렬
	$orderby = '';
	switch($sort) { 
		case 'hp'		: $orderby = 'b.it_price desc'; break;
		case 'lp'		: $orderby = 'b.it_price asc'; break;
		case 'qty'		: $orderby = 'b.it_sum_qty desc, '; break;
		case 'use'		: $orderby = 'b.it_use_cnt desc, '; break;
		case 'hit'		: $orderby = 'b.it_hit desc, '; break;
		case 'star'		: $orderby = 'b.it_use_avg desc'; break;
		case 'comment'	: $orderby = 'b.pt_comment desc, '; break;
		case 'good'		: $orderby = 'b.pt_good desc, '; break;
		case 'nogood'	: $orderby = 'b.pt_nogood desc, '; break;
		case 'like'		: $orderby = '(b.pt_good - b.pt_nogood) desc, '; break;
	}

	$dayterm = (isset($arr['dayterm']) && $arr['dayterm'] > 0) ? $arr['dayterm'] : 0;
	$term = (isset($arr['term']) && $arr['term']) ? $arr['term'] : '';
	$term = ($term == 'day' && $dayterm > 0) ? $dayterm : $term;
	$sql_term = apms_sql_term($term, 'b.it_time'); // 기간(일수,today,yesterday,month,prev)

	if($mode == 'comment') {
		$orderby .= "a.wr_id desc";
		$sql_common = "from `{$g5['apms_comment']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id)
						where b.it_use = '1' and b.it_soldout <> '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";		
	} else if($mode == 'use') {
		$orderby .= "a.is_id desc";
		$sql_common = "from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id)
						where a.is_confirm = '1' and b.it_use = '1' and b.it_soldout <> '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";		
	} else if($mode == 'qa') {
		$orderby .= "a.iq_id desc";
		$sql_common = "from `{$g5['g5_shop_item_qa_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id)
						where b.it_use = '1' and b.it_soldout <> '1' $sql_type $sql_ca $sql_ca_ex $sql_pt $sql_pt_ex $sql_term ";		
	} else {
		return;
	}

	if($page > 1) {
		$total = sql_fetch("select count(*) as cnt $sql_common ", false);
		$total_count = $total['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}

	$result = sql_query(" select a.*, b.it_name $sql_common order by $orderby limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$row['is_thumb_no'] = $thumb_no;
		$row['img_rows'] = $img_rows;
		$row['no_img'] = $no_img;

		$list[$i] = thema_widget_item_list('item'.$mode, $ca_id, $row, $newtime, $thumb_w, $thumb_h, false, true);
	}

	return $list;
}

// 이벤트 배너
function apms_banner_event_rows($arr) {
	global $g5, $demo_config;

	$list = array();

	$ev_id = (isset($arr['ev_id']) && $arr['ev_id']) ? apms_escape_string($arr['ev_id']) : '';
	$type = (isset($arr['type']) && $arr['type']) ? apms_escape_string($arr['type']) : '';
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 8;
	$sort = (isset($arr['sort']) && $arr['sort']) ? $arr['sort'] : '';
	$thumb_w = (isset($arr['thumb_w']) && $arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = (isset($arr['thumb_h']) && $arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$thumb_no = (isset($arr['thumb_no']) && $arr['thumb_no']) ? true : false;
	$banner = (isset($arr['banner']) && $arr['banner']) ? 's' : 'm';

	//데모
	if(isset($demo_config['ev_id']) && $demo_config['ev_id']) $ev_id = $demo_config['ev_id'];

	// 이벤트
	$sql_ev = '';
	if($ev_id) {
		$sql_ev = (isset($arr['except']) && $arr['except']) ? "and find_in_set(ev_id, '{$ev_id}')=0" : "and find_in_set(ev_id, '{$ev_id}')";
	}

	// 타입
	$sql_type = ($type) ? "and ev_type = '{$type}'" : "";

	// 정렬
	switch($sort) {
		case 'rdm'	: $orderby = 'rand()'; break;
		case 'asc'	: $orderby = 'ev_id'; break;
		default		: $orderby = 'ev_id desc'; break;
	}

	$sql = " select * from `{$g5['g5_shop_event_table']}` where ev_use = '1' $sql_ev $sql_ex_ev $sql_type order by $orderby limit 0, $rows ";
	$result = sql_query($sql, false);
	$j = 0;
	for ($i=0; $row=sql_fetch_array($result); $i++) { 

		if(!is_file(G5_DATA_PATH.'/event/'.$row['ev_id'].'_'.$banner)) continue;

		$list[$j] = $row;
		$list[$j]['href'] = ($row['ev_href']) ? set_http(get_text($row['ev_href'])) : G5_SHOP_URL.'/event.php?ev_id='.$row['ev_id'];
		$list[$j]['subject'] = get_text($row['ev_subject']);
		$img = apms_thumbnail(G5_DATA_URL.'/event/'.$row['ev_id'].'_'.$banner, $thumb_w, $thumb_h, false);
		$list[$j]['img'] = $img['src'];
		$list[$j]['alt'] = $list[$j]['subject'];
		$j++;
	}

	return $list;
}

// 배너
function apms_banner_rows($arr) {
	global $g5, $demo_config;

	$list = array();

	$bn_list = (isset($arr['bn_list']) && $arr['bn_list']) ? apms_escape_string($arr['bn_list']) : '';
	$position = (isset($arr['loc']) && $arr['loc']) ? apms_escape_string($arr['loc']) : '';
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 8;
	$sort = (isset($arr['sort']) && $arr['sort']) ? $arr['sort'] : '';
	$thumb_w = (isset($arr['thumb_w']) && $arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = (isset($arr['thumb_h']) && $arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$thumb_no = (isset($arr['thumb_no']) && $arr['thumb_no']) ? true : false;

	//데모
	if(isset($demo_config['bn_id']) && $demo_config['bn_id']) $bn_list = $demo_config['bn_id'];

	// 배너
	$sql_bn = '';
	if($bn_list) {
		$sql_bn = (isset($arr['except']) && $arr['except']) ? "and find_in_set(bn_id, '{$bn_list}')=0" : "and find_in_set(bn_id, '{$bn_list}')";
	}

	//위치
	$sql_loc = ($position) ? "and bn_position = '$position'" : "";

	// 정렬
	switch($sort) {
		case 'rdm'	: $orderby = 'rand()'; break;
		case 'asc'	: $orderby = 'bn_order desc, bn_id'; break;
		default		: $orderby = 'bn_order, bn_id desc'; break;
	}

	$sql = " select * from {$g5['g5_shop_banner_table']} where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time $sql_po $sql_bn $sql_loc order by $orderby limit 0, $rows ";
	$result = sql_query($sql);
	$j = 0;
	for ($i=0; $row=sql_fetch_array($result); $i++) { 

		if(!is_file(G5_DATA_PATH.'/banner/'.$row['bn_id'])) continue;

		$list[$j] = $row;
		$img = apms_thumbnail(G5_DATA_URL.'/banner/'.$row['bn_id'], $thumb_w, $thumb_h, false);
		$list[$j]['img'] = $img['src'];
		$list[$j]['alt'] = $row['bn_alt'];
		$list[$j]['target'] = ($row['bn_new_win']) ? ' target="_blank"' : '';
        if ($row['bn_url'][0] == '#') {
			$list[$j]['href'] = $row['bn_url'];
        } else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
			$list[$j]['href'] = G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'];
        }
		$j++;
	}

	return $list;

}

// 태그 관련상품 추출
function apms_tag_item_rows($arr) {
	global $g5;

	$list = array();
	$tag = (isset($arr['tag']) && $arr['tag']) ? apms_escape_string($arr['tag']) : '';
	if(!$tag) {
		return $list;	
	}
	$rows = (isset($arr['rows']) && $arr['rows'] > 0) ? $arr['rows'] : 7;
	$page = (isset($arr['page']) && $arr['page'] > 1) ? $arr['page'] : 1;
	$newtime = (isset($arr['newtime']) && $arr['newtime'] > 0) ? $arr['newtime'] : 24;
	$thumb_w = (isset($arr['thumb_w']) && $arr['thumb_w'] > 0) ? $arr['thumb_w'] : 0;
	$thumb_h = (isset($arr['thumb_h']) && $arr['thumb_h'] > 0) ? $arr['thumb_h'] : 0;
	$thumb_no = (isset($arr['thumb_no']) && $arr['thumb_no']) ? true : false;
	$img_rows = (isset($arr['img_rows']) && $arr['img_rows'] > 0) ? $arr['img_rows'] : 0;
	$no_img = (isset($arr['no_img']) && $arr['no_img']) ? $arr['no_img'] : '';
	$dayterm = (isset($arr['dayterm']) && $arr['dayterm'] > 0) ? $arr['dayterm'] : 0;
	$term = (isset($arr['term']) && $arr['term']) ? $arr['term'] : '';
	$term = ($term == 'day' && $dayterm > 0) ? $dayterm : $term;
	$sql_mb = "";
	if(isset($arr['mb_list']) && $arr['mb_list']) {
		$sql_mb = (isset($arr['ex_mb']) && $arr['ex_mb']) ? "and find_in_set(mb_id, '{$arr['mb_list']}')=0" : "and find_in_set(mb_id, '{$arr['mb_list']}')";
	}

	$start_rows = 0;

	$sql_common = " from {$g5['apms_tag_log']} where it_id <> '' and find_in_set(tag, '{$tag}') $sql_mb group by it_id ";

	if($page > 1) {
		$total = sql_query(" select count(*) as cnt $sql_common ", false);
		$total_count = @sql_num_rows($total);
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}

	$result = sql_query(" select it_id $sql_common order by regdate desc limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$item = apms_it($row['it_id']);

		$item['is_thumb_no'] = $thumb_no;
		$item['img_rows'] = $img_rows;
		$item['no_img'] = $no_img;

		$list[$i] = thema_widget_item_list('item', $item['ca_id'], $item, $newtime, $thumb_w, $thumb_h, false, true);
	}

	return $list;
}

// 분류명 리스트
function apms_shop_category_name($opt='') {
	global $g5;

	$list = array();
	$result = sql_query(" select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ");
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$c = $row['ca_id'];
		$list[$c] = $row['ca_name'];
	}

	return $list;

}

// 사용가능쿠폰 체크
function apms_coupon_update($mb_id) {
	global $g5;

	if(!$mb_id)
		return;

	$sql = " select cp_id from {$g5['g5_shop_coupon_table']} where mb_id IN ('{$mb_id}', '전체회원') and cp_start <= '".G5_TIME_YMD."' and cp_end >= '".G5_TIME_YMD."'";
	$result = sql_query($sql);

	$k = 0;
	for($i=0; $row=sql_fetch_array($result); $i++) {
		if(is_used_coupon($mb_id, $row['cp_id']))
			continue;

		$k++;
	}

	// 보유 쿠폰 업데이트
	sql_query(" update {$g5['member_table']} set as_coupon = '{$k}' where mb_id = '{$mb_id}' ", false);

	return;
}

// 복수상품타입체크
function apms_chk_item_type($arr, $opt='') {

	$type = array();

	if($arr['main']) $type[] = $opt."pt_main = '1'";
	if($arr['type1']) $type[] = $opt."it_type1 = '1'";
	if($arr['type2']) $type[] = $opt."it_type2 = '1'";
	if($arr['type3']) $type[] = $opt."it_type3 = '1'";
	if($arr['type4']) $type[] = $opt."it_type4 = '1'";
	if($arr['type5']) $type[] = $opt."it_type5 = '1'";

	$str = (count($type)) ? " and (".implode(" or ", $type).")" : "";

	return $str;
}

// 상품분류 배열
function apms_item_category_array($ca_id) {
	global $g5, $member, $is_admin;

	$cate = array();
	$ca_id_len = strlen($ca_id);
	$len1 = $ca_id_len - 2;
	$len2 = $ca_id_len + 2;
	$len4 = $ca_id_len + 4;
	$field = "ca_id, ca_name, as_min, as_max, as_grade, as_equal, as_menu_show";
	$where = "and ca_use = '1' order by ca_order, ca_id";
	$result = sql_query(" select $field from {$g5['g5_shop_category_table']} where ca_id like '$ca_id%' and length(ca_id) = $len2 $where ");
	$z = 0;
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		
		if(!$is_admin && $row['as_menu_show']) { // 접근제한
			if(apms_auth($row['as_grade'], $row['as_equal'], $row['as_min'], $row['as_max'], 1)) continue;
		}

		$cate[$z]['ca_id'] = $row['ca_id']; // 현재 분류와 일치체크
		$cate[$z]['name'] = $row['ca_name'];
		$cate[$z]['on'] = ($row['ca_id'] === $ca_id) ? true : false;
		$z++;
	}

	if($z == 0 && $ca_id_len > 2) {
		$ca_id_pre = substr($ca_id,0,$len1);
		$result = sql_query(" select $field from {$g5['g5_shop_category_table']} where ca_id like '$ca_id_pre%' and length(ca_id) = $ca_id_len $where ");
		$z = 0;
		for ($i=0; $row=sql_fetch_array($result); $i++) { 
			
			if(!$is_admin && $row['as_menu_show']) { // 접근제한
				if(apms_auth($row['as_grade'], $row['as_equal'], $row['as_min'], $row['as_max'], 1)) continue;
			}

			$cate[$z]['ca_id'] = $row['ca_id']; // 현재 분류와 일치체크
			$cate[$z]['name'] = $row['ca_name'];
			$cate[$z]['on'] = ($row['ca_id'] === $ca_id) ? true : false;
			$z++;
		}
	}

	return $cate;
}

?>