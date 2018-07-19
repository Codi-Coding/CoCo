<?php
if (!defined('_SHOP_')) exit;

require_once(G5_SHOP_PATH.'/settle_'.$default['de_pg_service'].'.inc.php');
require_once(G5_SHOP_PATH.'/settle_kakaopay.inc.php');

if( $default['de_inicis_lpay_use'] ){   //이니시스 Lpay 사용시
	ob_start();
	require_once (G5_SHOP_PATH.'/inicis/lpay_common.php');
	$inicis_lpay_common = ob_get_contents();
	ob_end_clean();
}

ob_start();
// 결제대행사별 코드 include (스크립트 등)
require_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.1.php');
$orderform1 = ob_get_contents();
ob_end_clean();

if( $default['de_inicis_lpay_use'] ){   //이니시스 L.pay 사용시
	ob_start();
    require_once(G5_SHOP_PATH.'/inicis/lpay_form.1.php');
    $inicis_lpay_form = ob_get_contents();
    ob_end_clean();
}

if($is_kakaopay_use) {
	ob_start();
    require_once(G5_SHOP_PATH.'/kakaopay/orderform.1.php');
    $kakaopay_orderform1 = ob_get_contents();
    ob_end_clean();
}

// 주문상품 확인
$tot_point = 0;
$tot_sell_price = 0;

$goods = $goods_it_id = "";
$goods_count = -1;

// $s_cart_id 로 현재 장바구니 자료 쿼리
$sql = " select a.ct_id,
                a.it_id,
                a.it_name,
                a.ct_price,
                a.ct_point,
                a.ct_qty,
                a.ct_status,
                a.ct_send_cost,
                a.it_sc_type,
                b.ca_id,
                b.ca_id2,
                b.ca_id3,
                b.it_notax
           from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
          where a.od_id = '$s_cart_id'
            and a.ct_select = '1' ";
$sql .= " group by a.it_id ";
$sql .= " order by a.ct_id ";
$result = sql_query($sql);

$good_info = '';
$it_send_cost = 0;
$it_cp_count = 0;

$comm_tax_mny = 0; // 과세금액
$comm_vat_mny = 0; // 부가세
$comm_free_mny = 0; // 면세금액
$tot_tax_mny = 0;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    // 합계금액 계산
    $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                    SUM(ct_point * ct_qty) as point,
                    SUM(ct_qty) as qty
                from {$g5['g5_shop_cart_table']}
                where it_id = '{$row['it_id']}'
                  and od_id = '$s_cart_id' ";
    $sum = sql_fetch($sql);

    if (!$goods)
    {
        //$goods = addslashes($row[it_name]);
        //$goods = get_text($row[it_name]);
        $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $row['it_name']);
        $goods_it_id = $row['it_id'];
    }
    $goods_count++;

    // 에스크로 상품정보
    if($default['de_escrow_use']) {
        if ($i>0)
            $good_info .= chr(30);
        $good_info .= "seq=".($i+1).chr(31);
        $good_info .= "ordr_numb={$od_id}_".sprintf("%04d", $i).chr(31);
        $good_info .= "good_name=".addslashes($row['it_name']).chr(31);
        $good_info .= "good_cntx=".$row['ct_qty'].chr(31);
        $good_info .= "good_amtx=".$row['ct_price'].chr(31);
    }

    $image = get_it_image($row['it_id'], 200);

    $it_name = '<b>' . stripslashes($row['it_name']) . '</b>';
    $it_options = print_item_options($row['it_id'], $s_cart_id);
    if($it_options) {
        $it_name .= '<div class="sod_opt">'.$it_options.'</div>';
    }

    // 복합과세금액
    if($default['de_tax_flag_use']) {
        if($row['it_notax']) {
            $comm_free_mny += $sum['price'];
        } else {
            $tot_tax_mny += $sum['price'];
        }
    }

    $point      = $sum['point'];
    $sell_price = $sum['price'];

    // 쿠폰
    if($is_member) {
        $cp_button = '';
        $cp_count = 0;

        $sql = " select cp_id
                    from {$g5['g5_shop_coupon_table']}
                    where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                      and cp_start <= '".G5_TIME_YMD."'
                      and cp_end >= '".G5_TIME_YMD."'
                      and cp_minimum <= '$sell_price'
                      and (
                            ( cp_method = '0' and cp_target = '{$row['it_id']}' )
                            OR
                            ( cp_method = '1' and ( cp_target IN ( '{$row['ca_id']}', '{$row['ca_id2']}', '{$row['ca_id3']}' ) ) )
                          ) ";
        $res = sql_query($sql);

        for($k=0; $cp=sql_fetch_array($res); $k++) {
            if(is_used_coupon($member['mb_id'], $cp['cp_id']))
                continue;

            $cp_count++;
        }

        if($cp_count) {
            $cp_button = '<button type="button" class="cp_btn btn_frmline">적용</button>';
            $it_cp_count++;
        }
    }

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
        $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

        if($sendcost == 0)
            $ct_send_cost = '무료';
    }

	$sod_list[$i]['it_id'] = $row['it_id'];
	$sod_list[$i]['it_name'] = $row['it_name'];
	$sod_list[$i]['it_notax'] = $row['it_notax'];
	$sod_list[$i]['ct_price'] = $row['ct_price'];
	$sod_list[$i]['sum_qty'] = $sum['qty'];
	$sod_list[$i]['image'] = $image;
	$sod_list[$i]['sell_price'] = $sell_price;
	$sod_list[$i]['point'] = $point;
	$sod_list[$i]['cp_count'] = $cp_count;
	$sod_list[$i]['ct_send_cost'] = $ct_send_cost;
    
    $tot_point      += $point;
    $tot_sell_price += $sell_price;

} // for 끝
$sod_count = count($sod_list);

