<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(file_exists(G5_THEME_SHOP_PATH.'/index.php')) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
} else {
    include_once($g5['tmpl_path'].'/tail.php'); ///goodbuilder
}
?>
