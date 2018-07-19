<?php
if (!defined('_GNUBOARD_')) exit;

$subject = get_text(cut_str($write['wr_subject'], 255));

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/scrap_popin.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'scrap_popin.skin.html');

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);