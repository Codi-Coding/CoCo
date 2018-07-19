<?php // 굿빌더 ?>
<?php
$sub_menu = "350801";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "데이타베이스 업그레이드";
include_once ("../admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>

<section class="cbox">
<div style="float:right">데이타베이스: <?php echo G5_MYSQL_DB?></div>
<h2>업그레이드 결과</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td valign=top style="padding:10px 5px 5px 5px">
<?php
echo "<b>[DB 업그레이드]</b><br><br>";

$check_count   = 0;
$upgrade_count = 0;

// config2w_m 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_m_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_m_table']." 생성 ";
    $res = sql_query(" CREATE TABLE `{$g5['config2w_m_table']}` (
        `cf_id` varchar(30) NOT NULL default '',
        `cf_search` varchar(30) NOT NULL default 'nouse',
        `cf_menu` varchar(30) NOT NULL default 'list',
        `cf_main_image` varchar(30) NOT NULL default 'nouse',
        PRIMARY KEY  (`cf_id`) ) ", false);

    $res = sql_query(" INSERT INTO `{$g5['config2w_m_table']}` VALUES (1,'basic','basic','nouse','list','nouse'),(4,'basic_g5','basic','nouse','list','nouse'),(5,'shop_basic','basic','nouse','list','nouse'),(6,'shop_basic_yc5','basic','nouse','list','nouse'),(8,'shop_c_basic','basic','nouse','list','nouse'),(9,'shop_c_basic_g5','basic','nouse','list','nouse') ", false);

    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
    }
    echo "<br>";
}

// config2w_def 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_def_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_def_table']." 생성 ";
    $res = sql_query(" CREATE TABLE `{$g5['config2w_def_table']}` (
        `cf_templete` varchar(30) NOT NULL default 'basic') ");

    $res = sql_query(" INSERT INTO `{$g5['config2w_def_table']}` (cf_templete) VALUES ('{$g5['tmpl']}') ", false);

    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
        $config2w_def = sql_fetch(" select * from `{$g5['config2w_def_table']}` ");
        
    }
    echo "<br>";
}

// config2w_m_def 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_m_def_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_m_def_table']." 생성 ";
    $res = sql_query(" CREATE TABLE `{$g5['config2w_m_def_table']}` (
        `cf_templete` varchar(30) NOT NULL default 'basic') ", false);

    $res = sql_query(" INSERT INTO `{$g5['config2w_m_def_table']}` VALUES ('{$g5['mobile_tmpl']}') ", false);

    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
        $config2w_m_def = sql_fetch(" select * from `{$g5['config2w_m_def_table']}` ");
    }
    echo "<br>";
}

