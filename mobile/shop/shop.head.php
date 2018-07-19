<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(file_exists(G5_THEME_MSHOP_PATH.'/index.php')) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
} else {
    include_once($g5['mobile_tmpl_path'].'/head.php'); ///goodbuilder
    if(!preg_match('/shop_|w3_/', $g5['mobile_tmpl'])) echo '<center><font color=#aaa> + '._t('이 템플릿에서는 쇼핑몰이 정상적으로 지원되지 않습니다.').' + </font></center>';
}
?>
