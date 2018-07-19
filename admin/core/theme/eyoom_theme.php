<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

/**
 * 테마 매니저의 폼 action 
 */
$theme_action_url = EYOOM_ADMIN_URL . "/?dir=theme&amp;pid=theme_manager_update&amp;smode=1";

/**
 * 테마관리 메뉴 depth
 */
$sub_key = substr($sub_menu,3,3);
if(!$sub_key) exit;

/**
 * 커뮤니티홈으로 설정된 테마
 */
$theme = $eyoom_basic['theme'];

/**
 * 쇼핑몰홈으로 설정된 테마
 */
$shop_theme = $eyoom_basic['shop_theme'];

/**
 * 현재 작업중인 테마
 */
$this_theme = $_GET['thema'];
if(!$this_theme) $this_theme = $theme;

/**
 * 작업중인 테마의 설정정보 가져오기
 */
$config_file = G5_DATA_PATH.'/eyoom.'.$this_theme.'.config.php';
if($this_theme && !$eb->check_free_theme($this_theme)) {
	if(!file_exists($config_file)) {
		$theme = $eyoom['theme'] = 'basic3';
		$qfile->save_file('eyoom', eyoom_config, $eyoom);
	}
} else if (!isset($this_theme)) {
	$config_file = G5_DATA_PATH.'/eyoom.config.php';
}
unset($eyoom);
@include($config_file);

/**
 * 기본설정 파일에서 누락된 추가 설정 정보 자동 적용하기
 */
foreach($eyoom_basic as $key => $val) {
	$_eyoom[$key] = !$eyoom[$key] && $eyoom[$key] != '0' ? $val : $eyoom[$key];
}
$_eyoom['theme'] = $eyoom['theme'];
$_eyoom['bootstrap'] = $eyoom['bootstrap'];
$_eyoom['is_shop_theme'] = isset($eyoom['is_shop_theme']) ? $eyoom['is_shop_theme']: 'n';
$_eyoom['work_url'] = isset($eyoom['work_url']) ? $eyoom['work_url']: '';
$_eyoom['real_url'] = isset($eyoom['real_url']) ? $eyoom['real_url']: '';
$_eyoom['use_eyoom_admin'] = isset($eyoom['use_eyoom_admin']) ? $eyoom['use_eyoom_admin']: 'y';
$_eyoom['use_social_login'] = isset($eyoom['use_social_login']) ? $eyoom['use_social_login']: 'n';
$_eyoom['use_search_image'] = isset($eyoom['use_search_image']) ? $eyoom['use_search_image']: 'n';
$_eyoom['search_image_width'] = isset($eyoom['search_image_width']) ? $eyoom['search_image_width']: '300';
$_eyoom['search_image_height'] = isset($eyoom['search_image_height']) ? $eyoom['search_image_height']: '0';
$_eyoom['group_latest_cnt'] = isset($eyoom['group_latest_cnt']) ? $eyoom['group_latest_cnt']: '7';
$_tpl_name = $eyoom['bootstrap'] ? 'bs':'pc';

/**
 * 쇼핑몰 테마인가?
 */
$shopping_theme = false;
if (preg_match('/^shop/i', $this_theme) || $_eyoom['is_shop_theme'] == 'y') {
	$shopping_theme = true;
	$_eyoom['is_shop_theme'] = 'y';
	
	$_eyoom['use_shop_index'] 		= isset($eyoom['use_shop_index']) ? $eyoom['use_shop_index']: 'n';
	$_eyoom['use_shop_itemtype'] 	= isset($eyoom['use_shop_itemtype']) ? $eyoom['use_shop_itemtype']: 'n';
	$_eyoom['use_layout_community'] = isset($eyoom['use_layout_community']) ? $eyoom['use_layout_community']: 'n';
}
unset($eyoom);

/**
 * 게시판 설정 가져오기
 */
if($bo_table) {
	$eyoom_board = $eb->eyoom_board_info($bo_table, $this_theme);
	if(!$eyoom_board) {
		$eyoom_board = $eb->eyoom_board_default($bo_table);
	}
}

/**
 * DB eyoom_theme 테이블에 등록된 테마정보
 */
$sql = "select * from {$g5['eyoom_theme']} where 1 ";
$res = sql_query($sql, false);
for ($i=0; $row=sql_fetch_array($res); $i++) {
	$tminfo[$row['tm_name']] = $row;
}

/**
 * 현재 테마 정보
 */
$this_tminfo = $tminfo[$this_theme];

/**
 * 이윰 테마 디렉토리에 등록된 테마 폴더명 = 테마명
 */
$arr = get_skin_dir ('theme', EYOOM_PATH);
for ($i=0; $i<count($arr); $i++) {
	if($arr[$i] == 'countdown') continue;
	$config_file = $arr[$i] == 'basic' ? eyoom_config:G5_DATA_PATH.'/eyoom.'.$arr[$i].'.config.php';
	if(file_exists($config_file)) {
		$tlist[$i]['is_setup'] = true;
		if ($this_theme != $arr[$i]) {
			$exist_theme[$i] = $arr[$i];
		}
		@include($config_file);
	} else {
		$tlist[$i]['is_setup'] = false;
	}
	
	if ($eyoom['is_shop_theme'] == 'y') {
		$tlist[$i]['shop_theme'] = true;
		
		if ($eyoom_basic['shop_theme'] == '' && $theme == $arr[$i]) {
			$tlist[$i]['is_shopping_theme'] = true;
		}
	} else {
		$tlist[$i]['shop_theme'] = false;
	}
	
	$tlist[$i]['theme_name'] 	= $arr[$i];
	$tlist[$i]['theme_alias'] 	= $tminfo[$arr[$i]]['tm_alias'];
	unset($eyoom);
}
unset($arr);

/**
 * 카운트다운 스킨
 */
$countdown_skin = get_skin_dir('countdown', EYOOM_THEME_PATH);
$is_countdown = false;
if ($eyoom_basic['countdown'] == 'y' && $eyoom_basic['countdown_skin'] && strtotime($eyoom_basic['countdown_date']) > time()) {
	$is_countdown = true;
}

/**
 * 테마 매니저 템플릿 정의
 */
$atpl->define(array(
	'theme_manager' => 'skin_bs/theme/basic/theme_manager.skin.html',
));

$atpl->assign(array(
	'tlist' 			=> $tlist,
	'tminfo' 			=> $tminfo,
	'this_theme' 		=> $this_theme,
	'shop_theme' 		=> $shop_theme,
	'this_tminfo' 		=> $this_tminfo,
	'countdown_skin' 	=> $countdown_skin,
	'is_countdown' 		=> $is_countdown,
));