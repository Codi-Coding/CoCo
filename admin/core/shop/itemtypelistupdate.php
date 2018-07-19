<?php
$sub_menu = '400610';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

check_demo();

auth_check($auth[$sub_menu], "w");

check_admin_token();

for ($i=0; $i<count($_POST['it_id']); $i++)
{
    $sql = "update {$g5['g5_shop_item_table']}
               set it_type1 = '{$_POST['it_type1'][$i]}',
                   it_type2 = '{$_POST['it_type2'][$i]}',
                   it_type3 = '{$_POST['it_type3'][$i]}',
                   it_type4 = '{$_POST['it_type4'][$i]}',
                   it_type5 = '{$_POST['it_type5'][$i]}'
             where it_id = '{$_POST['it_id'][$i]}' ";
    sql_query($sql);
}

goto_url(EYOOM_ADMIN_URL . "/?dir=shop&amp;pid=itemtypelist&amp;sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>
