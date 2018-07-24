<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 보드설정값
$bo_set = "
	bo_page_rows = '$bo_page_rows',
	bo_mobile_page_rows = '$bo_mobile_page_rows',
	bo_gallery_width = '$bo_gallery_width',
	bo_gallery_height = '$bo_gallery_height',
	bo_mobile_gallery_width = '$bo_mobile_gallery_width',
	bo_mobile_gallery_height = '$bo_mobile_gallery_height',
	bo_gallery_cols = '$bo_gallery_cols',
	bo_subject_len = '$bo_subject_len',
	bo_mobile_subject_len = '$bo_mobile_subject_len'
";

sql_query(" update {$g5['board_table']} set $bo_set where bo_table = '{$bo_table}' ", false);

?>
