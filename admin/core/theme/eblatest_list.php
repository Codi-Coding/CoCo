<?php
$sub_menu = "800620";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=eblatest_list_update&amp;smode=1';

/**
 * EB latest 테이블 생성
 */
$sql = "
	CREATE TABLE IF NOT EXISTS `" . $g5['eyoom_eblatest'] . "` (
	  `el_no` int(10) unsigned NOT NULL auto_increment,
	  `el_code` varchar(20) NOT NULL,
	  `el_subject` varchar(255) NOT NULL,
	  `el_theme` varchar(30) NOT NULL default 'basic3',
	  `el_skin` varchar(50) NOT NULL default 'basic',
	  `el_state` smallint(1) NOT NULL default '0',
	  `el_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
	  PRIMARY KEY  (`el_no`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
sql_query($sql, false);

/**
 * 배너 테이블에서 작업테마의 배너/광고 레코드 정보 가져오기
 */
$sql_common = " from {$g5['eyoom_eblatest']} ";

/**
 * 작업테마 조건문
 */
$sql_search = " where el_theme='{$this_theme}' ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} order by el_regdt desc ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} order by el_regdt desc limit {$from_record}, {$rows}";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$el_list[$i] = $row;
	$el_list[$i]['el_chg_code']	= "&lt;!--{=eb_latest('{$row['el_code']}')}--&gt;";
}

/**
 * Paging 
 */
$paging = $thema->pg_pages($tpl_name,"./?dir=theme&amp;pid=eblatest_list&amp;thema={$this_theme}&amp;{$qstr}&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'list' 	=> $el_list,
));