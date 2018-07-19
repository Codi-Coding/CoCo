<?php
define('_INDEX_', true);

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');

if(defined('G5_THEME_MAIN_BANNER')) {
    if(is_mobile()) $height_pgw = intval(420 * 1.5238); else $height_pgw = 420;
    if(is_mobile()) $height_skd = intval(228 * 1.5238); else $height_skd = 228;
    if(is_mobile()) $height_carousel = intval(227 * 1.5238); else $height_carousel = 227;
    if(is_mobile()) $height_bx = intval(360 * 1.5238); else $height_bx = 360;

    if(G5_THEME_MAIN_BANNER == 1)
        $banner_func = 'latest("good_webzine_full", "basic_main_banner", 1, 48)';
    else if(G5_THEME_MAIN_BANNER == 2)
        $banner_func = 'latest("r_good_slide_pgw", "basic_main_banner", 5, 0, 1, "960|'.$height_pgw.'")';
        ///$banner_func = 'latest("r_good_slide_skd", "basic_main_banner", 5, 0, 1, "600|'.$height_skd.'|full|sliding|1000")'; /// full/fixed, sliding/fading, 2000/1000
        ///$banner_func = 'latest("r_good_slide_carousel", "basic_main_banner", 5, 0, 1,  "600|'.$height_carousel.'")';
    else if(G5_THEME_MAIN_BANNER == 3)
        $banner_func = 'latest("r_good_slide_bx", "basic_main_banner", 5, 0, 1, "480|182|728|'.$height_bx.'|1")';
    else
        $banner_func = 'latest("good_webzine_full", "basic_main_banner", 1, 48)';
} else {
    $banner_func = 'latest("good_webzine_full", "basic_main_banner", 1, 48)';
}
?>
<?php
/// captcha support
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
$captcha_html = '';
$captcha_js   = '';
if ($is_guest) {
    $captcha_html = captcha_html();
    $captcha_js   = chk_captcha_js();
}

/// define write table
$main_banner_table = $g5['write_prefix'].'basic_main_banner';
$about_table = $g5['write_prefix'].'basic_about';
$service_table = $g5['write_prefix'].'basic_service';
$gallery_table = $g5['write_prefix'].'basic_gallery';
$contact_table = $g5['write_prefix'].'basic_contact';

/// get table info
$table_info['basic_main_banner'] = sql_fetch(" select * from {$g5['board_table']} where bo_table = 'basic_main_banner' ");
$table_info['basic_about'] = sql_fetch(" select * from {$g5['board_table']} where bo_table = 'basic_about' ");
$table_info['basic_service'] = sql_fetch(" select * from {$g5['board_table']} where bo_table = 'basic_service' ");
$table_info['basic_gallery'] = sql_fetch(" select * from {$g5['board_table']} where bo_table = 'basic_gallery' ");
$table_info['basic_contact'] = sql_fetch(" select * from {$g5['board_table']} where bo_table = 'basic_contact' ");

/// get main banner info
$main_banner_res = sql_query(" select * from {$main_banner_table} order by wr_id desc limit 1 ");
$main_banner_row[0] = sql_fetch_array($main_banner_res);
$main_banner_row[0]['file'] = get_file('basic_main_banner', $main_banner_row[0]['wr_id']);

/// get about info
$about_res = sql_query(" select * from {$about_table} order by wr_id asc limit 3 ");
$about_row[0] = sql_fetch_array($about_res);
$about_row[0]['file'] = get_file('basic_about', $about_row[0]['wr_id']);
$about_row[1] = sql_fetch_array($about_res);
$about_row[1]['file'] = get_file('basic_about', $about_row[1]['wr_id']);
$about_row[2] = sql_fetch_array($about_res);
$about_row[2]['file'] = get_file('basic_about', $about_row[2]['wr_id']);

/// get service info
$service_res = sql_query(" select * from {$service_table} order by wr_id asc limit 4 ");
$service_row[0] = sql_fetch_array($service_res);
$service_row[0]['file'] = get_file('basic_service', $service_row[0]['wr_id']);
$service_row[1] = sql_fetch_array($service_res);
$service_row[1]['file'] = get_file('basic_service', $service_row[1]['wr_id']);
$service_row[2] = sql_fetch_array($service_res);
$service_row[2]['file'] = get_file('basic_service', $service_row[2]['wr_id']);
$service_row[3] = sql_fetch_array($service_res);
$service_row[3]['file'] = get_file('basic_service', $service_row[3]['wr_id']);

