<?php
include_once('./_common.php');

if (!$is_member) {
    if (get_session('ss_orderview_uid') != $_GET['uid'])
        alert("직접 링크로는 수령확인이 불가합니다.\\n\\n주문조회 화면을 통하여 수령확인을 해주시기 바랍니다.", G5_SHOP_URL);
}

$sql = "select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
if($is_member && !$is_admin)
    $sql .= " and mb_id = '{$member['mb_id']}' ";
$od = sql_fetch($sql);
if (!$od['od_id'] || (!$is_member && md5($od['od_id'].$od['od_time'].$od['od_ip']) != get_session('ss_orderview_uid'))) {
    alert("수령확인하실 주문서가 없습니다.", G5_SHOP_URL);
}

// 개별상품처리
$mb_id = '';
$sql = "select ct_id from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and it_id = '$it_id' and ct_select = '1' ";
if($is_member && !$is_admin) {
    $sql .= " and mb_id = '{$member['mb_id']}' ";
	$mb_id = $member['mb_id'];
}
$result = sql_query($sql);
for($i=0; $row=sql_fetch_array($result); $i++) {
	apms_order_it($row['ct_id'], $mb_id);
}

// 주문서 완료처리
$sql = "select count(*) as cnt from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_status <> '완료' and ct_select = '1' ";
$row = sql_fetch($sql);
if(!$row['cnt']) {
	sql_query(" update {$g5['g5_shop_order_table']} set od_status = '완료' where od_id = '$od_id' ");
}

// 이동하기
goto_url(G5_SHOP_URL.'/orderinquiryview.php?od_id='.$od['od_id'].'&amp;uid='.urlencode($uid));

?>