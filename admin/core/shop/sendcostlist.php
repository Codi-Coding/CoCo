<?php
$sub_menu = '400750';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$action_url = EYOOM_ADMIN_URL . '/?dir=shop&amp;pid=sendcostupdate&amp;smode=1';

$sql_common = " from {$g5['g5_shop_sendcost_table']} ";

$sql_search = " where (1) ";
$sql_order = " order by sc_id desc ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

for($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
}

$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">';
$frm_submit .= '</div>';

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=shop&amp;pid=sendcostlist&amp;".$qstr."&amp;page=");

$atpl->assign(array(
	'frm_submit' => $frm_submit,
));

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";