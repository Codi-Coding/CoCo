<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<h1>
	<i class="fa fa-star"></i> My Reviews
</h1>
<div class="well" style="padding-bottom:3px;">
	<form class="form" role="form" name="flist">
	<input type="hidden" name="ap" value="<?php echo $ap;?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>">
	<input type="hidden" name="save_opt" value="<?php echo $opt; ?>">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label for="sca" class="sound_only">분류선택</label>
					<select name="sca" id="sca" class="form-control input-sm">
						<option value="">카테고리</option>
						<?php echo $category_options;?>
					</select>
				    <script>document.getElementById("sca").value = "<?php echo $sca; ?>";</script>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<div class="form-group">
						<label for="opt" class="sound_only">별점선택</label>
						<select name="opt" id="opt" class="form-control input-sm">
							<option value="">전체보기</option>
							<option value="5">별 5개</option>
							<option value="4">별 4개</option>
							<option value="3">별 3개</option>
							<option value="2">별 2개</option>
							<option value="1">별 1개</option>
						</select>
						<script>document.getElementById("opt").value = "<?php echo $opt; ?>";</script>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> 보기</button>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<a href="./?ap=<?php echo $ap;?>" class="btn btn-danger btn-sm btn-block"><i class="fa fa-power-off"></i> 초기화</a>
				</div>
			</div>
		</div>
	</form>
</div>

<h3>
	<i class="fa fa-pencil"></i> <?php echo number_format($total_count);?> Reviews
</h3>

<div class="at-media">
<?php 
	for ($i=0; $i < count($list); $i++) { 
		// 이미지
		if($list[$i]['is_photo']) {
			$img['src'] = $list[$i]['is_photo'];
		} else {
			$img = apms_it_write_thumbnail($list[$i]['it_id'], $list[$i]['is_content'], 80, 80);
		}
?>
	<div class="media">
		<div class="img-thumbnail photo pull-left">
			<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
				<?php echo ($img['src']) ? '<img src="'.$img['src'].'" alt="'.$img['src'].'">' : '<i class="fa fa-user"></i>'; ?>
			</a>
		</div>
		<div class="media-body">
			<h5 class="media-heading">
				<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
					<span class="pull-right text-muted font-11 en">no.<?php echo $list[$i]['is_num']; ?></span>
					<?php echo $list[$i]['is_subject']; ?>
				</a>
			</h5>
			<div class="media-item">
				<a href="<?php echo $list[$i]['it_href'];?>" target="_blank"><span class="text-muted"><?php echo $list[$i]['it_name']; ?></span></a>
			</div>
			<div class="media-info en text-muted">
				<span class="is-star red font-12">
					<?php echo $list[$i]['is_star'];?>
				</span>
				
				<i></i> 
				<?php if($list[$i]['is_reply']) { ?>
					<span class="blue">답변완료</span>
				<?php } else { ?>
					답변대기
				<?php } ?>

				<i class="fa fa-user"></i>
				<?php echo $list[$i]['is_name']; ?>

				<i class="fa fa-clock-o"></i>
				<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['is_time']) ?>"><?php echo apms_datetime($list[$i]['is_time'], 'Y.m.d H:i');?></time>

			</div>
			<div class="media-content media-resize" id="more_is_<?php echo $i; ?>" style="display:none;">
				<?php echo get_view_thumbnail($list[$i]['is_content'], $default['pt_img_width']); // 문의 내용 ?>
				<?php if ($list[$i]['is_reply']) { 
					//답글제목 : $list[$i]['is_reply_subject']
					//답글작성 : $list[$i]['is_reply_name']
				?>
					<div class="well well-sm">
						<?php echo get_view_thumbnail($list[$i]['is_reply_content'], $default['pt_img_width']); ?>
					</div>
				<?php } ?>
				<p>
					<a href="<?php echo $list[$i]['is_reply_href'];?>" class="btn btn-default btn-sm"><i class="fa fa-comment"></i> 답변하기</a>
				</p>
			</div>
		</div>
	</div>
<?php } ?>
</div>

<?php if ($i == 0) echo '<p class="text-center text-muted" style="padding:50px 0px;">등록된 후기가 없습니다.</p>'; ?>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<script>
	function more_is(id) {
		$("#" + id).toggle();
	}
</script>
