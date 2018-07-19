<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
    </div>
</div>

<hr>

<?php if(!defined('_SHOP_')) echo poll('basic_old'); // 설문조사 ?>

<hr>

<div id="ft">
    <?php echo popular('basic_old'); // 인기검색어 ?>
    <?php echo visit('basic_old'); // 방문자수 ?>
    <div id="ft_copy">
        <div id="ft_company">
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company"><?php echo _t('회사소개'); ?></a>
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy"><?php echo _t('개인정보처리방침'); ?></a>
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision"><?php echo _t('서비스이용약관'); ?></a>
        </div>
        Copyright &copy; <b><?php echo $config['cf_title']?></b>. All rights reserved.<br>
        <p><a href="#"><?php echo _t('상단으로'); ?></a></p>
    </div>
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
if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}

include_once(G5_MOBILE_TMPL_PATH.'/tail.sub.php');
?>
