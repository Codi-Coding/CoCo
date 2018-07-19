<?php // 굿빌더 ?>
<?php
$sub_menu = "350301";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$menu_que = "";
$leng_que = "";
$link_que = "";

$submenu_que = "";
$sublink_que = "";
$cf_menu = $g5['menu'];

for ($i = 0; $i < $config2w['cf_max_menu']; $i++) { 

	/// $s = $cf_menu_sort[$i]?$cf_menu_sort[$i]:$i;
	$s = $cf_menu_sort[$i];

	$menu_que .= " cf_menu_name_$s = '{$cf_menu_name[$i]}'";
	$leng_que .= " cf_menu_leng_$s = '{$cf_menu_leng[$i]}'";
	$link_que .= " cf_menu_link_$s = '{$cf_menu_link[$i]}'";

	if($i < $config2w['cf_max_menu'] - 1) {
		$menu_que .= ",";
		$leng_que .= ",";
		$link_que .= ",";
	}

	for ($j = 0; $j < $config2w['cf_max_submenu']; $j++) {

		$submenu_que .= " cf_submenu_name_$s"."_$j = '{$config2w_menu['cf_submenu_name_'.$i.'_'.$j]}'";
		$sublink_que .= " cf_submenu_link_$s"."_$j = '{$config2w_menu['cf_submenu_link_'.$i.'_'.$j]}'";

		if(($i < $config2w['cf_max_menu'] - 1) or ($j < $config2w['cf_max_submenu'] - 1)) {
			$submenu_que .= ",";
			$sublink_que .= ",";
		}

	}

}

$sql = " update $g5[config2w_menu_table] set $menu_que, $leng_que, $link_que, $submenu_que, $sublink_que ";
///$sql .= " where cf_id='$g5[tmpl]' "; /// 2012.11.24
$sql .= " where cf_menu='$cf_menu' "; /// 2012.11.24
/// echo $sql;
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

goto_url("./menu_config_form.php");
?>
