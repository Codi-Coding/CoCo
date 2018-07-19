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

<table class="div-table table">
<tbody>
<tr class="active">
	<th class="text-center" scope="col">번호</th>
	<th class="text-center" scope="col">이미지</th>
	<th class="text-center" scope="col">제목</th>
	<th class="text-center" scope="col">날짜</th>
</tr>
<?php 
for ($i=0; $i<count($list); $i++)	{
	$list[$i]['img'] = apms_wr_thumbnail($list[$i]['bo_table'], $list[$i], 40, 40, false, true); // 썸네일	
?>
	<tr>
		<td class="text-center font-11 en">
			<?php echo $list[$i]['num']; ?>
		</td>
		<td class="text-center">
			<a href="<?php echo $list[$i]['href']; ?>" target="_blank">
				<?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>" width="40" height="40">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>				
			</a>
		</td>
		<td>
			<a href="<?php echo $list[$i]['href'] ?>" target="_blank">
				<?php echo get_text($list[$i]['subject']); ?>
				<?php if($list[$i]['comment']) { ?>
					<span class="count red"><?php echo $list[$i]['comment'];?></span>
				<?php } ?>
			</a>
			<div class="list-details text-muted font-11">
				<?php if($list[$i]['ca_name']) { ?>
					<?php echo $list[$i]['ca_name']; ?> 
					/
				<?php } ?>
				<?php echo $list[$i]['bo_subject']; ?> 
				/ 
				<?php echo $list[$i]['gr_subject']; ?>
			</div>
		</td>
		<td class="text-center font-11">
			<?php echo apms_datetime($list[$i]['date'], 'Y.m.d'); ?>
		</td>
	</tr>
<?php }  ?>
<?php if ($i == 0) echo '<tr><td colspan="4" class="text-center text-muted list-none">등록한 게시물이 없습니다.</td></tr>'; ?>
</tbody>
<tfoot>
<tr class="active">
	<td colspan="5" class="text-center">
		<?php echo $config['cf_new_del'];?>일 이내 등록된 글만 확인할 수 있습니다.
	</td>
</tr>
</tfoot>
</table>
