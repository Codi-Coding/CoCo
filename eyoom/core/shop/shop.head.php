<?php
if (!defined('_GNUBOARD_')) exit;

@include_once(EYOOM_SHOP_PATH.'/shop.lib.php');

// 커뮤니티 레이아웃을 쇼핑몰에 적용하기
if(isset($eyoom['use_layout_community']) && $eyoom['use_layout_community'] == 'y') {
	@include_once(EYOOM_PATH.'/head.php');
	return;
}

if(!defined('_EYOOM_')) @include EYOOM_PATH.'/common.php';

// PC/모바일 링크 생성
$href = $thema->get_href($tpl_name);

if($is_member) {
	// 읽지 않은 쪽지
	$memo_not_read = $eb->get_memo($member['mb_id']);

	// 내글 반응
	$respond = $eyoomer['respond'];
	if($respond < 0) {
		$respond = 0;
		sql_query("update {$g5['eyoom_member']} set respond = 0 where mb_id='{$member['mb_id']}'");
	}
}

// 메뉴설정
if($eyoom['use_eyoom_shopmenu'] == 'y') {
	$me_shop = 1;
	$menu = $thema->menu_create('eyoom');
} else {
	$menu = $shop->menu_create();
}

// 서브페이지 타이틀 및 Path 정보
$subinfo = $thema->subpage_info($menu);

// 접속자 정보
$connect = $eb->get_connect();

//최근 본 상품
if(defined('_SHOP_')) @include EYOOM_SHOP_PATH.'/boxtodayview.php';

// 사이드 메뉴 출력여부 판단
if (defined('_INDEX_')) {
	if ($eyoom['use_shopmain_side_layout'] == 'y') {
		$side_layout['use'] = 'yes';
		$side_layout['pos'] = $eyoom['pos_shopmain_side_layout'];
	}
} else {
	if ($eyoom['use_shopsub_side_layout'] == 'y') {
		$side_layout['use'] = 'yes';
		$side_layout['pos'] = $eyoom['pos_shopsub_side_layout'];
	}
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/shop.head.php');

// 템플릿에 변수 할당
@include EYOOM_INC_PATH.'/tpl.assign.php';

$tpl->define(array(
	"shop_side" => "skin_bs/shop/".$eyoom['shop_skin']."/side.skin.html",
));

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'head.skin.html');

$tpl->print_($tpl_name);