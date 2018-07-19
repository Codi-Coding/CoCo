<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// Owl Carousel
apms_script('owlcarousel');

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

$is_autoplay = (isset($wset['auto']) && ($wset['auto'] > 0 || $wset['auto'] == "0")) ? $wset['auto'] : 3000;
$is_speed = (isset($wset['speed']) && $wset['speed'] > 0) ? $wset['speed'] : 0;
if(G5_IS_MOBILE) {
	$is_lazy = false;
} else {
	$is_lazy = (isset($wset['lazy']) && $wset['lazy']) ? true : false;
}

$wset['thumb_w'] = (isset($wset['thumb_w']) && $wset['thumb_w'] > 0) ? $wset['thumb_w'] : 400;
$wset['thumb_h'] = (isset($wset['thumb_h']) && $wset['thumb_h'] > 0) ? $wset['thumb_h'] : 225;
$img_h = apms_img_height($wset['thumb_w'], $wset['thumb_h'], '56.25');

// 간격
$gap = (isset($wset['gap']) && ($wset['gap'] > 0 || $wset['gap'] == "0")) ? $wset['gap'] : 15;

// 가로수
$item = (isset($wset['item']) && $wset['item'] > 0) ? $wset['item'] : 1;

// 기본수
$lg = $md = $sm = $xs = $item;

// 랜덤아이디
$widget_id = apms_id(); 

?>
<style>
	#<?php echo $widget_id;?> .owl-container { margin-right:<?php echo $gap * (-1);?>px;}
	#<?php echo $widget_id;?> .owl-next { right:<?php echo $gap;?>px; }
	#<?php echo $widget_id;?> .owl-hide { margin-right:<?php echo ($item > 1) ? ($gap * ($item - 1)) : $gap;?>px; }
	#<?php echo $widget_id;?> .owl-hide .item { width:<?php echo apms_img_width($item);?>%; } 
	#<?php echo $widget_id;?> .item-list { margin-right:<?php echo $gap;?>px; }
	#<?php echo $widget_id;?> .item-name { height:<?php echo $line_height;?>px; }
	#<?php echo $widget_id;?> .img-wrap { padding-bottom:<?php echo $img_h;?>%; }
	<?php if(_RESPONSIVE_) { //반응형일 때만 작동 
		$lg = (isset($wset['lg']) && $wset['lg'] > 0) ? $wset['lg'] : 1;
		$lgg = (isset($wset['lgg']) && ($wset['lgg'] > 0 || $wset['lgg'] == "0")) ? $wset['lgg'] : $gap;

		$md = (isset($wset['md']) && $wset['md'] > 0) ? $wset['md'] : 1;
		$mdg = (isset($wset['mdg']) && ($wset['mdg'] > 0 || $wset['mdg'] == "0")) ? $wset['mdg'] : $lgg;

		$sm = (isset($wset['sm']) && $wset['sm'] > 0) ? $wset['sm'] : 1;
		$smg = (isset($wset['smg']) && ($wset['smg'] > 0 || $wset['smg'] == "0")) ? $wset['smg'] : $mdg;

		$xs = (isset($wset['xs']) && $wset['xs'] > 0) ? $wset['xs'] : 1;
		$xsg = (isset($wset['xsg']) && ($wset['xsg'] > 0 || $wset['xsg'] == "0")) ? $wset['xsg'] : $smg;
	?>
	@media (max-width:1199px) { 
		.responsive #<?php echo $widget_id;?> .owl-container { margin-right:<?php echo $lgg * (-1);?>px;}
		.responsive #<?php echo $widget_id;?> .owl-next { right:<?php echo $lgg;?>px; }
		.responsive #<?php echo $widget_id;?> .owl-hide { margin-right:<?php echo ($lg > 1) ? ($lgg * ($lg - 1)) : $lgg;?>px; }
		.responsive #<?php echo $widget_id;?> .owl-hide .item { width:<?php echo apms_img_width($lg);?>%; }
		.responsive #<?php echo $widget_id;?> .item-list { margin-right:<?php echo $lgg;?>px; }
	}
	@media (max-width:991px) { 
		.responsive #<?php echo $widget_id;?> .owl-container { margin-right:<?php echo $mdg * (-1);?>px;}
		.responsive #<?php echo $widget_id;?> .owl-next { right:<?php echo $mdg;?>px; }
		.responsive #<?php echo $widget_id;?> .owl-hide { margin-right:<?php echo ($md > 1) ? ($mdg * ($md - 1)) : $mdg;?>px; }
		.responsive #<?php echo $widget_id;?> .owl-hide .item { width:<?php echo apms_img_width($md);?>%; } 
		.responsive #<?php echo $widget_id;?> .item-list { margin-right:<?php echo $mdg;?>px; }
	}
	@media (max-width:767px) { 
		.responsive #<?php echo $widget_id;?> .owl-container { margin-right:<?php echo $smg * (-1);?>px;}
		.responsive #<?php echo $widget_id;?> .owl-next { right:<?php echo $smg;?>px; }
		.responsive #<?php echo $widget_id;?> .owl-hide { margin-right:<?php echo ($sm > 1) ? ($smg * ($sm - 1)) : $smg;?>px; }
		.responsive #<?php echo $widget_id;?> .owl-hide .item { width:<?php echo apms_img_width($sm);?>%; } 
		.responsive #<?php echo $widget_id;?> .item-list { margin-right:<?php echo $smg;?>px; }
	}
	@media (max-width:480px) { 
		.responsive #<?php echo $widget_id;?> .owl-container { margin-right:<?php echo $xsg * (-1);?>px;}
		.responsive #<?php echo $widget_id;?> .owl-next { right:<?php echo $xsg;?>px; }
		.responsive #<?php echo $widget_id;?> .owl-hide { margin-right:<?php echo ($xs > 1) ? ($xsg * ($xs - 1)) : $xsg;?>px; }
		.responsive #<?php echo $widget_id;?> .owl-hide .item { width:<?php echo apms_img_width($xs);?>%; } 
		.responsive #<?php echo $widget_id;?> .item-list { margin-right:<?php echo $xsg;?>px; }
	}
	<?php } ?>
</style>
<div id="<?php echo $widget_id;?>" class="basic-shop-banner-slider">
	<?php
		if($wset['cache'] > 0) { // 캐시적용시
			echo apms_widget_cache($widget_path.'/widget.rows.php', $wname, $wid, $wset);
		} else {
			include($widget_path.'/widget.rows.php');
		}
	?>
</div>
<?php if($setup_href) { ?>
	<div class="btn-wset text-center p10">
		<a href="<?php echo $setup_href;?>" class="win_memo">
			<span class="text-muted font-12"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>
<script>
$(document).ready(function(){
	$('#<?php echo $widget_id;?> .owl-carousel').owlCarousel({
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
		itemsDesktop:[1199,<?php echo $lg;?>],
		itemsDesktopSmall:[991,<?php echo $md;?>],
		itemsTablet:[767,<?php echo $sm;?>],
		itemsMobile:[480,<?php echo $xs;?>],
		pagination:<?php echo ($wset['dot']) ? 'true' : 'false';?>,
		<?php if(isset($wset['nav']) && $wset['nav']) { ?> 
		navigationText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
		navigation:true,
		<?php } else { ?>
		navigation:false,
		<?php } ?>
		loop:true,
		afterInit : function() {
			$('#<?php echo $widget_id;?> .owl-hide').hide();
		}
	});
});
</script>