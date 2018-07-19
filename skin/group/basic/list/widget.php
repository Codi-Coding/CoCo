<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);
echo $wset['subj'];
?>
<div class="basic-group-list">
	<ul>
	<?php 
		if($wset['cache'] > 0) { // 캐시적용시
			echo apms_widget_cache($widget_path.'/widget.rows.php', $wname, $wid, $wset);
		} else {
			include($widget_path.'/widget.rows.php');
		}
	?>
	<?php if($setup_href) { ?>
		<li class="btn-wset text-center p10">
			<a href="<?php echo $setup_href;?>" class="win_memo">
				<span class="text-muted"><i class="fa fa-cog"></i> 위젯설정</span>
			</a>
		</li>
	<?php } ?>
	</ul>
</div>