/// get gallery info
$gallery_res = sql_query(" select * from {$gallery_table} order by wr_id desc limit 8 ");
$gallery_row[0] = sql_fetch_array($gallery_res);
$gallery_row[0]['file'] = get_file('basic_gallery', $gallery_row[0]['wr_id']);
$gallery_row[1] = sql_fetch_array($gallery_res);
$gallery_row[1]['file'] = get_file('basic_gallery', $gallery_row[1]['wr_id']);
$gallery_row[2] = sql_fetch_array($gallery_res);
$gallery_row[2]['file'] = get_file('basic_gallery', $gallery_row[2]['wr_id']);
$gallery_row[3] = sql_fetch_array($gallery_res);
$gallery_row[3]['file'] = get_file('basic_gallery', $gallery_row[3]['wr_id']);
$gallery_row[4] = sql_fetch_array($gallery_res);
$gallery_row[4]['file'] = get_file('basic_gallery', $gallery_row[4]['wr_id']);
$gallery_row[5] = sql_fetch_array($gallery_res);
$gallery_row[5]['file'] = get_file('basic_gallery', $gallery_row[5]['wr_id']);
$gallery_row[6] = sql_fetch_array($gallery_res);
$gallery_row[6]['file'] = get_file('basic_gallery', $gallery_row[6]['wr_id']);
$gallery_row[7] = sql_fetch_array($gallery_res);
$gallery_row[7]['file'] = get_file('basic_gallery', $gallery_row[7]['wr_id']);

/// multi lang
$table_info['basic_main_banner']['bo_subject'] = _t($table_info['basic_main_banner']['bo_subject']);
$table_info['basic_main_banner']['bo_explan'] = _t($table_info['basic_main_banner']['bo_explan']);
$table_info['basic_about']['bo_subject'] = _t($table_info['basic_about']['bo_subject']);
$table_info['basic_about']['bo_explan'] = _t($table_info['basic_about']['bo_explan']);
$table_info['basic_service']['bo_subject'] = _t($table_info['basic_service']['bo_subject']);
$table_info['basic_service']['bo_explan'] = _t($table_info['basic_service']['bo_explan']);
$table_info['basic_gallery']['bo_subject'] = _t($table_info['basic_gallery']['bo_subject']);
$table_info['basic_gallery']['bo_explan'] = _t($table_info['basic_gallery']['bo_explan']);
$table_info['basic_contact']['bo_subject'] = _t($table_info['basic_contact']['bo_subject']);
$table_info['basic_contact']['bo_explan'] = _t($table_info['basic_contact']['bo_explan']);

$main_banner_row[0]['wr_subject'] = _t($main_banner_row[0]['wr_subject']);
$main_banner_row[0]['wr_content'] = _t($main_banner_row[0]['wr_content']);
$main_banner_row[0]['wr_1'] = _t($main_banner_row[0]['wr_1']);
$main_banner_row[0]['wr_2'] = _t($main_banner_row[0]['wr_2']);
$main_banner_row[0]['wr_4'] = _t($main_banner_row[0]['wr_4']);

$about_row[0]['wr_subject'] = _t($about_row[0]['wr_subject']);
$about_row[0]['wr_content'] = _t($about_row[0]['wr_content']);
$about_row[1]['wr_subject'] = _t($about_row[1]['wr_subject']);
$about_row[1]['wr_content'] = _t($about_row[1]['wr_content']);
$about_row[2]['wr_subject'] = _t($about_row[2]['wr_subject']);
$about_row[2]['wr_content'] = _t($about_row[2]['wr_content']);

