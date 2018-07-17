<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// Owl Carousel
apms_script('owlcarousel');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

// 링크 열기
$wset['modal_js'] = ($wset['modal'] == "1") ? apms_script('modal') : '';

$autoplay = (isset($wset['auto']) && ($wset['auto'] > 0 || $wset['auto'] == "0")) ? $wset['auto'] : 3000;
$speed = (isset($wset['speed']) && $wset['speed'] > 0) ? $wset['speed'] : 0;

// 간격
$gap = (isset($wset['gap']) && ($wset['gap'] > 0 || $wset['gap'] == "0")) ? $wset['gap'] : 20;
$minus = ($gap > 0) ? '-'.$gap : 0;

// 가로수
$item = (isset($wset['item']) && $wset['item'] > 0) ? $wset['item'] : 1;

// 기본수
$lg = $md = $sm = $xs = $item;

// 반응형
if(_RESPONSIVE_) {
	$lg = (isset($wset['lg']) && $wset['lg'] > 0) ? $wset['lg'] : 1;
	$md = (isset($wset['md']) && $wset['md'] > 0) ? $wset['md'] : 1;
	$sm = (isset($wset['sm']) && $wset['sm'] > 0) ? $wset['sm'] : 1;
	$xs = (isset($wset['xs']) && $wset['xs'] > 0) ? $wset['xs'] : 1;
} 

// 랜덤아이디
$widget_id = apms_id(); 

?>
<style>
	#<?php echo $widget_id;?> { position:relative; overflow:hidden; height:22px; line-height:22px; }
	#<?php echo $widget_id;?> b { letter-spacing:-1px; padding-right:1px; }
	#<?php echo $widget_id;?> .txt-normal { letter-spacing:0px; }
	#<?php echo $widget_id;?> .owl-container { margin-right:<?php echo $minus;?>px;}
	#<?php echo $widget_id;?> .item { margin-right:<?php echo $gap;?>px; }
</style>
<div id="<?php echo $widget_id;?>">
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
		<?php if($autoplay > 0) { ?>
			autoPlay:<?php echo $autoplay; ?>,
		<?php } ?>
		<?php if($speed) { ?>
			slideSpeed:<?php echo $speed; ?>,
		<?php } ?>
		items:<?php echo $item;?>,
		itemsDesktop:[1199,<?php echo $lg;?>],
		itemsDesktopSmall:[991,<?php echo $md;?>],
		itemsTablet:[767,<?php echo $sm;?>],
		itemsMobile:[480,<?php echo $xs;?>],
		navigation:false,
		pagination:false,
		loop:true
	});
});
</script>
