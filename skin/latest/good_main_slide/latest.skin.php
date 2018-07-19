<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if(gettype($options) == 'string') $options = explode('|', $options);
?>
<link rel="stylesheet" href="<?php echo $latest_skin_url?>/css/font-awesome.min.css">
<style>
	#slides<?php echo $bo_table?> {
		display: none;
		margin: 0 auto 20px; /* 추가 */
	}

	.slidesjs-navigation {
		margin-top:3px;
	}

	.slidesjs-previous {
		margin-right: 5px;
	 
	}

	.slidesjs-next {
		margin-right: 5px;
		
	}

	.slidesjs-pagination {
		margin: 6px 0 0;
		float: right;
		list-style: none;
	}

	.slidesjs-pagination li {
		float: left;
		margin: 0 1px;
	}

	.slidesjs-pagination li a {
		display: block;
		width: 13px;
		height: 0;
		padding-top: 13px;
		background-image: url("<?php echo $latest_skin_url?>/img/pagination.png");
		background-position: 0 0;
		float: left;
		overflow: hidden;
	}

	.slidesjs-pagination li a.active,
	.slidesjs-pagination li a:hover.active {
		background-position: 0 -13px
	}

	.slidesjs-pagination li a:hover {
		background-position: 0 -26px
	}

</style>
<div style="width:<?php echo $options[0]?>px;position:relative;">
<div id="slides<?php echo $bo_table?>" >
<?php
for ($i=0; $i<count($list); $i++) { 
	$noimage = "$latest_skin_url/img/no-image.gif";
	$list[$i][file] =get_file($bo_table, $list[$i][wr_id]);
	$imagepath = $list[$i][file][0][path]."/".$list[$i][file][0][file];
?>
<a href="<?php echo set_http($list[$i]['href'])?>"><img src="<?php echo $imagepath?>" alt="<?php echo $list[$i][wr_subject]?>" style='width:<?php echo $options[0]?>px;height:<?php echo $options[1]?>px;'></a>
<?php } ?>
<a href="#" style="position:absolute;top:<?php echo (($options[1]/2)-21)?>px;z-index:10;left:20px;" class="slidesjs-previous slidesjs-navigation" ><img src="<?php echo $latest_skin_url?>/img//btn_prev.png" alt=""></a>
<a href="#" style="position:absolute;top:<?php echo (($options[1]/2)-21)?>px;z-index:10;right:20px;" class="slidesjs-next slidesjs-navigation" ><img src="<?php echo $latest_skin_url?>/img/btn_next.png" alt=""></a>
</div>
</div>
<script src="<?php echo $latest_skin_url?>/js/jquery.slides.min.js"></script>
<script>
	$(function() {
		$('#slides<?php echo $bo_table?>').slidesjs({
			width: <?php echo $options[0]?>,
			height: <?php echo $options[1]?>,
			navigation: false,
			pagination: false,
			play: {
			active: false,
				// [boolean] Generate the play and stop buttons.
				// You cannot use your own buttons. Sorry.
			effect: "slide",
				// [string] Can be either "slide" or "fade".
			interval: 4000,
				// [number] Time spent on each slide in milliseconds.
			auto: true,
				// [boolean] Start playing the slideshow on load.
			swap: true,
				// [boolean] show/hide stop and play buttons
			pauseOnHover: false,
				// [boolean] pause a playing slideshow on hover
			restartDelay: 2500
				// [number] restart delay on inactive slideshow
			}
		});
	});
</script>
