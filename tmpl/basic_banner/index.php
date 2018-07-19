<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if($site_name == '') $site_name = $config['cf_title']; /// 2010.11.25
$index_title = trim("$site_name $index_title_comment ");

$g5['title'] = $index_title;
$main_page = 1; /// main, subpage 구분을 위해 추가.  2013.01.18
include_once(G5_TMPL_PATH.'/head.php');

// 좌측 사이드, 상단, 메인 시작
$width_main = $config2w['cf_width_main'];
$width_main_left = $config2w['cf_width_main_left'];
$width_main_right = $config2w['cf_width_main_right'];

/// 서브 페이지의 경우 레이아웃 조정
$hide_left = $config2w['cf_hide_left'];
$hide_right = $config2w['cf_hide_right'];

if(!$main_page) {
    if($hide_left) {
        $width_main += $width_main_left;
        $width_main_left = 0;
    }
    if($hide_right) {
        $width_main += $width_main_right;
        $width_main_right = 0;
    }
}
?>

<h2 class="sound_only"><?php echo _t('최신글'); ?></h2>
<!-- 최신글 시작 { -->

<!-- index페이지용 스타일시트 -->

<?php if(0) { ?>
<!-- 슬라이딩 메인 배너 -->
<table width="100%" border=0 cellspacing=0 cellpadding=0 style="margin:0;padding:0"><tr><td align=center>
<?php $options = array("740","214"); echo latest("good_main_gal", "gallery_main_ad", 5, 0, 1, $options);?>
</td></tr></table> 
<!--<br>
<br>-->
<?php } ?>
<table width=100% border=0 cellspacing=0 cellpadding=0 align=center style="margin-top:-7px"><tr><td align=left valign="top">

<?php
$width_main_half = ($width_main - 10) / 2;

for($i = 0; $i < $config2w['cf_max_main']; $i++) {

	if($config2w['cf_main_nouse_'.$i] == 'checked') continue;

	if($config2w['cf_main_name_'.$i] == '') continue;

	if($config2w['cf_main_long_'.$i] == "checked") {
		echo "
<table border=0 cellspacing=0 cellpadding=0 style=\"margin-left:0px;\">
<tr><td width=\"$width_main\" valign=\"top\">
<div class=\"{$config2w['cf_main_style_'.$i]}\">".call_name($config2w['cf_main_name_'.$i])."</div>
</td></tr>
</table>
";
	} else {
		echo "
<table border=0 cellspacing=0 cellpadding=0 style=\"margin-left:0px;\">
<tr><td width=\"$width_main_half\" valign=\"top\">
<div class=\"{$config2w['cf_main_style_'.$i]}\">".call_name($config2w['cf_main_name_'.$i])."</div>
</td><td width=10></td>
";
		$i++;
		echo "
<td width=\"$width_main_half\" valign=\"top\">
<div class=\"{$config2w['cf_main_style_'.$i]}\">".call_name($config2w['cf_main_name_'.$i])."</div>
</td></tr>
</table>
";
	}
}
?>

<!-- 메인 끝 -->
</td></tr></table>

<!-- } 최신글 끝 -->

<?php
include_once(G5_TMPL_PATH.'/tail.php');
?>
