<?php
$sub_menu = "300100";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');

if (!$board) alert("잘못된 접근입니다.");

$action_url1 = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=board_extend_update&amp;smode=1';
$action_url2 = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=board_exlist_update&amp;smode=1';

// 게시판 확장필드 테이블 생성
$exboard_sql = "
	CREATE TABLE IF NOT EXISTS `" . $g5['eyoom_exboard'] . "` (
	  `ex_no` int(11) unsigned NOT NULL auto_increment,
	  `bo_table` varchar(20) NOT NULL,
	  `ex_fname` varchar(10) NOT NULL,
	  `ex_subject` varchar(50) NOT NULL,
	  `ex_use_search` enum('y','n') NOT NULL default 'n',
	  `ex_required` enum('y','n') NOT NULL default 'n',
	  `ex_form` varchar(20) NOT NULL default 'text',
	  `ex_type` varchar(20) NOT NULL,
	  `ex_length` mediumint(5) NOT NULL,
	  `ex_default` varchar(255) NOT NULL,
	  `ex_item_value` text NOT NULL,
	  PRIMARY KEY  (`ex_no`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
sql_query($exboard_sql, true);

/**
 * 버튼셋
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <a href="' . EYOOM_ADMIN_URL . '/?dir=board&amp;pid=board_list&amp;page='.$page.'" class="btn-e btn-e-lg btn-e-dark">게시판 목록</a> ';
$frm_submit .= ' <a href="'.G5_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'" class="btn-e btn-e-lg btn-e-dark" target="_blank">게시판 바로가기</a> ';
$frm_submit .= '</div>';

/**
 * 배너 테이블에서 작업테마의 배너/광고 레코드 정보 가져오기
 */
$sql_common = " from {$g5['eyoom_exboard']} ";

/**
 * 작업테마 조건문
 */
$sql_search = " where bo_table='{$board['bo_table']}' ";

/**
 * 출력순서
 */
$sql_order = " order by ex_no asc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 100;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows}";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	switch($row['ex_form']) {
		case 'text':
			$list[$i]['form'] = "&lt;input type='<strong class='color-red'>text</strong>' name='{$row['ex_fname']}'&gt;";
			break;
			
		case 'radio':
			$list[$i]['form'] = "&lt;input type='<strong class='color-red'>radio</strong>' name='{$row['ex_fname']}'&gt;";
			break;
			
		case 'checkbox':
			$list[$i]['form'] = "&lt;input type='<strong class='color-red'>checkbox</strong>' name='{$row['ex_fname']}'&gt;";
			break;
			
		case 'select':
			$list[$i]['form'] = "&lt;<strong class='color-red'>select</strong> name='{$row['ex_fname']}'&gt;";
			break;
			
		case 'textarea':
			$list[$i]['form'] = "&lt;<strong class='color-red'>textarea</strong> name='{$row['ex_fname']}'&gt;";
			break;
			
		case 'address':
			$list[$i]['form'] = "<strong class='color-red'>address</strong>";
			break;
	}
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=board&amp;pid=board_extend&amp;bo_table={$bo_table}&amp;{$qstr}&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'frm_submit' 	=> $frm_submit,
));