<?php
if (!defined('_SHOP_')) exit;

$tv_idx = get_session("ss_tv_idx");

$tv_div['top'] = 0;
$tv_div['img_width'] = 160;
$tv_div['img_height'] = 160;
$tv_div['img_length'] = 3; // 한번에 보여줄 이미지 수

$tv_tot_count = 0;
$k = 0;
for ($i=1;$i<=$tv_idx;$i++)
{
	$tv_it_idx = $tv_idx - ($i - 1);
	$tv_it_id = get_session("ss_tv[$tv_it_idx]");
	
	$rowx = sql_fetch(" select it_id, it_name from {$g5['g5_shop_item_table']} where it_id = '$tv_it_id' ");
	if(!$rowx['it_id'])
		continue;
		
	if ($tv_tot_count % $tv_div['img_length'] == 0) $k++;
	
	$it_name = get_text($rowx['it_name']);
	$img = get_it_image($tv_it_id, $tv_div['img_width'], $tv_div['img_height'], $tv_it_id, '', $it_name);
	
	$boxtoday[$i]['it_name'] = cut_str($it_name, 10, '');
	$boxtoday[$i]['img'] = $img;
	
	$tv_tot_count++;
}