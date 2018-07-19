<?php
if (!defined('_GNUBOARD_')) exit;

// 소셜로그인일 경우 리턴
if (preg_match("/oauth/i", $_SERVER['SCRIPT_NAME'])) {
	return;
}

// Eyoom Builder
define('_EYOOM_',true);

// Eyoom Builder 경로 정의
define('EYOOM_SITE','http://eyoom.net');
define('EYOOM_PATH', G5_PATH.'/eyoom');
define('EYOOM_URL', G5_URL.'/eyoom');
define('EYOOM_THEME_PATH', EYOOM_PATH.'/theme');
define('EYOOM_THEME_URL', EYOOM_URL.'/theme');

// Gnuboard Site URL
define('GNU_URL', 'http://sir.kr');

// Eyoom Core & Class 외 경로 정의
define('EYOOM_CORE_PATH', EYOOM_PATH.'/core');
define('EYOOM_CORE_URL', EYOOM_URL.'/core');
define('EYOOM_CLASS_PATH', EYOOM_PATH.'/classes');
define('EYOOM_CLASS_URL', EYOOM_URL.'/classes');
define('EYOOM_THEME_PATH', EYOOM_PATH.'/theme');
define('EYOOM_THEME_URL', EYOOM_URL.'/theme');
define('EYOOM_INC_PATH', EYOOM_PATH.'/inc');
define('EYOOM_INC_URL', EYOOM_URL.'/inc');
define('EYOOM_MISC_PATH', EYOOM_PATH.'/misc');
define('EYOOM_MISC_URL', EYOOM_URL.'/misc');
define('EYOOM_EXTEND_PATH', EYOOM_PATH.'/extend');
define('EYOOM_LANGUAGE_PATH', EYOOM_PATH.'/language');
define('EYOOM_LANGUAGE_URL', EYOOM_URL.'/language');
define('EYOOM_SHOP_PATH', EYOOM_CORE_PATH.'/shop');
define('EYOOM_SHOP_URL', EYOOM_CORE_URL.'/shop');
define('EYOOM_MSHOP_PATH', EYOOM_CORE_PATH.'/shop_mobile');
define('EYOOM_MSHOP_URL', EYOOM_CORE_URL.'/shop_mobile');

// User Program 경로 정의
define('EYOOM_USER_PATH', EYOOM_PATH.'/user_program');
define('EYOOM_USER_URL', EYOOM_URL.'/user_program');

// 게시판 이윰 확장필드 prefix
define('EYOOM_EXBOARD_PREFIX', 'ex_');

// Eyoom DB Table
$g5['eyoom_respond']		= G5_TABLE_PREFIX.'eyoom_respond';
$g5['eyoom_member']			= G5_TABLE_PREFIX.'eyoom_member';
$g5['eyoom_new']			= G5_TABLE_PREFIX.'eyoom_new';
$g5['eyoom_activity']		= G5_TABLE_PREFIX.'eyoom_activity';
$g5['eyoom_guest']			= G5_TABLE_PREFIX.'eyoom_guest';
$g5['eyoom_theme']			= G5_TABLE_PREFIX.'eyoom_theme';
$g5['eyoom_board']			= G5_TABLE_PREFIX.'eyoom_board';
$g5['eyoom_banner']			= G5_TABLE_PREFIX.'eyoom_banner';
$g5['eyoom_menu']			= G5_TABLE_PREFIX.'eyoom_menu';
$g5['eyoom_link']			= G5_TABLE_PREFIX.'eyoom_link';
$g5['eyoom_attendance'] 	= G5_TABLE_PREFIX.'eyoom_attendance';
$g5['eyoom_yellowcard']		= G5_TABLE_PREFIX.'eyoom_yellowcard';
$g5['eyoom_rating']			= G5_TABLE_PREFIX.'eyoom_rating';
$g5['eyoom_tag']			= G5_TABLE_PREFIX.'eyoom_tag';
$g5['eyoom_tag_write']		= G5_TABLE_PREFIX.'eyoom_tag_write';
$g5['eyoom_ebslider']		= G5_TABLE_PREFIX.'eyoom_ebslider';
$g5['eyoom_ebslider_item']	= G5_TABLE_PREFIX.'eyoom_ebslider_item';
$g5['eyoom_ebslider_ytitem']= G5_TABLE_PREFIX.'eyoom_ebslider_ytitem';
$g5['eyoom_ebcontents']		= G5_TABLE_PREFIX.'eyoom_ebcontents';
$g5['eyoom_ebcontents_item']= G5_TABLE_PREFIX.'eyoom_ebcontents_item';
$g5['eyoom_eblatest']		= G5_TABLE_PREFIX.'eyoom_eblatest';
$g5['eyoom_eblatest_item']	= G5_TABLE_PREFIX.'eyoom_eblatest_item';
$g5['eyoom_exboard']		= G5_TABLE_PREFIX.'eyoom_exboard';

