<?php
	include_once('./_common.php');

	if(!$_GET['pid']) {
		alert('잘못된 접근입니다.');
		exit;
	} else {
		$pid = $_GET['pid'];
	}

	define('_PAGE_',true);
	if(!$act) include_once('../_head.php');
	include_once($page_skin_path.'/index.php');
	if(!$act) include_once('../_tail.php');
?>