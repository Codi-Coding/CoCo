<?php
if (!defined('_GNUBOARD_')) exit;

include_once(EYOOM_CLASS_PATH.'/template.class.php');
$tpl = new Template($this->theme);

include_once(EYOOM_CLASS_PATH.'/shop.class.php');
$shop = new shop;

// Template define
$tpl->define_template('shop',$this->eyoom['shop_skin'],'main.50.skin.html');

$css	= $this->css;
$img_width = $this->img_width;

for ($i=1; $row=sql_fetch_array($result); $i++) {
	if ($this->list_mod >= 2) { // 1줄 이미지 : 2개 이상
		if ($i%$this->list_mod == 0) $row['sct_last'] = 'sct_last'; // 줄 마지막
		else if ($i%$this->list_mod == 1) $row['sct_last'] = 'sct_clear'; // 줄 첫번째
		else $row['sct_last'] = '';
	} else { // 1줄 이미지 : 1개
		$row['sct_last'] = ' sct_clear';
	}
	
	if($this->href) {
		$row['href'] = $this->href . $row['it_id'];
	}
	$row['it_image'] = $this->view_it_img ? get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name'])):'';
	
	if($this->view_it_icon) {
		$row['it_icon'] = $shop->item_icon($row);
	}
	
	// 할인율 계산
	$row['dc_ratio'] = $row['it_cust_price'] ? $shop->dc_ratio($row['it_cust_price'], $row['it_price']): 0;
	
	if ($this->view_it_cust_price || $this->view_it_price) {
		if ($this->view_it_cust_price && $row['it_cust_price']) {
			$row['it_cust_price'] = "<strike>".preg_replace('/원/','',display_price($row['it_cust_price']))."</strike>";
		}
		if ($this->view_it_price) {
			$row['it_tel_inq'] = preg_replace('/원/','',display_price(get_price($row), $row['it_tel_inq']));
		}
	}
	
	if ($this->view_sns) {
		$row['sns_top'] = $this->img_height + 10;
		$row['sns_url']  = urlencode(G5_SHOP_URL.'/item.php?it_id='.$row['it_id']);
		$row['sns_title'] = urlencode(get_text($row['it_name']).' | '.get_text($config['cf_title']));
	}
	
	// 고객선호도 별점수
	$row['star_score'] = get_star_image($row['it_id']);
	
	$list[$i] = $row;
}
$count = count($list);

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/main.user.php');

// Template assign
$tpl->assign(array(
	'list' => $list,
	'count' => $count,
	'css' => $this->css,
	'href' => $this->href,
	'view_it_img' => $this->view_it_img,
	'view_it_icon' => $this->view_it_icon,
	'view_it_id' => $this->view_it_id,
	'view_it_name' => $this->view_it_name,
	'view_it_basic' => $this->view_it_basic,
	'view_it_cust_price' => $this->view_it_cust_price,
	'view_it_price' => $this->view_it_price,
	'view_sns' => $this->view_sns,
));
$tpl->print_($this->tpl_name);