<?php // 굿빌더 ?>
<?php
$sub_menu = "350501";
include_once "./_common.php";
check_demo();
auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if(0) { ///
if ($member['mb_password'] != sql_password($_POST['admin_password'])) {
    alert("패스워드가 다릅니다.");
}
} ///

$mb = get_member($cf_admin);
check_token();

$sql = " update $g5[config2w_m_table]
            set 
                cf_search               = '{$_POST['cf_search']}',
                cf_menu_style           = '{$_POST['cf_menu_style']}',
                cf_main_image           = '{$_POST['cf_main_image']}'
             where 
                cf_id             = '{$g5['mobile_tmpl']}'";
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config2w_m_table]` ");
goto_url("./default_basic_config_form.php", false);
?>
