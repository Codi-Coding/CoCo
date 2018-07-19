<?php // 굿빌더 ?>
<?php
$sub_menu = "350402";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$nouse_que = "";
$main_que = "";
$style_que = "";
$admin_que = "";

for ($i = 0; $i < $config2w['cf_max_main_left']; $i++) {

	$s = $cf_main_left_sort[$i];

	$nouse_que .= " cf_main_left_nouse_$s = '{$cf_main_left_nouse[$i]}'";
	$main_que .= " cf_main_left_name_$s = '{$cf_main_left_name[$i]}'";
	$style_que .= " cf_main_left_style_$s = '{$cf_main_left_style[$i]}'";
	$admin_que .= " cf_main_left_admin_$s = '{$cf_main_left_admin[$i]}'";

	if($i < $config2w['cf_max_main_left'] - 1) {
		$nouse_que .= ",";
		$main_que .= ",";
		$style_que .= ",";
		$admin_que .= ",";
	}

}

$sql = " update $g5[config2w_table] set $nouse_que, $main_que, $style_que, $admin_que ";
$sql .= " where cf_id='$g5[tmpl]' "; /// 2012.11.24
/// echo $sql;
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

goto_url("./main_left_config_form.php");
?>
