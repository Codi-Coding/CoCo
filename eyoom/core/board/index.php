<?php
if (!defined('_GNUBOARD_')) exit;

if(!$t) alert('잘못된 접근입니다.');
else {
	if($bo_table) {
		include_once(G5_BBS_PATH.'/board.php');
	}
}