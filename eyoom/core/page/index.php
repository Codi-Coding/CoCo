<?php
if (!defined('_GNUBOARD_')) exit;

if(!$pid) alert('잘못된 접근입니다.');
else {
	$pid = str_replace("|","/",$pid);
	$page_file = $pid.'.html';
	$file_path = EYOOM_THEME_PATH.'/'.$theme.'/page/'.$page_file;

	// 코어 프로그램 프로그램 연동할 수 있도록 추가
	@include_once(EYOOM_CORE_PATH.'/page/'.$pid.'.php');
	
	// 사용자 프로그램
	@include_once(EYOOM_USER_PATH.'/page/'.$pid.'.php');

	if(file_exists($file_path)) {
		$tpl->define(array(
			'pc' => 'page/' . $page_file,
			'mo' => 'page/' . $page_file,
			'bs' => 'page/' . $page_file,
		));
		$tpl->assign(array(
			//'page' => $page,
		));
		@include EYOOM_INC_PATH.'/tpl.assign.php';
		$tpl->print_($tpl_name);
	}
}