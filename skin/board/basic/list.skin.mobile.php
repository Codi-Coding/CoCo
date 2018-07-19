<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 포토 아이콘
$icon = apms_fa($boset['icon']);

$list_cnt = count($list);

?>
<?php if($is_category) { ?>
	<div class="clearfix h15 hidden-xs"></div>
<?php } ?>
<p>
	Total <b><?php echo number_format($total_count);?></b> Posts, Now <b><?php echo $page;?></b> Page
</p>
<div class="list-mobile font-14<?php echo ($boset['mimg']) ? '' : ' no-img';?>">
	<?php //리스트
		for ($i=0; $i<count($list); $i++) { 

		//아이콘 체크
		$wr_icon = '';
		$is_lock = false;
		if ($list[$i]['icon_secret'] || $list[$i]['is_lock']) {
			$wr_icon = '<span class="wr-icon wr-secret"></span>';
			$is_lock = true;
		} else if ($list[$i]['icon_hot']) {
			$wr_icon = '<span class="wr-icon wr-hot"></span>';
		} else if ($list[$i]['icon_new']) {
			$wr_icon = '<span class="wr-icon wr-new"></span>';
		}

		// 공지, 현재글 스타일 체크
		if ($wr_id == $list[$i]['wr_id']) { // 현재글
			$div_css = ' list-now';
			$subject_css = ' now';
		} else if ($list[$i]['is_notice']) { // 공지사항
			$div_css = ' list-notice';
			$subject_css = ' notice';
			$list[$i]['ca_name'] = '공지';
		} else {
			$div_css = $subject_css = '';			
		}
	 ?>
		<div class="list-item media<?php echo $div_css;?>">
			<?php if($boset['mimg']) {
				$img = apms_wr_thumbnail($bo_table, $list[$i], 50, 50, false, true); // 썸네일
				$img['src'] = (!$img['src'] && $boset['photo']) ? apms_photo_url($list[$i]['mb_id']) : $img['src']; // 회원사진	
			?>
				<div class="list-img pull-left">
					<a href="<?php echo $list[$i]['href'] ?>">
						<?php if($img['src']) { ?>
							<img src="<?php echo $img['src'];?>" alt="<?php echo $img['alt'];?>">
						<?php } else { ?>
							<?php echo $icon;?>
						<?php } ?>
					</a>
				</div>
			<?php } ?>
			<div class="media-body">
				<strong class="media-heading<?php echo $subject_css;?>">
					<a href="<?php echo $list[$i]['href'] ?>">
						<span class="pull-right">
							&nbsp;
							<?php if ($list[$i]['comment_cnt']) { ?>
								<span class="list-cnt">+<?php echo $list[$i]['wr_comment']; ?></span>&nbsp;
							<?php } ?>
							<?php echo apms_date($list[$i]['date'], 'orangered', 'H:i', 'm.d', 'Y.m.d');?>
						</span>
						<?php echo $wr_icon;?>
						<?php echo $list[$i]['subject'] ?>
					</a>
				</strong>
			</div>
		</div>
	<?php } ?>
	<?php if (!$is_list) { ?>
		<div class="text-center text-muted list-none">게시물이 없습니다.</div>
	<?php } ?>
</div>
