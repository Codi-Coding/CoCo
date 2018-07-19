<?php
include_once('./_common.php');

if (!$is_member) {
	if($move) {
		alert("회원만 이용이 가능합니다.");
	} else {
		alert_close("회원만 이용이 가능합니다.");
	}
}

$iq_id = (int)trim($_REQUEST['iq_id']);
$iq_subject = trim($_POST['iq_subject']);
$iq_question = trim($_POST['iq_question']);
$iq_question = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $iq_question);
$iq_answer = trim($_POST['iq_answer']);
$hash = trim($_REQUEST['hash']);

if ($w == "" || $w == "u") {
    $iq_name     = addslashes(strip_tags($member['mb_nick'])); //별명으로 변경
    $iq_password = $member['mb_password'];

    if (!$iq_subject) alert("제목을 입력하여 주십시오.");
    if (!$iq_question) alert("질문을 입력하여 주십시오.");
}

if ($w == "") {

	//APMS : 파트너 정보 등록 - 2014.07.21
	$it = apms_it($it_id);

	$sql = "insert {$g5['g5_shop_item_qa_table']}
               set it_id = '$it_id',
                   mb_id = '{$member['mb_id']}',
                   iq_secret = '$iq_secret',
                   iq_name  = '$iq_name',
                   iq_email = '$iq_email',
                   iq_hp = '$iq_hp',
                   iq_password  = '$iq_password',
                   iq_subject  = '$iq_subject',
                   iq_question = '$iq_question',
                   iq_time = '".G5_TIME_YMDHIS."',
				   pt_it = '{$it['pt_it']}',
                   pt_id = '{$it['pt_id']}',
				   iq_ip = '$REMOTE_ADDR' "; // APMS - 2014.07.21
    sql_query($sql);

    //$alert_msg = '등록 되었습니다.';

    $iq_id = sql_insert_id();

	// 내글반응	등록
	$it['pt_id'] = ($it['pt_id']) ? $it['pt_id'] : $config['cf_admin']; // 파트너 없으면 최고관리자에게 보냄
	apms_response('it', 'qa', $it_id, '', $iq_id, $iq_subject, $it['pt_id'], $member['mb_id'], $iq_name);

	// 상품의 질답 증가
	sql_query(" update {$g5['g5_shop_item_table']} set pt_qa = pt_qa + 1 where it_id = '{$it_id}' ", false);

} else if ($w == "u") {

    if (!$is_admin) {
        $sql = " select count(*) as cnt from {$g5['g5_shop_item_qa_table']} where mb_id = '{$member['mb_id']}' and iq_id = '$iq_id' ";
        $row = sql_fetch($sql);
        if (!$row['cnt'])
            alert("자신의 글만 수정하실 수 있습니다.");
    }

    $sql = " update {$g5['g5_shop_item_qa_table']}
                set iq_secret = '$iq_secret',
                    iq_email = '$iq_email',
                    iq_hp = '$iq_hp',
                    iq_subject = '$iq_subject',
                    iq_question = '$iq_question'
              where iq_id = '$iq_id' ";
    sql_query($sql);

    //$alert_msg = '수정 되었습니다.';

} else if ($w == "d") {

	$row = sql_fetch(" select it_id, mb_id, iq_question, iq_answer from {$g5['g5_shop_item_qa_table']} where iq_id = '$iq_id' and md5(concat(iq_id,iq_time,iq_ip)) = '{$hash}' ");

	if (!$is_admin) {
		if($move) {
			if ($member['mb_id'] != $row['mb_id'])
				alert("자신의 글만 삭제하실 수 있습니다.");

			if ($row['iq_answer'])
				alert("답변이 있는 글은 삭제하실 수 없습니다.");
		} else {
			if ($member['mb_id'] != $row['mb_id'])
				apms_alert("1|자신의 글만 삭제하실 수 있습니다.");

			if ($row['iq_answer'])
				apms_alert("1|답변이 있는 글은 삭제하실 수 없습니다.");
		}
	}

	// 에디터로 첨부된 이미지 삭제
	apms_editor_image($row['iq_question'], 'del');
	apms_editor_image($row['iq_answer'], 'del');

	// 삭제
	sql_query(" delete from {$g5['g5_shop_item_qa_table']} where iq_id = '$iq_id' and md5(concat(iq_id,iq_time,iq_ip)) = '{$hash}' ");

	// 상품의 질답 감소
	sql_query(" update {$g5['g5_shop_item_table']} set pt_qa = pt_qa - 1 where it_id = '{$row['it_id']}' ", false);

	//$alert_msg = '0|삭제 하셨습니다.';
}

if($move) {
	if($move == "1") { //아이템으로
		goto_url('./item.php?it_id='.$it_id.'&ca_id='.$ca_id.'#itemqa');
	} else if($move == "3") { //내용으로
		goto_url('./itemqaview.php?iq_id='.$iq_id.'&ca_id='.$ca_id.'&page='.$page);
	} else { //목록으로
		goto_url('./itemqalist.php?page='.$page);
	}
} else {
	if($w == 'd') {
		apms_alert($alert_msg);
	} else {
		apms_opener('itemqa', $alert_msg, './itemqa.php?it_id='.$it_id.'&ca_id='.$ca_id.'&qrows='.$qrows.'&page='.$page);
	}
}
?>
