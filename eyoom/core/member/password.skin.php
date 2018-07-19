<?php
if (!defined('_GNUBOARD_')) exit;

$delete_str = "";
if ($w == 'x') $delete_str = "댓";
if ($w == 'u') $g5['title'] = $delete_str."글 수정";
else if ($w == 'd' || $w == 'x') $g5['title'] = $delete_str."글 삭제";
else $g5['title'] = $g5['title'];

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/password.skin.php');

// Template define
$tpl->define_template('member',$eyoom['member_skin'],'password.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);