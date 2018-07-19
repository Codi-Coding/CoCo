<?php // 굿빌더 ?>
<?php
$sub_menu = "350303";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if($src_cf_menu == '') $src_cf_menu = 'basic';

/// config2w_menu
$sql = " select count(*) as cnt from $g5[config2w_menu_table] where cf_menu='$cf_menu' ";
$row = sql_fetch($sql);
if($row['cnt'])
    alert($cf_menu." 메뉴가 이미 존재합니다.");

/// sql_query(" lock tables $g5[config2w_menu_table] ");

$sql = " create temporary table tmp select * from $g5[config2w_menu_table] where cf_menu='$src_cf_menu' ";
/// echo $sql;
sql_query($sql);

$sql = " update tmp set cf_menu='$cf_menu' ";

sql_query($sql);

$sql = " insert into $g5[config2w_menu_table] select * from tmp ";
$res = sql_query($sql);

sql_query(" drop table tmp ");

/// sql_query(" OPTIMIZE TABLE `$g5[config2w_menu_table]` ");

/// sql_query(" unlock tables ");

if($res) 
    alert($cf_menu." 메뉴가 생성되었습니다.", "./menu_create_form.php");
else
    alert($cf_menu." 메뉴가 생성되지 못했습니다.", "./menu_create_form.php");

///goto_url("./menu_create_form.php");
?>
