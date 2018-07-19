<?php
$sub_menu = '300700';
if (!defined('_EYOOM_IS_ADMIN_')) exit;
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$action_url = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=faqformupdate&amp;smode=1';

$sql = " select * from {$g5['faq_master_table']} where fm_id = '$fm_id' ";
$fm = sql_fetch($sql);

if ($w == "u")
{
    $html_title .= " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['faq_table']} where fa_id = '$fa_id' ";
    $fa = sql_fetch($sql);
    if (!$fa['fa_id']) alert("등록된 자료가 없습니다.");
}
else
    $html_title .= ' 항목 입력';


include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'fm' => $fm,
	'fa' => $fa,
));