<?php
if (!defined('_SHOP_')) exit;

ob_start();
include_once (G5_SHOP_PATH.'/settle_'.$default['de_pg_service'].'.inc.php');
$settle_pg = ob_get_contents();
ob_end_clean();

ob_start();
// 결제대행사별 코드 include (스크립트 등)
include_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.1.php');
$orderform1 = ob_get_contents();
ob_end_clean();

ob_start();
// 결제대행사별 코드 include (결제대행사 정보 필드)
include_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');
$orderform2 = ob_get_contents();
ob_end_clean();

$multi_settle == 0;
$checked = '';

$escrow_title = "";
if ($default['de_escrow_use']) {
	$escrow_title = "에스크로 ";
}

// 가상계좌 사용
if ($default['de_vbank_use']) {
	$multi_settle++;
}

// 계좌이체 사용
if ($default['de_iche_use']) {
	$multi_settle++;
}

// 휴대폰 사용
if ($default['de_hp_use']) {
	$multi_settle++;
}

// 신용카드 사용
if ($default['de_card_use']) {
	$multi_settle++;
}

ob_start();
include_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.3.php');
$orderform3 = ob_get_contents();
ob_end_clean();

ob_start();
include_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.4.php');
$orderform4 = ob_get_contents();
ob_end_clean();

ob_start();
include_once (G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.5.php');
$orderform5 = ob_get_contents();
ob_end_clean();