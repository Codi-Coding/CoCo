<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div style="padding:15px;">
	<div class="input-group input-group-sm">
		<span class="input-group-addon">Total <?php echo number_format($total_count);?></span>
		<select name="ca_id" onchange="location='./mypost.php?mode=<?php echo $mode; ?>&ca_id=' + encodeURIComponent(this.value);" class="form-control input-sm">
			<option value="">전체보기</option>
			<?php echo apms_category($ca_id);?>
		</select>
	</div>
</div>

<div class="mypost-media">
<?php 
	for ($i=0; $i < count($list); $i++) { 
		// 이미지
		$list[$i]['img'] = apms_it_write_thumbnail($list[$i]['it_id'], $list[$i]['is_content'], 80, 80);
?>
	<div class="media">
		<div class="photo pull-left">
			<a href="#" onclick="more_iq('more_iq_<?php echo $i; ?>'); return false;">
				<?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>				
			</a>
		</div>
		<div class="media-body">
			<div class="media-heading">
				<a href="#" onclick="more_iq('more_iq_<?php echo $i; ?>'); return false;">
					<b><?php echo $list[$i]['iq_subject']; ?></b>
				</a>
			</div>
			<div class="media-item">
				<a href="<?php echo $list[$i]['it_href'];?>" target="_blank"><span class="text-muted"><?php echo $list[$i]['it_name']; ?></span></a>
			</div>
			<div class="font-11 text-muted">
				<?php echo ($list[$i]['answer']) ? '<span class="red">답변완료</span>' : '답변대기'; ?>
				/ 
				no.<?php echo $list[$i]['num']; ?>
				/
				<?php echo apms_datetime($list[$i]['date'], 'Y.m.d H:i');?>
				/
				<?php echo $list[$i]['ca_name']; ?>
			</div>
			<div class="media-content media-resize" id="more_iq_<?php echo $i; ?>" style="display:none;">
				<?php echo get_view_thumbnail($list[$i]['iq_question'], $default['pt_img_width']); ?>
				<?php if($list[$i]['answer']) { ?>
					<div class="media media-reply">
						<div class="photo pull-left">
							<?php echo ($list[$i]['ans_photo']) ? '<img src="'.$list[$i]['ans_photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
						</div>
						<div class="media-body">
							<?php echo get_view_thumbnail($list[$i]['iq_answer'], $default['pt_img_width']); ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>

<?php if ($i == 0) echo '<p class="text-center text-muted list-none">등록한 문의가 없습니다.</p>'; ?>

<script>
function more_iq(id) {
	$("#" + id).toggle();
}
</script>
