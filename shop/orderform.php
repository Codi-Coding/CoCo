<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/orderform.php');
    return;
}

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

// 주문상품 재고체크 js 파일
add_javascript('<script src="'.G5_JS_URL.'/shop.order.js"></script>', 0);

// 모바일 주문인지
$is_mobile_order = is_mobile();

set_session("ss_direct", $sw_direct);

// 장바구니가 비어있는가?
if ($sw_direct) {
    $tmp_cart_id = get_session('ss_cart_direct');
}
else {
    $tmp_cart_id = get_session('ss_cart_id');
}

if (get_cart_count($tmp_cart_id) == 0)
    alert('장바구니가 비어 있습니다.', G5_SHOP_URL.'/cart.php');

// Page ID
$pid = 'orderform';
$at = apms_page_thema($pid);

$g5['title'] = '주문서 작성';

// 모바일이 아니고 전자결제를 사용할 때만 실행
if($is_mobile_order) { 
	define('APMS_PGCHECK_PATH', G5_MSHOP_PATH);
} else {
	define('APMS_PGCHECK_PATH', G5_SHOP_PATH);
}

// 새로운 주문번호 생성
$od_id = get_uniqid();
set_session('ss_order_id', $od_id);
$s_cart_id = $tmp_cart_id;
if($default['de_pg_service'] == 'inicis' || $default['de_inicis_lpay_use'])
    set_session('ss_order_inicis_id', $od_id);

$order_action_url = $action_url = G5_HTTPS_SHOP_URL.'/orderformupdate.php';

// 비회원 주문일 때
$is_guest_order = false;
if($is_guest && (isset($_REQUEST['sw_guest']) && $_REQUEST['sw_guest'])) {
	$is_guest_order = true;
	$order_login_url = ($sw_direct) ? G5_SHOP_URL.'/orderform.php?sw_direct='.$sw_direct : G5_SHOP_URL.'/orderform.php';
	$order_login_url = G5_BBS_URL.'/login.php?url='.urlencode($order_login_url);
}

require_once(APMS_PGCHECK_PATH.'/settle_'.$default['de_pg_service'].'.inc.php');
require_once(G5_SHOP_PATH.'/settle_kakaopay.inc.php');

if($is_mobile_order) {

	if( is_inicis_simple_pay() ){   //이니시스 삼성페이 또는 Lpay 사용시
		require_once(G5_MSHOP_PATH.'/samsungpay/incSamsungpayCommon.php');
	}

	// 결제등록 요청시 사용할 입금마감일
	$tablet_size = "1.0"; // 화면 사이즈 조정 - 기기화면에 맞게 수정(갤럭시탭,아이패드 - 1.85, 스마트폰 - 1.0)

	// 개인결제번호제거
	set_session('ss_personalpay_id', '');
	set_session('ss_personalpay_hash', '');
}

// 상품처리 ----------------------
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
				b.pt_it,
				b.ca_id,
				b.ca_id2,
				b.ca_id3,
				b.it_notax,
				b.pt_point,
				b.pt_msg1,
				b.pt_msg2,
				b.pt_msg3
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

$no_use_point = 0; // 포인트 사용제한

$item = array();
$arr_it_orderform = array();

