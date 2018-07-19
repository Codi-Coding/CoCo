<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
	body { background:#222; padding:0px; margin:0px; }
	#sit_pvi_nw {text-align:center; background:#222; margin-top:60px; }
	#sit_pvi_nwbig {padding:0;text-align:center}
	#sit_pvi_nwbig span {display:none}
	#sit_pvi_nwbig span.visible {display:inline}
	#sit_pvi_nwbig span.visible img { max-width:100%; height:auto; }
	.img_thumb_box { position:fixed; top:0; left:0; height:60px; width:100%; text-align:center; z-index:9999; background:#000; }
	.img_thumb img {width:60px;height:60px}
</style>
<div id="sit_pvi_nw">
    <div id="sit_pvi_nwbig">
        <?php
        $thumbnails = array();
        for($i=1; $i<=10; $i++) {
            if(!$row['it_img'.$i])
                continue;

            $file = G5_DATA_PATH.'/item/'.$row['it_img'.$i];
            if(is_file($file)) {
                // 썸네일
                $thumb = get_it_thumbnail($row['it_img'.$i], 60, 60);
                $thumbnails[$i] = $thumb;
                $imageurl = G5_DATA_URL.'/item/'.$row['it_img'.$i];
        ?>
        <span>
            <a href="javascript:window.close();">
                <img src="<?php echo $imageurl; ?>" alt="<?php echo $row['it_name']; ?>" id="largeimage_<?php echo $i; ?>">
            </a>
        </span>
        <?php
            }
        }
        ?>
    </div>
	<div class="img_thumb_box">
	<?php
		$total_count = count($thumbnails);
		$thumb_count = 0;
		if($total_count > 0) {
			foreach($thumbnails as $key=>$val) {
				echo '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it_id.'&amp;no='.$key.'" class="img_thumb">'.$val.'</a>';
			}
		}
	?>
	</div>
</div>

<script>
	// 창 사이즈 조절
	$(window).on("load", function() {
		var w = screen.width - 20;
		var h = screen.height - 40;
		window.resizeTo(w, h);
	});

	$(function(){
		$("#sit_pvi_nwbig span:eq("+<?php echo ($no - 1); ?>+")").addClass("visible");

		// 이미지 미리보기
		$(".img_thumb").bind("mouseover focus", function(){
			var idx = $(".img_thumb").index($(this));
			$("#sit_pvi_nwbig span.visible").removeClass("visible");
			$("#sit_pvi_nwbig span:eq("+idx+")").addClass("visible");
		});
	});
</script>