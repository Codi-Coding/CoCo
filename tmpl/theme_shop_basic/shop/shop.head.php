<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>

<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div id="skip_to_container"><a href="#container"><?php echo _t('본문 바로가기'); ?></a></div>

    <?php if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
     } ?>

    <aside id="hd_qnb">
        <h2><?php echo _t('쇼핑몰 퀵메뉴'); ?></h2>
        <div>
            <a href="<?php echo G5_SHOP_URL; ?>/cart.php"><img src="<?php echo G5_SHOP_URL; ?>/img/hd_nb_cart.gif" alt="<?php echo _t('장바구니'); ?>"></a>
            <a href="<?php echo G5_SHOP_URL; ?>/wishlist.php"><img src="<?php echo G5_SHOP_URL; ?>/img/hd_nb_wish.gif" alt="<?php echo _t('위시리스트'); ?>"></a>
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php"><img src="<?php echo G5_SHOP_URL; ?>/img/hd_nb_deli.gif" alt="<?php echo _t('주문/배송조회'); ?>"></a>
        </div>
    </aside>

    <div id="hd_wrapper">
        <div id="logo"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_THEME_IMG_URL; ?>/shop_logo.png" alt="<?php echo $config['cf_title']; ?>"></a></div>

        <div id="hd_sch">
            <h3><?php echo _t('쇼핑몰 검색'); ?></h3>
            <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">

            <label for="sch_str" class="sound_only"><?php echo _t('검색어'); ?><strong class="sound_only"> <?php echo _t('필수'); ?></strong></label>
            <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required>
            <input type="submit" value="<?php echo _t('검색'); ?>" id="sch_submit">

            </form>
            <script>
            function search_submit(f) {
                if (f.q.value.length < 2) {
                    alert("<?php echo _t('검색어는 두글자 이상 입력하십시오.'); ?>");
                    f.q.select();
                    f.q.focus();
                    return false;
                }

                return true;
            }
            </script>
        </div>

        <div id="tnb">
            <h3><?php echo _t('회원메뉴'); ?></h3>
            <ul>
                <?php if ($is_member) { ?>
                <?php if ($is_admin) {  ?>
                <li><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/"><b><?php echo _t('관리자'); ?></b></a></li>
                <?php }  ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><?php echo _t('정보수정'); ?></a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop"><?php echo _t('로그아웃'); ?></a></li>
                <?php } else { ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/register.php"><?php echo _t('회원가입'); ?></a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><b><?php echo _t('로그인'); ?></b></a></li>
                <?php } ?>
                <li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php"><?php echo _t('마이페이지'); ?></a></li>
                <li><a href="<?php echo G5_SHOP_URL; ?>/couponzone.php"><?php echo _t('쿠폰존'); ?></a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/faq.php"><?php echo _t('FAQ'); ?></a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/qalist.php"><?php echo _t('1:1문의'); ?></a></li>
                <li><a href="<?php echo G5_SHOP_URL; ?>/personalpay.php"><?php echo _t('개인결제'); ?></a></li>
                <li><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php"><?php echo _t('사용후기'); ?></a></li>
                <?php if(G5_COMMUNITY_USE) { ?>
                <li><a href="<?php echo G5_URL; ?>/"><?php echo _t('커뮤니티'); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

</div>

<div id="wrapper">

    <?php include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>

    <div id="aside">
        <?php echo outlogin('theme/shop_basic'); // 아웃로그인 ?>

        <?php include_once(G5_SHOP_SKIN_PATH.'/boxcategory.skin.php'); // 상품분류 ?>

        <?php include_once(G5_SHOP_SKIN_PATH.'/boxcart.skin.php'); // 장바구니 ?>

        <?php include_once(G5_SHOP_SKIN_PATH.'/boxwish.skin.php'); // 위시리스트 ?>

        <?php include_once(G5_SHOP_SKIN_PATH.'/boxevent.skin.php'); // 이벤트 ?>

        <?php include_once(G5_SHOP_SKIN_PATH.'/boxcommunity.skin.php'); // 커뮤니티 ?>

        <!-- 쇼핑몰 배너 시작 { -->
        <?php echo display_banner('왼쪽'); ?>
        <!-- } 쇼핑몰 배너 끝 -->
    </div>
<!-- } 상단 끝 -->

    <!-- 콘텐츠 시작 { -->
    <div id="container">
        <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><div id="wrapper_title"><?php echo $g5['title'] ?></div><?php } ?>
        <!-- 글자크기 조정 display:none 되어 있음 시작 { -->
        <div id="text_size">
            <button class="no_text_resize" onclick="font_resize('container', 'decrease');"><?php echo _t('작게'); ?></button>
            <button class="no_text_resize" onclick="font_default('container');"><?php echo _t('기본'); ?></button>
            <button class="no_text_resize" onclick="font_resize('container', 'increase');"><?php echo _t('크게'); ?></button>
        </div>
        <!-- } 글자크기 조정 display:none 되어 있음 끝 -->
