<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<style>
	.page-content { line-height:22px; word-break: keep-all; word-wrap: break-word; }
	.page-content .article-title { color:#0083B9; font-weight:bold; padding-top:30px; padding-bottom:10px; }
	.page-content p { margin:0 0 15px; padding:0; }
</style>

<div class="page-content">

	<?php if(!$header_skin) { // 헤더 미사용시 출력 ?>
		<div class="text-center" style="margin:15px 0px;">
			<h3 class="div-title-underline-bold border-color">
				이메일 무단수집거부
			</h3>
		</div>
	<?php } ?>

	<div class="text-center">
		<p>본 사이트에 게시된 이메일 주소가 전자우편 수집 프로그램이나 그 밖의 기술적 장치를 이용하여 무단으로 수집 되는 것을 거부합니다.</p>
		<p>이를 위반시 <b>「정보통신망 이용촉진 및 정보보호 등에 관한 법률」</b>에 의해 형사처벌됨을 유념하시기 바랍니다.</p>
		<br>
		<p><i class="fa fa-at" style="font-size:80px;"></i></p>
	</div>
</div>

<div class="h30"></div>
