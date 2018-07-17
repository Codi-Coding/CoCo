<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 분류항목 출력
if($sca && $boset['cateshow']) {
	$is_category = false;
}

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($boset['img']) $colspan++;
if ($is_category) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

$list_cnt = count($list);

?>

<div class="table-responsive">
	<table class="table div-table list-pc bg-white">
	<thead>
	<tr>
		<?php if ($is_checkbox) { ?>
		<th scope="col">
			<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
			<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
		</th>
		<?php } ?>
		<th scope="col">번호</th>
		<?php if($boset['img']) { $icon = apms_fa($boset['icon']); //포토용 아이콘 ?>
			<th scope="col">포토</th>
		<?php } ?>
		<?php if($is_category) { ?>
			<th scope="col">분류</th>
		<?php } ?>
		<th scope="col">제목</th>
		<th scope="col">글쓴이</th>
		<th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</a></th>
		<th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?><nobr>조회</nobr></a></th>
		<?php if($is_good) { ?>
			<th scope="col"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?><nobr>추천</nobr></a></th>
		<?php } ?>
		<?php if($is_nogood) { ?>
			<th scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?><nobr>비추</nobr></a></th>
		<?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php for ($i=0; $i < $list_cnt; $i++) { 

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
		$tr_css = $subject_css = '';
		if ($wr_id == $list[$i]['wr_id']) {
			$tr_css = ' class="list-now"';
			$subject_css = ' now';
			$num = '<span class="wr-text red">열람중</span>';
		} else if ($list[$i]['is_notice']) { // 공지사항
			$tr_css = ' class="active"';
			$subject_css = ' notice';
			$num = '<span class="wr-icon wr-notice"></span>';
			$list[$i]['ca_name'] = '공지';
		} else {
			$num = '<span class="en">'.$list[$i]['num'].'</span>';
		}
	?>
	<tr<?php echo $tr_css; ?>>
		<?php if ($is_checkbox) { ?>
			<td class="text-center">
				<label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
				<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
			</td>
		<?php } ?>
		<td class="text-center font-11">
			<?php echo $num;?>
		</td>
		<?php if ($boset['img']) { 
			$img = apms_wr_thumbnail($bo_table, $list[$i], 50, 50, false, true); // 썸네일
			$img['src'] = (!$img['src'] && $boset['photo']) ? apms_photo_url($list[$i]['mb_id']) : $img['src']; // 회원사진		
		?>
			<td class="list-img text-center">
				<a href="<?php echo $list[$i]['href'];?>">
					<?php if($img['src']) { ?>
						<img src="<?php echo $img['src'];?>" alt="<?php echo $img['alt'];?>">
					<?php } else { ?>
						<?php echo $icon;?>
					<?php } ?>
				</a>
			</td>
		<?php } ?>
		<?php if ($is_category) { ?>
			<td class="text-center">
				<a href="<?php echo $list[$i]['ca_name_href'] ?>"><span class="text-muted font-11"><?php echo $list[$i]['ca_name'] ?></span></a>
			</td>
		<?php } ?>
		<td class="list-subject<?php echo $subject_css;?>">
			<a href="<?php echo $list[$i]['href'];?>">
				<?php echo $list[$i]['icon_reply']; ?>
				<?php echo $wr_icon;?>
				<?php echo $list[$i]['subject']; ?>
				<?php if ($list[$i]['comment_cnt']) { ?>
					<span class="sound_only">댓글</span><span class="count orangered">+<?php echo $list[$i]['comment_cnt']; ?></span><span class="sound_only">개</span>
				<?php } ?>
			</a>
		</td>
		<td><b><?php echo $list[$i]['name'] ?></b></td>
		<td class="text-center en font-11"><?php echo apms_date($list[$i]['date'], 'orangered', 'H:i', 'm.d', 'Y.m.d'); ?></td>
		<td class="text-center en font-11"><?php echo $list[$i]['wr_hit'] ?></td>
		<?php if ($is_good) { ?>
			<td class="text-center en font-11"><?php echo $list[$i]['wr_good'] ?></td>
		<?php } ?>
		<?php if ($is_nogood) { ?>
			<td class="text-center en font-11"><?php echo $list[$i]['wr_nogood'] ?></td>
		<?php } ?>
	</tr>
	<?php } ?>
	<?php if (!$is_list) { ?>
		<tr><td colspan="<?php echo $colspan;?>" class="text-center text-muted list-none">게시물이 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>
