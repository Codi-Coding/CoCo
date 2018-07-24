<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 스크립트 불러오기
if($boset['masonry']) {
	apms_script('masonry');
	apms_script('imagesloaded');
}

if(!$is_modal_js) apms_script('lightbox');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$list_skin_url.'/list.css" media="screen">', 0);

// 너비
$item_w = apms_img_width($board['bo_gallery_cols']);

// 간격
$gap_right = ($boset['gap_r'] == "") ? 15 : $boset['gap_r'];
$gap_bottom = ($boset['gap_b'] == "") ? 15 : $boset['gap_b'];

// 이미지 비율
$thumb_w = $board['bo_'.MOBILE_.'gallery_width'];
$thumb_h = $board['bo_'.MOBILE_.'gallery_height'];
$img_h = apms_img_height($thumb_w, $thumb_h); // 이미지 높이

// 날짜
$is_date = '';
if($boset['date']) {
	$is_date = ($boset['trans']) ? 'trans-bg-'.$boset['date'] : 'bg-'.$boset['date'];
	$is_date = ($boset['right']) ? $is_date.' right' : $is_date.' left';
}

// 타켓
$target = ($boset['ltarget']) ? ' target="_blank"' : '';

?>
<style>
	.list-wrap .list-container { overflow:hidden; margin-right:<?php echo ($gap_right > 0) ? '-'.$gap_right : 0;?>px; margin-bottom:<?php echo ($gap_bottom > 15) ? 0 : 15;?>px; }
	.list-wrap .list-row { float:left; width:<?php echo $item_w;?>%; }
	.list-wrap .list-item { margin-right:<?php echo $gap_right;?>px; margin-bottom:<?php echo $gap_bottom;?>px; }
</style>
<div class="list-container">
	<?php
	$k = 0;
	for ($i=0; $i < $list_cnt; $i++) { 

		if($list[$i]['is_notice']) continue;		

		// 아이콘 체크
		$is_lock = false;
		$wr_icon = $wr_label = '';
		if ($list[$i]['icon_secret'] || $list[$i]['is_lock']) {
			$wr_icon = "<span class='tack-icon bg-red'>비밀</span> ";
			$wr_label = '<div class="label-cap bg-red">Lock</div>';
			$is_lock = true;
		} else if ($list[$i]['icon_hot']) {
			$wr_icon = "<span class='tack-icon bg-orange'>인기</span> ";
			$wr_label = '<div class="label-cap bg-orange">Hot</div>';
		} else if ($list[$i]['icon_new']) {
			$wr_icon = "<span class='tack-icon bg-green'>새글</span> ";
			$wr_label = '<div class="label-cap bg-green">New</div>';
		}

		if($wr_id && $list[$i]['wr_id'] == $wr_id) {
			$wr_label = '<div class="label-cap bg-blue">Now</div>';
		}

		// 링크
		$list[$i]['target'] = '';
		if($is_link_target && !$list[$i]['is_notice'] && $list[$i]['wr_link1']) {
			$list[$i]['target'] = $is_link_target;
			$list[$i]['href'] = $list[$i]['link_href'][1];
		}

		// 썸네일
		$list[$i]['no_img'] = $board_skin_url.'/img/no-img.jpg'; // No-Image
		$img = ($is_lock) ? apms_thumbnail($list[$i]['no_img'], 0, 0, false, true) : apms_wr_thumbnail($bo_table, $list[$i], 0, 0, false, true);
		$thumb = apms_thumbnail($img['src'], $thumb_w, $thumb_h, false, true); // 썸네일

		//Caption
		if($list[$i]['target']) {
			$caption = "<a href='".$list[$i]['href']."' target='_blank'>".$wr_icon.apms_get_html($list[$i]['subject'], 1)."</a>";
		} else {
			$caption = "<a href='".$list[$i]['href']."'>".$wr_icon.apms_get_html($list[$i]['subject'], 1);
			$caption .= " &nbsp;<i class='fa fa-comment'></i> ";
			if($list[$i]['wr_comment']) $caption .= "<span class='en orangered'>".$list[$i]['wr_comment']."</span>&nbsp; ";
			$caption .= "<span class='font-normal font-11'>댓글달기</span></a>";
		}

	?>
		<?php if(!$boset['masonry'] && $k > 0 && $k%$board['bo_gallery_cols'] == 0) { ?>
			<div class="list-row clearfix"></div>
		<?php } ?>
		<div class="list-row">
			<div class="list-item">
				<?php if($thumb_h > 0) { ?>
					<div class="imgframe">
						<div class="img-wrap" style="padding-bottom:<?php echo $img_h;?>%;">
							<div class="img-item">
								<?php echo $wr_label;?>
								<?php if ($is_checkbox) { ?>
									<div class="tack-check<?php echo ($boset['right']) ? '-left' : '';?>">
										<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
									</div>	
								<?php } ?>
								<?php if($is_modal_js) { ?>
									<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js;?>>
								<?php } else { ?>
									<a href="<?php echo $img['src'];?>" data-lightbox="<?php echo $bo_table;?>-lightbox" data-title="<?php echo $caption;?>">
								<?php } ?>
									<img src="<?php echo $thumb['src'];?>" alt="<?php echo $img['alt'];?>">
								</a>
							</div>
						</div>
						<?php if($is_date) { ?>
							<div class="list-date <?php echo $is_date;?> en">
								<?php echo date("Y.m.d", $list[$i]['date']); ?>
							</div>
						<?php } ?>
					</div>
				<?php } else { ?>
					<div class="list-img">
						<?php echo $wr_label;?>
						<?php if ($is_checkbox) { ?>
							<div class="tack-check<?php echo ($boset['right']) ? '-left' : '';?>">
								<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
							</div>	
						<?php } ?>
						<?php if($is_modal_js) { ?>
							<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js;?>>
						<?php } else { ?>
							<a href="<?php echo $img['src'];?>" data-lightbox="<?php echo $bo_table;?>-lightbox" data-title="<?php echo $caption;?>">
						<?php } ?>
							<img src="<?php echo $thumb['src'];?>" alt="<?php echo $img['alt'];?>">
						</a>
						<?php if($is_date) { ?>
							<div class="list-date <?php echo $is_date;?> en">
								<?php echo date("Y.m.d", $list[$i]['date']); ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				<?php if($boset['shadow']) echo apms_shadow($boset['shadow']); //그림자 ?>
			</div>
		</div>
	<?php $k++; } ?>

</div>
<div class="clearfix"></div>
<?php if (!$list_cnt) { ?>
	<div class="text-center text-muted list-none">게시물이 없습니다.</div>
<?php } ?>

<?php if($boset['masonry']) { // 메이선리 ?>
	<script>
		$(function(){
			var $container = $('.list-container');
			$container.imagesLoaded(function(){
				$container.masonry({
					columnWidth : '.list-row',
					itemSelector : '.list-row',
					isAnimated: true
				});
			});
		});
	</script>
<?php } ?>