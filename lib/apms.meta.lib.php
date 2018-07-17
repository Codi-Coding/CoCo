<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$seometa = array();

// 메타태그 사용안함
if($is_no_meta) return;

$seometa['publisher'] = $seometa['creator'] = str_replace("\"", "'", apms_get_text($config['cf_title']));

if($is_seometa == 'view') { //게시물
	$seometa['subject'] = apms_get_text($write['wr_subject']);
	$g5_head_title = $seometa['subject'];
	$seometa['description'] = apms_cut_text($write['wr_content'], 200);
	$seometa['creator'] = apms_get_text($write['wr_name']);
	$seometa['keyword'] = apms_seo_keyword($write['as_tag'].','.$write['ca_name'].','.$board['bo_subject'].','.$group['gr_subject']);
	$seometa['type'] = 'article';
	$seometa['url'] = G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id;
	$seometa['img'] = apms_wr_thumbnail($bo_table, $write, 0, 0); // 썸네일
	if(isset($write['as_thumb']) && !$write['as_thumb']) {
		$write['as_thumb'] = ($seometa['img']['src']) ? $seometa['img']['src'] : 1;
		sql_query(" update {$write_table} set as_thumb = '".addslashes($write['as_thumb'])."' where wr_id = '{$wr_id}' ", false);
	}
} else if($is_seometa == 'it') { // 상품
	$seometa['subject'] = apms_get_text($it['it_name']);
	$g5_head_title = $seometa['subject'];
	$seometa['description'] = ($it['it_basic']) ? apms_get_text($it['it_basic']) : apms_cut_text($it['it_explan'], 200);
	$seometa['creator'] = ($author['mb_nick']) ? $author['mb_nick'] : $seometa['publisher'];
	$seometa['keyword'] = apms_seo_keyword($it['pt_tag'].','.$it['ca_name']);
	$seometa['type'] = 'product';
	$seometa['url'] = G5_SHOP_URL.'/item.php?it_id='.$it['it_id'];
	$seometa['img'] = apms_it_thumbnail($it, 0, 0, false, true);
	//썸네일 이미지 업데이트
	if(isset($it['pt_thumb']) && !$it['pt_thumb']) {
		$it['pt_thumb'] = ($seometa['img']['src']) ? $seometa['img']['src'] : 1;
		sql_query(" update {$g5['g5_shop_item_table']} set pt_thumb = '".addslashes($it['pt_thumb'])."' where it_id = '{$it['it_id']}' ", false);
	}
} else if($is_seometa == 'iqa') { //상품문의
	$seometa['subject'] = apms_get_text($view['iq_subject']).' > '.apms_get_text($view['it_name']);
	$seometa['description'] = apms_cut_text($view['it_name'].' : '.$view['iq_content'], 200);
	$seometa['creator'] = apms_get_text($view['iq_name']);
	$seometa['keyword'] = apms_seo_keyword($view['pt_tag']);
	$seometa['type'] = 'article';
	$seometa['url'] = G5_SHOP_URL.'/itemqaview.php?iq_id='.(int)$_REQUEST['iq_id'];
	$seometa['img'] = apms_it_write_thumbnail($view['it_id'], $view['iq_content'], 0, 0);
} else if($is_seometa == 'iuse') { //상품후기
	$seometa['subject'] = apms_get_text($view['is_subject']).' > '.apms_get_text($view['it_name']);
	$g5_head_title = $seometa['subject'];
	$seometa['description'] = apms_cut_text($view['it_name'].' : '.$view['is_content'], 200);
	$seometa['creator'] = apms_get_text($view['is_name']);
	$seometa['keyword'] = apms_seo_keyword($view['pt_tag']);
	$seometa['type'] = 'article';
	$seometa['url'] = G5_SHOP_URL.'/itemuseview.php?is_id='.(int)$_REQUEST['is_id'];
	$seometa['img'] = apms_it_write_thumbnail($view['it_id'], $view['is_content'], 0, 0);
} else if($is_seometa == 'page' || $is_seometa == 'content') { // 페이지
	$seometa['subject'] = $at['subject'];
	$seometa['description'] = $seo_page_desc;
	$seometa['keyword'] = apms_seo_keyword($at['nav2'].','.$at['nav1']);
	$seometa['type'] = 'website';
	if($is_seometa == 'content') {
		$seometa['url'] = G5_BBS_URL.'/content.php?co_id='.clean_xss_tags($co_id);
	} else {
		$seometa['url'] = G5_BBS_URL.'/page.php?hid='.clean_xss_tags($hid);
	}
	$seometa['img']['src'] = $seo_page_img;
} else { //기타
	$seometa['url'] = clean_xss_tags($_SERVER['REQUEST_URI']);
	$seometa['url'] = str_replace("&amp;pim=1", "", $seometa['url']);
	$seometa['url'] = str_replace("&pim=1", "", $seometa['url']);
	$seometa['url'] = $_SERVER['HTTP_HOST'].$seometa['url'];
	$seometa['url'] = ($xp['https_url']) ? 'https://'.$seometa['url'] : 'http://'.$seometa['url'];
	$seometa['keyword'] = apms_seo_keyword();
}

$seometa['title'] = str_replace("\"", "'", $g5_head_title);

if(!$seometa['description']) {
	$seometa['description'] = ($xp['seo_desc']) ? apms_get_text($xp['seo_desc']) : $seometa['title'];
}
$seometa['description'] = str_replace("\"", "'", $seometa['description']);
$seometa['url'] = preg_replace("/[\<\>\'\"\\\'\\\"\(\)\^\*]/", "", $seometa['url']);

//이미지가 없으면 대표이미지 지정
if(!$seometa['img']['src']) {
	if ($xp['seo_img'] && preg_match("/(\.(jpg|jpeg|gif|png))$/i", $xp['seo_img'])) {
		$seometa['img']['src'] = $xp['seo_img'];
	}
}

?>
<meta name="title" content="<?php echo $seometa['title'];?>" />
<?php if($seometa['subject']) { ?>
<meta name="subject" content="<?php echo str_replace("\"", "'", $seometa['subject']);?>" />
<?php } ?>
<meta name="publisher" content="<?php echo $seometa['publisher'];?>" />
<meta name="author" content="<?php echo $seometa['creator'];?>" />
<meta name="robots" content="index,follow" />
<meta name="keywords" content="<?php echo $seometa['keyword'];?>" />
<meta name="description" content="<?php echo $seometa['description'];?>" />
<meta name="twitter:card" content="summary_large_image" />
<meta property="og:title" content="<?php echo $seometa['title'];?>" />
<meta property="og:site_name" content="<?php echo $seometa['publisher'];?>" />
<meta property="og:author" content="<?php echo $seometa['creator'];?>" />
<meta property="og:type" content="<?php echo $seometa['type'];?>" />
<?php if($seometa['img']['src']) { ?>
<meta property="og:image" content="<?php echo $seometa['img']['src'];?>" />
<?php } ?>
<meta property="og:description" content="<?php echo $seometa['description'];?>" />
<meta property="og:url" content="<?php echo $seometa['url'];?>" />
<?php if($seometa['img']['src']) { ?>
<link rel="image_src" href="<?php echo $seometa['img']['src'];?>" />
<?php } ?>
<link rel="canonical" href="<?php echo $seometa['url'];?>" />
