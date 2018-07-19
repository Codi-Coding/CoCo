<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
apms_autosize();
?>
<script src="<?php echo G5_JS_URL;?>/apms.video.js"></script>
<div class="modal fade" id="apmsVideoModal" tabindex="-1" role="dialog" aria-labelledby="apmsVideoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<div class="apms-autowrap" style="max-width:100% !important;">
					<div id="apmsVideoWrap" class="apms-autosize">
						<iframe id="apmsVideoPlayer" src="" width="640" height="360" frameborder="0"></iframe>
					</div>
				</div>
				<div style="margin-top:12px;">
					<button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">×</button>
					<div id="apmsVideoContent" class="pull-left"></div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
