<?php
include_once('./_common.php');

if (!$member['mb_id'])
    alert(_t('회원만 접근하실 수 있습니다.'));

if ($is_admin == 'super')
    alert(_t('최고 관리자는 탈퇴할 수 없습니다'));

if (!($_POST['mb_password'] && check_password($_POST['mb_password'], $member['mb_password'])))
    alert(_t('비밀번호가 틀립니다.'));

// 회원탈퇴일을 저장
$date = date("Ymd");
$sql = " update {$g5['member_table']} set mb_leave_date = '{$date}' where mb_id = '{$member['mb_id']}' ";
sql_query($sql);

// 3.09 수정 (로그아웃)
unset($_SESSION['ss_mb_id']);

if (!$url)
    $url = G5_URL;

//소셜로그인 해제
if(function_exists('social_member_link_delete')){
    social_member_link_delete($member['mb_id']);
}

alert(''.$member['mb_nick']._t('님께서는').' '. date("Y"._t("년")." m"._t("월")." d"._t("일")) ._t('에 회원에서 탈퇴 하셨습니다.'), $url);
?>
