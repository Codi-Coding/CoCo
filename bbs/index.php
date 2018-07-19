<?php
	define('_LINK_',true);
	include_once('./_common.php');

	if(!$_GET['t']) {
		alert('잘못된 접근입니다.');
		exit;
	} else {
		include_once($board_skin_path.'/index.php');
	}
?>