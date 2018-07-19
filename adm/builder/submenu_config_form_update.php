<?php // 굿빌더 ?>
<?php
$sub_menu = "350301";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$submenu_que = "";
$sublink_que = "";
$cf_menu = $g5['menu'];

$i = $_GET['i'];

for ($j = 0; $j < $config2w['cf_max_submenu']; $j++) {

	/// $s = $cf_submenu_sort[$j]?$cf_submenu_sort[$j]:$j;
	$s = $cf_submenu_sort[$j];

	$submenu_que .= " cf_submenu_name_$i"."_$s = '{$cf_submenu_name[$i.'_'.$j]}'";
	$sublink_que .= " cf_submenu_link_$i"."_$s = '{$cf_submenu_link[$i.'_'.$j]}'";

	if($j < $config2w['cf_max_submenu'] - 1) {
		$submenu_que .= ",";
		$sublink_que .= ",";
	}

}

$sql = " update $g5[config2w_menu_table] set $submenu_que, $sublink_que ";
$sql .= " where cf_menu='$cf_menu' "; /// 2012.11.24
/// echo $sql;
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

goto_url("./submenu_config_form.php?i=$i");
?>
