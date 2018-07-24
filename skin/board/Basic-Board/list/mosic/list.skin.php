<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($boset['lightbox']) apms_script('lightbox');

apms_script('mosaic');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$list_skin_url.'/list.css" media="screen">', 0);

// 너비
$item_w = apms_img_width($board['bo_gallery_cols']);

// 간격
$gap = ($boset['gap'] == "") ? 5 : $boset['gap'];

// 이미지 비율
$thumb_w = $board['bo_'.MOBILE_.'gallery_width'];
//$thumb_h = $board['bo_'.MOBILE_.'gallery_height'];
$thumb_h = 0;

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
	.list-wrap .list-mosaic { overflow:hidden; list-style:none; padding:0; margin:0 <?php echo ($gap > 0) ? '-'.$gap : 0;?>px <?php echo ($gap > 15) ? $gap : 15;?>px }
	.list-wrap .list-row { float:left; }
</style>
<ul class="list-mosaic">
	<?php
	// 리스트
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

		//Caption
		if($boset['lightbox']) {
			$img = ($is_lock) ? apms_thumbnail($list[$i]['no_img'], 0, 0, false, true) : apms_wr_thumbnail($bo_table, $list[$i], 0, 0, false, true);
			$thumb = apms_thumbnail($img['src'], $thumb_w, $thumb_h, false, true); // 썸네일
			$caption = "<a href='".$list[$i]['href']."'>".$wr_icon.apms_get_html($list[$i]['subject'], 1);
			$caption .= " &nbsp;<i class='fa fa-comment'></i> ";
			if($list[$i]['wr_comment']) $caption .= "<span class='en orangered'>".$list[$i]['wr_comment']."</span>&nbsp; ";
			$caption .= "<span class='font-normal font-11'>댓글달기</span></a>";
		} else {
			$thumb = ($is_lock) ? apms_thumbnail($list[$i]['no_img'], $thumb_w, $thumb_h, false, true) : apms_wr_thumbnail($bo_table, $list[$i], $thumb_w, $thumb_h, false, true);
		}

	?>
		<li class="list-row">
			<div class="list-item">
				<div class="list-img">
					<?php echo $wr_label;?>
					<?php if ($is_checkbox) { ?>
						<div class="tack-check<?php echo ($boset['right']) ? '-left' : '';?>">
							<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
						</div>	
					<?php } ?>
					<?php if($boset['lightbox']) { ?>
						<a href="<?php echo $img['src'];?>" data-lightbox="<?php echo $bo_table;?>-lightbox" data-title="<?php echo $caption;?>">
					<?php } else { ?>
						<a href="<?php echo $list[$i]['href'];?>"<?php echo $list[$i]['target'];?><?php echo $is_modal_js;?>>
					<?php } ?>
						<img src="<?php echo $thumb['src'];?>" alt="<?php echo $img['alt'];?>">
					</a>
					<?php if($is_date) { ?>
						<div class="list-date <?php echo $is_date;?> en">
							<?php echo date("Y.m.d", $list[$i]['date']); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</li>
	<?php } ?>

</ul>
<div class="clearfix"></div>
<?php if (!$list_cnt) { ?>
	<div class="text-center text-muted list-none">게시물이 없습니다.</div>
<?php } ?>
<script>
	$(function(){
		var $container = $('.list-mosaic');

		$container.jMosaic({
			items_type: "li", 
			margin: <?php echo $gap;?>,
			min_row_height: <?php echo ($boset['min_h'] > 0) ? $boset['min_h'] : 180;?>
		});

		$(window).resize(function() {
			$container.jMosaic({
				items_type: "li", 
				margin: <?php echo $gap;?>,
				min_row_height: <?php echo ($boset['min_h'] > 0) ? $boset['min_h'] : 180;?>
			});
		});
	});
</script>
