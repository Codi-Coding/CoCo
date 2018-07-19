<?
// m3 google sitemap ver 1.23 by mahler83 2009-11-16
// please give feedbacks to bomool.net
include_once("./_common.php");

$charset = $g5[charset];
$url = G5_URL;

header("Content-type: text/xml;charset=\"UTF-8\"");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?
$query = sql_query("select bo_table from `$g5[board_table]` where bo_read_level='1'");
while($temp = sql_fetch_array($query)) {
	$bo_arr[] = $temp[bo_table];
}

$i = 1;
foreach($bo_arr as $bo) {
	// list of bo_table
	echo "<url>\n";
	echo "<loc>$url/bbs/board.php?bo_table=$bo</loc>\n";
	$temp = sql_fetch("select wr_datetime from `$g5[write_prefix]$bo` order by wr_datetime DESC");
	$lastmod = str_replace(" ", "T", substr($temp[wr_datetime], 0, 30))."+00:00";
	
	// if 
	if(!$lastmod || strlen($lastmod) < 25 || strcmp($lastmod, "+00:00")) $lastmod = "2014-10-10T00:00:00+00:00";
	
	echo "<lastmod>$lastmod</lastmod>\n";
	echo "<changefreq>daily</changefreq>\n";
	echo "<priority>0.9</priority>\n";
	echo "</url>\n";

	$query = sql_query("select wr_id, wr_datetime from `$g5[write_prefix]$bo` where wr_is_comment='0' AND wr_option NOT LIKE '%secret%'");
	while($row = sql_fetch_array($query)) {
		// list of each article
		echo "<url>";
		echo "<loc>$url/bbs/board.php?bo_table=$bo&amp;wr_id=$row[wr_id]</loc>";
		$temp = sql_fetch("select wr_datetime from `$g5[write_prefix]$bo` where wr_parent='$row[wr_id]' order by wr_id DESC");
		$lastmod = str_replace(" ", "T", substr($temp[wr_datetime], 0, 30))."+00:00";
		if(!$lastmod) {
			$temp = sql_fetch("select wr_datetime from `$g5[write_prefix]$bo` where wr_id='$row[wr_id]'");
			$lastmod = str_replace(" ", "T", substr($temp[wr_datetime], 0, 30))."+00:00";
		}
		if(!$lastmod) $lastmod = $g5[time_ymd];
		echo "<lastmod>$lastmod</lastmod>";
		echo "<changefreq>weekly</changefreq>";
		echo "<priority>0.5</priority>";
		echo "</url>\n";
	}
	$i++;
}
?>
</urlset>
