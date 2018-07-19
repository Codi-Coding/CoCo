<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

/**
 * 회원정보
 */
$meminfo = $mb ? $mb: get_member($mb_id);
$meminfo['mb_photo'] = $eb->mb_photo($mb_id);

/**
 * 해당 회원의 이윰회원 정보 가져오기
 */
$eyoomer = $eb->get_user_info($mb_id);
$lvinfo = $eb->eyoom_level_info($meminfo);

$atpl->define(array(
	'member_box' => 'skin_bs/member/basic/member_box.skin.html',
));

$atpl->assign(array(
	'meminfo' => $meminfo,
	'eyoomer' => $eyoomer,
	'lvinfo' => $lvinfo,
	'levelset' => $levelset,
));