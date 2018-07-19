<?php
$sub_menu = '300700';
if (!defined('_EYOOM_IS_ADMIN_')) exit;
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$fm_id = preg_replace('/[^0-9]/', '', $fm_id);

$action_url = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=faqmasterformupdate&amp;smode=1';

if ($w == "u")
{
    $html_title = ' 수정';
    $readonly = ' readonly';

    $sql = " select * from {$g5['faq_master_table']} where fm_id = '$fm_id' ";
    $fm = sql_fetch($sql);
    if (!$fm['fm_id']) alert('등록된 자료가 없습니다.');
}
else
{
    $html_title = ' 입력';
}

// 모바일 상하단 내용 필드추가
if(!sql_query(" select fm_mobile_head_html from {$g5['faq_master_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['faq_master_table']}`
                    ADD `fm_mobile_head_html` text NOT NULL AFTER `fm_tail_html`,
                    ADD `fm_mobile_tail_html` text NOT NULL AFTER `fm_mobile_head_html` ", true);
}

$himg = G5_DATA_PATH.'/faq/'.$fm['fm_id'].'_h';
if (file_exists($himg)) {
    $size = @getimagesize($himg);
    if($size[0] && $size[0] > 750)
        $fm['himg_width'] = 750;
    else
        $fm['himg_width'] = $size[0];
}

$timg = G5_DATA_PATH.'/faq/'.$fm['fm_id'].'_t';
if (file_exists($timg)) {
    $size = @getimagesize($timg);
    if($size[0] && $size[0] > 750)
        $fm['timg_width'] = 750;
    else
        $fm['timg_width'] = $size[0];
}


include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'fm' => $fm,
));