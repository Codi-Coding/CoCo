<?php
$sub_menu = '500300';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$sql = " select ev_subject from {$g5['g5_shop_event_table']} where ev_id = '$ev_id' ";
$ev = sql_fetch($sql);

$sql = " select b.it_id, b.it_name, b.it_use from {$g5['g5_shop_event_item_table']} a
           left join {$g5['g5_shop_item_table']} b on (a.it_id=b.it_id)
          where a.ev_id = '$ev_id'
          order by b.it_id desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
    
    $eventwin_list[$i] = $row;
    $eventwin_list[$i]['image'] = str_replace('"', "'", get_it_image($row['it_id'], 50, 50));
    $eventwin_list[$i]['href'] = $href;
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'ev' => $ev,
	'eventwin_list' => $eventwin_list,
));