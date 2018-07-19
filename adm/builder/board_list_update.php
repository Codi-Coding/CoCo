<?php
$sub_menu = "350203";
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
            $sql = " select count(*) as cnt from {$g5['board_table']} a, {$g5['group_table']} b
                      where a.gr_id = '{$_POST['gr_id'][$k]}'
                        and a.gr_id = b.gr_id
                        and b.gr_admin = '{$member['mb_id']}' ";
            $row = sql_fetch($sql);
            if (!$row['cnt'])
                alert('최고관리자가 아닌 경우 다른 관리자의 게시판('.$board_table[$k].')은 수정이 불가합니다.');
        }

        $sql = " update {$g5['board_table']}
                    set bo_explan          = '{$_POST['bo_explan'][$k]}'
                  where bo_table            = '{$_POST['board_table'][$k]}' ";
        sql_query($sql);
    }

}

goto_url('./board_list.php?'.$qstr);
?>
