<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 데모 스킨설정 파일
$demo_setup_file = THEMA_PATH.'/assets/demo/demo.php';

// 데모일 때 설정
$demo_config = array('bo_table' => 'basic', 'ca_id' => '10', 'ev_id' => '', 'bn_id' => '');

// 데모 레이아웃 설정값 저장하기
if(isset($dpv) && $dpv) { 
	if($reset) {
		set_session(THEMA.'_demo_set', '');
	} else {
		$dpv_set = serialize($_POST['at_set']);
		set_session(THEMA.'_demo_set', $dpv_set);
	}
}

// 데모 레이아웃 설정값 불러오기
$demo_set = get_session(THEMA.'_demo_set');
if($demo_set) {
	$tmp_set = unserialize($demo_set);
	if($tmp_set['thema'] == THEMA) {
		$at_set = $tmp_set;
	}
	unset($tmp_set);
}

//G5 데모 설정값
$member_skin_path   = G5_SKIN_PATH.'/member/basic';
$member_skin_url    = G5_SKIN_URL.'/member/basic';
$new_skin_path      = G5_SKIN_PATH.'/new/basic';
$new_skin_url       = G5_SKIN_URL.'/new/basic';
$search_skin_path   = G5_SKIN_PATH.'/search/basic';
$search_skin_url    = G5_SKIN_URL.'/search/basic';
$connect_skin_path  = G5_SKIN_PATH.'/connect/basic';
$connect_skin_url   = G5_SKIN_URL.'/connect/basic';
$faq_skin_path      = G5_SKIN_PATH.'/faq/basic';
$faq_skin_url       = G5_SKIN_URL.'/faq/basic';
$tag_skin_path      = G5_SKIN_PATH.'/tag/basic';
$tag_skin_url       = G5_SKIN_URL.'/tag/basic';
$qa_skin_path       = G5_SKIN_PATH.'/qa/basic';
$qa_skin_url        = G5_SKIN_URL.'/qa/basic';
$order_skin_path    = G5_SKIN_PATH.'/apms/order/basic';
$order_skin_url     = G5_SKIN_URL.'/apms/order/basic';

if($bo_table == 'basic') {
	$board['bo_'.MOBILE_.'skin'] = 'Basic-Board';
	$board_skin_path = G5_SKIN_PATH.'/board/'.$board['bo_'.MOBILE_.'skin'];
	$board_skin_url = G5_SKIN_URL.'/board/'.$board['bo_'.MOBILE_.'skin'];
}

?>