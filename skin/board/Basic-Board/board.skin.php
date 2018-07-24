<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 헤더 출력
$header_skin = (isset($boset['header_skin']) && $boset['header_skin']) ? $boset['header_skin'] : ''; 
if($header_skin) {
	$header_color = $boset['header_color'];
	include_once('./header.php');
}

// 게시판 관리의 상단 내용
if(!$is_bo_content_head) {
	if (G5_IS_MOBILE) {
		echo stripslashes($board['bo_mobile_content_head']);
	} else {
		echo stripslashes($board['bo_content_head']);
	}
}

?>
