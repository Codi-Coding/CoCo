<?php
if (!defined('_GNUBOARD_')) exit;

$option = '';
$option_hidden = '';

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/qa/write.skin.php');

// Template define
$tpl->define_template('qa',$eyoom['qa_skin'],'write.skin.html');

$tpl->assign(array(
	'write' => $write,
));

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);