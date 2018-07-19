<?php
$sub_menu = "200300";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

if ($w == 'u' || $w == 'd')
    check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

if ($w == '') {
    $sql = " insert {$g5['mail_table']}
                set ma_id = '{$_POST['ma_id']}',
                     ma_subject = '{$_POST['ma_subject']}',
                     ma_content = '{$_POST['ma_content']}',
                     ma_time = '".G5_TIME_YMDHIS."',
                     ma_ip = '{$_SERVER['REMOTE_ADDR']}' ";
    sql_query($sql);
    $msg = "정상적으로 메일을 등록하였습니다.";
} else if ($w == 'u') {
    $sql = " update {$g5['mail_table']}
                set ma_subject = '{$_POST['ma_subject']}',
                     ma_content = '{$_POST['ma_content']}',
                     ma_time = '".G5_TIME_YMDHIS."',
                     ma_ip = '{$_SERVER['REMOTE_ADDR']}'
                where ma_id = '{$_POST['ma_id']}' ";
    sql_query($sql);
    $msg = "메일정보를 수정하였습니다.";
} else if ($w == 'd') {
	$sql = " delete from {$g5['mail_table']} where ma_id = '{$_POST['ma_id']}' ";
    sql_query($sql);
    $msg = "선택한 회원메일을 삭제하였습니다.";
}

alert($msg, EYOOM_ADMIN_URL."/?dir=member&pid=mail_list");