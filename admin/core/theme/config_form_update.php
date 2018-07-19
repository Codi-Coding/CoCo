<?php
$sub_menu = '800100';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "w");

unset($theme);
$theme 		= clean_xss_tags(trim($_POST['theme']));
$tm_alias 	= clean_xss_tags(trim($_POST['tm_alias']));
$tm_key 	= clean_xss_tags(trim($_POST['tm_key']));
$cm_key 	= clean_xss_tags(trim($_POST['cm_key']));
$tm_alias 	= clean_xss_tags(trim($_POST['tm_alias']));
$cm_salt 	= clean_xss_tags(trim($_POST['cm_salt']));

// 테마 별칭 중복 체크
if ($tm_alias) {
	$sql = "select count(*) as cnt from {$g5['eyoom_theme']} where tm_name != '{$theme}' and tm_alias = '{$tm_alias}' ";
	$info = sql_fetch($sql);
	if ($info['cnt'] > 0) {
		alert('입력하신 별칭은 이미 사용하고 있습니다. 다른 별칭을 입력해 주세요.');
	}
}
$use_eyoom_admin = $eyoom['use_eyoom_admin'];

// $eyoom 변수파일 재정의
unset($eyoom);
$eyoom_config_file = !$_POST['theme'] ? G5_DATA_PATH . '/eyoom.config.php': G5_DATA_PATH . '/eyoom.'.$theme.'.config.php';
include($eyoom_config_file);

// 쇼핑몰 테마 체크
if ($_POST['is_shop_theme'] == 'y') {
	$shop_theme_file = EYOOM_THEME_PATH . '/' . $theme . '/skin_' . $tpl_name . '/shop/basic/index.skin.html';
	if (!file_exists($shop_theme_file)) {
		alert("현재 작업 테마는 쇼핑몰 테마가 아닙니다.");
	}
}

foreach($eyoom_basic as $key => $val) {
	if($key == 'bootstrap') {
		$val = !isset($_POST[$key]) ? '1':$_POST[$key];
	} else if($key == 'is_shop_theme') {
		$val = !$_POST[$key] ? '':$_POST[$key];
	} else if($key == 'is_community_theme') {
		$val = !$_POST[$key] ? '':$_POST[$key];
	} else if($key == 'work_url') {
		$val = !$_POST[$key] ? '':$_POST[$key];
	} else if($key == 'real_url') {
		$val = !$_POST[$key] ? '':$_POST[$key];
	} else if(preg_match('/_skin/i',$key) || $key == 'theme') {
		$val = !$_POST[$key] ? 'basic' : $_POST[$key];
	} else if(preg_match('/use_gnu_/i',$key)) {
		$val = !$_POST[$key] ? 'n' : $_POST[$key];
	} else if($key == 'level_icon_gnu') {
		$val = !$_POST[$key] ? '':$_POST[$key];
	} else if($key == 'use_level_icon_gnu') {
		$val = !$_POST[$key] ? 'n':$_POST[$key];
	} else if($key == 'level_icon_eyoom') {
		$val = !$_POST[$key] ? '':$_POST[$key];
	} else if($key == 'use_level_icon_eyoom') {
		$val = !$_POST[$key] ? 'n':$_POST[$key];
	} else if($key == 'use_eyoom_menu') {
		$val = !$_POST[$key] ? 'y':$_POST[$key];
	} else if($key == 'use_eyoom_shopmenu') {
		$val = !$_POST[$key] ? 'n':$_POST[$key];
	} else if($key == 'use_eyoom_admin') {
		$val = $use_eyoom_admin;
	} else if($key == 'use_sideview') {
		$val = !$_POST[$key] ? 'y':$_POST[$key];
	} else if($key == 'use_main_side_layout') {
		$val = !$_POST[$key] ? 'y':$_POST[$key];
	} else if($key == 'use_sub_side_layout') {
		$val = !$_POST[$key] ? 'y':$_POST[$key];
	} else if($key == 'use_shopmain_side_layout') {
		$val = !$_POST[$key] ? 'y':$_POST[$key];
	} else if($key == 'use_shopsub_side_layout') {
		$val = !$_POST[$key] ? 'y':$_POST[$key];
	} else if($key == 'use_shop_mobile') {
		$val = !$_POST[$key] ? 'n':$_POST[$key];
	} else if($key == 'use_tag') {
		$val = !$_POST[$key] ? 'n':$_POST[$key];
	} else if($key == 'use_board_control') {
		$val = !$_POST[$key] ? 'n':$_POST[$key];
	} else if($key == 'use_theme_info') {
		$val = !$_POST[$key] ? 'n':$_POST[$key];
	} else if($key == 'tag_dpmenu_count') {
		$val = !$_POST[$key] && $_POST[$key] != '0' ? '20':$_POST[$key];
	} else if($key == 'tag_dpmenu_sort') {
		$val = !$_POST[$key] ? 'regdt':$_POST[$key];
	} else if($key == 'tag_recommend_count') {
		$val = !$_POST[$key] && $_POST[$key] != '0' ? '5':$_POST[$key];
	} else if($key == 'pos_main_side_layout') {
		$val = !$_POST[$key] ? 'right':$_POST[$key];
	} else if($key == 'pos_sub_side_layout') {
		$val = !$_POST[$key] ? 'right':$_POST[$key];
	} else if($key == 'pos_shopmain_side_layout') {
		$val = !$_POST[$key] ? 'right':$_POST[$key];
	} else if($key == 'pos_shopsub_side_layout') {
		$val = !$_POST[$key] ? 'right':$_POST[$key];
	} else if($key == 'push_reaction') {
		$val = !$_POST[$key] ? 'y':$_POST[$key];
	} else if($key == 'push_time') {
		$val = !$_POST[$key] ? '1000':$_POST[$key];
	} else if($key == 'photo_width') {
		$val = !$_POST[$key] && $_POST[$key] != '0' ? '150':$_POST[$key];
	} else if($key == 'photo_height') {
		$val = !$_POST[$key] && $_POST[$key] != '0' ? '150':$_POST[$key];
	} else if($key == 'cover_width') {
		$val = !$_POST[$key] ? '845':$_POST[$key];
	} else if($key == 'theme') {
		$val = $eyoom[$key];
	}
	$eyoom_config[$key] = isset($val) && $val != '0' ? $val : $eyoom[$key];
}

