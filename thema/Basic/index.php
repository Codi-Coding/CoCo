<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

$is_main_file = THEMA_PATH.'/main/'.$at_set['mfile'].'.php';

if(is_file($is_main_file)) {
	include_once($is_main_file);
} else {
	echo '<div class="text-muted text-center" style="padding:300px 0px;">좌측 상단의 모니터 아이콘(Switcher) 클릭해서 사용할 메인파일을 설정해 주세요.</div>';
}

?>