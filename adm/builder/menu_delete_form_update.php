<?php // 굿빌더 ?>
<?php
$sub_menu = "350304";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if ($cf_menu == "")
    alert("메뉴을 선택해 주십시요.");

if ($cf_menu == "basic")
    alert("basic 메뉴은 삭제할 수 없습니다.");

if ($cf_menu == $config2w['cf_menu'])
    alert("사용 중인 메뉴입니다.");

if ($cf_menu == $g5['menu'])
    alert("작업 중인 메뉴입니다.");

$sql = " delete from $g5[config2w_menu_table] where cf_menu='$cf_menu' ";
/// echo $sql;
$res = sql_query($sql);

/// sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

if($res)
    alert($cf_menu." 메뉴가 삭제되었습니다.");
else
    alert($cf_menu." 메뉴가 삭제되지 못했습니다.");

///goto_url("./basic_tmpl_delete_form.php");
?>
