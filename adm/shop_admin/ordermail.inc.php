<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 제대로된 include 시에만 실행
if (!defined("_ORDERMAIL_")) exit;

// 파트너 메일발송
$is_pt_email = 0;
if (defined('USE_PARTNER') && USE_PARTNER && isset($_POST['pt_email'])) {
	$is_pt_email = count($_POST['pt_email']);
}

// 메일발송
if ($od_send_mail || $is_pt_email) {

	// 주문정보
	$od = sql_fetch(" select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ");

	// 메모
    $addmemo = nl2br(stripslashes($addmemo));

	// 주문상품
    $sql = " select *
               from {$g5['g5_shop_cart_table']}
              where od_id = '{$od['od_id']}'
              order by ct_id ";
    $result = sql_query($sql);
}

// 주문자님께 메일발송 체크를 했다면
if ($od_send_mail) {

    unset($cart_list);
    unset($card_list);
    unset($bank_list);
    unset($point_list);
    unset($delivery_list);

    for ($j=0; $ct=sql_fetch_array($result); $j++) {
        $cart_list[$j]['it_id']   = $ct['it_id'];
        $cart_list[$j]['it_name'] = $ct['it_name'];
        $cart_list[$j]['it_opt']  = $ct['ct_option'];

        $ct_status = $ct['ct_status'];
        if ($ct_status == "준비") {
            $ct_status = "상품준비중";
        } else if ($ct_status == "배송") {
            $ct_status = "배송중";
        }

        $cart_list[$j]['ct_status'] = $ct_status;
        $cart_list[$j]['ct_qty']    = $ct['ct_qty'];
    }

    /*
    ** 입금정보
    */
    $is_receipt = false;

    // 신용카드 입금
    if ($od['od_receipt_price'] > 0 && $od['od_settle_case'] == '신용카드') {
        $card_list['od_receipt_time'] = $od['od_receipt_time'];
        $card_list['od_receipt_price'] = display_price($od['od_receipt_price']);

        $is_receipt = true;
    }

    // 무통장 입금
    if ($od['od_receipt_price'] > 0 && $od['od_settle_case'] == '무통장') {
        $bank_list['od_receipt_time']    = $od['od_receipt_time'];
        $bank_list['od_receipt_price'] = display_price($od['od_receipt_price']);
        $bank_list['od_deposit_name'] = $od['od_deposit_name'];

        $is_receipt = true;
    }

    // 포인트 입금
    if ($od['od_receipt_point'] > 0) {
        $point_list['od_time']          = $od['od_time'];
        $point_list['od_receipt_point'] = display_point($od['od_receipt_point']);

        $is_receipt = true;
    }

    // 배송정보
    $is_delivery = false;
    if ($od['od_delivery_company'] && $od['od_invoice']) {
        $delivery_list['dl_company']      = $od['od_delivery_company'];
        $delivery_list['od_invoice']      = $od['od_invoice'];
        $delivery_list['od_invoice_time'] = $od['od_invoice_time'];
        $delivery_list['dl_inquiry']      = get_delivery_inquiry($od['od_delivery_company'], $od['od_invoice'], 'dvr_link');

        $is_delivery = true;
    }

    // 입금 또는 배송내역이 있다면 메일 발송
    if ($is_receipt || $is_delivery)
    {
        $title = $config['cf_title'].' - '.$od['od_name'].'님 주문 처리 내역 안내';

		ob_start();
        include ($misc_skin_path.'/ordermail.mail.php');
        $content = ob_get_contents();
        ob_end_clean();

        $email = $od['od_email'];

        // 메일 보낸 내역 상점메모에 update
        $od_shop_memo = G5_TIME_YMDHIS.' - 결제/배송내역 메일발송\n' . $od['od_shop_memo'];
        /* 1.00.06
        ** 주석처리 - 처리하지 않음
        if ($receipt_check)
            $od_shop_memo .= ", 입금확인";
        if ($invoice_check)
            $od_shop_memo .= ", 송장번호";
        */

        sql_query(" update {$g5['g5_shop_order_table']} set od_shop_memo = '$od_shop_memo' where od_id = '$od_id' ");

        mailer($config['cf_admin_email_name'], $config['cf_admin_email'], $email, $title, $content, 1);
    }
}

// 파트너에게 주문알림
if ($is_pt_email) {

	// 메모
    $od_memo = nl2br(stripslashes($od['od_memo']));
	$pt_memo = nl2br(stripslashes($pt_email_memo));

	$list = array();

	// 파트너 메일처리
    for ($k=0; $k < $is_pt_email; $k++) {

		// 파트너 아이디
		$pt_mb_id = $_POST['pt_email'][$k];

		// 파트너 아이디가 없으면 통과
		if(!$pt_mb_id) continue;

		// 회원정보에서 이메일 확인
		$pt_mb = apms_partner($pt_mb_id, 'pt_email');
		$pt_send_email = $pt_mb['pt_email'];
		
		// 파트너 이메일이 없으면 통과
		if(!$pt_send_email) continue;

		// 배송상품정리
		$z = 0;
		for ($j=0; $ct=sql_fetch_array($result); $j++) {

			// 파트너 아이디 없으면 통과
			if(!$ct['pt_id']) continue;

			// 파트너 아이디가 다르면 통과
			if($pt_mb_id != $ct['pt_id']) continue;

			// 배송가능상품이 아니면 통과
			if(in_array($ct['pt_it'], $g5['apms_automation'])) continue;

			// 상품정리
			$list[$z] = $ct;
		    $list[$z]['it_simg'] = get_it_image($ct['it_id'], 70, 70);

			//상품옵션
			$it_opt = array($ct['ct_option'], $ct['pt_msg1'], $ct['pt_msg2'], $ct['pt_msg3']);
			if(count($it_opt)) {
	 		    $list[$z]['it_opt'] = implode("<br>", $it_opt);
			} else {
	 		    $list[$z]['it_opt'] = $ct['ct_option'];
			}

			// 배송비
			switch($ct['ct_send_cost']) {
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
			if($ct['it_sc_type'] == 2) {
				// 합계금액 계산
				$sql2 = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
							SUM(ct_qty) as qty
							from {$g5['g5_shop_cart_table']}
							where it_id = '{$ct['it_id']}'
							and od_id = '{$od_id}' ";
				$sum = sql_fetch($sql2);
				$sendcost = get_item_sendcost($ct['it_id'], $sum['price'], $sum['qty'], $od_id);
				if($sendcost == 0)
					$ct_send_cost = '무료';
			}

			$list[$z]['sendcost'] = $ct_send_cost;

			$z++;
		}

		// 배송상품내역이 있으면 메일발송
		if($z) {

			$title = $config['cf_title'].' - '.$od['od_name'].'님 주문 내역 안내';

			ob_start();
	        include ($misc_skin_path.'/orderpartner.mail.php');
			$content = ob_get_contents();
			ob_end_clean();

			mailer($config['cf_admin_email_name'], $config['cf_admin_email'], $pt_send_email, $title, $content, 1);
		}

		unset($list);
	}
}

?>
