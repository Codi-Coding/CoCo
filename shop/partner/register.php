<?php
include_once('./_common.php');

if($is_guest) {
	alert('회원만 이용가능합니다.', APMS_PARTNER_URL.'/login.php');
}

$is_seller = (isset($apms['apms_partner']) && $apms['apms_partner']) ? true : false;
$is_marketer = (isset($apms['apms_marketer']) && $apms['apms_marketer']) ? true : false;
$is_company = (isset($apms['apms_company']) && $apms['apms_company']) ? true : false;
$is_personal = (isset($apms['apms_personal']) && $apms['apms_personal']) ? true : false;

if(!$is_seller && !$is_marketer) {
	alert('지금은 파트너 등록을 받지 않습니다.', G5_URL);
}

if(!$is_company && !$is_personal) {
	alert('지금은 파트너 등록을 받지 않습니다.', G5_URL);
}

$upload_max_filesize = number_format($default['pt_upload_size']) . ' 바이트';

$partner = array();
$partner = apms_partner($member['mb_id']);

if($partner['pt_id']) { //파트너 정보가 있으면

	if(!$partner['pt_register']) { // 등록심사중이면
		alert('회원님은 현재 등록심사 중입니다.', G5_URL);
	}

	if($partner['pt_leave']) { // 탈퇴한 회원이면
		alert('회원님은 파트너에서 탈퇴하셨습니다.\\n\\n재등록을 원하시면 관리자에게 문의바랍니다.', G5_URL);
	}

	if(!$partner['pt_partner'] && !$partner['pt_marketer']) { // 권한해제 회원이면
		alert('회원님은 파트너 권한이 해제된 상태입니다.\\n\\n권한 재등록을 원하시면 관리자에게 문의바랍니다.', G5_URL);
	}

	alert('회원님은 파트너로 등록되신 분입니다.\\n\\n파트너 페이지로 이동합니다.', APMS_PARTNER_URL);
}

// 파트너 등록
if(!$is_admin) {
	$register_no_msg = '';
	if($apms['apms_email_yes'] && !$member['mb_email_certify']) {
		$register_no_msg .= '이메일인증';
	}
	if($apms['apms_cert_yes'] && !$member['mb_certify']) {
		if($register_no_msg) $register_no_msg .= ', ';
		$register_no_msg .= '본인인증';
	}
	if($apms['apms_adult_yes'] && !$member['mb_adult']) {
		if($register_no_msg) $register_no_msg .= ', ';
		$register_no_msg .= '성인인증';
	}

	if($register_no_msg) {
		alert($register_no_msg.' 회원만 파트너 등록이 가능합니다.\\n\\n정보수정에서 인증 후 등록할 수 있습니다.', G5_BBS_URL.'/member_confirm.php?url=register_form.php');
	}
}

$action_url = APMS_PARTNER_HTTPS_URL.'/register.update.php';
$partner_stipulation = get_text($apms['apms_stipulation']);

$g5['title'] = '파트너 신청';
include_once(G5_PATH.'/head.sub.php');
include_once($skin_path.'/register.skin.php');
include_once(G5_PATH.'/tail.sub.php');
?>