$service_row[0]['wr_subject'] = _t($service_row[0]['wr_subject']);
$service_row[0]['wr_content'] = _t($service_row[0]['wr_content']);
$service_row[1]['wr_subject'] = _t($service_row[1]['wr_subject']);
$service_row[1]['wr_content'] = _t($service_row[1]['wr_content']);
$service_row[2]['wr_subject'] = _t($service_row[2]['wr_subject']);
$service_row[2]['wr_content'] = _t($service_row[2]['wr_content']);
$service_row[3]['wr_subject'] = _t($service_row[3]['wr_subject']);
$service_row[3]['wr_content'] = _t($service_row[3]['wr_content']);

$gallery_row[0]['wr_subject'] = _t($gallery_row[0]['wr_subject']);
$gallery_row[0]['wr_content'] = _t($gallery_row[0]['wr_content']);
$gallery_row[1]['wr_subject'] = _t($gallery_row[1]['wr_subject']);
$gallery_row[1]['wr_content'] = _t($gallery_row[1]['wr_content']);
$gallery_row[2]['wr_subject'] = _t($gallery_row[2]['wr_subject']);
$gallery_row[2]['wr_content'] = _t($gallery_row[2]['wr_content']);
$gallery_row[3]['wr_subject'] = _t($gallery_row[3]['wr_subject']);
$gallery_row[3]['wr_content'] = _t($gallery_row[3]['wr_content']);
$gallery_row[4]['wr_subject'] = _t($gallery_row[4]['wr_subject']);
$gallery_row[4]['wr_content'] = _t($gallery_row[4]['wr_content']);
$gallery_row[5]['wr_subject'] = _t($gallery_row[5]['wr_subject']);
$gallery_row[5]['wr_content'] = _t($gallery_row[5]['wr_content']);
$gallery_row[6]['wr_subject'] = _t($gallery_row[6]['wr_subject']);
$gallery_row[6]['wr_content'] = _t($gallery_row[6]['wr_content']);
$gallery_row[7]['wr_subject'] = _t($gallery_row[7]['wr_subject']);
$gallery_row[7]['wr_content'] = _t($gallery_row[7]['wr_content']);

/// get conact & google map info
$contact_addr = array_map(trim, explode(':::', $config2w_def['cf_contact_info'])); 
$google_map_pos = $config2w_def['cf_google_map_pos']; 
$google_map_key = $config2w_def['cf_google_map_api_key']; 

$contact_addr[0] = _t($contact_addr[0]);
$contact_addr[1] = _t($contact_addr[1]);
$contact_addr[2] = _t($contact_addr[2]);
$contact_addr[3] = _t($contact_addr[3]);
?>

