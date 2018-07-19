<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 추출하기
if(!$wset['rows']) {
	$wset['rows'] = 12;	
}

// 추출하기
$list = apms_item_rows($wset);
$list_cnt = count($list); // 글수

$rank = apms_rank_offset($wset['rows'], $wset['page']);

// 새상품
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 
$new_item = ($wset['newtime']) ? $wset['newtime'] : 24;

// DC
$is_dc = (isset($wset['dc']) && $wset['dc']) ? $wset['dc'] : 'orangered'; 

// 그림자
$shadow_in = '';
$shadow_out = (isset($wset['shadow']) && $wset['shadow']) ? apms_shadow($wset['shadow']) : '';
if($shadow_out && isset($wset['inshadow']) && $wset['inshadow']) {
	$shadow_in = '<div class="in-shadow">'.$shadow_out.'</div>';
	$shadow_out = '';	
}

// 리스트
for ($i=0; $i < $list_cnt; $i++) {

	// DC
	$cur_price = $dc_per = '';
	if($list[$i]['it_cust_price'] > 0 && $list[$i]['it_price'] > 0) {
		$cur_price = '<strike>&nbsp;'.number_format($list[$i]['it_cust_price']).'&nbsp;</strike>';
		$dc_per = round((($list[$i]['it_cust_price'] - $list[$i]['it_price']) / $list[$i]['it_cust_price']) * 100);
	}

	// 라벨
	$item_label = '';
	if($wset['rank']) {
		$rank_txt = ($rank < 4) ? 'Top'.$rank : $rank.'th';
		$item_label = '<div class="label-cap bg-red">'.$rank_txt.'</div>'; $rank++;
	} else if($dc_per || $list[$i]['it_type5']) {
		$item_label = '<div class="label-cap bg-red">DC</div>';	
	} else if($list[$i]['it_type3'] || $list[$i]['pt_num'] >= (G5_SERVER_TIME - ($new_item * 3600))) {
		$item_label = '<div class="label-cap bg-'.$wset['new'].'">New</div>';
	}

	// 아이콘
	$item_icon = item_icon($list[$i]);
	$item_icon = ($item_icon) ? '<div class="label-tack">'.$item_icon.'</div>' : '';

?>
	<div class="item-row">
		<div class="item-list">
			<div class="item-image">
				<a href="<?php echo $list[$i]['href'];?>">
					<div class="img-wrap">
						<?php echo $shadow_in;?>
						<?php echo $item_label;?>
						<?php echo $item_icon;?>
						<div class="img-item">
							<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
						</div>
					</div>
				</a>
				<?php echo $shadow_out;?>
			</div>
			<div class="item-content">
				<?php if($wset['star']) { ?>
					<div class="item-star">
						<?php echo apms_get_star($list[$i]['it_use_avg'], $wset['star']); //평균별점 ?>
					</div>
				<?php } ?>
				<div class="item-name">
					<a href="<?php echo $list[$i]['href'];?>">
						<b><?php echo $list[$i]['it_name'];?></b>
						<div class="item-text">
							<?php echo ($list[$i]['it_basic']) ? $list[$i]['it_basic'] : apms_cut_text($list[$i]['it_explan'], 120); ?>
						</div>
					</a>
				</div>
				<div class="item-price en">
					<?php if($list[$i]['it_tel_inq']) { ?>
						<b>Call</b>
					<?php } else { ?>
						<?php echo $cur_price;?>
						<b><i class="fa fa-krw"></i> <?php echo number_format($list[$i]['it_price']);?></b>
					<?php } ?>
				</div>
				<div class="item-details en">
					<?php if($wset['cmt'] && $list[$i]['pt_comment']) { ?>
						<span class="item-sp red">
							<i class="fa fa-comment"></i> 
							<?php echo number_format($list[$i]['pt_comment']);?>
						</span>
					<?php } ?>
					<?php if($wset['buy'] && $list[$i]['it_sum_qty']) { ?>
						<span class="item-sp blue">
							<i class="fa fa-shopping-cart"></i>
							<?php echo number_format($list[$i]['it_sum_qty']);?>
						</span>
					<?php } ?>
					<?php if($wset['hit'] && $list[$i]['it_hit']) { ?>
						<span class="item-sp gray">
							<i class="fa fa-eye"></i> 
							<?php echo number_format($list[$i]['it_hit']);?>
						</span>
					<?php } ?>
					<?php if($list[$i]['it_point']) { ?>
						<span class="item-sp green">
							<i class="fa fa-gift"></i> 
							<?php echo ($list[$i]['it_point_type'] == 2) ? $list[$i]['it_point'].'%' : number_format(get_item_point($list[$i]));?>
						</span>
					<?php } ?>
					<?php if($dc_per) { ?>
						<span class="item-sp orangered">
							<i class="fa fa-bolt"></i> 
							<?php echo $dc_per;?>% DC
						</span>
					<?php } ?>
				</div>
			</div>
			<?php if($wset['sns']) { ?>
				<div class="item-sns">
					<?php 
						$sns_url  = G5_SHOP_URL.'/item.php?it_id='.$list[$i]['it_id'];
						$sns_title = get_text($list[$i]['it_name']);
						$sns_img = $widget_url.'/img';
						echo  get_sns_share_link('facebook', $sns_url, $sns_title, $sns_img.'/sns_fb.png').' ';
						echo  get_sns_share_link('twitter', $sns_url, $sns_title, $sns_img.'/sns_twt.png').' ';
						echo  get_sns_share_link('googleplus', $sns_url, $sns_title, $sns_img.'/sns_goo.png').' ';
						echo  get_sns_share_link('kakaostory', $sns_url, $sns_title, $sns_img.'/sns_kakaostory.png').' ';
						echo  get_sns_share_link('kakaotalk', $sns_url, $sns_title, $sns_img.'/sns_kakao.png').' ';
						echo  get_sns_share_link('naverband', $sns_url, $sns_title, $sns_img.'/sns_naverband.png').' ';
					?>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } // end for ?>
<?php if(!$list_cnt) { ?>
	<div class="item-none">등록된 상품이 없습니다.</div>
<?php } ?>
