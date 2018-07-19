<?php
if (!defined('_GNUBOARD_')) exit;

// 첨부한 이미지 파일이 있다면 삭제하기
if($write['wr_link2']) $eb->delete_comment_image($write['wr_link2'], $bo_table);

// 내글반응 삭제
$where = "bo_table = '{$bo_table}' and wr_id = '{$write['wr_parent']}' and wr_cmt = '{$comment_id}'";
$row = sql_fetch("select * from {$g5['eyoom_respond']} where $where ");
if($row['wr_id']) {
	// 아직 읽지 않은 상태라면 상대의 반응글 수 내림
	if(!$row['re_chk']) sql_query("update {$g5['eyoom_member']} set respond = respond - 1 where mb_id = '{$row['wr_mb_id']}'");

	if($row['re_cnt'] > 0) {
		// 카운트가 0보다 클때 카운트 내림
		sql_query("update {$g5['eyoom_respond']} set re_cnt = re_cnt -1 where $where");
	} else {
		// 카운트가 0이라면 삭제
		sql_query("delete from {$g5['eyoom_respond']} where $where");
	}		
}

// 원글의 코멘트 숫자를 감소
sql_query(" update {$g5['eyoom_new']} set wr_comment = wr_comment - 1 where wr_id = '{$write['wr_parent']}' ");

// 이윰 새글 테이블에서 댓글내용 삭제
sql_query("delete from {$g5['eyoom_new']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}'");

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/delete_comment.skin.php');

// 무한스크롤 리스트에서 뷰창을 띄웠을 경우
$qstr .= $wmode ? $qstr.'&wmode=1':'';