<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<div class="sub-title">
	<h4>
		<i class="fa fa-thumb-tack scrap-icon"></i>
		스크랩하기
	</h4>
</div>
<div class="scrap-skin">
	<h3 class="scrap-head">
		<i class="fa fa-quote-left"></i> <?php echo get_text(cut_str($write['wr_subject'], 255)) ?> <i class="fa fa-quote-right"></i>
	</h3>
	<div class="scrap-form">
		<form class="form-horizontal" role="form" name="f_scrap_popin" action="./scrap_popin_update.php" method="post">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">

			<div class="form-group">
				<label class="col-xs-2 control-label" for="wr_content"><i class="fa fa-comment fa-lg"></i> <b>댓글</b></label>
				<div class="col-xs-10">
					<textarea name="wr_content" id="wr_content" rows="10" class="form-control input-sm"></textarea>
					<p class="help-block">
						<i class="fa fa-smile-o fa-lg"></i> 스크랩을 하시면서 감사 혹은 격려의 댓글을 남기실 수 있습니다.
					</p>
				</div>
			</div>

			<p class="text-center">
				<button type="submit" class="btn btn-color btn-sm">스크랩 확인</button>
			</p>
		</form>
	</div>
</div>