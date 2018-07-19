<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/itemqa.php');
	return;
}

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 현재페이지, 총페이지수, 한페이지에 보여줄 행, URL
if (!function_exists('itemqa_page'))
{
	function itemqa_page($write_pages, $cur_page, $total_page, $url, $add="")
	{
		//$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
		$url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';
		
		$str = '';
		if ($cur_page > 1) {
			$str .= '<a href="'.$url.'1'.$add.'" class="qa_page qa_start">처음</a>'.PHP_EOL;
		}
		
		$start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
		$end_page = $start_page + $write_pages - 1;
		
		if ($end_page >= $total_page) $end_page = $total_page;
		
		if ($start_page > 1) $str .= '<a href="'.$url.($start_page-1).$add.'" class="qa_page pg_prev">이전</a>'.PHP_EOL;
		
		if ($total_page > 1) {
			for ($k=$start_page;$k<=$end_page;$k++) {
				if ($cur_page != $k)
					$str .= '<a href="'.$url.$k.$add.'" class="qa_page">'.$k.'</a><span class="sound_only">페이지</span>'.PHP_EOL;
				else
					$str .= '<span class="sound_only">열린</span><strong class="pg_current">'.$k.'</strong><span class="sound_only">페이지</span>'.PHP_EOL;
			}
		}
		
		if ($total_page > $end_page) $str .= '<a href="'.$url.($end_page+1).$add.'" class="qa_page pg_next">다음</a>'.PHP_EOL;
		
		if ($cur_page < $total_page) {
			$str .= '<a href="'.$url.$total_page.$add.'" class="qa_page pg_end">맨끝</a>'.PHP_EOL;
		}
		
		if ($str)
			return "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
		else
			return "";
	}
}

$itemqa_list = "./itemqalist.php";
$itemqa_form = "./itemqaform.php?it_id=".$it_id;
$itemqa_formupdate = "./itemqaformupdate.php?it_id=".$it_id;

$sql_common = " from `{$g5['g5_shop_item_qa_table']}` where it_id = '{$it_id}' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 5;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select * $sql_common order by iq_id desc limit $from_record, $rows ";
$result = sql_query($sql);

$thumbnail_width = 500;
$iq_num     = $total_count - ($page - 1) * $rows;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$iq_name    = get_text($row['iq_name']);
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
	$iq_time    = substr($row['iq_time'], 2, 8);
	
	$hash = md5($row['iq_id'].$row['iq_time'].$row['iq_ip']);
	
	$iq_stats = '';
	$iq_style = '';
	$iq_answer = '';
	
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
	
	$item_qa[$i]['iq_name'] = $iq_name;
	$item_qa[$i]['iq_subject'] = $iq_subject;
	$item_qa[$i]['iq_time'] = $iq_time;
	$item_qa[$i]['iq_stats'] = $iq_stats;
	$item_qa[$i]['iq_style'] = $iq_style;
	$item_qa[$i]['iq_question'] = $iq_question;
	$item_qa[$i]['iq_answer'] = $iq_answer;
	$item_qa[$i]['is_secret'] = $is_secret;
	$item_qa[$i]['is_answer'] = $is_answer;
	$item_qa[$i]['mb_id'] = $row['mb_id'];
	$item_qa[$i]['link_edit']  = $itemqa_form."&amp;iq_id={$row['iq_id']}&amp;w=u";
	$item_qa[$i]['link_del']   = $itemqa_formupdate."&amp;iq_id={$row['iq_id']}&amp;w=d&amp;hash={$hash}";
	$item_qa[$i]['iq_num'] = $iq_num;
	$iq_num--;
}
$qa_cnt = count($item_qa);

$paging_itemqa = itemqa_page($config['cf_write_pages'], $page, $total_page, "./itemqa.php?it_id=$it_id&amp;page=", "");

$tpl->define(array(
	'item_qa_pc'	=> 'skin_pc/shop/' . $eyoom['shop_skin'] . '/item_qa.skin.html',
	'item_qa_mo'	=> 'skin_mo/shop/' . $eyoom['shop_skin'] . '/item_qa.skin.html',
	'item_qa_bs'	=> 'skin_bs/shop/' . $eyoom['shop_skin'] . '/item_qa.skin.html',
));

if ($_GET['page']) {	
	// Template assign
	@include EYOOM_INC_PATH.'/tpl.assign.php';
	$tpl->print_('item_qa_'.$tpl_name);
}