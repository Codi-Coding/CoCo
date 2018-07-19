<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/itemuse.php');
	return;
}

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 현재페이지, 총페이지수, 한페이지에 보여줄 행, URL
if (!function_exists('itemuse_page'))
{
	function itemuse_page($write_pages, $cur_page, $total_page, $url, $add="")
	{
		//$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
		$url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';
		
		$str = '';
		if ($cur_page > 1) {
			$str .= '<a href="'.$url.'1'.$add.'" class="pg_page pg_start">처음</a>'.PHP_EOL;
		}
		
		$start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
		$end_page = $start_page + $write_pages - 1;
		
		if ($end_page >= $total_page) $end_page = $total_page;
		
		if ($start_page > 1) $str .= '<a href="'.$url.($start_page-1).$add.'" class="pg_page pg_prev">이전</a>'.PHP_EOL;
		
		if ($total_page > 1) {
			for ($k=$start_page;$k<=$end_page;$k++) {
				if ($cur_page != $k)
					$str .= '<a href="'.$url.$k.$add.'" class="pg_page">'.$k.'</a><span class="sound_only">페이지</span>'.PHP_EOL;
				else
					$str .= '<span class="sound_only">열린</span><strong class="pg_current">'.$k.'</strong><span class="sound_only">페이지</span>'.PHP_EOL;
			}
		}
		
		if ($total_page > $end_page) $str .= '<a href="'.$url.($end_page+1).$add.'" class="pg_page pg_next">다음</a>'.PHP_EOL;
		
		if ($cur_page < $total_page) {
			$str .= '<a href="'.$url.$total_page.$add.'" class="pg_page pg_end">맨끝</a>'.PHP_EOL;
		}
		
		if ($str)
			return "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
		else
			return "";
	}
}

$itemuse_list = "./itemuselist.php";
$itemuse_form = "./itemuseform.php?it_id=".$it_id;
$itemuse_formupdate = "./itemuseformupdate.php?it_id=".$it_id;

$sql_common = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 5;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select * $sql_common order by is_id desc limit $from_record, $rows ";
$result = sql_query($sql);

$thumbnail_width = 500;
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);
	
	$item_use[$i]['mb_id']		= $row['mb_id'];
	$item_use[$i]['is_num']		= $total_count - ($page - 1) * $rows - $i;
	$item_use[$i]['is_star']    = get_star($row['is_score']);
	$item_use[$i]['is_name']    = get_text($row['is_name']);
	$item_use[$i]['is_subject'] = conv_subject($row['is_subject'],50,"…");
	$item_use[$i]['is_content'] = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
	$item_use[$i]['is_time']    = substr($row['is_time'], 2, 8);
	$item_use[$i]['is_href']    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];
	$item_use[$i]['link_edit']  = $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u";
	$item_use[$i]['link_del']   = $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}";
}
$use_cnt = count($item_use);

$paging_itemuse = itemuse_page($config['cf_write_pages'], $page, $total_page, "./itemuse.php?it_id=$it_id&amp;page=", "");

$tpl->define(array(
	'item_use_pc'	=> 'skin_pc/shop/' . $eyoom['shop_skin'] . '/item_use.skin.html',
	'item_use_mo'	=> 'skin_mo/shop/' . $eyoom['shop_skin'] . '/item_use.skin.html',
	'item_use_bs'	=> 'skin_bs/shop/' . $eyoom['shop_skin'] . '/item_use.skin.html',
));

if ($_GET['page']) {	
	// Template assign
	@include EYOOM_INC_PATH.'/tpl.assign.php';
	$tpl->print_('item_use_'.$tpl_name);
}