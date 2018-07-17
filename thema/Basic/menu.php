<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<?php if($is_top_nav == "float"){ // 좌측형 ?>

	<div class="nav-visible">
		<div class="at-container">
			<div class="nav-top nav-float nav-slide">
				<ul class="menu-ul">
				<li class="menu-li nav-home <?php echo ($is_index) ? 'on' : 'off';?>">
					<a class="menu-a nav-height" href="<?php echo $at_href['main'];?>">
						<i class="fa fa-home"></i>
					</a>
				</li>
				<?php 
					for ($i=1; $i < $menu_cnt; $i++) {

						if(!$menu[$i]['gr_id']) continue;

				?>
					<li class="menu-li <?php echo $menu[$i]['on'];?>">
						<a class="menu-a nav-height" href="<?php echo $menu[$i]['href'];?>"<?php echo $menu[$i]['target'];?>>
							<?php echo $menu[$i]['name'];?>
							<?php if($menu[$i]['new'] == "new") { ?>
								<i class="fa fa-bolt new"></i>
							<?php } ?>
						</a>
						<?php if($menu[$i]['is_sub']) { //Is Sub Menu ?>
							<div class="sub-slide sub-1div">
								<ul class="sub-1dul subm-w pull-left">
								<?php 
									$smw1 = 1; //나눔 체크
									for($j=0; $j < count($menu[$i]['sub']); $j++) { 
								?>
									<?php if($menu[$i]['sub'][$j]['sp']) { //나눔 ?>
										</ul>
										<ul class="sub-1dul subm-w pull-left">
									<?php $smw1++; } // 나눔 카운트 ?>

									<?php if($menu[$i]['sub'][$j]['line']) { //구분라인 ?>
										<li class="sub-1line"><a><?php echo $menu[$i]['sub'][$j]['line'];?></a></li>
									<?php } ?>

									<li class="sub-1dli <?php echo $menu[$i]['sub'][$j]['on'];?>">
										<a href="<?php echo $menu[$i]['sub'][$j]['href'];?>" class="sub-1da<?php echo ($menu[$i]['sub'][$j]['is_sub']) ? ' sub-icon' : '';?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
											<?php echo $menu[$i]['sub'][$j]['name'];?>
											<?php if($menu[$i]['sub'][$j]['new'] == "new") { ?>
												<i class="fa fa-bolt sub-1new"></i>
											<?php } ?>
										</a>
										<?php if($menu[$i]['sub'][$j]['is_sub']) { // Is Sub Menu ?>
											<div class="sub-slide sub-2div">
												<ul class="sub-2dul subm-w pull-left">					
												<?php 
													$smw2 = 1; //나눔 체크
													for($k=0; $k < count($menu[$i]['sub'][$j]['sub']); $k++) { 
												?>
													<?php if($menu[$i]['sub'][$j]['sub'][$k]['sp']) { //나눔 ?>
														</ul>
														<ul class="sub-2dul subm-w pull-left">
													<?php $smw2++; } // 나눔 카운트 ?>

													<?php if($menu[$i]['sub'][$j]['sub'][$k]['line']) { //구분라인 ?>
														<li class="sub-2line"><a><?php echo $menu[$i]['sub'][$j]['sub'][$k]['line'];?></a></li>
													<?php } ?>

													<li class="sub-2dli <?php echo $menu[$i]['sub'][$j]['sub'][$k]['on'];?>">
														<a href="<?php echo $menu[$i]['sub'][$j]['sub'][$k]['href'];?>" class="sub-2da"<?php echo $menu[$i]['sub'][$j]['sub'][$k]['target'];?>>
															<?php echo $menu[$i]['sub'][$j]['sub'][$k]['name'];?>
															<?php if($menu[$i]['sub'][$j]['sub'][$k]['new'] == "new") { ?>
																<i class="fa fa-bolt sub-2new"></i>
															<?php } ?>
														</a>
													</li>
												<?php } ?>
												</ul>
												<?php $smw2 = ($smw2 > 1) ? $is_subw * $smw2 : 0; //서브메뉴 너비 ?>
												<div class="clearfix"<?php echo ($smw2) ? ' style="width:'.$smw2.'px;"' : '';?>></div>
											</div>
										<?php } ?>
									</li>
								<?php } //for ?>
								</ul>
								<?php $smw1 = ($smw1 > 1) ? $is_subw * $smw1 : 0; //서브메뉴 너비 ?>
								<div class="clearfix"<?php echo ($smw1) ? ' style="width:'.$smw1.'px;"' : '';?>></div>
							</div>
						<?php } ?>
					</li>
				<?php } //for ?>
				</ul>
			</div><!-- .nav-top -->
		</div>	<!-- .nav-container -->
	</div><!-- .nav-visible -->

<?php } else { // 배분형 ?>

	<div class="nav-visible">
		<div class="at-container">
			<div class="nav-top nav-both nav-slide">
				<ul class="menu-ul">
				<li class="menu-li nav-home <?php echo ($is_index) ? 'on' : 'off';?>">
					<a class="menu-a nav-height" href="<?php echo $at_href['main'];?>">
						<i class="fa fa-home"></i>
					</a>
				</li>
				<?php 
					for ($i=1; $i < $menu_cnt; $i++) {

						if(!$menu[$i]['gr_id']) continue;

				?>
					<li class="menu-li <?php echo $menu[$i]['on'];?>">
						<a class="menu-a nav-height" href="<?php echo $menu[$i]['href'];?>"<?php echo $menu[$i]['target'];?>>
							<?php echo $menu[$i]['name'];?>
							<?php if($menu[$i]['new'] == "new") { ?>
								<i class="fa fa-bolt new"></i>
							<?php } ?>
						</a>
						<?php if($menu[$i]['is_sub']) { //Is Sub Menu ?>
							<div class="sub-slide sub-1div">
								<ul class="sub-1dul">
								<?php for($j=0; $j < count($menu[$i]['sub']); $j++) { ?>

									<?php if($menu[$i]['sub'][$j]['line']) { //구분라인 ?>
										<li class="sub-1line"><a><?php echo $menu[$i]['sub'][$j]['line'];?></a></li>
									<?php } ?>

									<li class="sub-1dli <?php echo $menu[$i]['sub'][$j]['on'];?>">
										<a href="<?php echo $menu[$i]['sub'][$j]['href'];?>" class="sub-1da<?php echo ($menu[$i]['sub'][$j]['is_sub']) ? ' sub-icon' : '';?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
											<?php echo $menu[$i]['sub'][$j]['name'];?>
											<?php if($menu[$i]['sub'][$j]['new'] == "new") { ?>
												<i class="fa fa-bolt sub-1new"></i>
											<?php } ?>
										</a>
										<?php if($menu[$i]['sub'][$j]['is_sub']) { // Is Sub Menu ?>
											<div class="sub-slide sub-2div">
												<ul class="sub-2dul subm-w pull-left">					
												<?php 
													$smw2 = 1; //나눔 체크
													for($k=0; $k < count($menu[$i]['sub'][$j]['sub']); $k++) { 
												?>
													<?php if($menu[$i]['sub'][$j]['sub'][$k]['sp']) { //나눔 ?>
														</ul>
														<ul class="sub-2dul subm-w pull-left">
													<?php $smw2++; } // 나눔 카운트 ?>

													<?php if($menu[$i]['sub'][$j]['sub'][$k]['line']) { //구분라인 ?>
														<li class="sub-2line"><a><?php echo $menu[$i]['sub'][$j]['sub'][$k]['line'];?></a></li>
													<?php } ?>

													<li class="sub-2dli <?php echo $menu[$i]['sub'][$j]['sub'][$k]['on'];?>">
														<a href="<?php echo $menu[$i]['sub'][$j]['sub'][$k]['href'];?>" class="sub-2da"<?php echo $menu[$i]['sub'][$j]['sub'][$k]['target'];?>>
															<?php echo $menu[$i]['sub'][$j]['sub'][$k]['name'];?>
															<?php if($menu[$i]['sub'][$j]['sub'][$k]['new'] == "new") { ?>
																<i class="fa fa-bolt sub-2new"></i>
															<?php } ?>
														</a>
													</li>
												<?php } ?>
												</ul>
												<?php $smw2 = ($smw2 > 1) ? $is_subw * $smw2 : 0; //서브메뉴 너비 ?>
												<div class="clearfix"<?php echo ($smw2) ? ' style="width:'.$smw2.'px;"' : '';?>></div>
											</div>
										<?php } ?>
									</li>
								<?php } //for ?>
								</ul>
							</div>
						<?php } ?>
					</li>
				<?php } //for ?>
				<!-- 우측공간 확보용 -->
				<li class="menu-li nav-rw"><a>&nbsp;</a></li>
				</ul>
			</div><!-- .nav-top -->
		</div>	<!-- .nav-container -->
	</div><!-- .nav-visible -->

<?php } ?>
