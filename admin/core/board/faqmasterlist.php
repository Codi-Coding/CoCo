<?php
$sub_menu = '300700';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$sql_common = " from {$g5['faq_master_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "select * $sql_common order by fm_order, fm_id limit $from_record, {$config['cf_page_rows']} ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $sql1 = " select COUNT(*) as cnt from {$g5['faq_table']} where fm_id = '{$row['fm_id']}' ";
    $row1 = sql_fetch($sql1);
    $cnt = $row1['cnt'];
    
    $faqmaster_list[$i] = $row;
    $faqmaster_list[$i]['cnt'] = $cnt;
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=board&amp;pid=faqmasterlist&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'faqmaster_list' => $faqmaster_list,
));