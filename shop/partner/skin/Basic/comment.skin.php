<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<h1><i class="fa fa-comment"></i> My Comments</h1>

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
						<label for="opt" class="sound_only">댓글선택</label>
						<select name="opt" id="opt" class="form-control input-sm">
							<option value="">회원댓글</option>
							<option value="1">마이댓글</option>
							<option value="2">전체댓글</option>
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
	<i class="fa fa-comments"></i> <?php echo number_format($total_count); ?> Comments
</h3>

<section class="comment-media">
	<?php
	$cmt_cnt = count($list);
	for ($i=0; $i<$cmt_cnt; $i++) {
		$photo = apms_photo_url($list[$i]['mb_id']);
		$photo = ($photo) ? '<img src="'.$photo.'" alt="" class="media-object">' : '<div class="media-object"><i class="fa fa-user"></i></div>';
	 ?>
		<div class="media">
			<div class="photo pull-left">
				<?php echo $photo;?>
			</div>
			<div class="media-body">
				<h5 class="media-heading">
					<b class="font-13"><?php echo $list[$i]['name'] ?></b>
					<span class="font-11 text-muted">
						<span class="hidden-xs media-info">
							<i class="fa fa-clock-o"></i>
							<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['date']) ?>"><?php echo apms_datetime($list[$i]['date'], 'Y.m.d H:i');?></time>
						</span>
						<span class="pull-right text-muted font-11 en">
							no.<?php echo $list[$i]['num']; ?>
							<?php if ($is_shingo)  { ?>
								<a href="#" onclick="apms_shingo('<?php echo $list[$i]['it_id'];?>', '<?php echo $list[$i]['wr_id'];?>'); return false;">
									<span class="text-muted media-btn">신고</span>
								</a>
							<?php } ?>
							<?php if ($is_admin) { ?>
								<?php if ($list[$i]['is_lock']) { // 글이 잠긴상태이면 ?>
									<a href="#" onclick="apms_shingo('<?php echo $list[$i]['it_id'];?>', '<?php echo $list[$i]['wr_id'];?>', 'unlock'); return false;">
										<span class="text-muted media-btn"><i class="fa fa-unlock fa-lg"></i><span class="sound_only">해제</span></span>
									</a>
								<?php } else { ?>
									<a href="#" onclick="apms_shingo('<?php echo $list[$i]['it_id'];?>', '<?php echo $list[$i]['wr_id'];?>', 'lock'); return false;">
										<span class="text-muted media-btn"><i class="fa fa-lock fa-lg"></i><span class="sound_only">잠금</span></span>
									</a>
								<?php } ?>
							<?php } ?>
						</span> 
					</span>
				</h5>
				<div class="media-content">
					<?php if (strstr($list[$i]['wr_option'], "secret")) { ?><i class="fa fa-lock"></i><?php } ?>
					<?php echo $list[$i]['content']; ?>
				</div>
				<div class="media-it">
					<a href="<?php echo $list[$i]['href'];?>" target="_blank">
						<span class="text-muted"><i class="fa fa-shopping-cart fa-lg"></i> <?php echo $list[$i]['it_name'];?></span>
					</a>
				</div>
		  </div>
		</div>
	<?php } ?>
	<?php if($i == 0) { ?>
		<p class="text-center text-muted" style="padding:50px 0px;">등록된 댓글이 없습니다.</p>
	<?php } ?>
</section>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>
