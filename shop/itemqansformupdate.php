<?php
include_once('./_common.php');

if($is_guest) {
	if($move) {
		alert('회원만 이용가능합니다.');
	} else {
		alert_close('회원만 이용가능합니다.');
	}
}

$iq = sql_fetch(" select * from {$g5['g5_shop_item_qa_table']} where iq_id = '$iq_id' ");
if (!$iq['iq_id']) {
	if($move) {
		alert("등록된 자료가 없습니다.");
	} else {
		alert_close("등록된 자료가 없습니다.");
	}
}

$it_id = $iq['it_id'];

// 상품정보체크
$sql = " select it_id, ca_id, pt_id from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$row = sql_fetch($sql);
if(!$row['it_id']) {
	if($move) {
		alert("자료가 존재하지 않습니다.");
	} else {
		alert_close("자료가 존재하지 않습니다.");
	}
}

if (!$is_admin && $row['pt_id'] != $member['mb_id']) {
	if($move) {
		alert("자신이 등록한 상품의 문의글에 대한 답글만 가능합니다.");
	} else {
		alert_close("자신이 등록한 상품의 문의글에 대한 답글만 가능합니다.");
	}
}

if (!$iq_answer) {
	alert("답변을 입력하여 주십시오.");
}

// 답변등록
$sql = "update {$g5['g5_shop_item_qa_table']} set iq_answer = '$iq_answer' where iq_id = '$iq_id' ";
sql_query($sql);

if(!$iq['iq_answer'] && trim($iq_answer)) {
	$sql = " select a.mb_id, a.iq_email, a.iq_hp, b.it_name
				from {$g5['g5_shop_item_qa_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
				where a.iq_id = '$iq_id' ";
	$row = sql_fetch($sql);

	// 내글반응	등록
	apms_response('it', 'reply', $iq['it_id'], '', $iq_id, get_text($iq['iq_subject']), $row['mb_id'], $member['mb_id'], $member['mb_nick']);

	// SMS 알림
	if($config['cf_sms_use'] == 'icode' && $row['iq_hp']) {
		include_once(G5_LIB_PATH.'/icode.sms.lib.php');

		$sms_content = get_text($row['it_name']).' 문의에 답변이 등록되었습니다.';
		$send_number = preg_replace('/[^0-9]/', '', $default['de_admin_company_tel']);
		$recv_number = preg_replace('/[^0-9]/', '', $row['iq_hp']);

		if($recv_number) {
			$SMS = new SMS; // SMS 연결
			$SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);
			$SMS->Add($recv_number, $send_number, $config['cf_icode_id'], iconv("utf-8", "euc-kr", stripslashes($sms_content)), "");
			$SMS->Send();
		}
	}

	// 답변 이메일전송
	if(trim($row['iq_email'])) {
		include_once(G5_LIB_PATH.'/mailer.lib.php');

		$subject = $config['cf_title'].' '.$row['it_name'].' 문의 답변 알림 메일';
		$content = conv_content($iq_answer, 1);

		// 파트너 아이디가 있을 경우 파트너 회원정보의 메일주소로 전송
		if($row['pt_id']) {
			$mb = get_member($row['pt_id'], 'mb_email');
			if($mb['mb_email']) {
				$config['cf_admin_email'] = $mb['mb_email'];
			}
		}

		mailer($config['cf_title'], $config['cf_admin_email'], $row['iq_email'], $subject, $content, 1);
	}
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
	apms_opener('itemqa', $alert_msg, './itemqa.php?it_id='.$it_id.'&ca_id='.$ca_id.'&qrows='.$qrows.'&page='.$page);
}

?>
