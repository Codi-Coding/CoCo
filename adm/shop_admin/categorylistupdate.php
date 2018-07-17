<?php
$sub_menu = '400200';
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

check_admin_token();

for ($i=0; $i<count($_POST['ca_id']); $i++)
{
    if ($_POST['ca_mb_id'][$i])
    {
        $sql = " select mb_id from {$g5['member_table']} where mb_id = '{$_POST['ca_mb_id'][$i]}' ";
        $row = sql_fetch($sql);
        if (!$row['mb_id'])
            alert("\'{$_POST['ca_mb_id'][$i]}\' 은(는) 존재하는 회원아이디가 아닙니다.", "./categorylist.php?page=$page&amp;sort1=$sort1&amp;sort2=$sort2");
    }

    if(!empty($_POST['ca_skin'][$i]) && ! is_include_path_check($_POST['ca_skin'][$i])){
        alert("오류 : 데이터폴더가 포함된 path 를 포함할수 없습니다.");
    }

    $sql = " update {$g5['g5_shop_category_table']}
                set ca_name             = '{$_POST['ca_name'][$i]}',
                    ca_order            = '{$_POST['ca_order'][$i]}',
					ca_mb_id            = '{$_POST['ca_mb_id'][$i]}',
					ca_use              = '{$_POST['ca_use'][$i]}',
                    ca_cert_use         = '{$_POST['ca_cert_use'][$i]}',
					ca_adult_use        = '{$_POST['ca_adult_use'][$i]}',
                    ca_img_width        = '{$_POST['ca_img_width'][$i]}',
                    ca_img_height       = '{$_POST['ca_img_height'][$i]}',
                    ca_mobile_img_width  = '{$_POST['ca_mobile_img_width'][$i]}',
                    ca_mobile_img_height = '{$_POST['ca_mobile_img_height'][$i]}',
                    ca_skin             = '{$_POST['ca_skin'][$i]}',
                    ca_mobile_skin      = '{$_POST['ca_mobile_skin'][$i]}',
                    ca_skin_dir         = '{$_POST['ca_skin_dir'][$i]}',
                    ca_mobile_skin_dir  = '{$_POST['ca_mobile_skin_dir'][$i]}',
					ca_list_mod         = '{$_POST['ca_list_mod'][$i]}',
                    ca_list_row         = '{$_POST['ca_list_row'][$i]}',
                    ca_mobile_list_mod  = '{$_POST['ca_mobile_list_mod'][$i]}',
                    ca_mobile_list_row  = '{$_POST['ca_mobile_list_row'][$i]}',
                    ca_stock_qty        = '{$_POST['ca_stock_qty'][$i]}',
					pt_use			    = '{$_POST['pt_use'][$i]}',
                    pt_limit		    = '{$_POST['pt_limit'][$i]}',
                    pt_item			    = '{$_POST['pt_item'][$i]}',
					pt_point		    = '{$_POST['pt_point'][$i]}',
                    pt_form			    = '{$_POST['pt_form'][$i]}'
              where ca_id = '{$_POST['ca_id'][$i]}' "; // APMS : 2014.07.23
    sql_query($sql);
}

goto_url("./categorylist.php?$qstr");
?>
