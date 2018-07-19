<?php
include_once('../../../common.php');

if (!defined('G5_USE_SHOP') || !G5_USE_SHOP)
    ///* goodbuilder 수정 * die('<p>쇼핑몰 설치 후 이용해 주십시오.</p>');
    alert(_t('현재 쇼핑몰 서비스는 제공하지 않습니다.'));
define('_SHOP_', true);
?>
