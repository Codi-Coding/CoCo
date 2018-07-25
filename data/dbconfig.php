<?php
if (!defined('_GNUBOARD_')) exit;
define('G5_MYSQL_HOST', '211.253.229.69');
define('G5_MYSQL_USER', 'root');
define('G5_MYSQL_PASSWORD', 'lab1138');
define('G5_MYSQL_DB', 'shop');
define('G5_MYSQL_SET_MODE', true);

define('G5_TABLE_PREFIX', 'g5_');

$g5['write_prefix'] = G5_TABLE_PREFIX.'write_'; // 게시판 테이블명 접두사

$g5['auth_table'] = G5_TABLE_PREFIX.'auth'; // 관리권한 설정 테이블
$g5['config_table'] = G5_TABLE_PREFIX.'config'; // 기본환경 설정 테이블
$g5['group_table'] = G5_TABLE_PREFIX.'group'; // 게시판 그룹 테이블
$g5['group_member_table'] = G5_TABLE_PREFIX.'group_member'; // 게시판 그룹+회원 테이블
$g5['board_table'] = G5_TABLE_PREFIX.'board'; // 게시판 설정 테이블
$g5['board_file_table'] = G5_TABLE_PREFIX.'board_file'; // 게시판 첨부파일 테이블
$g5['board_good_table'] = G5_TABLE_PREFIX.'board_good'; // 게시물 추천,비추천 테이블
$g5['board_new_table'] = G5_TABLE_PREFIX.'board_new'; // 게시판 새글 테이블
$g5['login_table'] = G5_TABLE_PREFIX.'login'; // 로그인 테이블 (접속자수)
$g5['mail_table'] = G5_TABLE_PREFIX.'mail'; // 회원메일 테이블
$g5['member_table'] = G5_TABLE_PREFIX.'member'; // 회원 테이블
$g5['memo_table'] = G5_TABLE_PREFIX.'memo'; // 메모 테이블
$g5['poll_table'] = G5_TABLE_PREFIX.'poll'; // 투표 테이블
$g5['poll_etc_table'] = G5_TABLE_PREFIX.'poll_etc'; // 투표 기타의견 테이블
$g5['point_table'] = G5_TABLE_PREFIX.'point'; // 포인트 테이블
$g5['popular_table'] = G5_TABLE_PREFIX.'popular'; // 인기검색어 테이블
$g5['scrap_table'] = G5_TABLE_PREFIX.'scrap'; // 게시글 스크랩 테이블
$g5['visit_table'] = G5_TABLE_PREFIX.'visit'; // 방문자 테이블
$g5['visit_sum_table'] = G5_TABLE_PREFIX.'visit_sum'; // 방문자 합계 테이블
$g5['uniqid_table'] = G5_TABLE_PREFIX.'uniqid'; // 유니크한 값을 만드는 테이블
$g5['autosave_table'] = G5_TABLE_PREFIX.'autosave'; // 게시글 작성시 일정시간마다 글을 임시 저장하는 테이블
$g5['cert_history_table'] = G5_TABLE_PREFIX.'cert_history'; // 인증내역 테이블
$g5['qa_config_table'] = G5_TABLE_PREFIX.'qa_config'; // 1:1문의 설정테이블
$g5['qa_content_table'] = G5_TABLE_PREFIX.'qa_content'; // 1:1문의 테이블
$g5['content_table'] = G5_TABLE_PREFIX.'content'; // 내용(컨텐츠)정보 테이블
$g5['faq_table'] = G5_TABLE_PREFIX.'faq'; // 자주하시는 질문 테이블
$g5['faq_master_table'] = G5_TABLE_PREFIX.'faq_master'; // 자주하시는 질문 마스터 테이블
$g5['new_win_table'] = G5_TABLE_PREFIX.'new_win'; // 새창 테이블
$g5['menu_table'] = G5_TABLE_PREFIX.'menu'; // 메뉴관리 테이블

define('G5_USE_SHOP', true);

define('G5_SHOP_TABLE_PREFIX', 'g5_shop_');

$g5['g5_shop_default_table'] = G5_SHOP_TABLE_PREFIX.'default'; // 쇼핑몰설정 테이블
$g5['g5_shop_banner_table'] = G5_SHOP_TABLE_PREFIX.'banner'; // 배너 테이블
$g5['g5_shop_cart_table'] = G5_SHOP_TABLE_PREFIX.'cart'; // 장바구니 테이블
$g5['g5_shop_category_table'] = G5_SHOP_TABLE_PREFIX.'category'; // 상품분류 테이블
$g5['g5_shop_event_table'] = G5_SHOP_TABLE_PREFIX.'event'; // 이벤트 테이블
$g5['g5_shop_event_item_table'] = G5_SHOP_TABLE_PREFIX.'event_item'; // 상품, 이벤트 연결 테이블
$g5['g5_shop_item_table'] = G5_SHOP_TABLE_PREFIX.'item'; // 상품 테이블
$g5['g5_shop_item_option_table'] = G5_SHOP_TABLE_PREFIX.'item_option'; // 상품옵션 테이블
$g5['g5_shop_item_use_table'] = G5_SHOP_TABLE_PREFIX.'item_use'; // 상품 사용후기 테이블
$g5['g5_shop_item_qa_table'] = G5_SHOP_TABLE_PREFIX.'item_qa'; // 상품 질문답변 테이블
$g5['g5_shop_item_relation_table'] = G5_SHOP_TABLE_PREFIX.'item_relation'; // 관련 상품 테이블
$g5['g5_shop_order_table'] = G5_SHOP_TABLE_PREFIX.'order'; // 주문서 테이블
$g5['g5_shop_order_delete_table'] = G5_SHOP_TABLE_PREFIX.'order_delete'; // 주문서 삭제 테이블
$g5['g5_shop_wish_table'] = G5_SHOP_TABLE_PREFIX.'wish'; // 보관함(위시리스트) 테이블
$g5['g5_shop_coupon_table'] = G5_SHOP_TABLE_PREFIX.'coupon'; // 쿠폰정보 테이블
$g5['g5_shop_coupon_zone_table'] = G5_SHOP_TABLE_PREFIX.'coupon_zone'; // 쿠폰존 테이블
$g5['g5_shop_coupon_log_table'] = G5_SHOP_TABLE_PREFIX.'coupon_log'; // 쿠폰사용정보 테이블
$g5['g5_shop_sendcost_table'] = G5_SHOP_TABLE_PREFIX.'sendcost'; // 추가배송비 테이블
$g5['g5_shop_personalpay_table'] = G5_SHOP_TABLE_PREFIX.'personalpay'; // 개인결제 정보 테이블
$g5['g5_shop_order_address_table'] = G5_SHOP_TABLE_PREFIX.'order_address'; // 배송지이력 정보 테이블
$g5['g5_shop_item_stocksms_table'] = G5_SHOP_TABLE_PREFIX.'item_stocksms'; // 재입고SMS 알림 정보 테이블
$g5['g5_shop_order_data_table'] = G5_SHOP_TABLE_PREFIX.'order_data'; // 모바일 결제정보 임시저장 테이블
$g5['g5_shop_inicis_log_table'] = G5_SHOP_TABLE_PREFIX.'inicis_log'; // 이니시스 모바일 계좌이체 로그 테이블
?>