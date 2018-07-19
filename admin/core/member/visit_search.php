<?php
$sub_menu = '200810';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

include_once(G5_LIB_PATH.'/visit.lib.php');

$sql_common = " from {$g5['visit_table']} ";
if ($sfl) {
    if($sst=='vi_ip' || $sst=='vi_date'){
        $sql_search = " where $sfl like '$stx%' ";
    }else{
        $sql_search = " where $sfl like '%$stx%' ";
    }
}
$sql = " select count(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} order by vi_id desc limit {$from_record}, {$rows} ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $brow = $row['vi_browser'];
    if(!$brow) $brow = get_brow($row['vi_agent']);

    $os = $row['vi_os'];
    if(!$os) $os = get_os($row['vi_agent']);

    $device = $row['vi_device'];

    $referer = '';
    $title = '';
    if ($row['vi_referer']) {

        $referer = get_text(cut_str($row['vi_referer'], 255, ''));
        $referer = urldecode($referer);

        if (!is_utf8($referer)) {
            $referer = iconv_utf8($referer);
        }

        $title = str_replace(array('<', '>', '&'), array("&lt;", "&gt;", "&amp;"), $referer);
    }

    if ($is_admin == 'super')
        $ip = $row['vi_ip'];
    else
        $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['vi_ip']);
    
    $vi_search[$i] = $row;
    $vi_search[$i]['brow'] = $brow;
    $vi_search[$i]['os'] = $os;
    $vi_search[$i]['device'] = $device;
    $vi_search[$i]['referer'] = $referer;
    $vi_search[$i]['title'] = $title;
    $vi_search[$i]['ip'] = $ip;
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=member&amp;pid=visit_search&amp;".$qstr."&amp;domain={$domain}&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'vi_search' => $vi_search,
));