<!-- Header -->
<?php if(0) { ?>
<header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
  <?php if($is_admin) { ?><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_main_banner&amp;wr_id=<?php echo $main_banner_row[0]['wr_id']; ?>" style="text-decoration:none"><?php } ?><img class="w3-image" src="<?php echo $main_banner_row[0]['file'][0]['path']; ?>/<?php echo $main_banner_row[0]['file'][0]['file']; ?>" alt="<?php ///echo $main_banner_row[0]['wr_subject']; ?>" width="1500" height="800"><?php if($is_admin) { ?></a><?php } ?>
  <?php if(0) { ?>
  <div class="w3-display-middle w3-margin-top w3-center">
    <?php if($is_admin) { ?><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_main_banner&amp;wr_id=<?php echo $main_banner_row[0]['wr_id']; ?>" style="text-decoration:none"><?php } ?><h1 class="w3-xxlarge w3-text-white"><span class="w3-padding w3-black w3-opacity-min"><?php echo $main_banner_row[0]['wr_subject']; ?></span><!-- <span class="w3-hide-small w3-text-light-grey"></span>--></h1><?php if($is_admin) { ?></a><?php } ?>
  </div>
  <?php } ?>
</header>
<?php } ?>
<header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
  <?php echo call_name($banner_func);?>
</header>

<?php if(G5_THEME_MAIN_BANNER == 2) { ?>
<div class="w3-container w3-padding">
</div>
<?php } ?>

<!-- Page content -->
<div class="w3-content w3-padding" style="max-width:1564px">

<?php if(0) { ?>
  <!-- About Section -->
  <div class="w3-container w3-padding-32" id="about">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16"><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_about" style="text-decoration:none"><?php echo $table_info['basic_about']['bo_subject']; ?></a></h3>
    <p><?php echo nl2br($about_row[0]['wr_content']); ?></p>
  </div>
<?php } ?>

  <!-- About Section -->
  <div class="w3-container w3-padding-32" id="about">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16"><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_about" style="text-decoration:none"><?php echo $table_info['basic_about']['bo_subject']; ?></a></h3>
  </div>

  <div class="w3-row-padding">
    <div class="w3-third">
      <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_about&amp;wr_id=<?php echo $about_row[0]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $about_row[0]['file'][0]['path']; ?>/<?php echo $about_row[0]['file'][0]['file']; ?>" alt="<?php ///echo $about_row[0]['wr_subject']; ?>" style="width:100%" class="w3-hover-opacity"></a>
      <h4><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_about&amp;wr_id=<?php echo $about_row[0]['wr_id']; ?>" style="text-decoration:none"><?php echo $about_row[0]['wr_subject']; ?></a></h4>
      <p><?php echo nl2br($about_row[0]['wr_content']); ?></p>
    </div>
    <div class="w3-third">
      <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_about&amp;wr_id=<?php echo $about_row[1]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $about_row[1]['file'][0]['path']; ?>/<?php echo $about_row[1]['file'][0]['file']; ?>" alt="<?php ///echo $about_row[1]['wr_subject']; ?>" style="width:100%" class="w3-hover-opacity"></a>
      <h4><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_about&amp;wr_id=<?php echo $about_row[1]['wr_id']; ?>" style="text-decoration:none"><?php echo $about_row[1]['wr_subject']; ?></a></h4>
      <p><?php echo nl2br($about_row[1]['wr_content']); ?></p>
    </div>
    <div class="w3-third">
      <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_about&amp;wr_id=<?php echo $about_row[2]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $about_row[2]['file'][0]['path']; ?>/<?php echo $about_row[2]['file'][0]['file']; ?>" alt="<?php ///echo $about_row[2]['wr_subject']; ?>" style="width:100%" class="w3-hover-opacity"></a>
      <h4><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_about&amp;wr_id=<?php echo $about_row[2]['wr_id']; ?>" style="text-decoration:none"><?php echo $about_row[2]['wr_subject']; ?></a></h4>
      <p><?php echo nl2br($about_row[2]['wr_content']); ?></p>
    </div>
  </div>

  <!-- Service Section -->
  <div class="w3-container w3-padding-32" id="service">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16"><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_service" style="text-decoration:none"><?php echo $table_info['basic_service']['bo_subject']; ?></a></h3>
  </div>

  <div class="w3-row-padding /*w3-grayscale*/">
    <div class="w3-col l3 m6 w3-margin-bottom">
      <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_service&amp;wr_id=<?php echo $service_row[0]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $service_row[0]['file'][0]['path']; ?>/<?php echo $service_row[0]['file'][0]['file']; ?>" alt="<?php ///echo $service_row[0]['wr_subject']; ?>" class="w3-hover-opacity" style="width:100%"></a>
      <h4><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_service&amp;wr_id=<?php echo $service_row[0]['wr_id']; ?>" style="text-decoration:none"><?php echo $service_row[0]['wr_subject']; ?></a></h4>
      <p><?php echo $service_row[0]['wr_content']; ?></p>
      <!--<p><button class="w3-button w3-light-grey w3-block">Contact</button></p>-->
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_service&amp;wr_id=<?php echo $service_row[1]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $service_row[1]['file'][0]['path']; ?>/<?php echo $service_row[1]['file'][0]['file']; ?>" alt="<?php ///echo $service_row[1]['wr_subject']; ?>" class="w3-hover-opacity" style="width:100%"></a>
      <h4><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_service&amp;wr_id=<?php echo $service_row[1]['wr_id']; ?>" style="text-decoration:none"><?php echo $service_row[1]['wr_subject']; ?></a></h4>
      <p><?php echo $service_row[1]['wr_content']; ?></p>
      <!--<p><button class="w3-button w3-light-grey w3-block">Contact</button></p>-->
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_service&amp;wr_id=<?php echo $service_row[2]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $service_row[2]['file'][0]['path']; ?>/<?php echo $service_row[2]['file'][0]['file']; ?>" alt="<?php ///echo $service_row[2]['wr_subject']; ?>" class="w3-hover-opacity" style="width:100%"></a>
      <h4><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_service&amp;wr_id=<?php echo $service_row[2]['wr_id']; ?>" style="text-decoration:none"><?php echo $service_row[2]['wr_subject']; ?></a></h4>
      <p><?php echo $service_row[2]['wr_content']; ?></p>
      <!--<p><button class="w3-button w3-light-grey w3-block">Contact</button></p>-->
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_service&amp;wr_id=<?php echo $service_row[3]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $service_row[3]['file'][0]['path']; ?>/<?php echo $service_row[3]['file'][0]['file']; ?>" alt="<?php ///echo $service_row[3]['wr_subject']; ?>" class="w3-hover-opacity" style="width:100%"></a>
      <h4><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_service&amp;wr_id=<?php echo $service_row[3]['wr_id']; ?>" style="text-decoration:none"><?php echo $service_row[3]['wr_subject']; ?></a></h4>
      <p><?php echo $service_row[3]['wr_content']; ?></p>
      <!--<p><button class="w3-button w3-light-grey w3-block">Contact</button></p>-->
    </div>
  </div>

  <!-- Works Section -->
  <div class="w3-container w3-padding-32" id="gallery">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16"><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_gallery" style="text-decoration:none"><?php echo $table_info['basic_gallery']['bo_subject']; ?></a></h3>
  </div>

  <div class="w3-row-padding">
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding"><?php echo $gallery_row[0]['wr_subject']; ?></div>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_gallery&amp;wr_id=<?php echo $gallery_row[0]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $gallery_row[0]['file'][0]['path']; ?>/<?php echo $gallery_row[0]['file'][0]['file']; ?>" alt="<?php ///echo $gallery_row[0]['wr_subject']; ?>" class="w3-hover-opacity" style="width:99%"></a>
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding"><?php echo $gallery_row[1]['wr_subject']; ?></div>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_gallery&amp;wr_id=<?php echo $gallery_row[1]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $gallery_row[1]['file'][0]['path']; ?>/<?php echo $gallery_row[1]['file'][0]['file']; ?>" alt="<?php ///echo $gallery_row[1]['wr_subject']; ?>" class="w3-hover-opacity" style="width:99%"></a>
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding"><?php echo $gallery_row[2]['wr_subject']; ?></div>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_gallery&amp;wr_id=<?php echo $gallery_row[2]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $gallery_row[2]['file'][0]['path']; ?>/<?php echo $gallery_row[2]['file'][0]['file']; ?>" alt="<?php ///echo $gallery_row[2]['wr_subject']; ?>" class="w3-hover-opacity" style="width:99%"></a>
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding"><?php echo $gallery_row[3]['wr_subject']; ?></div>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_gallery&amp;wr_id=<?php echo $gallery_row[3]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $gallery_row[3]['file'][0]['path']; ?>/<?php echo $gallery_row[3]['file'][0]['file']; ?>" alt="<?php ///echo $gallery_row[3]['wr_subject']; ?>" class="w3-hover-opacity" style="width:99%"></a>
      </div>
    </div>
  </div>

  <div class="w3-row-padding">
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding"><?php echo $gallery_row[4]['wr_subject']; ?></div>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_gallery&amp;wr_id=<?php echo $gallery_row[4]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $gallery_row[4]['file'][0]['path']; ?>/<?php echo $gallery_row[4]['file'][0]['file']; ?>" alt="<?php ///echo $gallery_row[4]['wr_subject']; ?>" class="w3-hover-opacity" style="width:99%"></a>
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding"><?php echo $gallery_row[5]['wr_subject']; ?></div>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_gallery&amp;wr_id=<?php echo $gallery_row[5]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $gallery_row[5]['file'][0]['path']; ?>/<?php echo $gallery_row[5]['file'][0]['file']; ?>" alt="<?php ///echo $gallery_row[5]['wr_subject']; ?>" class="w3-hover-opacity" style="width:99%"></a>
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding"><?php echo $gallery_row[6]['wr_subject']; ?></div>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_gallery&amp;wr_id=<?php echo $gallery_row[6]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $gallery_row[6]['file'][0]['path']; ?>/<?php echo $gallery_row[6]['file'][0]['file']; ?>" alt="<?php ///echo $gallery_row[6]['wr_subject']; ?>" class="w3-hover-opacity" style="width:99%"></a>
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding"><?php echo $gallery_row[7]['wr_subject']; ?></div>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_gallery&amp;wr_id=<?php echo $gallery_row[7]['wr_id']; ?>" style="text-decoration:none"><img src="<?php echo $gallery_row[7]['file'][0]['path']; ?>/<?php echo $gallery_row[7]['file'][0]['file']; ?>" alt="<?php ///echo $gallery_row[7]['wr_subject']; ?>" class="w3-hover-opacity" style="width:99%"></a>
      </div>
    </div>
  </div>

  <!-- Contact Section -->
  <div class="w3-container w3-padding-32" id="contact">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16"><?php if($is_admin) { ?><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=basic_contact" style="text-decoration:none"><?php } ?><?php echo $table_info['basic_contact']['bo_subject']; ?><?php if($is_admin) { ?></a><?php } ?></h3>
    <p><?php echo $contact_addr[3]; ?></p>
    <form class="w3-container w3-card-4 w3-padding-16 w3-white" name="fwrite" method="post" action="<?php echo $g5['url']?>/bbs/write_update.php" onsubmit="return checkFrm(this);">
      <input type=hidden name=w        value="">
      <input type=hidden name=bo_table value="contact">
      <input type=hidden name=wr_id    value="">
      <input type=hidden name=sca      value="">
      <input type=hidden name=sfl      value="">
      <input type=hidden name=stx      value="">
      <input type=hidden name=spt      value="">
      <input type=hidden name=sst      value="">
      <input type=hidden name=sod      value="">
      <input type=hidden name=wr_1  value="답변 대기">
      <input class="w3-input" type="text" placeholder="<?php echo _t('이름'); ?>" required name="wr_name">
      <input class="w3-input w3-section" type="text" placeholder="<?php echo _t('이메일'); ?>" required name="wr_email">
      <input class="w3-input w3-section" type="text" placeholder="<?php echo _t('제목'); ?>" required name="wr_subject">
      <input class="w3-input w3-section" type="text" placeholder="<?php echo _t('내용'); ?>" required name="wr_content">
      <?php if ($is_guest) { //자동등록방지  ?>
      <div class="w3-section">      
        <?php echo $captcha_html ?>
      </div>  
      <?php } ?>
      <div class="w3-section">      
        <input class="w3-check" type="checkbox" checked name="wr_6" value="1">
        <label><?php echo _t('동의합니다'); ?> (<a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy" target="_blank"><?php echo _t('개인 정보 처리 방침'); ?></a>)</label>
      </div>  
      <button class="w3-button w3-black w3-section" type="submit">
        <i class="fa fa-paper-plane"></i> <?php echo _t('보내기'); ?> 
      </button>
      <!--<i class="fa fa-paper-plane"></i> <input type="submit" value="<?php echo _t('보내기'); ?>" class="w3-button w3-black w3-section">-->
    </form>
  </div>
  
</div>
<!-- End of page content -->

<!-- Google Maps -->
<div id="googleMap" style="width:100%;height:420px;"></div>
<script>
function myMap()
{
    myCenter=new google.maps.LatLng(<?php echo $google_map_pos; ?>);
    var mapOptions= {
        center:myCenter,
        zoom:12, scrollwheel: false, draggable: false,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    var map=new google.maps.Map(document.getElementById("googleMap"),mapOptions);

    var marker = new google.maps.Marker({
        position: myCenter,
    });
    marker.setMap(map);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_map_key; ?>&callback=myMap&language=<?php echo $g5['lang_js_list'][$g5['lang']]?>"></script>

<!-- Contact -->
<script type="text/javascript">
function checkFrm(obj) {
    if(obj.wr_6.checked == false) {
        alert('<?php echo _t('개인 정보 처리 방침 동의에 체크해 주세요.'); ?>');
        obj.wr_6.focus();
        return false;
    }    
}     
</script>
<script src="<?php echo G5_THEME_URL; ?>/js/common.extend.js"></script>
<script>
<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>
</script>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
