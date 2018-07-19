<?php
include_once('./_common.php');

// 자바스크립트 사용가능할 때
if($_POST['js'] == "on") {
    $error = $success = $count = "";

    function print_result($error, $success, $count) {
		echo '{ "error": "' . $error . '", "success": "' . $success . '", "count": "' . $count . '" }';
        exit;
    }

    if (!$is_member) {
        $error = '회원만 가능합니다.';
        print_result($error, $success, $count);
    }

    if (!$id) {
        $error = '값이 제대로 넘어오지 않았습니다.';
        print_result($error, $success, $count);
    }

	$to = get_member($id);

	if (!$to['mb_id']) {
        $error = '대상이 존재하지 않습니다.';
        print_result($error, $success, $count);
    }

    if($to['mb_id'] == $member['mb_id']) {
        $error = '자신에게 할 수 없습니다.';
        print_result($error, $success, $count);
    }

    if ($act == 'like' || $act == 'follow') {
        $sql = " select flag from {$g5['apms_like']} where mb_id = '{$member['mb_id']}' and to_id = '{$id}' and flag = '{$act}' ";
        $row = sql_fetch($sql);
        if ($row['flag']) {
            $status = ($row['flag'] == 'like') ? '좋아요' : '팔로잉';

            $error = "이미 $status 하셨습니다.";
	        print_result($error, $success, $count);
        } else {
			if($act == 'like') {
				// 내 카운트 증가
				sql_query(" update {$g5['member_table']} set as_like = as_like + 1 where mb_id = '{$member['mb_id']}' ");

				// 상대편 카운트 증가
				sql_query(" update {$g5['member_table']} set as_liked = as_liked + 1 where mb_id = '{$id}' ");

				$status = '좋아요';	
				$count = (int)$to['as_liked'] + 1;
			} else {
				// 내 카운트 증가
				sql_query(" update {$g5['member_table']} set as_follow = as_follow + 1 where mb_id = '{$member['mb_id']}' ");

				// 상대편 카운트 증가
				sql_query(" update {$g5['member_table']} set as_followed = as_followed + 1 where mb_id = '{$id}' ");

				$status = '팔로잉';	
				$count = (int)$to['as_followed'] + 1;
			}

			// 내역 생성
            sql_query(" insert {$g5['apms_like']} set mb_id = '{$member['mb_id']}', to_id = '{$id}', flag = '{$act}', regdate = '".G5_TIME_YMDHIS."' ");

			$success = $status.' 하셨습니다.';
	        print_result($error, $success, $count);
        }
    }
} else {

    if (!$is_member) {
        alert('회원만 가능합니다.');
    }

    if (!$it_id) {
        alert('값이 제대로 넘어오지 않았습니다.');
	}

	$to = get_member($id);

	if (!$to['mb_id']) {
        alert('대상이 존재하지 않습니다.');
    }

	if($to['mb_id'] == $member['mb_id']) {
        alert('자신에게 할 수 없습니다.');
    }

    if ($act == 'like' || $act == 'follow') {

        $sql = " select flag from {$g5['apms_like']} where mb_id = '{$member['mb_id']}' and to_id = '{$id}' and flag = '{$act}' ";
        $row = sql_fetch($sql);
        if ($row['flag']) {
            $status = ($row['flag'] == 'like') ? '좋아요' : '팔로잉';
            alert("이미 $status 하셨습니다.");
        } else {
			if($act == 'like') {
				// 내 카운트 증가
				sql_query(" update {$g5['member_table']} set as_like = as_like + 1 where mb_id = '{$member['mb_id']}' ");

				// 상대편 카운트 증가
				sql_query(" update {$g5['member_table']} set as_liked = as_liked + 1 where mb_id = '{$id}' ");

				$status = '좋아요';	
				$count = (int)$to['as_liked'] + 1;
			} else {
				// 내 카운트 증가
				sql_query(" update {$g5['member_table']} set as_follow = as_follow + 1 where mb_id = '{$member['mb_id']}' ");

				// 상대편 카운트 증가
				sql_query(" update {$g5['member_table']} set as_followed = as_followed + 1 where mb_id = '{$id}' ");

				$status = '팔로잉';	
				$count = (int)$to['as_followed'] + 1;
			}

			// 내역 생성
            sql_query(" insert {$g5['apms_like']} set mb_id = '{$member['mb_id']}', to_id = '{$id}', flag = '{$act}', regdate = '".G5_TIME_YMDHIS."' ");

			alert("$status 하셨습니다.", '', false);
        }
    }
}

?>