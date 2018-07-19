<?php
$sub_menu = "350206";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_token();

$exchange_rate_list = array();
for($i = 0; $i < count($g5['currency_list_all']); $i++) {
    $currency = $g5['currency_list_all'][$i];
    if($_POST[$currency]) {
        $exchange_rate_list[] = $currency.':'.$_POST[$currency];
    }
}
$exchange_rate_list_str = implode('|', array_map('trim', $exchange_rate_list));

$row = sql_fetch(" select count(*) as cnt from {$g5['config2w_def_table']} ");

if($row['cnt'])
    $sql = " update {$g5['config2w_def_table']} set exchange_rate_list = '$exchange_rate_list_str' ";
else
    $sql = " insert into {$g5['config2w_def_table']} set exchange_rate_list = '$exchange_rate_list_str' ";

///echo $sql."<br/>";
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config2w_def_table]` ");

goto_url('./exchange_rate_config_form.php', false);
?>
