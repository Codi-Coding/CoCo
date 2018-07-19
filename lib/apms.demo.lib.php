<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$is_demo) return;

// 위치체크
$shop = (IS_YC && IS_SHOP) ? 1 : 0;
$qstr_shop = '';
if($shop) {
	$qstr_shop = '&amp;shop=1';
	$qstr .= $qstr_shop;
}

//데모 메뉴설정
$demo_menu_arr = array(); //1차 서브
$demo_sub_arr = array(); //2차 서브

//페이지 메뉴
$demo_page_menu = array();
$i = 0;
$msp = 'page';
$demo_href = 'mon='.$msp.'&amp;pv='.THEMA.$qstr_shop.'&amp;pvp=';
$demo_on = ($mon == $msp) ? 'on' : 'off';
$demo_page_menu[$i]['on'] = $demo_on;
$demo_page_menu[$i]['new'] = 'old';
$demo_page_menu[$i]['href'] = $at_href['faq'].'?'.$demo_href.urlencode('faq');
$demo_page_menu[$i]['name'] = $demo_page_menu[$i]['menu'] = '기본 페이지';
$demo_page_menu[$i]['icon'] = '<i class="fa fa-book"></i>';
$demo_page_menu[$i]['is_sub'] = true;
$demo_page_menu[$i]['gr_id'] = $msp;

//1차 서브
if(IS_YC && IS_SHOP) { // 쇼핑몰
	$demo_menu_arr[] = array('cart', '장바구니', '', 0);
	$demo_menu_arr[] = array('inquiry', '주문내역', '', 0);
	$demo_menu_arr[] = array('ppay', '개인결제', '', 0);
	$demo_menu_arr[] = array('event', '이벤트', '', 0);
	$demo_menu_arr[] = array('isearch', '상품검색', '', 0);
	$demo_menu_arr[] = array('iuse', '상품후기', '', 0);
	$demo_menu_arr[] = array('iqa', '상품문의', '', 0);
	$demo_menu_arr[] = array('wishlist', '위시리스트', '', 0);
	if(USE_PARTNER) {
		$demo_menu_arr[] = array('myshop', '마이샵', '', 0);
		$demo_menu_arr[] = array('partner', '파트너', '', 0);
	}
} else {
	$demo_menu_arr[] = array('faq', 'FAQ', '', 0);
	$demo_menu_arr[] = array('search', '게시물검색', '', 0);
	$demo_menu_arr[] = array('new', '새글모음', '', 0);
	$demo_menu_arr[] = array('connect', '현재접속자', '', 0);
	$demo_menu_arr[] = array('tag', '태그박스', '', 0);
	$demo_menu_arr[] = array('login', '로그인', '', 0);
	$demo_menu_arr[] = array('reg', '회원가입', '', 0);
	$demo_menu_arr[] = array('secret', '1:1문의', '', 0);
}

for($j=0; $j < count($demo_menu_arr); $j++) {
	$pvpv = $demo_menu_arr[$j][0];
	$demo_sub_on = ($demo_on && $pvp == $pvpv) ? 'on' : 'off';
	$demo_page_menu[$i]['sub'][$j]['line'] = $demo_menu_arr[$j][2];
	$demo_page_menu[$i]['sub'][$j]['sp'] = $demo_menu_arr[$j][3];
	$demo_page_menu[$i]['sub'][$j]['on'] = $demo_sub_on;
	$demo_page_menu[$i]['sub'][$j]['href'] = $at_href[$pvpv].'?'.$demo_href.urlencode($pvpv);
	if($pvpv == 'myshop') {
		$demo_page_menu[$i]['sub'][$j]['href'] .= '&amp;id=amina';
	}
	$demo_page_menu[$i]['sub'][$j]['name'] = $demo_page_menu[$i]['sub'][$j]['menu'] = $demo_menu_arr[$j][1];
	$demo_page_menu[$i]['sub'][$j]['new'] = 'old';
	$demo_page_menu[$i]['sub'][$j]['is_sub'] = false;
}

unset($demo_menu_arr);

