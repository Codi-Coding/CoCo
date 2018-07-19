<?php
if (!defined('_GNUBOARD_')) exit;

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/memo_form.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'memo_form.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);