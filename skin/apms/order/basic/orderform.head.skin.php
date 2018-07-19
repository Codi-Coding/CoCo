<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// StyleSheet
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" type="text/css" media="screen">',0);

// 목록헤드
if(isset($wset['ohead']) && $wset['ohead']) {
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/head/'.$wset['ohead'].'.css" media="screen">', 0);
	$head_class = 'list-head';
} else {
	$head_class = (isset($wset['ocolor']) && $wset['ocolor']) ? 'tr-head border-'.$wset['ocolor'] : 'tr-head border-black';
}

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>

<?php // 주문서폼 시작 - id 변경불가 & 삭제하면 안됨 ?>
<form name="forderform" id="forderform" method="post" action="<?php echo $action_url; ?>" autocomplete="off" role="form" class="form-horizontal">
