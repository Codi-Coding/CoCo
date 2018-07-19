<?php
include_once('../common.php');

//추가설정 초기화
$sql_apms_where = $sql_apms_orderby = '';

if (isset($_REQUEST['sort']))  {
    $sort = trim($_REQUEST['sort']);
    $sort = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $sort);
} else {
    $sort = '';
}

if (isset($_REQUEST['sortodr']))  {
    $sortodr = preg_match("/^(asc|desc)$/i", $sortodr) ? $sortodr : '';
} else {
    $sortodr = '';
}

$ca_id = apms_escape('ca_id');

if (!defined('G5_USE_SHOP') || !G5_USE_SHOP)
    die('<p>쇼핑몰 설치 후 이용해 주십시오.</p>');

define('_SHOP_', true);

define('IS_SHOP', true);

// 예약체크
apms_check_reserve_end();

?>