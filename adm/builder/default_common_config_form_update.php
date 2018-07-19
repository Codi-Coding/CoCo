<?php // 굿빌더 ?>
<?php
$sub_menu = "350101";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$sql = " update $g5[config2w_table] set
     cf_use_common_logo = 
     '$cf_use_common_logo', 
     cf_use_common_menu = 
     '$cf_use_common_menu', 
     cf_use_common_addr = 
     '$cf_use_common_addr'
";
$sql .= " where cf_id='$g5[tmpl]' "; /// 2012.11.24

/// echo $sql;
sql_query($sql);

if($cf_all_common_logo_chk) sql_query("update $g5[config2w_table] set cf_use_common_logo = '$cf_use_common_logo'");
if($cf_all_common_menu_chk) sql_query("update $g5[config2w_table] set cf_use_common_menu = '$cf_use_common_menu'");
if($cf_all_common_addr_chk) sql_query("update $g5[config2w_table] set cf_use_common_addr = '$cf_use_common_addr'");

/// sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

goto_url("./default_common_config_form.php");
?>
