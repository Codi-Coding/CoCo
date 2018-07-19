<?php
if (!defined('_GNUBOARD_')) exit;

// 레벨 진행바
$lvinfo = $eb->eyoom_level_info($member);

$lvset = $eyoomer['mb_level'] . '|' . $eyoomer['level'];
$lv = $eb->level_info($lvset);

// 읽지 않은 쪽지가 있다면
$memo_not_read = $eb->get_memo($member['mb_id']);

$tpl->define(array(
	'mybox_pc' => 'skin_pc/mypage/' . $eyoom['mypage_skin'] . '/mybox.skin.html',
	'mybox_mo' => 'skin_mo/mypage/' . $eyoom['mypage_skin'] . '/mybox.skin.html',
	'mybox_bs' => 'skin_bs/mypage/' . $eyoom['mypage_skin'] . '/mybox.skin.html',
));

$tpl->assign(array(
	'path' => $path['filename'],
	'memo_not_read' => $memo_not_read,
	't' => $_GET['t'],
	'lvinfo' => $lvinfo,
	'lv' => $lv,
	'levelset' => $levelset,
));