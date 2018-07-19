<?php
if (!defined('_SHOP_')) exit;

if( isset($sfl) && ! in_array($sfl, array('b.it_name', 'a.it_id', 'a.iq_subject', 'a.iq_question', 'a.iq_name', 'a.mb_id')) ){
    //다른값이 들어가있다면 초기화
    $sfl = '';
}

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/itemqalist.php');
	return;
}

$g5['title'] = '상품문의';

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.head.php');

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

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.*, b.it_name
			$sql_common
			$sql_search
			$sql_order
			limit $from_record, $rows ";
$result = sql_query($sql);

$thumbnail_width = 500;
$num = $total_count - ($page - 1) * $rows;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$iq_subject = conv_subject($row['iq_subject'],50,"…");
	
	$is_secret = false;
	if($row['iq_secret']) {
		$iq_subject .= ' <i class="fa fa-lock color-red"></i>';
		
		if($is_admin || $member['mb_id' ] == $row['mb_id']) {
			$iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
		} else {
			$iq_question = '비밀글로 보호된 문의입니다.';
			$is_secret = true;
		}
	} else {
		$iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
	}

	$it_href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
	
	if ($row['iq_answer'])
	{
		$iq_answer = get_view_thumbnail(conv_content($row['iq_answer'], 1), $thumbnail_width);
		$iq_stats = '답변완료';
		$iq_style = 'sit_qaa_done';
		$is_answer = true;
	} else {
		$iq_stats = '답변전';
		$iq_style = 'sit_qaa_yet';
		$iq_answer = '답변이 등록되지 않았습니다.';
		$is_answer = false;
	}
	$list[$i]['it_href'] = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";
	$list[$i]['it_id'] = $row['it_id'];
	$list[$i]['it_name'] = $row['it_name'];
	$list[$i]['iq_name'] = $row['iq_name'];
	$list[$i]['iq_time'] = $row['iq_time'];
	$list[$i]['iq_subject'] = $iq_subject;
	$list[$i]['iq_style'] = $iq_style;
	$list[$i]['iq_stats'] = $iq_stats;
	$list[$i]['iq_question'] = $iq_question;
	$list[$i]['is_secret'] = $is_secret;
	$list[$i]['iq_answer'] = $iq_answer;
	$num--;
}
$count = count($list);

// Paging 
$paging = $thema->pg_pages($tpl_name,$_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=');

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'item_qalist.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/itemqalist.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');