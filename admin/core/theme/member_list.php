<?php
$sub_menu = "800800";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');

$action_url1 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=member_list';
$action_url2 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=member_list_update&amp;smode=1';

/**
 * 회원 정보 가져오기
 */
$sql_common = " from {$g5['eyoom_member']} as em left join {$g5['member_table']} as gm on em.mb_id = gm.mb_id ";

$sql_search = " where em.mb_id!='' and gm.mb_id != '{$config['cf_admin']}' ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'gm.mb_point' :
        case 'em.level_point' :
            $sql_search .= " ({$sfl} >= '{$stx}') ";
            break;
        case 'gm.mb_level' :
        case 'em.level' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "gm.mb_datetime";
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

for ($i=0; $row=sql_fetch_array($result); $i++) {
	if(!$row['mb_id']) continue;

	$member_list[$i] = $row;

	/**
	 * 회원 레벨을 select 형식으로 변환
	 */
	$mb_level = get_member_level_select("mb_level[$i]", 1, $levelset['max_use_gnu_level'], $row['mb_level']);
	$member_list[$i]['mb_select_level'] = preg_replace("/(\\n|\\r)/","",str_replace('"', "'", $mb_level));
	
	$member_list[$i]['photo_url'] = mb_photo_url($row['mb_id']);
}

/*
 * Paging 
 */
$paging = $thema->pg_pages($tpl_name,"./?dir=theme&amp;pid=member_list&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'member_list' => $member_list,
	'levelset' => $levelset,
));