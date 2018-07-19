<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<div class="sub-title">
	<h4>
		<?php if($member['photo']) { ?>
			<img src="<?php echo $member['photo'];?>" alt="">
		<?php } else { ?>
			<i class="fa fa-user"></i>
		<?php } ?>
		<?php echo $g5['title'];?>
	</h4>
</div>

<div class="follow-skin">
	<div class="btn-group btn-group-justified">
		<a href="<?php echo $follow_href;?>" class="btn btn-sm btn-black<?php echo ($follow_on) ? ' active' : '';?>">Follow (<?php echo $member['follow'];?>)</a>
		<a href="<?php echo $followed_href;?>" class="btn btn-sm btn-black<?php echo ($followed_on) ? ' active' : '';?>">Followed (<?php echo $member['followed'];?>)</a>
		<a href="<?php echo $like_href;?>" class="btn btn-sm btn-black<?php echo ($like_on) ? ' active' : '';?>">Like (<?php echo $member['like'];?>)</a>
		<a href="<?php echo $liked_href;?>" class="btn btn-sm btn-black<?php echo ($liked_on) ? ' active' : '';?>">Liked (<?php echo $member['liked'];?>)</a>
	</div>

	<?php for($i=0; $i < count($list); $i++) { ?>
		<div class="panel panel-default sp-follow"<?php if($i == 0) echo ' style="border-top:0;"';?>>
			<div class="panel-heading">
				<h3 class="panel-title">
					<?php if($list[$i]['del_href']) { ?>
						<span class="pull-right"><a href="#" onclick="mb_delete('<?php echo $list[$i]['del_href'];?>'); return false;"><i class="fa fa-times text-muted"></i></a></span>
					<?php } ?>
					<?php echo ($list[$i]['online']) ? '<span class="red">Online</span>' : 'Offline'; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-2 text-center col-follow">
						<div class="img-photo">
							<?php echo ($list[$i]['photo']) ? '<img src="'.$list[$i]['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
						</div>
					</div>
					<div class="col-xs-10 col-follow">
						<div style="margin-bottom:6px;">
							<span class="pull-right">Lv.<?php echo $list[$i]['level'];?></span>
							<b><?php echo $list[$i]['name']; ?></b> &nbsp;<small class="text-muted font-11"><?php echo $list[$i]['grade'];?></small>
						</div>
						<div class="at-tip" data-original-title="<?php echo number_format($list[$i]['exp_up']);?>점 추가획득시 레벨업합니다." data-toggle="tooltip" data-placement="top" data-html="true">
							<div class="div-progress progress progress-striped" style="margin:0px 0px 6px;">
								<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo $list[$i]['exp_per'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($list[$i]['exp_per']);?>%;">
									<span class="sr-only"><?php echo number_format($list[$i]['exp']);?> (<?php echo $list[$i]['exp_per'];?>%)</span>
								</div>
							</div>
						</div>
						<div class="myinfo font-12">
							<?php if($list[$i]['myshop_href']) { ?>
								<a href="<?php echo $list[$i]['myshop_href'];?>" target="_blank"><i class="fa fa-shopping-cart"></i> 마이샵</a>
							<?php } ?>
							<?php if($list[$i]['myrss_href']) { ?>
								<a href="<?php echo $list[$i]['myrss_href'];?>" target="_blank"><i class="fa fa-rss"></i> 구독하기</a>
							<?php } ?>
							<a><i class="fa fa-clock-o"></i> <?php echo $list[$i]['mb_today_login'];?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="list-group">
				<?php if($list[$i]['is_it']) { // 최근 아이템 ?>
					<a href="#" class="list-group-item bg-heading">
						<b class="black"><i class="fa fa-gift"></i> 최근 아이템</b>
					</a>
					<?php for($j=0; $j < count($list[$i]['it']);$j++) { ?>
						<a href="<?php echo $list[$i]['it'][$j]['href'];?>" target="_blank" class="list-group-item">
							<?php echo $list[$i]['it'][$j]['subject'];?>
							<?php if($list[$i]['it'][$j]['comment']) { ?>
								 &nbsp;<span class="text-muted font-11 en"><i class="fa fa-comment"></i> <?php echo $list[$i]['it'][$j]['comment'];?></span>
							<?php } ?>
							<span class="text-muted font-11 en">
								 &nbsp;<i class='fa fa-clock-o'></i>
								<?php echo apms_datetime($list[$i]['it'][$j]['date']);?>
							</span>
						</a>
					<?php } ?>
				<?php } ?>

				<?php if($list[$i]['is_wr']) { // 최근글 ?>
					<a href="#" class="list-group-item bg-heading">
						<b class="black"><i class="fa fa-pencil"></i> 최근 게시물</b>
					</a>
					<?php for($j=0; $j < count($list[$i]['wr']);$j++) { ?>
						<a href="<?php echo $list[$i]['wr'][$j]['href'];?>" target="_blank" class="list-group-item">
							<?php echo $list[$i]['wr'][$j]['subject'];?>
							<?php if($list[$i]['wr'][$j]['comment']) { ?>
								 &nbsp;<span class="text-muted font-11 en"><i class="fa fa-comment"></i> <?php echo $list[$i]['wr'][$j]['comment'];?></span>
							<?php } ?>
							<span class="text-muted font-11 en">
								 &nbsp;<i class='fa fa-clock-o'></i>
								<?php echo apms_datetime($list[$i]['wr'][$j]['date']);?>
							</span>
						</a>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	<?php if($i == 0) { ?>
		<p class="text-center text-muted" style="padding:50px 0;">자료가 없습니다.</p>
	<?php } ?>

	<?php if($total_count > 0) { ?>
		<div class="text-center">
			<ul class="pagination pagination-sm en">
				<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
			</ul>
		</div>
	<?php } ?>

	<p class="text-center">
		<a class="btn btn-color btn-sm" href="<?php echo $recount_href;?>">리카운트</a>
		<a class="btn btn-black btn-sm" href="#" onclick="window.close();">닫기</a>
	</p>

	<script>
	function mb_delete(url) {
		if(confirm("리스트에서 삭제하시겠습니까?")) {
			document.location.href = url;
		}
	}
	</script>
</div>
