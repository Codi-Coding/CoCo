<?php
if (!defined('_SHOP_')) exit;

$g5['title'] =  '상품 재입고 알림 (SMS)';

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 상품정보
$sql = " select it_id, it_name, it_soldout, it_stock_sms
			from {$g5['g5_shop_item_table']}
			where it_id = '$it_id' ";
$it = sql_fetch($sql);

if(!$it['it_id'])
	alert_close('상품정보가 존재하지 않습니다.');

if(!$it['it_soldout'] || !$it['it_stock_sms'])
	alert_close('재입고SMS 알림을 신청할 수 없는 상품입니다.');

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'item_stocksms.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/itemstocksms.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

include_once(G5_PATH.'/tail.sub.php');