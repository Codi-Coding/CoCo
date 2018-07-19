<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
	html { height:100% !important; }
	body { height:100% !important; background:#000 !important; overflow:hidden; padding:0; margin:0; }
</style>

<script type="text/javascript" src="<?php echo G5_PLUGIN_URL;?>/jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="<?php echo APMS_JWPLAYER6_KEY;?>";</script>

<div id="player">Loading the player...</div>

<script type="text/javascript">
	var win_w = 640;
	var win_h = 480;
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

	jwplayer("player").setup({
		file: "<?php echo $fileurl;?>",
		<?php echo $image;?>
		<?php echo $caption;?>
		autostart: true,
		width: "100%",
		height: "100%"
	});
</script>
