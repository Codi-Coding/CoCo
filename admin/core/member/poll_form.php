<?php
$sub_menu = "200900";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$action_url = EYOOM_ADMIN_URL . '/?dir=member&amp;pid=poll_form_update&amp;smode=1';

$po_id = isset($po_id) ? (int) $po_id : 0;

if ($w == '')
    $html_title = ' 생성';
else if ($w == 'u')  {
    $html_title = ' 수정';
    $sql = " select * from {$g5['poll_table']} where po_id = '{$po_id}' ";
    $po = sql_fetch($sql);
} else
    alert('w 값이 제대로 넘어오지 않았습니다.');

for ($i=1; $i<=9; $i++) {
    $required = '';
    if ($i==1 || $i==2) {
        $required = 'required';
        $sound_only = '<strong class="sound_only">필수</strong>';
    }
    
    $poll_item[$i]['po_poll'] 	= get_text($po['po_poll'.$i]);
    $poll_item[$i]['po_cnt'] 	= $po['po_cnt'.$i];
}
    
include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'po' 		=> $po,
	'poll_item'	=> $poll_item,
));