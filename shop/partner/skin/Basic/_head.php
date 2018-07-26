<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

add_stylesheet('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800" type="text/css">',0);
add_stylesheet('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:300,200,100" type="text/css">',0);
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/assets/css/bootstrap.min.css" type="text/css" media="screen">',0);
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" type="text/css" media="screen">',0);

?>

<div id="wrapper">
	<!-- Sidebar -->
	<nav class="navbar navbar-inverse navbar-fixed-top en" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="./">
				<span>
					<?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="" class="photo">' : '<i class="fa fa-cubes fa-lg"></i>'; //사진 ?>
					My Admin
				</span>
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav side-nav">
				<?php if(IS_SELLER) { ?>
					<li class="bg-blue">
						<a><span class="white"><i class="fa fa-shopping-cart fa-lg"></i> 판매자(셀러)</span></a>
					</li>
					<li<?php if(!$ap) echo ' class="active"';?>>
						<a href="./"><i class="fa fa-dashboard fa-lg"></i> 대시보드</a>
					</li>
					<li<?php if($ap == 'list' || $ap == 'item') echo ' class="active"';?>>
						<a href="./?ap=list"><i class="fa fa-cube fa-lg"></i> 자료관리</a>
					</li>
					<li<?php if($ap == 'comment') echo ' class="active"';?>>
						<a href="./?ap=comment"><i class="fa fa-comment fa-lg"></i> 댓글관리</a>
					</li>
					<li<?php if($ap == 'qalist') echo ' class="active"';?>>
						<a href="./?ap=qalist"><i class="fa fa-question-circle fa-lg"></i> 문의관리</a>
					</li>
					<li<?php if($ap == 'uselist') echo ' class="active"';?>>
						<a href="./?ap=uselist"><i class="fa fa-star fa-lg"></i> 후기관리</a>
					</li>
					<li<?php if($ap == 'salelist') echo ' class="active"';?>>
						<a href="./?ap=salelist"><i class="fa fa-line-chart fa-lg"></i> 판매현황</a>
					</li>
					<li<?php if($ap == 'saleitem') echo ' class="active"';?>>
						<a href="./?ap=saleitem"><i class="fa fa-shopping-cart fa-lg"></i> 판매자료</a>
					</li>
					<li<?php if($ap == 'delivery') echo ' class="active"';?>>
						<a href="./?ap=delivery"><i class="fa fa-truck fa-lg"></i> 배송관리</a>
					</li>
					<li<?php if($ap == 'sendcost') echo ' class="active"';?>>
						<a href="./?ap=sendcost"><i class="fa fa-tag fa-lg"></i> 배송비용</a>
					</li>
					<li<?php if($ap == 'cancelitem') echo ' class="active"';?>>
						<a href="./?ap=cancelitem"><i class="fa fa-cart-arrow-down fa-lg"></i> 취소내역</a>
					</li>
					<li<?php if($ap == 'paylist') echo ' class="active"';?>>
						<a href="./?ap=paylist"><i class="fa fa-calculator fa-lg"></i> 출금관리</a>
					</li>
				<?php } ?>
				<?php if(IS_MARKETER) { ?>
					<li class="bg-green">
						<a><span class="white"><i class="fa fa-database fa-lg"></i> 추천인(마케터)</span></a>
					</li>
					<li<?php if(!$ap) echo ' class="active"';?>>
						<a href="./"><i class="fa fa-dashboard fa-lg"></i> 대시보드</a>
					</li>
					<li<?php if($ap == 'mitem') echo ' class="active"';?>>
						<a href="./?ap=mitem"><i class="fa fa-cube fa-lg"></i> 수익자료</a>
					</li>
					<li<?php if($ap == 'mlist') echo ' class="active"';?>>
						<a href="./?ap=mlist"><i class="fa fa-line-chart fa-lg"></i> 수익현황</a>
					</li>
					<li<?php if($ap == 'mitemlist') echo ' class="active"';?>>
						<a href="./?ap=mitemlist"><i class="fa fa-database fa-lg"></i> 수익내역</a>
					</li>
					<li<?php if($ap == 'mcancelitem') echo ' class="active"';?>>
						<a href="./?ap=mcancelitem"><i class="fa fa-cart-arrow-down fa-lg"></i> 취소내역</a>
					</li>
					<li<?php if($ap == 'mpaylist') echo ' class="active"';?>>
						<a href="./?ap=mpaylist"><i class="fa fa-calculator fa-lg"></i> 출금관리</a>
					</li>
				<?php } ?>
			</ul>
			<ul class="nav navbar-nav navbar-left">
				<li class="hidden-xs">
					<a>
						<i class="fa fa-user fa-lg"></i>
						<?php echo xp_icon($member['mb_id'], $member['level']);?>
						<?php echo $member['mb_nick'];?>
					</a>
				</li>
				<?php if($member['admin']) { ?>
					<li><a href="<?php echo G5_ADMIN_URL;?>"><i class="fa fa-cog fa-lg"></i> 관리자</a></li>
				<?php } ?>
				<li>
					<a href="<?php echo $at_href['response'];?>" target="_blank" class="win_memo">
						<i class="fa fa-retweet fa-lg"></i> 내글반응
						<?php if ($member['response']) { ?>
							<span class="badge bg-blue"><?php echo number_format($member['response']);?></span>
						<?php } ?>
					</a>		
				</li>
				<li>
					<a href="<?php echo $at_href['memo'];?>" target="_blank" class="win_memo">
						<i class="fa fa-envelope-o fa-lg"></i> 쪽지함
						<?php if ($member['memo']) { ?>
							<span class="badge bg-green"><?php echo number_format($member['memo']);?></span>
						<?php } ?>
					</a>		
				</li>
				<li>
					<a href="<?php echo $at_href['secret'];?>"><i class="fa fa-user-secret fa-lg"></i> 1:1문의</a>
				</li>
				<?php if(IS_SELLER) { ?>
					<li>
						<a href="<?php echo G5_SHOP_URL;?>/myshop.php?id=<?php echo urlencode($member['mb_id']);?>"><i class="fa fa-home fa-lg"></i> 마이샵</a>
					</li>
				<?php } ?>
				<li>
					<a href="<?php echo G5_SHOP_URL;?>"><i class="fa fa-shopping-cart fa-lg"></i> 쇼핑몰</a>
				</li>
				<li>
					<a href="<?php echo G5_URL;?>"><i class="fa fa-users fa-lg"></i> 커뮤니티</a>
				</li>
				<li>
					<a href="<?php echo $at_href['logout'];?>">
						<i class="fa fa-sign-out fa-lg"></i> 로그아웃
					</a>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</nav>

	<div id="page-wrapper">
