<?php // 굿빌더 ?>
<?php
include_once("./_common.php");

include_once("$g5[tmpl_path]/menu/menu.php");
include_once("$g5[tmpl_path]/menu/menu_aux.php");

$menu_name    = $menu_list[$main_index][0];
$submenu_name = $menu[$main_index][$side_index][0];

if(isset($_GET[p])) {
    if(G5_IS_MOBILE) {
        if(file_exists("$g5[tmpl_path]/$g5[subpage]/m/{$_GET[p]}.html"))
            include("$g5[tmpl_path]/$g5[subpage]/m/{$_GET[p]}.html");
    } else {
        if(file_exists("$g5[tmpl_path]/$g5[subpage]/{$_GET[p]}.html"))
            include("$g5[tmpl_path]/$g5[subpage]/{$_GET[p]}.html");
    }
}
?>
