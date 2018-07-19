<?php
$sub_menu = "200300";
if (!defined('_EYOOM_IS_ADMIN_')) exit;
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

/**
 * 폼 action URL
 */
$action_url = EYOOM_ADMIN_URL . "/?dir=member&amp;pid=mail_update&amp;smode=1";

if ($w == 'u') {
    $html_title = '수정';
    $readonly = ' readonly';

    $sql = " select * from {$g5['mail_table']} where ma_id = '{$ma_id}' ";
    $ma = sql_fetch($sql);
    if (!$ma['ma_id'])
        alert('등록된 자료가 없습니다.');
} else {
    $html_title = '입력';
}

$editor_html = editor_html("ma_content", get_text($ma['ma_content'], 0));

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'ma' => $ma,
));