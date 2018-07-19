<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>

</div><!-- container End -->

<div id="ft">
    <h2><?php echo $config['cf_title']; ?> <?php echo _t('정보'); ?></h2>
    <?php if($config2w_m['cf_use_common_logo']) { ?>
    <a href="<?php echo G5_URL; ?>/"><img src="<?php echo G5_IMG_URL; ?>/mobile_ft.png" alt="<?php echo _t('처음으로'); ?>"></a>
    <?php } else { ?>
    <a href="<?php echo G5_URL; ?>/"><img src="<?php echo $g5['mobile_tmpl_url']; ?>/images/ft.png" alt="<?php echo _t('처음으로'); ?>"></a>
    <?php } ?>
    <p>
        <span><?php echo $default['de_admin_company_addr']; ?></span>
        <span><b><?php echo _t('대표'); ?></b> <?php echo $default['de_admin_company_owner']; ?></span><br>
        <span><b><?php echo _t('전화'); ?></b> <?php echo $default['de_admin_company_tel']; ?></span>
        <span><b><?php echo _t('팩스'); ?></b> <?php echo $default['de_admin_company_fax']; ?></span><br>
        <span><b><?php echo _t('사업자 등록번호'); ?></b> <?php echo $default['de_admin_company_saupja_no']; ?></span>
        <span><b><?php echo _t('통신판매업신고번호'); ?></b> <?php echo $default['de_admin_tongsin_no']; ?></span><br>
        <?php if ($default['de_admin_buga_no']) echo '<span><b>'._t('부가통신사업신고번호').'</b> '.$default['de_admin_buga_no'].'</span>'; ?>
        <span><b><?php echo _t('개인정보 보호책임자'); ?></b> <?php echo $default['de_admin_info_name']; ?></span><br>
        Copyright &copy; 2001-2013 <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.
    </p>
    <a href="#" id="ft_to_top"><?php echo _t('상단으로'); ?></a>
</div>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
<a href="<?php echo get_device_change_url(); ?>" id="device_change"><?php echo _t('PC 버전으로 보기'); ?></a>
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

<?php
include_once(G5_MOBILE_TMPL_PATH.'/tail.sub.php');
?>
