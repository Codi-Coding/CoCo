<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

//print_r2($site);

?>

<div class="well well-sm" style="max-width:320px; margin:0px auto 15px;">
	<a href="<?php echo $site['url'];?>" target="_blank">
		<?php if($site['img']) { ?>
			<img src="<?php echo $site['img'];?>" alt="" style="display:block; margin-bottom:10px; width:100%;">
		<?php } ?>
		<strong class="ellipsis"><?php echo $site['title'];?></strong>
		<p class="ellipsis text-muted no-margin">
			<?php echo $site['desc'];?>
		</p>
	</a>
</div>