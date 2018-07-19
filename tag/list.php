<?php
	include_once('./_common.php');
	
	define('TAG_LIST', true);
	
	$g5['title'] = '태그 리스트';

	include_once('../_head.php');
	include_once($tag_skin_path.'/list.skin.php');
	include_once('../_tail.php');
?>