// Eyoom 환경설정파일
$eyoom = array();
define('eyoom_config',G5_DATA_PATH."/eyoom.config.php");
if(@file_exists(eyoom_config)) {
	@include_once(eyoom_config);

	// 베이직테마 환경변수
	$eyoom_basic = $eyoom;

	// Eyoom Class Object Initialization
	include_once(EYOOM_CLASS_PATH.'/class.init.php');

	// 공사중 - 카운트다운
	if(!$is_admin && isset($eyoom['countdown']) && $eyoom['countdown'] == 'y') {
		$fname = $eb->get_filename_from_url($_SERVER['SCRIPT_NAME']);
		if($fname != 'login.php' && $fname != 'login_check.php') {
			$cd_date = $eb->mktime_countdown_date($eyoom['countdown_date']);
			if(isset($cd_date['mktime']) && $cd_date['mktime'] > time()) {
				$countdown = EYOOM_CORE_PATH.'/countdown/index.php';
				if(file_exists($countdown)) {
					include_once($countdown);
					return;
				}
			}
		}
	}

	// G5_ROOT 정의하기
	$g5_root = $eb->g5_root(dirname(__FILE__));
	define('G5_ROOT', $g5_root);

	// 테마 설정
	$_user			= array();
	$theme			= $eyoom['theme'];
	$shop_theme		= $eyoom['shop_theme'];

	// GET값으로 테마를 지정할 경우
	if(isset($_GET['theme']) || isset($_GET['shop_theme'])) {
		$_user['theme'] 	 = clean_xss_tags(trim($_GET['theme']));
		$_user['shop_theme'] = clean_xss_tags(trim($_GET['shop_theme']));
		$_config = $thema->set_user_theme($_user);
	} else {
		$_config = $thema->get_user_theme();
	}

	// 테마정보가 있다면 해당 테마로 강제 지정
	if(isset($_config['theme'])) {
		$theme 	 = $_config['theme'];
		$preview = true;
	}

	// 쇼핑몰 테마정보가 있다면 해당 테마로 강제 지정
	if(isset($_config['shop_theme'])) {
		$shop_theme = $_config['shop_theme'];
		$preview 	= true;
	}
	unset($_user, $_config);

	// 짧은주소 적용
	if(defined('_LINK_')) {
		$link = array();
		$link = $eb->short_url_data($t);
		$bo_table = $link['bo_table'];
		$write_table = $link['write_table'];
		$wr_id = $link['wr_id'];
		$board = $link['board'];
		$gr_id = $link['gr_id'];
		$group = $link['group'];
		$write = $link['write'];
		$theme = $link['theme'];
		unset($link);
	}

	// 테마 환경설정파일
	define('config_file',G5_DATA_PATH."/eyoom.".$theme.".config.php");
	if(@file_exists(config_file)) {
		@include_once(config_file);
	}

	// 반응형인지 체크
	$bs = $eyoom['bootstrap'];

	// 템플릿명 결정
	$tpl_name = G5_IS_MOBILE ? 'mo':'pc';
	if($eyoom['bootstrap'])  $tpl_name = 'bs';

	// 이윰레벨 설정파일
	$levelset_config_file = G5_DATA_PATH."/eyoom.levelset.php";
	if(@file_exists($levelset_config_file)) {
		@include_once($levelset_config_file);
	}

	// 이윰레벨 정보파일
	$levelinfo_config_file = G5_DATA_PATH."/eyoom.levelinfo.php";
	if(@file_exists($levelinfo_config_file)) {
		@include_once($levelinfo_config_file);
	}

	// 템플릿 클래스 오프젝트 생성
	include_once(EYOOM_CLASS_PATH.'/template.class.php');
	$tpl = new Template($theme);

	// 이윰 common 파일
	@include_once(EYOOM_PATH.'/common.php');

	// 스킨화작업이 어려운 파일은 File Hooking
	if($exchange_file = $tpl->exchange_file()) {
		@include_once(EYOOM_INC_PATH.'/hookedfile.header.php');
		@include_once($exchange_file);
		return;
	}

	// 쇼핑몰일 경우 Eyoom Core에서 파일 제어하기
	// Eyoom Core에 파일이 없을 경우에는 영카트 파일 실행
	$path = $tpl->get_filename_from_url();
	if(G5_USE_SHOP && $path['dirname'] == G5_SHOP_DIR) {
		if($eyoom_shop_core = $tpl->eyoom_control()) {

			define('_SHOP_',true);

			// 쇼핑몰 테마 설정정보 가져오기
			include(G5_DATA_PATH."/eyoom.".$shop_theme.".config.php");

			// 이윰테마에 샵스킨이 있는지 체크 후, 없다면 영카트5 기본 스킨을 뿌리도록 처리
			$shop_skin_for_theme = EYOOM_THEME_PATH . '/' . $shop_theme . '/skin_' . $tpl_name . '/shop/';
			if(!is_dir($shop_skin_for_theme)) return;
			else {
				// 그누보드5 테마 상수 및 레이아웃 변수 정의
				define('G5_THEME_PATH', EYOOM_PATH);
				$config['cf_include_head'] = 'eyoom/head.php';
				$config['cf_include_tail'] = 'eyoom/tail.php';
				$config['cf_include_index'] = 'eyoom/index.php';
			}

			if($eyoom['use_gnu_shop'] == 'n') {
				// 템플릿명 결정
				$tpl_name = G5_IS_MOBILE ? 'mo':'pc';
				if($eyoom['bootstrap'])  $tpl_name = 'bs';
				$tpl = new Template($shop_theme);

				@include_once(EYOOM_INC_PATH.'/hookedfile.header.php');
				include_once($eyoom_shop_core);
				exit;
			}
		}
	} else {
		// 그누보드5 테마 상수 및 레이아웃 변수 정의
		define('G5_THEME_PATH', EYOOM_PATH);
		$config['cf_include_head'] = 'eyoom/head.php';
		$config['cf_include_tail'] = 'eyoom/tail.php';
		$config['cf_include_index'] = 'eyoom/index.php';
	}

	// 쇼핑몰의 레이아웃을 커뮤니티에 적용하기
	if((isset($default['de_shop_layout_use']) && $default['de_shop_layout_use']) || $eyoom_board['use_shop_skin'] == 'y') {
		(int)$shop_layout_use = 1;
		if(!preg_match("/adm\//i",$_SERVER['SCRIPT_NAME'])) {
			unset($default['de_shop_layout_use']);
		}
	}
} else {
	$gmnow = gmdate('D, d M Y H:i:s').' GMT';
	header('Expires: 0'); // rfc2616 - Section 14.21
	header('Last-Modified: ' . $gmnow);
	header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
	header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
	header('Pragma: no-cache'); // HTTP/1.0

	// 이윰 설정파일이 없으면 설치하기
	header("location:".EYOOM_URL."/install/");
	exit;
}