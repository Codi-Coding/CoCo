<?php
$sub_menu = "300100";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

$action_url = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=board_list_update&amp;smode=1';

// 게시판 여유필드 확장수 저장 필드 추가
if(!sql_query(" select bo_ex_cnt from {$g5['board_table']} limit 1 ", false)) {
	$sql = " alter table `{$g5['board_table']}` add `bo_ex_cnt` int(5) NOT NULL default '0' after `bo_sort_field` ";
	sql_query($sql, true);
}

$sql_common = " from {$g5['board_table']} a ";
$sql_search = " where (1) ";

if ($is_admin != "super") {
    $sql_common .= " , {$g5['group_table']} b ";
    $sql_search .= " and (a.gr_id = b.gr_id and b.gr_admin = '{$member['mb_id']}') ";
}

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.gr_id, a.bo_table";
    $sod = "asc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $board_list[$i] = $row;
    $gr_select = str_replace('"', "'", get_group_select("gr_id[$i]", $row['gr_id']));
    $board_list[$i]['gr_select'] = preg_replace("/\\n/", "", $gr_select);
    
    $skin_select = str_replace('"', "'", get_skin_select('board', 'bo_skin_'.$i, "bo_skin[$i]", $row['bo_skin']));
    $board_list[$i]['skin_select'] = preg_replace("/\\n/", "", $skin_select);
    
    $mobile_skin_select = str_replace('"', "'", get_mobile_skin_select('board', 'bo_mobile_skin_'.$i, "bo_mobile_skin[$i]", $row['bo_mobile_skin']));
    $board_list[$i]['mobile_skin_select'] = preg_replace("/\\n/", "", $mobile_skin_select);
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=board&amp;pid=board_list&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'board_list' => $board_list,
));