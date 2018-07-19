<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$visit_skin_url.'/style.css">', 0);
?>

<aside id="visit">
    <h2><i class="fa fa-user" aria-hidden="true"></i> <?php echo _t('접속자집계'); ?></h2>
    <dl>
        <dt><?php echo _t('오늘'); ?></dt>
        <dd><?php echo number_format($visit[1]) ?></dd>
        <dt><?php echo _t('어제'); ?></dt>
        <dd><?php echo number_format($visit[2]) ?></dd>
        <dt><?php echo _t('최대'); ?></dt>
        <dd><?php echo number_format($visit[3]) ?></dd>
        <dt><?php echo _t('전체'); ?></dt>
        <dd><?php echo number_format($visit[4]) ?></dd>
    </dl>
    <?php if ($is_admin == "super") { ?><a href="<?php echo G5_ADMIN_URL ?>/visit_list.php"><?php echo _t('상세보기'); ?></a><?php } ?>
</aside>
