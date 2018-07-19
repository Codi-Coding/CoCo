<?php
$g5_path = '..'; // common.php 의 상대 경로
include_once($g5_path.'/common.php');
include_once(G5_LIB_PATH.'/apms.feed.lib.php');

// RSS 갯수
$rss_rows = $config['cf_page_rows'];

// 기본주소
if($id) {
	$default_link = G5_SHOP_URL.'/myshop.php?id='.$id;
} else if($cid) {
	$default_link = G5_SHOP_URL.'/list.php?ca_id='.$cid;
} else if($tid) {
	$default_link = G5_SHOP_URL.'/listtype.php?type='.$tid;
} else {
	$default_link = G5_SHOP_URL;
}

header('Content-type: text/xml');
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");

echo '<?xml version="1.0" encoding="utf-8" ?>'."\n";

?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
<title><?php echo specialchars_replace($config['cf_title']); ?></title>
<link><?php echo specialchars_replace($default_link); ?></link>
<description><?php echo ($xp['seo_desc']) ? specialchars_replace($xp['seo_desc']) : specialchars_replace($config['cf_title']); ?></description>
<language>ko</language>
<?php
$cate = array();
$author = array();

// 관리자 정보
$cf_author = apms_member($config['cf_admin']);

// where
if($id == $config['cf_admin']) { // 최고관리자는 자기꺼와 파트너아이디 없는 것 다 보여줌
	$sql_where = " and (pt_id = '' or pt_id = '{$id}')";
} else { // 파트너는 자기꺼만 보여줌
	$sql_where = " and pt_id = '{$id}'";
}

// 추출
$order_by = 'pt_num desc, it_id desc';
$where = "it_use = '1'";
if($id) $where .= $sql_where;
if($tid) $where .= " and it_type{$tid} = '1'";
if($cid) $where .= " and (ca_id like '{$cid}%' or ca_id2 like '{$cid}%' or ca_id3 like '{$cid}%')";

$result = sql_query(" select * from `{$g5['g5_shop_item_table']}` where $where order by $order_by limit 0, $rss_rows ");
for ($i=0; $row=sql_fetch_array($result); $i++) { 

	// 링크
	$link = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];

	// 이미지
	$img = apms_it_thumbnail($row, 600, 0, false, true);
	$rss_img = ($img['src']) ? '<p><img src="'.$img['src'].'" alt="'.$img['alt'].'" border=0></p>' : '';

	// 내용
	$rss_content = apms_cut_text($row['it_explan'], 300);

	if(!$row['pt_id'] || $row['pt_id'] == $config['cf_admin']) {
		$author['mb_nick'] = $cf_author['mb_nick'];
	} else {
		$author = get_member($row['pt_id'], 'mb_nick');
	}

	$date = ($row['pt_num']) ? $row['pt_num'] :  strtotime($row['it_time']);
	// rss 리더 스킨으로 호출하면 날짜가 제대로 표시되지 않음
	//$date = substr($date,0,10) . "T" . substr($date,11,8) . "+09:00";
	$date = date('r', $date);
?>
	<item>
	<title><?php echo specialchars_replace(apms_get_text($row['it_name'])); ?></title>
	<link><?php echo specialchars_replace($link); ?></link>
	<description><![CDATA[<?php echo conv_content($rss_img.$rss_content, 1); ?>]]></description>
	<dc:creator><?php echo specialchars_replace($author['mb_nick']); ?></dc:creator>
	<dc:date><?php echo $date ?></dc:date>
	</item>
<?php } ?>
</channel>
</rss>