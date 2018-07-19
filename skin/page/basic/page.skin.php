<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 헤더
if($header_skin)
	include_once('./header.php');

echo $page_content;

?>
<style>
.page-icon { 
	padding:0px 20px; 
}
.page-icon img { 
	width:34px; border-radius:50%; margin-bottom:5px;
}
@media all and (max-width:480px) {
	.responsive .page-icon { padding:0px; }
	.responsive .page-icon .pull-right { float:none !important; }
}
</style>
<div class="print-hide page-icon">
	<?php echo apms_sns_share_icon($sns_url, $sns_title, $seometa['img']['src']); //SNS 아이콘 ?>
	<span class="pull-right">
		<?php if($scrap_href) { ?>
			<a href="<?php echo $scrap_href;  ?>" target="_blank" onclick="win_scrap(this.href); return false;" title="스크랩">
				<img src="<?php echo G5_IMG_URL;?>/sns/scrap.png" alt="스크랩">
			</a>
		<?php } ?>
		<a href="javascript:;" onclick="apms_print();" title="프린트">
			<img src="<?php echo G5_IMG_URL;?>/sns/print.png" alt="프린트">
		</a>
	</span>
	<div class="clearfix"></div>
</div>
