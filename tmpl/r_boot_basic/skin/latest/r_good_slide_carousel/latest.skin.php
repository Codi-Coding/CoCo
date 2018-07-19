<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if(gettype($options) == 'string') $options = explode('|', $options);
$imgwidth = $options[0]; //표시할 이미지의 가로사이즈
$imgheight = $options[1]; //표시할 이미지의 세로사이즈

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
/// add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<script src="<?php echo $latest_skin_url?>/js/carousel.js"></script>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="bs3carousel" style="margin-bottom: 20px;">
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php for ($i=0; $i<count($list); $i++) { ?>
                <?php
                if($i==0) {
                    $active = "class='active'";
                } 
                else {
                    $active = "";
                }
                echo "<li data-target=\"#carousel-example-generic\" data-slide-to=".$i." ".$active."></li>";
                ?>
        <?php }  ?>
        <?php if (count($list) == 0) { //게시물이 없을 때  ?>
            <li>게시물이 없습니다.</li>
        <?php }  ?>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php for ($i=0; $i<count($list); $i++) { ?>
            <?php if($i==0) {
                $item = "item";
                $active = "active";
            } 
            else {
                $item = "item";
                $active = "";
            }
            echo "<div class='".$item." ".$active."'>";
                echo "<a href='".$list[$i]['href']."'>";
                    
                        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $imgwidth, $imgheight);                                  
                        if($thumb['src']) {
                        $img_content = '<img class="img_left" src="'.$thumb['src'].'" alt="'._t($list[$i]['subject']).'" style="width: 100%; height: auto;">';
                        } else {
                        $img_content = 'NO IMAGE';
                        }                
                        echo $img_content;                                                             
                    
                echo "</a>";
                echo "<div class=\"carousel-caption\">";
                        echo "<h3 style=\"font-weight:bold;color:antiquewhite;\">"._t($list[$i]['subject'])."</h3>";
                echo  "</div></div>";
            ?>
        <?php } ?>
    </div>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div><!-- #carousel-example-generic -->
</div>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->
