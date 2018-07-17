<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/jquery.shop.list.js"></script>', 10);
?>

<script src="<?php echo G5_JS_URL ?>/jquery.fancylist.js"></script>
<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>

 
    <!-- 상품진열 10 시작 { -->
    <?php
    $li_width = intval(100 / $this->list_mod);
    $li_width_style = ' style="width:'.$li_width.'%;"';

    for ($i=0; $row=sql_fetch_array($result); $i++) {
        if ($i == 0) {
            if ($this->css) {
                echo "<ul class=\"{$this->css} main_item\">\n";
            } else {
                echo "<ul class=\"main_item sct sct_10\">\n";
            }
        }

        echo "<li class=\"sct_li\"><div class=\"sct_li_wr\">\n";

        echo"<div class=\"img_wr\">";

        if ($this->href) {
            echo "<div class=\"sct_img\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
        }

        if ($this->view_it_img) {
            echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
        }

        if ($this->href) {
            echo "</a></div>\n";
        }
  
        echo"<div class=\"sct_btn\">
                <div class=\"sct_cart_btn\">
                    <button type=\"button\" class=\"btn_cart\" data-it_id=\"{$row['it_id']}\"><span class=\"sound_only\">장바구니</span><i class=\"fa fa-shopping-cart\" aria-hidden=\"true\"></i></button>
                    <button type=\"button\" class=\"btn_wish\" data-it_id=\"{$row['it_id']}\"><span class=\"sound_only\">위시리스트</span><i class=\"fa fa-heart\" aria-hidden=\"true\"></i></button>
                </div>
            </div>\n";

        echo"</div>";

        echo "<div class=\"sct_cartop\"></div>\n";


        if ($this->view_it_id) {
            echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
        }

        if ($this->href) {
            echo "<div class=\"sct_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
        }

        if ($this->view_it_name) {
            echo stripslashes($row['it_name'])."\n";
        }

        if ($this->href) {
            echo "</a></div>\n";
        }

        if ($this->view_it_price) {
            echo "<div class=\"sct_cost\">\n";
            echo display_price(get_price($row), $row['it_tel_inq'])."\n";
            echo "</div>\n";
            }
        if ($this->view_it_icon) {
            echo "<div class=\"sct_icon_wr\">".item_icon2($row)."</div>\n";
        }

        echo "</div></li>\n";
    }

    if ($i > 0) echo "</ul>\n";

    if($i == 0) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
    ?>



<!-- } 상품진열 10 끝 -->
