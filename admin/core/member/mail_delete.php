<?php
$sub_menu = '200300';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

check_demo();

auth_check($auth[$sub_menu], 'd');

check_admin_token();

$count = count($_POST['chk']);

if(!$count)
    alert('삭제할 메일목록을 1개이상 선택해 주세요.');

for($i=0; $i<$count; $i++) {
    $ma_id = $_POST['chk'][$i];

    $sql = " delete from {$g5['mail_table']} where ma_id = '$ma_id' ";
    sql_query($sql);
}

 alert('선택한 회원용 발송 메일을 삭제하였습니다.', EYOOM_ADMIN_URL.'/?dir=member&pid=mail_list');