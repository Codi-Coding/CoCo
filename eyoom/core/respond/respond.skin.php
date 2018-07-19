<?php
if (!defined('_GNUBOARD_')) exit;

// Paging
$paging = $thema->pg_pages($tpl_name,"respond.php?chk=$chk&amp;type=$type&amp;page=");

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/respond/respond.skin.php');

// Template define
$tpl->define_template('respond',$eyoom['respond_skin'],'respond.skin.html');

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);