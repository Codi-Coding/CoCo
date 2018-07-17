<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/itemqalist.php');
    return;
}

// Page ID
$pid = ($pid) ? $pid : 'iqa';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$skin_row = array();
$skin_row = apms_rows('qa_'.MOBILE_.'rows, qa_'.MOBILE_.'skin, qa_'.MOBILE_.'set');
$skin_name = $skin_row['qa_'.MOBILE_.'skin'];

// 스킨설정
$wset = array();
if($skin_row['qa_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['qa_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$skin_path = G5_SKIN_PATH.'/apms/qa/'.$skin_name;
$skin_url = G5_SKIN_URL.'/apms/qa/'.$skin_name;

// 스킨 체크
list($skin_path, $skin_url) = apms_skin_thema('shop/qa', $skin_path, $skin_url); 

// 설정값 불러오기
$is_qalist_sub = false;
@include_once($skin_path.'/config.skin.php');

$g5['title'] = '상품문의';

if($is_qa_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

//$sfl = trim($_REQUEST['sfl']);
//$stx = trim($_REQUEST['stx']);

$sql_common = " from `{$g5['g5_shop_item_qa_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) ";
$sql_search = " where (1) ";

if(!$sfl)
    $sfl = 'b.it_name';

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "a.it_id" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.iq_name" :
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
    $sst  = "a.iq_id";
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

$itemqa_list = "./itemqalist.php";
$itemqa_form = "./itemqaform.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows;
$itemqa_formupdate = "./itemqaformupdate.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows.'&amp;page='.$page;
$itemqans_form = "./itemqansform.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows;
$itemqans_formupdate = "./itemqansformupdate.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows.'&amp;page='.$page;

$rows = $skin_row['qa_'.MOBILE_.'rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.*, b.it_name
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$admin_photo = apms_photo_url($config['cf_admin']);
$iq_num = $total_count - ($page - 1) * $rows;
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['iq_num'] = $iq_num;
	$list[$i]['secret'] = false;
	if($row['iq_secret']) {
		if($is_admin || ($is_member && ($member['mb_id' ] == $row['mb_id'] || $member['mb_id' ] == $row['pt_id']))) {
			;
		} else {
			$list[$i]['iq_question'] = '비밀글로 보호된 문의입니다.';
			$list[$i]['secret'] = true;
		}
	} 

	$list[$i]['iq_time'] = strtotime($row['iq_time']);

	$list[$i]['iq_href'] = './itemqaview.php?iq_id='.$row['iq_id'].$qstr;
	$list[$i]['iq_edit_href'] = './itemqaform.php?it_id='.$row['it_id'].'&amp;iq_id='.$row['iq_id'].'&amp;page='.$page.'&amp;w=u&amp;move=3';
	$list[$i]['iq_ans_href'] = './itemqansform.php?it_id='.$row['it_id'].'&amp;iq_id='.$row['iq_id'].'&amp;page='.$page.'amp;move=3';

	$hash = md5($row['iq_id'].$row['iq_time'].$row['iq_ip']);
	$list[$i]['iq_del_href'] = './itemqaformupdate.php?it_id='.$row['it_id'].'&amp;iq_id='.$row['iq_id'].'&amp;w=d&amp;move=2&amp;hash='.$hash;

	$list[$i]['it_href'] = './item.php?it_id='.$row['it_id'];
	$list[$i]['iq_photo'] = apms_photo_url($row['mb_id']);
	if($row['pt_id']) {
		$list[$i]['ans_photo'] = ($row['pt_id'] == $config['cf_admin']) ? $admin_photo : apms_photo_url($row['pt_id']);
	} else {
		$list[$i]['ans_photo'] = $admin_photo;
	}
	$list[$i]['answer'] = false;
	if(!$list[$i]['secret']) {
		if ($row['iq_answer']) {
			$list[$i]['answer'] = true;
		}
	}

	$iq_num--;
}

// 셋업
$setup_href = '';
if (is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=qa&amp;name='.urlencode($skin_name).'&amp;ts='.urlencode(THEMA);
}

$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['SCRIPT_NAME'].'?';
if($pid != 'iuse' && $pid) $list_page .= '&amp;pid='.$pid;
$list_page .= $qstr.'&amp;page=';

include_once($skin_path.'/qalist.skin.php');

if($is_qa_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>