<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// Owl Carousel
apms_script('owlcarousel');

$is_autoplay = (isset($wset['auto']) && $wset['auto'] > 0) ? $wset['auto'] : 0;
$is_speed = (isset($wset['speed']) && $wset['speed'] > 0) ? $wset['speed'] : 0;
if(G5_IS_MOBLE) {
	$is_lazy = false;
} else {
	$is_lazy = (isset($wset['lazy']) && $wset['lazy']) ? true : false;
}

$thumb_w = (isset($wset['thumb_w']) && $wset['thumb_w'] > 0) ? $wset['thumb_w'] : 400;
$thumb_h = (isset($wset['thumb_h']) && $wset['thumb_h'] > 0) ? $wset['thumb_h'] : 540;
$img_h = apms_img_height($thumb_w, $thumb_h, '135');

$wset['line'] = (isset($wset['line']) && $wset['line'] > 0) ? $wset['line'] : 2;
$line_height = 20 * $wset['line'];

// 간격
$gap = (isset($wset['gap']) && ($wset['gap'] > 0 || $wset['gap'] == "0")) ? $wset['gap'] : 15;
$minus = ($gap > 0) ? '-'.$gap : 0;

// 가로수
$item = (isset($wset['item']) && $wset['item'] > 0) ? $wset['item'] : 4;

// 반응형
if(_RESPONSIVE_) {
	$lg = (isset($wset['lg']) && $wset['lg'] > 0) ? $wset['lg'] : 3;
	$md = (isset($wset['md']) && $wset['md'] > 0) ? $wset['md'] : 3;
	$sm = (isset($wset['sm']) && $wset['sm'] > 0) ? $wset['sm'] : 2;
	$xs = (isset($wset['xs']) && $wset['xs'] > 0) ? $wset['xs'] : 2;
}

// 새상품
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 
$new_item = ($wset['newtime']) ? $wset['newtime'] : 24;

// DC
$is_dc = (isset($wset['dc']) && $wset['dc']) ? $wset['dc'] : 'orangered'; 

// 그림자
$shadow_in = '';
$shadow_out = (isset($wset['rshadow']) && $wset['rshadow']) ? apms_shadow($wset['rshadow']) : '';
if($shadow_out && isset($wset['rinshadow']) && $wset['rinshadow']) {
	$shadow_in = '<div class="in-shadow">'.$shadow_out.'</div>';
	$shadow_out = '';	
}

$list_cnt = count($list);

?>

<style>
	#relation-item .owl-container { margin-right:<?php echo $minus;?>px;}
	#relation-item .owl-next { right:<?php echo $gap;?>px; }
	#relation-item .item { margin-right:<?php echo $gap;?>px; }
	#relation-item .item-name { height:<?php echo $line_height;?>px; }
	#relation-item .img-wrap { padding-bottom:<?php echo $img_h;?>%; }
	#relation-item .owl-hide { margin-right:<?php echo ($item > 1) ? ($gap * ($item - 1)) : $gap;?>px; }
	#relation-item .owl-hide .item { width:<?php echo apms_img_width($item);?>%; } 
	<?php if(_RESPONSIVE_) { //반응형일 때만 작동 ?>
	@media (max-width:1199px) { 
		.responsive #relation-item .owl-hide { margin-right:<?php echo ($lg > 1) ? ($gap * ($lg - 1)) : $gap;?>px; }
		.responsive #relation-item .owl-hide .item { width:<?php echo apms_img_width($lg);?>%; } 
	}
	@media (max-width:991px) { 
		.responsive #relation-item .owl-hide { margin-right:<?php echo ($md > 1) ? ($gap * ($md - 1)) : $gap;?>px; }
		.responsive #relation-item .owl-hide .item { width:<?php echo apms_img_width($md);?>%; } 
	}
	@media (max-width:767px) { 
		.responsive #relation-item .owl-hide { margin-right:<?php echo ($sm > 1) ? ($gap * ($sm - 1)) : $gap;?>px; }
		.responsive #relation-item .owl-hide .item { width:<?php echo apms_img_width($sm);?>%; } 
	}
	@media (max-width:480px) { 
		.responsive #relation-item .owl-hide { margin-right:<?php echo ($xs > 1) ? ($gap * ($xs - 1)) : $gap;?>px; }
		.responsive #relation-item .owl-hide .item { width:<?php echo apms_img_width($xs);?>%; } 
	}
	<?php } ?>
