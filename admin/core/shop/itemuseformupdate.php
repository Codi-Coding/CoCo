<?php
$sub_menu = '400650';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

if ($w == "u")
{
    $sql = "update {$g5['g5_shop_item_use_table']}
               set is_subject = '$is_subject',
                   is_content = '$is_content',
                   is_confirm = '$is_confirm'
             where is_id = '$is_id' ";
    sql_query($sql);

    update_use_cnt($_POST['it_id']);

    alert("적용하였습니다.", EYOOM_ADMIN_URL . "/?dir=shop&amp;pid=itemuseform&amp;w=u&amp;is_id={$is_id}&amp;sca={$sca}&amp;{$qstr}");
}
else
{
    alert();
}
?>
