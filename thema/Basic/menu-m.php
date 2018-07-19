<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>
<div class="m-wrap">
	<div class="at-container">
		<div class="m-table en">
			<div class="m-icon">
				<a href="javascript:;" onclick="sidebar_open('sidebar-menu');"><i class="fa fa-bars"></i></a>
			</div>
			<?php if(IS_YC) { // 영카트 이용시 ?>
				<div class="m-icon">
					<a href="<?php echo $at_href['change'];?>">
						<?php if(IS_SHOP) { // 쇼핑몰일 때 ?>
							<i class="fa fa-commenting"></i>
							<span class="label bg-blue">BBS</span>
						<?php } else { ?>
							<i class="fa fa-shopping-cart"></i>
							<span class="label bg-blue">SHOP</span>
						<?php } ?>
					</a>
				</div>
			<?php } ?>
			<div class="m-list">
				<div class="m-nav" id="mobile_nav">
					<ul class="clearfix">
					<li>
						<a href="<?php echo $at_href['main'];?>">메인</a>
					</li>
					<?php 
						$j = 1; //현재위치 표시
						for ($i=1; $i < $menu_cnt; $i++) {

							if(!$menu[$i]['gr_id']) continue;

							if($menu[$i]['on'] == 'on') {
								$m_sat = $j;

								//서브메뉴
								if($menu[$i]['is_sub']) {
									$m_sub = $i;
								}
							}
					?>
						<li>
							<a href="<?php echo $menu[$i]['href'];?>"<?php echo $menu[$i]['target'];?>>
								<?php echo $menu[$i]['menu'];?>
								<?php if($menu[$i]['new'] == "new") { ?>
									<i class="fa fa-bolt new"></i>
								<?php } ?>
							</a>
						</li>
					<?php $j++; } //for ?>
					</ul>
				</div>
			</div>
			<?php if(IS_YC) { // 영카트 이용시 ?>
				<div class="m-icon">
					<a href="<?php echo $at_href['cart'];?>" onclick="sidebar_open('sidebar-cart'); return false;"> 
						<i class="fa fa-shopping-bag"></i>
						<?php if($member['cart'] || $member['today']) { ?>
							<span class="label bg-green en">
								<?php echo number_format($member['cart'] + $member['today']);?>
							</span>
						<?php } ?>
					</a>
				</div>
			<?php } ?>
			<div class="m-icon">
				<a href="javascript:;" onclick="sidebar_open('sidebar-response');">
					<i class="fa fa-bell"></i>
					<span class="label bg-orangered en"<?php echo ($member['response'] || $member['memo']) ? '' : ' style="display:none;"';?>>
						<span class="msgCount"><?php echo number_format($member['response'] + $member['memo']);?></span>
					</span>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>

<?php if($m_sub) { //서브메뉴가 있으면 ?>
	<div class="m-sub">
		<div class="at-container">
			<div class="m-nav-sub en" id="mobile_nav_sub">
				<ul class="clearfix">
				<?php 
					$m_subchk = false;
					for ($i=1; $i < $menu_cnt; $i++) {
						if($i == $m_sub) {
							for($j=0; $j < count($menu[$i]['sub']); $j++) { 
								if($menu[$i]['sub'][$j]['on'] == 'on') { 
									$m_subsat = $j;
									$m_subchk = true;
								}
				?>
						<li>
							<a href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
								<?php echo $menu[$i]['sub'][$j]['menu'];?>
								<?php if($menu[$i]['sub'][$j]['new'] == "new") { ?>
									<i class="fa fa-bolt sub-new"></i>
								<?php } ?>
							</a>
						</li>
				<?php	
							}
						}
					}

					if(!$m_subchk) $m_subsat = '-1';
				?>
				</ul>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
<?php } ?>