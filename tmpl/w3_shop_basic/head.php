<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/good_group.lib.php'); /// New
include_once(G5_LIB_PATH.'/good_guide.lib.php'); /// New
include_once(G5_LIB_PATH.'/good_outnew.lib.php'); /// New
include_once(G5_LIB_PATH.'/good_outsearch.lib.php'); /// New
include_once(G5_LIB_PATH.'/good_sidemenu.lib.php'); /// New

// 메뉴설정파일
include_once("$g5[tmpl_path]/menu/menu.php");
include_once("$g5[tmpl_path]/menu/menu_aux.php");

/// sns
$sns_msg = urlencode(str_replace('\"', '"', $g5['title']));
$sns_send  = G5_BBS_URL.'/sns_send.php?longurl='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$sns_send .= '&amp;title='.$sns_msg;

$facebook_url = $sns_send.'&amp;sns=facebook';
$twitter_url  = $sns_send.'&amp;sns=twitter';
$gplus_url    = $sns_send.'&amp;sns=gplus';
$linkedin_url  = $sns_send.'&amp;sns=linkedin';
///$instagram_url = $sns_send.'&amp;sns=instagram';
///$snapchat_url = $sns_send.'&amp;sns=snapchat';
///$pinterest_url = $sns_send.'&amp;sns=pinterest';
///$flickr_url  = $sns_send.'&amp;sns=flickr';
?>
<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-padding w3-card-2">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-hover-white" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
    <a href="<?php echo G5_URL; ?>/" class="w3-bar-item w3-button w3-hover-black"><i class="fa fa-home w3-margin-right"></i><b><?php echo $config['cf_title']; ?></b></a>
    <div class="w3-right w3-hide-small">
<?php for($i = 0; $i < count($menu_list); $i++) { ?>
<?php if($menu_list[$i][0] == '홈' or $menu_list[$i][0] == _t('홈')) continue; ?>
<?php if(count($menu[$i]) == 0) { ?>
    <a href="<?php echo $menu_list[$i][1]?>" class="w3-bar-item w3-button w3-hide-small"><?php echo _t($menu_list[$i][0])?></a>
<?php } else { ?>
    <div class="w3-dropdown-hover w3-hide-small">
      <!--<button class="w3-button"><?php echo _t($menu_list[$i][0])?> <i class="fa fa-caret-down"></i></button>-->
      <a href="<?php echo $menu_list[$i][1]?>" class="w3-button"><?php echo _t($menu_list[$i][0])?> <i class="fa fa-caret-down"></i></a>
      <div class="w3-dropdown-content w3-card-4 w3-bar-block">
<?php for($j = 0; $j < count($menu[$i]); $j++) { ?>
        <a href="<?php echo $menu[$i][$j][1]?>" class="w3-bar-item w3-button"><?php echo _t($menu[$i][$j][0])?></a>
<?php } ?>
      </div>
    </div>
<?php } ?>
<?php } /// for ?>
    <a href="<?php echo G5_SHOP_URL; ?>/search.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-black" title="Search"><i class="fa fa-search"></i></a>
    <div class="w3-dropdown-hover w3-hide-small w3-right">
<?php if ($is_admin) {  ?>
      <button class="w3-button"><?php echo _t('관리자'); ?> <i class="fa fa-caret-down"></i></button>     
<?php } else if ($is_member) {  ?>
      <button class="w3-button"><?php echo _t('회원관리'); ?> <i class="fa fa-caret-down"></i></button>     
<?php } else {  ?>
      <button class="w3-button"><?php echo _t('로그인'); ?> <i class="fa fa-caret-down"></i></button>     
<?php }  ?>
      <div class="w3-dropdown-content w3-card-4 w3-bar-block">
