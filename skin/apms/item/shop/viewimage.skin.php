<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
	html { height:100% !important; }
	body { height:100% !important; background:#000 !important; overflow:hidden; padding:0; margin:0; }
</style>
<div>
	<img src="<?php echo $fileurl;?>" alt="" width="<?php echo $width;?>" height="<?php echo $height;?>" class="draggable" style="position:relative;top:0;left:0;cursor:move;">
</div>
<script>
	var win_w = <?php echo $width ?>;
	var win_h = <?php echo $height ?> + 70;
	var win_l = (screen.width - win_w) / 2;
	var win_t = (screen.height - win_h) / 2;

	if(win_w > screen.width) {
		win_l = 0;
		win_w = screen.width - 20;

		if(win_h > screen.height) {
			win_t = 0;
			win_h = screen.height - 40;
		}
	}

	if(win_h > screen.height) {
		win_t = 0;
		win_h = screen.height - 40;

		if(win_w > screen.width) {
			win_w = screen.width - 20;
			win_l = 0;
		}
	}

	window.moveTo(win_l, win_t);
	window.resizeTo(win_w, win_h);

	$(function() {
		var is_draggable = false;
		var x = y = 0;
		var pos_x = pos_y = 0;

		$(".draggable").mousemove(function(e) {
			if(is_draggable) {
				x = parseInt($(this).css("left")) - (pos_x - e.pageX);
				y = parseInt($(this).css("top")) - (pos_y - e.pageY);

				pos_x = e.pageX;
				pos_y = e.pageY;

				$(this).css({ "left" : x, "top" : y });
			}

			return false;
		});

		$(".draggable").mousedown(function(e) {
			pos_x = e.pageX;
			pos_y = e.pageY;
			is_draggable = true;
			return false;
		});

		$(".draggable").mouseup(function() {
			is_draggable = false;
			return false;
		});

		$(".draggable").dblclick(function() {
			window.close();
		});
	});
</script>