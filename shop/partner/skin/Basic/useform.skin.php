<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<h1>
	<i class="fa fa-pencil"></i> Review
</h1>

<form class="form" role="form" name="fitemuseform" method="post" action="./useformupdate.php" onsubmit="return fitemuseform_submit(this);">
<input type="hidden" name="is_id" value="<?php echo $is_id; ?>">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="opt" value="<?php echo $opt; ?>">
<input type="hidden" name="save_opt" value="<?php echo $save_opt; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="panel panel-default" style="margin-top:10px;">
	<div class="panel-heading"><h4><i class="fa fa-pencil fa-lg"></i> <?php echo conv_subject($use['is_subject'],120); ?></h4></div>
	<div class="panel-body">
		<p class="text-muted">
			<i class="fa fa-user"></i> <?php echo $name; ?>
		    <?php if($use['is_email']) { ?>
				&nbsp; &nbsp;
				<i class="fa fa-envelope"></i> <?php echo get_text($use['is_email']); ?>
			<?php } ?>
		</p>

		<?php echo $use['is_content']; ?>
	</div>
	<div class="list-group">
		<a href="./item.php?it_id=<?php echo $it['it_id'];?>" target="_blank" class="list-group-item">
			<?php $img = apms_it_thumbnail($it, 40, 40, false, true); ?>
			<?php if($img['src']) { ?>
				<img src="<?php echo $img['src'];?>" alt="<?php echo $img['alt'];?>">
			<?php } ?>
			<?php echo $it['it_name'];?>
		</a>
	</div>
</div>

<h3>
	<i class="fa fa-gift"></i> Thanks
</h3>

<div class="form-group">
    <div class="input-group">
		<div class="input-group-addon ko font-12">제목</div>
		<input type="text" name="is_reply_subject" value="<?php echo get_text($use['is_reply_subject']); ?>" id="is_reply_subject" class="form-control input-sm minlength=2" minlength="2" maxlength="250">
    </div>
</div>

<div>
	<?php echo editor_html('is_reply_content', $use['is_reply_content']); ?>
</div>

<br>

<p class="text-center">
    <button type="submit" accesskey='s' class="btn btn-danger">확인</button>
    <a href="<?php echo $list_href; ?>" class="btn btn-primary">목록</a>
</p>

</form>

<script>
	function fitemuseform_submit(f) {
		<?php echo get_editor_js('is_reply_content'); ?>
		return true;
	}
	// BS3
	$(function(){
		$("#is_reply_content").addClass("form-control input-sm form-iq-size");
	});
</script>
