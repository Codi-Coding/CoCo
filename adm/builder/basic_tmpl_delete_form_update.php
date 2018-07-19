<?php // 굿빌더 ?>
<?php
$sub_menu = "350603";
include_once("./_common.php");

function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if ($cf_id == "")
    alert("템플릿을 선택해 주십시요.");

if ($cf_id == "basic")
    alert("basic 템플릿은 삭제할 수 없습니다.");

if ($cf_id == $config2w_def['cf_templete'])
    alert("사용 중인 템플릿입니다.");

if ($cf_id == $g5['tmpl'])
    alert("작업 중인 템플릿입니다.");

$sql = " delete from $g5[config2w_table] where cf_id='$cf_id' ";
/// echo $sql;
sql_query($sql);

/// sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

if($chk_del_file) {
    if(file_exists("$g5[path]/$g5[tmpl_dir]/$cf_id")) {
        /// exec("rm -rf $g5[path]/$g5[tmpl_dir]/$cf_id 2>&1");
        delTree("$g5[path]/$g5[tmpl_dir]/$cf_id");
    }
}

if(1) {

$sql = " delete from $g5[config2w_config_table] where cf_id = '$cf_id' ";
sql_query($sql);

$sql = " delete from $g5[config2w_board_table] where cf_id = '$cf_id' ";
sql_query($sql);

$sql = " delete from $g5[config2w_m_def_table] where cf_templete = '$cf_id' ";
sql_query($sql);

} /// if 1

goto_url("./basic_tmpl_delete_form.php");
?>
