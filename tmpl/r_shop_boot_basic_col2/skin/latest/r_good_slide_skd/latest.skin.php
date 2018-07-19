<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if(gettype($options) == 'string') $options = explode('|', $options);
$image_width  = $options[0];
$image_height = $options[1];
$demo_type    = $options[2] ? $options[2] : 'full';
$show_type    = $options[3] ? $options[3] : 'sliding';
$speed        = $options[4] ? $options[4] : '1000';
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
/// add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>

<!-- <script src="http://code.jquery.com/jquery.js"></script> -->
<script src="<?php echo $latest_skin_url?>/slider/skdslider.min.js"></script>
<link href="<?php echo $latest_skin_url?>/slider/skdslider.css" rel="stylesheet">
<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#full').skdslider({delay:5000, animationSpeed: <?php echo $speed; ?>,showNextPrev:true,showPlayButton:true,autoSlide:true,animationType:'<?php echo $show_type; ?>'});
			jQuery('#fixed').skdslider({delay:5000, animationSpeed: <?php echo $speed; ?>,showNextPrev:true,showPlayButton:false,autoSlide:true,animationType:'<?php echo $show_type; ?>'});
			
			jQuery('#responsive').change(function(){
			  $('#responsive_wrapper').width(jQuery(this).val());
			  $(window).trigger('resize');
			});
			
		});
</script>

<?php if($demo_type == 'full') { ?>
<div class="skdslider">
<ul id="full" class="slides">
    <?php for ($i=0; $i<count($list); $i++) { ?>
    <li>
        <a href="<?php echo $list[$i]['href'] ?>">
        <?php
        if ($list[$i]['is_notice']) { // 공지사항  ?>
            <strong style="width:<?php echo $image_width ?>px;height:<?php echo $image_height ?>px">공지</strong>
        <?php } else {
            $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $image_width, $image_height);

            if($thumb['src']) {
                $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
            } else {
                $img_content = '<span style="width:'.$image_width.'px;height:'.$image_height.'px">no image</span>';
            }

            echo $img_content;
        }
         ?>
        </a>
    </li>
    <?php } ?>
</ul>
</div>
<?php } else if($demo_type == 'fixed') { ?>
<div id="responsive_wrapper" style="max-width:<?php echo $image_width; ?>px;margin:0 auto;">
<ul id="fixed">
    <?php for ($i=0; $i<count($list); $i++) { ?>
    <li>
        <a href="<?php echo $list[$i]['href'] ?>">
        <?php
        if ($list[$i]['is_notice']) { // 공지사항  ?>
            <strong style="width:<?php echo $image_width ?>px;height:<?php echo $image_height ?>px">공지</strong>
        <?php } else {
            $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $image_width, $image_height);

            if($thumb['src']) {
                $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
            } else {
                $img_content = '<span style="width:'.$image_width.'px;height:'.$image_height.'px">no image</span>';
            }

            echo $img_content;
        }
         ?>
        </a>
        <!--<div class="slide-desc">
            <h2><?php echo _t($list[$i]['subject'])?></h2>
            <p><?php echo conv_content($list[$i]['wr_content'], 0)?> <a class="more" href="<?php echo $list[$i]['href'] ?>">더보기</a></p>
        </div>-->
    </li>
    <?php } ?>
</ul>
</div>
<?php } ?>
