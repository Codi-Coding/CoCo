<?php
$sub_menu = '500500';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "w");

$action_url = EYOOM_ADMIN_URL . '/?dir=shopetc&amp;pid=bannerformupdate&amp;smode=1';

if ($w=="u")
{
    $html_title .= ' 수정';
    $sql = " select * from {$g5['g5_shop_banner_table']} where bn_id = '$bn_id' ";
    $bn = sql_fetch($sql);
}
else
{
    $html_title .= ' 입력';
    $bn['bn_url']        = "http://";
    $bn['bn_begin_time'] = date("Y-m-d 00:00:00", time());
    $bn['bn_end_time']   = date("Y-m-d 00:00:00", time()+(60*60*24*31));
}

$bimg_url = "";
$bimg = G5_DATA_PATH."/banner/{$bn['bn_id']}";
if (file_exists($bimg) && !is_dir($bimg)) {
    $size = @getimagesize($bimg);
    if($size[0] && $size[0] > 750)
        $width = 750;
    else
        $width = $size[0];

    $bimg_url = G5_DATA_URL.'/banner/'.$bn['bn_id'];
    $bimg_width = $width;
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'bn' => $bn,
));