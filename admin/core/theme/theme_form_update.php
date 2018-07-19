<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

if($is_admin != 'super') alert('최고관리자만 설정을 변경할 수 있습니다.');

$tm_key				= clean_xss_tags(get_text(trim($_POST['tm_key'])));
$cm_key				= clean_xss_tags(get_text(trim($_POST['cm_key'])));
$cm_salt			= clean_xss_tags(get_text(trim($_POST['cm_salt'])));
$tm_name			= clean_xss_tags(get_text(trim($_POST['tm_name'])));
$tm_shop			= clean_xss_tags(get_text(trim($_POST['tm_shop'])));
$tm_community		= clean_xss_tags(get_text(trim($_POST['tm_community'])));
$tm_mainside		= clean_xss_tags(get_text(trim($_POST['tm_mainside'])));
$tm_subside			= clean_xss_tags(get_text(trim($_POST['tm_subside'])));
$tm_mainpos			= clean_xss_tags(get_text(trim($_POST['tm_mainpos'])));
$tm_subpos			= clean_xss_tags(get_text(trim($_POST['tm_subpos'])));
$tm_shopmainside	= clean_xss_tags(get_text(trim($_POST['tm_shopmainside'])));
$tm_shopsubside		= clean_xss_tags(get_text(trim($_POST['tm_shopsubside'])));
$tm_shopmainpos		= clean_xss_tags(get_text(trim($_POST['tm_shopmainpos'])));
$tm_shopsubpos		= clean_xss_tags(get_text(trim($_POST['tm_shopsubpos'])));

if (!$tm_name) alert('잘못된 접근입니다.');
if (!$tm_key || strlen($tm_key) != 50) alert('잘못된 접근입니다.');
if (!$cm_key) alert('잘못된 접근입니다.');
if (!$cm_salt) alert('잘못된 접근입니다.');

$tm_path = EYOOM_THEME_PATH . '/' . $tm_name;
if (!is_dir($tm_path)) {
    alert("입력하신 테마 라이선스키와 설치하고자 하는 테마가 서로 일치하지 않습니다.");
}

// 테마정보 업데이트
$where = " tm_name='{$tm_name}' ";
$info = sql_fetch("select count(*) as cnt from {$g5['eyoom_theme']} where {$where}");

$set = "
	tm_name = '{$tm_name}',
	tm_key = '{$tm_key}',
	cm_key = '{$cm_key}',
	cm_salt = '{$cm_salt}',
	tm_time = '".G5_TIME_YMDHIS."'
";

if($info['cnt']>0) {
	sql_query("update {$g5['eyoom_theme']} set $set where $where");
} else {
	sql_query("insert into {$g5['eyoom_theme']} set $set");
}

// 이윰메뉴 생성
$g5_root = $eb->g5_root(str_replace("{$admin_dirname}/index.php",'',$_SERVER['SCRIPT_NAME']));
$eyoom_menu_sql_file = EYOOM_PATH.'/install/eyoom.menu.'.$tm_name.'.sql';
if (file_exists($eyoom_menu_sql_file)) {
	// 해당 테마의 메뉴를 삭제
	sql_query("delete from {$g5['eyoom_menu']} where me_theme = '{$tm_name}' ");
	$file = implode('', file($eyoom_menu_sql_file));
	eval("\$file = \"$file\";");
	
	$file = preg_replace('/`g5_([^`]+`)/', '`'.G5_TABLE_PREFIX.'$1', $file);
	if ($g5_root != '' && $g5_root != '/') {
	    $file = str_replace("`me_link` = '", "`me_link` = '{$g5_root}", $file);
	}
	$q = explode(';', $file);
	
	for ($i=0; $i<count($q); $i++) {
	    if (trim($q[$i]) == '') continue;
	    sql_query($q[$i]);
	}
}

// 사이드영역 출력여부 및 위치
$tm_mainside = ($tm_mainside == '' || $tm_mainside == 'n') ? 'n': 'y';
$tm_subside = ($tm_subside == '' || $tm_subside == 'n') ? 'n': 'y';
$tm_mainpos = ($tm_mainpos == '' || $tm_mainpos == 'n') ? 'right': 'left';
$tm_subpos = ($tm_subpos == '' || $tm_subpos == 'n') ? 'right': 'left';
$tm_shopmainside = ($tm_shopmainside == '' || $tm_shopmainside == 'n') ? 'n': 'y';
$tm_shopsubside = ($tm_shopsubside == '' || $tm_shopsubside == 'n') ? 'n': 'y';
$tm_shopmainpos = ($tm_shopmainpos == '' || $tm_shopmainpos == 'n') ? 'right': 'left';
$tm_shopsubpos = ($tm_shopsubpos == '' || $tm_shopsubpos == 'n') ? 'right': 'left';

if ($tm_shop == 'y') {
	$g5_install = 0;
	if (isset($_POST['g5_install']))
	    $g5_install  = $_POST['g5_install'];
	$g5_shop_prefix = $_POST['g5_shop_prefix'];
	$g5_shop_install= $_POST['g5_shop_install'];
} else {
	$g5_shop_install = false;
}

// 설정파일 정의 
foreach($eyoom_basic as $key => $val) {
	if ($key == 'theme') {
		$_eyoom[$key] = $tm_name;
	} else if ( $key == 'is_shop_theme' ) {
		$_eyoom[$key] = $tm_shop == 'y' ? 'y': 'n';
	} else if ( $key == 'is_community_theme' ) {
		$_eyoom[$key] = $tm_community == 'y' ? 'y': 'n';
	} else if ( $key == 'work_url' ) {
		$_eyoom[$key] = $_SERVER['HTTP_HOST'];
	} else if ( $key == 'use_main_side_layout' ) {
		$_eyoom[$key] = $tm_mainside;
	} else if ( $key == 'use_sub_side_layout' ) {
		$_eyoom[$key] = $tm_subside;
	} else if ( $key == 'use_shopmain_side_layout' ) {
		$_eyoom[$key] = $tm_shopmainside;
	} else if ( $key == 'use_shopsub_side_layout' ) {
		$_eyoom[$key] = $tm_shopsubside;
	} else if ( $key == 'pos_main_side_layout' ) {
		$_eyoom[$key] = $tm_mainpos;
	} else if ( $key == 'pos_sub_side_layout' ) {
		$_eyoom[$key] = $tm_mainpos;
	} else if ( $key == 'pos_shopmain_side_layout' ) {
		$_eyoom[$key] = $tm_shopmainpos;
	} else if ( $key == 'pos_shopsub_side_layout' ) {
		$_eyoom[$key] = $tm_shopmainpos;
	} else {
		$_eyoom[$key] = $val;
	}
}

$theme_config = G5_DATA_PATH . '/eyoom.'.$tm_name.'.config.php';
$qfile->save_file('eyoom', $theme_config, $_eyoom, false);
?>
<script>
alert("테마설치를 완료하였습니다.");
parent.location.reload();
</script>