<?php
if (!defined('_GNUBOARD_')) exit;

// 페이징 
$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = 10;
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
$total_page = ceil(count($list)/$page_rows);

$list = array_slice($list,$from_record,$page_rows);
$paging = $thema->pg_pages($tpl_name,"./memo.php?kind=".$_GET['kind']);

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/memo.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'memo.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);