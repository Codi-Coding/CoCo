<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 값정리
$at['id'] = (isset($at['id'])) ? $at['id'] : '';
$at['gid'] = (isset($at['gid'])) ? $at['gid'] : '';
$at['title'] = (isset($at['title'])) ? $at['title'] : '';
$at['desc'] = (isset($at['desc'])) ? $at['desc'] : '';
$at['wide'] = (isset($at['wide'])) ? $at['wide'] : '';
$at['shop'] = (isset($at['shop'])) ? $at['shop'] : '';
$at['thema'] = (isset($at['thema'])) ? $at['thema'] : '';
$at['multi'] = (isset($at['multi'])) ? $at['multi'] : '';

// 헤더
$header_skin = (isset($at['header']) && $at['header']) ? $at['header'] : '';
$header_color = (isset($at['hcolor']) && $at['hcolor']) ? $at['hcolor'] : 'color';

// 아이디
$grid = ($at['gid']) ? $at['gid'] : $gr_id;
$bo_table = (isset($bo_table) && $bo_table) ? $bo_table : '';

// 인덱스는 무조건 와이드
$is_wide_layout = ($is_index) ? true : $at['wide'];

// 멀티사이트
$is_multi = ($at['multi']) ? true : false;

// 네비게이션
$page_title = $at['title'];
$page_desc = $at['desc'];
$page_name = $at['name'];
$page_nav1 = $at['nav1'];
$page_nav2 = $at['nav2'];
if(isset($at['nav3']) && $at['nav3']) {
	$page_nav3 = $at['nav3'];
} else if(isset($sca) && $sca) {
	$page_nav3 = $sca;
} else {
	$page_nav3 = '';
}

// Shop Check
if(IS_YC) {
	if(!defined('IS_SHOP')) {
		if($is_demo && $shop) {
			define('IS_SHOP', true);
		} else if($at['shop'] == "1") {
			define('IS_SHOP', true);
		} else if($at['shop'] == "2") {
			define('IS_SHOP', false);
		} else {
			if(isset($default['de_root_index_use']) && $default['de_root_index_use']) {
				define('IS_SHOP', true);
			} else {
				define('IS_SHOP', false);
			}
		}
	}
} else {
	define('IS_SHOP', false);
}

