<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(0) {

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_cut_name' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_cut_name` int(11) NOT NULL default '12'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_page_rows' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_page_rows` int(11) NOT NULL default '5'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_new_rows' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_new_rows` int(11) NOT NULL default '10'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_new_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_new_skin` varchar(255) NOT NULL default 'basic'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_search_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_search_skin` varchar(255) NOT NULL default 'basic'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_connect_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_connect_skin` varchar(255) NOT NULL default 'basic'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_member_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_member_skin` varchar(255) NOT NULL default 'basic'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_write_pages' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_write_pages` int(11) NOT NULL default '3'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_tel' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_tel` varchar(30) NOT NULL default ''
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_sms' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_sms` varchar(30) NOT NULL default ''
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['config_table']}` LIKE 'cf_m_test' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['config_table']}` add `cf_m_test` set('0','1') NOT NULL default '0'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['group_table']}` LIKE 'gr_m_show_menu' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['group_table']}` add `gr_m_show_menu` tinyint(4) NOT NULL default '0'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['group_table']}` LIKE 'gr_m_sort' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['group_table']}` add `gr_m_sort` int(11) NOT NULL default '0'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_table_width' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_table_width` int(11) NOT NULL default '100'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_subject_len' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_subject_len` int(11) NOT NULL default '50'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_page_rows' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_page_rows` int(11) NOT NULL default '10'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_image_width' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_image_width` int(11) NOT NULL default '300'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_skin` varchar(255) NOT NULL default 'basic'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_include_head' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_include_head` varchar(255) NOT NULL default '../_head.php'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_include_tail' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_include_tail` varchar(255) NOT NULL default '../_tail.php'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_content_head' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_content_head` text NOT NULL
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_content_tail' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_content_tail` text NOT NULL
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_use' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_use` int(11) NOT NULL default '1'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_main_use' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_main_use` int(11) NOT NULL default '1'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_latest_rows' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_latest_rows` int(11) NOT NULL default '5'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_latest_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_latest_skin` varchar(255) NOT NULL default 'g4m_basic'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_sort' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_sort` int(11) NOT NULL default '0'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_main_sort' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_main_sort` int(11) NOT NULL default '0'
    ";
    @sql_query($sql);
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_m_latestsub_len' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = "
    alter table `{$g5['board_table']}` add `bo_m_latestsub_len` int(11) NOT NULL default '50'
    ";
    @sql_query($sql);
}

} /// if 0
?>
