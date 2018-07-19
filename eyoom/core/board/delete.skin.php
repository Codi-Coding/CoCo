<?php
if (!defined('_GNUBOARD_')) exit;

$dsql = " select wr_id, mb_id, wr_is_comment, wr_content, wr_link2 from $write_table where wr_parent = '{$write['wr_id']}' order by wr_id ";
$res = sql_query($dsql);
while ($row = sql_fetch_array($res)) {
	// 원글이라면
	if (!$row['wr_is_comment']) {
		$wr_id = $row['wr_id'];
		$eb->delete_editor_image($row['wr_content']);
	} else {
		// 코멘트에 작용된 파일삭제
		if($row['wr_link2']) $eb->delete_comment_image($row['wr_link2'], $bo_table);
	}
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/delete.skin.php');