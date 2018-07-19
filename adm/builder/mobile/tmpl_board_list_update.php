<?php
$sub_menu = "350903";
include_once('./_common.php');

check_demo();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택수정") {

    auth_check($auth[$sub_menu], 'w');

    for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        if ($is_admin != 'super') {
            alert('최고관리자가 아닌 경우 수정이 불가합니다.');
        }

        $sql = " update {$g5['config2w_m_board_table']}
                    set bo_mobile_skin      = '{$_POST['bo_mobile_skin'][$k]}'
                  where cf_id    = '{$_POST['cf_id']}' 
                    and bo_table = '{$_POST['board_table'][$k]}' 
        ";
        sql_query($sql);
    }

} else if ($_POST['act_button'] == "선택삭제") {

    if ($is_admin != 'super')
        alert('게시판 삭제는 최고관리자만 가능합니다.');

    auth_check($auth[$sub_menu], 'd');

    check_token();

    // _BOARD_DELETE_ 상수를 선언해야 board_delete.inc.php 가 정상 작동함
    define('_BOARD_DELETE_', true);
    $tmp_cf_id = $_POST['cf_id'];

    for ($i=0; $i<count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        // include 전에 $bo_table 값을 반드시 넘겨야 함
        $tmp_bo_table = trim($_POST['board_table'][$k]);
        include ('./tmpl_board_delete.inc.php');
    }


}

goto_url('./tmpl_board_list.php?'.$qstr);
?>
