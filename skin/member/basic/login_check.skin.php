<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 자신만의 코드를 넣어주세요.

// 영카트5이면 쿠폰갯수 체크
if(defined('G5_USE_SHOP') && G5_USE_SHOP) {
	apms_coupon_update($mb['mb_id']);
}

?>
