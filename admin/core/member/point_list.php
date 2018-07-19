<?php
$sub_menu = "200200";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

$action_url  = EYOOM_ADMIN_URL . '/?dir=member&amp;pid=point_list_delete&amp;smode=1';
$action_url2 = EYOOM_ADMIN_URL . '/?dir=member&amp;pid=point_update&amp;smode=1';

$sql_common = " from {$g5['point_table']} ";
$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "po_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$mb = array();
if ($sfl == 'mb_id' && $stx)
    $mb = get_member($stx);

$po_expire_term = '';
if($config['cf_point_term'] > 0) {
    $po_expire_term = $config['cf_point_term'];
}

if (strstr($sfl, "mb_id")) $mb_id = $stx;
else  $mb_id = "";

if (!(isset($mb['mb_id']) && $mb['mb_id'])) {
    $row2 = sql_fetch(" select sum(po_point) as sum_point from {$g5['point_table']} ");
    $sum_point = $row2['sum_point'];
}


for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i==0 || ($row2['mb_id'] != $row['mb_id'])) {
        $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
        $row2 = sql_fetch($sql2);
    }

    $expr = '';
    if($row['po_expired'] == 1)
        $expr = ' txt_expired';

    $bg = 'bg'.($i%2);
    
    $point_list[$i] = $row;
    $point_list[$i]['mb_name'] = $row2['mb_name'];
    $point_list[$i]['mb_nick'] = $row2['mb_nick'];
    
    if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table']) {
	    $point_list[$i]['link'] = true;
    }
    
    if ($row['po_expired'] == 1) {
	    $point_list[$i]['expire_date'] = substr(str_replace('-', '', $row['po_expire_date']), 2);
    } else {
	    $point_list[$i]['expire_date'] = $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date'];
    }
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=member&amp;pid=point_list&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'point_list' 		=> $point_list,
));