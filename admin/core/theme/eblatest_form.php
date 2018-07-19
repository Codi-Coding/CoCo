<?php
$sub_menu = "800620";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url1 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=eblatest_form_update&amp;smode=1';
$action_url2 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=eblatest_itemlist_update&amp;smode=1';

/**
 * EB Contents 이미지 아이템 테이블 생성
 */
$sql = "
	CREATE TABLE IF NOT EXISTS `" . $g5['eyoom_eblatest_item'] . "` (
	  `li_no` int(10) unsigned NOT NULL auto_increment,
	  `el_code` varchar(20) NOT NULL,
	  `li_theme` varchar(30) NOT NULL default '',
	  `li_state` char(1) NOT NULL default '2',
	  `li_sort` int(10) default '0',
	  `li_title` varchar(255) NOT NULL,
	  `li_bo_table` varchar(20) NOT NULL default '',
	  `li_gr_id` varchar(20) NOT NULL default '',
	  `li_exclude` varchar(255) NOT NULL default '',
	  `li_include` varchar(255) NOT NULL default '',
	  `li_tables` text NOT NULL,
	  `li_direct` char(1) NOT NULL default 'n',
	  `li_count` smallint(2) NOT NULL default '5',
	  `li_period` smallint(2) NOT NULL default '0',
	  `li_ca_view` char(1) NOT NULL default 'n',
	  `li_cut_subject` smallint(2) NOT NULL default '50',
	  `li_best` char(1) NOT NULL default 'n',
	  `li_random` char(1) NOT NULL default 'n',
	  `li_img_view` char(1) NOT NULL default 'n',
	  `li_img_width` smallint(3) NOT NULL default '300',
	  `li_img_height` smallint(3) NOT NULL default '300',
	  `li_content` char(1) NOT NULL default 'n',
	  `li_cut_content` smallint(3) NOT NULL default '100',
	  `li_bo_subject` char(1) NOT NULL default 'n',
	  `li_mbname_view` char(1) NOT NULL default 'y',
	  `li_photo` char(1) NOT NULL default 'n',
	  `li_use_date` char(1) NOT NULL default 'y',
	  `li_date_type` char(1) NOT NULL default '1',
	  `li_date_kind` varchar(20) NOT NULL,
	  `li_where` text NOT NULL,
	  `li_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
	  PRIMARY KEY  (`li_no`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
sql_query($sql, false);

/**
 * 스킨 디렉토리 읽어오기
 */
$skins['eblatest'] 	= $eb->get_skin_dir('eblatest', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);

/**
 * EB최신글 마스터 정보 가져오기
 */
if ($w == 'u') {
	$el = sql_fetch("select * from {$g5[eyoom_eblatest]} where el_code = '{$el_code}' and el_theme='{$this_theme}'");
	
	if (!$el) {
		alert('존재하지 않는 최신글입니다.', EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=eblatest_list&amp;page=1');
	}
}

/**
 * 버튼셋
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= ' <a href="' . EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=eblatest_list&amp;page='.$page.'&amp;thema='.$this_theme.'" class="btn-e btn-e-lg btn-e-dark">목록</a> ';
$frm_submit .= '</div>';

/**
 * 최신글 테이블에서 작업테마의 최신글 아이템 정보 가져오기
 */
$sql_common = " from {$g5['eyoom_eblatest_item']} ";

/**
 * 작업테마 조건문
 */
$sql_search = " where li_theme='{$this_theme}' and el_code = '{$el_code}' ";

$sql = " select * {$sql_common} {$sql_search} order by li_sort asc";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$li_list[$i] = $row;
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'list' 			=> $li_list,
	'el' 			=> $el,
	'skins' 		=> $skins,
	'frm_submit' 	=> $frm_submit,
));