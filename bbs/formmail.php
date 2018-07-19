<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if (!$config['cf_email_use'])
    alert_close('환경설정에서 \"메일발송 사용\"에 체크하셔야 메일을 발송할 수 있습니다.\\n\\n관리자에게 문의하시기 바랍니다.');

if (!$is_member && $config['cf_formmail_is_member'])
    alert_close('회원만 이용하실 수 있습니다.');

if ($is_member && !$member['mb_open'] && $is_admin != "super" && $member['mb_id'] != $mb_id)
    alert_close('자신의 정보를 공개하지 않으면 다른분에게 메일을 보낼 수 없습니다.\\n\\n정보공개 설정은 회원정보수정에서 하실 수 있습니다.');

$photo = '';
if ($mb_id) {
    $mb = get_member($mb_id);
    if (!$mb['mb_id'])
        alert_close('회원정보가 존재하지 않습니다.\\n\\n탈퇴한 회원일 수 있습니다.');

    if (!$mb['mb_open'] && $is_admin != "super")
        alert_close('정보공개를 하지 않았습니다.');

	$photo = apms_photo_url($mb_id);
}

$sendmail_count = (int)get_session('ss_sendmail_count') + 1;
if ($sendmail_count > 3)
    alert_close('한번 접속후 일정수의 메일만 발송할 수 있습니다.\\n\\n계속해서 메일을 보내시려면 다시 로그인 또는 접속하여 주십시오.');

$email_enc = new str_encrypt();
$email_dec = $email_enc->decrypt($email);

$email = get_email_address($email_dec);
if(!$email)
    alert_close('이메일이 올바르지 않습니다.');

$email = $email_enc->encrypt($email);

if (!$name)
    $name = $email;
else
    $name = get_text(stripslashes($name), true);

if (!isset($type))
    $type = 0;

$type_checked[0] = $type_checked[1] = $type_checked[2] = "";
$type_checked[$type] = 'checked';

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_mail_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = '메일 쓰기';

if($is_mail_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/formmail.skin.php');

if($is_mail_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>