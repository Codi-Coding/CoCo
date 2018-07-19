<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_TMPL_PATH.'/head.sub.php');
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

$boot_pkg = "bootstrap";
if(defined('G5_THEME_COLOR') && G5_THEME_COLOR) $boot_change = 'boot_change.'.G5_THEME_COLOR;
else $boot_change = 'boot_change';
?>

<!-- header -->
<?php
    add_stylesheet('<link rel="stylesheet" href="'.$g5['url'].'/'.$boot_pkg.'/css/bootstrap.css" media="screen">', 0);
    add_stylesheet('<link rel="stylesheet" href="'.$g5['url'].'/'.$boot_pkg.'/css/bootswatch.min.css">', 0);
    ///add_stylesheet('<link rel="stylesheet" href="'.$g5['tmpl_url'].'/css/'.$boot_change.'.css" >', 0);
?>
    <script src="<?php echo $g5['url']?>/<?php echo $boot_pkg?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $g5['url']?>/<?php echo $boot_pkg?>/js/bootswatch.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $g5['url']?>/<?php echo $boot_pkg?>/js/html5shiv.js"></script>
    <script src="<?php echo $g5['url']?>/<?php echo $boot_pkg?>/js/respond.min.js"></script>
    <![endif]-->

    <?php
        if(defined('_INDEX_')) echo latest('good_basic_popup', 'notice'); /// popup
    ?>

    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="<?php echo G5_URL?>/" class="navbar-brand">GoodBuilder</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <?php
        // 메뉴설정파일
        include_once("$g5[tmpl_path]/menu/menu.php");
        include_once("$g5[tmpl_path]/menu/menu_aux.php");
        ?>
        <div class="navbar-collapse collapse" id="navbar-main">
          <form _lpchecked="1" name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);" class="navbar-form navbar-left">        
            <input type="hidden" name="sfl" value="wr_subject||wr_content">
            <input type="hidden" name="sop" value="and">              
            <!--<input type="text" name="stx" class="form-control col-md-8" placeholder="Search">-->
            <input type="text" name="stx" class="form-control" placeholder="Search">
          </form>
          <script>
            function fsearchbox_submit(f)
            {
                if (f.stx.value.length < 2) {
                    alert("<?php echo _t('검색어는 두글자 이상 입력하십시오.'); ?>");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                var cnt = 0;
                for (var i=0; i<f.stx.value.length; i++) {
                    if (f.stx.value.charAt(i) == ' ')
                        cnt++;
                }

                if (cnt > 1) {
                    alert("<?php echo _t('빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.'); ?>");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                return true;
            }
          </script>
          <ul class="nav navbar-nav">
            <?php for($i = 0; $i < count($menu_list); $i++) { ?>
            <?php if($menu_list[$i][0] == _t('홈')) continue; ?>
            <?php if(count($menu[$i]) > 0) { ?>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="menu_<?php echo $i?>"><?php echo _t($menu_list[$i][0])?><span class="caret"></span></a>
            <?php } else { ?>
            <li>
              <a href="<?php echo $menu_list[$i][1]?>"><?php echo _t($menu_list[$i][0])?></a>
            <?php } ?>
            <?php if($i > 0) { ?>
            <?php if(count($menu[$i]) > 0) { ?>
              <ul class="dropdown-menu" aria-labelledby="menu_<?php echo $i?>">
                <?php for($j = 0; $j < count($menu[$i]); $j++) { ?>
                    <li>
                        <a href="<?php echo $menu[$i][$j][1]?>"><?php echo _t($menu[$i][$j][0])?></a>
                    </li>
                <?php } ?>
              </ul>
            <?php } ?>
            <?php } ?>
            </li>
            <?php } /// for ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <?php if ($is_admin) {  ?>
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><?php echo _t('관리자'); ?><span class="caret"></span></a>
              <?php } else if ($is_member) {  ?>
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><?php echo _t('회원관리'); ?><span class="caret"></span></a>
              <?php } else {  ?>
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><?php echo _t('로그인'); ?><span class="caret"></span></a>
              <?php }  ?>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <?php if ($is_admin) {  ?>
                <li><a href="<?php echo G5_ADMIN_URL ?>"><?php echo _t('관리자'); ?></a></li>
                <li><a href="<?php echo G5_ADMIN_URL ?>/builder/basic_tmpl_config_form.php"><?php echo _t('빌더관리'); ?></a></li>
                <?php }  ?>
                <?php if ($is_member) {  ?>
                <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php"><?php echo _t('정보수정'); ?></a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/logout.php"><?php echo _t('로그아웃'); ?></a></li>
                <li><a href="<?php echo G5_SHOP_URL ?>/mypage.php"><?php echo _t('마이페이지'); ?></a></li>
                <li><a href="<?php echo G5_SHOP_URL ?>/couponzone.php"><?php echo _t('쿠폰존'); ?></a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo"><?php echo _t('쪽지'); ?></a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="win_point"><?php echo _t('포인트'); ?></a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" class="win_scrap"><?php echo _t('스크랩'); ?></a></li>
                <?php } else {  ?>
                <li><a href="<?php echo G5_BBS_URL ?>/login.php"><?php echo _t('로그인'); ?></a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/register.php"><?php echo _t('회원가입'); ?></a></li>
                <?php }  ?>
              </ul>
            </li>
          </ul>
        </div><!--navbar-main-->
      </div><!--container-->
    </div><!--navbar-fixed-top-->
    <?php if(defined('_SHOP_') && _SHOP_) { ?>
    <div class="container" style="padding-top:55px">
    <?php } else { ?>
    <div class="container" style="padding-top:30px">
    <?php } ?>
<!-- end of header -->
<!-- body -->
