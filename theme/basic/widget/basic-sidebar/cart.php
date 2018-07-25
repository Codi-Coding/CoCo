<?php
include_once('./_common.php');

thema_member('cart');

if(isset($del) && $del) {
	$tv_idx = (int)get_session("ss_tv_idx");
	for ($k=1;$k<=$tv_idx;$k++) {
		$sid = "ss_tv[".$k."]";
		unset($_SESSION[$sid]);
	}
	unset($_SESSION['ss_tv_idx']);
	$member['today'] = 0;
}

?>

<div class="div-title-underline-thin en">
	<b>CART</b>
	<?php if($member['cart']) { ?>
		<span class="count orangered">+<?php echo number_format($member['cart']);?></span>
	<?php } ?>
</div>

<?php if($member['cart']) {
	$list = apms_cart_rows();
	$list_cnt = count($list);
	for($i=0; $i < $list_cnt; $i++) {
?>
		<div class="sidebar-media media">
			<div class="media-photo pull-left">
				<?php echo ($list[$i]['img']) ? '<img src="'.$list[$i]['img'].'" alt="">' : '<i class="fa fa-cube"></i>'; ?>
			</div>
			<div class="media-body">
				<a href="<?php echo $list[$i]['href'];?>">
					<div class="ellipsis">
						<?php echo $list[$i]['it_name'];?>
					</div>
					<div class="media-info">
						<?php echo number_format($list[$i]['ct_price']);?>원
					</div>
				</a>
			</div>
		</div>
	<?php }	?>
	<p>
		<a href="<?php echo $at_href['cart'];?>">
			<span class="gray"><i class="fa fa-shopping-basket"></i> 장바구니 열기</span>
		</a>
	</p>
<?php } else { ?>
	<p class="text-muted">
		장바구니가 비어 있습니다.
	</p>
<?php } ?>

<div class="h20"></div>

<div class="div-title-underline-thin en">
	<b>TODAY VIEW</b>
	<?php if($member['today']) { ?>
		<span class="count orangered">+<?php echo number_format($member['today']);?></span>
	<?php } ?>
</div>

<?php if($member['today']) {
	unset($list);
	$list = apms_today_rows();
	$list_cnt = count($list);
	for($i=0; $i < $list_cnt; $i++) {
?>
		<div class="sidebar-media media">
			<div class="media-photo pull-left">
				<?php echo ($list[$i]['img']) ? '<img src="'.$list[$i]['img'].'" alt="">' : '<i class="fa fa-cube"></i>'; ?>
			</div>
			<div class="media-body">
				<a href="<?php echo $list[$i]['href'];?>">
					<div class="ellipsis">
						<?php echo $list[$i]['it_name'];?>
					</div>
					<div class="media-info">
						<?php echo number_format($list[$i]['it_price']);?>원
					</div>
				</a>
			</div>
		</div>
	<?php } ?>
	<p>
		<a class="cursor" onclick="sidebar_empty('sidebar-cart');">
			<span class="gray"><i class="fa fa-trash"></i> 오늘 본 아이템 비우기</span>
		</a>
	</p>
<?php } else { ?>
	<p class="text-muted">
		오늘 본 아이템이 없습니다.
	</p>
<?php } ?>
