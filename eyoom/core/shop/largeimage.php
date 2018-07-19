<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/largeimage.php');
	return;
}

$it_id = $_GET['it_id'];
$no = $_GET['no'];

$sql = " select it_id, it_name, it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10
			from {$g5['g5_shop_item_table']} where it_id='$it_id' ";
$row = sql_fetch_array(sql_query($sql));

if(!$row['it_id'])
	alert_close('상품정보가 존재하지 않습니다.');

$imagefile = G5_DATA_PATH.'/item/'.$row['it_img'.$no];
$imagefileurl = G5_DATA_URL.'/item/'.$row['it_img'.$no];
$size = getimagesize($imagefile);

$g5['title'] = "{$row['it_name']} ($it_id)";

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

$thumbnails = array();
for($i=1; $i<=10; $i++) {
	if(!$row['it_img'.$i])
		continue;
	
	$file = G5_DATA_PATH.'/item/'.$row['it_img'.$i];
	if(is_file($file)) {
		// 썸네일
		$thumb = get_it_thumbnail($row['it_img'.$i], 60, 60);
		$thumbnails[$i] = $thumb;
		$imageurl = G5_DATA_URL.'/item/'.$row['it_img'.$i];
		
		$list[$i]['imageurl'] = $imageurl;
		$list[$i]['it_name'] = $row['it_name'];
	}
}
$img_width = $size[0];
$img_height = $size[1];

$total_count = count($thumbnails);
$thumb_count = 0;
if($total_count > 0) {
	foreach($thumbnails as $key=>$val) {
		$thumbs[$key]['href'] = G5_SHOP_URL.'/largeimage.php?it_id='.$it_id.'&amp;no='.$key;
		$thumbs[$key]['img'] = $val;
	}
}

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'largeimage.skin.html');

$tpl->assign(array(
	'thumbs' => $thumbs,
));
// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

include_once(G5_PATH.'/tail.sub.php');