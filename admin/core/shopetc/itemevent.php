<?php
$sub_menu = '500300';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$sql_common = " from {$g5['g5_shop_event_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = "select * $sql_common order by ev_id desc ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {

    $href = "";
    $sql = " select count(ev_id) as cnt from {$g5['g5_shop_event_item_table']} where ev_id = '{$row['ev_id']}' ";
    $ev = sql_fetch($sql);
    if ($ev['cnt']) {
        $href = "<a href='javascript:;' onclick=itemeventwin('".$row['ev_id']."')>".$ev['cnt']."</a>";
    }
    if ($row['ev_subject_strong']) $subject = '<strong>'.$row['ev_subject'].'</strong>';
    else $subject = $row['ev_subject'];
    
    $it_event[$i] = $row;
    $it_event[$i]['cnt'] = $ev['cnt'];
    $it_event[$i]['href'] = $href;
    $it_event[$i]['subject'] = $subject;
    
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'it_event' => $it_event,
));