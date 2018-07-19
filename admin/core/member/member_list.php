<?php
$sub_menu = "200100";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

$action_url = EYOOM_ADMIN_URL . '/?dir=member&amp;pid=member_list_update&amp;smode=1';

$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_point' :
            $sql_search .= " ({$sfl} >= '{$stx}') ";
            break;
        case 'mb_level' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'mb_tel' :
        case 'mb_hp' :
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if ($is_admin != 'super')
    $sql_search .= " and mb_level <= '{$member['mb_level']}' ";

if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

if ($wmode) $qstr .= "&amp;wmode=1";

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {

    $leave_date = $row['mb_leave_date'] ? $row['mb_leave_date'] : date('Ymd', G5_SERVER_TIME);
    $intercept_date = $row['mb_intercept_date'] ? $row['mb_intercept_date'] : date('Ymd', G5_SERVER_TIME);

    $mb_nick = get_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);

    $mb_id = $row['mb_id'];
    $leave_msg = '';
    $intercept_msg = '';
    $intercept_title = '';
    if ($row['mb_leave_date']) {
        $mb_id = $mb_id;
        $leave_msg = "<span class='mb_leave_msg color-red'>탈퇴함</span>";
    }
    else if ($row['mb_intercept_date']) {
        $mb_id = $mb_id;
        $intercept_msg = "<span class='mb_intercept_msg color-orange'>차단됨</span>";
        $intercept_title = '차단해제';
    }
    if ($intercept_title == '')
        $intercept_title = '차단하기';

    if ($leave_msg || $intercept_msg) {
	    $row['mb_status'] = $leave_msg.' '.$intercept_msg;
    } else if(preg_match('#^[0-9]{8}.*삭제함#', $row['mb_memo'])) {
	    $row['mb_status'] = "<span class='mb_delete_msg color-yellow'>삭제</span>";
    } else {
	    $row['mb_status'] = "정상";
    }

    switch($row['mb_certify']) {
        case 'hp':
            $mb_certify_case = '휴대폰';
            $mb_certify_val = 'hp';
            break;
        case 'ipin':
            $mb_certify_case = '아이핀';
            $mb_certify_val = '';
            break;
        case 'admin':
            $mb_certify_case = '관리자';
            $mb_certify_val = 'admin';
            break;
        default:
            $mb_certify_case = '&nbsp;';
            $mb_certify_val = 'admin';
            break;
    }
    $mb_level = get_member_level_select("mb_level[$i]", 1, $member['mb_level'], $row['mb_level']);
	
	$list[$i] = $row;
	
	$list[$i]['mb_level'] = preg_replace("/(\\n|\\r)/","",str_replace('"', "'", $mb_level));
    if (preg_match('/[1-9]/', $row['mb_email_certify']) ) {
	    $list[$i]['email_certify'] = 'Yes';
    } else {
	    $list[$i]['email_certify'] = 'No';
    }

    $list[$i]['bg'] = 'bg'.($i%2);
    $list[$i]['photo_url'] = mb_photo_url($row['mb_id']);
    
	$list_num = $total_count - ($page - 1) * $rows;
    $list[$i]['num'] = $list_num - $k;
    $k++;
}

// Paging 
$paging = $thema->pg_pages($tpl_name, EYOOM_ADMIN_URL . "/?dir=member&amp;pid=member_list&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";