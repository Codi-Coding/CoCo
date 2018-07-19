<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더
$header_skin = (isset($wset['header_skin']) && $wset['header_skin']) ? $wset['header_skin'] : 'none';
if($header_skin != 'none') {
	$page_name = (isset($wset['title']) && $wset['title']) ? $wset['title'] : '쿠폰존';
	$header_color = (isset($wset['header_color']) && $wset['header_color']) ? $wset['header_color'] : 'navy';
	include_once('./header.php');
}

// 버튼컬러
$btn1 = (isset($wset['btn1']) && $wset['btn1']) ? $wset['btn1'] : 'deepblue';
$btn2 = (isset($wset['btn2']) && $wset['btn2']) ? $wset['btn2'] : 'green';

// 간격
$gap = (isset($wset['gap']) && ($wset['gap'] > 0 || $wset['gap'] == "0")) ? $wset['gap'] : 15;
$gapb = (isset($wset['gapb']) && ($wset['gapb'] > 0 || $wset['gapb'] == "0")) ? $wset['gapb'] : 15;

// 가로수
$item = (isset($wset['item']) && $wset['item'] > 0) ? $wset['item'] : 3;

$widget_id = "couponzone_wrap"; // Random ID

?>
<style>
	#<?php echo $widget_id;?> .item-wrap { margin-right:<?php echo $gap * (-1);?>px; margin-bottom:<?php echo $gapb * (-1);?>px; }
	#<?php echo $widget_id;?> .item-row { width:<?php echo apms_img_width($item);?>%; }
	#<?php echo $widget_id;?> .item-list { margin-right:<?php echo $gap;?>px; margin-bottom:<?php echo $gapb;?>px; }
	<?php if(_RESPONSIVE_) { // 반응형일 때만 작동
		$lg = (isset($wset['lg']) && $wset['lg'] > 0) ? $wset['lg'] : 3;
		$lgg = (isset($wset['lgg']) && ($wset['lgg'] > 0 || $wset['lgg'] == "0")) ? $wset['lgg'] : $gap;
		$lgb = (isset($wset['lgb']) && ($wset['lgb'] > 0 || $wset['lgb'] == "0")) ? $wset['lgb'] : $gapb;

		$md = (isset($wset['md']) && $wset['md'] > 0) ? $wset['md'] : 2;
		$mdg = (isset($wset['mdg']) && ($wset['mdg'] > 0 || $wset['mdg'] == "0")) ? $wset['mdg'] : $lgg;
		$mdb = (isset($wset['mdb']) && ($wset['mdb'] > 0 || $wset['mdb'] == "0")) ? $wset['mdb'] : $lgb;

		$sm = (isset($wset['sm']) && $wset['sm'] > 0) ? $wset['sm'] : 2;
		$smg = (isset($wset['smg']) && ($wset['smg'] > 0 || $wset['smg'] == "0")) ? $wset['smg'] : $mdg;
		$smb = (isset($wset['smb']) && ($wset['smb'] > 0 || $wset['smb'] == "0")) ? $wset['smb'] : $mdb;

		$xs = (isset($wset['xs']) && $wset['xs'] > 0) ? $wset['xs'] : 1;
		$xsg = (isset($wset['xsg']) && ($wset['xsg'] > 0 || $wset['xsg'] == "0")) ? $wset['xsg'] : $smg;
		$xsb = (isset($wset['xsb']) && ($wset['xsb'] > 0 || $wset['xsb'] == "0")) ? $wset['xsb'] : $smb;
	?>
	@media (max-width:1199px) { 
		.responsive #<?php echo $widget_id;?> .item-wrap { margin-right:<?php echo $lgg * (-1);?>px; margin-bottom:<?php echo $lgb * (-1);?>px; }
		.responsive #<?php echo $widget_id;?> .item-row { width:<?php echo apms_img_width($lg);?>%; } 
		.responsive #<?php echo $widget_id;?> .item-list { margin-right:<?php echo $lgg;?>px; margin-bottom:<?php echo $lgb;?>px; }
	}
	@media (max-width:991px) { 
		.responsive #<?php echo $widget_id;?> .item-wrap { margin-right:<?php echo $mdg * (-1);?>px; margin-bottom:<?php echo $mdb * (-1);?>px; }
		.responsive #<?php echo $widget_id;?> .item-row { width:<?php echo apms_img_width($md);?>%; } 
		.responsive #<?php echo $widget_id;?> .item-list { margin-right:<?php echo $mdg;?>px; margin-bottom:<?php echo $mdb;?>px; }
	}
	@media (max-width:767px) { 
		.responsive #<?php echo $widget_id;?> .item-wrap { margin-right:<?php echo $smg * (-1);?>px; margin-bottom:<?php echo $smb * (-1);?>px; }
		.responsive #<?php echo $widget_id;?> .item-row { width:<?php echo apms_img_width($sm);?>%; } 
		.responsive #<?php echo $widget_id;?> .item-list { margin-right:<?php echo $smg;?>px; margin-bottom:<?php echo $smb;?>px; }
	}
	@media (max-width:480px) { 
		.responsive #<?php echo $widget_id;?> .item-wrap { margin-right:<?php echo $xsg * (-1);?>px; margin-bottom:<?php echo $xsb * (-1);?>px; }
		.responsive #<?php echo $widget_id;?> .item-row { width:<?php echo apms_img_width($xs);?>%; } 
		.responsive #<?php echo $widget_id;?> .item-list { margin-right:<?php echo $xsg;?>px; margin-bottom:<?php echo $xsb;?>px; }
	}
	<?php } ?>
