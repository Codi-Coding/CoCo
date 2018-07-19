<?php // 굿빌더 ?>
<?php
$sub_menu = "350201";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$cf_width_main_total = $cf_width_main_left + $cf_width_main + $cf_width_main_right;
$sql = " update $g5[config2w_table] set
     cf_max_menu =
     '$cf_max_menu',
     cf_max_submenu = 
     '$cf_max_submenu',
     cf_width_main_total =
     '$cf_width_main_total',
     cf_width_main =
     '$cf_width_main',
     cf_width_main_left = 
     '$cf_width_main_left',
     cf_width_main_right = 
     '$cf_width_main_right',
     cf_hide_left = 
     '$cf_hide_left',
     cf_hide_right = 
     '$cf_hide_right',
     cf_max_main =
     '$cf_max_main',
     cf_max_main_left = 
     '$cf_max_main_left',
     cf_max_main_right = 
     '$cf_max_main_right',
     cf_max_head =
     '$cf_max_head',
     cf_max_tail =
     '$cf_max_tail'
";
$sql .= " where cf_id='$g5[tmpl]' "; /// 2012.11.24

///echo $sql;
sql_query($sql);

/// sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

goto_url("./default_basic_config_form.php");
?>`
