<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_CONTENTS_SKIN_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_MEDIAELEMENT_URL.'/mediaelementplayer.css">', 0);

// add_javascript('javascript 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript('<script src="'.G5_MEDIAELEMENT_URL.'/mediaelement-and-player.min.js"></script>', 0);
?>

<video id="player" preload="none">
    <?php echo $video_source; ?>
</video>

<script>
$(function() {
    var w = $(window).width();
    var h = $(window).height() - 3;

    //alert(w + ' ' + h);

    $("video#player")
        .attr("width", w)
        .attr("height", h)
        .mediaelementplayer({
            enableAutosize: true,
            success: function (mediaElement, domObject) {
                //alert(mediaElement.getAttribute("width") + " " + mediaElement.getAttribute("height"));
            }
        });
});
</script>