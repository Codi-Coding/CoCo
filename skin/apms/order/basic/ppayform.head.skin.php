<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>

<?php // 결제폼 시작 - id 변경불가 & 삭제하면 안됨 ?>
<form name="forderform" id="forderform" method="post" action="<?php echo $action_url; ?>" autocomplete="off" role="form" class="form-horizontal">
