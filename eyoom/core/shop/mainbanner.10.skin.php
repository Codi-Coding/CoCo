<?php
if (!defined('_GNUBOARD_')) exit;

$max_width = $max_height = 0;
$bn_first_class = ' class="sbn_first"';

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';;
	// 새창 띄우기인지
	$bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';
	
	$bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
	if (file_exists($bimg)) {
		$banner = '';
		$size = getimagesize($bimg);
		
		if($size[2] < 1 || $size[2] > 16) continue;
		
		if($max_width < $size[0]) $max_width = $size[0];
		
		if($max_height < $size[1]) $max_height = $size[1];
		
		$row['bn_first_class'] = $bn_first_class;
		$row['bn_url_0'] = $row['bn_url'][0];
		
		if ($row['bn_url'][0] == '#') {
			$row['bn_href'] = $row['bn_url'];
			$row['bn_new_win'] = '';
		} else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
			$row['bn_href'] = G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'];
			$row['bn_new_win'] = $bn_new_win;
		}
		$row['img_width'] = $size[0];
		$row['bn_border'] = $bn_border;
		
		$bn_first_class = '';
	}
	
	$list[$i] = $row;
}
$count = count($list);

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'mainbanner.10.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/mainbanner.php');

// Template assign
$tpl->assign(array(
	'list' => $list,
	'count' => $count,
	'max_width' => $max_width,
	'max_height' => $max_height,
));
$tpl->print_($tpl_name);