<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 추출하기
$list = apms_banner_event_rows($wset);
$list_cnt = count($list);

// 캡션
$is_caption = (isset($wset['caption']) && $wset['caption']) ? true : false;

// 그림자
$shadow_in = '';
$shadow_out = (isset($wset['shadow']) && $wset['shadow']) ? apms_shadow($wset['shadow']) : '';
if($shadow_out && isset($wset['inshadow']) && $wset['inshadow']) {
	$shadow_in = '<div class="in-shadow">'.$shadow_out.'</div>';
	$shadow_out = '';	
}

// owl-hide : 모양유지용 프레임
if($list_cnt) {
?>
	<div class="owl-show">
		<div class="owl-container">
			<div class="owl-carousel">
			<?php 
			for ($i=0; $i < $list_cnt; $i++) { 

				// Lazy
				$img_src = ($is_lazy) ? 'data-src="'.$list[$i]['img'].'" class="lazyOwl"' : 'src="'.$list[$i]['img'].'"';

			?>
				<div class="item">
					<div class="item-list">
						<div class="item-image">
							<a href="<?php echo $list[$i]['href'];?>">
								<div class="img-wrap">
									<?php echo $shadow_in;?>
									<div class="img-item">
										<img <?php echo $img_src;?> alt="<?php echo $list[$i]['alt'];?>">
										<?php if($is_caption) { ?>
											<div class="in-subject trans-bg-black">
												<?php echo $list[$i]['ev_subject'];?>
											</div>
										<?php } ?>
									</div>
								</div>
							</a>
							<?php echo $shadow_out;?>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
	<div class="owl-hide">
		<div class="item">
			<div class="item-list">
				<div class="item-image">
					<div class="img-wrap">
						<div class="img-item">&nbsp;</div>
					</div>
					<?php echo $shadow_out;?>
				</div>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="item-none">
		등록된 이벤트가 없습니다.
	</div>
<?php } ?>