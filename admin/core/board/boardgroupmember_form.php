<?php
$sub_menu = "300200";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$action_url = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=boardgroupmember_update&amp;smode=1';

$mb = get_member($mb_id);
if (!$mb['mb_id'])
    alert('존재하지 않는 회원입니다.');
    
$sql = " select *
            from {$g5['group_table']}
            where gr_use_access = 1 ";
//if ($is_admin == 'group') {
if ($is_admin != 'super')
    $sql .= " and gr_admin = '{$member['mb_id']}' ";
$sql .= " order by gr_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$group[$i] = $row;
}

$sql = " select * from {$g5['group_member_table']} a, {$g5['group_table']} b
            where a.mb_id = '{$mb['mb_id']}'
            and a.gr_id = b.gr_id ";
if ($is_admin != 'super')
    $sql .= " and b.gr_admin = '{$member['mb_id']}' ";
$sql .= " order by a.gr_id desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$group_member[$i] = $row;
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'mb' => $mb,
	'group' => $group,
	'group_member' => $group_member,
));
