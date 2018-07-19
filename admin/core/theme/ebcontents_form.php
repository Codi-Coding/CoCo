<?php
$sub_menu = "800610";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url1 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebcontents_form_update&amp;smode=1';
$action_url2 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebcontents_itemlist_update&amp;smode=1';

/**
 * EB Contents 이미지 아이템 테이블 생성
 */
$sql = "
	CREATE TABLE IF NOT EXISTS `" . $g5['eyoom_ebcontents_item'] . "` (
	  `ci_no` int(10) unsigned NOT NULL auto_increment,
	  `ec_code` text NOT NULL,
	  `ci_theme` varchar(30) NOT NULL default '',
	  `ci_state` char(1) NOT NULL default '2',
	  `ci_sort` int(10) default '0',
	  `ci_title` varchar(255) NOT NULL,
	  `ci_subtitle` varchar(255) NOT NULL,
	  `ci_text` text NOT NULL,
	  `ci_content` text NOT NULL,
	  `ci_link` text NOT NULL,
	  `ci_target` text NOT NULL,
	  `ci_img` text NOT NULL,
	  `ci_period` char(1) NOT NULL default '1',
	  `ci_start` varchar(10) NOT NULL,
	  `ci_end` varchar(10) NOT NULL,
	  `ci_view_level` tinyint(4) NOT NULL default '1',
	  `ci_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
	  PRIMARY KEY  (`ci_no`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
sql_query($sql, false);

/**
 * 스킨 디렉토리 읽어오기
 */
$skins['ebcontents'] 	= $eb->get_skin_dir('ebcontents', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);

/**
 * EB컨텐츠 마스터 정보 가져오기
 */
if ($w == 'u') {
	$ec = sql_fetch("select * from {$g5[eyoom_ebcontents]} where ec_code = '{$ec_code}' and ec_theme='{$this_theme}'");
	
	if (!$ec) {
		alert('존재하지 않는 컨텐츠입니다.', EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebcontents_list&amp;page=1');
	}
}

/**
 * 버튼셋
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= ' <a href="' . EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebcontents_list&amp;page='.$page.'&amp;thema='.$this_theme.'" class="btn-e btn-e-lg btn-e-dark">목록</a> ';
$frm_submit .= '</div>';

/**
 * 컨텐츠 테이블에서 작업테마의 컨텐츠 레코드 정보 가져오기
 */
$sql_common = " from {$g5['eyoom_ebcontents_item']} ";

/**
 * 작업테마 조건문
 */
$sql_search = " where ci_theme='{$this_theme}' and ec_code = '{$ec_code}' ";

$sql = " select * {$sql_common} {$sql_search} order by ci_sort asc";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$ci_list[$i] = $row;
	
	$ci_link = unserialize($row['ci_link']);
	$ci_target = unserialize($row['ci_target']);
	$ci_img = unserialize($row['ci_img']);
	
	$ci_file = G5_DATA_PATH.'/ebcontents/'.$row['ci_theme'].'/'.$ci_img[0];
	if (file_exists($ci_file) && $ci_img[0]) {
		$ci_url 	= G5_DATA_URL.'/ebcontents/'.$row['ci_theme'].'/'.$ci_img[0];
		$ci_list[$i]['ci_image'] = "<img src='".$ci_url."' class='img-responsive'> ";
	}
	
	$view_level = get_member_level_select("ci_view_level[$i]", 1, $member['mb_level'], $row['ci_view_level']);
	$ci_list[$i]['view_level'] = preg_replace("/(\\n|\\r)/","",str_replace('"', "'", $view_level));
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'list' 			=> $ci_list,
	'ec' 			=> $ec,
	'skins' 		=> $skins,
	'frm_submit' 	=> $frm_submit,
));