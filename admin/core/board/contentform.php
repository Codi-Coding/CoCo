<?php
$sub_menu = '300600';
if (!defined('_EYOOM_IS_ADMIN_')) exit;
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$action_url = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=contentformupdate&amp;smode=1';

if ($w == "u")
{
    $html_title = " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['content_table']} where co_id = '$co_id' ";
    $co = sql_fetch($sql);
    if (!$co['co_id'])
        alert('등록된 자료가 없습니다.');
}
else
{
    $html_title = ' 입력';
    $co['co_html'] = 2;
    $co['co_skin'] = 'basic';
    $co['co_mobile_skin'] = 'basic';
}

$himg = G5_DATA_PATH.'/content/'.$co['co_id'].'_h';
if (file_exists($himg)) {
    $size = @getimagesize($himg);
    if($size[0] && $size[0] > 750)
        $co['himg_width'] = 750;
    else
        $co['himg_width'] = $size[0];
}

$timg = G5_DATA_PATH.'/content/'.$co['co_id'].'_t';
if (file_exists($timg)) {
    $size = @getimagesize($timg);
    if($size[0] && $size[0] > 750)
        $co['timg_width'] = 750;
    else
        $co['timg_width'] = $size[0];
}


include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'co' 		=> $co,
));