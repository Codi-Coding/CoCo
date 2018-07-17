<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>
<div class="sidebar-login">
	<?php if($is_member) { //Login ?>
		<div class="profile">
			<a href="<?php echo $at_href['myphoto'];?>" target="_blank" class="win_memo" title="사진등록">
				<div class="photo pull-left">
					<?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="">' : '<i class="fa fa-user-plus"></i>'; //사진 ?>
				</div>
			</a>
			<h3><?php echo $member['mb_nick'];?></h3>
			<div class="font-12 text-muted" style="letter-spacing:-1px;">
				<?php echo $member['grade'];?>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="progress progress-striped sidebar-tip cursor" style="height:10px; margin:10px 0px 0px;" data-original-title="레벨업까지 <?php echo number_format($member['exp_up']);?>점 남았습니다." data-toggle="tooltip" data-html="true">
			<div class="progress-bar progress-bar-blue" style="width: <?php echo round($member['exp_per']);?>%;"></div>
		</div>

		<div class="font-12" style="padding:5px 0px 8px;">
			<span class="pull-right">
				Exp <?php echo number_format($member['exp']);?> (<?php echo $member['exp_per'];?>%)
			</span>
			레벨 <?php echo $member['level'];?> 
		</div>

		<div class="btn-group btn-group-justified" role="group">
			<?php if($member['admin']) { ?>
				<a href="<?php echo G5_ADMIN_URL;?>" class="btn btn-navy btn-sm">관리자</a>
			<?php } ?>
			<?php if($member['partner']) { ?>
				<a href="<?php echo $at_href['myshop'];?>" class="btn btn-navy btn-sm">마이샵</a>
			<?php } ?>
			<a href="<?php echo $at_href['logout'];?>" class="btn btn-navy btn-sm">나가기</a>
		</div>
		
		<div class="h15"></div>

		<!-- Service -->
		<div class="div-title-underline-thin en">
			<b>MY MENU</b>
		</div>

		<ul class="sidebar-list list-links">
			<li>
				<a href="<?php echo $at_href['point'];?>" target="_blank" class="win_point no-fa">
					<span class="pull-right"><?php echo number_format($member['mb_point']);?> 점</span>
					<?php echo AS_MP;?>
				</a>
			</li>
			<?php if($member['as_date']) { // 기간제 회원 ?>
				<li>
					<a class="no-fa">
						<span class="pull-right">
							<?php echo date("Y.m.d H:i", $member['as_date']);?>
							(<?php echo number_format(($member['as_date'] - G5_SERVER_TIME) / 86400);?>일)
						</span>
						프리미엄
					</a>		
				</li>
			<?php } ?>
			<li>
				<?php if ($member['response']) { ?>
					<a href="#" onclick="sidebar_open('sidebar-response'); return false;" class="no-fa">
						<span class="pull-right"><?php echo number_format($member['response']);?> 건</span>
				<?php } else { ?>
					<a href="<?php echo $at_href['response'];?>" target="_blank" class="win_memo">
				<?php } ?>
					내글반응
				</a>		
			</li>
			<li>
				<?php if ($member['memo']) { ?>
					<a href="#" onclick="sidebar_open('sidebar-response'); return false;" class="no-fa">
						<span class="pull-right"><?php echo number_format($member['memo']);?> 개</span>
				<?php } else { ?>
					<a href="<?php echo $at_href['memo'];?>" target="_blank" class="win_memo">
				<?php } ?>
					쪽지함
				</a>		
			</li>
			<li>
				<a href="<?php echo $at_href['follow'];?>" target="_blank" class="win_memo">
					팔로우
				</a>		
			</li>
			<li>
				<a href="<?php echo $at_href['scrap'];?>" target="_blank" class="win_scrap">
					스크랩
				</a>		
			</li>
			<?php if(IS_YC) { //영카트 ?>
				<li>
					<?php if ($member['as_coupon']) { ?>
						<a href="<?php echo $at_href['coupon']; ?>" target="_blank" class="win_point no-fa">
							<span class="pull-right"><?php echo number_format($member['as_coupon']);?> 장</span>
					<?php } else { ?>
						<a href="<?php echo $at_href['coupon']; ?>" target="_blank" class="win_point">
					<?php } ?>
						마이쿠폰
					</a>
				</li>
				<li>
					<a href="<?php echo $at_href['shopping']; ?>" target="_blank" class="win_memo">
						쇼핑리스트
					</a>
				</li>
				<li>
					<a href="<?php echo $at_href['wishlist']; ?>">
						위시리스트
					</a>
				</li>
			<?php } ?>
			<li>
				<a href="<?php echo $at_href['mypage']; ?>">
					마이페이지
				</a>
			</li>
			<li>
				<a href="<?php echo $at_href['mypost']; ?>" target="_blank" class="win_memo">
					내글관리
				</a>
			</li>
			<li>
				<a href="<?php echo $at_href['myphoto'];?>" target="_blank" class="win_memo">
					사진등록
				</a>
			</li>
			<li>
				<a href="<?php echo $at_href['edit'];?>">
					정보수정
				</a>
			</li>
			<li>
				<a href="<?php echo $at_href['leave'];?>" class="leave-me">
					탈퇴하기
				</a>
			</li>
		</ul>

	<?php } else { //Logout ?>

		<form id="sidebar_login_form" name="sidebar_login_form" method="post" action="<?php echo $at_href['login_check'];?>" autocomplete="off" role="form" class="form" onsubmit="return sidebar_login(this);">
		<input type="hidden" name="url" value="<?php echo $urlencode; ?>">
			<div class="form-group">	
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user gray"></i></span>
					<input type="text" name="mb_id" id="mb_id" class="form-control input-sm" placeholder="아이디" tabindex="91">
				</div>
			</div>
			<div class="form-group">	
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock gray"></i></span>
					<input type="password" name="mb_password" id="mb_password" class="form-control input-sm" placeholder="비밀번호" tabindex="92">
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-navy btn-block" tabindex="93">Login</button>    
			</div>	

			<label class="text-muted" style="letter-spacing:-1px;">
				<input type="checkbox" name="auto_login" value="1" id="remember_me" class="remember-me" tabindex="94">
				자동로그인 및 로그인 상태 유지
			</label>
		</form>

		<div class="h10"></div>

		<?php if($sns_login_icon) { // 소셜로그인 ?>
			<!-- SNS Login -->
			<div class="div-title-underline-thin en">
				<b>SNS LOGIN</b>
			</div>
			<div class="sidebar-sns-login">
				<?php echo $sns_login_icon; ?>
				<div class="clearfix"></div>
			</div>
			<div class="h20"></div>
		<?php } ?>

		<!-- Member -->
		<div class="div-title-underline-thin en">
			<b>MEMBER</b>
		</div>
		<ul class="sidebar-list list-links">
			<li><a href="<?php echo $at_href['reg'];?>">회원가입</a></li>
			<li><a href="<?php echo $at_href['lost'];?>" class="win_password_lost">아이디/비밀번호 찾기</a></li>
		</ul>
		
	<?php } //End ?>
</div>

<div class="h20"></div>

<!-- Service -->
<div class="div-title-underline-thin en">
	<b>SERVICE</b>
</div>

<ul class="sidebar-list list-links">
	<?php if (IS_YC) { //영카트 ?>
		<li><a href="<?php echo $at_href['cart']; ?>">장바구니</a></li>
		<li><a href="<?php echo $at_href['ppay']; ?>">개인결제</a></li>
		<li><a href="<?php echo $at_href['inquiry']; ?>">주문 및 배송조회</a></li>
	<?php } ?>
	<li><a href="<?php echo $at_href['faq'];?>">자주하시는 질문(FAQ)</a></li>
	<li><a href="<?php echo $at_href['secret'];?>">1:1 문의</a></li>
	<li><a href="<?php echo $at_href['new'];?>">새글모음</a></li>
	<li><a href="<?php echo $at_href['connect'];?>">현재접속자</a></li>
</ul>
