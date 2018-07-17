<?php
// 댓글 삭제
include_once('./_common.php');

$delete_comment_token = get_session('it_delete_comment_'.$comment_id.'_token');
set_session('ss_delete_comment_'.$comment_id.'_token', '');

if (!($token && $delete_comment_token == $token))
	apms_alert('1|토큰 에러로 삭제 불가합니다.');

// 상품정보
$it = apms_it($it_id);

if (!$it['it_id'])
    apms_alert("1|자료가 없습니다.");

// 테이블
$comment_table = $g5['apms_comment'];

$write = sql_fetch(" select * from {$comment_table} where wr_id = '{$comment_id}' and it_id = '{$it_id}' ");

if (!$write['wr_id'])
    apms_alert('1|등록된 댓글이 아닙니다.');

if ($is_admin == 'super') { // 최고관리자 통과
    ;
} else if ($member['mb_id']) {
    if ($member['mb_id'] != $write['mb_id'])
        apms_alert('1|자신의 댓글이 아니므로 삭제할 수 없습니다.');
} else {
	apms_alert('1|로그인한 회원만 삭제할 수 있습니다.');
	//if (sql_password($wr_password) != $write['wr_password'])
    //    apms_alert('1|비밀번호가 틀립니다.');
}

$len = strlen($write['wr_comment_reply']);
if ($len < 0) $len = 0;
$comment_reply = substr($write['wr_comment_reply'], 0, $len);

$sql = " select count(*) as cnt from {$comment_table}
            where wr_comment_reply like '{$comment_reply}%'
            and wr_id <> '{$comment_id}'
            and it_id = '{$it_id}'
			and wr_comment = '{$write[wr_comment]}' ";
$row = sql_fetch($sql);
if ($row['cnt'] && !$is_admin)
    apms_alert('1|이 댓글과 관련된 대댓글이 존재하므로 삭제 할 수 없습니다.');

// 댓글 포인트 삭제
if (!delete_point($write['mb_id'], $it_id, $comment_id, '댓글'))
    insert_point($write['mb_id'], $default['pt_comment_point'] * (-1), "{$it_id}-{$comment_id} 댓글 삭제");

// 댓글 삭제
sql_query(" delete from {$comment_table} where wr_id = '{$comment_id}' and it_id = '{$it_id}' ");

// 상품의 댓글 숫자를 감소
sql_query(" update {$g5['g5_shop_item_table']} set pt_comment = pt_comment - 1 where it_id = '{$it_id}' ");

//apms_alert('0|삭제 하셨습니다.');
apms_alert('');

?>