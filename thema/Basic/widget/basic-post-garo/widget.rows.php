<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 링크
$is_modal_js = $wset['modal_js'];
$is_link_target = ($wset['modal'] == "2") ? ' target="_blank"' : '';

$wset['thumb_w'] = (isset($wset['thumb_w']) && $wset['thumb_w'] > 0) ? $wset['thumb_w'] : 400;
$wset['thumb_h'] = (isset($wset['thumb_h']) && $wset['thumb_h'] > 0) ? $wset['thumb_h'] : 300;
$img_h = apms_img_height($wset['thumb_w'], $wset['thumb_h'], '75');

if(!$wset['rows']) {
	$wset['rows'] = 6;
}

// 리스트글
$post_cnt = $wset['rows'];

$img_post_cnt = (isset($wset['irows']) && $wset['irows'] > 0) ? $wset['irows'] : 3;
if($img_post_cnt > 3) {
	$img_post_cnt = 3;
}

switch($img_post_cnt) {
	case '1'	: $is_dadan = ''; break;
	case '2'	: $is_dadan = ' is-2'; break;
	default		: $is_dadan = ' is-3'; break;
}

// 이미지글수
$img = array();
$img_arr = array();
$wset['image'] = 1; //이미지글만 추출
$wset['rows'] = $img_post_cnt;
$img = apms_board_rows($wset);
$img_cnt = count($img);
for($i=0; $i < $img_cnt; $i++) {
	$img_arr[$i] = $img[$i]['bo_table'].'-'.$img[$i]['wr_id']; 
}

// 리스트글 - 중복글 제외
$tmp = array();
$wset['image'] = '';
$wset['rows'] = $post_cnt + $img_cnt;
$tmp = apms_board_rows($wset);
$tmp_cnt = count($tmp);
$z = 0;
for($i=0; $i < $tmp_cnt; $i++) {
	
	$chk_wr = $tmp[$i]['bo_table'].'-'.$tmp[$i]['wr_id'];

	if($img_cnt && in_array($chk_wr, $img_arr)) continue;

	$list[$z] = $tmp[$i];

	$z++;

	if($z == $post_cnt) break;
}

unset($tmp);

$list_cnt = count($list);

// 이미지글 제목크기
$wset['line'] = (isset($wset['line']) && $wset['line'] > 0) ? $wset['line'] : 1;
$text_height = 20 * $wset['line'];
if($wset['line'] > 1) $line_height = $line_height + 4;

// 아이콘
$icon = (isset($wset['icon']) && $wset['icon']) ? '<span class="lightgray">'.apms_fa($wset['icon']).'</span>' : '';

// 랭킹
$rank = apms_rank_offset($wset['rows'], $wset['page']); 

// 날짜
$is_idate = (isset($wset['idate']) && $wset['idate']) ? true : false;
$is_date = (isset($wset['date']) && $wset['date']) ? true : false;
$is_dtype = (isset($wset['dtype']) && $wset['dtype']) ? $wset['dtype'] : 'm.d';
$is_dtxt = (isset($wset['dtxt']) && $wset['dtxt']) ? true : false;

// 새글
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 

// 글내용 - 줄이 1줄보다 크고
$is_cont = ($wset['line'] > 1) ? true : false; 
$is_details = ($is_cont) ? '' : ' no-margin'; 

// 분류
$is_cate = (isset($wset['cate']) && $wset['cate']) ? true : false;

// 동영상아이콘
$is_vicon = (isset($wset['vicon']) && $wset['vicon']) ? '' : '<i class="fa fa-play-circle-o post-vicon"></i>'; 

// 스타일
$is_center = (isset($wset['center']) && $wset['center']) ? ' text-center' : ''; 
$is_bold = (isset($wset['bold']) && $wset['bold']) ? true : false;
$is_ticon = (isset($wset['ticon']) && $wset['ticon']) ? true : false;

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

// 그림자
$shadow_in = '';
$shadow_out = (isset($wset['shadow']) && $wset['shadow']) ? apms_shadow($wset['shadow']) : '';
if($shadow_out && isset($wset['inshadow']) && $wset['inshadow']) {
	$shadow_in = '<div class="in-shadow">'.$shadow_out.'</div>';
	$shadow_out = '';	
}

