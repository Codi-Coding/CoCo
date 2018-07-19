<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

///아래에서만 검사*** if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;

//------------------------------------------------------------------------------
// 쇼핑몰 상수 모음 시작
//------------------------------------------------------------------------------

define('G5_SHOP_DIR', 'shop');

/// g5 or multi language support
if(defined('ENABLE_MODULE_G5') && ENABLE_MODULE_G5 && file_exists(G5_PATH.'/module/g5/shop')) {
define('SHOP_NAME', 'module/g5/shop');
define('MSHOP_NAME', 'module/g5/mobile/shop');
} else if(defined('ENABLE_MODULE_ML') && ENABLE_MODULE_ML && file_exists(G5_PATH.'/module/ml/shop')) {
define('SHOP_NAME', 'module/ml/shop');
define('MSHOP_NAME', 'module/ml/mobile/shop');
} else {
define('SHOP_NAME', 'shop');
define('MSHOP_NAME', 'mobile/shop');
}

///define('G5_SHOP_PATH',  G5_PATH.'/'.G5_SHOP_DIR);
///define('G5_SHOP_URL',   G5_URL.'/'.G5_SHOP_DIR);
///define('G5_MSHOP_PATH', G5_MOBILE_PATH.'/'.G5_SHOP_DIR);
///define('G5_MSHOP_URL',  G5_MOBILE_URL.'/'.G5_SHOP_DIR);

define('G5_SHOP_PATH',  G5_PATH.'/'.SHOP_NAME);
define('G5_SHOP_URL',   G5_URL.'/'.SHOP_NAME);
define('G5_MSHOP_PATH', G5_PATH.'/'.MSHOP_NAME);
define('G5_MSHOP_URL',  G5_URL.'/'.MSHOP_NAME);

define('G5_SHOP_IMG_URL',  G5_SHOP_URL.'/'.G5_IMG_DIR);
define('G5_MSHOP_IMG_URL', G5_MSHOP_URL.'/'.G5_IMG_DIR);

// 보안서버주소 설정
if (G5_HTTPS_DOMAIN) {
    ///define('G5_HTTPS_SHOP_URL', G5_HTTPS_DOMAIN.'/'.G5_SHOP_DIR);
    ///define('G5_HTTPS_MSHOP_URL', G5_HTTPS_DOMAIN.'/'.G5_MOBILE_DIR.'/'.G5_SHOP_DIR);
    define('G5_HTTPS_SHOP_URL', G5_HTTPS_DOMAIN.'/'.SHOP_NAME);
    define('G5_HTTPS_MSHOP_URL', G5_HTTPS_DOMAIN.'/'.MSHOP_NAME);
} else {
    define('G5_HTTPS_SHOP_URL', G5_SHOP_URL);
    define('G5_HTTPS_MSHOP_URL', G5_MSHOP_URL);
}

//------------------------------------------------------------------------------
// 쇼핑몰 상수 모음 끝
//------------------------------------------------------------------------------

/// shop url
$g5['shop_url'] = G5_SHOP_URL;

if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return; ///***

//==============================================================================
// 쇼핑몰 필수 실행코드 모음 시작
//==============================================================================

$default = sql_fetch(" select * from {$g5['g5_shop_default_table']} ");

/*
배송업체에 데이터를 추가하는 경우 아래 형식으로 추가하세요.
.'(배송업체명^택배조회URL^연락처)'
*/
define('G5_DELIVERY_COMPANY',
     '(경동택배^http://www.kdexp.com/sub3_shipping.asp?stype=1&p_item=^080-873-2178)'
    .'(대신택배^http://home.daesinlogistics.co.kr/daesin/jsp/d_freight_chase/d_general_process2.jsp?billno1=^043-222-4582)'
    .'(동부택배^http://www.dongbups.com/delivery/delivery_search_view.jsp?item_no=^1588-8848)'
    .'(로젠택배^http://www.ilogen.com/iLOGEN.Web.New/TRACE/TraceView.aspx?gubun=slipno&slipno=^1588-9988)'
    .'(우체국^http://service.epost.go.kr/trace.RetrieveRegiPrclDeliv.postal?sid1=^1588-1300)'
    .'(이노지스택배^http://www.innogis.co.kr/tracking_view.asp?invoice=^1566-4082)'
    .'(한진택배^http://www.hanjin.co.kr/Delivery_html/inquiry/result_waybill.jsp?wbl_num=^1588-0011)'
    .'(롯데택배^https://www.lotteglogis.com/open/tracking?InvNo=^1588-2121)'
    .'(CJ대한통운^https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=^1588-1255)'
    .'(CVSnet편의점택배^http://was.cvsnet.co.kr/_ver2/board/ctod_status.jsp?invoice_no=^1577-1287)'
    .'(KG옐로우캡택배^http://www.yellowcap.co.kr/custom/inquiry_result.asp?invoice_no=^1588-0123)'
    .'(KGB택배^http://www.kgbls.co.kr/sub5/trace.asp?f_slipno=^1577-4577)'
    .'(KG로지스^http://www.kglogis.co.kr/contents/waybill.jsp?item_no=^1588-8848)'
    .'(건영택배^http://www.kunyoung.com/goods/goods_01.php?mulno=^031-460-2700)'
    .'(호남택배^http://www.honamlogis.co.kr/04estimate/songjang_list.php?c_search1=^031-376-6070)'
);

/// extend/templete.theme.shop.extend.php로 이동. 2018.04.12
/// include_once(G5_LIB_PATH.'/shop.lib.php');
/// include_once(G5_LIB_PATH.'/thumbnail.lib.php');

//==============================================================================
// 쇼핑몰 미수금 등의 주문정보
//==============================================================================
/*
$info = get_order_info($od_id);

$info['od_cart_price']      // 장바구니 주문상품 총금액
$info['od_send_cost']       // 배송비
$info['od_coupon']          // 주문할인 쿠폰금액
$info['od_send_coupon']     // 배송할인 쿠폰금액
$info['od_cart_coupon']     // 상품할인 쿠폰금액
$info['od_tax_mny']         // 과세 공급가액
$info['od_vat_mny']         // 부가세액
$info['od_free_mny']        // 비과세 공급가액
$info['od_cancel_price']    // 주문 취소상품 총금액
$info['od_misu']            // 미수금액
*/
//==============================================================================
// 쇼핑몰 미수금 등의 주문정보
//==============================================================================

// 매출전표 url 설정
if($default['de_card_test']) {
    define('G5_BILL_RECEIPT_URL', 'https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=');
    define('G5_CASH_RECEIPT_URL', 'https://testadmin8.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?term_id=PGNW');
} else {
    define('G5_BILL_RECEIPT_URL', 'https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=');
    define('G5_CASH_RECEIPT_URL', 'https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?term_id=PGNW');
}

// 상품상세 페이지에서 재고체크 실행 여부 선택
// 상품의 옵션이 많아 로딩 속도가 느린 경우 false 로 설정
define('G5_SOLDOUT_CHECK', true);

// 주문폼의 상품이 재고 차감에 포함되는 기준 시간설정
// 0 이면 재고 차감에 계속 포함됨
define('G5_CART_STOCK_LIMIT', 3);

// 아이코드 코인 최소금액 설정
// 코인 잔액이 설정 금액보다 작을 때는 주문시 SMS 발송 안함
define('G5_ICODE_COIN', 100);
?>
