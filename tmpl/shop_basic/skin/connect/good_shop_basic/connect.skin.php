<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;
?>

<link rel="stylesheet" href="<?php echo $connect_skin_url ?>/style.css">

<!-- 현재 접속자 시작 -->
<section id="connect_aside">
    <div>
        <h2><?php echo _t('현재접속자'); ?></h2>
        <?php if ($is_admin == 'super' || $is_auth) {  ?><a href="<?php echo G5_BBS_URL."/current_connect.php"; ?>" class="btn_admin"><?php echo _t('현재접속자'); ?></a><?php }  ?>
        <ul>
            <li><a href="<?php echo G5_BBS_URL."/current_connect.php"; ?>"><?php echo _t('현재접속자'); ?> <?php echo number_format($row['total_cnt']) ?></a></li>
        </ul>
    </div>
</section>
<!-- 현재 접속자 끝 -->
