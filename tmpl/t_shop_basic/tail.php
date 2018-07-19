<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>

    </div>
    <!-- } 콘텐츠 끝 -->

<!-- 하단 시작 { -->
</div>

<div id="ft">
    <div>
        <?php if($config2w['cf_use_common_logo']) { ?>
        <a href="<?php echo G5_URL; ?>/" id="ft_logo"><img src="<?php echo G5_IMG_URL; ?>/shop_ft.png" alt="<?php echo _t('처음으로'); ?>"></a>
        <?php } else { ?>
        <a href="<?php echo G5_URL; ?>/" id="ft_logo"><img src="<?php echo G5_TMPL_URL; ?>/images/ft.png" alt="<?php echo _t('처음으로'); ?>"></a>
        <?php } ?>
        <ul>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company"><?php echo _t('회사소개'); ?></a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision"><?php echo _t('서비스이용약관'); ?></a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy"><?php echo _t('개인정보처리방침'); ?></a></li>
        </ul>
        <p>
            <span><?php echo $default['de_admin_company_addr']; ?></span>
            <span><b><?php echo _t('전화'); ?></b> <?php echo $default['de_admin_company_tel']; ?></span>
            <span><b><?php echo _t('팩스'); ?></b> <?php echo $default['de_admin_company_fax']; ?></span>
            <!--<span><b><?php echo _t('운영자'); ?></b> <?php echo _t($admin['mb_name']); ?></span>--><br>
            <span><b><?php echo _t('사업자 등록번호'); ?></b> <?php echo $default['de_admin_company_saupja_no']; ?></span>
            <span><b><?php echo _t('대표'); ?></b> <?php echo _t($default['de_admin_company_owner']); ?></span>
            <span><b><?php echo _t('개인정보 보호책임자'); ?></b> <?php echo _t($default['de_admin_info_name']); ?></span><br>
            <span><b><?php echo _t('통신판매업신고번호'); ?></b> <?php echo $default['de_admin_tongsin_no']; ?></span>
            <?php if ($default['de_admin_buga_no']) echo '<span><b>'._t('부가통신사업신고번호').'</b> '.$default['de_admin_buga_no'].'</span>'; ?><br>
            Copyright &copy; 2001-2013 <?php echo _t($default['de_admin_company_name']); ?>. <?php echo _t('All rights reserved.'); ?>
        </p>
        <a href="#" id="ft_totop"><?php echo _t('상단으로'); ?></a>
    </div>
</div>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<a href="<?php echo get_device_change_url(); ?>" id="device_change"><?php echo _t('모바일 버전으로 보기'); ?></a>
<?php
}
?>

<?php if(defined('POWERED_BY') && POWERED_BY) { ?>
<div id="powered_by">
    Powered by <a href="<?php echo BUILDER_HOME?>" target="_blank">Goodbuilder</a> 
    <?php if(defined('DESIGNED_BY') && DESIGNED_BY) { ?>
    / Designed by <a href="<?php echo BUILDER_HOME?>" target="_blank">Goodbuilder</a>
    <?php } ?>
</div>
<?php } ?>

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['PHP_SELF'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<!-- } 하단 끝 -->

<?php
include_once(G5_TMPL_PATH.'/tail.sub.php');
?>
