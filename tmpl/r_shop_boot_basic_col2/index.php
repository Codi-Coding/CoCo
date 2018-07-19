<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if($site_name == '') $site_name = $config['cf_title']; /// 2010.11.25
$index_title = trim("$site_name $index_title_comment ");

$g5['title'] = $index_title;
$main_page = 1; /// main, subpage 구분을 위해 추가.  2013.01.18
include_once(G5_TMPL_PATH.'/head.php');
?>

<!-- 메인이미지 시작 { -->
<?php ///echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
<!-- } 메인이미지 끝 -->

<!-- 슬라이딩 메인 배너 -->
      <div class="main-page">
        <div class="row">
          <h2 class="sound_only"><?php echo _t('메인 배너'); ?></h2>
          <div class="col-md-12">
            <div class="bs-component">
<table width="100%" border=0 cellspacing=0 cellpadding=0 style="margin:0;padding:0"><tr><td align=center>
<?php /// echo latest("good_webzine_full", "gallery_main_ad", 1, 0); /// 간단히 그림만 표시할 경우 ?>
<?php /// $options = array("480","140"); echo latest("r_good_slide_pgw", "gallery_main_ad", 5, 0, 1, $options); /// 넚이 480 이하로 지정 ?>
<?php $options = array("600","197"); echo latest("r_good_slide_carousel", "gallery_main_ad", 5, 0, 1, $options);?>
</td></tr></table> 
            </div>
          </div>
        </div>
      </div>
      <br>
<?php if($default['de_type1_list_use']) { ?>
<!-- 히트상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1"><?php echo _t('히트상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('히트상품 모음'); ?></p>
    </header>
    <div style="border:1px solid #eee; border-bottom:2px solid #eee; border-radius:4px; padding:5px; background:#fbfbfb; margin:0 auto">
    <?php
    $list = new item_list();
    $list->set_type(1);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
    </div>
</section>
<!-- } 히트상품 끝 -->
<?php } ?>

<?php if($default['de_type2_list_use']) { ?>
<!-- 추천상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2"><?php echo _t('추천상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('추천상품 모음'); ?></p>
    </header>
    <div style="border:1px solid #eee; border-bottom:2px solid #eee; border-radius:4px; padding:5px; background:#fbfbfb; margin:0 auto">
    <?php
    $list = new item_list();
    $list->set_type(2);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
    </div>
</section>
<!-- } 추천상품 끝 -->
<?php } ?>

<?php if($default['de_type3_list_use']) { ?>
<!-- 최신상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3"><?php echo _t('최신상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('최신상품 모음'); ?></p>
    </header>
    <div style="border:1px solid #eee; border-bottom:2px solid #eee; border-radius:4px; padding:5px; background:#fbfbfb; margin:0 auto">
    <?php
    $list = new item_list();
    $list->set_type(3);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
    </div>
</section>
<!-- } 최신상품 끝 -->
<?php } ?>

<?php if($default['de_type4_list_use']) { ?>
<!-- 인기상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4"><?php echo _t('인기상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('인기상품 모음'); ?></p>
    </header>
    <div style="border:1px solid #eee; border-bottom:2px solid #eee; border-radius:4px; padding:5px; background:#fbfbfb; margin:0 auto">
    <?php
    $list = new item_list();
    $list->set_type(4);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
    </div>
</section>
<!-- } 인기상품 끝 -->
<?php } ?>

<?php if($default['de_type5_list_use']) { ?>
<!-- 할인상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5"><?php echo _t('할인상품'); ?></a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> <?php echo _t('할인상품 모음'); ?></p>
    </header>
    <div style="border:1px solid #eee; border-bottom:2px solid #eee; border-radius:4px; padding:5px; background:#fbfbfb; margin:0 auto">
    <?php
    $list = new item_list();
    $list->set_type(5);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
    </div>
</section>
<!-- } 할인상품 끝 -->
<?php } ?>

<?php if(0) { ?>
<!-- 커뮤니티 최신글 시작 { -->
<section id="sidx_lat">
    <h2><?php echo _t('커뮤니티 최신글'); ?></h2>
    <?php echo latest('shop_basic_old', 'notice', 5, 30); ?>
    <?php echo latest('shop_basic_old', 'free', 5, 25); ?>
    <?php echo latest('shop_basic_old', 'qna', 5, 20); ?>
</section>
<!-- } 커뮤니티 최신글 끝 -->

<?php echo poll('shop_basic_old'); // 설문조사 ?>

<?php echo visit('shop_basic_old'); // 접속자 ?>
<?php } ?>

      <div class="main-page">
        <div class="row">
          <h2 class="sound_only"><?php echo _t('최신글'); ?></h2>
          <!--<div class="col-md-12">-->
            <div class="bs-component">

<!-- 최신글 시작 { -->
<?php
if(0) {
// 모든 테이블 최신글
$sql = " select bo_table from `{$g5['board_table']}` a left join `{$g5['group_table']}` b on (a.gr_id=b.gr_id)  where a.bo_device <> 'mobile' order by b.gr_order, a.bo_order ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i%2==1) $lt_style = "margin-left:20px";
    else $lt_style = "";
    echo latest("r_good_boot_basic", $row['bo_table'], 5, 25);
}
} /// if 0
?>
<?php
if(0) {
// '중앙 화면 관리'에 사용 등록된 테이블 최신글
for($i = 0; $i < $config2w['cf_max_main']; $i++) {
  if($config2w['cf_main_nouse_'.$i] == 'checked') continue;
  if($config2w['cf_main_name_'.$i] == '') continue;
  echo call_name($config2w['cf_main_name_'.$i]);
}
} /// if 0
?>
<?php
$width_main      = "100%";
$width_main_half = "50%";

for($i = 0; $i < $config2w['cf_max_main']; $i++) {

	if($config2w['cf_main_nouse_'.$i] == 'checked') continue;

	if($config2w['cf_main_name_'.$i] == '') continue;

	if($config2w['cf_main_long_'.$i] == "checked") {
		if(0) echo "
<table width=\"100%\" border=0 cellspacing=0 cellpadding=0 style=\"margin-left:0px;\">
<tr><td width=\"$width_main\" valign=\"top\">
<div class=\"{$config2w['cf_main_style_'.$i]}\">".call_name($config2w['cf_main_name_'.$i])."</div>
</td></tr>
</table>
";
		echo "
<div class=\"col-md-12\">".call_name($config2w['cf_main_name_'.$i])."</div>
";
	} else {
		if(0) echo "
<table width=\"100%\" border=0 cellspacing=0 cellpadding=0 style=\"margin-left:0px;\">
<tr><td width=\"$width_main_half\" valign=\"top\" style=\"padding:0 5px 0 0\">
<div class=\"{$config2w['cf_main_style_'.$i]}\">".call_name($config2w['cf_main_name_'.$i])."</div>
</td>
";
		echo "
<div class=\"col-md-6\">".call_name($config2w['cf_main_name_'.$i])."</div>
";
		$i++;
		if(0) echo "
<td width=\"$width_main_half\" valign=\"top\" style=\"padding:0 0 0 5px\">
<div class=\"{$config2w['cf_main_style_'.$i]}\">".call_name($config2w['cf_main_name_'.$i])."</div>
</td></tr>
</table>
";
		echo "
<div class=\"col-md-6\">".call_name($config2w['cf_main_name_'.$i])."</div>
";
	}
}
?>
<!-- } 최신글 끝 -->
            </div>
          <!--</div>-->
        </div>
      </div>
<?php
include_once(G5_TMPL_PATH.'/tail.php');
?>
