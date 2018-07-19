<?php
$sub_menu = "200200";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$mb_id = $_POST['mb_id'];
$po_point = $_POST['po_point'];
$po_content = $_POST['po_content'];
$po_all = $_POST['po_all'];
$expire = preg_replace('/[^0-9]/', '', $_POST['po_expire_term']);

if ($po_all == 'y') {
	if ($mb_id != $config['cf_admin']) {
		alert("전체 회원에게 적용할 경우, 반드시 회원아이디는 최고관리자 아이디여야 합니다.");	
	} else {
		$sql = "select mb_id, mb_point from {$g5['member_table']} where mb_leave_date = '' and mb_intercept_date = '' and mb_id <> '{$config['cf_admin']}' ";
		$res = sql_query($sql, false);
		for ($i=0; $row=sql_fetch_array($res); $i++) {
			$mb = $row;
			
			insert_point($mb['mb_id'], $po_point, $po_content, '@passive', $mb['mb_id'], $mb_id.'-'.uniqid('').'-'.$i, $expire);
		}
		
		alert("포인트 내역을 총 {$i}명에게 적용하였습니다.", EYOOM_ADMIN_URL . '/?dir=member&pid=point_list&'.$qstr);
		
	}
} else {
	
	$mb = get_member($mb_id);
	
	if (!$mb['mb_id'])
	    alert('존재하는 회원아이디가 아닙니다.', './point_list.php?'.$qstr);
	
	if (($po_point < 0) && ($po_point * (-1) > $mb['mb_point']))
	    alert('포인트를 깎는 경우 현재 포인트보다 작으면 안됩니다.', './point_list.php?'.$qstr);
	
	insert_point($mb_id, $po_point, $po_content, '@passive', $mb_id, $member['mb_id'].'-'.uniqid(''), $expire);
	
	alert("포인트 내역을 적용하였습니다.", EYOOM_ADMIN_URL . '/?dir=member&pid=point_list&'.$qstr);
}