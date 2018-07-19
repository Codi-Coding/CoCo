<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if(gettype($options) == 'string') $options = explode('|', $options);
$img_width  = $options[0];
$img_height = $options[1];
if(!$img_width) $img_width   = 480; //이미지 가로 크기
if(!$img_height) $img_height = 140; //이미지 세로 크기

add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/pgwslider.css">', 0);
?>

<div>
<ul class="pgwSlider">
    <?php for ($i = 0; $i < count($list); $i++) { ?>
    <li>
        <a href="<?php echo $list[$i]['href']?>">
        <?php
        $img = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $img_width, $img_height);
        $no_img = "$latest_skin_url/img/noimg.gif";

        if($img['src']) {
            $img_src = '<img src="'.$img['src'].'" alt="'._t($list[$i]['subject']).'">';
        } else {
            $img_src = '<img src="'.$no_img.'" width="'.$img_width.'" height="'.$img_height.'" alt=".'._t('이미지없음').'" title="" />';
        }
        echo $img_src;
	?>
        </a>
    </li>
    <?php } ?> 
</ul>
</div>

<script src="<?php echo $latest_skin_url?>/pgwslider.js"></script>
<script>
$(document).ready(function() {
    $('.pgwSlider').pgwSlider();
});
</script>
