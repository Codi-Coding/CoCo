<?php
// tmpl_board_list_update.php 에서 include 하는 파일

if (!defined('_GNUBOARD_')) exit;
if (!defined('_BOARD_DELETE_')) exit; // 개별 페이지 접근 불가

// $tmp_cf_id 에는 $_POST['cf_id'] 값을 넘겨주어야 함
// $tmp_bo_table 에는 $bo_table 값을 넘겨주어야 함
if (!$tmp_cf_id) { return; }
if (!$tmp_bo_table) { return; }

// 게시판 설정 삭제
sql_query(" delete from {$g5['config2w_board_table']} where cf_id = '$tmp_cf_id' and bo_table = '{$tmp_bo_table}' ");
?>
