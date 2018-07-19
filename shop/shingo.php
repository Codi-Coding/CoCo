<?php
include_once('./_common.php');

$move_href = ($_POST['js'] != "on") ? G5_SHOP_URL.'/item.php?it_id='.$bo_table.'&page='.$page.$qstr : '';

function apms_return($msg) {
	global $move_href;

	if($move_href) {
		if($msg) {
			alert($msg, $move_href);
		} else {
		    echo "<script type='text/javascript'> location.replace('$move_href'); </script>";
		    exit;
		}
	} else {
		echo '{ "msg": "' . $msg . '" }';
		exit;
	}
}

$msg = '';

if (!$is_member) {
	$msg = '회원만 가능합니다.';
	apms_return($msg);
}

if (!($bo_table && $wr_id)) {
	$msg = '값이 제대로 넘어오지 않았습니다.';
	apms_return($msg);
}

$write = sql_fetch(" select * from {$g5['apms_comment']} where wr_id = '{$wr_id}' ", false);
if (!$write['wr_id']) {
	$msg = '존재하는 댓글이 아닙니다.';
	apms_return($msg);
}

if($write['mb_id'] == $member['mb_id']) {
	if($act == "lock") {
		$msg = '자신의 글은 잠글 수 없습니다.';
	} else {
		$msg = '자신의 글은 신고할 수 없습니다.';
	}
	apms_return($msg);
}

//관리자만 가능한 기능
if(!$is_admin) {
	if($default['pt_shingo'] > 0) {
		;
	} else {
		$msg = '신고 기능을 사용하지 않습니다.';
		apms_return($msg);
	}

	if(strstr($write['wr_option'], "secret")) {
		$msg = '비밀글은 신고할 수 없습니다.';
		apms_return($msg);
	}
		
	if($act) {
		$msg = '관리자만 가능합니다.';
		apms_return($msg);
	}

	if(is_admin($write['mb_id'])) {
		$msg = '관리자 글은 신고할 수 없습니다.';
		apms_return($msg);
	}
}

//신고 상태 보기
$shingo = $write['wr_shingo'];

$it = apms_it($write['it_id']);
$wr_ment = "[".$it['it_name']."] 아이템에 달린 회원님의 댓글";

if($act == "lock") {

	if($shingo < 0) {
		$msg = '이미 잠금처리된 글입니다.';
		apms_return($msg);
	}

	//신고카운트 LOCK으로 변경
	sql_query(" update {$g5['apms_comment']} set wr_shingo = '-1' where wr_id = '$wr_id' ");

	//내역 생성
	sql_query(" insert {$g5['apms_shingo']} set bo_table = '$bo_table', wr_id = '$wr_id', wr_parent = '{$write['wr_comment']}', mb_id = '@shingo', datetime = '".G5_TIME_YMDHIS."', ip = '{$_SERVER['REMOTE_ADDR']}', flag = '1' ");

	//쪽지
	$send_msg = $wr_ment."이 잠금처리되었음을 알려드립니다.";

	$success = "잠금처리하셨습니다.";

} else if($act == "unlock") {

	//신고카운트 초기화 변경
	sql_query(" update {$g5['apms_comment']} set wr_shingo = '0' where wr_id = '$wr_id' ");

	//기존 신고내역 삭제
	sql_query(" delete from {$g5['apms_shingo']} where bo_table = '$bo_table' and wr_id = '$wr_id' and flag = '1' ");

	//쪽지
	$send_msg = $wr_ment."에 대한 잠금처리가 해제되었음을 알려드립니다.";

	$success = "잠금처리를 해제하셨습니다.";

} else {

	if($shingo < 0) {
		$msg = '잠금 처리된 글은 신고할 수 없습니다.';
		apms_return($msg);
	}
		
	//신고여부
	$sql = " select count(*) as cnt from {$g5['apms_shingo']} where bo_table = '$bo_table' and wr_id = '$wr_id' and mb_id = '{$member['mb_id']}' and flag = '1' ";
	$row = sql_fetch($sql);
	if($row['cnt'] > 0) {
		$msg = '이미 신고하신 글입니다.';
		apms_return($msg);
	} else {
		$shingo = $shingo + 1;
		if($shingo >= $default['pt_shingo']) $shingo = -1;

		//신고카운트 증가
		sql_query(" update {$g5['apms_comment']} set wr_shingo = '$shingo' where wr_id = '$wr_id' ");

		//내역 생성
		sql_query(" insert {$g5['apms_shingo']} set bo_table = '$bo_table', wr_id = '$wr_id', wr_parent = '{$write['wr_comment']}', mb_id = '{$member['mb_id']}', datetime = '".G5_TIME_YMDHIS."', ip = '{$_SERVER['REMOTE_ADDR']}', flag = '1' ");

		//잠금처리
		if($shingo < 0) {
			$send_msg = $wr_ment."이 잠금처리가 되었음을 알려드립니다.";
			sql_query(" insert {$g5['apms_shingo']} set bo_table = '$bo_table', wr_id = '$wr_id', wr_parent = '{$write['wr_comment']}', mb_id = '@shingo', datetime = '".G5_TIME_YMDHIS."', ip = '{$_SERVER['REMOTE_ADDR']}', flag = '1' ");
		}

		$success = "이 글을 신고하셨습니다.";
	}
}

// 회원 아이디와 메세지가 있으면 쪽지 보냄
if($write['mb_id'] && $send_msg) {
	$recv_id = $write['mb_id']; // 받는 사람 아이디
    $send_id = $config['cf_admin']; // 보내는 사람

	//쪽지 번호 뽑기
    $tmp_row = sql_fetch(" select max(me_id) as max_me_id from {$g5['memo_table']} ");
    $me_id = $tmp_row['max_me_id'] + 1;
        
	// 쪽지 INSERT
    $sql = " insert into {$g5['memo_table']} ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo ) values ( '$me_id', '$recv_id', '$send_id', '".G5_TIME_YMDHIS."', '$send_msg' ) ";
    sql_query($sql);
}

apms_return($success);

?>