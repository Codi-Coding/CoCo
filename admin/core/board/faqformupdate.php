<?php
$sub_menu = '300700';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

if ($w == "u" || $w == "d")
    check_demo();

if ($W == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

$sql_common = " fa_subject = '$fa_subject',
                fa_content = '$fa_content',
                fa_order = '$fa_order' ";

if ($w == "")
{
    $sql = " insert {$g5['faq_table']}
                set fm_id ='$fm_id',
                    $sql_common ";
    sql_query($sql);

    $fa_id = sql_insert_id();
    $msg = "FAQ 상세내용을 추가하였습니다.";
}
else if ($w == "u")
{
    $sql = " update {$g5['faq_table']}
                set $sql_common
              where fa_id = '$fa_id' ";
    sql_query($sql);
    
    $msg = "FAQ 상세내용을 수정하였습니다.";
}
else if ($w == "d")
{
	$sql = " delete from {$g5['faq_table']} where fa_id = '$fa_id' ";
    sql_query($sql);
    
    $msg = "FAQ 상세내용을 삭제하였습니다.";
}

if ($w == 'd')
    alert($msg, EYOOM_ADMIN_URL . "/?dir=board&amp;pid=faqlist&amp;fm_id=$fm_id");
else
    alert($msg, EYOOM_ADMIN_URL . "/?dir=board&amp;pid=faqform&amp;w=u&amp;fm_id=$fm_id&amp;fa_id=$fa_id");
?>
