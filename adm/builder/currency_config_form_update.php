<?php
$sub_menu = "350205";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_token();

$currency_list = array();
$lang_currency_list = array();

for($i = 0; $i < count($g5['lang_list_all']); $i++) {
    $lang = $g5['lang_list_all'][$i];
    if($_POST['currency_'.$lang]) {
        $currency_list[] = $_POST['currency_'.$lang];
        $lang_currency_list[] = $lang.':'.$_POST['currency_'.$lang];
    }
}

$currency_list_str = implode('|', $currency_list);
$lang_currency_list_str = implode('|', $lang_currency_list);

///echo $lang_currency_list_str;

$row = sql_fetch(" select count(*) as cnt from {$g5['config2w_def_table']} ");

if($row['cnt'])
    $sql = " update {$g5['config2w_def_table']} set currency = '{$_POST['currency']}', currency_list = '$currency_list_str', lang_currency_list = '$lang_currency_list_str' ";
else
    $sql = " insert into {$g5['config2w_def_table']} set currency = '{$_POST['currency']}', currency_list = '$currency_list_str', lang_currency_list = '$lang_currency_list_str' ";

///echo $sql."<br/>";
sql_query($sql);

if($_POST['currency'] != $g5['def_currency']) {
    $exchange_rate_list_str_new = '';

    for($i = 0; $i < count($g5['currency_list_all']); $i++) {
        $currency_i = $g5['currency_list_all'][$i];
        $exchange_rate_list_str_new .= $currency_i.':'.$g5['exchange_rate_list'][$currency_i] / $g5['exchange_rate_list'][$_POST['currency']].'|';
    }

    $exchange_rate_list_str_new = rtrim($exchange_rate_list_str_new, '|');
    ///echo $exchange_rate_list_str_new;

    $sql = " update {$g5['config2w_def_table']} set exchange_rate_list = '$exchange_rate_list_str_new' ";
    sql_query($sql);
}

//sql_query(" OPTIMIZE TABLE `$g5[config2w_def_table]` ");

goto_url('./currency_config_form.php', false);
?>
