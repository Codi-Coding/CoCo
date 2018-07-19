<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// StyleSheet
add_stylesheet('<link rel="stylesheet" href="'.$item_skin_url.'/style.css" type="text/css" media="screen">',0);

?>
<style>
	body { background: #fff; padding:20px 20px 0px; margin:0px; }
</style>

<div class="form-box">
	<div class="form-header">
		<h2>Review</h2>
	</div>
	<div class="form-body">
		<form name="fitemuse" class="form-light padding-15" role="form" method="post" action="./itemuseformupdate.php" onsubmit="return fitemuse_submit(this);" autocomplete="off">
			<input type="hidden" name="w" value="<?php echo $w; ?>">
			<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
			<input type="hidden" name="is_id" value="<?php echo $is_id; ?>">
			<input type="hidden" name="ca_id" value="<?php echo $ca_id; ?>">
			<input type="hidden" name="urows" value="<?php echo $urows; ?>">
			<input type="hidden" name="page" value="<?php echo $page; ?>">

			<div class="form-group">
				<label for="is_subject"><b class="en">제목</b><strong class="sound_only"> 필수</strong></label>
				<input type="text" name="is_subject" value="<?php echo get_text($use['is_subject']); ?>" id="is_subject" required class="form-control input-sm minlength=2" minlength="2" maxlength="250">
			</div>
			<div class="form-group">
				<?php echo $editor_html; ?>
			</div>

			<div class="row font-12">
				<div class="col-sm-2 text-center">
					<label><b class="en">별점주기</b></label>
				</div>
				<div class="col-sm-2 text-center">
					<label class="red">
						<input type="radio" name="is_score" value="5" id="is_score5" <?php echo ($is_score==5)?'checked="checked"':''; ?>>
						<?php echo apms_get_star(5); ?>
					</label>
				</div>
				<div class="col-sm-2 text-center">
					<label class="red">
						<input type="radio" name="is_score" value="4" id="is_score4" <?php echo ($is_score==4)?'checked="checked"':''; ?>>
						<?php echo apms_get_star(4); ?>
					</label>
				</div>
				<div class="col-sm-2 text-center">
					<label class="red">
						<input type="radio" name="is_score" value="3" id="is_score3" <?php echo ($is_score==3)?'checked="checked"':''; ?>>
						<?php echo apms_get_star(3); ?>
					</label>
				</div>
				<div class="col-sm-2 text-center">
					<label class="red">
						<input type="radio" name="is_score" value="2" id="is_score2" <?php echo ($is_score==2)?'checked="checked"':''; ?>>
						<?php echo apms_get_star(2); ?>
					</label>
				</div>
				<div class="col-sm-2 text-center">
					<label class="red">
						<input type="radio" name="is_score" value="1" id="is_score1" <?php echo ($is_score==1)?'checked="checked"':''; ?>>
						<?php echo apms_get_star(1); ?>
					</label>
				</div>
			</div>

			<br>

			<div class="text-center">
				<button type="submit" class="btn btn-color btn-sm">작성완료</button>
				<button type="button" class="btn btn-black btn-sm" onclick="window.close();">닫기</button>
			</div>
		</form>
	</div>
</div>

<script>
	function fitemuse_submit(f) {
		<?php echo $editor_js; ?>
		return true;
	}

	// BS3
	$(function(){
		$("#is_content").addClass("form-control input-sm form-is-size");
	});
</script>
