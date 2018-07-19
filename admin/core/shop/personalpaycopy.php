<?php
$sub_menu = '400440';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "w");

$sql = " select * from {$g5['g5_shop_personalpay_table']} where pp_id = '$pp_id' ";
$row = sql_fetch($sql);

if(!$row['pp_id'])
    alert_close('복사하시려는 개인결제 정보가 존재하지 않습니다.');
    
$copy = clean_xss_tags(trim($_GET['copy']));

/**
 * 폼 action URL
 */
$action_url = EYOOM_ADMIN_URL . "/?dir=shop&amp;pid=personalpaycopyupdate&amp;smode=1";

$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="복사하기" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">';
$frm_submit .= '</div>';

$atpl->assign(array(
	'pp' 		 => $row,
	'frm_submit' => $frm_submit,
));

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";