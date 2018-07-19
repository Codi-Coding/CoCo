<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// StyleSheet
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" type="text/css" media="screen">',0);

// 헤더 출력
if($move && $header_skin)
	include_once('./header.php');

?>

<form name="fitemqans" class="form-light padding-15" role="form" method="post" action="./itemqansformupdate.php" onsubmit="return fitemqansform_submit(this);" autocomplete="off">
	<input type="hidden" name="w" value="u">
	<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
	<input type="hidden" name="iq_id" value="<?php echo $iq_id; ?>">
	<input type="hidden" name="ca_id" value="<?php echo $ca_id; ?>">
	<input type="hidden" name="qrows" value="<?php echo $qrows; ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>">
	<input type="hidden" name="move" value="<?php echo $move; ?>">

	<div class="panel panel-default">
		<div class="panel-heading"><h4><i class="fa fa-question-circle fa-lg"></i> <?php echo conv_subject($qa['iq_subject'],120); ?></h4></div>
		<div class="panel-body">
			<p class="text-muted">
				<i class="fa fa-user"></i> <?php echo $qa['name']; ?>
				<?php if($qa['iq_email']) { ?>
					&nbsp; &nbsp;
					<i class="fa fa-envelope"></i> <?php echo get_text($qa['iq_email']); ?>
				<?php } ?>
				<?php if($qa['iq_hp']) { ?>
					&nbsp; &nbsp;
					<i class="fa fa-phone"></i> <?php echo get_text($qa['iq_hp']); ?>
				<?php } ?>
			</p>
			<div class="qa-view">
				<?php echo get_view_thumbnail($qa['iq_question'], $default['pt_img_width']); ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<?php echo $editor_html; ?>
	</div>

	<p class="text-center">
		<button type="submit" class="btn btn-color btn-sm">작성완료</button>
		<?php if($move) { ?>
			<button type="button" class="btn btn-black btn-sm" onclick="history.go(-1);">취소</button>
		<?php } else { ?>
			<button type="button" class="btn btn-black btn-sm" onclick="window.close();">닫기</button>
		<?php } ?>
	</p>

</form>

<script>
	function fitemqansform_submit(f) {
		<?php echo $editor_js; ?>
		return true;
	}
	// BS3
	$(function(){
		$("#iq_question").addClass("form-control input-sm form-iq-size");
		$("#iq_answer").addClass("form-control input-sm form-iq-size");
	});
</script>
