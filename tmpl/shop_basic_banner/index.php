<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if($site_name == '') $site_name = $config['cf_title']; /// 2010.11.25
$index_title = trim("$site_name $index_title_comment ");

$g5['title'] = $index_title;
$main_page = 1; /// main, subpage 구분을 위해 추가.  2013.01.18
include_once(G5_TMPL_PATH.'/head.php');
?>

<!-- 메인이미지 시작 { -->
<?php echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
<!-- } 메인이미지 끝 -->

<!-- 슬라이딩 메인 배너 -->
<table width="100%" border=0 cellspacing=0 cellpadding=0 style="margin:0;padding:0"><tr><td align=center>
<?php $options = array("740","281"); echo latest("good_main_gal", "gallery_main_ad", 5, 0, 1, $options);?>
<?php //$options = array("740","214"); echo latest("good_gallery_banner", "gallery_main_ad", 5, 0, 1, $options);?>
</td></tr></table> 
<!--<br>-->

<?php if($default['de_type1_list_use']) { ?>
<!-- 히트상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1"><?php echo _t('히트상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('히트상품 모음'); ?></p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(1);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
</section>
<!-- } 히트상품 끝 -->
<?php } ?>

<?php if($default['de_type2_list_use']) { ?>
<!-- 추천상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2"><?php echo _t('추천상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('추천상품 모음'); ?></p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(2);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
</section>
<!-- } 추천상품 끝 -->
<?php } ?>

<?php if($default['de_type3_list_use']) { ?>
<!-- 최신상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3"><?php echo _t('최신상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('최신상품 모음'); ?></p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(3);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
</section>
<!-- } 최신상품 끝 -->
<?php } ?>

<?php if($default['de_type4_list_use']) { ?>
<!-- 인기상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4"><?php echo _t('인기상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('인기상품 모음'); ?></p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(4);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
</section>
<!-- } 인기상품 끝 -->
<?php } ?>

<?php if($default['de_type5_list_use']) { ?>
<!-- 할인상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5"><?php echo _t('할인상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('할인상품 모음'); ?></p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(5);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
</section>
<!-- } 할인상품 끝 -->
<?php } ?>

<?php if(0) { ?>
<!-- 커뮤니티 최신글 시작 { -->
<section id="sidx_lat">
    <h2><?php echo _t('커뮤니티 최신글'); ?></h2>
    <?php echo latest('shop_basic_old', 'notice', 5, 30); ?>
    <?php echo latest('shop_basic_old', 'free', 5, 25); ?>
    <?php echo latest('shop_basic_old', 'qna', 5, 20); ?>
</section>
<!-- } 커뮤니티 최신글 끝 -->

<?php echo poll('shop_basic_old'); // 설문조사 ?>

<?php echo visit('shop_basic_old'); // 접속자 ?>
<?php } ?>

<?php
include_once(G5_TMPL_PATH.'/tail.php');
?>
