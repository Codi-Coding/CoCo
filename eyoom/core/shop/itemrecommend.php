<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/itemrecommend.php');
	return;
}

if (!$is_member)
	alert_close('회원만 메일을 발송할 수 있습니다.');
	
// 스팸을 발송할 수 없도록 세션에 아무값이나 저장하여 hidden 으로 넘겨서 다음 페이지에서 비교함
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$sql = " select it_name from {$g5['g5_shop_item_table']} where it_id='$it_id' ";
$it = sql_fetch($sql);
if (!$it['it_name'])
	alert_close("등록된 상품이 아닙니다.");

$g5['title'] =  $it['it_name'].' - 추천하기';

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'item_recommend.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/itemrecommend.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

include_once(G5_PATH.'/tail.sub.php');