<?php
// board_delete.php , boardgroup_delete.php 에서 include 하는 파일

if (!defined('_GNUBOARD_')) exit;
if (!defined('_BOARD_DELETE_')) exit; // 개별 페이지 접근 불가

// $tmp_bo_table 에는 $bo_table 값을 넘겨주어야 함
if (!$tmp_bo_table) { return; }

// 게시판 1개는 삭제 불가 (게시판 복사를 위해서)
//$row = sql_fetch(" select count(*) as cnt from $g5['board_table'] ");
//if ($row['cnt'] <= 1) { return; }

// 게시판 설정 삭제
sql_query(" delete from {$g5['board_table']} where bo_table = '{$tmp_bo_table}' ");

// 최신글 삭제
sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$tmp_bo_table}' ");

// 스크랩 삭제
sql_query(" delete from {$g5['scrap_table']} where bo_table = '{$tmp_bo_table}' ");

// 파일 삭제
sql_query(" delete from {$g5['board_file_table']} where bo_table = '{$tmp_bo_table}' ");

// 내글반응 삭제
sql_query(" delete from {$g5['apms_response']} where bo_table = '{$tmp_bo_table}' ", false);

// 태그로그 삭제
sql_query(" delete from {$g5['apms_tag_log']} where bo_table = '{$tmp_bo_table}' ", false);

// 신고글 삭제
sql_query(" delete from {$g5['apms_shingo']} where bo_table = '{$tmp_bo_table}' ", false);

// 이벤트 삭제
sql_query(" delete from {$g5['apms_event']} where bo_table = '{$tmp_bo_table}' ", false);

// 설문 삭제
sql_query(" delete from {$g5['apms_poll']} where bo_table = '{$tmp_bo_table}' ", false);

// 플레이목록 삭제
sql_query(" delete from {$g5['apms_playlist']} where bo_table = '{$tmp_bo_table}' ", false);

// 게시판 테이블 DROP
sql_query(" drop table {$g5['write_prefix']}{$tmp_bo_table} ", FALSE);

delete_cache_latest($tmp_bo_table);

// 게시판 폴더 전체 삭제
rm_rf(G5_DATA_PATH.'/file/'.$tmp_bo_table);
?>