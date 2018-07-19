<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<!-- 메인이미지 시작 { -->
<?php echo cm_display_banner('메인', 'mainbanner.10.skin.php'); ?>

<!-- } 메인이미지 끝 -->
<div id="cct_container">

<?php if($setting['de_type1_list_use']) { ?>
<!-- 추천상품 시작 { -->
<section class="cct_wrap">
    <header>
        <h2><a href="<?php echo G5_CONTENTS_URL; ?>/listtype.php?type=1"><?php echo _t('추천상품'); ?></a></h2>
    </header>
    <?php
    $list = new cm_item_list();
    $list->set_type(1);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_price', true);
    $list->set_view('it_sum_qty', true);
    $list->set_view('it_wish_qty', true);
    $list->set_view('it_icon', false);
    echo $list->run();
    ?>
</section>
<!-- } 추천상품 끝 -->
<?php } ?>

<?php if($setting['de_type2_list_use']) { ?>
<!-- 인기상품 시작 { -->
<section class="cct_wrap">
    <header>
        <h2><a href="<?php echo G5_CONTENTS_URL; ?>/listtype.php?type=2"><?php echo _t('인기상품'); ?></a></h2>
    </header>
    <?php
    $list = new cm_item_list();
    $list->set_type(2);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_price', true);
    $list->set_view('it_sum_qty', true);
    $list->set_view('it_wish_qty', true);
    $list->set_view('it_icon', false);
    echo $list->run();
    ?>
</section>
<!-- } 인기상품 끝 -->
<?php } ?>

<?php if($setting['de_type3_list_use']) { ?>
<!-- 최신상품 시작 { -->
<section class="cct_wrap">
    <header>
        <h2><a href="<?php echo G5_CONTENTS_URL; ?>/listtype.php?type=3"><?php echo _t('최신상품'); ?></a></h2>
    </header>
    <?php
    $list = new cm_item_list();
    $list->set_type(3);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_price', true);
    $list->set_view('it_sum_qty', true);
    $list->set_view('it_wish_qty', true);
    $list->set_view('it_icon', false);
    echo $list->run();
    ?>
</section>
<!-- } 최신상품 끝 -->
<?php } ?>

<?php if($setting['de_type4_list_use']) { ?>
<!-- 할인상품 시작 { -->
<section class="cct_wrap">
    <header>
        <h2><a href="<?php echo G5_CONTENTS_URL; ?>/listtype.php?type=4"><?php echo _t('할인상품'); ?></a></h2>
    </header>
    <?php
    $list = new cm_item_list();
    $list->set_type(4);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_price', true);
    $list->set_view('it_sum_qty', true);
    $list->set_view('it_wish_qty', true);
    $list->set_view('it_icon', false);
    echo $list->run();
    ?>
</section>
<!-- } 할인상품 끝 -->
<?php } ?>

</div> <!--cct_container end-->
