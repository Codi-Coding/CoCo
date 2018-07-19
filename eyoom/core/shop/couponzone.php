<?php
if (!defined('_SHOP_')) exit;

$sql_common = " from {$g5['g5_shop_coupon_zone_table']}
                where cz_start <= '".G5_TIME_YMD."'
                  and cz_end >= '".G5_TIME_YMD."' ";

$sql_order  = " order by cz_id desc ";

add_javascript('<script src="'.G5_JS_URL.'/shop.couponzone.js"></script>', 100);

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/couponzone.php');
	return;
}

$g5['title'] = "쿠폰존";

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');


/**
 * 다운로드 쿠폰
 */
$sql = " select * $sql_common and cz_type = '0' $sql_order ";
$result = sql_query($sql);

$coupon = '';

for($i=0; $row=sql_fetch_array($result); $i++) {
    if(!$row['cz_file'])
        continue;

    $img_file = G5_DATA_PATH.'/coupon/'.$row['cz_file'];
    if(!is_file($img_file))
        continue;

    $subj = get_text($row['cz_subject']);

    switch($row['cp_method']) {
        case '0':
            $sql3 = " select it_id, it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['cp_target']}' ";
            $row3 = sql_fetch($sql3);
            $cp_target = '<a href="./item.php?it_id='.$row3['it_id'].'">'.get_text($row3['it_name']).'</a>';
            break;
        case '1':
            $sql3 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
            $row3 = sql_fetch($sql3);
            $cp_target = '<a href="./list.php?ca_id='.$row3['ca_id'].'">'.get_text($row3['ca_name']).'</a>';
            break;
        case '2':
            $cp_target = '주문금액할인';
            break;
        case '3':
            $cp_target = '배송비할인';
            break;
    }

    // 다운로드 쿠폰인지
    $disabled = '';
    if(is_coupon_downloaded($member['mb_id'], $row['cz_id']))
        $disabled = ' disabled';
        
    $dcoupon[$i] = $row;
    $dcoupon[$i]['image'] = str_replace(G5_PATH, G5_URL, $img_file);
    $dcoupon[$i]['coupon_tit'] = $subj;
    $dcoupon[$i]['coupon_target'] = $cp_target;
    $dcoupon[$i]['disabled'] = $disabled;
}

/**
 * 포인트 쿠폰
 */
$sql = " select * $sql_common and cz_type = '1' $sql_order ";
$result = sql_query($sql);

$coupon = '';

for($i=0; $row=sql_fetch_array($result); $i++) {
    if(!$row['cz_file'])
        continue;

    $img_file = G5_DATA_PATH.'/coupon/'.$row['cz_file'];
    if(!is_file($img_file))
        continue;

    $subj = get_text($row['cz_subject']);

    switch($row['cp_method']) {
        case '0':
            $sql3 = " select it_id, it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['cp_target']}' ";
            $row3 = sql_fetch($sql3);
            $cp_target = '<a href="./item.php?it_id='.$row3['it_id'].'">'.get_text($row3['it_name']).'</a>';
            break;
        case '1':
            $sql3 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
            $row3 = sql_fetch($sql3);
            $cp_target = '<a href="./list.php?ca_id='.$row3['ca_id'].'">'.get_text($row3['ca_name']).'</a>';
            break;
        case '2':
            $cp_target = '주문금액할인';
            break;
        case '3':
            $cp_target = '배송비할인';
            break;
    }

    // 다운로드 쿠폰인지
    $disabled = '';
    if(is_coupon_downloaded($member['mb_id'], $row['cz_id']))
        $disabled = ' disabled';

    $pcoupon[$i] = $row;
    $pcoupon[$i]['image'] = str_replace(G5_PATH, G5_URL, $img_file);
    $pcoupon[$i]['coupon_tit'] = $subj;
    $pcoupon[$i]['coupon_target'] = $cp_target;
    $pcoupon[$i]['disabled'] = $disabled;
}

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'couponzone.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/couponzone.php');

$tpl->assign(array(
	'dcoupon' => $dcoupon,
	'pcoupon' => $pcoupon,
));

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');