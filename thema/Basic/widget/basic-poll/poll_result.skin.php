<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

// 그래프 색상
$bar = array("", "success", "info", "warning", "danger", "success", "info", "warning", "danger", "success", "info", "warning", "danger");

?>
<div class="poll-result-skin<?php echo (G5_IS_MOBILE) ? ' poll-mobile' : '';?>">
	<div class="poll-title">
		<h4>
			<i class="fa fa-bar-chart poll-icon"></i>
			<?php echo $g5['title'] ?>
		</h4>
	</div>

	<h3 class="poll-head">
		<i class="fa fa-quote-left"></i> <?php echo $po_subject ?> <i class="fa fa-quote-right"></i>
	</h3>

	<div style="padding:30px;">
		<ul class="list-group">
			<li class="list-group-item text-center" style="background:#f5f5f5;">
				<b class="list-group-item-heading"><i class="fa fa-smile-o fa-lg"></i> 전체 <?php echo $nf_total_po_cnt ?>표</b>
			</li>
			<?php for ($i=1; $i<=count($list); $i++) { ?>
				<li class="list-group-item">
					<p class="list-group-item-heading">
						<b><?php echo $list[$i]['content'] ?></b>
						<span class="pull-right"><?php echo $list[$i]['cnt'] ?> 표 (<?php echo number_format($list[$i]['rate'], 1) ?>%)</span>
					</p>
					<div class="div-progress progress progress-striped">
						<div class="progress-bar progress-bar-<?php echo $bar[$i];?> progress-bar-striped" role="progressbar" aria-valuenow="<?php echo number_format($list[$i]['rate'], 1) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo number_format($list[$i]['rate'], 1) ?>%">
							<span class="sr-only"><?php echo $list[$i]['cnt'] ?> 표 (<?php echo number_format($list[$i]['rate'], 1) ?>%)</span>
						</div>
					</div>
				</li>
			<?php } ?>
		</ul>

		<?php if ($is_etc) { ?>
			<h4 class="div-title-underline-thin" style="margin:0 0 5px;">
				Opinion
			</h4>

			<section class="poll-media">
				<?php for ($i=0; $i<count($list2); $i++) {  ?>
					<div class="media">
						<div class="photo pull-left">
							<?php if($list2[$i]['photo']) {?>
								<img src="<?php echo $list2[$i]['photo'];?>" alt="">
							<?php } else { ?>
								<i class="fa fa-user img-fa"></i>
							<?php } ?>
						</div>
						<div class="media-body">
							<div class="media-heading">
								<b class="font-13"><?php echo $list2[$i]['name'] ?></b>
								<span class="font-11 text-muted media-info">
									<i class="fa fa-clock-o"></i>
									<?php echo $list2[$i]['datetime'] ?>
								</span>
								</span>
								<?php if ($list2[$i]['del']) { ?>
									<span class="pull-right font-11"><?php echo $list2[$i]['del'];?><span class="text-muted">삭제</span></a></span>
								<?php } ?>
							</div>
							<div class="media-content">
								<?php echo $list2[$i]['idea'] ?>
							</div>
					  </div>
					</div>
				<?php } ?>
			</section>

			<?php if ($member['mb_level'] >= $po['po_level']) {  ?>
				<div class="panel panel-default" style="margin-top:10px;">
					<?php if($po_etc) { ?>
						<div class="panel-heading"><b><i class="fa fa-comment"></i> <?php echo $po_etc ?></b></div>
					<?php } ?>
					<div class="panel-body">
						<form class="form" role="form" name="fpollresult" action="./poll_etc_update.php" onsubmit="return fpollresult_submit(this);" method="post" autocomplete="off">
						<input type="hidden" name="po_id" value="<?php echo $po_id ?>">
						<input type="hidden" name="w" value="">
						<input type="hidden" name="skin_dir" value="<?php echo $skin_dir ?>">
						<?php if ($is_member) { ?>
							<input type="hidden" name="pc_name" value="<?php echo cut_str($member['mb_nick'],255) ?>">
						<?php } ?>

						<?php if ($is_guest) {  ?>
							<div class="form-group">
								<label class="sound_only" for="pc_name">이름<strong class="sound_only">필수</strong></label>
								<input type="text" name="pc_name" id="pc_name" required class="form-control input-sm" size="10" placeholder="이름">
							</div>
						<?php }  ?>

						<div class="form-group">
							<label class="sound_only" for="pc_idea">의견<strong class="sound_only">필수</strong></label>
							<input type="text" id="pc_idea" name="pc_idea" required class="form-control input-sm" size="47" maxlength="100"  placeholder="의견을 적어주세요.">
						</div>

						<?php if ($is_guest) {  ?>
							<div class="pull-left">
								<strong class="sound_only">자동등록방지</strong>
								<?php echo captcha_html(); ?>
							</div>
						<?php }  ?>
						<div class="pull-right">
							<button type="submit" class="btn btn-color btn-sm">의견남기기</button>
						</div>
						<div class="clearfix"></div>
						</form>
					</div>
				</div>
			<?php }  ?>

		<?php } ?>

		<?php if($is_etc_poll) { ?>
			<div class="panel panel-default">
				<div class="panel-heading"><b><i class="fa fa-bar-chart"></i> 다른 투표 결과 보기</b></div>
				<div class="list-group">
					<?php for ($i=0; $i<count($list3); $i++) {  ?>
						<a href="./poll_result.php?po_id=<?php echo $list3[$i]['po_id'] ?>&amp;skin_dir=<?php echo urlencode($skin_dir); ?>" class="list-group-item">
							[<?php echo $list3[$i]['date'] ?>] <?php echo $list3[$i]['subject'] ?>
						</a>
					<?php }  ?>
				</div>
			</div>
		<?php } ?>

		<p class="text-center">
			<button type="button" onclick="window.close();" class="btn btn-black btn-sm">닫기</button>
		</p>

	</div>

	<script>
	$(function() {
		$(".poll_delete").click(function() {
			if(!confirm("해당 기타의견을 삭제하시겠습니까?"))
				return false;
		});
	});

	function fpollresult_submit(f) {
		<?php if ($is_guest) { echo chk_captcha_js(); }  ?>
		return true;
	}
	</script>
</div>