</style>
<div id="relation-item">
	<div class="owl-show">
		<div class="owl-container">
			<div class="owl-carousel">
			<?php 
			for ($i=0; $i < $list_cnt; $i++) { 

				// DC
				$cur_price = $dc_per = '';
				if($list[$i]['it_cust_price'] > 0 && $list[$i]['it_price'] > 0) {
					$cur_price = '<strike>&nbsp;'.number_format($list[$i]['it_cust_price']).'&nbsp;</strike>';
					$dc_per = round((($list[$i]['it_cust_price'] - $list[$i]['it_price']) / $list[$i]['it_cust_price']) * 100);
				}

				// 라벨
				$item_label = '';
				if($wset['rank']) {
					$rank_txt = ($rank < 4) ? 'Top'.$rank : $rank.'th';
					$item_label = '<div class="label-cap bg-red">'.$rank_txt.'</div>'; $rank++;
				} else if($dc_per || $list[$i]['it_type5']) {
					$item_label = '<div class="label-cap bg-red">DC</div>';	
				} else if($list[$i]['it_type3'] || $list[$i]['pt_num'] >= (G5_SERVER_TIME - ($new_item * 3600))) {
					$item_label = '<div class="label-cap bg-'.$wset['new'].'">New</div>';
				}

				// 아이콘
				$item_icon = item_icon($list[$i]);
				$item_icon = ($item_icon) ? '<div class="label-tack">'.$item_icon.'</div>' : '';

				// 이미지
				$img = apms_it_thumbnail($list[$i], $thumb_w, $thumb_h, false, true);

				// Lazy
				$img_src = ($is_lazy) ? 'data-src="'.$img['src'].'" class="lazyOwl"' : 'src="'.$img['src'].'"';

			?>
				<div class="item">
					<div class="item-image">
						<a href="<?php echo $list[$i]['href'];?>">
							<div class="img-wrap">
								<?php echo $shadow_in;?>
								<?php echo $item_label;?>
								<?php echo $item_icon;?>
								<div class="img-item">
									<img <?php echo $img_src;?> alt="<?php echo $img['alt'];?>">
								</div>
							</div>
						</a>
						<?php echo $shadow_out;?>
					</div>
					<div class="item-content">
						<?php if($wset['star']) { ?>
							<div class="item-star">
								<?php echo apms_get_star($list[$i]['it_use_avg'], $wset['star']); //평균별점 ?>
							</div>
						<?php } ?>
						<div class="item-name">
							<a href="<?php echo $list[$i]['href'];?>">
								<b><?php echo $list[$i]['it_name'];?></b>
								<div class="item-text">
									<?php echo ($list[$i]['it_basic']) ? $list[$i]['it_basic'] : apms_cut_text($list[$i]['it_explan'], 120); ?>
								</div>
							</a>
						</div>
						<div class="item-price en">
							<?php if($list[$i]['it_tel_inq']) { ?>
								<b>Call</b>
							<?php } else { ?>
								<?php echo $cur_price;?>
								<b><i class="fa fa-krw"></i> <?php echo number_format($list[$i]['it_price']);?></b>
							<?php } ?>
						</div>
						<div class="item-details en">
							<?php if($wset['cmt'] && $list[$i]['pt_comment']) { ?>
								<span class="item-sp red">
									<i class="fa fa-comment"></i> 
									<?php echo number_format($list[$i]['pt_comment']);?>
								</span>
							<?php } ?>
							<?php if($wset['buy'] && $list[$i]['it_sum_qty']) { ?>
								<span class="item-sp blue">
									<i class="fa fa-shopping-cart"></i>
									<?php echo number_format($list[$i]['it_sum_qty']);?>
								</span>
							<?php } ?>
							<?php if($wset['hit'] && $list[$i]['it_hit']) { ?>
								<span class="item-sp gray">
									<i class="fa fa-eye"></i> 
									<?php echo number_format($list[$i]['it_hit']);?>
								</span>
							<?php } ?>
							<?php if($list[$i]['it_point']) { ?>
								<span class="item-sp green">
									<i class="fa fa-gift"></i> 
									<?php echo ($list[$i]['it_point_type'] == 2) ? $list[$i]['it_point'].'%' : number_format(get_item_point($list[$i]));?>
								</span>
							<?php } ?>
							<?php if($dc_per) { ?>
								<span class="item-sp orangered">
									<i class="fa fa-bolt"></i> 
									<?php echo $dc_per;?>% DC
								</span>
							<?php } ?>
						</div>
					</div>
					<?php if($wset['sns']) { ?>
						<div class="item-sns">
							<?php 
								$sns_url  = G5_SHOP_URL.'/item.php?it_id='.$list[$i]['it_id'];
								$sns_title = get_text($list[$i]['it_name']);
								$sns_img = $item_skin_url.'/img';
								echo  get_sns_share_link('facebook', $sns_url, $sns_title, $sns_img.'/sns_fb.png').' ';
								echo  get_sns_share_link('twitter', $sns_url, $sns_title, $sns_img.'/sns_twt.png').' ';
								echo  get_sns_share_link('googleplus', $sns_url, $sns_title, $sns_img.'/sns_goo.png').' ';
								echo  get_sns_share_link('kakaostory', $sns_url, $sns_title, $sns_img.'/sns_kakaostory.png').' ';
								echo  get_sns_share_link('kakaotalk', $sns_url, $sns_title, $sns_img.'/sns_kakao.png').' ';
								echo  get_sns_share_link('naverband', $sns_url, $sns_title, $sns_img.'/sns_naverband.png').' ';
							?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
	<div class="owl-hide">
		<div class="item">
			<div class="item-image">
				<div class="img-wrap">
					<div class="img-item">&nbsp;</div>
				</div>
				<?php echo $shadow_out;?>
			</div>
			<div class="item-content">
				<?php if($wset['star']) { ?>
					<div class="item-star">&nbsp;</div>
				<?php } ?>
				<div class="item-name">&nbsp;</div>
				<div class="item-price en">&nbsp;</div>
				<div class="item-details en">&nbsp;</div>
			</div>
			<?php if($wset['sns']) { ?>
				<div class="item-sns"><img src="<?php echo $item_skin_url;?>/img/sns_fb.png"></div>
			<?php } ?>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#relation-item .owl-carousel').owlCarousel({
		<?php if(isset($wset['rdm']) && $wset['rdm']) { ?> 
		beforeInit : function(elem){
			owl_random(elem);
		},
		<?php } ?>
		<?php if($is_autoplay > 0) { ?>
			autoPlay:<?php echo $is_autoplay; ?>,
		<?php } ?>
		<?php if($is_speed) { ?>
			slideSpeed:<?php echo $is_speed; ?>,
		<?php } ?>
		<?php if($is_lazy) { ?>
			lazyLoad : true,
		<?php } ?>
		items:<?php echo $item;?>,
		<?php if(_RESPONSIVE_) { //반응형일 때만 작동 ?>
		itemsDesktop:[1199,<?php echo $lg;?>],
		itemsDesktopSmall:[991,<?php echo $md;?>],
		itemsTablet:[767,<?php echo $sm;?>],
		itemsMobile:[480,<?php echo $xs;?>],
		<?php } else { ?>
		responsive:false,
		<?php } ?>
		pagination:<?php echo ($wset['dot']) ? 'true' : 'false';?>,
		<?php if(isset($wset['nav']) && $wset['nav']) { ?> 
		navigationText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
		navigation:true,
		<?php } else { ?>
		navigation:false,
		<?php } ?>
		loop:true,
		afterInit : function() {
			$('#relation-item .owl-hide').hide();
		}
	});
});
</script>