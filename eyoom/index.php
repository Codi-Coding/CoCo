<?php
if (!defined('_GNUBOARD_')) exit;

// 메인주소를 쇼핑몰로 사용
if(isset($eyoom['use_shop_index']) && $eyoom['use_shop_index'] == 'y') {
	@include_once(EYOOM_CORE_PATH.'/shop/index.php');
	return;
}

// 메인에서 쇼핑몰 유형별 상품 출력
if(isset($eyoom['use_shop_itemtype']) && $eyoom['use_shop_itemtype'] == 'y') {
	// 유형별 상품정보 출력
	@include_once(EYOOM_SHOP_PATH.'/itemtype.php');
}

// 이윰 헤더 디자인 출력
@include_once(EYOOM_PATH.'/head.php');

// 회원의 지정한 페이지 홈으로 보여주기
$eb->print_page($eyoomer['main_index']);

// 이윰 테일 디자인 출력
@include_once(EYOOM_PATH.'/tail.php');