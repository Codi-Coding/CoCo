<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
	html { height:100% !important; }
	body { height:100% !important; background:#000 !important; overflow:hidden; padding:0; margin:0; }
</style>

<iframe src="http://docs.google.com/gview?url=<?php echo urlencode($fileurl);?>&embedded=true" style="width:100%; height:100%;" frameborder="0"></iframe>

<script>
	var win_w = screen.width;
	var win_h = screen.height - 40;

	window.moveTo(0, 0);
	window.resizeTo(win_w, win_h);
</script>