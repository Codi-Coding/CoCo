<?php
define('_EYOOM_MYPAGE_',true);

$g5['title'] = '맞팔친구';
$mpid = 'myfriends';

include_once('./_common.php');

if (!$member['mb_id']) alert('회원만 접근하실 수 있습니다.');

include_once('../_head.php');
include_once($mypage_skin_path.'/myfriends.php');
include_once('../_tail.php');