<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_MOBILE_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>

<header id="hd">
    <?php if ((!$bo_table || $w == 's' ) && defined('_INDEX_')) { ?><h1><?php echo $config['cf_title'] ?></h1><?php } ?>

    <div id="skip_to_container"><a href="#container"><?php echo _t('본문 바로가기'); ?></a></div>

    <?php if(defined('_INDEX_')) { // index에서만 실행
        include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
    } ?>
    <ul id="hd_tnb">
        <?php if ($is_member) { ?>
        <?php if ($is_admin) {  ?>
        <li><a href="<?php echo G5_ADMIN_URL ?>/shop_admin/"><b><?php echo _t('관리자'); ?></b></a></li>
        <?php } else { ?>
        <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><?php echo _t('정보수정'); ?></a></li>
        <?php } ?>
        <li><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop"><?php echo _t('LOGOUT'); ?></a></li>
        <?php } else { ?>
        <li><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><?php echo _t('LOGIN'); ?></a></li>
        <li><a href="<?php echo G5_BBS_URL ?>/register.php" id="snb_join"><?php echo _t('JOIN'); ?></a></li>

        <?php } ?>
        <li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php"><?php echo _t('MY PAGE'); ?></a></li>
        <li><a href="<?php echo G5_SHOP_URL; ?>/cart.php" class="tnb_cart"><span></span><?php echo _t('CART'); ?></a></li>


    </ul>
    <div id="logo"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_DATA_URL; ?>/common/mobile_logo_img" alt="<?php echo $config['cf_title']; ?> <?php echo _t('메인'); ?>"></a></div>

    <?php include_once(G5_THEME_MSHOP_PATH.'/category.php'); // 분류 ?>

    <button type="button" id="hd_sch_open"><?php echo _t('검색'); ?><span class="sound_only"> <?php echo _t('열기'); ?></span></button>

    <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
    <aside id="hd_sch">
        <div class="sch_inner">
            <h2><?php echo _t('상품 검색'); ?></h2>
            <label for="sch_str" class="sound_only"><?php echo _t('상품명'); ?><strong class="sound_only"> <?php echo _t('필수'); ?></strong></label>
            <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required class="frm_input">
            <input type="submit" value="<?php echo _t('검색'); ?>" class="btn_submit">
            <button type="button" class="pop_close"><span class="sound_only"><?php echo _t('검색'); ?> </span><?php echo _t('닫기'); ?></button>
        </div>
    </aside>
    </form>
    <script>
        $(function (){
        var $hd_sch = $("#hd_sch");
        $("#hd_sch_open").click(function(){
            $hd_sch.css("display","block");
        });
        $("#hd_sch .pop_close").click(function(){
            $hd_sch.css("display","none");
        });
    });

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

    <ul id="hd_mb">
        <li><a href="<?php echo G5_BBS_URL; ?>/faq.php"><?php echo _t('FAQ'); ?></a></li>
        <li><a href="<?php echo G5_BBS_URL; ?>/qalist.php"><?php echo _t('1:1문의'); ?></a></li>
        <?php
        if(G5_COMMUNITY_USE) {
            $com_href = G5_URL;
            $com_name = _t('커뮤니티');
        } else {
            if(!preg_match('#'.G5_SHOP_DIR.'/#', $_SERVER['SCRIPT_NAME'])) {
                $com_href = G5_SHOP_URL;
                $com_name = _t('쇼핑몰');
            }
        }

        if($com_href && $com_name) {
        ?>
        <li><a href="<?php echo $com_href; ?>/"><?php echo $com_name; ?></a></li>
        <?php } ?>
        <li><a href="<?php echo G5_SHOP_URL; ?>/personalpay.php"><?php echo _t('개인결제'); ?></a></li>
        <?php if(!$com_href || !$com_name) { ?>
        <li><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5"><?php echo _t('세일상품'); ?></a></li>
        <?php } ?>
    </ul>
</header>

<div id="container">
    <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><h1 id="container_title"><?php echo $g5['title'] ?></h1><?php } ?>
