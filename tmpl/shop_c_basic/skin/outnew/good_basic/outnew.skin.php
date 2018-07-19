<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;
?>

<link rel="stylesheet" href="<?php echo $outnew_skin_url ?>/style.css">

<!-- 최근 게시물 현황 시작 -->
<section id="outnew_aside">
    <div>
        <h2><?php echo _t('최근 게시물'); ?></h2>
        <?php if ($is_admin == 'super' || $is_auth) {  ?><a href="<?php echo G5_BBS_URL."/new.php"; ?>" class="btn_admin"><?php echo _t('최근 게시물'); ?></a><?php }  ?>
        <ul>
            <li><a href="<?php echo G5_BBS_URL."/new.php"; ?>"><?php echo _t('최근 게시물'); ?></a></li>
        </ul>
    </div>
</section>
<!-- 최근 게시물 현황 끝 -->
