<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/itemuselist.php');
    return;
}

if( isset($sfl) && ! in_array($sfl, array('b.it_name', 'a.it_id', 'a.is_subject', 'a.is_content', 'a.is_name', 'a.mb_id')) ){
    //다른값이 들어가있다면 초기화
    $sfl = '';
}

// Page ID
$pid = ($pid) ? $pid : 'iuse';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$skin_row = array();
$skin_row = apms_rows('use_'.MOBILE_.'rows, use_'.MOBILE_.'skin, use_'.MOBILE_.'set');
$skin_name = $skin_row['use_'.MOBILE_.'skin'];

// 스킨설정
$wset = array();
if($skin_row['use_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['use_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$skin_path = G5_SKIN_PATH.'/apms/use/'.$skin_name;
$skin_url = G5_SKIN_URL.'/apms/use/'.$skin_name;

// 스킨 체크
list($skin_path, $skin_url) = apms_skin_thema('shop/use', $skin_path, $skin_url); 

// 설정값 불러오기
$is_use_sub = false;
@include_once($skin_path.'/config.skin.php');

$g5['title'] = '상품후기';

if($is_use_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$sql_common = " from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) ";
$sql_search = " where a.is_confirm = '1' ";

if(!$sfl)
    $sfl = 'b.it_name';

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "a.it_id" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.is_name" :
        case "a.mb_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

// 분류추가
if($ca_id) {
	$sql_search .= "and (b.ca_id like '{$ca_id}%' or b.ca_id2 like '{$ca_id}%' or b.ca_id3 like '{$ca_id}%')";
	$qstr .= '&amp;ca_id='.$ca_id;
}

if (!$sst) {
    $sst  = "a.is_id";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
         $sql_common
         $sql_search
         $sql_order ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$list = array();

$rows = $skin_row['use_'.MOBILE_.'rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)	{
	$list[$i] = $row;
	$list[$i]['is_num'] = $total_count - ($page - 1) * $rows - $i;
	$list[$i]['is_time'] = strtotime($row['is_time']);
	$list[$i]['is_photo'] = apms_photo_url($row['mb_id']);
	$list[$i]['is_href'] = './itemuseview.php?is_id='.$row['is_id'].$qstr;
	$list[$i]['it_href'] = './item.php?it_id='.$row['it_id'];
	$list[$i]['is_edit_href'] = './itemuseform.php?it_id='.$row['it_id'].'&amp;is_id='.$row['is_id'].'&amp;page='.$page.'&amp;w=u&amp;move=3';
	$list[$i]['is_subject'] = get_text($row['is_subject']);
	$list[$i]['is_reply'] = false;
	if(!empty($row['is_reply_content'])) {
		$list[$i]['is_reply'] = true;
		$list[$i]['is_reply_name'] = get_text($row['is_reply_name']); 
		$list[$i]['is_reply_subject'] = get_text($row['is_reply_subject']); 
		$list[$i]['is_reply_content'] = apms_content(conv_content($row['is_reply_content'], 1));
	}

	$hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);
	$list[$i]['is_del_href'] = './itemuseformupdate.php?it_id='.$row['it_id'].'&amp;is_id='.$row['is_id'].'&amp;w=d&amp;move=2&amp;hash='.$hash;
}

// 셋업
$setup_href = '';
if (is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=use&amp;name='.urlencode($skin_name).'&amp;ts='.urlencode(THEMA);
}

// 페이징
$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];

$list_page = $_SERVER['SCRIPT_NAME'].'?';
if($pid != 'iuse' && $pid) $list_page .= '&amp;pid='.$pid;
$list_page .= $qstr.'&amp;page=';

include_once($skin_path.'/uselist.skin.php');

if($is_use_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>