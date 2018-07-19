<?php
include_once('./_common.php');

if (isset($_REQUEST['is_id'])) { 
    $is_id = (int)$_REQUEST['is_id'];
}

if (!$is_id) {
	alert('is_id 값이 넘어오지 않았습니다.', G5_URL);
}

$view = sql_fetch(" select * from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) where a.is_confirm = '1' and a.is_id = '$is_id' ");

if(!$view['is_id']) {
	alert('존재하지 않는 자료입니다.', G5_URL);
}

if($ca_id) {
	$qstr .= '&amp;ca_id='.$ca_id;
}

// 버튼
$view['is_edit_href'] = $view['is_del_href'] = '';
if($is_admin || ($view['mb_id'] && $member['mb_id'] == $view['mb_id'])) {
	$view['is_edit_href'] = './itemuseform.php?it_id='.$view['it_id'].'&amp;is_id='.$is_id.'&amp;page='.$page.'&amp;w=u&amp;move=3';

	$hash = md5($view['is_id'].$view['is_time'].$view['is_ip']);
	$view['is_del_href'] = './itemuseformupdate.php?it_id='.$view['it_id'].'&amp;is_id='.$is_id.'&amp;w=d&amp;move=2&amp;hash='.$hash;
}

$view['is_time'] = strtotime($view['is_time']);
$view['is_photo'] = apms_photo_url($view['mb_id']);
$view['is_content'] = apms_content(conv_content($view['is_content'], 1));
$view['it_href'] = './item.php?it_id='.$view['it_id'];
$view['is_reply'] = false;
if(!empty($view['is_reply_content'])) {
	$view['is_reply'] = true;
	$view['is_reply_name'] = get_text($view['is_reply_name']); 
	$view['is_reply_subject'] = get_text($view['is_reply_subject']); 
	$view['is_reply_content'] = apms_content(conv_content($view['is_reply_content'], 1));
}

// Page ID
$pid = ($pid) ? $pid : 'iuse';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$skin_row = array();
$skin_row = apms_rows('use_'.MOBILE_.'rows, use_'.MOBILE_.'skin, use_'.MOBILE_.'set');
$skin_name = $skin_row['use_'.MOBILE_.'skin'];

// 스킨설정
$wset = array();
if($skin_row['use_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['use_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$skin_path = G5_SKIN_PATH.'/apms/use/'.$skin_name;
$skin_url = G5_SKIN_URL.'/apms/use/'.$skin_name;

// 스킨 체크
list($skin_path, $skin_url) = apms_skin_thema('shop/use', $skin_path, $skin_url); 

// 설정값 불러오기
$is_use_sub = false;
@include_once($skin_path.'/config.skin.php');

// SEO 메타태그
$is_seometa = 'iuse';
$g5['title'] = get_text($view['is_subject']).' > '.get_text($view['it_name']);

if($is_use_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

// 셋업
$setup_href = '';
if (is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=use&amp;name='.urlencode($skin_name).'&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/useview.skin.php');

if($is_use_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>
