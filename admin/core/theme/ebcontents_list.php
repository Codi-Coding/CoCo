<?php
$sub_menu = "800610";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebcontents_list_update&amp;smode=1';

/**
 * EB Contents 테이블 생성
 */
$sql = "
	CREATE TABLE IF NOT EXISTS `" . $g5['eyoom_ebcontents'] . "` (
	  `ec_no` int(10) unsigned NOT NULL auto_increment,
	  `ec_code` text NOT NULL,
	  `ec_subject` varchar(255) NOT NULL,
	  `ec_theme` varchar(30) NOT NULL default 'basic3',
	  `ec_skin` varchar(50) NOT NULL default 'basic',
	  `ec_state` smallint(1) NOT NULL default '0',
	  `ec_text` text NOT NULL,
	  `ec_link_cnt` smallint(2) NOT NULL default '2',
	  `ec_image_cnt` smallint(2) NOT NULL default '5',
	  `ec_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
	  PRIMARY KEY  (`ec_no`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
sql_query($sql, false);

/**
 * EB 컨텐츠 아이템 파일 저장 경로
 */
$ebcontents_folder = G5_DATA_PATH.'/ebcontents/';
if(!@is_dir($ebcontents_folder) ) {
	@mkdir($ebcontents_folder, G5_DIR_PERMISSION);
	@chmod($ebcontents_folder, G5_DIR_PERMISSION);
}

/**
 * 배너 테이블에서 작업테마의 배너/광고 레코드 정보 가져오기
 */
$sql_common = " from {$g5['eyoom_ebcontents']} ";

/**
 * 작업테마 조건문
 */
$sql_search = " where ec_theme='{$this_theme}' ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} order by ec_regdt desc ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} order by ec_regdt desc limit {$from_record}, {$rows}";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$ec_list[$i] = $row;
	$ec_list[$i]['ec_chg_code']	= "&lt;!--{=eb_contents('{$row['ec_code']}')}--&gt;";
}

/**
 * Paging 
 */
$paging = $thema->pg_pages($tpl_name,"./?dir=theme&amp;pid=ebcontents_list&amp;thema={$this_theme}&amp;{$qstr}&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'list' 	=> $ec_list,
));