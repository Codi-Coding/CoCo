<?php // 굿빌더 ?>
<?php
$sub_menu = "350401";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$nouse_que = "";
$head_que = "";
$style_que = "";
$long_que = "";

for ($i = 0; $i < $config2w['cf_max_head']; $i++) {

	$s = $cf_head_sort[$i];

	$nouse_que .= " cf_head_nouse_$s = '{$cf_head_nouse[$i]}'";
	$head_que .= " cf_head_name_$s = '{$cf_head_name[$i]}'";
	$style_que .= " cf_head_style_$s = '{$cf_head_style[$i]}'";
	$long_que .= " cf_head_long_$s = '{$cf_head_long[$i]}'";

	if($i < $config2w['cf_max_head'] - 1) {
		$nouse_que .= ",";
		$head_que .= ",";
		$style_que .= ",";
		$long_que .= ",";
	}

}

$sql = " update $g5[config2w_table] set $nouse_que, $head_que, $style_que, $long_que ";
$sql .= " where cf_id='$g5[tmpl]' "; /// 2012.11.24
/// echo $sql;
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

goto_url("./head_config_form.php");
?>
