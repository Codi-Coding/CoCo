<?php
$sub_menu = '350890';
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

check_admin_token();

//
// 영카트 default
//
$sql = " update {$g5['g5_shop_default_table']}
            set de_pg_service                 = '{$_POST['de_pg_service']}',
                de_paypal_use                 = '$de_paypal_use',
                de_paypal_test                = '$de_paypal_test',
                de_paypal_mid                 = '$de_paypal_mid',
                de_paypal_currency_code       = '$de_paypal_currency_code',
                de_paypal_exchange_rate       = '$de_paypal_exchange_rate',
                de_alipay_use                 = '$de_alipay_use',
                de_alipay_test                = '$de_alipay_test',
                de_alipay_service_type        = '$de_alipay_service_type',
                de_alipay_partner             = '$de_alipay_partner',
                de_alipay_key                 = '$de_alipay_key',
                de_alipay_seller_id           = '$de_alipay_seller_id',
                de_alipay_seller_email        = '$de_alipay_seller_email',
                de_alipay_currency            = '$de_alipay_currency',
                de_alipay_exchange_rate       = '$de_alipay_exchange_rate',
                de_anet_use                   = '$de_anet_use',
                de_anet_test                  = '$de_anet_test',
                de_anet_id                    = '$de_anet_id',
                de_anet_key                   = '$de_anet_key',
                de_anet_test_mode             = '$de_anet_test_mode',
                de_anet_exchange_rate         = '$de_anet_exchange_rate',
                de_eximbay_use                = '$de_eximbay_use',
                de_eximbay_test               = '$de_eximbay_test',
                de_eximbay_mid                = '$de_eximbay_mid',
                de_eximbay_key                = '$de_eximbay_key',
                de_eximbay_currency           = '$de_eximbay_currency',
                de_eximbay_exchange_rate      = '$de_eximbay_exchange_rate',
                de_eximbay_lang               = '$de_eximbay_lang'
";
sql_query($sql);

goto_url("./shop_configform.php");
?>
