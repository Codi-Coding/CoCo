<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH'))
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
else
    include_once($g5['mobile_tmpl_path'].'/index.php'); ///goodbuilder
?>
