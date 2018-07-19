<?php // 굿빌더 ?>
<?php
$sub_menu = "350405";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$nouse_que = "";
$tail_que = "";
$style_que = "";
$long_que = "";

for ($i = 0; $i < $config2w['cf_max_tail']; $i++) {

	$s = $cf_tail_sort[$i];

	$nouse_que .= " cf_tail_nouse_$s = '{$cf_tail_nouse[$i]}'";
	$tail_que .= " cf_tail_name_$s = '{$cf_tail_name[$i]}'";
	$style_que .= " cf_tail_style_$s = '{$cf_tail_style[$i]}'";
	$long_que .= " cf_tail_long_$s = '{$cf_tail_long[$i]}'";

	if($i < $config2w['cf_max_tail'] - 1) {
		$nouse_que .= ",";
		$tail_que .= ",";
		$style_que .= ",";
		$long_que .= ",";
	}

}

$sql = " update $g5[config2w_table] set $nouse_que, $tail_que, $style_que, $long_que ";
$sql .= " where cf_id='$g5[tmpl]' "; /// 2012.11.24
/// echo $sql;
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

goto_url("./tail_config_form.php");
?>
