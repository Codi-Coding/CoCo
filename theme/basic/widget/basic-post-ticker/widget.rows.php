<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 링크
$is_modal_js = $wset['modal_js'];
$is_link_target = ($wset['modal'] == "2") ? ' target="_blank"' : '';

// 추출하기
$list = apms_board_rows($wset);
$list_cnt = count($list);

// 랭킹
$rank = apms_rank_offset($wset['rows'], $wset['page']);

// 아이콘
$icon = (isset($wset['icon']) && $wset['icon']) ? '<span class="lightgray">'.apms_fa($wset['icon']).'</span>' : '';

// 날짜
$is_date = (isset($wset['date']) && $wset['date']) ? true : false;
$is_dtype = (isset($wset['dtype']) && $wset['dtype']) ? $wset['dtype'] : 'm.d';
$is_dtxt = (isset($wset['dtxt']) && $wset['dtxt']) ? true : false;

// 새글
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 

// 강조글
$bold = array();
$strong = explode(",", $wset['strong']);
$is_strong = count($strong);
for($i=0; $i < $is_strong; $i++) {

	list($n, $bc) = explode("|", $strong[$i]);

	if(!$n) continue;

	$n = $n - 1;
	$bold[$n]['num'] = true;
	$bold[$n]['color'] = ($bc) ? ' class="'.$bc.'"' : '';
}

?>

<div class="owl-container">
	<div class="owl-carousel">
	<?php 
	for ($i=0; $i < $list_cnt; $i++) { 

		//아이콘 체크
		$wr_icon = $icon;
		$is_lock = false;
		if ($list[$i]['secret'] || $list[$i]['is_lock']) {
			$is_lock = true;
			$wr_icon = '<span class="rank-icon en bg-orange en">Lock</span>';	
		} else if ($wset['rank']) {
			$wr_icon = '<span class="rank-icon en bg-'.$wset['rank'].'">'.$rank.'</span>';	
			$rank++;
		} else if($list[$i]['new']) {
			$wr_icon = '<span class="rank-icon txt-space en bg-'.$is_new.'">New</span>';	
		}

		// 링크이동
		$target = '';
		if($is_link_target && $list[$i]['wr_link1']) {
			$target = $is_link_target;
			$list[$i]['href'] = $list[$i]['link_href'][1];
		}

		//강조글
		if($is_strong) {
			if($bold[$i]['num']) {
				$list[$i]['subject'] = '<b'.$bold[$i]['color'].'>'.$list[$i]['subject'].'</b>';
			}
		}

	?>
		<div class="item post-list">
			<a href="<?php echo $list[$i]['href'];?>" class="ellipsis"<?php echo $is_modal_js;?><?php echo $target;?>>
				<?php if($is_date || $list[$i]['comment']) { ?> 
					<span class="pull-right gray font-12">
						<?php if($list[$i]['comment']) { ?>
							<span class="count orangered">
								+<?php echo $list[$i]['comment'];?>
							</span>
						<?php } ?>
						<?php if ($is_date) { ?>
							&nbsp;<?php echo ($is_dtxt) ? apms_datetime($list[$i]['date'], $is_dtype) : date($is_dtype, $list[$i]['date']); ?>
						<?php } ?>
					</span>
				<?php } ?>
				<?php echo $wr_icon;?>
				<?php echo $list[$i]['subject'];?>
			</a>
		</div>
	<?php } ?>
	<?php if(!$list_cnt) { ?>
		<div class="item">
			<a class="ellipsis">등록된 글이 없습니다.</a>
		</div>
	<?php } ?>
	</div>
</div>
