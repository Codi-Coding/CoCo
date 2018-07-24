<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($boset['lightbox']) apms_script('lightbox');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$list_skin_url.'/list.css" media="screen">', 0);

// 이미지 비율
$thumb_w = $board['bo_'.MOBILE_.'gallery_width'];
$thumb_h = $board['bo_'.MOBILE_.'gallery_height'];
$img_h = apms_img_height($thumb_w, $thumb_h); // 이미지 높이

$img_align = ($boset['align']) ? 'img-right pull-right' : 'img-left pull-left';
$ellipsis = (G5_IS_MOBILE) ? '' : ' class="ellipsis"';
$cont_len = (G5_IS_MOBILE) ? $boset['m_cont'] : $boset['cont'];
if($cont_len == "") $cont_len = 100;
$no_img = ($boset['noimg']) ? '' : $board_skin_url.'/img/no-img.jpg';

?>
<style>
	.list-item .img { width:<?php echo ($boset['img_w'] > 0) ? $boset['img_w'] : 160;?>px; }
</style>
<div class="list-webzine">
	<?php
	// 리스트
	for ($i=0; $i < $list_cnt; $i++) { 

		if($list[$i]['is_notice']) continue;		

		//아이콘 체크
		$is_lock = false;
		$wr_lock = $wr_icon = $wr_label = '';
		if ($list[$i]['icon_secret'] || $list[$i]['is_lock']) {
			$wr_lock = '<span class="wr-icon wr-secret"></span>';
			$list[$i]['wr_content'] = ($list[$i]['is_lock']) ? '잠긴글입니다' : '비밀글입니다.';
			$is_lock = true;
		}

		// 공지, 현재글 스타일 체크
		if ($wr_id == $list[$i]['wr_id']) { // 현재글
			$wr_label = '<div class="label-cap bg-blue">Now</div>';
			$wr_icon = '<span class="tack-icon bg-blue">현재</span>';
		} else if($is_lock) {
			$wr_label = '<div class="label-cap bg-red">Lock</div>';
		} else if ($list[$i]['icon_hot']) {
			$wr_label = '<div class="label-cap bg-orange">Hot</div>';
			$wr_icon = '<span class="tack-icon bg-orange">인기</span>';
		} else if ($list[$i]['icon_new']) {
			$wr_label = '<div class="label-cap bg-green">New</div>';
			$wr_icon = '<span class="tack-icon bg-green">새글</span>';
		}

		// 링크
		$list[$i]['target'] = '';
		if($is_link_target && !$list[$i]['is_notice'] && $list[$i]['wr_link1']) {
			$list[$i]['target'] = $is_link_target;
			$list[$i]['href'] = $list[$i]['link_href'][1];
		}

		$list[$i]['no_img'] = $no_img; // No-Image
		if($boset['lightbox']) { //라이트박스
			$img = ($is_lock) ? apms_thumbnail($list[$i]['no_img'], 0, 0, false, true) : apms_wr_thumbnail($bo_table, $list[$i], 0, 0, false, true);
			$thumb = apms_thumbnail($img['src'], $thumb_w, $thumb_h, false, true); // 썸네일
			$caption = "<a href='".$list[$i]['href']."'>".str_replace('"', '\'', $wr_icon).apms_get_html($list[$i]['subject'], 1);
			$caption .= " &nbsp;<i class='fa fa-comment'></i> ";
			if($list[$i]['wr_comment']) $caption .= "<span class='en orangered'>".$list[$i]['wr_comment']."</span>&nbsp; ";
			$caption .= "<span class='font-normal font-11'>댓글달기</span></a>";
		} else {
			$thumb = ($is_lock) ? apms_thumbnail($list[$i]['no_img'], $thumb_w, $thumb_h, false, true) : apms_wr_thumbnail($bo_table, $list[$i], $thumb_w, $thumb_h, false, true);
		}
	?>
		<div class="media list-media">
			<div class="list-item">
				<?php if($thumb['src']) { ?>
					<div class="img <?php echo $img_align;?>">
						<div class="imgframe">
							<div class="img-wrap" style="padding-bottom:<?php echo $img_h;?>%;">
								<div class="img-item">
									<?php echo $wr_label;?>
									<?php if($boset['lightbox']) { //라이트박스 ?>
										<a href="<?php echo $img['src'];?>" data-lightbox="<?php echo $bo_table;?>-lightbox" data-title="<?php echo $caption;?>">
									<?php } else { ?>
										<a href="<?php echo $list[$i]['href'];?>"<?php echo $list[$i]['target'];?><?php echo $is_modal_js;?>>
									<?php } ?>
										<img src="<?php echo $thumb['src'];?>" alt="<?php echo $thumb['alt'];?>">
									</a>
								</div>
							</div>
						</div>
						<?php if($boset['shadow']) echo apms_shadow($boset['shadow']); //그림자 ?>
					</div>
				<?php } ?>
				<div class="media-body">
					<h2 class="media-heading">
						<a href="<?php echo $list[$i]['href'];?>"<?php echo $ellipsis;?><?php echo $list[$i]['target'];?><?php echo $is_modal_js;?>>
							<?php echo $wr_icon;?>
							<?php echo $wr_lock;?>
							<?php if($wr_id && $list[$i]['wr_id'] == $wr_id) {?>
								<span class="crimson"><?php echo $list[$i]['subject'];?></span>
							<?php } else { ?>
								<?php echo $list[$i]['subject'];?>
							<?php } ?>
						</a>
					</h2>
					<div class="list-details text-muted">
						<?php if ($is_checkbox) { ?>
							<span class="pull-right">
								<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
							</span>	
						<?php } ?>
						<?php if($boset['name']) { ?>
							<?php echo $list[$i]['name'];?>
							<span class="list-sp">|</span>
						<?php } ?>
						<?php if($is_category && $list[$i]['ca_name']) { ?>
							<span class="hidden-xs">
								<?php echo $list[$i]['ca_name'];?>
								<span class="list-sp">|</span>
							</span>
						<?php } ?>
						댓글
						<?php echo ($list[$i]['wr_comment']) ? '<span class="red">'.number_format($list[$i]['wr_comment']).'</span>' : 0;?>
						<span class="list-sp">|</span>
						조회
						<?php echo number_format($list[$i]['wr_hit']);?>
						<?php if ($boset['udp'] && $list[$i]['as_down']) { ?>
							<span class="list-sp">|</span>
							다운
							<?php echo number_format($list[$i]['as_down']); ?>P
						<?php } ?>
						<?php if ($is_good) { ?>
							<span class="list-sp">|</span>
							추천
							<?php echo number_format($list[$i]['wr_good']);?>
						<?php } ?>
						<span class="hidden-xs">
							<span class="list-sp">|</span>
							<?php echo apms_datetime($list[$i]['date'], 'Y.m.d'); ?>
						</span>
					</div>
					<?php if($cont_len > 0) { ?>
						<div class="list-cont">
							<a href="<?php echo $list[$i]['href'];?>"<?php echo $ellipsis;?><?php echo $list[$i]['target'];?><?php echo $is_modal_js;?>>
								<span class="text-muted">
									<?php echo apms_cut_text($list[$i]['wr_content'], $cont_len,'… <span class="font-11 text-muted">더보기</span>');?>
								</span>
							</a>
						</div>
					<?php } ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	<?php } ?>

</div>

<?php if (!$list_cnt) { ?>
	<div class="text-center text-muted list-none">게시물이 없습니다.</div>
<?php } ?>
