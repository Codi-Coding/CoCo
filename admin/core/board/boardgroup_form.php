<?php
$sub_menu = "300200";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super' && $w == '') alert('최고관리자만 접근 가능합니다.');

$action_url = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=boardgroup_form_update&amp;smode=1';

$gr_id_attr = '';
$sound_only = '';
if ($w == '') {
    $gr_id_attr = 'required';
    $sound_only = '<strong class="sound_only"> 필수</strong>';
    $gr['gr_use_access'] = 0;
    $html_title .= ' 생성';
} else if ($w == 'u') {
    $gr_id_attr = 'readonly';
    $gr = sql_fetch(" select * from {$g5['group_table']} where gr_id = '$gr_id' ");
    $html_title .= ' 수정';
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');
    
$sql1 = " select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$gr_id}' ";
$row1 = sql_fetch($sql1);
$grmember_cnt = $row1['cnt'];

for ($i=1; $i<=10; $i++) {
	$gr_extra[$i]['gr_subject']	= $group['gr_' . $i . '_subj'];
	$gr_extra[$i]['gr_value'] 	= $group['gr_' . $i];
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'gr' => $gr,
	'gr_extra' => $gr_extra,
));