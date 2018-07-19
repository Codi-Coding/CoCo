<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 추출하기
$list = apms_board_rows($wset);
$list_cnt = count($list);

// 아이콘
$icon = (isset($wset['icon']) && $wset['icon']) ? apms_fa($wset['icon']) : '';

// 랭킹
$rank = apms_rank_offset($wset['rows'], $wset['page']); 

// 링크
$is_link = (isset($wset['link']) && $wset['link']) ? true : false;

// 날짜
$wset['date'] = (isset($wset['date']) && $wset['date']) ? $wset['date'] : '';

// 리스트
for ($i=0; $i < $list_cnt; $i++) { 
	// 링크#1
	$target = '';
	if($is_link && $list[$i]['wr_link1']) {
		$list[$i]['href'] = $list[$i]['link_href'][1];
		$target = ' target="_blank"';
	}
?>
	<li>
		<a href="<?php echo $list[$i]['href'];?>" class="ellipsis"<?php echo $target;?>>
			<?php if($wset['comment']) { ?>
				<span class="pull-right name">
					<?php echo $list[$i]['name'];?>
				</span>
			<?php } else if($wset['date']) { ?>
				<span class="pull-right text-muted">
				<?php if($list[$i]['comment']) { ?>
					<span class="count red">
						<?php echo number_format($list[$i]['comment']);?> &nbsp;
					</span>
				<?php } ?>
				<?php echo date($wset['date'], $list[$i]['date']); ?>
				</span>
			<?php } else if($list[$i]['comment']) { ?>
				<span class="pull-right count red">
					<?php echo number_format($list[$i]['comment']);?>
				</span>
			<?php } ?>
			<?php if($wset['rank']) { ?>
				<span class="rank-icon bg-<?php echo $wset['rank'];?> en">
					<?php echo $rank; $rank++; ?>
				</span>
			<?php } ?>
			<?php if($icon) { ?>
				<span class="icon">
					<?php if($list[$i]['new']) { ?>
						<span class="<?php echo $wset['new'];?>"><?php echo $icon;?></span>
					<?php } else { ?>
						<?php echo $icon;?>
					<?php } ?>
				</span>
			<?php } ?>
			<?php echo $list[$i]['subject'];?>
		</a> 
	</li>
<?php } ?>
<?php if(!$list_cnt) { ?>
	<li class="item-none text-muted text-center">글이 없습니다.</li>
<?php } ?>