<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

// 링크 열기
$wset['modal_js'] = ($wset['modal'] == "1") ? apms_script('modal') : '';

$wset['thumb_w'] = (isset($wset['thumb_w']) && $wset['thumb_w'] > 0) ? $wset['thumb_w'] : 400;
$wset['thumb_h'] = (isset($wset['thumb_h']) && $wset['thumb_h'] > 0) ? $wset['thumb_h'] : 300;
$img_h = apms_img_height($wset['thumb_w'], $wset['thumb_h'], '75');

$wset['line'] = (isset($wset['line']) && $wset['line'] > 0) ? $wset['line'] : 3;
$line_height = 20 * $wset['line'] + 4;
$img_height = $line_height + 22;
$img_width = round($img_height / ($img_h / 100));

// 랜덤아이디
$widget_id = apms_id(); // Random ID
?>
<style>
	#<?php echo $widget_id;?> .post-image { width:<?php echo $img_width;?>px; height:<?php echo $img_height;?>px; }
	#<?php echo $widget_id;?> .post-subject { height:<?php echo $line_height;?>px; }
	#<?php echo $widget_id;?> .img-wrap { padding-bottom:<?php echo $img_h;?>%; }
</style>
<div id="<?php echo $widget_id;?>" class="basic-post-mix">
	<?php
		if($wset['cache'] > 0) { // 캐시적용시
			echo apms_widget_cache($widget_path.'/widget.rows.php', $wname, $wid, $wset);
		} else {
			include($widget_path.'/widget.rows.php');
		}
	?>
</div>
<?php if($setup_href) { ?>
	<div class="btn-wset text-center p10">
		<a href="<?php echo $setup_href;?>" class="win_memo">
			<span class="text-muted"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>
