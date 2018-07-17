<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 위젯 대표아이디 설정
$wid = 'CSB';

// 게시판 제목 폰트 설정
$font = 'font-16 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'navy';

?>
<style>
	.widget-side .div-title-underbar { margin-bottom:15px; }
	.widget-side .div-title-underbar span { padding-bottom:4px; }
	.widget-side .div-title-underbar span b { font-weight:500; }
	.widget-box { margin-bottom:25px; }
</style>

<div class="widget-side">

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

	<?php 
	// 카테고리 체크
	$side_category = apms_widget('basic-category');
	if($side_category) { 
	?>
		<div class="div-title-underbar">
			<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
				<b>Category</b>
			</span>
		</div>

		<div class="widget-box">
			<?php echo $side_category;?>
		</div>
	<?php } ?>

	<div class="row">
		<div class="col-md-12 col-sm-6">

			<!-- 새글 시작 -->
			<div class="div-title-underbar">
				<a href="<?php echo $at_href['new'];?>">
					<span class="pull-right lightgray <?php echo $font;?>">+</span>
					<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
						<b>Posts</b>
					</span>
				</a>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('basic-post-list', $wid.'-ws1', 'icon={아이콘:pencil} date=1 strong=1,2'); ?>
			</div>
			<!-- 새글 끝 -->

		</div>
		<div class="col-md-12 col-sm-6">

			<!-- 댓글 시작 -->
			<div class="div-title-underbar">
				<a href="<?php echo $at_href['new'];?>?view=c">
					<span class="pull-right lightgray <?php echo $font;?>">+</span>
					<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
						<b>Comments</b>
					</span>
				</a>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('basic-post-list', $wid.'-ws2', 'icon={아이콘:comment} comment=1 date=1 strong=1,2'); ?>
			</div>
			<!-- 댓글 끝 -->
		</div>
	</div>

	<!-- 광고 시작 -->
	<div class="widget-box">
		<div style="width:100%; min-height:280px; line-height:280px; text-align:center; background:#f5f5f5;">
			반응형 구글광고 등
		</div>
	</div>
	<!-- 광고 끝 -->

	<!-- 통계 시작 -->
	<div class="div-title-underbar">
		<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
			<b>State</b>
		</span>
	</div>
	<div class="widget-box">
		<ul style="padding:0; margin:0; list-style:none;">
			<li><i class="fa fa-bug red"></i>  <a href="<?php echo $at_href['connect'];?>">
				현재 접속자 <span class="pull-right"><?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb'] > 0) ? '(<b>'.number_format($stats['now_mb']).'</b>)' : ''; ?> 명</span></a>
			</li>
			<li><i class="fa fa-bug"></i> 오늘 방문자 <span class="pull-right"><?php echo number_format($stats['visit_today']); ?> 명</span></li>
			<li><i class="fa fa-bug"></i> 어제 방문자 <span class="pull-right"><?php echo number_format($stats['visit_yesterday']); ?> 명</span></li>
			<li><i class="fa fa-bug"></i> 최대 방문자 <span class="pull-right"><?php echo number_format($stats['visit_max']); ?> 명</span></li>
			<li><i class="fa fa-bug"></i> 전체 방문자 <span class="pull-right"><?php echo number_format($stats['visit_total']); ?> 명</span></li>
			<li><i class="fa fa-bug"></i> 전체 게시물	<span class="pull-right"><?php echo number_format($menu[0]['count_write']); ?> 개</span></li>
			<li><i class="fa fa-bug"></i> 전체 댓글수	<span class="pull-right"><?php echo number_format($menu[0]['count_comment']); ?> 개</span></li>
			<li><i class="fa fa-bug"></i> 전체 회원수	<span class="pull-right at-tip" data-original-title="<nobr>오늘 <?php echo $stats['join_today'];?> 명 / 어제 <?php echo $stats['join_yesterday'];?> 명</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><?php echo number_format($stats['join_total']); ?> 명</span>
			</li>
		</ul>
	</div>
	<!-- 통계 끝 -->

	<!-- SNS아이콘 시작 -->
	<div class="widget-box text-center">
		<?php echo $sns_share_icon; // SNS 공유아이콘 ?>
	</div>
	<!-- SNS아이콘 끝 -->

</div>