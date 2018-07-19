<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 사이트 주소
$site_url = (G5_DOMAIN) ? G5_DOMAIN : 'http://'.$_SERVER['HTTP_HOST'];

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$print_skin_url.'/print.css" media="screen">', 1);

?>

<div class="print-logo">
	<span class="pull-right">
		<?php echo $site_url;?>
	</span>
	<h4><?php echo $config['cf_title'];?></h4>
	<div class="clearfix"></div>
</div>

<div class="print-nav">
	<button type="button" class="btn btn-orangered btn-sm" onclick="window.print();">
		<i class="fa fa-print"></i> 프린트
	</button>
	<button type="button" class="btn btn-black btn-sm" onclick="window.close();">
		<i class="fa fa-times"></i> 취소
	</button>
</div>

<div class="print-header"></div>

<div class="print-body">
