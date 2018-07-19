<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

//포인트 관리테이블
$g5_point_table  = "{$write_table}_point"; /// 서브 테이블 이용

if(!sql_query(" DESC {$g5_point_table} ", false)) {
    sql_query(" CREATE TABLE `{$g5_point_table}` (
        `po_id` int(11) NOT NULL auto_increment,
        `order_id` int(11) NOT NULL default '0',
        `bo_table` varchar(255) NOT NULL default '',
        `wr_id` varchar(255) NOT NULL default '',
        `mb_id` varchar(255) NOT NULL default '',
        `b_name` varchar(255) NOT NULL default '',
        `order_time` datetime NOT NULL default '0000-00-00 00:00:00',
        `ing_time` datetime NOT NULL default '0000-00-00 00:00:00',
        `send_time` datetime NOT NULL default '0000-00-00 00:00:00',
        `order_state` varchar(255) NOT NULL default '',
        `b_tel` varchar(255) NOT NULL default '',
        `b_hp` varchar(255) NOT NULL default '',
        `b_email` varchar(255) NOT NULL default '',
        `b_addr1` varchar(255) NOT NULL default '',
        `b_addr2` varchar(255) NOT NULL default '',
        `b_ch` int(11) NOT NULL default '0',
        `b_name2` varchar(255) NOT NULL default '',
        `b_tel2` varchar(255) NOT NULL default '',
        `b_hp2` varchar(255) NOT NULL default '',
        `b_email2` varchar(255) NOT NULL default '',
        `b_addr1_2` varchar(255) NOT NULL default '',
        `b_addr2_2` varchar(255) NOT NULL default '',
        `b_ch2` int(11) NOT NULL default '0',
        `b_opt1` varchar(255) NOT NULL default '',
        `b_opt2` varchar(255) NOT NULL default '',
        `b_opt3` varchar(255) NOT NULL default '',
        `b_opt5` varchar(255) NOT NULL default '',
        `b_opt6` varchar(255) NOT NULL default '',
        `b_opt7` varchar(255) NOT NULL default '',
        `b_opt8` varchar(255) NOT NULL default '',
        `b_opt9` varchar(255) NOT NULL default '',
        `b_opt10` varchar(255) NOT NULL default '',
         PRIMARY KEY  (`po_id`) ) ", false);
}

function point_buy($wr_id, $point)
{
}

?>
