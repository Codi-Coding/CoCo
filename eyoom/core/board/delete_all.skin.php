<?php
if (!defined('_GNUBOARD_')) exit;

for ($i=count($tmp_array)-1; $i>=0; $i--) {
	$write = sql_fetch(" select * from $write_table where wr_id = '$tmp_array[$i]' ");
	if ($is_admin == 'super') // 최고관리자 통과
		;
	else if ($is_admin == 'group') {
		$mb = get_member($write['mb_id']);

		// 자신이 관리하는 그룹인가?
		if ($member['mb_id'] == $group['gr_admin']) {
			if ($member['mb_level'] >= $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
				;
			else continue;
		}
		else continue;
	} else if ($is_admin == 'board') { // 게시판관리자이면
		
		$mb = get_member($write['mb_id']);
		if ($member['mb_id'] == $board['bo_admin']) // 자신이 관리하는 게시판인가?
			if ($member['mb_level'] >= $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
				;
			else continue;
		else continue;
	} else if ($member['mb_id'] && $member['mb_id'] == $write['mb_id']) { // 자신의 글이라면
		;
	} else if ($wr_password && !$write['mb_id'] && sql_password($wr_password) == $write['wr_password']) { // 비밀번호가 같다면
		;
	} else continue;   // 나머지는 삭제 불가

	$len = strlen($write['wr_reply']);
	if ($len < 0) $len = 0;
	$reply = substr($write['wr_reply'], 0, $len);

	// 원글만 구한다.
	$sql = " select count(*) as cnt from $write_table
				where wr_reply like '$reply%'
				and wr_id <> '{$write['wr_id']}'
				and wr_num = '{$write['wr_num']}'
				and wr_is_comment = 0 ";
	$row = sql_fetch($sql);
	if ($row['cnt']) continue;

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
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/delete.skin.php');