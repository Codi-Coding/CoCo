<?php // 굿빌더 ?>
<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

global $is_admin;
?>

<!-- 방문 통계 시작 -->
   <?php echo _t('오늘'); ?> <?php echo number_format($visit[1])?>
<?php if ($is_admin == "super") { ?>&nbsp;<a href="<?php echo $g5['admin_url']?>/visit_list.php"><img src="<?php echo $visit_skin_url?>/img/admin.gif" width="33" height="15" border="0" align="absmiddle"></a>&nbsp;<?php }?>
   <?php echo _t('어제'); ?> <?php echo number_format($visit[2])?>
   <?php echo _t('최대'); ?> <?php echo number_format($visit[3])?>
   <?php echo _t('전체'); ?> <?php echo number_format($visit[4])?>&nbsp;
<?php if ($is_admin == "super") { ?>
<a href='<?php echo $g5['bbs_url']?>/current_connect.php'><?php echo _t('현재접속자'); ?> <?php echo $row['total_cnt']?> (<?php echo _t('회원'); ?> <?php echo $row['mb_cnt']?>)</a>
<?php } ?>
<!-- 방문 통계 끝 -->
