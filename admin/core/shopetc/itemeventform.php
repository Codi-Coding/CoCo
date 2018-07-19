<?php
$sub_menu = '500300';
if (!defined('_EYOOM_IS_ADMIN_')) exit;
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$action_url = EYOOM_ADMIN_URL . '/?dir=shopetc&amp;pid=itemeventformupdate&smode=1';

if ($w == "u")
{
    $html_title .= " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['g5_shop_event_table']} where ev_id = '$ev_id' ";
    $ev = sql_fetch($sql);
    if (!$ev['ev_id'])
        alert("등록된 자료가 없습니다.");

    // 등록된 이벤트 상품
    $sql = " select b.it_id, b.it_name
                from {$g5['g5_shop_event_item_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                where a.ev_id = '$ev_id' ";
    $res_item = sql_query($sql);
    
    for($i=0; $row=sql_fetch_array($res_item); $i++) {
        $it_info[$i] = $row;
        $it_info[$i]['image'] = get_it_image($row['it_id'], 50, 50);
    }
}
else
{
    $html_title .= " 입력";
    $ev['ev_skin'] = 'list.10.skin.php';
    $ev['ev_mobile_skin'] = 'list.10.skin.php';
    $ev['ev_use'] = 1;

    $ev['ev_img_width']  = 230;
    $ev['ev_img_height'] = 230;
    $ev['ev_list_mod'] = 3;
    $ev['ev_list_row'] = 5;
    $ev['ev_mobile_img_width']  = 230;
    $ev['ev_mobile_img_height'] = 230;
    $ev['ev_mobile_list_mod'] = 3;
    $ev['ev_mobile_list_row'] = 5;
}

// 분류리스트
$category_select = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
if ($is_admin != 'super')
    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $len = strlen($row['ca_id']) / 2 - 1;

    $nbsp = "";
    for ($i=0; $i<$len; $i++)
        $nbsp .= "&nbsp;&nbsp;&nbsp;";

    $category_select .= "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";
}

$mimg_url = "";
$mimg = G5_DATA_PATH.'/event/'.$ev['ev_id'].'_m';
if (file_exists($mimg)) {
    $size = @getimagesize($mimg);
    if($size[0] && $size[0] > 750)
        $width = 750;
    else
        $width = $size[0];

    $mimg_url = G5_DATA_URL.'/event/'.$ev['ev_id'].'_m';
    $mimg_width = $width;
}

$himg_url = "";
$himg = G5_DATA_PATH.'/event/'.$ev['ev_id'].'_h';
if (file_exists($himg)) {
    $size = @getimagesize($himg);
    if($size[0] && $size[0] > 750)
        $width = 750;
    else
        $width = $size[0];

    $himg_url = G5_DATA_URL.'/event/'.$ev['ev_id'].'_h';
    $himg_width = $width;
}

$timg_url = "";
$timg = G5_DATA_PATH.'/event/'.$ev['ev_id'].'_t';
if (file_exists($timg)) {
    $size = @getimagesize($timg);
    if($size[0] && $size[0] > 750)
        $width = 750;
    else
        $width = $size[0];

    $timg_url = G5_DATA_URL.'/event/'.$ev['ev_id'].'_t';
    $timg_width = $width;
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'ev' => $ev,
	'it_info' => $it_info,
));