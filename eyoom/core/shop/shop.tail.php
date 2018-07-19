<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 커뮤니티 레이아웃을 쇼핑몰에 적용하기
if(isset($eyoom['use_layout_community']) && $eyoom['use_layout_community'] == 'y') {
	@include_once(EYOOM_PATH.'/tail.php');
	return;
}

// PC/모바일 링크 생성
$href = $thema->get_href($tpl_name);

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/shop.tail.php');

// 템플릿에 변수 할당
@include EYOOM_INC_PATH.'/tpl.assign.php';

// 로딩 시간 계산 
$end_time = $tpl->getMicroTime();
$run_time = $end_time - $start_time;

$tpl->define(array(
	'push_pc'	=> 'skin_pc/push/' . $eyoom['push_skin'] . '/push.skin.html',
	'push_mo'	=> 'skin_mo/push/' . $eyoom['push_skin'] . '/push.skin.html',
	'push_bs'	=> 'skin_bs/push/' . $eyoom['push_skin'] . '/push.skin.html',
));

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'tail.skin.html');
$tpl->print_($tpl_name);