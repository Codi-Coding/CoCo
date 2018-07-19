<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$msg = _t("등록이 완료되었습니다.") ;
$url = G5_URL;
$error = false;
alert($msg, $url, $error) ;
?>

