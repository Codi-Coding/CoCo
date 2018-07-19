<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_CONTENTS_SKIN_URL.'/style.css">', 0);

add_javascript('<script src="'.G5_CONTENTS_SKIN_URL.'/jquery.easing.1.3.min.js"></script>', 0);
?>

<!-- 상품진열 20 시작 { -->
<?php
for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($i == 1) {
        if ($this->css) {
            echo "<div id=\"cmt_{$this->type}\" class=\"{$this->css}\"><div class=\"cct_box\"><div class=\"cct_20\"><ul class=\"cct cct_ul\">\n";
        } else {
            echo "<div id=\"cmt_{$this->type}\" class=\"cct_wrap\"><div class=\"cct_box\"><div class=\"cct_20\"><ul class=\"cct cct_ul\">\n";
        }
    }

    echo "<li class=\"cct_li\" style=\"width:{$this->img_width}px\">\n";

    if ($this->href) {
        echo "<div class=\"cct_img\"><p class=\"goods_tit\"><a href=\"{$this->href}{$row['it_id']}\" class=\"cct_a\">\n";
    }

    if ($this->view_it_img) {
        echo cm_get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes(_t($row['it_name'])))."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->view_it_icon) {
        echo "<div class=\"sct_icon\">".cm_item_icon($row)."</div>\n";
    }

    if ($this->view_it_id) {
        echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
    }

    if ($this->href) {
        echo "<div class=\"cct_tit\"><span class=\"goods_tit\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes(_t($row['it_name']))."\n";
    }
    if ($this->href) {
        echo "</a></span>\n";
    }


    if ($this->view_it_basic && $row['it_basic']) {
        echo "<span class=\"goods_basic\">".stripslashes(_t($row['it_basic']))."</span>\n";
    }

    echo "</div>\n";


    if ($this->view_it_price || $this->view_it_sum_qty || $this->view_it_wish_qty) {
        echo "<div class=\"cct_price\">\n";
        if($this->view_it_wish_qty)
            echo "<span class=\"wish_c\">"._t("찜")." ".number_format($row['it_wish_qty'])."</span>\n";
        if($this->view_it_sum_qty)
            echo "<span class=\"buy_c\">"._t("구매")." ".number_format($row['it_sum_qty'])."</span>\n";
        echo "<span class=\"goods_price\">" .cm_display_price(cm_get_price($row), $row['it_tel_inq'])." </span>\n";
        echo "</div>\n";
    }

    if ($this->view_sns) {
        $sns_top = $this->img_height + 10;
        $sns_url  = G5_CONTENTS_URL.'/item.php?it_id='.$row['it_id'];
        $sns_title = get_text(_t($row['it_name'])).' | '.get_text($config['cf_title']);
        echo "<div class=\"cct_sns\" style=\"top:{$sns_top}px\">";
        echo cm_get_sns_share_link('facebook', $sns_url, $sns_title, G5_CONTENTS_SKIN_URL.'/img/sns_fb_s.png');
        echo cm_get_sns_share_link('twitter', $sns_url, $sns_title, G5_CONTENTS_SKIN_URL.'/img/sns_twt_s.png');
        echo cm_get_sns_share_link('googleplus', $sns_url, $sns_title, G5_CONTENTS_SKIN_URL.'/img/sns_goo_s.png');
        echo "</div>\n";
    }

    echo "</li>\n";
}

if ($i > 1) {
    echo "</ul></div>\n";
    if($i >= 4) {
        echo "<button type=\"button\" class=\"btn_ctrl btn_prev\">"._t("이전")."</button>";
        echo "<button type=\"button\" class=\"btn_ctrl btn_next\">"._t("다음")."</button>";
    }
    echo "</div>\n";
    echo "</div>\n";
}



if($i == 1) echo "<p class=\"cct_noitem\">"._t("등록된 상품이 없습니다.")."</p>\n";
?>

