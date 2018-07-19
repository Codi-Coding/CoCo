<?php
if (!defined('_SHOP_')) exit;

// 상품 썸네일 이미지
$thumbnails = array();
for($i=1; $i<=10; $i++) {
	if(!$it['it_img'.$i]) continue;

	$img = get_it_thumbnail($it['it_img'.$i], $default['de_mimg_width'], $default['de_mimg_height']);
	if($img) {
		// 썸네일
		$thumb = get_it_thumbnail($it['it_img'.$i], 120, 0);
		$thumbnails[] = $thumb;
		$thumb_big[$i]['href'] = G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$i;
		$thumb_big[$i]['img'] = $img;
	}
}

$thumb1 = true;
$thumb_count = 0;
$thumb_total_count = count($thumbnails);
if($thumb_total_count > 0) {
    $i=0;
    foreach($thumbnails as $val) {
        $thumb_count++;
        $sit_pvi_last ='';
        if ($thumb_count % 5 == 0) $thumb_info[$i]['sit_pvi_last'] = 'class="li_last"';
        $thumb_info[$i]['href'] = G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$thumb_count;
        $thumb_info[$i]['img'] = $val;
        $thumb_info[$i]['cnt'] = $thumb_count;
        $i++;
    }
}

// 이미지 크게 보기 모달 작업 : 시작
$it_id = $_GET['it_id'];
$no = 1;

$sql = " select it_id, it_name, it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10
			from {$g5['g5_shop_item_table']} where it_id='$it_id' ";
$row = sql_fetch_array(sql_query($sql));

if(!$row['it_id'])
	alert_close('상품정보가 존재하지 않습니다.');

$imagefile = G5_DATA_PATH.'/item/'.$row['it_img'.$no];
$imagefileurl = G5_DATA_URL.'/item/'.$row['it_img'.$no];
$size = getimagesize($imagefile);

$thumbnails = array();
for($i=1; $i<=10; $i++) {
	if(!$row['it_img'.$i])
		continue;

	$file = G5_DATA_PATH.'/item/'.$row['it_img'.$i];
	if(is_file($file)) {
		// 썸네일
		$thumb = get_it_thumbnail($row['it_img'.$i], 120, 0);
		$thumbnails[$i] = $thumb;
		$imageurl = G5_DATA_URL.'/item/'.$row['it_img'.$i];

		$bigimg[$i]['imageurl'] = $imageurl;
		$bigimg[$i]['it_name'] = $row['it_name'];
		
	}
}
$img_width = $size[0];
$img_height = $size[1];

$total_img_count = count($thumbnails);
$thumb_count = 0;
if($total_img_count > 0) {
    foreach($thumbnails as $key=>$val) {
		$thumbs[$key]['href'] = G5_SHOP_URL.'/largeimage.php?it_id='.$it_id.'&amp;no='.$key;
		$thumbs[$key]['img'] = $val;
    }
}
$tpl->assign(array(
	'bigimg' => $bigimg,
	'thumbs' => $thumbs,
));
// 이미지 크게 보기 모달 작업 : 끝

//판매가격
$sell_price = get_price($it);
if($config['cf_use_point']) {
	if($it['it_point_type'] == 2) {
		$point_calc = '구매금액(추가옵션 제외)의 '.$it['it_point'].'%';
	} else {
		$it_point = get_item_point($it);
		$point_calc = number_format($it_point).'점';
	}
}

// 배송비 결제
$ct_send_cost_label = '배송비결제';

if($it['it_sc_type'] == 1)
	$sc_method = '무료배송';
else {
	if($it['it_sc_method'] == 1)
		$sc_method = '수령후 지불';
	else if($it['it_sc_method'] == 2) {
		$ct_send_cost_label = '<label for="ct_send_cost">배송비결제</label>';
		$sc_method = '<select name="ct_send_cost" id="ct_send_cost">
						  <option value="0">주문시 결제</option>
						  <option value="1">수령후 지불</option>
					  </select>';
	}
	else
		$sc_method = '주문시 결제';
}

// 선택된 옵션
if($is_orderable) {
	if(!$option_item) {
		if(!$it['it_buy_min_qty']) $it['it_buy_min_qty_sel'] = 1;
		else $it['it_buy_min_qty_sel'] = $it['it_buy_min_qty'];
	}
}

// 인코딩 URL
$encoded_url = urlencode(G5_SHOP_URL."/item.php?it_id=$it_id");