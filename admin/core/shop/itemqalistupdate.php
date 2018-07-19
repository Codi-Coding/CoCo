<?php
$sub_menu = '400660';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

check_demo();

check_admin_token();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택삭제") {

    auth_check($auth[$sub_menu], 'd');

    for ($i=0; $i<count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        $sql = "delete from {$g5['g5_shop_item_qa_table']} where iq_id = '{$_POST['iq_id'][$k]}' ";
        sql_query($sql);
    }
}

alert("선택한 상품문의를 삭제처리하였습니다.", EYOOM_ADMIN_URL . "/?dir=shop&amp;pid=itemqalist&amp;sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>
