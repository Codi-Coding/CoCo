<?php
if (!defined('_GNUBOARD_')) exit;

// 답글에 대한 내글반응 삭제 부분은 복잡한 관계로 다음 버전에서...

// 이윰 새글에서 삭제
sql_query(" delete from {$g5['eyoom_new']} where bo_table = '$bo_table' and wr_parent = '{$write['wr_id']}' ");

/**
 * 태그글 작성 테이블에서 해당 글 삭제
 * 태그 사용여부와 상관없이 처리 - 태그사용 후, 사용안한 게시물들의 태그글도 삭제하기 위함
 */
sql_query(" delete from {$g5['eyoom_tag_write']} where tw_theme = '{$theme}' and bo_table = '$bo_table' and wr_id = '{$write['wr_id']}' ", false);

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/delete.tail.skin.php');

// 무한스크롤 모달창 닫기
if($wmode) {
	delete_cache_latest($bo_table);
	echo "
	<script>window.parent.closeModal('{$write['wr_id']}');</script>
	";
	exit;
}