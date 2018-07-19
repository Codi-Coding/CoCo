<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_TMPL_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/good_group.lib.php'); /// New
include_once(G5_LIB_PATH.'/good_guide.lib.php'); /// New
include_once(G5_LIB_PATH.'/good_outnew.lib.php'); /// New
include_once(G5_LIB_PATH.'/good_outsearch.lib.php'); /// New
include_once(G5_LIB_PATH.'/good_sidemenu.lib.php'); /// New
?>

<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo _t($g5['title']) ?></h1>

    <div id="skip_to_container"><a href="#container"><?php echo _t('본문 바로가기'); ?></a></div>

    <?php if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
     } ?>

    <?php
        if(defined('_INDEX_')) echo latest('good_basic_popup', 'notice'); /// popup
    ?>

    <!--<aside id="hd_qnb">
        <h2>쇼핑몰 퀵메뉴</h2>
        <div>
            <a href="<?php echo G5_SHOP_URL; ?>/cart.php"><img src="<?php echo G5_TMPL_URL; ?>/img/hd_nb_cart.gif" alt="장바구니"></a>
            <a href="<?php echo G5_SHOP_URL; ?>/wishlist.php"><img src="<?php echo G5_TMPL_URL; ?>/img/hd_nb_wish.gif" alt="위시리스트"></a>
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php"><img src="<?php echo G5_TMPL_URL; ?>/img/hd_nb_deli.gif" alt="주문/배송조회"></a>
        </div>
    </aside>-->

    <div id="hd_wrapper">
        <?php if($config2w['cf_use_common_logo']) { ?>
        <div id="logo"><a href="<?php echo G5_URL; ?>/"><img src="<?php echo G5_IMG_URL ?>/shop_logo.png" alt="<?php echo _t($config['cf_title']); ?>"></a></div>
        <?php } else { ?>
        <div id="logo"><a href="<?php echo G5_URL; ?>/"><img src="<?php echo G5_TMPL_URL; ?>/images/logo.png" alt="<?php echo _t($config['cf_title']); ?>"></a></div>
        <?php } ?>

        <!--<div id="hd_sch">
            <h3>쇼핑몰 검색</h3>
            <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">

            <label for="sch_str" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required>
            <input type="submit" value="검색" id="sch_submit">

            </form>
            <script>
            function search_submit(f) {
                if (f.q.value.length < 2) {
                    alert("검색어는 두글자 이상 입력하십시오.");
                    f.q.select();
                    f.q.focus();
                    return false;
                }

                return true;
            }
            </script>
        </div>-->

        <div id="tnb">
            <h3><?php echo _t('회원메뉴'); ?></h3>
            <ul>
                <?php if ($is_member) { ?>
                <?php if ($is_admin) {  ?>
                <li><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/"><b><?php echo _t('관리자'); ?></b></a></li>
                <li><a href="<?php echo G5_ADMIN_URL ?>/builder/basic_tmpl_config_form.php"><b><?php echo _t('빌더관리'); ?></b></a></li>
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
                <li><a href="<?php echo G5_SHOP_URL; ?>"><?php echo _t('쇼핑몰'); ?></a></li>
                <?php if(!$default['de_root_index_use']) { ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/group.php?gr_id=board"><?php echo _t('커뮤니티'); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <hr>

    <?php if($g5['use_builder_menu']) { ?>
    <?php
    // 메뉴설정파일
    include_once(G5_TMPL_PATH."/menu/menu.php");
    include_once(G5_TMPL_PATH."/menu/menu_aux.php");
    ?>
    <nav id="gnb">
        <h2><?php echo _t('메인메뉴'); ?></h2>
        <ul id="gnb_1dul">
        <?php $gnb_zindex = 999; // gnb_1dli z-index 값 설정용 ?>
        <?php for($i = 0; $i < count($menu_list); $i++) { ?>
                <li class="gnb_1dli" style="z-index:<?php echo $gnb_zindex--; ?>">
                        <a href="<?php echo $menu_list[$i][1]?>" class="gnb_1da"><?php echo _t($menu_list[$i][0])?></a>
                        <?php if($i > 0) { ?>
                        <?php if(count($menu[$i]) > 0) { ?>
                        <ul class="gnb_2dul">
                        <?php for($j = 0; $j < count($menu[$i]); $j++) { ?>
                                <li class="gnb_2dli">
                                        <a href="<?php echo $menu[$i][$j][1]?>" class="gnb_2da"><?php echo _t($menu[$i][$j][0])?></a>
                                </li>
                        <?php } ?>
                        </ul>
                        <?php } ?>
                        <?php } ?>
                </li>
        <?php } ?>
        </ul>
    </nav>
    <?php } else { ?>
    <nav id="gnb">
        <h2><?php echo _t('메인메뉴'); ?></h2>
        <ul id="gnb_1dul">
            <?php
            $sql = " select *
                        from {$g5['menu_table']}
                        where me_use = '1'
                          and length(me_code) = '2'
                        order by me_order, me_id ";
            $result = sql_query($sql, false);
            $gnb_zindex = 999; // gnb_1dli z-index 값 설정용

            for ($i=0; $row=sql_fetch_array($result); $i++) {
                if(!preg_match('|^http://|', $row['me_link'])) $row['me_link'] = G5_URL.$row['me_link'];
            ?>
            <li class="gnb_1dli" style="z-index:<?php echo $gnb_zindex--; ?>">
                <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo _t($row['me_name']) ?></a>
                <?php
                $sql2 = " select *
                            from {$g5['menu_table']}
                            where me_use = '1'
                              and length(me_code) = '4'
                              and substring(me_code, 1, 2) = '{$row['me_code']}'
                            order by me_order, me_id ";
                $result2 = sql_query($sql2);

                for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                    if(!preg_match('|^http://|', $row2['me_link'])) $row2['me_link'] = G5_URL.$row2['me_link'];
                    if($k == 0)
                        echo '<ul class="gnb_2dul">'.PHP_EOL;
                ?>
                    <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo _t($row2['me_name']) ?></a></li>
                <?php
                }

                if($k > 0)
                    echo '</ul>'.PHP_EOL;
                ?>
            </li>
            <?php
            }

            if ($i == 0) {  ?>
                <li id="gnb_empty"><?php echo _t('메뉴 준비 중입니다.'); ?><?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php"><?php echo _t('관리자모드').' &gt; '._t('환경설정').' &gt; '._t('메뉴설정'); ?></a><?php echo _t('에서 설정하실 수 있습니다.'); ?><?php } ?></li>
            <?php } ?>
        </ul>
    </nav>
    <?php } /// if else ?>

</div>

<div id="wrapper">

    <?php include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>

    <div id="aside">
        <?php ///echo outsearch("good_shop_basic_no_top_pad"); ?>
        <?php echo outsearch("good_search_all"); ?>

        <?php echo outlogin('good_shop_basic'); // 아웃로그인 ?>

        <?php include_once(G5_SHOP_SKIN_PATH.'/boxcategory.skin.php'); // 상품분류 ?>

        <?php include_once(G5_SHOP_SKIN_PATH.'/boxcart.skin.php'); // 장바구니 ?>

        <?php include_once(G5_SHOP_SKIN_PATH.'/boxwish.skin.php'); // 위시리스트 ?>

        <?php include_once(G5_SHOP_SKIN_PATH.'/boxevent.skin.php'); // 이벤트 ?>

        <?php $box_gr_id = 'board'; include_once(G5_SHOP_SKIN_PATH.'/boxcommunitygroup.skin.php'); // 커뮤니티 ?>

        <!-- 쇼핑몰 배너 시작 { -->
        <?php echo display_banner('왼쪽'); ?>
        <!-- } 쇼핑몰 배너 끝 -->
    </div>
<!-- } 상단 끝 -->

    <!-- 콘텐츠 시작 { -->
    <div id="container">
        <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><div id="wrapper_title"><?php echo _t($g5['title']) ?></div><?php } ?>
        <!-- 글자크기 조정 display:none 되어 있음 시작 { -->
        <div id="text_size">
            <button class="no_text_resize" onclick="font_resize('container', 'decrease');"><?php echo _t('작게'); ?></button>
            <button class="no_text_resize" onclick="font_default('container');"><?php echo _t('기본'); ?></button>
            <button class="no_text_resize" onclick="font_resize('container', 'increase');"><?php echo _t('크게'); ?></button>
        </div>
        <!-- } 글자크기 조정 display:none 되어 있음 끝 -->
