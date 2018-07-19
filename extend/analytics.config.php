<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

define('G5_ANALYTICS_DIR', 'analytics');
mkdir(G5_PLUGIN_URL.'/'.G5_ANALYTICS_DIR, 0755);
define('G5_ANALYTICS_URL', G5_PLUGIN_URL.'/'.G5_ANALYTICS_DIR);
define('G5_ANALYTICS_PATH', G5_PLUGIN_PATH.'/'.G5_ANALYTICS_DIR);
define('NAVER_ANALYTICS_CODE', 'navercode'); //네이버 애널리틱스 코드
define('GOOGLE_ANALYTICS_CODE', 'googlecode'); //구글 애널리틱스 코드
?>
