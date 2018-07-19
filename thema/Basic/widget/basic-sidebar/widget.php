<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 내글반응 및 쪽지 자동알림 시간설정(초) - 0 설정시 자동알림 작동하지 않음
$response_check_time = 30; 

// 소셜로그인 플러그인이 설치되어 있어야 작동 - http://amina.co.kr/bbs/board.php?bo_table=skin_amina&wr_id=150
// 소셜로그인 사용 - 0 : 사용안함, 1 : 사용
$use_sns_login = 1;

// 상단라인 컬러 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line_top = 'navy';

// 메뉴 새글 아이콘 및 컬러 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$menu_new = '<i class="fa fa-bolt crimson"></i>';

// 이벤트 보드아이디
$bo_event = 'event';

// 출석부 보드아이디
$bo_chulsuk = 'chulsuk';

//----------------------------------------------------------------------------

global $member, $is_guest, $is_member, $is_admin, $at_href, $at_set, $menu, $stats, $is_main, $gid, $stx, $urlencode;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

// 소셜로그인
$sns_login_icon = '';
if ($is_guest && $use_sns_login && function_exists('get_login_oauth')) {
	$sns_login_icon .= get_login_oauth('naver');
	$sns_login_icon .= get_login_oauth('facebook');
	$sns_login_icon .= get_login_oauth('twitter');
	$sns_login_icon .= get_login_oauth('google');
	$sns_login_icon .= get_login_oauth('kakao');
}

// 영카트
if (IS_YC && !isset($member['cart'])) {
	thema_member('cart');
}

// 카테고리
$menu_id = 'sidebar_menu';
$menu_cnt = count($menu);

?>
<script>
var sidebar_url = "<?php echo $widget_url;?>";
var sidebar_time = "<?php echo $response_check_time;?>";
</script>
<script src="<?php echo $widget_url; ?>/sidebar.js"></script>

<!-- sidebar Box -->
<aside id="sidebar-box" class="<?php echo (isset($at_set['font']) && $at_set['font']) ? $at_set['font'] : 'ko';?>">

	<!-- Head Line -->
	<div class="sidebar-head bg-<?php echo $line_top;?>"></div>

	<!-- sidebar Wing -->
	<div class="sidebar-wing">
		<!-- sidebar Wing Close -->
		<div class="sidebar-wing-close sidebar-close en" title="닫기">
			<i class="fa fa-times"></i>
		</div>
	</div>

	<!-- sidebar Content -->
	<div id="sidebar-content" class="sidebar-content">

		<div class="h30"></div>

		<!-- Common -->
		<div class="sidebar-common">

			<!-- Login -->
			<div class="btn-group btn-group-justified" role="group">
				<?php if($is_member) { ?>
					<a href="#" onclick="sidebar_open('sidebar-user'); return false;" class="btn btn-navy btn-sm">내정보</a>
					<?php if($member['admin']) { ?>
						<a href="<?php echo G5_ADMIN_URL;?>" class="btn btn-navy btn-sm">관리자</a>
					<?php } ?>
					<?php if($member['partner']) { ?>
						<a href="<?php echo $at_href['myshop'];?>" class="btn btn-navy btn-sm">마이샵</a>
					<?php } ?>
					<a href="<?php echo $at_href['logout'];?>" class="btn btn-navy btn-sm">나가기</a>
				<?php } else { ?>
					<a href="#" onclick="sidebar_open('sidebar-user'); return false;" class="btn btn-navy btn-sm">로그인</a>
					<a href="<?php echo $at_href['reg'];?>" class="btn btn-navy btn-sm">회원가입</a>
					<a href="<?php echo $at_href['lost'];?>" class="win_password_lost btn btn-navy btn-sm">정보찾기</a>
				<?php } ?>
			</div>

			<div class="h15"></div>

		</div>

		<!-- Menu -->
		<div id="sidebar-menu" class="sidebar-item">
			<?php @include_once($widget_path.'/menu.php'); ?>
		</div>

		<!-- Search -->
		<div id="sidebar-search" class="sidebar-item">
			<?php @include_once($widget_path.'/search.php'); ?>
		</div>

		<!-- User -->
		<div id="sidebar-user" class="sidebar-item">
			<?php @include_once($widget_path.'/user.php'); ?>
		</div>

		<!-- Response -->
		<div id="sidebar-response" class="sidebar-item">
			<div id="sidebar-response-list"></div>
		</div>

		<?php if(IS_YC) { //영카트 ?>
		<!-- Cart -->
		<div id="sidebar-cart" class="sidebar-item">
			<div id="sidebar-cart-list"></div>
		</div>
		<?php } ?>

		<div class="h30"></div>
	</div>

</aside>

<div id="sidebar-box-mask" class="sidebar-close"></div>
