<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

$begin_time = get_microtime();

// 폼전송 모드일 때 헤더 출력 방지
if ($smode) return;

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 접속자 정보
$connect = $eb->get_connect();

// 최고관리자 정보
$adminfo = sql_fetch("select * from {$g5['member_table']} where mb_no = '1' limit 1");
if (!$adminfo) $adminfo = get_member($config['cf_admin']);

// 포토
$member['photo_url'] = mb_photo_url($member['mb_id']);

// 템플릿에 변수 할당
@include_once(EYOOM_ADMIN_INC_PATH.'/atpl.assign.php');

// 템플릿 출력
$atpl_head = 'head_' . $tpl_name;
$atpl->print_($atpl_head);
