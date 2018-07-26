<?php
include_once('./_common.php');

if($is_guest) {
	alert('파트너만 이용가능합니다.', APMS_PARTNER_URL.'/login.php');
}

$is_auth = ($is_admin == 'super') ? true : false;
$is_partner = (IS_SELLER) ? true : false;

if($is_auth || $is_partner) {
	; // 통과
} else {
	alert('판매자(셀러) 파트너만 이용가능합니다.', APMS_PARTNER_URL);
}

if (!$iq_answer) 
	alert('답변을 입력하여 주십시오.');

$qa_sql = '';
if ($is_auth) {
	$qa_sql .= " and (pt_id = '' or pt_id = '{$member['mb_id']}')";
} else {
	$qa_sql .= " and pt_id = '{$member['mb_id']}'";
}

$sql = " select * from {$g5['g5_shop_item_qa_table']} where iq_id = '$iq_id' $qa_sql ";
$iq = sql_fetch($sql);

if (!$iq['iq_id']) 
	alert('등록된 자료가 없습니다.', './?ap=qalist');

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

		mailer($config['cf_title'], $config['cf_admin_email'], $row['iq_email'], $subject, $content, 1);
	}
}

goto_url('./?ap=qaform&amp;iq_id='.$iq_id.'&amp;sca='.$sca.'&amp;save_opt='.$opt.'&amp;opt='.$opt.'&amp;page='.$page);

?>