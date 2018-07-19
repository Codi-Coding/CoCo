<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}

if(defined('G5_THEME_PATH'))
    include_once(G5_THEME_PATH.'/index.php');
else
    include_once($g5['tmpl_path'].'/index.php'); ///goodbuilder
?>
