<?php
$sub_menu = "200800";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

include_once(G5_LIB_PATH.'/visit.lib.php');

if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

$qstr = "fr_date=".$fr_date."&amp;to_date=".$to_date;
$query_string = $qstr ? '?'.$qstr : '';

$sql_common = " from {$g5['visit_table']} ";
$sql_search = " where vi_date between '{$fr_date}' and '{$to_date}' ";
if (isset($domain)) {
    $sql_search .= " and vi_referer like '%{$domain}%' ";
    $qstr .= "&amp;domain=$domain";
}

$sql = " select count(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *, SUBSTRING(vi_time,1,2) as hour {$sql_common} {$sql_search} order by vi_id desc limit {$from_record}, {$rows} ";
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
        
    $vi_list[$i] = $row;
    $vi_list[$i]['brow'] = $brow;
    $vi_list[$i]['os'] = $os;
    $vi_list[$i]['device'] = $device;
    $vi_list[$i]['referer'] = $referer;
    $vi_list[$i]['title'] = $title;
    $vi_list[$i]['ip'] = $ip;
    
    $hour = $row['hour'] * 1;
    
    $page_vi_cnt[$hour][$i] = $row;
    $page_vi_br[$brow] ++;
    $page_vi_os[$os] ++;
    $page_vi_dev[$device] ++;
    
    $str = $row['vi_referer'];
    preg_match("/^http[s]*:\/\/([\.\-\_0-9a-zA-Z]*)\//", $str, $match);
    $domain = $match[1];
    $domain = preg_replace("/^(www\.|search\.|dirsearch\.|dir\.search\.|dir\.|kr\.search\.|myhome\.)(.*)/", "\\2", $domain);
    $page_vi_domain[$domain] ++;
    unset($domain, $str, $match);
}

$page_vi_browser 	= $page_vi_br;
$page_vi_os 		= $page_vi_os;
$page_vi_device 	= $page_vi_dev;
$page_vi_domain 	= $page_vi_domain;

/**
 * --------------------------------//
 * 지정한 기간별 통계자료 가져오기 시작
 */
$period_vi_info = get_visit_info($fr_date, $to_date);

// 시간별 방문자 및 회원가입
for($i=0; $i<24; $i++) {
	// 방문자
	$period_vi_count[$i] = $period_vi_info['vi_cnt'][$i] ? count($period_vi_info['vi_cnt'][$i]) : 0;
	
	// 현재 페이지 카운트
	$page_vi_count[$i] = $page_vi_cnt[$i] ? count($page_vi_cnt[$i]) : 0;
}

// 접속 브라우저
$period_vi_browser = $period_vi_info['vi_br'];
// 접속 디바이스
$period_vi_device = $period_vi_info['vi_dev'];
// 접속 OS
$period_vi_os = $period_vi_info['vi_os'];
// 접속 도메인
$period_vi_domain = $period_vi_info['vi_domain'];
/**
 * ------------------------------- //
 */


// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=member&amp;pid=visit_list&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'vi_list' 			=> $vi_list,
	'page_vi_count' 	=> $page_vi_count,
	'page_vi_browser' 	=> $page_vi_browser,
	'page_vi_os' 		=> $page_vi_os,
	'page_vi_device' 	=> $page_vi_device,
	'page_vi_domain' 	=> $page_vi_domain,
	'period_vi_count' 	=> $period_vi_count,
	'period_vi_regist' 	=> $period_vi_regist,
	'period_vi_browser' => $period_vi_browser,
	'period_vi_device'	=> $period_vi_device,
	'period_vi_os'		=> $period_vi_os,
	'period_vi_domain'	=> $period_vi_domain,
));