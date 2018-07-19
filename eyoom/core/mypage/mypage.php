<?php
if (!defined('_GNUBOARD_')) exit;
if (!$member['mb_id']) alert('회원만 접근하실 수 있습니다.',G5_URL);

// iOS라면 href에서 wmode 를 off
if($eb->user_agent() != 'ios') $query_wmode = "&amp;wmode=1";

// 마이박스
@include_once(EYOOM_CORE_PATH.'/mypage/mybox.php');

$index = $_GET['t'];
if(!$eyoomer['mypage_main']) $eyoomer['mypage_main'] = 'respond';
$mymain = $index ? $index : $eyoomer['mypage_main'];
$index_file = EYOOM_CORE_PATH.'/mypage/'.$mymain.'.php';
if(file_exists($index_file)) {
	@include_once($index_file);
} else {
	$mymain = 'respond';
}

@include_once(EYOOM_CORE_PATH.'/mypage/'.$mymain.'.php');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/mypage/mypage.skin.php');

$tpl->define_template('mypage',$eyoom['mypage_skin'],'mypage.skin.html');
$tpl->assign(array(
	'mymain' => $mymain,
	'goback' => $mymain,
	'favorite' => $favorite,
	'timeline' => $timeline,
));

$tpl->define(array(
	'tab_category' => 'skin_bs/mypage/'.$eyoom['mypage_skin'].'/tabmenu.skin.html',
));

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);