<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if(gettype($options) == 'string') $options = explode('|', $options);
$img_width    = $options[0];
$img_height   = $options[1];
$video_width  = $options[2];
$video_height = $options[3];
$video_play   = $options[4];
if(!$img_width) $img_width       = 480; //이미지 가로 크기
if(!$img_height) $img_height     = 140; //이미지 세로 크기
if(!$video_width) $video_width   = 728; //비디오 가로 크기 (본래 크기: 640)
if(!$video_height) $video_height = 360; //비디오 세로 크기

add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/jquery.bxslider.css">', 0);
?>

<div>
<ul class="bx-wrapper">
    <?php for ($i = 0; $i < count($list); $i++) { ?>
    <li>
        <?php if($video_play and $list[$i]['wr_link1']) { ?>
        <iframe width="<?php echo $video_width?>" height="<?php echo $video_height?>" src="<?php echo $list[$i]['wr_link1']?>?feature=player_embedded" frameborder="0" allowfullscreen></iframe>
        <?php } else { ?>
        <a href="<?php echo $list[$i]['href']?>">
        <?php
        $img = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $img_width, $img_height);
        $no_img = "$latest_skin_url/img/noimg.gif";

        if($img['src']) {
            $img_src = '<img src="'.$img['src'].'" alt="'._t($list[$i]['subject']).'">';
        } else {
            $img_src = '<img src="'.$no_img.'" width="'.$img_width.'" height="'.$img_height.'" alt="'._t('이미지없음').'" title="" />';
        }
        echo $img_src;
	?>
        </a>
        <?php } ?>
    </li>
    <?php } ?> 
</ul>
</div>

<script src="<?php echo $latest_skin_url?>/jquery.bxslider.js"></script>
<script src="<?php echo $latest_skin_url?>/plugins/jquery.fitvids.js"></script>
<script>
$(document).ready(function(){
  $('.bx-wrapper').bxSlider();
});
</script>