?>
<div class="basic-post-garo">
	<div class="post-wrap<?php echo $is_dadan;?>">
		<?php // 이미지글
		for ($i=0; $i < $img_cnt; $i++) {

			//아이콘 체크
			$wr_icon = '';
			$is_lock = false;
			if ($img[$i]['secret'] || $img[$i]['is_lock']) {
				$is_lock = true;
				$wr_icon = '<span class="rank-icon en bg-orange en">Lock</span>';	
			} else if($img[$i]['new']) {
				$wr_icon = '<span class="rank-icon txt-normal en bg-'.$is_new.'">New</span>';	
			} 

			//링크이동
			$target = '';
			if($is_link_target && $img[$i]['wr_link1']) {
				$target = $is_link_target;
				$img[$i]['href'] = $img[$i]['link_href'][1];
			}

			//볼드체
			if($is_bold) {
				$img[$i]['subject'] = '<b>'.$img[$i]['subject'].'</b>';
			}
		?>
		<div class="post-image">
			<div class="post-item">
				<a href="<?php echo $img[$i]['href'];?>"<?php echo $is_modal_js;?><?php echo $target;?>>
					<div class="img-wrap<?php echo $is_hover;?>" style="padding-bottom:<?php echo $img_h;?>%;">
						<?php echo $shadow_in;?>
						<?php if($img[$i]['as_list'] == "2" || $img[$i]['as_list'] == "3") echo $is_vicon; ?>
						<div class="img-item">
							<img src="<?php echo $img[$i]['img']['src'];?>" alt="<?php echo $img[$i]['img']['alt'];?>">
						</div>
					</div>
				</a>				
				<?php echo $shadow_out;?>

				<div class="post-content<?php echo $is_center;?>">
					<div class="post-subject" style="height:<?php echo $text_height;?>px;">
						<a href="<?php echo $img[$i]['href'];?>"<?php echo $is_modal_js;?><?php echo $target;?>>
							<?php echo $wr_icon;?>
							<?php echo $img[$i]['subject'];?>
							<?php if($is_cont) { ?>
								<div class="post-text">
									<?php echo apms_cut_text($img[$i]['content'], 100);?>
								</div>
							<?php } ?>
						</a>
					</div>
					<div class="post-text post-ko txt-short ellipsis<?php echo $is_center;?><?php echo $is_details;?>">
						<?php echo $img[$i]['name'];?>
						<?php if($is_cate && $img[$i]['ca_name']) { ?>
							<span class="post-sp">|</span>
							<?php echo $img[$i]['ca_name'];?>
						<?php } ?>
						<?php if($is_idate) { ?>
							<span class="post-sp">|</span>
							<span class="txt-normal">
								<?php echo ($is_dtxt) ? apms_datetime($img[$i]['date'], $is_dtype) : date($is_dtype, $img[$i]['date']); ?>
							</span>
						<?php } ?>
						<?php if ($img[$i]['comment']) { ?>
							<span class="count orangered">+<?php echo $img[$i]['comment']; ?></span>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="clearfix"></div>
	</div>
	<ul class="post-list">
	<?php
	// 리스트
	for ($i=0; $i < $list_cnt; $i++) { 

		//아이콘 체크
		$wr_icon = $icon;
		$is_lock = false;
		if ($list[$i]['secret'] || $list[$i]['is_lock']) {
			$is_lock = true;
			$wr_icon = '<span class="wr-icon wr-secret"></span>';
		} else if ($wset['rank']) {
			$wr_icon = '<span class="rank-icon en bg-'.$wset['rank'].'">'.$rank.'</span>';	
			$rank++;
		} else if($list[$i]['new']) {
			$wr_icon = '<span class="wr-icon wr-new"></span>';
		} else if($is_ticon) {
			if ($list[$i]['icon_video']) {
				$wr_icon = '<span class="wr-icon wr-video"></span>';
			} else if ($list[$i]['icon_image']) {
				$wr_icon = '<span class="wr-icon wr-image"></span>';
			} else if ($list[$i]['wr_file']) {
				$wr_icon = '<span class="wr-icon wr-file"></span>';
			}
		}

		//링크이동
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
		<li class="ellipsis">
			<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js;?><?php echo $target;?>>
				<?php if($is_date || $list[$i]['comment']) { ?> 
					<span class="pull-right gray font-12">
						<?php if ($list[$i]['comment']) { ?>
							<span class="count orangered">+<?php echo $list[$i]['comment']; ?></span>
						<?php } ?>
						<?php if ($is_date) { ?>
							&nbsp;<?php echo ($is_dtxt) ? apms_datetime($list[$i]['date'], $is_dtype) : date($is_dtype, $list[$i]['date']); ?>
						<?php } ?>
					</span>
				<?php } ?>
				<?php echo $wr_icon;?>
				<?php echo $list[$i]['subject'];?>
			</a> 
		</li>
	<?php } ?>
	</ul>
</div>
<?php if(!$list_cnt) { ?>
	<div class="post-none">등록된 글이 없습니다.</div>
<?php } ?>
