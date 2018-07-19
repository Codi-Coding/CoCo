<?php
if (!defined('_GNUBOARD_')) exit;

include_once(EYOOM_CLASS_PATH.'/template.class.php');
$tpl = new Template($this->theme);

include_once(EYOOM_CLASS_PATH.'/shop.class.php');
$shop = new shop;

// Template define
$tpl->define_template('shop',$this->eyoom['shop_skin'],'main.20.skin.html');

for ($i=1; $row=sql_fetch_array($result); $i++) {
	$row['sct_last'] = '';
	if($i>1 && $i%$this->list_mod == 0)
		$row['sct_last'] = ' sct_last'; // 줄 마지막
	
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
		$row['sns_url']  = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
		$row['sns_title'] = get_text($row['it_name']).' | '.get_text($config['cf_title']);
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
	'tpl_name' => $this->tpl_name,
	'type' => $this->type,
	'css' => $this->css,
	'list_mod' => $this->list_mod,
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