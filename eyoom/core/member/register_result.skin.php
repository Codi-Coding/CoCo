<?php
if (!defined('_GNUBOARD_')) exit;

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/register_result.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'register_result.skin.html');

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);