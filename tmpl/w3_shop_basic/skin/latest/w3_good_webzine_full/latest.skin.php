<?php // 굿빌더 ?>
<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin, $config2w; /// config2w 2012.09.08

if($config2w['cf_head_long'] == "checked" or $config2w['cf_tail_long'] == "checked") { /// 임시 변수
   $image_width = $config2w[cf_width_main_total];
   /// $image_height = intval($image_width / 3);
   $image_height = "";
   $image_div_width = $image_width + 0;
} else {
   $image_width = $config2w[cf_width_main_total] / 2 - 1;
   /// $image_height = intval($image_width / 3);
   $image_height = "";
   $image_div_width = $image_width + 0;
}

$image_width = "1500";
$image_height = "800";
?>
<!-- 최신글용 스타일시트 -->
<!--
<link href="<?php echo $latest_skin_url?>/style.css" rel="stylesheet" type="text/css">
-->

<!-- 최신글 시작 -->
<!--
<div class="latestThumbF">
<div class="sideTable">
    <table width=100% border=0 cellspacing=0 cellpadding=0 style="margin:0px">
        <tr><td>
-->
<?php
for ($i=0; $i<count($list); $i++) {
    $org_img_path = G5_PATH."/data/file/$bo_table/".$list[$i][file][0][file];
    $org_img_url  = G5_URL."/data/file/$bo_table/".$list[$i][file][0][file];
    $img_path[$i] = $org_img_path;
    $img_url[$i]  = $org_img_url;
    $href = G5_BBS_URL."/board.php?bo_table=$bo_table&wr_id={$list[$i][wr_id]}";

    if (!file_exists($img_path[$i]) || !$list[$i][file][0][file]) {
        $img_path[$i] = "$latest_skin_path/img/no_image.gif";
        $img_url[$i]  = "$latest_skin_url/img/no_image.gif";
    }
?>
<!--
	<center><div class="latestIMG">
		<div style="width:<?php echo $image_div_width?>; overflow:hidden">--><!-- New -->
		<?php if($is_admin == "super") { ?><a href="<?php echo $href?>"><?php } ?>
		<?php if(preg_match("/\.(swf|wmv|asf|flv)$/i", $img_url[$i])) { ?>
		<script>doc_write(flash_movie('<?php echo $img_url[$i]?>', 'flash<?php echo $i?>', '<?php echo $image_width?>', '<?php echo $image_height?>', 'transparent'));</script>
		<?php } else { ?>
		<img class="w3-image" src="<?php echo $img_url[$i]?>" width="<?php echo $image_width?>" height="<?php echo $image_height; ?>" border="0" style="vertical-align:middle">
		<?php } ?>
		<?php if($is_admin == "super") { ?></a><?php } ?>
<!--
		</div>
        </div></center>
-->
<?php } ?>
<?php if (count($list) == 0) { ?>
        <div align=center><font color=#6a6a6a><?php echo _t('게시물이 없습니다.'); ?></font></div>
<?php } ?>
<!--
        </td></tr>
    </table>
</div>
</div>
-->
<!-- 최신글 끝 -->
