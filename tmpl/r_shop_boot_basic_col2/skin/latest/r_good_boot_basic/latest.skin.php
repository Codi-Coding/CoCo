<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-9">
                    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo _t($bo_subject); ?></a>
                </div>
                <div class="col-lg-3 add_moreright">
                    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>">
                    <span class="sound_only"><?php echo _t($bo_subject) ?></span> more
                    </a>                
                </div>               
            </div>
        </div>
        <div class="panel-body">
            <ul>
            <?php for ($i=0; $i<count($list); $i++) {  ?>
                <li>
                <?php
                //echo $list[$i]['icon_reply']." ";
                echo "<a href=\"".$list[$i]['href']."\">";
                echo _t($list[$i]['subject']);
                if ($list[$i]['comment_cnt'])
                    echo $list[$i]['comment_cnt'];
    
                echo "</a>";
    
                // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
                // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }
    
                echo "&nbsp;";
                if (isset($list[$i]['icon_new'])) echo " " . $list[$i]['icon_new'];
                if (isset($list[$i]['icon_hot'])) echo " " . $list[$i]['icon_hot'];
                if (isset($list[$i]['icon_file'])) echo " " . $list[$i]['icon_file'];
                if (isset($list[$i]['icon_link'])) echo " " . $list[$i]['icon_link'];
                if (isset($list[$i]['icon_secret'])) echo " " . $list[$i]['icon_secret'];
                 ?>
                </li>
                <?php }  ?>
                <?php 
                if($i < 4 && count($list) != 0) {
                    for ($i; $i<$rows; $i++) {                    
                        echo "<li></li>";
                    }                    
                }
                if (count($list) == 0) { //게시물이 없을 때
                    for ($i=0; $i<$rows; $i++) {
                        if ($i==0)  echo "<li>게시물이 없습니다.</li>";
                        else echo "<li></li>";
                    }  
                }                
                ?>
            </ul>            
        </div>
    </div>    
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->
