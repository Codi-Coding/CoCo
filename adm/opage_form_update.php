<?php
$sub_menu = '300900';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");


$sql_common = " gr_id                  = '$gr_id',
                subject                = '$subject',
                mobile_subject         = '$mobile_subject',
                read_level             = '$read_level',
                content_include        = '$content_include',
                mobile_content_include = '$mobile_content_include',
                include_head           = '$include_head',
                include_tail           = '$include_tail' ";

if ($w == "")
{
    //if(eregi("[^a-z0-9_]", $op_id)) alert("ID 는 영문자, 숫자, _ 만 가능합니다.");
    if(preg_match("/[^a-z0-9_]/i", $op_id)) alert("ID 는 영문자, 숫자, _ 만 가능합니다.");

    $sql = " select op_id from {$g5['opage_table']} where op_id = '$op_id' ";
    $row = sql_fetch($sql);
    if ($row['op_id'])
        alert("이미 같은 ID로 등록된 외부페이지가 있습니다.");

    $sql = " insert {$g5['opage_table']}
                set op_id = '$op_id',
                    $sql_common ";
    sql_query($sql);
}
else if ($w == "u")
{
    $sql = " update {$g5['opage_table']}
                set $sql_common
              where op_id = '$op_id' ";
    sql_query($sql);
}
else if ($w == "d")
{
    $sql = " delete from {$g5['opage_table']} where op_id = '$op_id' ";
    sql_query($sql);
}

if ($w == "" || $w == "u")
{
    goto_url("./opage_form.php?w=u&amp;op_id=$op_id");
}
else
{
    goto_url("./opage_list.php");
}
?>
