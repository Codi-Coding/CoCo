<?php
$sub_menu = '500400';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

/**
 * action url
 */
$action_url = EYOOM_ADMIN_URL . '/?dir=shopetc&amp;pid=itemstocksmsupdate&amp;smode=1';

// 테이블 생성
if(!isset($g5['g5_shop_item_stocksms_table']))
    die('<meta charset="utf-8">dbconfig.php 파일에 <strong>$g5[\'g5_shop_item_stocksms_table\'] = G5_SHOP_TABLE_PREFIX.\'item_stocksms\';</strong> 를 추가해 주세요.');

if(!sql_query(" select ss_id from {$g5['g5_shop_item_stocksms_table']} limit 1", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['g5_shop_item_stocksms_table']}` (
                  `ss_id` int(11) NOT NULL AUTO_INCREMENT,
                  `it_id` varchar(20) NOT NULL DEFAULT '',
                  `ss_hp` varchar(255) NOT NULL DEFAULT '',
                  `ss_send` tinyint(4) NOT NULL DEFAULT '0',
                  `ss_send_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `ss_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `ss_ip` varchar(25) NOT NULL DEFAULT '',
                  PRIMARY KEY (`ss_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ", true);
}

$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_field == "")  $sel_field = "it_it";
if ($sort1 == "") $sort1 = "ss_send";
if ($sort2 == "") $sort2 = "asc";

$sql_common = "  from {$g5['g5_shop_item_stocksms_table']} ";

// 미전송 건수
$sql = " select count(*) as cnt " . $sql_common . " where ss_send = '0' ";
$row = sql_fetch($sql);
$unsend_count = $row['cnt'];

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select *
           $sql_common
           $sql_search
          order by $sort1 $sort2
          limit $from_record, $rows ";
$result = sql_query($sql);

$qstr1 = 'sel_field='.$sel_field.'&amp;search='.$search;
$qstr = $qstr1.'&amp;sort1='.$sort1.'&amp;sort2='.$sort2.'&amp;page='.$page;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    // 상품정보
    $sql = " select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['it_id']}' ";
    $it = sql_fetch($sql);

    if($it['it_name'])
        $it_name = get_text($it['it_name']);
    else
        $it_name = '상품정보 없음';
        
    $list[$i] = $row;
    $list[$i]['it_name'] = $it_name;    
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=shopetc&amp;pid=itemstocksms&amp;".$qstr1."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'rank_list' => $rank_list,
));
