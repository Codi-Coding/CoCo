<?php
if (!defined('_GNUBOARD_')) exit;
if (!defined('_TAG_')) exit;

/**
 * 이윰 헤더 디자인 출력
 */
@include_once(EYOOM_PATH.'/head.php');

// 기본쿼리
$sql_common = " from {$g5['eyoom_tag']} where (1) and tg_theme = '{$theme}' ";

$sql_order = " order by tg_word asc, tg_regdt desc ";

$sql = " select count(*) as cnt {$sql_common}";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = $config['cf_page_rows'] * 10;
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$sql = "select * {$sql_common} {$sql_order} limit {$from_record}, {$page_rows}";
$result = sql_query($sql);
for($i=0; $row=sql_fetch_array($result); $i++) {
	unset($heading);
	$list[$i] = $row;
	$list[$i]['href'] = G5_URL . '/tag/?tag=' . str_replace('&', '^', $row['tg_word']);
	$list[$i]['tag'] = $row['tg_word'];
	
	if($row['tg_recommdt'] != '0000-00-00 00:00:00') {
		$list[$i]['weight'] = '10';
	} else {
		$weight = ceil($row['tg_score']/10);
		if($weight > 10) $weight = 10;
		
		$list[$i]['weight'] = $weight;
	}
}

/**
 * 이윰 페이징
 */
$paging = $thema->pg_pages($tpl_name,"./list.php?&amp;page=");

/**
 * 사용자 프로그램
 */
@include_once(EYOOM_USER_PATH.'/tag/list.skin.php');

/**
 * Template define
 */
$tpl->define_template('tag',$eyoom['tag_skin'],'list.skin.html');

/**
 * Template assign
 */
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->assign('rel_tags', $rel_tags);

/**
 * 템플릿 디자인 출력
 */
$tpl->print_($tpl_name);

/**
 * 이윰 테일 디자인 출력
 */
@include_once(EYOOM_PATH.'/tail.php');