<?php
$sub_menu = '500500';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$sql_common = " from {$g5['g5_shop_banner_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * from {$g5['g5_shop_banner_table']}
      order by bn_order, bn_id desc
      limit $from_record, $rows  ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    // 테두리 있는지
    $bn_border  = $row['bn_border'];
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? "target='_blank'" : '';

    $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
    if(file_exists($bimg)) {
        $size = @getimagesize($bimg);
        if($size[0] && $size[0] > 800)
            $width = 800;
        else
            $width = $size[0];

        $bn_img = "";
        if ($row['bn_url'] && $row['bn_url'] != "http://")
            $bn_img .= "<a href='".$row['bn_url']."' ".$bn_new_win.">";
        $bn_img .= "<img src='".G5_DATA_URL."/banner/".$row['bn_id']."' class='img-responsive' alt='".$row['bn_alt']."'></a>";
    }

    switch($row['bn_device']) {
        case 'pc':
            $bn_device = 'PC';
            break;
        case 'mobile':
            $bn_device = '모바일';
            break;
        default:
            $bn_device = 'PC와 모바일';
            break;
    }

    $bn_begin_time = substr($row['bn_begin_time'], 2, 14);
    $bn_end_time   = substr($row['bn_end_time'], 2, 14);
    
    $banner_list[$i] = $row;
    $banner_list[$i]['bn_device'] = $bn_device;
    $banner_list[$i]['bn_begin_time'] = $bn_begin_time;
    $banner_list[$i]['bn_end_time'] = $bn_end_time;
    $banner_list[$i]['bn_img'] = $bn_img;
}

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=shopetc&amp;pid=itemeventlist&amp;".$qstr."&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'banner_list' => $banner_list,
));