<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');

?>

<script src="<?php echo G5_JS_URL; ?>/swipe.js"></script>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.main.js"></script>

<?php echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
<?php
if (!$_COOKIE['ck_top_banner_close'])
    echo display_banner( '왼쪽');
?>

<div id="sidx">
    <?php include_once(G5_MSHOP_SKIN_PATH.'/main.event.skin.php'); // 이벤트 ?>

        <div class="sct-size"> 
            <button type="button" class="btn-size" id="btn-big">이미지크게보기</button>
            <button type="button" class="btn-size active" id="btn-small">이미지작게보기</button>
        </div>
        <?php if($default['de_mobile_type1_list_use']) { ?>
        <div class="sct_wrap">
            <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1">HIT ITEM</a></h2>
            <?php
            $list = new item_list();
            $list->set_mobile(true);
            $list->set_type(1);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_cust_price', true);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', true);
            $list->set_view('sns', false);
            echo $list->run();
            ?>
        </div>
        <?php } ?>

        <?php if($default['de_mobile_type2_list_use']) { ?>
        <div class="sct_wrap">
            <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2">RECOMMEND ITEM</a></h2>
            <?php
            $list = new item_list();
            $list->set_mobile(true);
            $list->set_type(2);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_cust_price', false);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', true);
            $list->set_view('sns', false);
            echo $list->run();
            ?>
        </div>
        <?php } ?>

        <?php if($default['de_mobile_type3_list_use']) { ?>
        <div class="sct_wrap">
            <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3">NEW ITEM</a></h2>
            <?php
            $list = new item_list();
            $list->set_mobile(true);
            $list->set_type(3);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_cust_price', true);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', true);
            $list->set_view('sns', false);
            echo $list->run();
            ?>
        </div>
        <?php } ?>

        <?php if($default['de_mobile_type4_list_use']) { ?>
        <div class="sct_wrap">
            <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4">BEST ITEM</a></h2>
            <?php
            $list = new item_list();
            $list->set_mobile(true);
            $list->set_type(4);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_cust_price', true);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', true);
            $list->set_view('sns', false);
            echo $list->run();
            ?>
        </div>
        <?php } ?>
        <?php if($default['de_mobile_type5_list_use']) { ?>
        <div class="sct_wrap">
            <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5">SALE ITEM</a></h2>
            <?php
            $list = new item_list();
            $list->set_mobile(true);
            $list->set_type(5);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_cust_price', true);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', false);
            $list->set_view('sns', false);
            echo $list->run();
            ?>
        </div>
        <?php } ?>

        
        <!-- 메인리뷰-->
        <?php
        // 상품리뷰
        $sql = " select a.is_id, a.is_subject, a.is_content, a.it_id, b.it_name
                    from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id)
                    where a.is_confirm = '1'
                    order by a.is_id desc
                    limit 0,10 ";
        $result = sql_query($sql);

        for($i=0; $row=sql_fetch_array($result); $i++) {
            if($i == 0) {
                echo '<div id="idx_review" class="sct_wrap">'.PHP_EOL;
                echo '<h2><a href="'.G5_SHOP_URL.'/itemuselist.php">REVIEW</a></h2>'.PHP_EOL;
                echo '<div class="review owl-carousel">'.PHP_EOL;
            }

            $review_href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
        ?>
            <div class="rv_li rv_<?php echo $i;?>">
                <div class="li_wr">
                    <a href="<?php echo $review_href; ?>" class="rv_img"><?php echo get_itemuselist_thumbnail($row['it_id'], $row['is_content'], 300, 350); ?></a>
                    <div class="txt_wr">
                        <span class="rv_tit"><?php echo get_text(cut_str($row['is_subject'], 20)); ?></span>
                        <a href="<?php echo $review_href; ?>" class="rv_prd"><?php echo $row['it_name']; ?></a>
                        <p><?php echo get_text(cut_str(strip_tags($row['is_content']), 90), 1); ?></p>
                    </div>
                </div>
            </div>
        <?php
        }

        if($i > 0) {
            echo '</div>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        }
        ?>
        <!-- 메인리뷰-->
        <script>
        $(function(){    
        $('#idx_review .review').owlCarousel({
            loop:true,
            margin:15,
            nav:true,
            autoplay:true,
            responsive:{
                0:{
                    items:1
                },
                430:{
                    items:2
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        })
        });
        </script>


</div>


<script>

    $(".sct-size  button").click(function () {
        $(".sct-size  button").removeClass("active");
        $(this).addClass("active");
    });
    $("#btn-small").click(function () {
        $(".sct_wrap").removeClass("big").addClass("small");
    });
    $("#btn-big").click(function () {
        $(".sct_wrap").removeClass("small").addClass("big");
    });

$("#container").removeClass("container").addClass("idx-container");
</script>

<?php
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>