<?php
include_once("./_common.php");

if($wr_id && $bo_table) { $meta_post_content = sql_fetch("select wr_subject, wr_content, wr_name, wr_datetime from g5_write_{$bo_table} where wr_id = '$wr_id' limit 1"); }

/// setup
$site_name    = $config['cf_title'];
$site_hellow  = $config['cf_5'];
$default_key  = $config['cf_4'];
$copy_right   = $config['cf_3'];
$copy_righter = $config['cf_6'];
$site_description = $config['cf_5'];
$site_url     = G5_URL;

$facebook_appid = $config['cf_facebook_appid'];
$sns_icon_img = ""; // 트위터, 페이스북 공유 이미지 주소
$metoday_tags = $config['cf_4'];
/// end of setup

if($meta_post_content) {
	$view['wr_name'] = "이 게시물에 대한 모든 저작권은 작성자에게 있습니다. ( 작성자: ".$meta_post_content['wr_name']." )";
	$view['author'] = $meta_post_content['wr_name'];
	$post_key = conv_subject(strip_tags($meta_post_content['wr_subject'].$meta_post_content['wr_content']),500);
	$is_meta_author_data = $meta_post_content['wr_datetime'];
	
}

if($board['bo_subject'] || $meta_post_content['wr_content']) {
	if(!$meta_post_content) {
		$view['meta_description'] = "$site_name  > 게시판 > {$board['bo_subject']}  ($page 페이지)";	
	} else {
		$view['meta_description'] = str_replace("\r\n"," ",conv_subject($site_name . " > ".$board['bo_subject']." | ".strip_tags($meta_post_content['wr_content']), 500));
	}
	
	if($wr_id == "0" ) { unset($wr_id); } 
	$view['meta_canonical'] = $site_url."/"."$bo_table/$wr_id"; // 게시물의 짧은주소 (트래백주소)
}

$keywords = str_replace(array("\r\n","!","@","#","$"," "), ",", $default_key.",".$post_key);
$keywords = str_replace(array("&nbsp;"), "", $keywords);
$keywords = array_unique(explode(",", $keywords));
$keywords = array_filter(array_map('trim', $keywords));
$keywords = implode(",", $keywords);

$g5_head_title = (!$g5_head_title) ? $site_hellow : $g5_head_title;
$meta_subject  = (!$g5_head_title) ? $site_hellow : $g5_head_title;
$meta_title    = (!$g5_head_title) ? $site_hellow : $g5_head_title;
$meta_copyright = (!$view['wr_name']) ? $copy_right : $view['wr_name'];
$meta_author   = (!$view['wr_name']) ? $copy_righter : $view['author'];
$meta_keywords = $keywords;

$meta_description  = (!$view['meta_description']) ? $site_description.$default_key : str_replace(array("&nbsp;","\r\n"),"",$view['meta_description']);
$meta_distribution = "Global";
$meta_canonical    = (!$view['meta_canonical']) ? 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : $view['meta_canonical'];
?>
<!-- 검색로봇 -->
<meta name="Location"		content="KR">
<meta name="subject"		content="<?php echo $meta_subject; //페이지 주제 ?>" />
<meta name="title"		content="<?php echo $meta_title; //페이지 제목 ?>" />
<meta name="copyright"		content="<?php echo $meta_copyright; //저작권 ?>" />
<meta name="author"		content="<?php echo $meta_author; //작성자 ?>">
<meta name="keywords"		content="<?php echo $meta_keywords; //페이지 키워드 ?>" />
<meta name="description" 	content="<?php echo $meta_description; //페이지 요약설명 ?>" />
<meta name="distribution"	content="<?php echo $meta_distribution; //배포자 ?>" />
<meta name="publisher"		content="<?php echo $copy_righter; //페이지의 공급자 ?>" />
<meta name="robots" 		content="index,follow" />
<link rel="canonical" 		href="<?php echo $meta_canonical; ?>">
<?php
if($is_meta_author_data) { // 작성일
	echo "<meta name='author-date(date)' content='$is_meta_author_data'/>";
}
?>
<!-- 트위터 -->
<meta name="twitter:card"	content="summary">
<meta name="twitter:title"	content="<?php echo $meta_title; //페이지 제목 ?>">
<meta name="twitter:site"	content="<?php echo $site_name; //사이트 이름 ?>">
<meta name="twitter:creator"	content="<?php echo $meta_author; //작성자 ?>">
<meta name="twitter:image"	content="<?php echo $sns_icon_img; //썸네일 이미지 ?>">
<meta name="twitter:description"	content="<?php echo $meta_title; //페이지 제목 ?>">
<!-- 페이스북 -->
<meta property="og:title"	content="<?php echo $meta_title; //페이지 제목 ?>"/>
<meta property="og:type"	content="website"/>
<meta property="og:site_name"	content="<?php echo $site_name; //사이트 이름 ?>"/> 
<meta property="fb:app_id"	content="<?php echo $facebook_appid; //페이스북 앱 아이디 ?>"/>
<meta property="og:image"	content="<?php echo $sns_icon_img; //썸네일 이미지 ?>"/>
<meta property="og:url"		content="<?php echo $meta_canonical; //페이지 주소 ?>"/>
<meta property="og:description"	content="<?php echo $meta_title; //페이지 제목 ?>"/>
<!-- 미투데이 -->
<meta property="me2:post_body"	content="<?php echo $meta_title; //페이지 제목 ?>"/>
<meta property="me2:post_tag"	content="<?php echo $metoday_tags.",".$meta_canonical; ?>"/>
<meta property="me2:image"	content="<?php echo $sns_icon_img; //썸네일 이미지 ?>"/>
<!-- Google -->
<meta itemprop="name"		content="<?php echo $meta_title; //페이지 제목 ?>">
<meta itemprop="description"	content="<?php echo $meta_description; //페이지 요약설명 ?>">
<meta itemprop="image"		content="<?php echo $sns_icon_img; //썸네일 이미지 ?>">
