<?php // 굿빌더 ?>
<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

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

// 메뉴설정파일
include_once("$g5[tmpl_path]/menu/menu.php");
include_once("$g5[tmpl_path]/menu/menu_aux.php");

/// selection 관리

$class = array();
$class[$main_index] = " class='selected'";
?>
<?php if($g5['use_left_sidebox']) { ?>
<style>
/*
#body .subpage .sidebox {
	background-position: top right;
}
*/
#body .subpage .content {
	background-position: top left;
}
</style>
<?php } ?>
<?php if (defined("_MODULE_")) { ?>
<style>
#body .subpage .content {
	background: none;
}
</style>
<?php } ?>
<script language="JavaScript">
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

    f.action = "<?php echo $g5[bbs_url]?>/search.php";
    return true;
}
</script>

        <?php
            if(defined('_INDEX_')) echo latest('good_basic_popup', 'notice'); /// popup
        ?>

	<div id="head">
		<div class="top_login">
			<?php include_once("$g5[tmpl_path]/menu/login_menu.php"); ?>
		</div>
		<div class="top">
			<?php if($config2w['cf_use_common_logo']) { ?>
			<a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/logo.png" alt="<?php echo $config['cf_title']; ?>"></a>
			<?php } else { ?>
			<a href="<?php echo $g5['url']?>/" class="logo"><img src="<?php echo $g5['tmpl_url']?>/images/logo.png" alt="로고"></a>
			<?php } ?>
			<form name="fsearchbox" method="get" onsubmit="return fsearchbox_submit(this);">
				<input type="hidden" name="sfl" value="wr_subject||wr_content">
				<input type="hidden" name="sop" value="and">
				<input type="text" name="stx" id="search" onclick="javascript:this.focus();">
				<input type="submit" name="searchbtn" id="searchbtn" value="">
			</form>
		</div>
		<div class="navimenu">
                        <ul>
                        <?php for($i = 0; $i < count($menu_list); $i++) { ?>
                                <li<?php echo $class[$i]?>>
                                        <a href="<?php echo $menu_list[$i][1]?>"><?php echo _t($menu_list[$i][0])?></a>
                                        <?php if($i > 0) { ?>
                                        <?php if(count($menu[$i]) > 0) { ?>
                                        <ul>
                                        <?php for($j = 0; $j < count($menu[$i]); $j++) { ?>
                                                <li>
                                                        <a href="<?php echo $menu[$i][$j][1]?>"><?php echo _t($menu[$i][$j][0])?></a>
                                                </li>
                                        <?php } ?>
                                        </ul>
                                        <?php } ?>
                                        <?php } ?>
                                </li>
                        <?php } ?>
                        </ul>
		</div>
	</div>
	<div id="body">
<?php if (!defined("_MAINPAGE_")) { ?>
		<div class="subpage">
			<?php if($g5['use_left_sidebox']) { ?>
			<?php if(!defined("_MODULE_")) { ?>
			<div class="sidebox">
                        <?
                                include "$g5[tmpl_path]/subpage/sidebox.inc.html";
                                include "$g5[tmpl_path]/subpage/sidebox_callcenter.inc.html";
                                include "$g5[tmpl_path]/subpage/sidebox_book.inc.html";
                        ?>
			</div><!-- sidebox -->
			<?php } ?>
			<?php } /// if ?>
			<div class="content">
<?php if (defined("_MODULE_")) { ?>
				<div class="sitepath2">
					<span><?php echo _t('Home'); ?> > <?php echo $board[bo_subject]?"{$group[gr_subject]} > {$board[bo_subject]}":$g5[title] ?></span>
				</div>
				<div class="module">
					<h2><?php echo $board[bo_subject]?'':$g5[title_subject] ?></h2>
					<div>
<?php } else { ?>
				<div class="sitepath">
					<span><?php echo _t('Home'); ?> > <?php echo $board[bo_subject]?"{$group[gr_subject]} > {$board[bo_subject]}":$g5[title] ?></span>
				</div>
<?php if (!defined("_SUBPAGE_")) { ?>
				<div class="board">
					<h2><?php echo $board[bo_subject]?'':$g5[title_subject] ?></h2>
					<div>
<?php } ?>
<?php } ?>
<?php } ?>
