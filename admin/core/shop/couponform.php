<?php
$sub_menu = '400800';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "w");

/**
 * 폼 action URL
 */
$action_url = EYOOM_ADMIN_URL . "/?dir=shop&amp;pid=couponformupdate&amp;smode=1";

$g5['title'] = '쿠폰관리';

if ($w == 'u') {
    $html_title = '쿠폰 수정';

    $sql = " select * from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
    $cp = sql_fetch($sql);
    if (!$cp['cp_id']) alert('등록된 자료가 없습니다.');
}
else
{
    $html_title = '쿠폰 입력';
    $cp['cp_start'] = G5_TIME_YMD;
    $cp['cp_end'] = date('Y-m-d', (G5_SERVER_TIME + 86400 * 7));
}

if($cp['cp_method'] == 1) {
    $cp_target_label = '적용분류';
    $cp_target_btn = '분류검색';
} else {
    $cp_target_label = '적용상품';
    $cp_target_btn = '상품검색';
}

$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">';
$frm_submit .= ' <a href="' . EYOOM_ADMIN_URL . '/?dir=shop&amp;pid=couponlist" class="btn-e btn-e-lg btn-e-dark">목록</a> ';
$frm_submit .= '</div>';

$atpl->assign(array(
	'cp' 		 => $cp,
	'frm_submit' => $frm_submit,
));

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";