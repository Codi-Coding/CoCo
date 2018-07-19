<?php // 굿빌더 ?>
<?
define("_MAINPAGE_", TRUE);
include_once("./_common.php");

if($site_name == '') $site_name = $config['cf_title']; /// 2010.11.25
$index_title = trim("$site_name $index_title_comment ");

$g5['title'] = $index_title;
include_once(G5_TMPL_PATH.'/head.php');
?>
		<div class="mainpage">
			<div class="banner">
    				<table width="100%" border=0 cellspacing=0 cellpadding=0 style="margin-top:0px"><tr><td align=center>
				<?php $options = array("780","428"); echo latest("good_main_gal", "main_banner", 5, 0, 1, $options);?>
				</td></tr></table>
			</div>
			<div class="box">
				<?php echo latest("good_basic_main", "notice", 5, 80)?>
				<?php echo latest("good_basic_main", "qna", 4, 80)?>
				<?php echo latest("good_basic_main", "faq", 4, 80)?>
			</div>
		</div><!-- mainpage -->
		<!--<hr size=1>-->
		<div class="visit"><span><?php echo visit("good_line"); ?></span></div>
		<div class="line"> </div>
<?
include_once(G5_TMPL_PATH.'/tail.php');
?>