//G5 THEME
if(USE_G5_THEME && defined('G5_THEME_PATH')) {
	define('THEMA', $config['cf_theme']);
	define('THEMA_PATH', G5_THEME_PATH);
	define('THEMA_URL', G5_THEME_URL);
} else {
	//APMS THEMA
	$sw_code = '';
	$tmp_pv = '';

	$pv = (isset($pv)) ? $pv : '';
	$pvc = (isset($pvc)) ? $pvc : '';
	$it_id = (isset($it_id)) ? $it_id : '';

	if($is_demo || $is_admin) { //데모 또는 관리자에서 미리보기
		if($pv) set_session('thema', $pv);
		if($pvc) set_session('colorset', $pvc);

		$tmp_pv = get_session('thema');
		$tmp_pvc = get_session('colorset');

		if($tmp_pv == "1") { //초기화
			set_session('thema', '');
			set_session('thema_org', '');
			$tmp_pv = $pv = '';
		} else if($tmp_pv && !is_dir(G5_PATH.'/thema/'.$tmp_pv)) {
			set_session('thema', '');
			set_session('thema_org', '');
			alert('등록되지 않은 테마입니다.', G5_URL);
		}
		
		// 컬러셋 체크
		if($tmp_pvc && !is_dir(G5_PATH.'/thema/'.$tmp_pv.'/colorset/'.$tmp_pvc)) {
			set_session('colorset', '');
			$tmp_pvc = '';
		}
	}

	if($tmp_pv && $is_demo) {
		$thema = $tmp_pv;
		$colorset = $tmp_pvc;
		$sw_msg = '데모 미리보기(저장안됨)';
	} else {
		if(IS_YC && IS_SHOP && !$at['group']) {
			if($at['thema']) {
				$thema = $at['thema'];
				$colorset = $at['colorset'];
				$sw_code = $at['id'];
				if(G5_IS_MOBILE) {
					$sw_type = 18;
					$sw_msg = '쇼핑몰 '.$at['name'].'('.$at['id'].')분류의 모바일테마';
				} else {
					$sw_type = 16;
					$sw_msg = '쇼핑몰 '.$at['name'].'('.$at['id'].')분류의 PC테마';
				}
			} else {
				$thema = $default['as_'.MOBILE_.'thema'];
				$colorset = $default['as_'.MOBILE_.'color'];
				if(G5_IS_MOBILE) {
					$sw_type = 17;
					$sw_msg = '쇼핑몰 기본 모바일테마';
				} else {
					$sw_type = 15;
					$sw_msg = '쇼핑몰 기본 PC테마';
				}
			}
		} else {
			if($at['thema']) {
				$thema = $at['thema'];
				$colorset = $at['colorset'];
				$sw_code = $at['id'];
				if(G5_IS_MOBILE) {
					$sw_type = 14;
					$sw_msg = '커뮤니티 '.$at['name'].'('.$at['id'].')그룹의 모바일테마';
				} else {
					$sw_type = 12;
					$sw_msg = '커뮤니티 '.$at['name'].'('.$at['id'].')그룹의 PC테마';
				}
			} else {
				$thema = $config['as_'.MOBILE_.'thema'];
				$colorset = $config['as_'.MOBILE_.'color'];
				if(G5_IS_MOBILE) {
					$sw_type = 13;
					$sw_msg = '커뮤니티 기본 모바일테마';
				} else {
					$sw_type = 11;
					$sw_msg = '커뮤니티 기본 PC테마';
				}
			}
		}

		// 관리자 테마 미리보기...
		if($is_admin && $tmp_pv) {
			define('THEMA_PREVIEW', true);
			set_session('thema_org', $thema);
			$thema = $tmp_pv;
			$sw_msg = '미리보기에서 '.$sw_msg;
		}
	}

	// Thema Path & URL
	if(!$thema) {
		$thema = 'Basic';
		$sw_type = 11;
		$sw_msg = '커뮤니티 기본 PC테마';
	}

	define('THEMA', $thema);
	define('THEMA_PATH', G5_PATH.'/thema/'.$thema);
	define('THEMA_URL', G5_URL.'/thema/'.$thema);


	// Ex Href
	$at_href['switcher'] = G5_BBS_URL.'/switcher.php?pv='.THEMA;
	if(IS_YC) {
		if(isset($default['de_root_index_use']) && $default['de_root_index_use']) {
			if(IS_SHOP) {
				$at_href['home'] = G5_URL;
				$at_href['change'] = G5_URL.'/?ci=1';
				$at_href['rss'] = G5_URL.'/rss/';
			} else {
				$at_href['home'] = G5_URL.'/?ci=1';
				$at_href['change'] = G5_URL;
				$at_href['rss'] = G5_URL.'/rss/rss.php';
			}
		} else {
			if(IS_SHOP) {
				$at_href['home'] = G5_SHOP_URL;
				$at_href['change'] = G5_URL;
				$at_href['rss'] = G5_URL.'/rss/';
			} else {
				$at_href['home'] = G5_URL;
				$at_href['change'] = G5_SHOP_URL;
				$at_href['rss'] = G5_URL.'/rss/rss.php';
			}
		}
	} else {
		$at_href['home'] = G5_URL;
		$at_href['change'] = '';
		$at_href['rss'] = G5_URL.'/rss/rss.php';
	}

	if(isset($group['as_multi']) && $group['as_multi']) {
		$at_href['main'] = ($group['as_main']) ? G5_BBS_URL.'/main.php?gid='.$grid : $at_href['home'];
	} else {
		$at_href['main'] = $at_href['home'];
	}

	// Thema Setup
	$at_set = array();
	$at_set = thema_switcher_load($sw_type, $sw_code, $thema);

	// 컬러셋 지정
	if($at_set['colorset']) {
		$colorset = $at_set['colorset'];
	}

	// Demo Config
	if($is_demo) {
		@include_once(G5_LIB_PATH.'/apms.demo.lib.php');
	}

	// Responsive
	if(G5_IS_MOBILE || APMS_PRINT) {
		define('_RESPONSIVE_', true);
	} else {
		if(isset($at_set['pc']) && $at_set['pc']) {
			define('_RESPONSIVE_', false);
		} else {
			define('_RESPONSIVE_', true);
		}
	}
	
	// Colorset Path & URL
	if(!$colorset) {
		$colorset = (is_dir(THEMA_PATH.'/colorset/Basic')) ? 'Basic' : 'basic';
	}

	define('COLORSET', $colorset);
	define('COLORSET_PATH', THEMA_PATH.'/colorset/'.COLORSET);
	define('COLORSET_URL', THEMA_URL.'/colorset/'.COLORSET);
}

?>