if ($sod_count == 0) {
	alert('장바구니가 비어 있습니다.', G5_SHOP_URL.'/cart.php');
} else {
	// 배송비 계산
	$send_cost = get_sendcost($s_cart_id);
}

// 복합과세처리
if($default['de_tax_flag_use']) {
    $comm_tax_mny = round(($tot_tax_mny + $send_cost) / 1.1);
    $comm_vat_mny = ($tot_tax_mny + $send_cost) - $comm_tax_mny;
}

if ($goods_count) $goods .= ' 외 '.$goods_count.'건';
$tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비
// 주문상품 확인 끝

ob_start();
// 결제대행사별 코드 include (결제대행사 정보 필드)
include_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');
$orderform2 = ob_get_contents();
ob_end_clean();

if($is_kakaopay_use) {
	ob_start();
    require_once(G5_SHOP_PATH.'/kakaopay/orderform.2.php');
    $kakaopay_orderform2 = ob_get_contents();
    ob_end_clean();
}

// 받으시는 분 입력 시작
if($is_member) {
    // 배송지 이력
    $addr_list = '';
    $sep = chr(30);

    // 기본배송지
    $sql = " select *
                from {$g5['g5_shop_order_address_table']}
                where mb_id = '{$member['mb_id']}'
                  and ad_default = '1' ";
    $row = sql_fetch($sql);
    if($row['ad_id']) {
        $val1 = $row['ad_name'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip1'].$sep.$row['ad_zip2'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_addr3'].$sep.$row['ad_jibeon'].$sep.$row['ad_subject'];
        
        $ad_sel_addr = get_text($val1);
    }

    // 최근배송지
    $sql = " select *
                from {$g5['g5_shop_order_address_table']}
                where mb_id = '{$member['mb_id']}'
                  and ad_default = '0'
                order by ad_id desc
                limit 1 ";
    $result = sql_query($sql);
    for($i=0; $row=sql_fetch_array($result); $i++) {
        $val1 = $row['ad_name'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip1'].$sep.$row['ad_zip2'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_addr3'].$sep.$row['ad_jibeon'].$sep.$row['ad_subject'];

        $latest_addr[$i]['val1'] = get_text($val1);
        $latest_addr[$i]['ad_subject'] = $row['ad_subject'];
        $latest_addr[$i]['ad_name'] = $row['ad_name'];
    }
}

