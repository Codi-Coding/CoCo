<?php
include_once("./_common.php");

if ($is_admin != 'super') 
    die("최고관리자만 가능합니다.");

$it_id = trim($_GET['it_id']);
$it = sql_fetch(" select a.*, b.ca_name, b.ca_use from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b where a.it_id = '$it_id' ", false);

if (!$it['it_id']) 
    die("자료가 없습니다.");

if (!($it['ca_use'] && $it['it_use'])) {
    die("사용하는 분류와 발행된 자료만 신디케이션을 지원합니다.");

if (!$it['pt_syndi']) 
    die("신디케이션을 지원하지 않는 자료입니다.");

$author = '';
if($it['pt_id']) {
	$mb = get_member($it['pt_id'], 'mb_nick');
	$author = $mb['mb_nick'];
}

$author = ($author) ? $author : $config['cf_title'];

$title        = htmlspecialchars($it['it_name']);
$author       = htmlspecialchars($author);
$published    = date('Y-m-d\TH:i:s\+09:00', strtotime($it['it_time']));
$updated      = $published;
$link_href    = G5_SHOP_URL . "/list.php?ca_id=".$it['ca_id'];
$id           = G5_SHOP_URL . "/item.php?" . htmlspecialchars("it_id={$it['it_id']}");
$cf_title     = htmlspecialchars($config['cf_title']);
$link_title   = htmlspecialchars($it['ca_name']);
$feed_updated = date('Y-m-d\TH:i:s\+09:00', G5_SERVER_TIME);

$find         = array('&amp;', '&nbsp;'); # 찾아서
$replace      = array('&', ' '); # 바꾼다

$content      = str_replace( $find, $replace, $it['it_explan'] );
$summary      = str_replace( $find, $replace, strip_tags($it['it_explan']) );

Header("Content-type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<feed xmlns=\"http://webmastertool.naver.com\">\n";
echo "<id>" . G5_URL . "</id>\n";
echo "<title>naver syndication feed document</title>\n";
echo "<author>\n";
    echo "<name>webmaster</name>\n";
echo "</author>\n";

echo "<updated>{$feed_updated}</updated>\n";

echo "<link rel=\"site\" href=\"" . G5_URL . "\" title=\"{$cf_title}\" />\n";
echo "<entry>\n";
    echo "<id>{$id}</id>\n";
    echo "<title><![CDATA[{$title}]]></title>\n";
    echo "<author>\n";
        echo "<name>{$author}</name>\n";
    echo "</author>\n";
    echo "<updated>{$updated}</updated>\n";
    echo "<published>{$published}</published>\n";
    echo "<link rel=\"via\" href=\"{$link_href}\" title=\"{$link_title}\" />\n";
    echo "<link rel=\"mobile\" href=\"{$id}\" />\n";
    echo "<content type=\"html\"><![CDATA[{$content}]]></content>\n";
    echo "<summary type=\"text\"><![CDATA[{$summary}]]></summary>\n";
    echo "<category term=\"{$it['ca_id']}\" label=\"{$link_title}\" />\n";
echo "</entry>\n";
echo "</feed>";
?>