//보드 메뉴
$demo_board_menu = array();
$i = 0;
$msp = 'basic';
$demo_href = G5_BBS_URL.'/board.php?bo_table='.$msp.$qstr_shop.'&amp;pv='.THEMA.'&amp;pvbl=';
$demo_on = ($bo_table == $msp) ? 'on' : 'off';
$demo_board_menu[$i]['on'] = $demo_on;
$demo_board_menu[$i]['new'] = 'old';
$demo_board_menu[$i]['href'] = $demo_href.urlencode('list').$qstr_shop.'&amp;pvbh='.urlencode('basic-black');
$demo_board_menu[$i]['name'] = $demo_board_menu[$i]['menu'] = '기본 보드';
$demo_board_menu[$i]['icon'] = '<i class="fa fa-pencil"></i>';
$demo_board_menu[$i]['is_sub'] = true;
$demo_board_menu[$i]['gr_id'] = $msp;

//1차 서브 - 목록
$demo_menu_arr[] = array('list', '리스트', '', 0);
$demo_menu_arr[] = array('gallery', '갤러리', '', 0);
$demo_menu_arr[] = array('lightbox', '라이트박스', '', 0);
$demo_menu_arr[] = array('webzine', '웹진', '', 0);
$demo_menu_arr[] = array('blog', '블로그', '', 0);
$demo_menu_arr[] = array('portfolio', '포트폴리오', '', 0);
$demo_menu_arr[] = array('timeline', '타임라인', '', 0);
$demo_menu_arr[] = array('talkbox', '토크박스', '', 0);
$demo_menu_arr[] = array('talkbox-top', '토크박스-상단', '', 0);
$demo_menu_arr[] = array('talkbox-bottom', '토크박스-하단', '', 0);

for($j=0; $j < count($demo_menu_arr); $j++) {
	$pvpv = $demo_menu_arr[$j][0];
	$demo_sub_on = ($demo_on && $pvbl == $pvpv) ? 'on' : 'off';
	$demo_board_menu[$i]['sub'][$j]['line'] = $demo_menu_arr[$j][2];
	$demo_board_menu[$i]['sub'][$j]['sp'] = $demo_menu_arr[$j][3];
	$demo_board_menu[$i]['sub'][$j]['on'] = $demo_sub_on;
	$demo_board_menu[$i]['sub'][$j]['href'] = $demo_href.urlencode($pvpv);
	$demo_board_menu[$i]['sub'][$j]['name'] = $demo_board_menu[$i]['sub'][$j]['menu'] = $demo_menu_arr[$j][1];
	$demo_board_menu[$i]['sub'][$j]['new'] = 'old';
	$demo_board_menu[$i]['sub'][$j]['is_sub'] = false;
}

unset($demo_menu_arr);

//더보기 메뉴
$demo_more_menu = array();
$i = 0;
$msp = 'more';
$demo_more_menu[$i]['on'] = 'off';
$demo_more_menu[$i]['new'] = 'old';
$demo_more_menu[$i]['href'] = 'http://amina.co.kr/demo/?pv=Basic';
$demo_more_menu[$i]['name'] = $demo_more_menu[$i]['menu'] = '테마 더보기';
$demo_more_menu[$i]['icon'] = '<i class="fa fa-desktop"></i>';
$demo_more_menu[$i]['is_sub'] = true;
$demo_more_menu[$i]['gr_id'] = $msp;

$demo_menu_arr[] = array(G5_URL.'/?pv=Basic', '베이직 테마', '', 0);
$demo_menu_arr[] = array('http://amina.co.kr/shop/list.php?ca_id=10', '아미나 테마', '', 0);
$demo_menu_arr[] = array('http://amina.co.kr/shop/list.php?ca_id=20', '파트너 테마', '', 0);
for($j=0; $j < count($demo_menu_arr); $j++) {
	$demo_more_menu[$i]['sub'][$j]['line'] = $demo_menu_arr[$j][2];
	$demo_more_menu[$i]['sub'][$j]['sp'] = $demo_menu_arr[$j][3];
	$demo_more_menu[$i]['sub'][$j]['href'] = $demo_menu_arr[$j][0];
	$demo_more_menu[$i]['sub'][$j]['name'] = $demo_more_menu[$i]['sub'][$j]['menu'] = $demo_menu_arr[$j][1];
	$demo_more_menu[$i]['sub'][$j]['on'] = 'off';
	$demo_more_menu[$i]['sub'][$j]['new'] = 'old';
	$demo_more_menu[$i]['sub'][$j]['is_sub'] = false;
}

unset($demo_menu_arr);

//데모 스킨설정파일
$demo_setup_file = THEMA_PATH.'/assets/demo.config.php';

//데모 공통설정
@include_once(THEMA_PATH.'/assets/demo/demo.config.php');

?>