</style>
<div id="couponzone_wrap">
	<section class="item-wrap">
		<div class="item-head">
			<h2>다운로드 쿠폰</h2>
			<p><?php echo $default['de_admin_company_name']; ?> 회원이시라면 쿠폰 다운로드 후 바로 사용하실 수 있습니다.</p>
		</div>
		<?php
		for($i=0; $i < count($list); $i++) {
			// 이미지 없으면 통과
			if(!$list[$i]['cz_img'])
				continue;

			switch($list[$i]['cp_method']) {
				case '0':
					$cp_target = '<a href="'.G5_SHOP_URL.'/item.php?it_id='.$list[$i]['it_id'].'">'.$list[$i]['it_name'].'</a>';
					break;
				case '1':
					$cp_target = '<a href="'.G5_SHOP_URL.'/list.php?ca_id='.$list[$i]['ca_id'].'">'.$list[$i]['ca_name'].'</a>';
					break;
				case '2':
					$cp_target = '주문금액할인';
					break;
				case '3':
					$cp_target = '배송비할인';
					break;
			}
		?>
			<div class="item-row">
				<div class="item-list">
					<div class="item-img">
						<img src="<?php echo $list[$i]['cz_img'];?>" alt="">
					</div>
					<div class="item-content">
						<div class="ellipsis"><strong><?php echo $list[$i]['cz_subject'];?></strong></div>
						<div class="ellipsis">기한 : 다운로드 후 <?php echo number_format($list[$i]['cz_period']);?>일</div>
						<div class="ellipsis">적용 : <?php echo $cp_target;?></div>
					</div>
					<div class="item-btn">
						<button type="button" class="btn btn-<?php echo $btn1;?> btn-block coupon_download<?php echo $list[$i]['disabled'];?>"<?php echo $list[$i]['disabled'];?> data-cid="<?php echo $list[$i]['cz_id'];?>">
							쿠폰 다운로드
						</button>
					</div>
				</div>
			</div>
		<?php } ?>

		<div class="clearfix"></div>

		<?php if(!$i) { ?>
		   <p class="item-none">사용할 수 있는 쿠폰이 없습니다.</p>
		<?php } ?>
	</section>

	<div class="h20"></div>

	<?php echo apms_line('fa', 'fa-gift'); ?>

	<section class="item-wrap" id="point_coupon">
		<div class="item-head">
			<h2>포인트 쿠폰</h2>
			<p>보유하신 <?php echo $default['de_admin_company_name']; ?> 회원 포인트를 쿠폰으로 교환하실 수 있습니다.</p>
		</div>
		<?php
		for($i=0; $i < count($plist); $i++) {
			// 이미지 없으면 통과
			if(!$plist[$i]['cz_img'])
				continue;

			switch($plist[$i]['cp_method']) {
				case '0':
					$cp_target = '<a href="'.G5_SHOP_URL.'/item.php?it_id='.$plist[$i]['it_id'].'">'.$plist[$i]['it_name'].'</a>';
					break;
				case '1':
					$cp_target = '<a href="'.G5_SHOP_URL.'/list.php?ca_id='.$plist[$i]['ca_id'].'">'.$plist[$i]['ca_name'].'</a>';
					break;
				case '2':
					$cp_target = '주문금액할인';
					break;
				case '3':
					$cp_target = '배송비할인';
					break;
			}
		?>
			<div class="item-row">
				<div class="item-list">
					<div class="item-img">
						<img src="<?php echo $plist[$i]['cz_img'];?>" alt="">
					</div>
					<div class="item-content">
						<div class="ellipsis"><strong><?php echo $plist[$i]['cz_subject'];?></strong></div>
						<div class="ellipsis">기한 : 다운로드 후 <?php echo number_format($plist[$i]['cz_period']);?>일</div>
						<div class="ellipsis">적용 : <?php echo $cp_target;?></div>
						<div class="ellipsis">포인트 <?php echo number_format($plist[$i]['cz_point']);?>점 차감</div>
					</div>
					<div class="item-btn">
						<button type="button" class="btn btn-<?php echo $btn2;?> btn-block coupon_download<?php echo $plist[$i]['disabled'];?>"<?php echo $plist[$i]['disabled'];?> data-cid="<?php echo $plist[$i]['cz_id'];?>">
							쿠폰 다운로드
						</button>
					</div>
				</div>
			</div>
		<?php } ?>

		<div class="clearfix"></div>

		<?php if(!$i) { ?>
		   <p class="item-none">사용할 수 있는 쿠폰이 없습니다.</p>
		<?php } ?>
	</section>
</div>

<div class="h30"></div>

<?php if ($admin_href || $setup_href) { ?>
	<p class="print-hide text-center">
		<?php if ($admin_href) { ?>
			<a href="<?php echo $admin_href;?>" class="btn btn-black btn-sm">쿠폰존 관리</a>
		<?php } ?>
		<?php if($setup_href) { ?>
			<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
				<i class="fa fa-cogs"></i> 스킨설정
			</a>
		<?php } ?>
	</p>
<?php } ?>
