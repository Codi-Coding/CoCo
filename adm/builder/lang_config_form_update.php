<?php
$sub_menu = "350800";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_token();

if(!in_array($lang, $lang_list)) $lang_list = array_merge(array($lang), $lang_list);
$lang_list_str = implode('|', $lang_list);

///echo $lang."<br/>"; 
///echo $lang_list_str; 

$row = sql_fetch(" select count(*) as cnt from {$g5['config2w_def_table']} ");

if(defined('G5_USE_MULTI_LANG_SINGLE') and G5_USE_MULTI_LANG_SINGLE) { 
    if($row['cnt'])
        $sql = " update {$g5['config2w_def_table']} set lang='$lang' ";
    else
        $sql = " insert into {$g5['config2w_def_table']} set lang='$lang' ";
} else if(defined('G5_USE_MULTI_LANG') and G5_USE_MULTI_LANG) { 
    if($row['cnt'])
        $sql = " update {$g5['config2w_def_table']} set lang='$lang', lang_list='$lang_list_str' ";
    else
        $sql = " insert into {$g5['config2w_def_table']} set lang='$lang', lang_list='$lang_list_str' ";
}

///echo $sql."<br/>";
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config2w_def_table]` ");

goto_url('./lang_config_form.php', false);
?>
