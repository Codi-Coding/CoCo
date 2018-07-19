<?php
$sub_menu = '100310';
if (!defined('_EYOOM_IS_ADMIN_')) exit;
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$nw_id = preg_replace('/[^0-9]/', '', $nw_id);

/**
 * 폼 action URL
 */
$action_url = EYOOM_ADMIN_URL . "/?dir=config&amp;pid=newwinform_update&amp;smode=1";

// 팝업레이어 테이블에 쇼핑몰, 커뮤니티 인지 구분하는 여부 필드 추가
$sql = " ALTER TABLE `{$g5['new_win_table']}` ADD `nw_division` VARCHAR(10) NOT NULL DEFAULT 'both' ";
sql_query($sql, false);

if ($w == "u") {
    $html_title = " 수정";
    $sql = " select * from {$g5['new_win_table']} where nw_id = '$nw_id' ";
    $nw = sql_fetch($sql);
    if (!$nw['nw_id']) alert("등록된 자료가 없습니다.");
} else {
    $html_title = " 입력";
    $nw['nw_device'] = 'both';
    $nw['nw_disable_hours'] = 24;
    $nw['nw_left']   = 10;
    $nw['nw_top']    = 10;
    $nw['nw_width']  = 450;
    $nw['nw_height'] = 500;
    $nw['nw_content_html'] = 2;
}

$editor_html = editor_html('nw_content', get_text($nw['nw_content'], 0));

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'nw' => $nw,
));