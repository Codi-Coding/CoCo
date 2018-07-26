<?php
include_once('./_common.php');

if($is_guest) {
	alert('로그인해 주세요.', APMS_PARTNER_URL.'/login.php');
}

// 회원정보가공
thema_member();

$is_partner = (IS_PARTNER) ? true : false;

if($is_partner) {
	; // 통과
} else {
	alert('등록된 파트너만 이용할 수 있습니다.', APMS_PARTNER_URL.'/register.php');
}

$is_auth = ($is_admin == 'super') ? true : false;

define('G5_IS_ADMIN', true);

$mb_id = $member['mb_id'];

//파트너 정보
$partner = array();
$partner = apms_partner($mb_id);
$partner['pt_level'] = (isset($partner['pt_level']) && $partner['pt_level'] > 0) ? $partner['pt_level'] : 1;
$plvl = $partner['pt_level'];
$partner['pt_level_benefit'] = (isset($apms['apms_benefit'.$plvl]) && $apms['apms_benefit'.$plvl] > 0) ? $apms['apms_benefit'.$plvl] : 0;

// 파일체크
switch($ap) {
	case 'salelist'		: $skin_file = 'salelist.php'; $chk_access = 1; break;
	case 'saleitem'		: $skin_file = 'saleitem.php'; $chk_access = 1; break;
	case 'cancelitem'	: $skin_file = 'cancelitem.php'; $chk_access = 1; break;
	case 'delivery'		: $skin_file = 'delivery.php'; $chk_access = 1; break;
	case 'sendcost'		: $skin_file = 'sendcost.php'; $chk_access = 1; break;
	case 'paylist'		: $skin_file = 'paylist.php'; $chk_access = 1; break;
	case 'list'			: $skin_file = 'itemlist.php'; $chk_access = 1; break;
	case 'item'			: $skin_file = 'itemform.php'; $chk_access = 1; break;
	case 'comment'		: $skin_file = 'comment.php'; $chk_access = 1; break;
	case 'qalist'		: $skin_file = 'qalist.php'; $chk_access = 1; break;
	case 'qaform'		: $skin_file = 'qaform.php'; $chk_access = 1; break;
	case 'uselist'		: $skin_file = 'uselist.php'; $chk_access = 1; break;
	case 'useform'		: $skin_file = 'useform.php'; $chk_access = 1; break;
	case 'mitem'		: $skin_file = 'mkt.item.php'; $chk_access = 2; break;
	case 'mlist'		: $skin_file = 'mkt.list.php'; $chk_access = 2; break;
	case 'mitemlist'	: $skin_file = 'mkt.itemlist.php'; $chk_access = 2; break;
	case 'mcancelitem'	: $skin_file = 'mkt.cancelitem.php'; $chk_access = 2; break;
	case 'mpaylist'		: $skin_file = 'mkt.paylist.php'; $chk_access = 2; break;
	default				: $skin_file = 'dashboard.php'; break;
}

//if(!$is_admin) {
	if(!IS_SELLER && $chk_access == "1") {
		alert('판매자(셀러) 파트너만 이용할 수 있습니다.', APMS_PARTNER_URL);
	}
	if(!IS_MARKETER && $chk_access == "2") {
		alert('추천인(마케터) 파트너만 이용할 수 있습니다.', APMS_PARTNER_URL);
	}
//}

//분류사용권한
$is_cauth = false;
if($is_auth) {
	$is_cauth = true;
} else {
    $row = sql_fetch(" select * from {$g5['auth_table']} where mb_id = '{$member['mb_id']}' and as_menu = '400300' ", false);
	if($row['r'] == 'r' || $row['w'] == 'w') {
		$is_cauth = true;
	}
}

include_once(G5_PATH.'/head.sub.php'); 
include_once($skin_path.'/_head.php');
include_once('./'.$skin_file);
include_once($skin_path.'/_tail.php');
include_once(G5_PATH.'/tail.sub.php'); 

?>
