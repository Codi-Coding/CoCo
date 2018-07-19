<?php
$sub_menu = "800700";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url1 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=tag_list';
$action_url2 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=tag_list_update&amp;smode=1';

/**
 * 태그 테이블에서 태그 레코드 정보 가져오기
 */
$sql_common = " from {$g5['eyoom_tag']} ";

$sql_search = " where (1) and tg_theme = '{$this_theme}' ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'tg_word' 	:
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "tg_regdt";
    $sod = "desc";
    $sdt = "";
} else if($sst != 'tg_regdt') {
	$sdt = ", tg_regdt {$sod}";
}

$sql_order = " order by {$sst} {$sod} {$sdt}";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order}";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows}";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$tag_list[$i] = $row;
}

/**
 * Paging 
 */
$paging = $thema->pg_pages($tpl_name,"./?dir=theme&amp;pid=tag_list&amp;thema={$this_theme}&amp;{$qstr}&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'tag_list' => $tag_list,
	'exist_theme' => $exist_theme,
));