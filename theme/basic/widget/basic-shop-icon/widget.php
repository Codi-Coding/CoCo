<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

global $at_href, $member;

if(!isset($member['cart'])) {
	thema_member('cart');
}

?>

<style>
	.basic-shop-icon { overflow:hidden; margin-bottom:-10px; text-align:center; }
	.basic-shop-icon .row { margin:0; padding:0; }
	.basic-shop-icon .row .col { margin:0; padding:0; }
	.basic-shop-icon .row i { margin-bottom:8px; }
	.basic-shop-icon .content-box { margin:0px 0px 10px; }
</style>

<div class="basic-shop-icon">
	<div class="row">
		<div class="col-xs-3 col">
			<div class="content-box text-center">
				<div class="heading">
					<a href="<?php echo $at_href['inquiry']; ?>">
						<i class="fa fa-truck circle light-circle normal"></i>
						<span class="ellipsis">주문/배송</span>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col">
			<div class="content-box text-center">
				<div class="heading">
					<a href="<?php echo $at_href['ppay']; ?>">
						<i class="fa fa-ticket circle light-circle normal"></i>
						<span class="ellipsis">개인결제</span>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col">
			<div class="content-box text-center">
				<div class="heading">
					<a href="<?php echo $at_href['faq']; ?>">
						<i class="fa fa-question circle light-circle normal"></i>
						<span class="ellipsis">FAQ</span>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col">
			<div class="content-box text-center">
				<div class="heading">
					<a href="<?php echo $at_href['secret'];?>">
						<i class="fa fa-user-secret circle light-circle normal"></i>
						<span class="ellipsis">1:1 문의</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-3 col">
			<div class="content-box text-center">
				<div class="heading">
					<a href="<?php echo $at_href['cart'];?>">
						<i class="fa fa-shopping-basket circle light-circle normal"></i>
						<span class="ellipsis">장바구니</span>
						<?php if($member['cart']) { ?>
							<span class="count orangered">+<?php echo $member['cart'];?></span>
						<?php } ?>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col">
			<div class="content-box text-center">
				<div class="heading">
					<a href="javascript:;" onclick="sidebar_open('sidebar-cart');">
						<i class="fa fa-eye circle light-circle normal"></i>
						<span class="ellipsis">투데이뷰</span>
						<?php if($member['today']) { ?>
							<span class="count orangered">+<?php echo $member['today'];?></span>
						<?php } ?>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col">
			<div class="content-box text-center">
				<div class="heading">
					<a href="<?php echo $at_href['isearch'];?>">
						<i class="fa fa-search circle light-circle normal"></i>
						<span class="ellipsis">상품찾기</span>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col">
			<div class="content-box text-center">
				<div class="heading">
					<a href="<?php echo $at_href['wishlist'];?>">
						<i class="fa fa-heart circle light-circle normal"></i>
						<span class="ellipsis">위시리스트</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
