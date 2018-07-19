<?php
if (!defined('_GNUBOARD_')) exit;

$mb_photo = $eb->mb_photo($mb_id);

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/profile.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'profile.skin.html');

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);