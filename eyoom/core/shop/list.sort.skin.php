<?php
if (!defined('_SHOP_')) exit;
if (!defined("_GNUBOARD_")) exit;

$sct_sort_href = $_SERVER['PHP_SELF'].'?';
if($ca_id)
	$sct_sort_href .= 'ca_id='.$ca_id;
else if($ev_id)
	$sct_sort_href .= 'ev_id='.$ev_id;
if($skin)
	$sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';

$tpl->define(array(
	'list_sort_pc'	=> 'skin_pc/shop/' . $eyoom['shop_skin'] . '/list.sort.skin.html',
	'list_sort_mo'	=> 'skin_mo/shop/' . $eyoom['shop_skin'] . '/list.sort.skin.html',
	'list_sort_bs'	=> 'skin_bs/shop/' . $eyoom['shop_skin'] . '/list.sort.skin.html',
));