<script>
(function($) {
    var intervals = {};
    var timeouts = {};

    var methods = {
        init: function(option)
        {
            if(this.length < 1)
                return false;

            var $wrap = this.find("ul");
            var $items = $wrap.find("li");
            var $items_a = $items.find("a");
            var $btn = this.find("button");
            var height = 0;
            var item_width = 0;
            var wrp_width = 0;
            var count = $items.size();
            var fx = null;
            var el_id = this[0].id;

            $items.each(function(index) {
                var h = $(this).outerHeight(true);
                var w = $(this).outerWidth(true);

                wrp_width += w;

                if(h > height)
                    height = h;

                if(index == 0)
                    item_width = w;
            });

            this.height(height);
            $wrap.width(wrp_width).height(height);

            // 기본 설정값
            var settings = $.extend({
                limit : 4,
                interval: 2000,
                duration: 300,
                ease: "easeInExpo"
            }, option);

            if(count < settings.limit)
                return;

            $wrap.css("left", "-"+item_width+"px");

            set_interval();

            $items.hover(
                function() {
                    clear_interval();
                    button_show();
                },
                function() {
                    set_interval();
                    button_hide();
                }
            );

            $items_a.on("focusin", function() {
                clear_interval();
                button_show();
            });

            $items_a.on("focusout", function() {
                set_interval();
                button_hide();
            });

            $btn.on("mouseover focusin", function() {
                clear_interval();
                button_show();
            });

            $btn.on("mouseout focusout", function() {
                set_interval();
                button_hide();
            });

            $btn.on("click", function() {
                if($wrap.is(":animated"))
                    return;

                if($(this).hasClass("btn_prev")) {
                    prev();
                } else if($(this).hasClass("btn_next")) {
                    next();
                }
            });

            function rolling() {
                $wrap
                    .stop()
                    .animate(
                        {'left':"-"+(item_width * 2)+"px"}, settings.duration, settings.ease,
                        function() {
                            $(this).find('li:first').appendTo(this);
                            $(this).css({ 'left':"-"+item_width+"px" });
                    });
            }

            function prev() {
                clear_interval();
                clear_timeout();

                $wrap
                    .stop()
                    .animate({'left':0}, settings.duration, settings.ease,
                        function() {
                            $(this).children('li:last').prependTo(this);
                            $(this).css({'left':"-"+item_width+"px"});
                });
            }

            function next() {
                clear_interval();
                clear_timeout();

                $wrap
                    .stop()
                    .animate({'left':"-"+(item_width*2)+"px"}, settings.duration, settings.ease,
                        function(){
                            $(this).children('li:first').appendTo(this);
                            $(this).css({'left':"-"+item_width+"px"});
                });
            }

            function button_show() {
                clear_timeout();

                $btn.fadeIn(200);
            }

            function button_hide() {
                clear_timeout();

                timeouts[el_id] = setTimeout(function() { $btn.fadeOut(200); }, 300);
            }

            function set_interval() {
                if(count >= settings.limit) {
                    clear_interval();

                    intervals[el_id] = setInterval(rolling, settings.interval);
                }
            }

            function clear_interval() {
                if(intervals[el_id]) {
                    clearInterval(intervals[el_id]);
                }
            }

            function clear_timeout() {
                if(timeouts[el_id]) {
                    clearTimeout(timeouts[el_id]);
                }
            }
        },
        stop: function()
        {
            var el_id = this[0].id;
            if(intervals[el_id])
                clearInterval(intervals[el_id]);
        }
    };

    $.fn.UIRolling = function(option) {
        if (methods[option])
            return methods[option].apply(this, Array.prototype.slice.call(arguments, 1));
        else
            return methods.init.apply(this, arguments);
    }
}(jQuery));

$(function() {
    $("#cmt_<?php echo $this->type; ?>").UIRolling();
    // 기본 설정값을 변경하려면 아래처럼 사용
    //$("#cmt_<?php echo $this->type; ?>").UIRolling({ limit: 4, interval: 2000, duration: 300, ease: "easeInExpo" });
});
</script>
<!-- } 상품진열 20 끝 -->
