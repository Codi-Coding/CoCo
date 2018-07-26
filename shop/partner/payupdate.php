<?php
include_once('./_common.php');

if($is_guest) { 
	alert_close('파트너만 이용가능합니다.');
}

if (get_session('pp_payment_id') != $member['mb_id']) {
	alert_close("직접 링크로는 등록이 불가합니다.\\n\\n출금신청 화면을 통하여 이용하시기 바랍니다.");
}

include_once(G5_LIB_PATH.'/apms.account.lib.php');

// APMS Config
$partner = array();
$account = array();
$list = array();

$partner = apms_partner($member['mb_id']);

if($partner['pt_id']) { //파트너 정보가 있으면
	if(!$partner['pt_register']) { // 등록심사중이면
		alert_close('회원님은 현재 등록심사 중입니다.');
	}

	if($partner['pt_leave']) { // 탈퇴한 회원이면
		alert_close('회원님은 파트너에서 탈퇴하셨습니다.\\n\\n재등록을 원하시면 관리자에게 문의바랍니다.');
	}

	if(!$partner['pt_partner'] && !$partner['pt_marketer']) { // 권한해제 회원이면
		alert_close('회원님은 파트너 권한이 해제된 상태입니다.\\n\\n권한 재등록을 원하시면 관리자에게 문의바랍니다.');
	}

} else {
	alert_close('등록된 파트너만 이용가능합니다.');
}

//출금제한
if($partner['pt_bank_limit']) {
	alert_close('회원님은 현재 출금신청이 제한된 상태입니다.');
}

if(!$partner['pt_company']) {
	alert_close('정산정보의 미등록으로 현재 출금신청이 제한된 상태입니다.');
}

if(!$partner['pt_flag']) {
	alert_close('정산방법의 미등록으로 현재 출금신청이 제한된 상태입니다.');
}

if(!$pp_means) { //포인트전환이 아닐경우
	if(!$partner['pt_bank_name'] || !$partner['pt_bank_account'] || !$partner['pt_bank_holder']) {
		//alert_close('입금계좌정보의 미등록으로 현재 출금신청이 제한된 상태입니다.');
	}
}

if($apms['apms_payment_limit']) {
	if($apms['apms_payment_day']) {
		$yoil = array("일","월","화","수","목","금","토");
		$y = date('w', G5_SERVER_TIME);
		$day = 	$yoil[$y];
		$msg = '매주 '.$apms['apms_payment_limit'].'요일만 출금신청이 가능합니다.';
	} else {
		$day = date('d', G5_SERVER_TIME);
		$msg = '매월 '.$apms['apms_payment_limit'].'일만 출금신청이 가능합니다.';
	}

	if (!chk_multiple_admin($day, $apms['apms_payment_limit'])) {
		alert_close($msg);
	}
}

//계정현황
$pp_field = ($pp_field) ? 1 : 0;
$account = apms_balance_sheet($member['mb_id'], $pp_field);

if($account['possible'] > 0) {
	;
} else {
	alert_close('출금가능한 잔액이 없습니다.');
}

if($pp_amount > 0) {
	;
} else {
	alert_close('신청금액은 0보다 큰 양수로 입력하셔야 합니다.');
}

if($pp_amount > $account['possible']) {
	alert_close('출금가능한 잔액보다 큰 금액을 신청하셨습니다.');
}

$str_num = $account['num'] * (-1);
$str = substr(strval($pp_amount), $str_num);
if($str == strval($account['txt'])) {
	;
} else {
	alert_close('신청금액을 '.number_format($account['unit']).'원 단위로 입력해 주세요.');
}

$pp_memo = substr(trim($pp_memo),0,65536);
$pp_memo = preg_replace("#[\\\]+$#", "", $pp_memo);

$sql = " insert into {$g5['apms_payment']}
			set mb_id = '{$member['mb_id']}',
				 pp_company = '{$partner['pt_company']}',
				 pp_type = '{$partner['pt_type']}',
				 pp_means = '$pp_means',
				 pp_flag = '{$partner['pt_flag']}',
				 pp_field = '{$pp_field}',
				 pp_amount = '$pp_amount',
				 pp_datetime = '".G5_TIME_YMDHIS."',
				 pp_ip = '{$_SERVER['REMOTE_ADDR']}',
				 pp_memo = '$pp_memo' ";
sql_query($sql);

// 출금신청 알림쪽지 발송
$msg = $member['mb_nick'].'('.$member['mb_id'].')님이 '.number_format($pp_amount).'원을 출금신청하셨습니다.';
$mb_list = $config['cf_admin'].','.$config['as_admin'];
$mb = array_unique(explode(",", $mb_list));
for($i=0; $i < count($mb); $i++) {
	$tmp_row = sql_fetch(" select max(me_id) as max_me_id from {$g5['memo_table']} ");
	$me_id = $tmp_row['max_me_id'] + 1;

	// 쪽지 INSERT
	sql_query(" insert into {$g5['memo_table']} ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo ) values ( '$me_id', '{$mb[$i]}', '{$config['cf_admin']}', '".G5_TIME_YMDHIS."', '{$msg}' ) ", false);

	// 읽지 않은 쪽지체크
	$tmp_row2 = sql_fetch(" select count(*) as cnt from {$g5['memo_table']} where me_recv_mb_id = '{$mb[$i]}' and me_read_datetime = '0000-00-00 00:00:00' ", false);

	// 실시간 쪽지 알림 기능
	sql_query(" update {$g5['member_table']} set mb_memo_call = '{$config['cf_admin']}', as_memo = '{$tmp_row2['cnt']}' where mb_id = '{$mb[$i]}' ", false);
}

//신청완료
alert_opener('출금신청을 하였습니다.', './?ap='.$ap)

?>