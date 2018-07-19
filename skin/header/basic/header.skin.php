<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<style>
.amina-header { line-height:22px; margin-bottom:15px; }
.amina-header .header-breadcrumb { margin-top:4px; }
@media all and (max-width:460px) {
	.responsive .amina-header .header-breadcrumb { display:none; }
}
</style>
<div class="amina-header">
	<span class="header-breadcrumb pull-right text-muted">
		<i class="fa fa-home"></i> 홈
		<?php echo ($page_nav1) ? ' > '.$page_nav1 : '';?>
		<?php echo ($page_nav2) ? ' > '.$page_nav2 : '';?>
		<?php echo ($page_nav3) ? ' > '.$page_nav3 : '';?>
	</span>
	<div class="div-title-underbar font-18">
		<span class="div-title-underbar-bold border-<?php echo $header_color;?>">
			<b><?php echo $page_name;?></b>
		</span>
	</div>
</div>
