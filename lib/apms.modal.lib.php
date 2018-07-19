<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//모달창 크기
$modal_size = 900;

?>
<script src="<?php echo G5_JS_URL;?>/apms.modal.js"></script>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<div id="viewModalContent">
					<div id="viewModalLoading"><img src="<?php echo G5_IMG_URL;?>/loading-modal.gif"></div>
					<iframe id="viewModalFrame" src="" width="100%" height="0" frameborder="0"></iframe>
				</div>
				<div class="text-center cursor">
					<i class="fa fa-times circle medium light-circle bg-white border-lightgray lightgray" data-dismiss="modal" aria-hidden="true"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if($modal_size > 900) { ?>
<style>
	@media all and (min-width:<?php echo $modal_size + 92;?>px) {
		#viewModal .modal-lg { width:<?php echo $modal_size;?>px; }
	}
</style>
<?php } ?>
