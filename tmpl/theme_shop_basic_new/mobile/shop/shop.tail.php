<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>
</div><!-- container End -->

<div id="ft">
    <h2><?php echo $config['cf_title']; ?> <?php echo _t('정보'); ?></h2>
    <div id="ft_company">
        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company"><?php echo _t('회사소개'); ?></a>
        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy"><?php echo _t('개인정보처리방침'); ?></a>
        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision"><?php echo _t('서비스이용약관'); ?></a>
        <?php
        if(G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
        <a href="<?php echo get_device_change_url(); ?>" id="device_change"><?php echo _t('PC 버전으로 보기'); ?></a>
        <?php
        }

        if ($config['cf_analytics']) {
            echo $config['cf_analytics'];
        }
        ?>
    </div>
    <div id="ft_logo"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_THEME_IMG_URL; ?>/shop_ft.png" alt="<?php echo $config['cf_title']; ?> <?php echo _t('메인'); ?>"></a></div>
    <p>
        <span><b><?php echo _t('회사명'); ?></b> <?php echo $default['de_admin_company_name']; ?></span>
        <span><b><?php echo _t('주소'); ?></b> <?php echo $default['de_admin_company_addr']; ?></span><br>
        <span><b><?php echo _t('사업자 등록번호'); ?></b> <?php echo $default['de_admin_company_saupja_no']; ?></span><br>
        <span><b><?php echo _t('대표'); ?></b> <?php echo $default['de_admin_company_owner']; ?></span>
        <span><b><?php echo _t('전화'); ?></b> <?php echo $default['de_admin_company_tel']; ?></span>
        <span><b><?php echo _t('팩스'); ?></b> <?php echo $default['de_admin_company_fax']; ?></span><br>
        <!-- <span><b><?php echo _t('운영자'); ?></b> <?php echo $admin['mb_name']; ?></span><br> -->
        <span><b><?php echo _t('통신판매업신고번호'); ?></b> <?php echo $default['de_admin_tongsin_no']; ?></span><br>
        <span><b><?php echo _t('개인정보 보호책임자'); ?></b> <?php echo $default['de_admin_info_name']; ?></span>

        <?php if ($default['de_admin_buga_no']) echo '<span><b>'._t('부가통신사업신고번호').'</b> '.$default['de_admin_buga_no'].'</span>'; ?><br>
        Copyright &copy; 2001-2013 <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.
    </p>
    <a href="#" id="ft_to_top"><i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only"><?php echo _t('상단으로'); ?></span></a>

</div>

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
