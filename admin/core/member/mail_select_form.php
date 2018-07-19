<?php
$sub_menu = '200300';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

if (!$config['cf_email_use'])
    alert('환경설정에서 \'메일발송 사용\'에 체크하셔야 메일을 발송할 수 있습니다.');
    
auth_check($auth[$sub_menu], 'r');

$action_url = EYOOM_ADMIN_URL . '/?dir=member&amp;pid=mail_select_list';

$sql = " select * from {$g5['mail_table']} where ma_id = '$ma_id' ";
$ma = sql_fetch($sql);
if (!$ma['ma_id'])
    alert('보내실 내용을 선택하여 주십시오.');

// 전체회원수
$sql = " select COUNT(*) as cnt from {$g5['member_table']} ";
$row = sql_fetch($sql);
$tot_cnt = $row['cnt'];

// 탈퇴대기회원수
$sql = " select COUNT(*) as cnt from {$g5['member_table']} where mb_leave_date <> '' ";
$row = sql_fetch($sql);
$finish_cnt = $row['cnt'];

$last_option = explode('||', $ma['ma_last_option']);
for ($i=0; $i<count($last_option); $i++) {
    $option = explode('=', $last_option[$i]);
    // 동적변수
    $var = $option[0];
    $$var = $option[1];
}

if (!isset($mb_id1)) $mb_id1 = 1;
if (!isset($mb_level_from)) $mb_level_from = 1;
if (!isset($mb_level_to)) $mb_level_to = 10;
if (!isset($mb_mailling)) $mb_mailling = 1;

$sql = " select gr_id, gr_subject from {$g5['group_table']} order by gr_subject ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$gr_list[$i] = $row;
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'gr_list' => $gr_list,
));