<?php
if (!defined('_GNUBOARD_')) exit;

define("_INDEX_", true);

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/index.php');
	return;
}

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 팝업창
@include_once(EYOOM_CORE_PATH.'/newwin/newwin.inc.php');

// 이윰 헤더 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

// 유형별 상품정보 출력
@include_once(EYOOM_SHOP_PATH.'/itemtype.php');

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'index.skin.html');
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');