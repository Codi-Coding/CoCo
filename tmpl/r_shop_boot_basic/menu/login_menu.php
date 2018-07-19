<?php // 굿빌더 ?>
<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<?php if (!$member['mb_id']) { ?>
   <!-- no login -->
   <?php if($g5['use_member_register']) { ?>
   <!-- <a href="<?php echo $g5['bbs_url']?>/login.php?url=<?php echo $urlencode?>"><?php echo _t('로그인'); ?></a> | -->
   <a href="<?php echo $g5['bbs_url']?>/login.php"><?php echo _t('로그인'); ?></a> |
   <a href="<?php echo $g5['bbs_url']?>/register.php"><?php echo _t('회원가입'); ?></a>&nbsp; 
   <?php } else { ?>
   &nbsp;
   <?php } ?>
<?php
} else {
   // login
   // 읽지 않은 쪽지 검사
    $sql = " select count(*) as cnt
              from {$g5['memo_table']}
              where me_recv_mb_id = '{$member['mb_id']}'
              and me_read_datetime = '0000-00-00 00:00:00' ";
    $row = sql_fetch($sql);
    $memo_not_read = $row['cnt'];
?>
    <a href="<?php echo $g5['bbs_url']?>/logout.php"><?php echo _t('로그아웃'); ?></a> |
    <a href="<?php echo $g5['bbs_url']?>/member_confirm.php?url=<?php echo urlencode("register_form.php");?>"><?php echo _t('정보수정'); ?></a> |

    <?php if(1) { ?>
    <A href="javascript:win_point('<?php echo $g5['bbs_url']?>/point.php');" class="util"><?php echo _t('포인트'); ?><SPAN class=small>(<?php echo $member[mb_point]?><?php echo _t('점'); ?>)</SPAN></A> |
    <A href="javascript:win_memo('<?php echo $g5['bbs_url']?>/memo.php');" class="util"><?php echo _t('쪽지'); ?><SPAN class=small>(<?php echo $memo_not_read?><?php echo _t('개'); ?>)</SPAN></A> |
    <A href="javascript:win_scrap('<?php echo $g5['bbs_url']?>/scrap.php');" class="util"><?php echo _t('스크랩'); ?></A> |
    <?php } ?>

    <?php if ($is_admin == "super") { ?>
    <a href="<?php echo $g5['admin_url']?>/"><img src="<?php echo $g5['url']?>/img/admin.png" width="33" height="15" border="0" align="absmiddle"></a>  
        <?php if(0) { ?>
    | <a href="<?php echo $g5['admin_url']?>/visit_list.php"><img src="<?php echo $g5['url']?>/img/visit.png" width="33" height="15" border="0" align="absmiddle"></a>:
    <a href="<?php echo $g5['admin_url']?>/visit_list.php"><?php echo _t('방문현황'); ?></a>/<a href="<?php echo $g5['bbs_url']?>/current_connect.php"><?php echo _t('최근방문'); ?></a>/<a href="<?php echo $g5['bbs_url']?>/new.php"><?php echo _t('최근게시물'); ?></a> |
    <a href="<?php echo $g5['admin_url']?>/builder/basic_tmpl_config_form.php"><img src="<?php echo $g5['url']?>/img/builder.png" width="40" height="15" border="0" align="absmiddle"></a>:
    <a href="<?php echo $g5['admin_url']?>/builder/basic_tmpl_config_form.php"><?php echo _t('템플릿'); ?></a>/<a href="<?php echo $g5['admin_url']?>/builder/menu_config_form.php"><?php echo _t('메뉴'); ?></a>/<a href="<?php echo $g5['admin_url']?>/builder/main_config_form.php"><?php echo _t('메인'); ?></a>/<a href="<?php echo $g5['admin_url']?>/builder/main_left_config_form.php"><?php echo _t('좌측'); ?></a>/<a href="<?php echo $g5['admin_url']?>/builder/main_right_config_form.php"><?php echo _t('우측'); ?></a>&nbsp;
        <?php } else { ?>
    <a href="<?php echo $g5['admin_url']?>/visit_list.php"><img src="<?php echo $g5['url']?>/img/visit.png" width="33" height="15" border="0" align="absmiddle"></a> 
    <a href="<?php echo $g5['admin_url']?>/builder/basic_tmpl_config_form.php"><img src="<?php echo $g5['url']?>/img/builder.png" width="40" height="15" border="0" align="absmiddle"></a>&nbsp;
        <?php } ?>
    <?php } ?>
<?php } ?>
