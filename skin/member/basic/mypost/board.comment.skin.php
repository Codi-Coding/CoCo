<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div style="padding:15px;">
	<div class="input-group input-group-sm">
		<span class="input-group-addon">Total <?php echo number_format($total_count);?></span>
		<select name="gr_id" id="gr_id" class="form-control input-sm" onchange="location='./mypost.php?mode=<?php echo $mode; ?>&gr_id=' + encodeURIComponent(this.value);">
			<option value="">전체보기</option>
			<?php echo $group_select ?>
		</select>
	</div>
</div>
<script>
	document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
</script>

<section class="mypost-media">
	<?php
	$cmt_cnt = count($list);
	for ($i=0; $i<$cmt_cnt; $i++) {
		$list[$i]['img'] = apms_wr_thumbnail($list[$i]['bo_table'], $parent[$i], 80, 80, false, true); // 썸네일	
	 ?>
		<div class="media">
			<div class="photo pull-left">
				<?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-comment img-fa"></i>
				<?php } ?>				
			</div>
			<div class="media-body">
				<div class="media-heading">
					<a href="<?php echo $list[$i]['href'] ?>" target="_blank">
						<b class="font-13"><?php echo get_text($list[$i]['subject']); ?></b>
						<?php if($list[$i]['comment']) { ?>
							<span class="count red"><?php echo $list[$i]['comment'];?></span>
						<?php } ?>
					</a>
				</div>
				<div class="text-muted font-11">
					no.<?php echo $list[$i]['num']; ?> 
					/ 
					<?php echo apms_datetime($list[$i]['date'], 'Y.m.d H:i'); ?> 
					/ 
					<?php echo $list[$i]['bo_subject']; ?> 
					/ 
					<?php echo $list[$i]['gr_subject']; ?>
				</div>
				<div class="media-content">
					<?php if (strstr($list[$i]['wr_option'], "secret")) { ?><i class="fa fa-lock"></i><?php } ?>
					<?php echo $list[$i]['content']; ?>
				</div>
		  </div>
		</div>
	<?php } ?>
	<?php if($i == 0) { ?>
		<p class="text-center text-muted list-none">등록한 댓글이 없습니다.</p>
	<?php } ?>
</section>

<p class="text-center text-muted">
	<?php echo $config['cf_new_del'];?>일 이내 등록된 댓글만 확인할 수 있습니다.
</p>