<?php if ($is_admin) {  ?>
        <a href="<?php echo G5_ADMIN_URL ?>" class="w3-bar-item w3-button"><?php echo _t('관리자'); ?></a>
        <a href="<?php echo G5_ADMIN_URL ?>/builder/basic_tmpl_config_form.php" class="w3-bar-item w3-button"><?php echo _t('빌더관리'); ?></a>
<?php }  ?>
<?php if ($is_member) {  ?>
        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" class="w3-bar-item w3-button"><?php echo _t('정보수정'); ?></a>
        <a href="<?php echo G5_BBS_URL ?>/logout.php" class="w3-bar-item w3-button"><?php echo _t('로그아웃'); ?></a>
        <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="w3-bar-item w3-button win_memo"><?php echo _t('쪽지'); ?></a>
        <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="w3-bar-item w3-button win_point"><?php echo _t('포인트'); ?></a>
        <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" class="w3-bar-item w3-button win_scrap"><?php echo _t('스크랩'); ?></a>
<?php } else {  ?>
        <a href="<?php echo G5_BBS_URL ?>/login.php" class="w3-bar-item w3-button"><?php echo _t('로그인'); ?></a>
        <a href="<?php echo G5_BBS_URL ?>/register.php" class="w3-bar-item w3-button"><?php echo _t('회원가입'); ?></a>
<?php }  ?>
      </div>
    </div>
    </div>
  </div>
  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium" style="height:500px;overflow:scroll">
<?php for($i = 0; $i < count($menu_list); $i++) { ?>
<?php if($menu_list[$i][0] == '홈' or $menu_list[$i][0] == _t('홈')) continue; ?>
    <a href="<?php echo $menu_list[$i][1]?>" class="w3-bar-item w3-button"><?php echo _t($menu_list[$i][0])?></a>
<?php if($i > 0) { ?>
<?php if(count($menu[$i]) > 0) { ?>
<?php for($j = 0; $j < count($menu[$i]); $j++) { ?>
      <a href="<?php echo $menu[$i][$j][1]?>" class="w3-bar-item w3-button" style="margin-left:30px"><?php echo _t($menu[$i][$j][0])?></a>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } /// for ?>
    <a href="<?php echo G5_SHOP_URL; ?>/search.php" class="w3-bar-item w3-button"><?php echo _t('Search'); ?></a>
<?php if ($is_admin) { ?>
    <a href="<?php echo G5_ADMIN_URL ?>" class="w3-bar-item w3-button"><?php echo _t('관리자'); ?></a>
<?php } else if ($is_member) { ?>
    <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" class="w3-bar-item w3-button"><?php echo _t('정보수정'); ?></a>
<?php } else { ?>
    <a href="<?php echo G5_BBS_URL ?>/login.php" class="w3-bar-item w3-button"><?php echo _t('로그인'); ?></a>
<?php }  ?>
<?php if ($is_admin) { ?>
    <a href="<?php echo G5_ADMIN_URL ?>" class="w3-bar-item w3-button" style="margin-left:30px"><?php echo _t('관리자'); ?></a>
    <a href="<?php echo G5_ADMIN_URL ?>/builder/basic_tmpl_config_form.php" class="w3-bar-item w3-button" style="margin-left:30px"><?php echo _t('빌더관리'); ?></a>
<?php } ?>
<?php if ($is_member) { ?>
    <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" class="w3-bar-item w3-button" style="margin-left:30px"><?php echo _t('정보수정'); ?></a>
    <a href="<?php echo G5_BBS_URL ?>/logout.php" class="w3-bar-item w3-button" style="margin-left:30px"><?php echo _t('로그아웃'); ?></a>
    <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="w3-bar-item w3-button win_memo" style="margin-left:30px"><?php echo _t('쪽지'); ?></a>
    <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="w3-bar-item w3-button win_point" style="margin-left:30px"><?php echo _t('포인트'); ?></a>
    <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" class="w3-bar-item w3-button win_scrap" style="margin-left:30px"><?php echo _t('스크랩'); ?></a>
<?php } else {  ?>
    <a href="<?php echo G5_BBS_URL ?>/login.php" class="w3-bar-item w3-button" style="margin-left:30px"><?php echo _t('로그인'); ?></a>
    <a href="<?php echo G5_BBS_URL ?>/register.php" class="w3-bar-item w3-button" style="margin-left:30px"><?php echo _t('회원가입'); ?></a>
<?php } ?>
  </div>
</div>
<!-- end of header -->

<!-- body -->
<?php if(!defined('_INDEX_')) { ?>
<div id="container" style="width:100%;padding-top:90px;padding-left:10px;padding-right:10px">
    <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><div id="wrapper_title"><?php echo _t($g5['title']) ?></div><?php } ?>
<?php } ?>