// 결제정보 입력 시작
$oc_cnt = $sc_cnt = 0;
if($is_member) {
    // 주문쿠폰
    $sql = " select cp_id
                from {$g5['g5_shop_coupon_table']}
                where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                  and cp_method = '2'
                  and cp_start <= '".G5_TIME_YMD."'
                  and cp_end >= '".G5_TIME_YMD."'
                  and cp_minimum <= '$tot_sell_price' ";
    $res = sql_query($sql);

    for($k=0; $cp=sql_fetch_array($res); $k++) {
        if(is_used_coupon($member['mb_id'], $cp['cp_id']))
            continue;

        $oc_cnt++;
    }

    if($send_cost > 0) {
        // 배송비쿠폰
        $sql = " select cp_id
                    from {$g5['g5_shop_coupon_table']}
                    where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                      and cp_method = '3'
                      and cp_start <= '".G5_TIME_YMD."'
                      and cp_end >= '".G5_TIME_YMD."'
                      and cp_minimum <= '$tot_sell_price' ";
        $res = sql_query($sql);

        for($k=0; $cp=sql_fetch_array($res); $k++) {
            if(is_used_coupon($member['mb_id'], $cp['cp_id']))
                continue;

            $sc_cnt++;
        }
    }
}

// 결제정보
$multi_settle == 0;
$checked = '';

$escrow_title = "";
if ($default['de_escrow_use']) {
	$escrow_title = "에스크로 ";
}

// 카카오페이
if($is_kakaopay_use) {
    $multi_settle++;
}

// 무통장입금 사용
if ($default['de_bank_use']) {
	$multi_settle++;
}

// 가상계좌 사용
if ($default['de_vbank_use']) {
    $multi_settle++;
}

// 계좌이체 사용
if ($default['de_iche_use']) {
    $multi_settle++;
}

// 휴대폰 사용
if ($default['de_hp_use']) {
    $multi_settle++;
}

// 신용카드 사용
if ($default['de_card_use']) {
    $multi_settle++;
}

// PG 간편결제
if($default['de_easy_pay_use']) {
    switch($default['de_pg_service']) {
        case 'lg':
            $pg_easy_pay_name = 'PAYNOW';
            break;
        case 'inicis':
            $pg_easy_pay_name = 'KPAY';
            break;
        default:
            $pg_easy_pay_name = 'PAYCO';
            break;
    }
    $multi_settle++;
}

// 포인트 결제
$temp_point = 0;
// 회원이면서 포인트사용이면
if ($is_member && $config['cf_use_point'])
{
	// 포인트 결제 사용 포인트보다 회원의 포인트가 크다면
	if ($member['mb_point'] >= $default['de_settle_min_point'])
	{
		$temp_point = (int)$default['de_settle_max_point'];

		if($temp_point > (int)$tot_sell_price)
			$temp_point = (int)$tot_sell_price;

		if($temp_point > (int)$member['mb_point'])
			$temp_point = (int)$member['mb_point'];

		$point_unit = (int)$default['de_settle_point_unit'];
		$temp_point = (int)((int)($temp_point / $point_unit) * $point_unit);
		$multi_settle++;
	}
}

// 무통장 결제은행
if ($default['de_bank_use']) {
	// 은행계좌를 배열로 만든후
	$bank_str = explode("\n", trim($default['de_bank_account']));
	if (count($bank_str) <= 1) {
		$bank_account = $bank_str[0];
	} else {
		for ($i=0; $i<count($bank_str); $i++) {
			$bank_str[$i] = trim($bank_str[$i]);
			$bank_account[$i]['bank'] .= $bank_str[$i];
		}
	}
}

ob_start();
include_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.3.php');
$orderform3 = ob_get_contents();
ob_end_clean();

if($is_kakaopay_use) {
	ob_start();
    require_once(G5_SHOP_PATH.'/kakaopay/orderform.3.php');
    $kakaopay_orderform3 = ob_get_contents();
    ob_end_clean();
}

if ($default['de_escrow_use']) {
	ob_start();
    include_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.4.php');
    $orderform4 = ob_get_contents();
    ob_end_clean();
}

if( $default['de_inicis_lpay_use'] ){   //이니시스 L.pay 사용시
	ob_start();
    require_once(G5_SHOP_PATH.'/inicis/lpay_order.script.php');
    $inicis_lpay_script = ob_get_contents();
    ob_end_clean();
}

ob_start();
include_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.5.php');
$orderform5 = ob_get_contents();
ob_end_clean();	