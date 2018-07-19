<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 위젯 대표아이디 설정
$wid = 'SMBWL';

// 게시판 제목 폰트 설정
$font = 'font-18 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'navy';

?>
<style>
	.widget-index { overflow:hidden; }
	.widget-index .div-title-underbar { margin-bottom:15px; }
	.widget-index .div-title-underbar span { padding-bottom:4px; }
	.widget-index .div-title-underbar span b { font-weight:500; }
	.widget-index h2.div-title-underbar { font-size:22px; text-align:center; margin-bottom:15px; /* 위젯 타이틀 */ }
	.widget-index h2 .div-title-underbar-bold { font-weight:bold; padding-bottom:4px; border-bottom-width:4px; margin-bottom:-3px; }
	.widget-index .widget-box { margin-bottom:40px; }
	.widget-index .widget-img img { display:block; max-width:100%; /* 배너 이미지 */ }
	@media all and (max-width:767px) {
		.responsive .widget-index .widget-box { margin-bottom:30px; }
	}
</style>

<?php echo apms_widget('basic-title', $wid.'-wt1', 'shadow=4 height=400px', 'auto=0'); //타이틀 ?>

<div class="h20"></div>

<div class="at-container widget-index">

	<div class="row">
		<div class="col-sm-8">
			<!-- 이벤트 시작 -->
			<div class="div-title-underbar">
				<a href="<?php echo $at_href['event'];?>">
					<span class="pull-right lightgray <?php echo $font;?>">+</span>
					<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
						<b>Event</b>
					</span>
				</a>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('basic-shop-event-slider', $wid.'-we1', 'caption=1 nav=1 item=3 lg=2 md=2 sm=2', 'auto=0'); ?>
			</div>
			<!-- 이벤트 끝 -->	
		</div>
		<div class="col-sm-4">
			<!-- 알림 시작 -->
			<div class="div-title-underbar">
				<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=basic">
					<span class="pull-right lightgray <?php echo $font;?>">+</span>
					<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
						<b>Notice</b>
					</span>
				</a>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('basic-post-list', $wid.'-wp1', 'icon={아이콘:bell} rows=6 date=1 strong=1,2'); ?>
			</div>
			<!-- 알림 끝 -->
		</div>
	</div>

	<!-- 히트 & 베스트 시작 -->
	<h2 class="div-title-underbar">
		<a href="<?php echo $at_href['itype'];?>?type=1">
			<span class="pull-right lightgray">+</span>
			<span class="div-title-underbar-bold border-<?php echo $line;?>">
				Hit & Best
			</span>
		</a>
	</h2>
	<div class="widget-box">
		<?php echo apms_widget('basic-shop-item-slider', $wid.'-wm1', 'type1=1 type4=1 auto=0 nav=1 item=5 lg=4', 'auto=0'); ?>
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
		<?php echo apms_widget('basic-shop-item-slider', $wid.'-wm2', 'type2=1 type3=1 auto=0 nav=1 item=5 lg=4', 'auto=0'); ?>
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
		<?php echo apms_widget('basic-shop-item-slider', $wid.'-wm3', 'type5=1 auto=0 nav=1 item=5 lg=4', 'auto=0'); ?>
	</div>
	<!-- 할인 끝 -->

	<?php echo apms_line('fa', 'fa-cube'); // 라인 ?>

	<!-- 상품목록 시작 -->	
	<div class="widget-box">
		<?php echo apms_widget('basic-shop-item-gallery', $wid.'-wm6', 'rows=10 item=5 lg=4'); ?>
	</div>
	<!-- 상품목록 끝 -->	

	<!-- 이미지 배너 시작 -->	
	<div class="widget-box widget-img">
		<a href="#배너이동주소">
			<img src="<?php echo THEMA_URL;?>/assets/img/banner.jpg">
		</a>
	</div>
	<!-- 이미지 배너 끝 -->	

	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-sm-6">

					<!-- 후기 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo $at_href['iuse'];?>">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
								<b>Review</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-shop-post', $wid.'-wm9', 'mode=use icon={아이콘:star} star=red rows=4 new=blue strong=1,2'); ?>
					</div>
					<!-- 후기 끝 -->

				</div>
				<div class="col-sm-6">

					<!-- 문의 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo $at_href['iqa'];?>">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
								<b>Q & A</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-shop-post', $wid.'-wm10', 'mode=qa icon={아이콘:user} rows=4 new=green strong=1,2'); ?>
					</div>
					<!-- 문의 끝 -->

				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-sm-6">

					<!-- 댓글 시작 -->
					<div class="div-title-underbar">
						<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
							<b>Comment</b>
						</span>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-shop-post', $wid.'-wm11', 'mode=comment icon={아이콘:comment} rows=4 strong=1'); ?>
					</div>
					<!-- 댓글 끝 -->

				</div>
				<div class="col-sm-6">

					<!-- 아이콘 시작 -->
					<div class="div-title-underbar">
						<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
							<b>Service</b>
						</span>
					</div>

					<div class="widget-box">
						<?php echo apms_widget('basic-shop-icon'); ?>
					</div>
					<!-- 아이콘 끝 -->

				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">

			<!-- 배너 시작 -->
			<div class="div-title-underbar">
				<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
					<b>Banner</b>
				</span>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('basic-shop-banner-slider', $wid.'-wm12', 'nav=1 item=3 lg=2 md=3 sm=2 xs=2', 'auto=0'); ?>
			</div>
			<!-- 배너 끝 -->

		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-sm-6">

					<!-- 정보 시작 -->
					<div class="div-title-underbar">
						<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
							<b>Bank Info</b>
						</span>
					</div>
					<div class="widget-box">

						<div class="help-block">
							국민은행 000000-00-000000
							<br>
							기업은행 000-000000-00-000
						</div>

						예금주 홍길동
						
					</div>
					<!-- 정보 끝 -->

				</div>
				<div class="col-sm-6">

					<!-- 고객센터 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo $at_href['secret'];?>">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
								<b>CS Center</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<div class="en red font-24">
							<i class="fa fa-phone"></i> <b>000.0000.0000</b>
						</div>

						<div class="h10"></div>

						<div class="help-block">
							월-금 : 9:30 ~ 17:30, 토/일/공휴일 휴무
							<br>
							런치타임 : 12:30 ~ 13:30
						</div>

					</div>
					<!-- 고객센터 끝 -->


				</div>
			</div>
		</div>
	</div>

</div>
