<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$wid = (isset($wid) && $wid) ? apms_escape_string($wid) : '';
$wname = (isset($wname) && $wname) ? apms_escape_string($wname) : '';
$thema = (isset($thema) && $thema) ? apms_escape_string($thema) : '';

if(!$wid || !$thema || !$wname) {
	die('정상적인 접근이 아닙니다.');
}

$add = (isset($add) && $add) ? apms_escape_string($add) : '';
$wdir = (isset($wdir) && $wdir) ? apms_escape_string($wdir) : '';

if (!defined('THEMA')) {
	define('THEMA', $thema);
	define('THEMA_PATH', G5_PATH.'/thema/'.$thema);
	define('THEMA_URL', G5_URL.'/thema/'.$thema);
}

if($wdir) {
	$widget_url = G5_URL.$wdir.'/'.$wname;
	$widget_path = G5_PATH.$wdir.'/'.$wname;
} else {
	if($add) { // 애드온
		$widget_url = G5_SKIN_URL.'/addon/'.$wname;
		$widget_path = G5_SKIN_PATH.'/addon/'.$wname;
	} else {
		$widget_url = THEMA_URL.'/widget/'.$wname;
		$widget_path = THEMA_PATH.'/widget/'.$wname;
	}
}

if(!file_exists($widget_path.'/widget.php')) {
	die('정상적인 접근이 아닙니다.');	
}

// 데모
if($is_demo) {
	if(file_exists(THEMA_PATH.'/assets/demo/demo.config.php')) {
		include_once(THEMA_PATH.'/assets/demo/demo.config.php');
	} else if(file_exists(THEMA_PATH.'/assets/demo.php')) {
		include_once(THEMA_PATH.'/assets/demo.php');
	}
}

// 위젯설정값
$wset = apms_widget_config($wid, $opt, $mopt, $add);

// 기본값 정리
$wset['cache'] = (isset($wset['cache']) && $wset['cache'] > 0) ? $wset['cache'] : 0;
$wset['comment'] = (isset($wset['comment']) && $wset['comment']) ? $wset['comment'] : '';
$wset['shadow'] = (isset($wset['shadow']) && $wset['shadow']) ? $wset['shadow'] : '';
$wset['rows'] = (isset($wset['rows']) && $wset['rows']) ? $wset['rows'] : '';
$wset['page'] = (isset($wset['page']) && $wset['page']) ? $wset['page'] : '';
$wset['mode'] = (isset($wset['mode']) && $wset['mode']) ? $wset['mode'] : '';
$wset['rank'] = (isset($wset['rank']) && $wset['rank']) ? $wset['rank'] : '';
$wset['new'] = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red';
$wset['page'] = $page;

?>