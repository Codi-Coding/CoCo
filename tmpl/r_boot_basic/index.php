<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if($site_name == '') $site_name = $config['cf_title']; /// 2010.11.25
$index_title = trim("$site_name $index_title_comment ");

$g5['title'] = $index_title;
$main_page = 1; /// main, subpage 구분을 위해 추가.  2013.01.18
include_once(G5_TMPL_PATH.'/head.php');

// 좌측 사이드, 상단, 메인 시작 (아래 width 관련 내용들 반응형에서는 미사용)
$width_main = $config2w['cf_width_main'];
$width_main_left = $config2w['cf_width_main_left'];
$width_main_right = $config2w['cf_width_main_right'];

/// 서브 페이지의 경우 레이아웃 조정
$hide_left = $config2w['cf_hide_left'];
$hide_right = $config2w['cf_hide_right'];

if(!$main_page) {
    if($hide_left) {
        $width_main += $width_main_left;
        $width_main_left = 0;
    }
    if($hide_right) {
        $width_main += $width_main_right;
        $width_main_right = 0;
    }
}
?>
      <?php if(0) { ?>
      <div class="main-page">
        <div class="row">
          <h2 class="sound_only"><?php echo _t('메인 배너'); ?></h2>
          <div class="col-md-12">
            <div class="bs-component">
<table width="100%" border=0 cellspacing=0 cellpadding=0 style="margin:0;padding:0"><tr><td align=center>
<?php /// echo latest("good_webzine_full", "gallery_main_ad", 1, 0); /// 간단히 그림만 표시할 경우 ?>
<?php /// $options = array("480","140"); echo latest("r_good_slide_pgw", "gallery_main_ad", 5, 0, 1, $options); /// 넚이 480 이하로 지정 ?>
<?php $options = array("600","197"); echo latest("r_good_slide_carousel", "gallery_main_ad", 5, 0, 1, $options);?>
<?php /// $options = array("600","197", "full", "sliding", "2000"); echo latest("r_good_slide_skd", "gallery_main_ad", 5, 0, 1, $options); /// full/fixed, sliding/fading, 2000/1000 ?>
</td></tr></table> 
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

      <div class="main-page">
        <div class="row">
          <h2 class="sound_only"><?php echo _t('최신글'); ?></h2>
          <div class="col-md-12">
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
// '중앙 화면 관리'에 사용 등록된 테이블 최신글
for($i = 0; $i < $config2w['cf_max_main']; $i++) {
  if($config2w['cf_main_nouse_'.$i] == 'checked') continue;
  if($config2w['cf_main_name_'.$i] == '') continue;
  echo call_name($config2w['cf_main_name_'.$i]);
}
?>
<!-- } 최신글 끝 -->
            </div>
          </div>
        </div>
      </div>
<?php
include_once(G5_TMPL_PATH.'/tail.php');
?>
