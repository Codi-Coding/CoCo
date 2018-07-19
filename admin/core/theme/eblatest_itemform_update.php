<?php
$sub_menu = "800620";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$iw 			= clean_xss_tags(trim($_POST['iw']));
$li_no 			= clean_xss_tags(trim($_POST['li_no']));
$el_code 		= clean_xss_tags(trim($_POST['el_code']));
$li_state 		= clean_xss_tags(trim($_POST['li_state']));
$li_sort 		= clean_xss_tags(trim($_POST['li_sort']));
$li_title 		= clean_xss_tags(trim($_POST['li_title']));
$li_bo_table 	= clean_xss_tags(trim($_POST['li_bo_table']));
$li_gr_id 		= clean_xss_tags(trim($_POST['li_gr_id']));
$li_theme 		= clean_xss_tags(trim($_POST['theme']));
$li_include 	= clean_xss_tags(trim($_POST['li_include']));
$li_exclude 	= clean_xss_tags(trim($_POST['li_exclude']));
$li_count 		= clean_xss_tags(trim($_POST['li_count']));
$li_cut_subject = clean_xss_tags(trim($_POST['li_cut_subject']));
$li_period 		= clean_xss_tags(trim($_POST['li_period']));
$li_img_view 	= clean_xss_tags(trim($_POST['li_img_view']));
$li_img_width 	= clean_xss_tags(trim($_POST['li_img_width']));
$li_img_height 	= clean_xss_tags(trim($_POST['li_img_height']));
$li_content 	= clean_xss_tags(trim($_POST['li_content']));
$li_cut_content = clean_xss_tags(trim($_POST['li_cut_content']));
$li_bo_subject 	= clean_xss_tags(trim($_POST['li_bo_subject']));
$li_ca_view 	= clean_xss_tags(trim($_POST['li_ca_view']));
$li_best 		= clean_xss_tags(trim($_POST['li_best']));
$li_random 		= clean_xss_tags(trim($_POST['li_random']));
$li_mbname_view = clean_xss_tags(trim($_POST['li_mbname_view']));
$li_photo 		= clean_xss_tags(trim($_POST['li_photo']));
$li_use_date 	= clean_xss_tags(trim($_POST['li_use_date']));
$li_date_type 	= clean_xss_tags(trim($_POST['li_date_type']));
$li_date_kind 	= clean_xss_tags(trim($_POST['li_date_kind']));

$bo_tables = array();
// 지정한 bo_table
if ($li_bo_table) $bo_tables[] = $li_bo_table;

// 게시판 그룹에 속한 bo_table
if ($li_gr_id) {
	$sql = "select bo_table from {$g5['board_table']} where gr_id = '{$li_gr_id}' ";
	$res = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($res); $i++) {
		$bo_tables[] = $row['bo_table'];
	}
}

// include bo_table
if ($li_include) {
	$bo_include = explode(',', $li_include);
	foreach ($bo_include as $in_table) {
		$bo_tables[] = trim($in_table);
	}
}

// exclude bo_table
if ($li_exclude) {
	$bo_exclude = explode(',', $li_exclude);
	foreach ($bo_exclude as $ex_table) {
		$ex_tables[] = trim($ex_table);
	}
	$bo_tables = array_diff($bo_tables, $ex_tables);
}

// 중복 테이블을 유니크하게 처리
$bo_tables = array_unique($bo_tables);

// 최종 출력하게될 대상
$li_tables = implode(',', $bo_tables);

$sql_common = " 
	el_code = '{$el_code}',
	li_state = '{$li_state}',
	li_sort = '{$li_sort}',
	li_title = '{$li_title}',
	li_bo_table = '{$li_bo_table}',
	li_gr_id = '{$li_gr_id}',
	li_theme = '{$li_theme}',
	li_include = '{$li_include}',
	li_exclude = '{$li_exclude}',
	li_tables = '{$li_tables}',
	li_count = '{$li_count}',
	li_cut_subject = '{$li_cut_subject}',
	li_period = '{$li_period}',
	li_img_view = '{$li_img_view}',
	li_img_width = '{$li_img_width}',
	li_img_height = '{$li_img_height}',
	li_content = '{$li_content}',
	li_cut_content = '{$li_cut_content}',
	li_bo_subject = '{$li_bo_subject}',
	li_ca_view = '{$li_ca_view}',
	li_best = '{$li_best}',
	li_random = '{$li_random}',
	li_mbname_view = '{$li_mbname_view}',
	li_photo = '{$li_photo}',
	li_use_date = '{$li_use_date}',
	li_date_type = '{$li_date_type}',
	li_date_kind = '{$li_date_kind}',
";

if ($iw == '') {
	$sql = "insert into {$g5['eyoom_eblatest_item']} set {$sql_common} li_regdt = '".G5_TIME_YMDHIS."'";
    sql_query($sql);
	$li_no = sql_insert_id();
	
} else if ($iw == 'u') {
    $sql = " update {$g5['eyoom_eblatest_item']} set {$sql_common} li_regdt=li_regdt where li_no = '{$li_no}' ";
    sql_query($sql);
	$msg = "EB최신글 아이템을 정상적으로 수정하였습니다.";
	
	alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=eblatest_itemform&amp;li_code='.$li_code.'&amp;'.$qstr.'&amp;thema='.$li_theme.'&amp;w=u&amp;iw=u&amp;wmode=1&amp;li_no='.$li_no);
	
} else {
	alert('제대로 된 값이 넘어오지 않았습니다.');
}

if ($iw == '') {
	echo "
		<script>window.parent.closeModal();</script>
	";
}