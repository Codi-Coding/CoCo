<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/// * 아래로 이동 if (!defined('G5_USE_CONTENTS') || !G5_USE_CONTENTS) return;

//------------------------------------------------------------------------------
// 컨텐츠몰 상수 모음 시작
//------------------------------------------------------------------------------

define('G5_CONTENTS_DIR', 'contents');

define('G5_CONTENTS_PATH',  G5_PATH.'/'.G5_CONTENTS_DIR);
define('G5_CONTENTS_URL',   G5_URL.'/'.G5_CONTENTS_DIR);
define('G5_MCONTENTS_PATH', G5_MOBILE_PATH.'/'.G5_CONTENTS_DIR);
define('G5_MCONTENTS_URL',  G5_MOBILE_URL.'/'.G5_CONTENTS_DIR);

// 보안서버주소 설정
if (G5_HTTPS_DOMAIN) {
    define('G5_HTTPS_CONTENTS_URL',  G5_HTTPS_DOMAIN.'/'.G5_CONTENTS_DIR);
    define('G5_HTTPS_MCONTENTS_URL', G5_HTTPS_DOMAIN.'/'.G5_MOBILE_DIR.'/'.G5_CONTENTS_DIR);
} else {
    define('G5_HTTPS_CONTENTS_URL',  G5_CONTENTS_URL);
    define('G5_HTTPS_MCONTENTS_URL', G5_MCONTENTS_URL);
}

// 컨테츠 파일 저장 DIR
define('G5_CONTENTS_SAVE_DIR',    'contents');

// 상품등록시 기본 옵션 개수
define('G5_CONTENTS_OPTION_COUNT', 3);

// 컨텐츠허브 연동 URL
define('G5_CONTENTS_HUB_URL', 'http://sir.co.kr/chub/contents.php');

// 컨텐츠허브 분류
$sir_chub_category = array('10'=>'테마', '20'=>'빌더', '30'=>'스킨', '40'=>'플러그인', '50'=>'디자인소스', '60'=>'솔루션');

// 컨텐츠허브 연동 후 결과코드 출력
define('G5_CONTENTS_HUB_CODE_DISPLAY', false);

//------------------------------------------------------------------------------
// 컨텐츠몰 상수 모음 끝
//------------------------------------------------------------------------------

if (!defined('G5_USE_CONTENTS') || !G5_USE_CONTENTS) return;

//==============================================================================
// 컨텐츠몰 필수 실행코드 모음 시작
//==============================================================================

// 컨텐츠몰 설정값 배열변수
$setting = sql_fetch(" select * from {$g5['g5_contents_default_table']} ");

define('G5_MEDIAELEMENT_PATH',   G5_PLUGIN_PATH.'/mediaelement');
define('G5_MEDIAELEMENT_URL',    G5_PLUGIN_URL.'/mediaelement');

//==============================================================================
// 컨텐츠몰 필수 실행코드 모음 끝
//==============================================================================

include_once(G5_LIB_PATH.'/contents.lib.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 매출전표 url 설정
if($setting['de_card_test']) {
    define('G5_CM_BILL_RECEIPT_URL', 'https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=');
    define('G5_CM_CASH_RECEIPT_URL', 'https://testadmin8.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?term_id=PGNW');
} else {
    define('G5_CM_BILL_RECEIPT_URL', 'https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=');
    define('G5_CM_CASH_RECEIPT_URL', 'https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?term_id=PGNW');
}

// 아이코드 코인 최소금액 설정
// 코인 잔액이 설정 금액보다 작을 때는 주문시 SMS 발송 안함
define('G5_ICODE_COIN', 100);
?>