if(defined('G5_USE_SHOP') && G5_USE_SHOP) {

/// paypal
$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` CHANGE `de_currency_code` `de_paypal_currency_code` VARCHAR(10) NOT NULL DEFAULT '' ";
if(isset($default['de_currency_code'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."의 de_currency_code를 de_paypal_currency_code로 변경 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 변경되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` CHANGE `de_exchange_rate` `de_paypal_exchange_rate` VARCHAR(20) NOT NULL DEFAULT '' ";
if(isset($default['de_exchange_rate'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."의 de_exchange_rate를 de_paypal_exchange_rate로 변경 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 변경되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_paypal_test` tinyint(4) NOT NULL DEFAULT '0' AFTER de_paypal_use ";
if(!isset($default['de_paypal_test'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_paypal_test를 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

/// alipay
$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_alipay_use` tinyint(4) NOT NULL DEFAULT '0' AFTER de_paypal_exchange_rate ";
if(!isset($default['de_alipay_use'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_use를 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_alipay_test` tinyint(4) NOT NULL DEFAULT '0' AFTER de_alipay_use ";
if(!isset($default['de_alipay_test'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_test를 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_alipay_service_type` VARCHAR(30) NOT NULL DEFAULT '' ";
if(!isset($default['de_alipay_service_type'])) {
    echo $g5['g5_shop_default_table']."에 de_alipay_service_type을 추가 ";
    $check_count++;
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_alipay_partner` VARCHAR(60) NOT NULL DEFAULT '' ";
if(!isset($default['de_alipay_partner'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_partner를 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_alipay_key` VARCHAR(120) NOT NULL DEFAULT '' ";
if(!isset($default['de_alipay_key'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_key를 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_alipay_seller_id` VARCHAR(60) NOT NULL DEFAULT '' ";
if(!isset($default['de_alipay_seller_id'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_seller_id를 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_alipay_seller_email` VARCHAR(120) NOT NULL DEFAULT '' ";
if(!isset($default['de_alipay_seller_email'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_seller_email을 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_alipay_currency` VARCHAR(10) NOT NULL DEFAULT '' ";
if(!isset($default['de_alipay_currency'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_currency를 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `de_alipay_exchange_rate` VARCHAR(20) NOT NULL DEFAULT '' AFTER de_alipay_currency ";
if(!isset($default['de_alipay_exchange_rate'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_exchange_rate를 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

/// authorize.net
if(!isset($default['de_anet_use'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_use를 추가 ";
    $res = sql_query(" alter table `{$g5['g5_shop_default_table']}` add `de_anet_use` tinyint(4) not null default 0 ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if(!isset($default['de_anet_test'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_test를 추가 ";
    $res = sql_query(" alter table `{$g5['g5_shop_default_table']}` add `de_anet_test` tinyint(4) not null default 0 ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";

}

if(!isset($default['de_anet_id'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_id를 추가 ";
    $res = sql_query(" alter table `{$g5['g5_shop_default_table']}` add `de_anet_id` varchar(255) not null default '' ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if(!isset($default['de_anet_key'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_key를 추가 ";
    $res = sql_query(" alter table `{$g5['g5_shop_default_table']}` add `de_anet_key` varchar(255) not null default '' ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if(!isset($default['de_anet_test_mode'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_test_mode를 추가 ";
    $res = sql_query(" alter table `{$g5['g5_shop_default_table']}` add `de_anet_test_mode` tinyint(4) not null default 0 ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if(!isset($default['de_anet_exchange_rate'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_exchange_rate를 추가 ";
    $res = sql_query(" alter table `{$g5['g5_shop_default_table']}` add `de_anet_exchange_rate` varchar(20) not null default '' after de_anet_test_mode ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_order_table']}` LIKE 'od_status_detail' ";
$row = sql_fetch($sql);
$sql = " ALTER TABLE `{$g5['g5_shop_order_table']}` ADD `od_status_detail` VARCHAR(255) NOT NULL DEFAULT '' ";
if(!isset($row['Field'])) {
    $check_count++;
    echo $g5['g5_shop_order_table']."에 od_status_detail을 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_order_table']}` LIKE 'od_test' ";
$row = sql_fetch($sql);
$sql = " ALTER TABLE `{$g5['g5_shop_order_table']}` ADD `od_test` tinyint(4) NOT NULL DEFAULT '0' AFTER od_settle_case ";

if(!isset($row['Field'])) {
    $check_count++;
    echo $g5['g5_shop_order_table']."에 od_test를 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_cart_table']}` LIKE 'ct_status_detail' ";
$row = sql_fetch($sql);
$sql = " ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `ct_status_detail` VARCHAR(255) NOT NULL DEFAULT '' ";
if(!isset($row['Field'])) {
    $check_count++;
    echo $g5['g5_shop_cart_table']."에 ct_status_detail을 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_cart_table']}` LIKE 'ct_select_time' ";
$row = sql_fetch($sql);
$sql = " ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `ct_select_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `ct_select` ";
if(!isset($row['Field'])) {
    $check_count++;
    echo $g5['g5_shop_cart_table']."에 ct_select_time을 추가 ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 상품메모 필드 추가
if(!sql_query(" select it_shop_memo from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    $check_count++;
    echo $g5['g5_shop_item_table']."에 it_shop_memo를 추가 ";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}`
                    ADD `it_shop_memo` text NOT NULL AFTER `it_use_avg` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 현금영수증 필드 추가
if(!sql_query(" select pp_cash from {$g5['g5_shop_personalpay_table']} limit 1 ", false)) {
    $check_count++;
    echo $g5['g5_shop_personalpay_table']."에 pp_cach를 추가 (이외 5 개 포함) ";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_personalpay_table']}`
                    ADD `pp_cash` tinyint(4) NOT NULL DEFAULT '0' AFTER `pp_shop_memo`,
                    ADD `pp_cash_no` varchar(255) NOT NULL DEFAULT '' AFTER `pp_cash`,
                    ADD `pp_cash_info` text NOT NULL AFTER `pp_cash_no`,
                    ADD `pp_email` varchar(255) NOT NULL DEFAULT '' AFTER `pp_name`,
                    ADD `pp_hp` varchar(255) NOT NULL DEFAULT '' AFTER `pp_email`,
                    ADD `pp_casseqno` varchar(255) NOT NULL DEFAULT '' AFTER `pp_app_no` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// cart 테이블 index 추가
if(!sql_fetch(" show keys from {$g5['g5_shop_cart_table']} where Key_name = 'it_id' ")) {
    $check_count++;
    echo $g5['g5_shop_cart_table']."에 it_id를 추가 (이외 1 개 포함) ";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}`
                    ADD INDEX `it_id` (`it_id`),
                    ADD INDEX `ct_status` (`ct_status`) ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 모바일 이니시스 계좌이체 결과 전달을 위한 테이블 추가
if(!sql_query(" DESCRIBE {$g5['g5_shop_inicis_log_table']} ", false)) {
    $check_count++;
    echo $g5['g5_shop_inicis_log_table']." 생성 ";
    $res = sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['g5_shop_inicis_log_table']}` (
                  `oid` bigint(20) unsigned NOT NULL,
                  `P_TID` varchar(255) NOT NULL DEFAULT '',
                  `P_MID` varchar(255) NOT NULL DEFAULT '',
                  `P_AUTH_DT` varchar(255) NOT NULL DEFAULT '',
                  `P_STATUS` varchar(255) NOT NULL DEFAULT '',
                  `P_TYPE` varchar(255) NOT NULL DEFAULT '',
                  `P_OID` varchar(255) NOT NULL DEFAULT '',
                  `P_FN_NM` varchar(255) NOT NULL DEFAULT '',
                  `P_AMT` int(11) NOT NULL DEFAULT '0',
                  `P_RMESG1` varchar(255) NOT NULL DEFAULT '',
                  PRIMARY KEY (`oid`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
    }
    echo "<br>";
}

// 결제정보 임시저장 테이블 추가
if(isset($g5['g5_shop_order_data_table']) && !sql_query(" DESCRIBE {$g5['g5_shop_order_data_table']} ", false)) {
    $check_count++;
    echo $g5['g5_shop_order_data_table']." 생성 ";
    $res = sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['g5_shop_order_data_table']}` (
                  `od_id` bigint(20) unsigned NOT NULL,
                  `dt_pg` varchar(255) NOT NULL DEFAULT '',
                  `dt_data` text NOT NULL,
                  `dt_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  KEY `od_id` (`od_id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8;", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
    }
    echo "<br>";
}

// inicis 필드 추가
if(!isset($default['de_inicis_mid'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_inicis_mid, de_inicis_admin_key 필드 추가 ";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_inicis_mid` varchar(255) NOT NULL DEFAULT '' AFTER `de_kcp_site_key`,
                    ADD `de_inicis_admin_key` varchar(255) NOT NULL DEFAULT '' AFTER `de_inicis_mid` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 레이아웃 파일 필드 삭제
if(isset($default['de_include_index'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에서 de_include_index 필드 삭제 (이외 2 개 포함)";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    DROP `de_include_index`,
                    DROP `de_include_head`,
                    DROP `de_include_tail` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 삭제되었습니다</font>";
    }
    echo "<br>";
}

// PG 간펼결제 사용여부 필드 추가
if(!isset($default['de_easy_pay_use'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_easy_pay_use 필드 추가 (이외 5 개 포함)";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_easy_pay_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_iche_use`,
                    ADD `de_kakaopay_mid` varchar(255) NOT NULL DEFAULT '' AFTER `de_tax_flag_use`,
                    ADD `de_kakaopay_key` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_mid`,
                    ADD `de_kakaopay_enckey` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_key`,
                    ADD `de_kakaopay_hashkey` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_enckey`,
                    ADD `de_kakaopay_cancelpwd` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_hashkey` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_event_table']}` LIKE 'ev_mobile_list_row' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['g5_shop_event_table']."에 `ev_mobile_list_row를 추가";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_event_table']}`
                    ADD `ev_mobile_list_row` int(11) NOT NULL DEFAULT '0' AFTER `ev_mobile_list_mod` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_inicis_log_table']}` LIKE 'P_AUTH_NO' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['g5_shop_inicis_log_table']."에 `P_AUTH_NO를 추가";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_inicis_log_table']}`
                    ADD `P_AUTH_NO` varchar(255) NOT NULL DEFAULT '' AFTER `P_FN_NM` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 네이버페이 필드추가
if(!isset($default['de_naverpay_mid'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 `de_naverpay_mid 외 5 개의 필드를 추가";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_naverpay_mid` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_cancelpwd`,
                    ADD `de_naverpay_cert_key` varchar(255) NOT NULL DEFAULT '' AFTER `de_naverpay_mid`,
                    ADD `de_naverpay_button_key` varchar(255) NOT NULL DEFAULT '' AFTER `de_naverpay_cert_key`,
                    ADD `de_naverpay_test` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_naverpay_button_key`,
                    ADD `de_naverpay_mb_id` varchar(255) NOT NULL DEFAULT '' AFTER `de_naverpay_test`,
                    ADD `de_naverpay_sendcost` varchar(255) NOT NULL DEFAULT '' AFTER `de_naverpay_mb_id`", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 지식쇼핑 PID 필드추가
if(!sql_query(" select ec_mall_pid from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    $check_count++;
    echo $g5['g5_shop_item_table']."에 `ec_mall_pid를 추가";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}`
                    ADD `ec_mall_pid` varchar(255) NOT NULL AFTER `it_shop_memo` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 쿠폰존 테이블 추가
if(isset($g5['g5_shop_coupon_zone_table'])) {
    if(!sql_query(" DESCRIBE {$g5['g5_shop_coupon_zone_table']} ", false)) {
        $check_count++;
        echo $g5['g5_shop_coupon_zone_table']." 생성";
        $res = sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['g5_shop_coupon_zone_table']}` (
                      `cz_id` int(11) NOT NULL AUTO_INCREMENT,
                      `cz_type` tinyint(4) NOT NULL DEFAULT '0',
                      `cz_subject` varchar(255) NOT NULL DEFAULT '',
                      `cz_start` DATE NOT NULL DEFAULT '0000-00-00',
                      `cz_end` DATE NOT NULL DEFAULT '0000-00-00',
                      `cz_file` varchar(255) NOT NULL DEFAULT '',
                      `cz_period` int(11) NOT NULL DEFAULT '0',
                      `cz_point` INT(11) NOT NULL DEFAULT '0',
                      `cp_method` TINYINT(4) NOT NULL DEFAULT '0',
                      `cp_target` VARCHAR(255) NOT NULL DEFAULT '',
                      `cp_price` INT(11) NOT NULL DEFAULT '0',
                      `cp_type` TINYINT(4) NOT NULL DEFAULT '0',
                      `cp_trunc` INT(11) NOT NULL DEFAULT '0',
                      `cp_minimum` INT(11) NOT NULL DEFAULT '0',
                      `cp_maximum` INT(11) NOT NULL DEFAULT '0',
                      `cz_download` int(11) NOT NULL DEFAULT '0',
                      `cz_datetime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
                      PRIMARY KEY (`cz_id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
        if($res) {
            $upgrade_count++;
            echo "<font color=#ff0000> ---> 생성되었습니다</font>";
        }
        echo "<br>";
    }
}

// 유형별상품리스트 설정필드 추가
if(!isset($default['de_listtype_list_skin'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_listtype_list_skin 외 9 개 필드 추가";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_listtype_list_skin` varchar(255) NOT NULL DEFAULT '' AFTER `de_mobile_search_img_height`,
                    ADD `de_listtype_list_mod` int(11) NOT NULL DEFAULT '0' AFTER `de_listtype_list_skin`,
                    ADD `de_listtype_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_listtype_list_mod`,
                    ADD `de_listtype_img_width` int(11) NOT NULL DEFAULT '0' AFTER `de_listtype_list_row`,
                    ADD `de_listtype_img_height` int(11) NOT NULL DEFAULT '0' AFTER `de_listtype_img_width`,
                    ADD `de_mobile_listtype_list_skin` varchar(255) NOT NULL DEFAULT '' AFTER `de_listtype_img_height`,
                    ADD `de_mobile_listtype_list_mod` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_listtype_list_skin`,
                    ADD `de_mobile_listtype_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_listtype_list_mod`,
                    ADD `de_mobile_listtype_img_width` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_listtype_list_row`,
                    ADD `de_mobile_listtype_img_height` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_listtype_img_width` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 이니시스 삼성페이 사용여부 필드 추가
if(!isset($default['de_samsung_pay_use'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_easy_pay_use 필드 추가";
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_samsung_pay_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_easy_pay_use` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

} /// if G5_USE_SHOP

///if(defined('G5_USE_TMPL_SKIN') and G5_USE_TMPL_SKIN) {
if(1) {

// config2w_config 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_config_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_config_table']."생성 ";
    $res = sql_query(" CREATE TABLE `{$g5['config2w_config_table']}` (
        `cf_id` varchar(255) NOT NULL default '',
        `cf_new_skin` varchar(255) NOT NULL default '',
        `cf_search_skin` varchar(255) NOT NULL default '',
        `cf_connect_skin` varchar(255) NOT NULL default '',
        `cf_faq_skin` varchar(255) NOT NULL default '',
        `cf_qa_skin` varchar(255) NOT NULL default '',
        `cf_member_skin` varchar(255) NOT NULL default '',
        `cf_shop_skin` varchar(255) NOT NULL default '',
        PRIMARY KEY  (`cf_id`) ) ", false);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
    }
    echo "<br>";
}

// config2w_board 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_board_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_board_table']."생성 ";
    $res = sql_query(" CREATE TABLE `{$g5['config2w_board_table']}` (
        `cf_id` varchar(255) NOT NULL default '',
        `bo_table` varchar(20) NOT NULL default '',
        `bo_skin` varchar(255) NOT NULL default '',
        `bo_latest_skin` varchar(255) NOT NULL default '',
        PRIMARY KEY  (`cf_id`,`bo_table`) ) ", false);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
    }
    echo "<br>";
}

// config2w_m_config 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_m_config_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_m_config_table']."생성 ";
    $res = sql_query(" CREATE TABLE `{$g5['config2w_m_config_table']}` (
        `cf_id` varchar(255) NOT NULL default '',
        `cf_mobile_new_skin` varchar(255) NOT NULL default '',
        `cf_mobile_search_skin` varchar(255) NOT NULL default '',
        `cf_mobile_connect_skin` varchar(255) NOT NULL default '',
        `cf_mobile_faq_skin` varchar(255) NOT NULL default '',
        `cf_mobile_qa_skin` varchar(255) NOT NULL default '',
        `cf_mobile_member_skin` varchar(255) NOT NULL default '',
        `cf_mobile_shop_skin` varchar(255) NOT NULL default '',
        PRIMARY KEY  (`cf_id`) ) ", false);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
    }
    echo "<br>";
}

// config2w_m_board 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_m_board_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_m_board_table']."생성 ";
    $res = sql_query(" CREATE TABLE `{$g5['config2w_m_board_table']}` (
        `cf_id` varchar(255) NOT NULL default '',
        `bo_table` varchar(20) NOT NULL default '',
        `bo_mobile_skin` varchar(255) NOT NULL default '',
        `bo_mobile_latest_skin` varchar(255) NOT NULL default '',
        PRIMARY KEY  (`cf_id`,`bo_table`) ) ", false);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
    }
    echo "<br>";
}

} /// if G5_USE_TMPL_SKIN

if(!isset($config2w['cf_use_common_logo'])) {
    $check_count++;
    echo $g5['config2w_table']."에 cf_use_common_logo를 추가 (이외 2 개 포함) ";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_table']}`
                    ADD `cf_use_common_logo` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_tail_long_4`,
                    ADD `cf_use_common_menu` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_use_common_logo`,
                    ADD `cf_use_common_addr` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_use_common_menu` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if(!isset($config2w_m['cf_use_common_logo'])) {
    $check_count++;
    echo $g5['config2w_m_table']."에 cf_use_common_logo를 추가 (이외 2 개 포함) ";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_m_table']}`
                    ADD `cf_use_common_logo` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_main_image`,
                    ADD `cf_use_common_menu` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_use_common_logo`,
                    ADD `cf_use_common_addr` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_use_common_menu` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

/*
$sql = " SHOW COLUMNS FROM `{$g5['config2w_table']}` LIKE 'cf_site_name' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_table']."에 cf_site_name을 추가 (이외 8 개 포함) ";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_table']}`
                    ADD `cf_site_name` varchar(255) NOT NULL default '' AFTER `cf_header_logo`,
                    ADD `cf_zip` varchar(255) NOT NULL default '' AFTER `cf_site_addr`,
                    ADD `cf_tel` varchar(255) NOT NULL default '' AFTER `cf_zip`,
                    ADD `cf_fax` varchar(255) NOT NULL default '' AFTER `cf_tel`,
                    ADD `cf_email` varchar(255) NOT NULL default '' AFTER `cf_fax`,
                    ADD `cf_site_owner` varchar(255) NOT NULL default '' AFTER `cf_email`,
                    ADD `cf_biz_num` varchar(255) NOT NULL default '' AFTER `cf_site_owner`,
                    ADD `cf_ebiz_num` varchar(255) NOT NULL default '' AFTER `cf_biz_num`,
                    ADD `cf_info_man` varchar(255) NOT NULL default '' AFTER `cf_ebiz_num`,
                    ADD `cf_info_email` varchar(255) NOT NULL default '' AFTER `cf_info_man` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}
*/

/// config2w_def 테이블과 그 안에 cf_templete 값이 존재할 경우
/// 기존 config2w 테이블의 id, cf_templete 삭제
$sql1 = " SHOW COLUMNS FROM `{$g5['config2w_table']}` LIKE 'id' ";
$row1 = sql_fetch($sql1);
$sql2 = " SHOW COLUMNS FROM `{$g5['config2w_table']}` LIKE 'cf_templete' ";
$row2 = sql_fetch($sql2);
if((isset($row1['Field']) or isset($row2['Field'])) && isset($config2w_def['cf_templete']))
{
    $check_count++;
    echo $g5['config2w_table']."에 id 및 cf_templete을 삭제 ";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_table']}`
                    DROP PRIMARY KEY,
                    DROP INDEX `cf_id`,
                    ADD PRIMARY KEY (`cf_id`),
                    DROP `id`,
                    DROP `cf_templete` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 삭제되었습니다</font>";
    }
    echo "<br>";
}

/// config2w_m_def 테이블과 그 안에 cf_templete 값이 존재할 경우
/// 기존 config2w_m 테이블의 id, cf_templete 삭제
$sql1 = " SHOW COLUMNS FROM `{$g5['config2w_m_table']}` LIKE 'id' ";
$row1 = sql_fetch($sql1);
$sql2 = " SHOW COLUMNS FROM `{$g5['config2w_m_table']}` LIKE 'cf_templete' ";
$row2 = sql_fetch($sql2);
if((isset($row1['Field']) or isset($row2['Field'])) && isset($config2w_m_def['cf_templete']))
{
    $check_count++;
    echo $g5['config2w_m_table']."에 id 및 cf_templete을 삭제 ";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_m_table']}`
                    DROP PRIMARY KEY,
                    DROP INDEX `cf_id`,
                    ADD PRIMARY KEY (`cf_id`),
                    DROP `id`,
                    DROP `cf_templete` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 삭제되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_config_table']}` LIKE 'cf_co_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_config_table']."에 cf_co_skin을 추가<br>";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_config_table']}`
                    ADD `cf_co_skin` varchar(255) NOT NULL default '' AFTER `cf_qa_skin` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_m_config_table']}` LIKE 'cf_mobile_co_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_m_config_table']."에 cf_mobile_co_skin을 추가<br>";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_m_config_table']}`
                    ADD `cf_mobile_co_skin` varchar(255) NOT NULL default '' AFTER `cf_mobile_qa_skin` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_config_table']}` LIKE 'cf_contents_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_config_table']."에 cf_contents_skin을 추가<br>";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_config_table']}`
                    ADD `cf_contents_skin` varchar(255) NOT NULL default '' AFTER `cf_shop_skin` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_m_config_table']}` LIKE 'cf_mobile_contents_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_m_config_table']."에 cf_mobile_contents_skin을 추가<br>";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_m_config_table']}`
                    ADD `cf_mobile_contents_skin` varchar(255) NOT NULL default '' AFTER `cf_mobile_shop_skin` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_def_table']}` LIKE 'lang' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_def_table']."에 lang, lang_list 추가<br>";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_def_table']}`
                    ADD `lang` varchar(30) NOT NULL default '' AFTER `cf_templete`,
                    ADD `lang_list` text NOT NULL ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 모바일 초기화면 이미지 줄 수 필드 추가
if(!isset($default['de_mobile_type1_list_row'])) {
    $check_count++;
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_mobile_type1_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type1_list_mod`,
                    ADD `de_mobile_type2_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type2_list_mod`,
                    ADD `de_mobile_type3_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type3_list_mod`,
                    ADD `de_mobile_type4_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type4_list_mod`,
                    ADD `de_mobile_type5_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type5_list_mod` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 모바일 관련상품 이미지 줄 수 필드 추가
if(!isset($default['de_mobile_rel_list_mod'])) {
    $check_count++;
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_mobile_rel_list_mod` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_rel_list_skin` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 모바일 검색상품 이미지 줄 수 필드 추가
if(!isset($default['de_mobile_search_list_row'])) {
    $check_count++;
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_mobile_search_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_search_list_mod` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 모바일 상품 출력줄수 필드 추가
if(!sql_query(" select ca_mobile_list_row from {$g5['g5_shop_category_table']} limit 1 ", false)) {
    $check_count++;
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}`
                    ADD `ca_mobile_list_row` int(11) NOT NULL DEFAULT '0' AFTER `ca_mobile_list_mod` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

// 접속기기 필드 추가
if(!sql_query(" select bn_device from {$g5['g5_shop_banner_table']} limit 0, 1 ")) {
    $check_count++;
    $res = sql_query(" ALTER TABLE `{$g5['g5_shop_banner_table']}`
                    ADD `bn_device` varchar(10) not null default '' AFTER `bn_url` ", true);
    if($res) {
        sql_query(" update {$g5['g5_shop_banner_table']} set bn_device = 'pc' ", true);
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_m_def_table']}` LIKE 'cf_mobile_templete' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_m_def_table']."에 cf_mobile_templete 추가<br>";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_m_def_table']}`
                    ADD `cf_mobile_templete` varchar(30) NOT NULL default 'basic' ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if(!isset($config['cf_theme'])) {
    $check_count++;
    echo $g5['config_table']."에 cf_theme을 추가 (이외 1 개 포함) ";
    $res = sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_theme` varchar(255) NOT NULL DEFAULT '' AFTER `cf_title`,
                    ADD `cf_sms_type` varchar(10) NOT NULL DEFAULT '' AFTER `cf_sms_use` ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if(isset($config['cf_include_index'])) {
    $check_count++;
    echo $g5['config_table']."에서 cf_include_index를 삭제 (이외 2 개 포함)<br>";
    $res = sql_query(" ALTER TABLE `{$g5['config_table']}`
                    DROP cf_include_index,
                    DROP cf_include_head,
                    DROP cf_include_tail ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if(!isset($config2w['cf_menu'])) {
    $check_count++;
    echo $g5['config2w_table']."에 cf_menu를 추가 ";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_table']}`
                    ADD `cf_menu` varchar(255) NOT NULL default 'basic' after cf_id ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";

    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='basic' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='basic' WHERE cf_id like 'basic%' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='basic' WHERE cf_id like 'g4_basic%' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='shop_basic' WHERE cf_id like 'shop_basic%' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='shop_c_basic' WHERE cf_id like 'shop_c_basic%' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='r_boot_basic' WHERE cf_id like 'r_boot%' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='r_shop_boot_basic' WHERE cf_id like 'r_shop_boot%' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='basic' WHERE cf_id like 'theme_%' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='contents_basic' WHERE cf_id like 'theme_contents%pro' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='shop_basic' WHERE cf_id like 'theme_shop%pro' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='basic' WHERE cf_id like 't_basic%' ", true);
    sql_query(" UPDATE `{$g5['config2w_table']}` SET cf_menu='shop_basic' WHERE cf_id like 't_shop_basic%' ", true);
}

if(isset($config2w_m['cf_menu'])) {
    $check_count++;
    echo $g5['config2w_m_table']."의 cf_menu를 cf_menu_style로 변경 ";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_m_table']}`
                    CHANGE `cf_menu` `cf_menu_style` varchar(30) NOT NULL default 'list' ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 변경되었습니다</font>";
    }
    echo "<br>";
}

// config2w_menu 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_menu_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_menu_table']." 생성 ";
    $res = sql_query(" CREATE TABLE `{$g5['config2w_menu_table']}` (
    `cf_menu` varchar(255) NOT NULL default '',
    `cf_menu_name_0` text NOT NULL,
    `cf_menu_name_1` text NOT NULL,
    `cf_menu_name_2` text NOT NULL,
    `cf_menu_name_3` text NOT NULL,
    `cf_menu_name_4` text NOT NULL,
    `cf_menu_name_5` text NOT NULL,
    `cf_menu_name_6` text NOT NULL,
    `cf_menu_name_7` text NOT NULL,
    `cf_menu_name_8` text NOT NULL,
    `cf_menu_name_9` text NOT NULL,
    `cf_menu_leng_0` int(11) NOT NULL default '0',
    `cf_menu_leng_1` int(11) NOT NULL default '0',
    `cf_menu_leng_2` int(11) NOT NULL default '0',
    `cf_menu_leng_3` int(11) NOT NULL default '0',
    `cf_menu_leng_4` int(11) NOT NULL default '0',
    `cf_menu_leng_5` int(11) NOT NULL default '0',
    `cf_menu_leng_6` int(11) NOT NULL default '0',
    `cf_menu_leng_7` int(11) NOT NULL default '0',
    `cf_menu_leng_8` int(11) NOT NULL default '0',
    `cf_menu_leng_9` int(11) NOT NULL default '0',
    `cf_menu_link_0` text NOT NULL,
    `cf_menu_link_1` text NOT NULL,
    `cf_menu_link_2` text NOT NULL,
    `cf_menu_link_3` text NOT NULL,
    `cf_menu_link_4` text NOT NULL,
    `cf_menu_link_5` text NOT NULL,
    `cf_menu_link_6` text NOT NULL,
    `cf_menu_link_7` text NOT NULL,
    `cf_menu_link_8` text NOT NULL,
    `cf_menu_link_9` text NOT NULL,
    `cf_submenu_name_0_0` text NOT NULL,
    `cf_submenu_name_0_1` text NOT NULL,
    `cf_submenu_name_0_2` text NOT NULL,
    `cf_submenu_name_0_3` text NOT NULL,
    `cf_submenu_name_0_4` text NOT NULL,
    `cf_submenu_name_0_5` text NOT NULL,
    `cf_submenu_name_0_6` text NOT NULL,
    `cf_submenu_name_0_7` text NOT NULL,
    `cf_submenu_name_0_8` text NOT NULL,
    `cf_submenu_name_0_9` text NOT NULL,
    `cf_submenu_link_0_0` text NOT NULL,
    `cf_submenu_link_0_1` text NOT NULL,
    `cf_submenu_link_0_2` text NOT NULL,
    `cf_submenu_link_0_3` text NOT NULL,
    `cf_submenu_link_0_4` text NOT NULL,
    `cf_submenu_link_0_5` text NOT NULL,
    `cf_submenu_link_0_6` text NOT NULL,
    `cf_submenu_link_0_7` text NOT NULL,
    `cf_submenu_link_0_8` text NOT NULL,
    `cf_submenu_link_0_9` text NOT NULL,
    `cf_submenu_name_1_0` text NOT NULL,
    `cf_submenu_name_1_1` text NOT NULL,
    `cf_submenu_name_1_2` text NOT NULL,
    `cf_submenu_name_1_3` text NOT NULL,
    `cf_submenu_name_1_4` text NOT NULL,
    `cf_submenu_name_1_5` text NOT NULL,
    `cf_submenu_name_1_6` text NOT NULL,
    `cf_submenu_name_1_7` text NOT NULL,
    `cf_submenu_name_1_8` text NOT NULL,
    `cf_submenu_name_1_9` text NOT NULL,
    `cf_submenu_link_1_0` text NOT NULL,
    `cf_submenu_link_1_1` text NOT NULL,
    `cf_submenu_link_1_2` text NOT NULL,
    `cf_submenu_link_1_3` text NOT NULL,
    `cf_submenu_link_1_4` text NOT NULL,
    `cf_submenu_link_1_5` text NOT NULL,
    `cf_submenu_link_1_6` text NOT NULL,
    `cf_submenu_link_1_7` text NOT NULL,
    `cf_submenu_link_1_8` text NOT NULL,
    `cf_submenu_link_1_9` text NOT NULL,
    `cf_submenu_name_2_0` text NOT NULL,
    `cf_submenu_name_2_1` text NOT NULL,
    `cf_submenu_name_2_2` text NOT NULL,
    `cf_submenu_name_2_3` text NOT NULL,
    `cf_submenu_name_2_4` text NOT NULL,
    `cf_submenu_name_2_5` text NOT NULL,
    `cf_submenu_name_2_6` text NOT NULL,
    `cf_submenu_name_2_7` text NOT NULL,
    `cf_submenu_name_2_8` text NOT NULL,
    `cf_submenu_name_2_9` text NOT NULL,
    `cf_submenu_link_2_0` text NOT NULL,
    `cf_submenu_link_2_1` text NOT NULL,
    `cf_submenu_link_2_2` text NOT NULL,
    `cf_submenu_link_2_3` text NOT NULL,
    `cf_submenu_link_2_4` text NOT NULL,
    `cf_submenu_link_2_5` text NOT NULL,
    `cf_submenu_link_2_6` text NOT NULL,
    `cf_submenu_link_2_7` text NOT NULL,
    `cf_submenu_link_2_8` text NOT NULL,
    `cf_submenu_link_2_9` text NOT NULL,
    `cf_submenu_name_3_0` text NOT NULL,
    `cf_submenu_name_3_1` text NOT NULL,
    `cf_submenu_name_3_2` text NOT NULL,
    `cf_submenu_name_3_3` text NOT NULL,
    `cf_submenu_name_3_4` text NOT NULL,
    `cf_submenu_name_3_5` text NOT NULL,
    `cf_submenu_name_3_6` text NOT NULL,
    `cf_submenu_name_3_7` text NOT NULL,
    `cf_submenu_name_3_8` text NOT NULL,
    `cf_submenu_name_3_9` text NOT NULL,
    `cf_submenu_link_3_0` text NOT NULL,
    `cf_submenu_link_3_1` text NOT NULL,
    `cf_submenu_link_3_2` text NOT NULL,
    `cf_submenu_link_3_3` text NOT NULL,
    `cf_submenu_link_3_4` text NOT NULL,
    `cf_submenu_link_3_5` text NOT NULL,
    `cf_submenu_link_3_6` text NOT NULL,
    `cf_submenu_link_3_7` text NOT NULL,
    `cf_submenu_link_3_8` text NOT NULL,
    `cf_submenu_link_3_9` text NOT NULL,
    `cf_submenu_name_4_0` text NOT NULL,
    `cf_submenu_name_4_1` text NOT NULL,
    `cf_submenu_name_4_2` text NOT NULL,
    `cf_submenu_name_4_3` text NOT NULL,
    `cf_submenu_name_4_4` text NOT NULL,
    `cf_submenu_name_4_5` text NOT NULL,
    `cf_submenu_name_4_6` text NOT NULL,
    `cf_submenu_name_4_7` text NOT NULL,
    `cf_submenu_name_4_8` text NOT NULL,
    `cf_submenu_name_4_9` text NOT NULL,
    `cf_submenu_link_4_0` text NOT NULL,
    `cf_submenu_link_4_1` text NOT NULL,
    `cf_submenu_link_4_2` text NOT NULL,
    `cf_submenu_link_4_3` text NOT NULL,
    `cf_submenu_link_4_4` text NOT NULL,
    `cf_submenu_link_4_5` text NOT NULL,
    `cf_submenu_link_4_6` text NOT NULL,
    `cf_submenu_link_4_7` text NOT NULL,
    `cf_submenu_link_4_8` text NOT NULL,
    `cf_submenu_link_4_9` text NOT NULL,
    `cf_submenu_name_5_0` text NOT NULL,
    `cf_submenu_name_5_1` text NOT NULL,
    `cf_submenu_name_5_2` text NOT NULL,
    `cf_submenu_name_5_3` text NOT NULL,
    `cf_submenu_name_5_4` text NOT NULL,
    `cf_submenu_name_5_5` text NOT NULL,
    `cf_submenu_name_5_6` text NOT NULL,
    `cf_submenu_name_5_7` text NOT NULL,
    `cf_submenu_name_5_8` text NOT NULL,
    `cf_submenu_name_5_9` text NOT NULL,
    `cf_submenu_link_5_0` text NOT NULL,
    `cf_submenu_link_5_1` text NOT NULL,
    `cf_submenu_link_5_2` text NOT NULL,
    `cf_submenu_link_5_3` text NOT NULL,
    `cf_submenu_link_5_4` text NOT NULL,
    `cf_submenu_link_5_5` text NOT NULL,
    `cf_submenu_link_5_6` text NOT NULL,
    `cf_submenu_link_5_7` text NOT NULL,
    `cf_submenu_link_5_8` text NOT NULL,
    `cf_submenu_link_5_9` text NOT NULL,
    `cf_submenu_name_6_0` text NOT NULL,
    `cf_submenu_name_6_1` text NOT NULL,
    `cf_submenu_name_6_2` text NOT NULL,
    `cf_submenu_name_6_3` text NOT NULL,
    `cf_submenu_name_6_4` text NOT NULL,
    `cf_submenu_name_6_5` text NOT NULL,
    `cf_submenu_name_6_6` text NOT NULL,
    `cf_submenu_name_6_7` text NOT NULL,
    `cf_submenu_name_6_8` text NOT NULL,
    `cf_submenu_name_6_9` text NOT NULL,
    `cf_submenu_link_6_0` text NOT NULL,
    `cf_submenu_link_6_1` text NOT NULL,
    `cf_submenu_link_6_2` text NOT NULL,
    `cf_submenu_link_6_3` text NOT NULL,
    `cf_submenu_link_6_4` text NOT NULL,
    `cf_submenu_link_6_5` text NOT NULL,
    `cf_submenu_link_6_6` text NOT NULL,
    `cf_submenu_link_6_7` text NOT NULL,
    `cf_submenu_link_6_8` text NOT NULL,
    `cf_submenu_link_6_9` text NOT NULL,
    `cf_submenu_name_7_0` text NOT NULL,
    `cf_submenu_name_7_1` text NOT NULL,
    `cf_submenu_name_7_2` text NOT NULL,
    `cf_submenu_name_7_3` text NOT NULL,
    `cf_submenu_name_7_4` text NOT NULL,
    `cf_submenu_name_7_5` text NOT NULL,
    `cf_submenu_name_7_6` text NOT NULL,
    `cf_submenu_name_7_7` text NOT NULL,
    `cf_submenu_name_7_8` text NOT NULL,
    `cf_submenu_name_7_9` text NOT NULL,
    `cf_submenu_link_7_0` text NOT NULL,
    `cf_submenu_link_7_1` text NOT NULL,
    `cf_submenu_link_7_2` text NOT NULL,
    `cf_submenu_link_7_3` text NOT NULL,
    `cf_submenu_link_7_4` text NOT NULL,
    `cf_submenu_link_7_5` text NOT NULL,
    `cf_submenu_link_7_6` text NOT NULL,
    `cf_submenu_link_7_7` text NOT NULL,
    `cf_submenu_link_7_8` text NOT NULL,
    `cf_submenu_link_7_9` text NOT NULL,
    `cf_submenu_name_8_0` text NOT NULL,
    `cf_submenu_name_8_1` text NOT NULL,
    `cf_submenu_name_8_2` text NOT NULL,
    `cf_submenu_name_8_3` text NOT NULL,
    `cf_submenu_name_8_4` text NOT NULL,
    `cf_submenu_name_8_5` text NOT NULL,
    `cf_submenu_name_8_6` text NOT NULL,
    `cf_submenu_name_8_7` text NOT NULL,
    `cf_submenu_name_8_8` text NOT NULL,
    `cf_submenu_name_8_9` text NOT NULL,
    `cf_submenu_link_8_0` text NOT NULL,
    `cf_submenu_link_8_1` text NOT NULL,
    `cf_submenu_link_8_2` text NOT NULL,
    `cf_submenu_link_8_3` text NOT NULL,
    `cf_submenu_link_8_4` text NOT NULL,
    `cf_submenu_link_8_5` text NOT NULL,
    `cf_submenu_link_8_6` text NOT NULL,
    `cf_submenu_link_8_7` text NOT NULL,
    `cf_submenu_link_8_8` text NOT NULL,
    `cf_submenu_link_8_9` text NOT NULL,
    `cf_submenu_name_9_0` text NOT NULL,
    `cf_submenu_name_9_1` text NOT NULL,
    `cf_submenu_name_9_2` text NOT NULL,
    `cf_submenu_name_9_3` text NOT NULL,
    `cf_submenu_name_9_4` text NOT NULL,
    `cf_submenu_name_9_5` text NOT NULL,
    `cf_submenu_name_9_6` text NOT NULL,
    `cf_submenu_name_9_7` text NOT NULL,
    `cf_submenu_name_9_8` text NOT NULL,
    `cf_submenu_name_9_9` text NOT NULL,
    `cf_submenu_link_9_0` text NOT NULL,
    `cf_submenu_link_9_1` text NOT NULL,
    `cf_submenu_link_9_2` text NOT NULL,
    `cf_submenu_link_9_3` text NOT NULL,
    `cf_submenu_link_9_4` text NOT NULL,
    `cf_submenu_link_9_5` text NOT NULL,
    `cf_submenu_link_9_6` text NOT NULL,
    `cf_submenu_link_9_7` text NOT NULL,
    `cf_submenu_link_9_8` text NOT NULL,
    `cf_submenu_link_9_9` text NOT NULL,
    PRIMARY KEY  (`cf_menu`) ) ", false);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 생성되었습니다</font>";
    }
    echo "<br>";

    echo $g5['config2w_table']."의 메뉴 정보를 ".$g5['config2w_menu_table']."로 복사 ";
    $res = sql_query(" INSERT INTO `{$g5['config2w_menu_table']}` SELECT `cf_id`, `cf_menu_name_0`, `cf_menu_name_1`, `cf_menu_name_2`, `cf_menu_name_3`, `cf_menu_name_4`, `cf_menu_name_5`, `cf_menu_name_6`, `cf_menu_name_7`, `cf_menu_name_8`, `cf_menu_name_9`, `cf_menu_leng_0`, `cf_menu_leng_1`, `cf_menu_leng_2`, `cf_menu_leng_3`, `cf_menu_leng_4`, `cf_menu_leng_5`, `cf_menu_leng_6`, `cf_menu_leng_7`, `cf_menu_leng_8`, `cf_menu_leng_9`, `cf_menu_link_0`, `cf_menu_link_1`, `cf_menu_link_2`, `cf_menu_link_3`, `cf_menu_link_4`, `cf_menu_link_5`, `cf_menu_link_6`, `cf_menu_link_7`, `cf_menu_link_8`, `cf_menu_link_9`, `cf_submenu_name_0_0`, `cf_submenu_name_0_1`, `cf_submenu_name_0_2`, `cf_submenu_name_0_3`, `cf_submenu_name_0_4`, `cf_submenu_name_0_5`, `cf_submenu_name_0_6`, `cf_submenu_name_0_7`, `cf_submenu_name_0_8`, `cf_submenu_name_0_9`, `cf_submenu_link_0_0`, `cf_submenu_link_0_1`, `cf_submenu_link_0_2`, `cf_submenu_link_0_3`, `cf_submenu_link_0_4`, `cf_submenu_link_0_5`, `cf_submenu_link_0_6`, `cf_submenu_link_0_7`, `cf_submenu_link_0_8`, `cf_submenu_link_0_9`, `cf_submenu_name_1_0`, `cf_submenu_name_1_1`, `cf_submenu_name_1_2`, `cf_submenu_name_1_3`, `cf_submenu_name_1_4`, `cf_submenu_name_1_5`, `cf_submenu_name_1_6`, `cf_submenu_name_1_7`, `cf_submenu_name_1_8`, `cf_submenu_name_1_9`, `cf_submenu_link_1_0`, `cf_submenu_link_1_1`, `cf_submenu_link_1_2`, `cf_submenu_link_1_3`, `cf_submenu_link_1_4`, `cf_submenu_link_1_5`, `cf_submenu_link_1_6`, `cf_submenu_link_1_7`, `cf_submenu_link_1_8`, `cf_submenu_link_1_9`, `cf_submenu_name_2_0`, `cf_submenu_name_2_1`, `cf_submenu_name_2_2`, `cf_submenu_name_2_3`, `cf_submenu_name_2_4`, `cf_submenu_name_2_5`, `cf_submenu_name_2_6`, `cf_submenu_name_2_7`, `cf_submenu_name_2_8`, `cf_submenu_name_2_9`, `cf_submenu_link_2_0`, `cf_submenu_link_2_1`, `cf_submenu_link_2_2`, `cf_submenu_link_2_3`, `cf_submenu_link_2_4`, `cf_submenu_link_2_5`, `cf_submenu_link_2_6`, `cf_submenu_link_2_7`, `cf_submenu_link_2_8`, `cf_submenu_link_2_9`, `cf_submenu_name_3_0`, `cf_submenu_name_3_1`, `cf_submenu_name_3_2`, `cf_submenu_name_3_3`, `cf_submenu_name_3_4`, `cf_submenu_name_3_5`, `cf_submenu_name_3_6`, `cf_submenu_name_3_7`, `cf_submenu_name_3_8`, `cf_submenu_name_3_9`, `cf_submenu_link_3_0`, `cf_submenu_link_3_1`, `cf_submenu_link_3_2`, `cf_submenu_link_3_3`, `cf_submenu_link_3_4`, `cf_submenu_link_3_5`, `cf_submenu_link_3_6`, `cf_submenu_link_3_7`, `cf_submenu_link_3_8`, `cf_submenu_link_3_9`, `cf_submenu_name_4_0`, `cf_submenu_name_4_1`, `cf_submenu_name_4_2`, `cf_submenu_name_4_3`, `cf_submenu_name_4_4`, `cf_submenu_name_4_5`, `cf_submenu_name_4_6`, `cf_submenu_name_4_7`, `cf_submenu_name_4_8`, `cf_submenu_name_4_9`, `cf_submenu_link_4_0`, `cf_submenu_link_4_1`, `cf_submenu_link_4_2`, `cf_submenu_link_4_3`, `cf_submenu_link_4_4`, `cf_submenu_link_4_5`, `cf_submenu_link_4_6`, `cf_submenu_link_4_7`, `cf_submenu_link_4_8`, `cf_submenu_link_4_9`, `cf_submenu_name_5_0`, `cf_submenu_name_5_1`, `cf_submenu_name_5_2`, 
`cf_submenu_name_5_3`, `cf_submenu_name_5_4`, `cf_submenu_name_5_5`, `cf_submenu_name_5_6`, `cf_submenu_name_5_7`, `cf_submenu_name_5_8`, `cf_submenu_name_5_9`, `cf_submenu_link_5_0`, `cf_submenu_link_5_1`, `cf_submenu_link_5_2`, `cf_submenu_link_5_3`, `cf_submenu_link_5_4`, `cf_submenu_link_5_5`, `cf_submenu_link_5_6`, `cf_submenu_link_5_7`, `cf_submenu_link_5_8`, `cf_submenu_link_5_9`, `cf_submenu_name_6_0`, `cf_submenu_name_6_1`, `cf_submenu_name_6_2`, `cf_submenu_name_6_3`, `cf_submenu_name_6_4`, `cf_submenu_name_6_5`, `cf_submenu_name_6_6`, `cf_submenu_name_6_7`, `cf_submenu_name_6_8`, `cf_submenu_name_6_9`, `cf_submenu_link_6_0`, `cf_submenu_link_6_1`, `cf_submenu_link_6_2`, `cf_submenu_link_6_3`, `cf_submenu_link_6_4`, `cf_submenu_link_6_5`, `cf_submenu_link_6_6`, `cf_submenu_link_6_7`, `cf_submenu_link_6_8`, `cf_submenu_link_6_9`, `cf_submenu_name_7_0`, `cf_submenu_name_7_1`, `cf_submenu_name_7_2`, `cf_submenu_name_7_3`, `cf_submenu_name_7_4`, `cf_submenu_name_7_5`, `cf_submenu_name_7_6`, `cf_submenu_name_7_7`, `cf_submenu_name_7_8`, `cf_submenu_name_7_9`, `cf_submenu_link_7_0`, `cf_submenu_link_7_1`, `cf_submenu_link_7_2`, `cf_submenu_link_7_3`, `cf_submenu_link_7_4`, `cf_submenu_link_7_5`, `cf_submenu_link_7_6`, `cf_submenu_link_7_7`, `cf_submenu_link_7_8`, `cf_submenu_link_7_9`, `cf_submenu_name_8_0`, `cf_submenu_name_8_1`, `cf_submenu_name_8_2`, `cf_submenu_name_8_3`, `cf_submenu_name_8_4`, `cf_submenu_name_8_5`, `cf_submenu_name_8_6`, `cf_submenu_name_8_7`, `cf_submenu_name_8_8`, `cf_submenu_name_8_9`, `cf_submenu_link_8_0`, `cf_submenu_link_8_1`, `cf_submenu_link_8_2`, `cf_submenu_link_8_3`, `cf_submenu_link_8_4`, `cf_submenu_link_8_5`, `cf_submenu_link_8_6`, `cf_submenu_link_8_7`, `cf_submenu_link_8_8`, `cf_submenu_link_8_9`, `cf_submenu_name_9_0`, `cf_submenu_name_9_1`, `cf_submenu_name_9_2`, `cf_submenu_name_9_3`, `cf_submenu_name_9_4`, `cf_submenu_name_9_5`, `cf_submenu_name_9_6`, `cf_submenu_name_9_7`, `cf_submenu_name_9_8`, `cf_submenu_name_9_9`, `cf_submenu_link_9_0`, `cf_submenu_link_9_1`, `cf_submenu_link_9_2`, `cf_submenu_link_9_3`, `cf_submenu_link_9_4`, `cf_submenu_link_9_5`, `cf_submenu_link_9_6`, `cf_submenu_link_9_7`, `cf_submenu_link_9_8`, `cf_submenu_link_9_9` FROM {$g5['config2w_table']} ", false);
    if($res) {
        echo "<font color=#ff0000> ---> 복사되었습니다</font>";
    }
    echo "<br>";

    echo "(".$g5['config2w_table']."에서 메뉴 필드들 삭제";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_table']}` 
    DROP `cf_menu_name_0`,
    DROP `cf_menu_name_1`,
    DROP `cf_menu_name_2`,
    DROP `cf_menu_name_3`,
    DROP `cf_menu_name_4`,
    DROP `cf_menu_name_5`,
    DROP `cf_menu_name_6`,
    DROP `cf_menu_name_7`,
    DROP `cf_menu_name_8`,
    DROP `cf_menu_name_9`,
    DROP `cf_menu_leng_0`,
    DROP `cf_menu_leng_1`,
    DROP `cf_menu_leng_2`,
    DROP `cf_menu_leng_3`,
    DROP `cf_menu_leng_4`,
    DROP `cf_menu_leng_5`,
    DROP `cf_menu_leng_6`,
    DROP `cf_menu_leng_7`,
    DROP `cf_menu_leng_8`,
    DROP `cf_menu_leng_9`,
    DROP `cf_menu_link_0`,
    DROP `cf_menu_link_1`,
    DROP `cf_menu_link_2`,
    DROP `cf_menu_link_3`,
    DROP `cf_menu_link_4`,
    DROP `cf_menu_link_5`,
    DROP `cf_menu_link_6`,
    DROP `cf_menu_link_7`,
    DROP `cf_menu_link_8`,
    DROP `cf_menu_link_9`,
    DROP `cf_submenu_name_0_0`,
    DROP `cf_submenu_name_0_1`,
    DROP `cf_submenu_name_0_2`,
    DROP `cf_submenu_name_0_3`,
    DROP `cf_submenu_name_0_4`,
    DROP `cf_submenu_name_0_5`,
    DROP `cf_submenu_name_0_6`,
    DROP `cf_submenu_name_0_7`,
    DROP `cf_submenu_name_0_8`,
    DROP `cf_submenu_name_0_9`,
    DROP `cf_submenu_link_0_0`,
    DROP `cf_submenu_link_0_1`,
    DROP `cf_submenu_link_0_2`,
    DROP `cf_submenu_link_0_3`,
    DROP `cf_submenu_link_0_4`,
    DROP `cf_submenu_link_0_5`,
    DROP `cf_submenu_link_0_6`,
    DROP `cf_submenu_link_0_7`,
    DROP `cf_submenu_link_0_8`,
    DROP `cf_submenu_link_0_9`,
    DROP `cf_submenu_name_1_0`,
    DROP `cf_submenu_name_1_1`,
    DROP `cf_submenu_name_1_2`,
    DROP `cf_submenu_name_1_3`,
    DROP `cf_submenu_name_1_4`,
    DROP `cf_submenu_name_1_5`,
    DROP `cf_submenu_name_1_6`,
    DROP `cf_submenu_name_1_7`,
    DROP `cf_submenu_name_1_8`,
    DROP `cf_submenu_name_1_9`,
    DROP `cf_submenu_link_1_0`,
    DROP `cf_submenu_link_1_1`,
    DROP `cf_submenu_link_1_2`,
    DROP `cf_submenu_link_1_3`,
    DROP `cf_submenu_link_1_4`,
    DROP `cf_submenu_link_1_5`,
    DROP `cf_submenu_link_1_6`,
    DROP `cf_submenu_link_1_7`,
    DROP `cf_submenu_link_1_8`,
    DROP `cf_submenu_link_1_9`,
    DROP `cf_submenu_name_2_0`,
    DROP `cf_submenu_name_2_1`,
    DROP `cf_submenu_name_2_2`,
    DROP `cf_submenu_name_2_3`,
    DROP `cf_submenu_name_2_4`,
    DROP `cf_submenu_name_2_5`,
    DROP `cf_submenu_name_2_6`,
    DROP `cf_submenu_name_2_7`,
    DROP `cf_submenu_name_2_8`,
    DROP `cf_submenu_name_2_9`,
    DROP `cf_submenu_link_2_0`,
    DROP `cf_submenu_link_2_1`,
    DROP `cf_submenu_link_2_2`,
    DROP `cf_submenu_link_2_3`,
    DROP `cf_submenu_link_2_4`,
    DROP `cf_submenu_link_2_5`,
    DROP `cf_submenu_link_2_6`,
    DROP `cf_submenu_link_2_7`,
    DROP `cf_submenu_link_2_8`,
    DROP `cf_submenu_link_2_9`,
    DROP `cf_submenu_name_3_0`,
    DROP `cf_submenu_name_3_1`,
    DROP `cf_submenu_name_3_2`,
    DROP `cf_submenu_name_3_3`,
    DROP `cf_submenu_name_3_4`,
    DROP `cf_submenu_name_3_5`,
    DROP `cf_submenu_name_3_6`,
    DROP `cf_submenu_name_3_7`,
    DROP `cf_submenu_name_3_8`,
    DROP `cf_submenu_name_3_9`,
    DROP `cf_submenu_link_3_0`,
    DROP `cf_submenu_link_3_1`,
    DROP `cf_submenu_link_3_2`,
    DROP `cf_submenu_link_3_3`,
    DROP `cf_submenu_link_3_4`,
    DROP `cf_submenu_link_3_5`,
    DROP `cf_submenu_link_3_6`,
    DROP `cf_submenu_link_3_7`,
    DROP `cf_submenu_link_3_8`,
    DROP `cf_submenu_link_3_9`,
    DROP `cf_submenu_name_4_0`,
    DROP `cf_submenu_name_4_1`,
    DROP `cf_submenu_name_4_2`,
    DROP `cf_submenu_name_4_3`,
    DROP `cf_submenu_name_4_4`,
    DROP `cf_submenu_name_4_5`,
    DROP `cf_submenu_name_4_6`,
    DROP `cf_submenu_name_4_7`,
    DROP `cf_submenu_name_4_8`,
    DROP `cf_submenu_name_4_9`,
    DROP `cf_submenu_link_4_0`,
    DROP `cf_submenu_link_4_1`,
    DROP `cf_submenu_link_4_2`,
    DROP `cf_submenu_link_4_3`,
    DROP `cf_submenu_link_4_4`,
    DROP `cf_submenu_link_4_5`,
    DROP `cf_submenu_link_4_6`,
    DROP `cf_submenu_link_4_7`,
    DROP `cf_submenu_link_4_8`,
    DROP `cf_submenu_link_4_9`,
    DROP `cf_submenu_name_5_0`,
    DROP `cf_submenu_name_5_1`,
    DROP `cf_submenu_name_5_2`,
    DROP `cf_submenu_name_5_3`,
    DROP `cf_submenu_name_5_4`,
    DROP `cf_submenu_name_5_5`,
    DROP `cf_submenu_name_5_6`,
    DROP `cf_submenu_name_5_7`,
    DROP `cf_submenu_name_5_8`,
    DROP `cf_submenu_name_5_9`,
    DROP `cf_submenu_link_5_0`,
    DROP `cf_submenu_link_5_1`,
    DROP `cf_submenu_link_5_2`,
    DROP `cf_submenu_link_5_3`,
    DROP `cf_submenu_link_5_4`,
    DROP `cf_submenu_link_5_5`,
    DROP `cf_submenu_link_5_6`,
    DROP `cf_submenu_link_5_7`,
    DROP `cf_submenu_link_5_8`,
    DROP `cf_submenu_link_5_9`,
    DROP `cf_submenu_name_6_0`,
    DROP `cf_submenu_name_6_1`,
    DROP `cf_submenu_name_6_2`,
    DROP `cf_submenu_name_6_3`,
    DROP `cf_submenu_name_6_4`,
    DROP `cf_submenu_name_6_5`,
    DROP `cf_submenu_name_6_6`,
    DROP `cf_submenu_name_6_7`,
    DROP `cf_submenu_name_6_8`,
    DROP `cf_submenu_name_6_9`,
    DROP `cf_submenu_link_6_0`,
    DROP `cf_submenu_link_6_1`,
    DROP `cf_submenu_link_6_2`,
    DROP `cf_submenu_link_6_3`,
    DROP `cf_submenu_link_6_4`,
    DROP `cf_submenu_link_6_5`,
    DROP `cf_submenu_link_6_6`,
    DROP `cf_submenu_link_6_7`,
    DROP `cf_submenu_link_6_8`,
    DROP `cf_submenu_link_6_9`,
    DROP `cf_submenu_name_7_0`,
    DROP `cf_submenu_name_7_1`,
    DROP `cf_submenu_name_7_2`,
    DROP `cf_submenu_name_7_3`,
    DROP `cf_submenu_name_7_4`,
    DROP `cf_submenu_name_7_5`,
    DROP `cf_submenu_name_7_6`,
    DROP `cf_submenu_name_7_7`,
    DROP `cf_submenu_name_7_8`,
    DROP `cf_submenu_name_7_9`,
    DROP `cf_submenu_link_7_0`,
    DROP `cf_submenu_link_7_1`,
    DROP `cf_submenu_link_7_2`,
    DROP `cf_submenu_link_7_3`,
    DROP `cf_submenu_link_7_4`,
    DROP `cf_submenu_link_7_5`,
    DROP `cf_submenu_link_7_6`,
    DROP `cf_submenu_link_7_7`,
    DROP `cf_submenu_link_7_8`,
    DROP `cf_submenu_link_7_9`,
    DROP `cf_submenu_name_8_0`,
    DROP `cf_submenu_name_8_1`,
    DROP `cf_submenu_name_8_2`,
    DROP `cf_submenu_name_8_3`,
    DROP `cf_submenu_name_8_4`,
    DROP `cf_submenu_name_8_5`,
    DROP `cf_submenu_name_8_6`,
    DROP `cf_submenu_name_8_7`,
    DROP `cf_submenu_name_8_8`,
    DROP `cf_submenu_name_8_9`,
    DROP `cf_submenu_link_8_0`,
    DROP `cf_submenu_link_8_1`,
    DROP `cf_submenu_link_8_2`,
    DROP `cf_submenu_link_8_3`,
    DROP `cf_submenu_link_8_4`,
    DROP `cf_submenu_link_8_5`,
    DROP `cf_submenu_link_8_6`,
    DROP `cf_submenu_link_8_7`,
    DROP `cf_submenu_link_8_8`,
    DROP `cf_submenu_link_8_9`,
    DROP `cf_submenu_name_9_0`,
    DROP `cf_submenu_name_9_1`,
    DROP `cf_submenu_name_9_2`,
    DROP `cf_submenu_name_9_3`,
    DROP `cf_submenu_name_9_4`,
    DROP `cf_submenu_name_9_5`,
    DROP `cf_submenu_name_9_6`,
    DROP `cf_submenu_name_9_7`,
    DROP `cf_submenu_name_9_8`,
    DROP `cf_submenu_name_9_9`,
    DROP `cf_submenu_link_9_0`,
    DROP `cf_submenu_link_9_1`,
    DROP `cf_submenu_link_9_2`,
    DROP `cf_submenu_link_9_3`,
    DROP `cf_submenu_link_9_4`,
    DROP `cf_submenu_link_9_5`,
    DROP `cf_submenu_link_9_6`,
    DROP `cf_submenu_link_9_7`,
    DROP `cf_submenu_link_9_8`,
    DROP `cf_submenu_link_9_9` ", false);
    if($res) {
        echo "<font color=#ff0000> ---> 삭제되었습니다</font>";
    }
    echo ")<br>";
}

if(!isset($config2w_def['cf_header_logo'])) {
    $check_count++;
    echo $g5['config2w_def_table']."에 cf_header_logo외 14 개 필드 추가 ";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_def_table']}`
    ADD `cf_header_logo` text NOT NULL AFTER `lang_list`,
    ADD `cf_site_name` varchar(255) NOT NULL default '',
    ADD `cf_site_addr` text NOT NULL,
    ADD `cf_zip` varchar(255) NOT NULL default '',
    ADD `cf_tel` varchar(255) NOT NULL default '',
    ADD `cf_fax` varchar(255) NOT NULL default '',
    ADD `cf_email` varchar(255) NOT NULL default '',
    ADD `cf_site_owner` varchar(255) NOT NULL default '',
    ADD `cf_biz_num` varchar(255) NOT NULL default '',
    ADD `cf_ebiz_num` varchar(255) NOT NULL default '',
    ADD `cf_info_man` varchar(255) NOT NULL default '',
    ADD `cf_info_email` varchar(255) NOT NULL default '',
    ADD `cf_copyright` text NOT NULL,
    ADD `cf_keywords` text NOT NULL,
    ADD `cf_description` text NOT NULL ", true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_explan' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $check_count++;
    echo $g5['board_table']."에 bo_explan 필드 추가 ";
    $sql = " ALTER TABLE `{$g5['board_table']}` ADD `bo_explan` text NOT NULL DEFAULT '' ";
    $res = sql_query($sql, true);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if (!isset($config2w_def['cf_contact_info'])) {
    $check_count++;
    echo $g5['config2w_def_table']."에 cf_contact_info외 4 개 필드 추가 ";
    $res = sql_query(" ALTER TABLE `{$g5['config2w_def_table']}` 
    ADD `cf_contact_info` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_description`,
    ADD `cf_google_map_pos` VARCHAR(255) NOT NULL DEFAULT '',
    ADD `cf_google_map_api_key` VARCHAR(255) NOT NULL DEFAULT '',
    ADD `cf_google_captcha_api_key` VARCHAR(255) NOT NULL DEFAULT '',
    ADD `cf_google_captcha_api_secret` VARCHAR(255) NOT NULL DEFAULT '' ", false);
    if($res) {
        $upgrade_count++;
        echo "<font color=#ff0000> ---> 추가되었습니다</font>";
    }
    echo "<br>";
}

if($upgrade_count == 0) {
    echo "업그레이드된 내용이 없습니다.";
} else {
    echo "<br><b>".$check_count." 항목 중 ".$upgrade_count." 항목이 업그레이드되었습니다.</b>";
}

echo "<br><br><br>";
echo "<b>[템플릿 데이타 추가]</b><br><br>";
include_once("./database_tmpl.inc.php");
?>
    </td>
</tr>
</table>
</section>

<?php
include_once ("../admin.tail.php");
?>
