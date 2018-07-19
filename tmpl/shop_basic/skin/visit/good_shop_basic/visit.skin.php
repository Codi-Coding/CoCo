<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;
?>

<link rel="stylesheet" href="<?php echo $visit_skin_url ?>/style.css">

<!-- 접속자 집계 시작 -->
<section id="visit_aside">
    <div>
        <h2><?php echo _t('접속자집계'); ?></h2>
        <?php if ($is_admin == 'super' || $is_auth) {  ?><a href="<?php echo G5_ADMIN_URL."/visit_list.php"; ?>" class="btn_admin"><?php echo _t('접속자집계'); ?></a><?php }  ?>
        <ul>
            <li><?php echo _t('오늘'); ?> <?php echo number_format($visit[1]) ?></li>
            <li><?php echo _t('어제'); ?> <?php echo number_format($visit[2]) ?></li>
            <li><?php echo _t('최대'); ?> <?php echo number_format($visit[3]) ?></li>
            <li><?php echo _t('전체'); ?> <?php echo number_format($visit[4]) ?></li>
        </ul>
    </div>
</section>
<!-- 접속자 집계 끝 -->
