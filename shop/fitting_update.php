<?php
include_once('./_common.php');

if (!$is_member)
    alert('회원 전용 서비스 입니다.', G5_BBS_URL.'/login.php?url='.urlencode($url));


// 피팅카트 아이템 삭제
if ($w == "d")
{
    $fc_id = trim($_GET['fitting_cart_id']);

    $sql = " select mb_id from CoCo_fitting_cart where fitting_cart_id = '$fc_id' ";
    $row = sql_fetch($sql);

    if($row['mb_id'] != $member['mb_id'])
        alert('피팅 상품을 삭제할 권한이 없습니다.');

    $sql = " delete from CoCo_fitting_cart
              where fitting_cart_id = '$fc_id'
                and mb_id = '{$member['mb_id']}' ";

    sql_query($sql);
    goto_url('./fittingroom.php');
}
// 피팅카트 추가
else
{
    $re = Array('re' => 0);
    if(is_array($it_id))
        $it_id = $_POST['it_id'];

    if(!$it_id)
        alert('상품코드가 올바르지 않습니다.', G5_SHOP_URL);

    // 상품정보 체크
    $sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $item_row = sql_fetch($sql);

    if(!$item_row['it_id'])
        alert('상품정보가 존재하지 않습니다.', G5_SHOP_URL);

    $sql = " select fitting_cart_id from CoCo_fitting_cart
              where mb_id = '{$member['mb_id']}' and it_id = '$it_id' ";
    $row = sql_fetch($sql);

    if (!$row['fitting_cart_id']) { // 없다면 등록
        $sql = " insert CoCo_fitting_cart
        set mb_id = '{$member['mb_id']}',
            it_id = '$it_id',
            cart_time = '".G5_TIME_YMDHIS."'";
        sql_query($sql);
        $re['src'] = apms_it_thumbnail($item_row, 40, 40, false, true)['src'];
        $re['re'] = 1;
    }
    echo(json_encode($re));
}

?>