<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>
<?php if(!defined('_INDEX_')) { ?>
</div>
<?php } ?>
<!-- end of body -->

<!-- tail -->
<!-- Footer -->
<footer class="w3-center w3-padding-16">
  <h4>SNS <?php echo _t('공유'); ?></h4>
  <a class="w3-button w3-large w3-black" href="<?php echo $facebook_url; ?>" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
  <a class="w3-button w3-large w3-black" href="<?php echo $twitter_url; ?>" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
  <a class="w3-button w3-large w3-black" href="<?php echo $gplus_url; ?>" title="Google +" target="_blank"><i class="fa fa-google-plus"></i></a>
  <a class="w3-button w3-large w3-black w3-hide-small" href="<?php echo $linkedin_url; ?>" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>
  <!--<a class="w3-button w3-large w3-black" href="<?php echo $instagram_url; ?>" title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a>-->
  <p>Powered by <a href="http://www.goodbuilder.co.kr" title="Good Builder" target="_blank" class="w3-hover-text-green">Goodbuilder</a></p>

  <div style="position:relative;bottom:100px;z-index:1;" class="w3-tooltip w3-right">
    <span class="w3-text w3-padding w3-black w3-hide-small"><?php echo _t('Go To Top'); ?></span>   
    <a class="w3-button w3-theme" href="#myPage"><span class="w3-xlarge">
    <i class="fa fa-chevron-circle-up"></i></span></a>
  </div>
</footer>

<!-- Navigation -->
<script>
// Script for side navigation
function w3_open() {
    var x = document.getElementById("mySidebar");
    x.style.width = "300px";
    x.style.paddingTop = "10%";
    x.style.display = "block";
}
// Close side navigation
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

<?php
if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>
<!-- } 하단 끝 -->

<!-- font resize -->
<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>
