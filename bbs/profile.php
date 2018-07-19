<?php
include_once('./_common.php');

if (!$member['mb_id'])
    alert_close('회원만 이용하실 수 있습니다.');

if (!$member['mb_open'] && $is_admin != 'super' && $member['mb_id'] != $mb_id)
    alert_close('자신의 정보를 공개하지 않으면 다른분의 정보를 조회할 수 없습니다.\\n\\n정보공개 설정은 회원정보수정에서 하실 수 있습니다.');

$mb = apms_member($mb_id);
if (!$mb['mb_id'])
    alert_close('회원정보가 존재하지 않습니다.\\n\\n탈퇴하였을 수 있습니다.');

if (!$mb['mb_open'] && $is_admin != 'super' && $member['mb_id'] != $mb_id)
    alert_close('정보공개를 하지 않았습니다.');

$mb_nick = apms_sideview($mb['mb_id'], get_text($mb['mb_nick']), $mb['mb_email'], $mb['mb_homepage'], $mb['as_level']);

// 회원가입후 몇일째인지? + 1 은 당일을 포함한다는 뜻
$sql = " select (TO_DAYS('".G5_TIME_YMDHIS."') - TO_DAYS('{$mb['mb_datetime']}') + 1) as days ";
$row = sql_fetch($sql);
$mb_reg_after = $row['days'];

$mb_homepage = set_http(get_text(clean_xss_tags($mb['mb_homepage'])));
$mb_profile = ($mb['mb_profile']) ? conv_content($mb['mb_profile'],0) : '';
$mb_signature = ($mb['mb_signature']) ? apms_content(conv_content($mb['mb_signature'], 1)) : '';

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_profile_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = get_text($mb['mb_nick']).'님의 자기소개';

if($is_profile_sub) {
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

include_once($skin_path.'/profile.skin.php');

if($is_profile_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>