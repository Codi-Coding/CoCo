<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/apms.feed.lib.php');

$sql = " select gr_id, bo_subject, bo_page_rows, bo_read_level, bo_use_rss_view from {$g5['board_table']} where bo_table = '$bo_table' ";
$row = sql_fetch($sql);
$subj2 = specialchars_replace($row['bo_subject'], 255);
$lines = $row['bo_page_rows'];

// 비회원 읽기가 가능한 게시판만 RSS 지원
if ($row['bo_read_level'] >= 2) {
    echo '비회원 읽기가 가능한 게시판만 Feed를 지원합니다.';
    exit;
}

// RSS 사용 체크
if (!$row['bo_use_rss_view']) {
    echo 'Feed 보기가 금지되어 있습니다.';
    exit;
}

// Feed 동영상
$is_feedvideo = true;

$sql = " select gr_subject from {$g5['group_table']} where gr_id = '{$row['gr_id']}' ";
$row = sql_fetch($sql);
$subj1 = specialchars_replace($row['gr_subject'], 255);

header('Content-type: text/xml');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

echo '<?xml version="1.0" encoding="utf-8" ?>'."\n";

?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
<title><?php echo specialchars_replace($config['cf_title'].' &gt; '.$subj1.' &gt; '.$subj2) ?></title>
<link><?php echo specialchars_replace(G5_BBS_URL.'/board.php?bo_table='.$bo_table) ?></link>
<description><?php echo ($xp['seo_desc']) ? specialchars_replace($xp['seo_desc']) : specialchars_replace($config['cf_title'].' &gt; '.$subj1.' &gt; '.$subj2); ?></description>
<language>ko</language>
<?php
$sql = " select * from {$g5['write_prefix']}$bo_table where wr_is_comment = 0 and wr_option not like '%secret%' and as_shingo >= '0' order by wr_num, wr_reply limit 0, $lines ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {

	$view = get_view($row, $board, $board_skin_path);

    if (strstr($view['wr_option'], 'html'))
        $html = 1;
    else
        $html = 0;

	$view['wr_content'] = conv_content($view['wr_content'], $html);

	$file = $head_file = $tail_file = '';
	if($view['as_img'] == "2") { // 본문삽입
		$view['wr_content'] = preg_replace_callback("/{이미지\:([0-9]+)[:]?([^}]*)}/i", "conv_rich_content", $view['wr_content']);
	} else {
		for ($i=0; $i<=count($view['file']); $i++) {
			if ($view['file'][$i]['view']) {
				$file .='<p><img src="'.$view['file'][$i]['path'].'/'.$view['file'][$i]['file'].'"></p>';
			}
		}

		if($view['as_img'] == "1") {
			$head_file = $file;
		} else {
			$tail_file = $file;
		}
	}

?>
	<item>
	<title><?php echo specialchars_replace($view['wr_subject']) ?></title>
	<link><?php echo specialchars_replace(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$view['wr_id']) ?></link>
	<description><![CDATA[<?php echo $head_file; ?><?php echo conv_link_video($view['wr_link1']);?><?php echo conv_link_video($view['wr_link2']);?><?php echo $view['wr_content']; ?><?php echo $tail_file; ?>]]></description>
	<dc:creator><?php echo specialchars_replace($view['wr_name']) ?></dc:creator>
	<?php
	$date = $view['wr_datetime'];
	// rss 리더 스킨으로 호출하면 날짜가 제대로 표시되지 않음
	//$date = substr($date,0,10) . "T" . substr($date,11,8) . "+09:00";
	$date = date('r', strtotime($date));
	?>
	<dc:date><?php echo $date ?></dc:date>
	</item>
<?php } ?>
</channel>
</rss>