for ($i=0; $row=sql_fetch_array($result); $i++) {

	// APMS : 비회원은 컨텐츠상품 구매않되도록 처리
	if($is_guest && $row['pt_it'] == "2") {
		alert("회원만 구매가능한 아이템이 포함되어 있습니다.\\n\\n회원이시라면 로그인 후 진행해 주십시오.");
	}
	
	// 합계금액 계산
	$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
					SUM(ct_point * ct_qty) as point,
					SUM(ct_qty) as qty
				from {$g5['g5_shop_cart_table']}
				where it_id = '{$row['it_id']}'
				  and od_id = '$s_cart_id' ";
	$sum = sql_fetch($sql);

	if (!$goods) {
		//$goods = addslashes($row[it_name]);
		//$goods = get_text($row[it_name]);
		$goods = preg_replace("/\?|\'|\"|\||\,|\&|\;/", "", $row['it_name']);
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

	$it_name = stripslashes($row['it_name']);
	$it_options = print_item_options($row['it_id'], $s_cart_id, $row['pt_msg1'], $row['pt_msg2'], $row['pt_msg3']);

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
	$cp_button = false;
	if($is_member) {
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
			$cp_button = true;
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

	// 배열화
	$item[$i] = $row;
	$item[$i]['hidden_it_id'] = $row['it_id'];
	$item[$i]['hidden_it_name'] = get_text($row['it_name']);
	$item[$i]['hidden_sell_price'] = $sell_price;
	$item[$i]['hidden_cp_id'] = '';
	$item[$i]['hidden_cp_price'] = 0;
	$item[$i]['hidden_it_notax'] = $row['it_notax'];
	$item[$i]['it_name'] = $it_name;
	$item[$i]['it_options'] = $it_options;
	$item[$i]['pt_it'] = apms_pt_it($row['pt_it'],1);
	$item[$i]['qty'] = number_format($sum['qty']);
	$item[$i]['ct_price'] = number_format($row['ct_price']);
	$item[$i]['is_coupon'] = $cp_button;
	$item[$i]['total_price'] = number_format($sell_price);
	$item[$i]['point'] = number_format($point);
	$item[$i]['ct_send_cost'] = $ct_send_cost;

	if(!in_array($row['pt_it'], $g5['apms_automation'])) {
		$arr_it_orderform[] = $row['it_id'];
	}

	// 결제 포인트 제한 체크.
	if($row['pt_point']) {
		$no_use_point++;
	}

	$tot_point      += $point;
	$tot_sell_price += $sell_price;
} // for 끝

if ($i == 0) {
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

// 자동처리 주문서인지 체크
$is_orderform = false;
if(is_array($arr_it_orderform) && !empty($arr_it_orderform)) {
	$is_orderform = true;
}

// 상품처리 끝 ----------------------
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

$skin_row = array();
$skin_row = apms_rows('order_'.MOBILE_.'skin, order_'.MOBILE_.'set');
$skin_name = $skin_row['order_'.MOBILE_.'skin'];
$order_skin_path = G5_SKIN_PATH.'/apms/order/'.$skin_name;
$order_skin_url = G5_SKIN_URL.'/apms/order/'.$skin_name;

// 스킨 체크
list($order_skin_path, $order_skin_url) = apms_skin_thema('shop/order', $order_skin_path, $order_skin_url); 

// 스킨설정
$wset = array();
if($skin_row['order_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['order_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

// 설정값 불러오기
$is_orderform_sub = false;
@include_once($order_skin_path.'/config.skin.php');

if($is_orderform_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $order_skin_path;
$skin_url = $order_skin_url;

// 셋업
$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=order&amp;name='.urlencode($skin_name).'&amp;ts='.urlencode(THEMA);
}

if ($default['de_hope_date_use']) {
    include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
}

// 결제대행사별 코드 include (스크립트 등)
if($is_mobile_order) {
	echo '<div id="sod_approval_frm">'."\n";

	ob_start();
	include_once($skin_path.'/orderform.item.skin.php');
	$content = ob_get_contents();
	ob_end_clean();

	echo '</div>'."\n";

	require_once(G5_MSHOP_PATH.'/'.$default['de_pg_service'].'/orderform.1.php');

	if( is_inicis_simple_pay() ){   //이니시스 삼성페이 또는 lpay 사용시
		require_once(G5_MSHOP_PATH.'/samsungpay/orderform.1.php');
	}

	if($is_kakaopay_use) {
		require_once(G5_SHOP_PATH.'/kakaopay/orderform.1.php');
	}

} else {
	require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.1.php');

	if($is_kakaopay_use) {
		require_once(G5_SHOP_PATH.'/kakaopay/orderform.1.php');
	}
}

// 헤드 스킨
include_once($skin_path.'/orderform.head.skin.php');

// 상품 스킨
if(!$is_mobile_order) include_once($skin_path.'/orderform.item.skin.php');

?>
	<input type="hidden" name="od_price"    value="<?php echo $tot_sell_price; ?>">
	<input type="hidden" name="org_od_price"    value="<?php echo $tot_sell_price; ?>">
	<input type="hidden" name="od_send_cost" value="<?php echo $send_cost; ?>">
	<input type="hidden" name="od_send_cost2" value="0">
	<input type="hidden" name="item_coupon" value="0">
	<input type="hidden" name="od_coupon" value="0">
	<input type="hidden" name="od_send_coupon" value="0">

<?php
	if($is_mobile_order) {
		echo $content; //모바일 상품스킨
	} else {
		// 결제대행사별 코드 include (결제대행사 정보 필드)
		require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');

		if($is_kakaopay_use) {
			require_once(G5_SHOP_PATH.'/kakaopay/orderform.2.php');
		}
	}

	//주문서 사용할 때
	$addr_sel = array();
	$addr_default = '';
	if($is_orderform) {
		$orderer_zip_href =	G5_BBS_URL.'/zip.php?frm_name=forderform&amp;frm_zip1=od_zip1&amp;frm_zip2=od_zip2&amp;frm_addr1=od_addr1&amp;frm_addr2=od_addr2&amp;frm_addr3=od_addr3&amp;frm_jibeon=od_addr_jibeon';
		$taker_zip_href = G5_BBS_URL.'/zip.php?frm_name=forderform&amp;frm_zip1=od_b_zip1&amp;frm_zip2=od_b_zip2&amp;frm_addr1=od_b_addr1&amp;frm_addr2=od_b_addr2&amp;frm_addr3=od_b_addr3&amp;frm_jibeon=od_b_addr_jibeon';

		if($is_member) {

			// 배송지 이력
			$sep = chr(30);

			// 기본배송지
			$sql = " select *
						from {$g5['g5_shop_order_address_table']}
						where mb_id = '{$member['mb_id']}'
						  and ad_default = '1' ";
			$row = sql_fetch($sql);
			if($row['ad_id']) {
				$addr_default = $row['ad_name'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip1'].$sep.$row['ad_zip2'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_addr3'].$sep.$row['ad_jibeon'].$sep.$row['ad_subject'];
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
				$addr_sel[$i]['addr'] = $row['ad_name'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip1'].$sep.$row['ad_zip2'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_addr3'].$sep.$row['ad_jibeon'].$sep.$row['ad_subject'];
				$addr_sel[$i]['namme'] = ($row['ad_subject']) ? $row['ad_subject'] : $row['ad_name'];
			}
		} 
	}

	// 주문서 스킨
	include_once($skin_path.'/orderform.orderer.skin.php');

	// 쿠폰사용
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

	// 결제방법
	$multi_settle == 0;
	$escrow_title = ($default['de_escrow_use']) ? '에스크로 ' : '';

	// 카카오페이
	$is_kakaopay = false;
	if($is_kakaopay_use) {
		$multi_settle++;
        $is_kakaopay = true;
	}

	// 무통장입금 사용
	$is_mu = false;
	if ($default['de_bank_use']) {
		$multi_settle++;
		$is_mu = true;
	}

	// 가상계좌 사용
	$is_vbank = false;
	if ($default['de_vbank_use']) {
		$multi_settle++;
		$is_vbank = true;
	}

	// 계좌이체 사용
	$is_iche = false;
	if ($default['de_iche_use']) {
		$multi_settle++;
		$is_iche = true;
	}

	// 휴대폰 사용
	$is_hp = false;
	if ($default['de_hp_use']) {
		$multi_settle++;
		$is_hp = true;
	}

	// 신용카드 사용
	$is_card = false;
	if ($default['de_card_use']) {
		$multi_settle++;
		$is_card = true;
	}

	// PG 간편결제
	$is_easy_pay = false;
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
		$is_easy_pay = true;
	}

	// 이니시스 삼성페이
	$is_samsung_pay = false;
	if($is_mobile_order && $default['de_samsung_pay_use']) {
		$multi_settle++;
		$is_samsung_pay = true;
	}

	//이니시스 Lpay
	$is_inicis_lpay = false;
	if($is_mobile_order && $default['de_inicis_lpay_use']) {
		$multi_settle++;
		$is_inicis_lpay = true;
	}

	$temp_point = 0;
	$is_point = false;
	if (!$no_use_point && $is_member && $config['cf_use_point']) { // 회원이면서 포인트사용이면

		// 포인트 결제 사용 포인트보다 회원의 포인트가 크다면
		if ($member['mb_point'] >= $default['de_settle_min_point']) {
			$temp_point = (int)$default['de_settle_max_point'];

			if($temp_point > (int)$tot_sell_price)
				$temp_point = (int)$tot_sell_price;

			if($temp_point > (int)$member['mb_point'])
				$temp_point = (int)$member['mb_point'];

			$point_unit = (int)$default['de_settle_point_unit'];
			$temp_point = (int)((int)($temp_point / $point_unit) * $point_unit);

			$is_point = true;
		}
	}

	// 포인트 사용
	$is_po = false;
	if($is_point && $default['as_point']) {
		$multi_settle++;
		$is_po = true;
	}

	$bank_account = '';
	if ($default['de_bank_use']) {
		// 은행계좌를 배열로 만든후
		$str = explode("\n", trim($default['de_bank_account']));
		for ($i=0; $i<count($str); $i++) {
			//$str[$i] = str_replace("\r", "", $str[$i]);
			$str[$i] = trim($str[$i]);
			$bank_account .= '<option value="'.$str[$i].'">'.$str[$i].'</option>'.PHP_EOL;
		}
	}

	$is_none = false;
	if ($multi_settle == 0) {
		$is_none = true;
	}

	// 결제정보 스킨
	include_once($skin_path.'/orderform.payment.skin.php');

	// 결제대행사별 코드 include (주문버튼)
	if($is_mobile_order) {
	    require_once(G5_MSHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');

	    if( is_inicis_simple_pay() ){   //삼성페이 또는 L.pay 사용시
			require_once(G5_MSHOP_PATH.'/samsungpay/orderform.2.php');
		}

		if($is_kakaopay_use) {
			require_once(G5_SHOP_PATH.'/kakaopay/orderform.2.php');
		}

		echo '<div id="show_progress" style="display:none;">'.PHP_EOL;
		echo '<img src="'.G5_MOBILE_URL.'/shop/img/loading.gif" alt="">'.PHP_EOL;
		echo '<span>주문완료 중입니다. 잠시만 기다려 주십시오.</span>'.PHP_EOL;
		echo '</div>'.PHP_EOL;

		if($is_kakaopay_use) {
			require_once(G5_SHOP_PATH.'/kakaopay/orderform.3.php');
		}

	} else {
		require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.3.php');

		if($is_kakaopay_use) {
			require_once(G5_SHOP_PATH.'/kakaopay/orderform.3.php');
		}
	}

	$escrow_info = '';
	if ($default['de_escrow_use']) {
		// 결제대행사별 코드 include (에스크로 안내)
		ob_start();
		if($is_mobile_order) {
			include_once(G5_MSHOP_PATH.'/'.$default['de_pg_service'].'/orderform.3.php');

		    if( is_inicis_simple_pay() ){   //삼성페이 또는 L.pay 사용시
				require_once(G5_MSHOP_PATH.'/samsungpay/orderform.3.php');
			}

		} else {
			include_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.4.php');
		}
		$escrow_info = ob_get_contents();
		ob_end_clean();
	}

	// 테일 스킨
	include_once($skin_path.'/orderform.tail.skin.php');

	if($is_mobile_order && $default['de_samsung_pay_use'] ){   //삼성페이 사용시
		require_once(G5_MSHOP_PATH.'/samsungpay/order.script.php');
	}
?>
<script>
<?php if($is_mobile_order) { ?>
	$(function() {
		$("#od_settle_bank").on("click", function() {
			$("[name=od_deposit_name]").val( $("[name=od_name]").val() );
			$("#settle_bank").show();
			<?php if($is_point) { ?>
			$("#sod_frm_pt").show();
			<?php } ?>
			$("#show_req_btn").css("display", "none");
			$("#show_pay_btn").css("display", "inline");
		});

		$("#od_settle_point").on("click", function() {
			$("#settle_bank").hide();
			$("#sod_frm_pt").hide();
			$("#show_req_btn").css("display", "none");
			$("#show_pay_btn").css("display", "inline");
		});

		$("#od_settle_iche,#od_settle_card,#od_settle_vbank,#od_settle_hp,#od_settle_easy_pay,#od_settle_kakaopay,#od_settle_samsungpay").bind("click", function() {
			$("#settle_bank").hide();
			<?php if($is_point) { ?>
			$("#sod_frm_pt").show();
			<?php } ?>
			$("#show_req_btn").css("display", "inline");
			$("#show_pay_btn").css("display", "none");
		});
	});

	/* 결제방법에 따른 처리 후 결제등록요청 실행 */
	var settle_method = "";
	var temp_point = 0;

	function pay_approval()
	{
		// 재고체크
		var stock_msg = order_stock_check();
		if(stock_msg != "") {
			alert(stock_msg);
			return false;
		}

		var f = document.sm_form;
		var pf = document.forderform;

		// 필드체크
		if(!orderfield_check(pf))
			return false;

		// 금액체크
		if(!payment_check(pf))
			return false;

		// pg 결제 금액에서 포인트 금액 차감
		if(settle_method != "무통장" && settle_method != "포인트") {
			var od_price = parseInt(pf.od_price.value);
			var send_cost = parseInt(pf.od_send_cost.value);
			var send_cost2 = parseInt(pf.od_send_cost2.value);
			var send_coupon = parseInt(pf.od_send_coupon.value);
			f.good_mny.value = od_price + send_cost + send_cost2 - send_coupon - temp_point;
		}

		// 카카오페이 지불
		if(settle_method == "KAKAOPAY") {
			<?php if($default['de_tax_flag_use']) { ?>
			pf.SupplyAmt.value = parseInt(pf.comm_tax_mny.value) + parseInt(pf.comm_free_mny.value);
			pf.GoodsVat.value  = parseInt(pf.comm_vat_mny.value);
			<?php } ?>
			pf.good_mny.value = f.good_mny.value;
			getTxnId(pf);
			return false;
		}

		var form_order_method = '';

	    if( settle_method == "삼성페이" || settle_method == "lpay" ){
			form_order_method = 'samsungpay';
		}

		if( jQuery(pf).triggerHandler("form_sumbit_order_"+form_order_method) !== false ) {
			<?php if($default['de_pg_service'] == 'kcp') { ?>
			f.buyr_name.value = pf.od_name.value;
			f.buyr_mail.value = pf.od_email.value;
			f.buyr_tel1.value = pf.od_tel.value;
			f.buyr_tel2.value = pf.od_hp.value;
			f.rcvr_name.value = pf.od_b_name.value;
			f.rcvr_tel1.value = pf.od_b_tel.value;
			f.rcvr_tel2.value = pf.od_b_hp.value;
			f.rcvr_mail.value = pf.od_email.value;
			f.rcvr_zipx.value = pf.od_b_zip.value;
			f.rcvr_add1.value = pf.od_b_addr1.value;
			f.rcvr_add2.value = pf.od_b_addr2.value;
			f.settle_method.value = settle_method;
			if(settle_method == "간편결제")
				f.payco_direct.value = "Y";
			else
				f.payco_direct.value = "";
			<?php } else if($default['de_pg_service'] == 'lg') { ?>
			var pay_method = "";
			var easy_pay = "";
			switch(settle_method) {
				case "계좌이체":
					pay_method = "SC0030";
					break;
				case "가상계좌":
					pay_method = "SC0040";
					break;
				case "휴대폰":
					pay_method = "SC0060";
					break;
				case "신용카드":
					pay_method = "SC0010";
					break;
				case "간편결제":
					easy_pay = "PAYNOW";
					break;
			}
			f.LGD_CUSTOM_FIRSTPAY.value = pay_method;
			f.LGD_BUYER.value = pf.od_name.value;
			f.LGD_BUYEREMAIL.value = pf.od_email.value;
			f.LGD_BUYERPHONE.value = pf.od_hp.value;
			f.LGD_AMOUNT.value = f.good_mny.value;
			f.LGD_EASYPAY_ONLY.value = easy_pay;
			<?php if($default['de_tax_flag_use']) { ?>
			f.LGD_TAXFREEAMOUNT.value = pf.comm_free_mny.value;
			<?php } ?>
			<?php } else if($default['de_pg_service'] == 'inicis') { ?>
			var paymethod = "";
			var width = 330;
			var height = 480;
			var xpos = (screen.width - width) / 2;
			var ypos = (screen.width - height) / 2;
			var position = "top=" + ypos + ",left=" + xpos;
			var features = position + ", width=320, height=440";
			var p_reserved = f.DEF_RESERVED.value;
			f.P_RESERVED.value = p_reserved;
			switch(settle_method) {
				case "계좌이체":
					paymethod = "bank";
					break;
				case "가상계좌":
					paymethod = "vbank";
					break;
				case "휴대폰":
					paymethod = "mobile";
					break;
				case "신용카드":
					paymethod = "wcard";
					f.P_RESERVED.value = f.P_RESERVED.value.replace("&useescrow=Y", "");
					break;
				case "간편결제":
					paymethod = "wcard";
					f.P_RESERVED.value = p_reserved+"&d_kpay=Y&d_kpay_app=Y";
					break;
				case "삼성페이":
					paymethod = "wcard";
					f.P_RESERVED.value = f.P_RESERVED.value.replace("&useescrow=Y", "")+"&d_samsungpay=Y";
					//f.DEF_RESERVED.value = f.DEF_RESERVED.value.replace("&useescrow=Y", "");
					f.P_SKIP_TERMS.value = "Y"; //약관을 skip 해야 제대로 실행됨
					break;
				case "lpay":
					paymethod = "wcard";
					f.P_RESERVED.value = f.P_RESERVED.value.replace("&useescrow=Y", "")+"&d_lpay=Y";
					//f.DEF_RESERVED.value = f.DEF_RESERVED.value.replace("&useescrow=Y", "");
					f.P_SKIP_TERMS.value = "Y"; //약관을 skip 해야 제대로 실행됨
					break;
			}
			f.P_AMT.value = f.good_mny.value;
			f.P_UNAME.value = pf.od_name.value;
			f.P_MOBILE.value = pf.od_hp.value;
			f.P_EMAIL.value = pf.od_email.value;
			<?php if($default['de_tax_flag_use']) { ?>
			f.P_TAX.value = pf.comm_vat_mny.value;
			f.P_TAXFREE = pf.comm_free_mny.value;
			<?php } ?>
			f.P_RETURN_URL.value = "<?php echo $return_url.$od_id; ?>";
			f.action = "https://mobile.inicis.com/smart/" + paymethod + "/";
			<?php } ?>

			// 주문 정보 임시저장
			var order_data = $(pf).serialize();
			var save_result = "";
			$.ajax({
				type: "POST",
				data: order_data,
				url: g5_url+"/shop/ajax.orderdatasave.php",
				cache: false,
				async: false,
				success: function(data) {
					save_result = data;
				}
			});

			if(save_result) {
				alert(save_result);
				return false;
			}

			f.submit();
		}

		return false;
	}

	function forderform_check()
	{
		var f = document.forderform;

		// 필드체크
		if(!orderfield_check(f))
			return false;

		// 금액체크
		if(!payment_check(f))
			return false;

		if(settle_method != "포인트" && settle_method != "무통장" && f.res_cd.value != "0000") {
			alert("결제등록요청 후 주문해 주십시오.");
			return false;
		}

		document.getElementById("display_pay_button").style.display = "none";
		document.getElementById("show_progress").style.display = "block";

		setTimeout(function() {
			f.submit();
		}, 300);
	}

	// 주문폼 필드체크
	function orderfield_check(f)
	{
		errmsg = "";
		errfld = "";
		var deffld = "";

		<?php if($is_guest_order) { ?>
		if (!f.agree.checked) {
			alert("개인정보처리방침안내의 내용에 동의하셔야 주문하실 수 있습니다.");
			f.agree.focus();
			return false;
		}
		<?php } ?>

		check_field(f.od_name, "주문하시는 분 이름을 입력하십시오.");
		check_field(f.od_tel, "주문하시는 분 전화번호를 입력하십시오.");
		<?php if($is_orderform) { ?>
		if (typeof(f.od_pwd) != 'undefined')
		{
			clear_field(f.od_pwd);
			if( (f.od_pwd.value.length<3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/)!=-1) )
				error_field(f.od_pwd, "회원이 아니신 경우 주문서 조회시 필요한 비밀번호를 3자리 이상 입력해 주십시오.");
		}
		check_field(f.od_addr1, "주소검색을 이용하여 주문하시는 분 주소를 입력하십시오.");
		//check_field(f.od_addr2, " 주문하시는 분의 상세주소를 입력하십시오.");
		check_field(f.od_zip, "주문하시는 분의 우편번호를 입력하십시오.");

		clear_field(f.od_email);
		if(f.od_email.value=='' || f.od_email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
			error_field(f.od_email, "E-mail을 바르게 입력해 주십시오.");

		if (typeof(f.od_hope_date) != "undefined")
		{
			clear_field(f.od_hope_date);
			if (!f.od_hope_date.value)
				error_field(f.od_hope_date, "희망배송일을 선택하여 주십시오.");
		}

		check_field(f.od_b_name, "받으시는 분 이름을 입력하십시오.");
		check_field(f.od_b_tel, "받으시는 분 전화번호를 입력하십시오.");
		check_field(f.od_b_addr1, "주소검색을 이용하여 받으시는 분 주소를 입력하십시오.");
		//check_field(f.od_b_addr2, "받으시는 분의 상세주소를 입력하십시오.");
		check_field(f.od_b_zip, "받으시는 분의 우편번호를 입력하십시오.");

		<?php } ?>
		var od_settle_bank = document.getElementById("od_settle_bank");
		if (od_settle_bank) {
			if (od_settle_bank.checked) {
				check_field(f.od_bank_account, "계좌번호를 선택하세요.");
				check_field(f.od_deposit_name, "입금자명을 입력하세요.");
			}
		}

		// 배송비를 받지 않거나 더 받는 경우 아래식에 + 또는 - 로 대입
		f.od_send_cost.value = parseInt(f.od_send_cost.value);

		if (errmsg)
		{
			alert(errmsg);
			errfld.focus();
			return false;
		}

		var settle_case = document.getElementsByName("od_settle_case");
		var settle_check = false;
		for (i=0; i<settle_case.length; i++)
		{
			if (settle_case[i].checked)
			{
				settle_check = true;
				settle_method = settle_case[i].value;
				break;
			}
		}
		if (!settle_check)
		{
			alert("결제방식을 선택하십시오.");
			return false;
		}

		return true;
	}

	// 결제체크
	function payment_check(f)
	{
		var max_point = 0;
		var od_price = parseInt(f.od_price.value);
		var send_cost = parseInt(f.od_send_cost.value);
		var send_cost2 = parseInt(f.od_send_cost2.value);
		var send_coupon = parseInt(f.od_send_coupon.value);
		temp_point = 0;

		if (typeof(f.max_temp_point) != "undefined")
			var max_point  = parseInt(f.max_temp_point.value);

		if (typeof(f.od_temp_point) != "undefined") {
			if (f.od_temp_point.value)
			{
				var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
				temp_point = parseInt(f.od_temp_point.value);

				if (temp_point > <?php echo (int)$member['mb_point']; ?>) {
					alert("회원님의 포인트보다 많이 결제할 수 없습니다.");
					f.od_temp_point.select();
					return false;
				}

				if (document.getElementById("od_settle_point") && document.getElementById("od_settle_point").checked) {
					;
				} else {
					if (temp_point < 0) {
						alert("포인트를 0 이상 입력하세요.");
						f.od_temp_point.select();
						return false;
					}

					if (temp_point > od_price) {
						alert("상품 주문금액(배송비 제외) 보다 많이 포인트결제할 수 없습니다.");
						f.od_temp_point.select();
						return false;
					}

					if (temp_point > max_point) {
						alert(max_point + "점 이상 결제할 수 없습니다.");
						f.od_temp_point.select();
						return false;
					}

					if (parseInt(parseInt(temp_point / point_unit) * point_unit) != temp_point) {
						alert("포인트를 "+String(point_unit)+"점 단위로 입력하세요.");
						f.od_temp_point.select();
						return false;
					}
				}
			}
		}

		if (document.getElementById("od_settle_point")) {
			if (document.getElementById("od_settle_point").checked) {
				var tmp_point = parseInt(f.od_temp_point.value);

				if (tmp_point > 0) {
					;
				} else {
					alert("포인트를 입력해 주세요.");
					f.od_temp_point.select();
					return false;
				}

				var tot_point = od_price + send_cost + send_cost2 - send_coupon;

				if (tot_point != tmp_point) {
					alert("결제하실 금액과 포인트가 일치하지 않습니다.");
					f.od_temp_point.select();
					return false;
				}
			}
		}

		var tot_price = od_price + send_cost + send_cost2 - send_coupon - temp_point;

		if (document.getElementById("od_settle_iche")) {
			if (document.getElementById("od_settle_iche").checked) {
				if (tot_price < 150) {
					alert("계좌이체는 150원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("od_settle_card")) {
			if (document.getElementById("od_settle_card").checked) {
				if (tot_price < 1000) {
					alert("신용카드는 1000원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("od_settle_hp")) {
			if (document.getElementById("od_settle_hp").checked) {
				if (tot_price < 350) {
					alert("휴대폰은 350원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		<?php if($default['de_tax_flag_use']) { ?>
		calculate_tax();
		<?php } ?>

		return true;
	}
<?php } else { // PC결제 ?>

	var form_action_url = "<?php echo $order_action_url; ?>";

	$(function() {
		$("#od_settle_bank").on("click", function() {
			$("[name=od_deposit_name]").val( $("[name=od_name]").val() );
			$("#settle_bank").show();
			<?php if($is_point) { ?>
			$("#sod_frm_pt").show();
			<?php } ?>
		});

		$("#od_settle_point").on("click", function() {
			$("#settle_bank").hide();
			$("#sod_frm_pt").hide();
		});

		$("#od_settle_iche,#od_settle_card,#od_settle_vbank,#od_settle_hp,#od_settle_easy_pay,#od_settle_kakaopay").bind("click", function() {
			$("#settle_bank").hide();
			<?php if($is_point) { ?>
			$("#sod_frm_pt").show();
			<?php } ?>
		});
	});

	function forderform_check(f) {

		<?php if($is_guest_order) { ?>
		if (!f.agree.checked) {
			alert("개인정보처리방침안내의 내용에 동의하셔야 주문하실 수 있습니다.");
			f.agree.focus();
			return false;
		}
		<?php } ?>

		// 재고체크
		var stock_msg = order_stock_check();
		if(stock_msg != "") {
			alert(stock_msg);
			return false;
		}
		
		errmsg = "";
		errfld = "";
		var deffld = "";

		check_field(f.od_name, "주문하시는 분 이름을 입력하십시오.");
		check_field(f.od_tel, "주문하시는 분 전화번호를 입력하십시오.");
		<?php if($is_orderform) { ?>
			if (typeof(f.od_pwd) != 'undefined')
			{
				clear_field(f.od_pwd);
				if( (f.od_pwd.value.length<3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/)!=-1) )
					error_field(f.od_pwd, "회원이 아니신 경우 주문서 조회시 필요한 비밀번호를 3자리 이상 입력해 주십시오.");
			}
			check_field(f.od_addr1, "주소검색을 이용하여 주문하시는 분 주소를 입력하십시오.");
			//check_field(f.od_addr2, " 주문하시는 분의 상세주소를 입력하십시오.");
			check_field(f.od_zip, "주문하시는 분의 우편번호를 입력하십시요.");

			clear_field(f.od_email);
			if(f.od_email.value=='' || f.od_email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
				error_field(f.od_email, "E-mail을 바르게 입력해 주십시오.");

			if (typeof(f.od_hope_date) != "undefined")
			{
				clear_field(f.od_hope_date);
				if (!f.od_hope_date.value)
					error_field(f.od_hope_date, "희망배송일을 선택하여 주십시오.");
			}

			check_field(f.od_b_name, "받으시는 분 이름을 입력하십시오.");
			check_field(f.od_b_tel, "받으시는 분 전화번호를 입력하십시오.");
			check_field(f.od_b_addr1, "주소검색을 이용하여 받으시는 분 주소를 입력하십시오.");
			//check_field(f.od_b_addr2, "받으시는 분의 상세주소를 입력하십시오.");
			check_field(f.od_b_zip, "받으시는 분의 우편번호를 입력하십시요.");
		<?php } ?>
		var od_settle_bank = document.getElementById("od_settle_bank");
		if (od_settle_bank) {
			if (od_settle_bank.checked) {
				check_field(f.od_bank_account, "계좌번호를 선택하세요.");
				check_field(f.od_deposit_name, "입금자명을 입력하세요.");
			}
		}

		// 배송비를 받지 않거나 더 받는 경우 아래식에 + 또는 - 로 대입
		f.od_send_cost.value = parseInt(f.od_send_cost.value);

		if (errmsg) {
			alert(errmsg);
			errfld.focus();
			return false;
		}

		var settle_case = document.getElementsByName("od_settle_case");
		var settle_check = false;
		var settle_method = "";
		for (i=0; i<settle_case.length; i++) {
			if (settle_case[i].checked) {
				settle_check = true;
				settle_method = settle_case[i].value;
				break;
			}
		}
		if (!settle_check) {
			alert("결제방식을 선택하십시오.");
			return false;
		}

		var od_price = parseInt(f.od_price.value);
		var send_cost = parseInt(f.od_send_cost.value);
		var send_cost2 = parseInt(f.od_send_cost2.value);
		var send_coupon = parseInt(f.od_send_coupon.value);

		var max_point = 0;
		if (typeof(f.max_temp_point) != "undefined")
			max_point  = parseInt(f.max_temp_point.value);

		var temp_point = 0;
		if (typeof(f.od_temp_point) != "undefined") {
			if (f.od_temp_point.value) {
				var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
				temp_point = parseInt(f.od_temp_point.value);

				if (temp_point > <?php echo (int)$member['mb_point']; ?>) {
					alert("회원님의 포인트보다 많이 결제할 수 없습니다.");
					f.od_temp_point.select();
					return false;
				}

				if (settle_method == "포인트") {
					;
				} else {
					if (temp_point < 0) {
						alert("포인트를 0 이상 입력하세요.");
						f.od_temp_point.select();
						return false;
					}

					if (temp_point > od_price) {
						alert("상품 주문금액(배송비 제외) 보다 많이 포인트결제할 수 없습니다.");
						f.od_temp_point.select();
						return false;
					}

					if (temp_point > max_point) {
						alert(max_point + "점 이상 결제할 수 없습니다.");
						f.od_temp_point.select();
						return false;
					}

					if (parseInt(parseInt(temp_point / point_unit) * point_unit) != temp_point) {
						alert("포인트를 "+String(point_unit)+"점 단위로 입력하세요.");
						f.od_temp_point.select();
						return false;
					}
				}

				// pg 결제 금액에서 포인트 금액 차감
				if(settle_method != "무통장" && settle_method != "포인트") {
					f.good_mny.value = od_price + send_cost + send_cost2 - send_coupon - temp_point;
				}
			}
		}

		if (document.getElementById("od_settle_point")) {
			if (document.getElementById("od_settle_point").checked) {
				var tmp_point = parseInt(f.od_temp_point.value);

				if (tmp_point > 0) {
					;
				} else {
					alert("포인트를 입력해 주세요.");
					f.od_temp_point.select();
					return false;
				}

				var tot_point = od_price + send_cost + send_cost2 - send_coupon;

				if (tot_point != tmp_point) {
					alert("결제하실 금액과 포인트가 일치하지 않습니다.");
					f.od_temp_point.select();
					return false;
				}
			}

		}

		var tot_price = od_price + send_cost + send_cost2 - send_coupon - temp_point;

		if (document.getElementById("od_settle_iche")) {
			if (document.getElementById("od_settle_iche").checked) {
				if (tot_price < 150) {
					alert("계좌이체는 150원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("od_settle_card")) {
			if (document.getElementById("od_settle_card").checked) {
				if (tot_price < 1000) {
					alert("신용카드는 1000원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		if (document.getElementById("od_settle_hp")) {
			if (document.getElementById("od_settle_hp").checked) {
				if (tot_price < 350) {
					alert("휴대폰은 350원 이상 결제가 가능합니다.");
					return false;
				}
			}
		}

		<?php if($default['de_tax_flag_use']) { ?>
		calculate_tax();
		<?php } ?>

		<?php if($default['de_pg_service'] == 'inicis') { ?>
		if( f.action != form_action_url ){
			f.action = form_action_url;
			f.removeAttribute("target");
			f.removeAttribute("accept-charset");
		}
		<?php } ?>

		// 카카오페이 지불
		if(settle_method == "KAKAOPAY") {
			<?php if($default['de_tax_flag_use']) { ?>
			f.SupplyAmt.value = parseInt(f.comm_tax_mny.value) + parseInt(f.comm_free_mny.value);
			f.GoodsVat.value  = parseInt(f.comm_vat_mny.value);
			<?php } ?>
			getTxnId(f);
			return false;
		}

		// pay_method 설정
		<?php if($default['de_pg_service'] == 'kcp') { ?>
		f.site_cd.value = f.def_site_cd.value;
		f.payco_direct.value = "";
		switch(settle_method) {
			case "계좌이체":
				f.pay_method.value = "010000000000";
				break;
			case "가상계좌":
				f.pay_method.value = "001000000000";
				break;
			case "휴대폰":
				f.pay_method.value = "000010000000";
				break;
			case "신용카드":
				f.pay_method.value = "100000000000";
				break;
			case "간편결제":
				<?php if($default['de_card_test']) { ?>
				f.site_cd.value      = "S6729";
				<?php } ?>
				f.pay_method.value   = "100000000000";
				f.payco_direct.value = "Y";
				break;
			case "포인트":
				f.pay_method.value = "포인트";
				break;
			default:
				f.pay_method.value = "무통장";
				break;
		}
		<?php } else if($default['de_pg_service'] == 'lg') { ?>
		f.LGD_EASYPAY_ONLY.value = "";
		if(typeof f.LGD_CUSTOM_USABLEPAY === "undefined") {
			var input = document.createElement("input");
			input.setAttribute("type", "hidden");
			input.setAttribute("name", "LGD_CUSTOM_USABLEPAY");
			input.setAttribute("value", "");
			f.LGD_EASYPAY_ONLY.parentNode.insertBefore(input, f.LGD_EASYPAY_ONLY);
		}

		switch(settle_method) {
			case "계좌이체":
				f.LGD_CUSTOM_FIRSTPAY.value = "SC0030";
				f.LGD_CUSTOM_USABLEPAY.value = "SC0030";
				break;
			case "가상계좌":
				f.LGD_CUSTOM_FIRSTPAY.value = "SC0040";
				f.LGD_CUSTOM_USABLEPAY.value = "SC0040";
				break;
			case "휴대폰":
				f.LGD_CUSTOM_FIRSTPAY.value = "SC0060";
				f.LGD_CUSTOM_USABLEPAY.value = "SC0060";
				break;
			case "신용카드":
				f.LGD_CUSTOM_FIRSTPAY.value = "SC0010";
				f.LGD_CUSTOM_USABLEPAY.value = "SC0010";
				break;
			case "간편결제":
				var elm = f.LGD_CUSTOM_USABLEPAY;
				if(elm.parentNode)
					elm.parentNode.removeChild(elm);
				f.LGD_EASYPAY_ONLY.value = "PAYNOW";
				break;
			case "포인트":
				f.LGD_CUSTOM_FIRSTPAY.value = "포인트";
				break;
			default:
				f.LGD_CUSTOM_FIRSTPAY.value = "무통장";
				break;
		}
		<?php }  else if($default['de_pg_service'] == 'inicis') { ?>
		switch(settle_method)
		{
			case "계좌이체":
				f.gopaymethod.value = "DirectBank";
				break;
			case "가상계좌":
				f.gopaymethod.value = "VBank";
				break;
			case "휴대폰":
				f.gopaymethod.value = "HPP";
				break;
			case "신용카드":
				f.gopaymethod.value = "Card";
	            f.acceptmethod.value = f.acceptmethod.value.replace(":useescrow", "");
				break;
			case "간편결제":
				f.gopaymethod.value = "Kpay";
				break;
			case "포인트":
				f.gopaymethod.value = "포인트";
				break;
			default:
				f.gopaymethod.value = "무통장";
				break;
		}
		<?php } ?>

		// 결제정보설정
		<?php if($default['de_pg_service'] == 'kcp') { ?>
		f.buyr_name.value = f.od_name.value;
		f.buyr_mail.value = f.od_email.value;
		f.buyr_tel1.value = f.od_tel.value;
		f.buyr_tel2.value = f.od_hp.value;
		f.rcvr_name.value = f.od_b_name.value;
		f.rcvr_tel1.value = f.od_b_tel.value;
		f.rcvr_tel2.value = f.od_b_hp.value;
		f.rcvr_mail.value = f.od_email.value;
		f.rcvr_zipx.value = f.od_b_zip.value;
		f.rcvr_add1.value = f.od_b_addr1.value;
		f.rcvr_add2.value = f.od_b_addr2.value;

		if(f.pay_method.value != "무통장" && f.pay_method.value != "포인트") {
	        jsf__pay( f );
		} else {
			f.submit();
		}
		<?php } ?>
		<?php if($default['de_pg_service'] == 'lg') { ?>
		f.LGD_BUYER.value = f.od_name.value;
		f.LGD_BUYEREMAIL.value = f.od_email.value;
		f.LGD_BUYERPHONE.value = f.od_hp.value;
		f.LGD_AMOUNT.value = f.good_mny.value;
		f.LGD_RECEIVER.value = f.od_b_name.value;
		f.LGD_RECEIVERPHONE.value = f.od_b_hp.value;
		<?php if($default['de_escrow_use']) { ?>
		f.LGD_ESCROW_ZIPCODE.value = f.od_b_zip.value;
		f.LGD_ESCROW_ADDRESS1.value = f.od_b_addr1.value;
		f.LGD_ESCROW_ADDRESS2.value = f.od_b_addr2.value;
		f.LGD_ESCROW_BUYERPHONE.value = f.od_hp.value;
		<?php } ?>
		<?php if($default['de_tax_flag_use']) { ?>
		f.LGD_TAXFREEAMOUNT.value = f.comm_free_mny.value;
		<?php } ?>

		if(f.LGD_CUSTOM_FIRSTPAY.value != "무통장" && f.LGD_CUSTOM_FIRSTPAY.value != "포인트") {
	        launchCrossPlatform(f);
		} else {
			f.submit();
		}
		<?php } ?>
		<?php if($default['de_pg_service'] == 'inicis') { ?>
		f.price.value       = f.good_mny.value;
		<?php if($default['de_tax_flag_use']) { ?>
		f.tax.value         = f.comm_vat_mny.value;
		f.taxfree.value     = f.comm_free_mny.value;
		<?php } ?>
		f.buyername.value   = f.od_name.value;
		f.buyeremail.value  = f.od_email.value;
		f.buyertel.value    = f.od_hp.value ? f.od_hp.value : f.od_tel.value;
		f.recvname.value    = f.od_b_name.value;
		f.recvtel.value     = f.od_b_hp.value ? f.od_b_hp.value : f.od_b_tel.value;
		f.recvpostnum.value = f.od_b_zip.value;
		f.recvaddr.value    = f.od_b_addr1.value + " " +f.od_b_addr2.value;

		if(f.gopaymethod.value != "무통장" && f.gopaymethod.value != "포인트") {
			// 주문정보 임시저장
			var order_data = $(f).serialize();
			var save_result = "";
			$.ajax({
				type: "POST",
				data: order_data,
				url: g5_url+"/shop/ajax.orderdatasave.php",
				cache: false,
				async: false,
				success: function(data) {
					save_result = data;
				}
			});

			if(save_result) {
				alert(save_result);
				return false;
			}

			if(!make_signature(f))
				return false;

			paybtn(f);

		} else {
	        f.submit();
		}
		<?php } ?>
	}
<?php } ?>

<?php if ($default['de_hope_date_use']) { ?>
$(function(){
	$("#od_hope_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", minDate: "+<?php echo (int)$default['de_hope_date_after']; ?>d;", maxDate: "+<?php echo (int)$default['de_hope_date_after'] + 6; ?>d;" });
});
<?php } ?>

<?php if($is_none && $default['as_point']) { ?>
$('#display_pay_button input').hide();
<?php } ?>
</script>

<?php
if($is_orderform_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>