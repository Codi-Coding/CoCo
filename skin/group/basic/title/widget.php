<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

if(!$wset['slider_h']) $wset['slider_h'] = 35;
if(!$wset['slider']) $wset['slider'] = 0;

// 효과
$effect = apms_carousel_effect($wset['effect']);

// 간격
$interval = apms_carousel_interval($wset['interval']);

// 랜덤아이디
$slider_id = apms_id();
?>

<div id="<?php echo $slider_id;?>" class="carousel div-carousel<?php echo $effect;?>" data-ride="carousel" data-interval="<?php echo $interval;?>">
	<?php if(!$wset['nav']) { ?>
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<?php
			$k=0;
			for ($i=1; $i <= $wset['slider']; $i++) { //총 7개
				if(!$wset['use'.$i]) continue; // 사용하지 않으면 건너뜀
			?>
				<li data-target="#<?php echo $slider_id;?>" data-slide-to="<?php echo $k;?>"<?php echo (!$k) ? ' class="active"' : '';?>></li>
			<?php $k++; } ?>
		</ol>
	<?php } ?>
	<div class="carousel-inner">
		<?php
		// 슬라이더
		$k=0;
		for ($i=1; $i <= $wset['slider']; $i++) { //총 7개
			if(!$wset['use'.$i]) continue; // 사용하지 않으면 건너뜀
		?>
			<div class="item<?php echo (!$k) ? ' active' : '';?>">
				<div class="img-wrap" style="padding-bottom:<?php echo $wset['slider_h'];?>%;">
					<div class="img-item">
						<?php if($wset['label'.$i]) { // 라벨 ?>
							<div class="label-band bg-<?php echo $wset['label'.$i];?>"><?php echo apms_fa($wset['txt'.$i]); ?></div>
						<?php } ?>
						<a<?php echo ($wset['link'.$i]) ? ' href="'.$wset['link'.$i].'"' : '';?>>
							<img draggable="false" src="<?php echo $wset['img'.$i];?>" alt=""<?php echo ($wset['mm'.$i] > 0) ? ' style="margin-top:-'.$wset['mm'.$i].'%;"' : '';?>>
							<?php if($wset['title'.$i]) { // 타이틀 ?>
								<h2 class="slide-title font-18 ellipsis" style="max-width:100%;">
									<span class="white"><?php echo apms_fa($wset['title'.$i]); ?></span>
								</h2>
							<?php } ?>
						</a>
					</div>
				</div>
			</div>
		<?php $k++;} ?>
		<?php if(!$k) { ?>
			<div class="item active">
				<div class="img-wrap" style="padding-bottom:<?php echo $wset['slider_h'];?>%;">
					<div class="img-item bg-lightgray">
						<h2 class="slide-title font-18 ellipsis" style="max-width:100%;">
							위젯설정에서 사용할 타이틀을 등록해 주세요.
						</h2>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<!-- Controls -->
	<a class="left carousel-control" href="#<?php echo $slider_id;?>" role="button" data-slide="prev">
		<i class="fa fa-chevron-left" aria-hidden="true"></i>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#<?php echo $slider_id;?>" role="button" data-slide="next">
		<i class="fa fa-chevron-right" aria-hidden="true"></i>
		<span class="sr-only">Next</span>
	</a>
</div>
<?php if($wset['shadow']) echo apms_shadow($wset['shadow']); //그림자 ?>
<?php if($setup_href) { ?>
	<div class="btn-wset text-center p10">
		<a href="<?php echo $setup_href;?>" class="win_memo">
			<span class="text-muted"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>
