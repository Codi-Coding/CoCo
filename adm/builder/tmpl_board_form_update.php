<?php
$sub_menu = "350903";
include_once('./_common.php');

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], 'w');

if (!$bo_table) { alert('게시판 TABLE명은 반드시 입력하세요.'); }
if (!preg_match("/^([A-Za-z0-9_]{1,20})$/", $bo_table)) { alert('게시판 TABLE명은 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내)'); }

// 분류에 & 나 = 는 사용이 불가하므로 2바이트로 바꾼다.
$src_char = array('&', '=');
$dst_char = array('＆', '〓');
$bo_category_list = str_replace($src_char, $dst_char, $bo_category_list);

$sql_common = " bo_skin             = '{$_POST['bo_skin']}'
                 ";

if ($w == '') {

    $row = sql_fetch(" select count(*) as cnt from {$g5['config2w_board_table']} where bo_table = '{$bo_table}' ");
    if ($row['cnt'])
        alert($bo_table.' 은(는) 이미 존재하는 TABLE 입니다.');

    $sql = " insert into {$g5['config2w_board_table']}
                set cf_id = '{$_POST['cf_id']}',
                    bo_table = '{$bo_table}',
                    $sql_common ";
    sql_query($sql);

}

///goto_url("./tmpl_board_form.php?w=u&bo_table={$bo_table}&amp;{$qstr}");
goto_url("./tmpl_board_form.php");
?>
