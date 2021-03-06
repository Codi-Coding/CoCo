<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 위젯 대표아이디 설정
$wid = 'SMBL';

// 게시판 제목 폰트 설정
$font = 'font-16 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'navy';

// 사이드 위치 설정 - left, right
$side = ($at_set['side']) ? 'left' : 'right';

?>
<style>
	.widget-index .div-title-underbar { margin-bottom:15px; }
	.widget-index .div-title-underbar span { padding-bottom:4px; }
	.widget-index .div-title-underbar span b { font-weight:500; }
	.widget-index h2.div-title-underbar { font-size:22px; text-align:center; margin-bottom:15px; /* 위젯 타이틀 */ }
	.widget-index h2 .div-title-underbar-bold { font-weight:bold; padding-bottom:4px; border-bottom-width:4px; margin-bottom:-3px; }
	.widget-index .widget-box { margin-bottom:25px; }
	.widget-index .at-main .widget-box { margin-bottom:40px; }
	.widget-index .widget-img img { display:block; max-width:100%; /* 배너 이미지 */ }
	@media all and (max-width:767px) {
		.responsive .widget-index .at-main .widget-box { margin-bottom:30px; }
	}
</style>

<?php //echo apms_widget('basic-title', $wid.'-wt1', 'shadow=4 height=400px', 'auto=0'); //타이틀 ?>

<div class="at-container widget-index">

	<div class="row at-row">
		<!-- 메인 영역 -->
		<div class="col-md-9<?php echo ($side == "left") ? ' pull-right' : '';?> at-col at-main">

			<!-- 히트 & 베스트 시작 -->
			<h2 class="div-title-underbar">
				<a href="<?php echo $at_href['itype'];?>?type=1">
					<span class="pull-right lightgray">+</span>
					<span class="div-title-underbar-bold border-<?php echo $line;?>">
						Hit & Best123
					</span>
				</a>
			</h2>
			<div class="widget-box">
				<?php echo apms_widget('basic-shop-item-slider', $wid.'-wm1', 'type1=1 type4=1 auto=0 nav=1', 'auto=0'); ?>
			</div>
			<!-- 히트 & 베스트 끝 -->

			<!-- 추천 & 신상 시작 -->
			<h2 class="div-title-underbar">
				<a href="<?php echo $at_href['itype'];?>?type=2">
					<span class="pull-right lightgray">+</span>
					<span class="div-title-underbar-bold border-<?php echo $line;?>">
						Cool & New
					</span>
				</a>
			</h2>

			<div class="widget-box">
				<?php echo apms_widget('basic-shop-item-slider', $wid.'-wm2', 'type2=1 type3=1 auto=0 nav=1', 'auto=0'); ?>
			</div>
			<!-- 추천 & 신상 끝 -->

			<!-- 이미지 배너 시작 -->	
			<div class="widget-box widget-img">
				<a href="#배너이동주소">
					<img src="<?php echo THEMA_URL;?>/assets/img/banner.jpg">
				</a>
			</div>
			<!-- 이미지 배너 끝 -->	

			<!-- 할인 시작 -->
			<h2 class="div-title-underbar">
				<a href="<?php echo $at_href['itype'];?>?type=5">
					<span class="pull-right lightgray">+</span>
					<span class="div-title-underbar-bold border-<?php echo $line;?>">
						Discount
					</span>
				</a>
			</h2>

			<div class="widget-box">
				<?php echo apms_widget('basic-shop-item-slider', $wid.'-wm3', 'type5=1 auto=0 nav=1', 'auto=0'); ?>
			</div>
			<!-- 할인 끝 -->

			<?php echo apms_line('fa', 'fa-cube'); // 라인 ?>

			<!-- 상품목록 시작 -->	
			<div class="widget-box">
				<?php echo apms_widget('basic-shop-item-gallery', $wid.'-wm6'); ?>
			</div>
			<!-- 상품목록 끝 -->	

		</div>
		<!-- 사이드 영역 -->
		<div class="col-md-3<?php echo ($side == "left") ? ' pull-left' : '';?> at-col at-side">

			<?php if(!G5_IS_MOBILE) { //PC일 때만 출력 ?>
				<div class="hidden-sm hidden-xs">
					<!-- 로그인 시작 -->
					<div class="div-title-underbar">
						<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
							<b><?php echo ($is_member) ? 'Profile' : 'Login';?></b>
						</span>
					</div>

					<div class="widget-box">
						<?php echo apms_widget('basic-outlogin'); //외부로그인 ?>
					</div>
					<!-- 로그인 끝 -->
				</div>
			<?php } ?>

	</div>
</div>
