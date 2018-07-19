<?php
$sub_menu = '400810';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "w");

/**
 * 폼 action URL
 */
$action_url = EYOOM_ADMIN_URL . "/?dir=shop&amp;pid=couponzoneformupdate&amp;smode=1";

if ($w == 'u') {
    $html_title = '쿠폰 수정';

    $sql = " select * from {$g5['g5_shop_coupon_zone_table']} where cz_id = '$cz_id' ";
    $cp = sql_fetch($sql);
    if (!$cp['cz_id']) alert('등록된 자료가 없습니다.');
}
else
{
    $html_title = '쿠폰 입력';
    $cp['cz_start'] = G5_TIME_YMD;
    $cp['cz_end'] = date('Y-m-d', (G5_SERVER_TIME + 86400 * 15));
    $cp['cz_period'] = 15;
}

if($cp['cp_method'] == 1) {
    $cp_target_label = '적용분류';
    $cp_target_btn = '분류검색';
} else {
    $cp_target_label = '적용상품';
    $cp_target_btn = '상품검색';
}

$cpimg_str = false;
$cpimg = G5_DATA_PATH."/coupon/{$cp['cz_file']}";
if (is_file($cpimg) && $cp['cz_id']) {
    $size = @getimagesize($cpimg);
    if($size[0] && $size[0] > 750)
        $width = 750;
    else
        $width = $size[0];
    $cpimg_str = true;
}

$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">';
$frm_submit .= ' <a href="' . EYOOM_ADMIN_URL . '/?dir=shop&amp;pid=couponzonelist" class="btn-e btn-e-lg btn-e-dark">목록</a> ';
$frm_submit .= '</div>';

$atpl->assign(array(
	'cp' 		 => $cp,
	'frm_submit' => $frm_submit,
));

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";