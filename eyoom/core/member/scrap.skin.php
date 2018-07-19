<?php
if (!defined('_GNUBOARD_')) exit;

// Paging 
$paging = $thema->pg_pages($tpl_name,"?$qstr&amp;page=");

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/scrap.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'scrap.skin.html');

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);