<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

if(!$wset['slider']) {
	$wset['slider'] = 2;
	for($i=1; $i <= 2; $i++) {
		$wset['use'.$i] = 1;
		$wset['cl'.$i] = 'center';
		$wset['img'.$i] = $widget_url.'/img/title.jpg';
		$wset['cs'.$i] = 'title';
		$wset['cf'.$i] = 'white';
		$wset['cc'.$i] = 'black';
		$wset['caption'.$i] = '위젯설정에서 사용할 타이틀을 등록해 주세요.';
	}
}

// 높이
$height = (isset($wset['height']) && $wset['height']) ? $wset['height'] : '400px';
$lg = (isset($wset['lg']) && $wset['lg']) ? $wset['lg'] : '';
$md = (isset($wset['md']) && $wset['md']) ? $wset['md'] : '';
$sm = (isset($wset['sm']) && $wset['sm']) ? $wset['sm'] : '';
$xs = (isset($wset['xs']) && $wset['xs']) ? $wset['xs'] : '';

// 효과
$effect = apms_carousel_effect($wset['effect']);

// 간격
if($wset['auto'] == "") {
	$wset['auto'] = 3000;
}
$interval = apms_carousel_interval($wset['auto']);

// 작은화살표
$is_small = (isset($wset['arrow']) && $wset['arrow']) ? ' div-carousel' : '';

$list = array();

// 슬라이더
$k=0;
for ($i=1; $i <= $wset['slider']; $i++) {

	if(!$wset['use'.$i]) continue; // 사용하지 않으면 건너뜀

	$list[$k]['cl'] = ($wset['cl'.$i]) ? ' background-position:'.$wset['cl'.$i].' center;' : '';
	$list[$k]['img'] = $wset['img'.$i];
	$list[$k]['link'] = ($wset['link'.$i]) ? $wset['link'.$i] : 'javascript:;';
	$list[$k]['target'] = ($wset['target'.$i]) ? ' target="'.$wset['target'.$i].'"' : '';
	$list[$k]['label'] = $wset['label'.$i];
	$list[$k]['txt'] = $wset['txt'.$i];
	$list[$k]['cs'] = $wset['cs'.$i];
	$list[$k]['caption'] = $wset['caption'.$i];
	$list[$k]['cf'] = $wset['cf'.$i];
	$list[$k]['cc'] = $wset['cc'.$i];
	$k++;
}

$list_cnt = count($list);

// 랜덤
if($wset['rdm'] && $list_cnt) shuffle($list);

// 랜덤아이디
$widget_id = apms_id(); 

?>
<style>

	#<?php echo $widget_id;?> .item { background-size:cover; background-position:center center; background-repeat:no-repeat; }
	#<?php echo $widget_id;?> .img-wrap { padding-bottom:<?php echo $height;?>; }
	#<?php echo $widget_id;?> .tab-indicators { position:absolute; left:0; bottom:0; width:100%; }
	#<?php echo $widget_id;?> .nav a { background: rgba(255,255,255, 0.9); color:#000; border-radius: 0px; margin:0px; }
	#<?php echo $widget_id;?> .nav a:hover, #<?php echo $widget_id;?> .nav a:focus,
	#<?php echo $widget_id;?> .nav .active a { background: rgba(0,0,0, 0.6); color:#fff; }
	<?php if(_RESPONSIVE_) { //반응형일 때만 작동 ?>
		<?php if($lg) { ?>
		@media (max-width:1199px) { 
			.responsive #<?php echo $widget_id;?> .img-wrap { padding-bottom:<?php echo $lg;?> !important; } 
		}
		<?php } ?>
		<?php if($md) { ?>
		@media (max-width:991px) { 
			.responsive #<?php echo $widget_id;?> .img-wrap { padding-bottom:<?php echo $md;?> !important; } 
		}
		<?php } ?>
		<?php if($sm) { ?>
		@media (max-width:767px) { 
			.responsive #<?php echo $widget_id;?> .img-wrap { padding-bottom:<?php echo $sm;?> !important; } 
		}
		<?php } ?>
		<?php if($xs) { ?>
		@media (max-width:480px) { 
			.responsive #<?php echo $widget_id;?> .img-wrap { padding-bottom:<?php echo $xs;?> !important; } 
		}
		<?php } ?>
	<?php } ?>
</style>
<div id="<?php echo $widget_id;?>" class="swipe-carousel carousel<?php echo $is_small;?><?php echo $effect;?>" data-ride="carousel" data-interval="<?php echo $interval;?>">
	<div class="carousel-inner bg-black">
		<?php for ($i=0; $i < $list_cnt; $i++) { ?>
			<div class="item<?php echo (!$i) ? ' active' : '';?>" style="background-image: url('<?php echo $list[$i]['img'];?>');<?php echo $list[$i]['cl'];?>">
				<a href="<?php echo $list[$i]['link'];?>"<?php echo $list[$i]['target'];?>>
					<div class="img-wrap">
						<div class="img-item">
							<?php if($list[$i]['label']) { // 라벨 ?>
								<div class="label-band bg-<?php echo $list[$i]['label'];?>"><?php echo apms_fa($list[$i]['txt']); ?></div>
							<?php } ?>
							<?php if($list[$i]['cs'] && $list[$i]['caption']) { // 캡션 ?>
								<div class="en in-<?php echo $list[$i]['cs'];?> font-<?php echo $list[$i]['cf'];?> trans-bg-<?php echo $list[$i]['cc'];?>">
									<?php echo apms_fa($list[$i]['caption']); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</a>
			</div>
		<?php $k++;} ?>
	</div>

	<?php if($wset['arrow'] != '2') { ?>
		<!-- Controls -->
		<a class="left carousel-control" href="#<?php echo $widget_id;?>" role="button" data-slide="prev">
			<?php if($is_small) { ?>
				<i class="fa fa-chevron-left" aria-hidden="true"></i>
			<?php } else { ?>
			   <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<?php } ?>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#<?php echo $widget_id;?>" role="button" data-slide="next">
			<?php if($is_small) { ?>
				<i class="fa fa-chevron-right" aria-hidden="true"></i>
			<?php } else { ?>
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<?php } ?>
			<span class="sr-only">Next</span>
		</a>
	<?php } ?>

	<!-- Indicators -->
	<?php if($wset['nav']) { ?>
		<ol class="carousel-indicators" style="z-index:2;margin-bottom:0px;bottom:<?php echo ($wset['dot']) ? $wset['dot'] : '10px';?>;">
			<?php for ($i=0; $i < $list_cnt; $i++) { ?>
				<li data-target="#<?php echo $widget_id;?>" data-slide-to="<?php echo $i;?>"<?php echo (!$i) ? ' class="active"' : '';?>></li>
			<?php } ?>
		</ol>
	<?php } ?>
</div>
<?php if($wset['shadow']) echo apms_shadow($wset['shadow']); //그림자 ?>
<?php if($setup_href) { ?>
	<div class="btn-wset text-center p10">
		<a href="<?php echo $setup_href;?>" class="win_memo">
			<span class="text-muted font-12"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>
