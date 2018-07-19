<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!extension_loaded('openssl')) {
    echo '<script>'.PHP_EOL;
    echo 'alert("PHP openssl 확장모듈이 설치되어 있지 않습니다.\n모바일 컨텐츠몰 결제 때 사용되오니 openssl 확장 모듈을 설치하여 주십시오.");'.PHP_EOL;
    echo '</script>'.PHP_EOL;
}

if(!extension_loaded('soap') || !class_exists('SOAPClient')) {
    echo '<script>'.PHP_EOL;
    echo 'alert("PHP SOAP 확장모듈이 설치되어 있지 않습니다.\n모바일 컨텐츠몰 결제 때 사용되오니 SOAP 확장 모듈을 설치하여 주십시오.");'.PHP_EOL;
    echo '</script>'.PHP_EOL;
}
?>