// 추가설정 확장
{
	// 소셜로그인 사용여부
	$eyoom_config['use_social_login'] = $_POST['use_social_login'] ? $_POST['use_social_login']: 'n';
	
	// 전체검색 리스트에서 이미지 사용
	$eyoom_config['use_search_image'] = $_POST['use_search_image'] ? $_POST['use_search_image']: 'n';
	$eyoom_config['search_image_width'] = $_POST['search_image_width'] ? $_POST['search_image_width']: '300';
	$eyoom_config['search_image_height'] = $_POST['search_image_height'] ? $_POST['search_image_height']: '0';
	
	// 그룹게시판 최신글 추출 갯수
	$eyoom_config['group_latest_cnt'] = $_POST['group_latest_cnt'] ? $_POST['group_latest_cnt']: '7';
}

// 쇼핑몰 테마 체크 후, 설정변수 추가
if ($_POST['is_shop_theme'] == 'y') {
	$eyoom_config['use_shop_index'] 		= $_POST['use_shop_index'] ? $_POST['use_shop_index']: 'n';
	$eyoom_config['use_shop_itemtype'] 		= $_POST['use_shop_itemtype'] ? $_POST['use_shop_itemtype']: 'n';
	$eyoom_config['use_layout_community'] 	= $_POST['use_layout_community'] ? $_POST['use_layout_community']: 'n';
}

// 테마 정보 업데이트
$set = "
	tm_alias = '{$tm_alias}',
	tm_key = '{$tm_key}',
	cm_key = '{$cm_key}',
	cm_salt = '{$cm_salt}',
	tm_last = '".G5_TIME_YMDHIS."'
";
$sql = "update {$g5['eyoom_theme']} set {$set} where tm_name = '{$theme}'";
sql_query($sql);

// 설정정보 업데이트
$qfile->save_file('eyoom', $eyoom_config_file, $eyoom_config);
$msg = "설정을 사용테마에 적용하였습니다.";
alert($msg, EYOOM_ADMIN_URL.'/?dir=theme&amp;pid=config_form&amp;thema='.$theme);
