<?php
$sub_menu = "350902";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$mb = get_member($cf_admin);
if (!$mb['mb_id'])
    alert('최고관리자 회원아이디가 존재하지 않습니다.');

check_token();

$sql = " select count(*) as cnt from $g5[config2w_config_table] where cf_id='{$_POST['cf_id']}' ";
$row = sql_fetch($sql);

if($row['cnt']) {
    $sql = " update {$g5['config2w_config_table']}
            set 
                cf_new_skin = '{$_POST['cf_new_skin']}',
                cf_search_skin = '{$_POST['cf_search_skin']}',
                cf_connect_skin = '{$_POST['cf_connect_skin']}',
                cf_faq_skin = '{$_POST['cf_faq_skin']}',
                cf_qa_skin = '{$_POST['cf_qa_skin']}',
                cf_co_skin = '{$_POST['cf_co_skin']}',
                cf_member_skin = '{$_POST['cf_member_skin']}',
                cf_shop_skin = '{$_POST['cf_shop_skin']}',
                cf_contents_skin = '{$_POST['cf_contents_skin']}'
            where cf_id = '{$_POST['cf_id']}'
                ";
} else {
    $sql = " insert into {$g5['config2w_config_table']}
            set 
                cf_new_skin = '{$_POST['cf_new_skin']}',
                cf_search_skin = '{$_POST['cf_search_skin']}',
                cf_connect_skin = '{$_POST['cf_connect_skin']}',
                cf_faq_skin = '{$_POST['cf_faq_skin']}',
                cf_qa_skin = '{$_POST['cf_qa_skin']}',
                cf_co_skin = '{$_POST['cf_co_skin']}',
                cf_member_skin = '{$_POST['cf_member_skin']}',
                cf_shop_skin = '{$_POST['cf_shop_skin']}',
                cf_contents_skin = '{$_POST['cf_contents_skin']}',
                cf_id = '{$_POST['cf_id']}'
                ";
}

sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config2w_config_table]` ");

goto_url('./tmpl_config_form.php', false);
?>
