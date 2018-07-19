<?php
if (!defined('_GNUBOARD_')) exit;

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/connect/current_connect.skin.php');

// Template define
$tpl->define_template('connect',$eyoom['connect_skin'],'current_connect.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);