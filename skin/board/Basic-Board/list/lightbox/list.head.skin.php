<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<?php if($notice_count > 0) { //공지사항 ?>
	<div class="panel panel-default list-notice">
		<div class="panel-heading">
			<h4 class="panel-title">Notice</h4>
		</div>
		<div class="list-group">
			<?php for ($i=0; $i < $notice_count; $i++) { 
					if(!$list[$i]['is_notice']) break; //공지가 아니면 끝냄 
			?>
				 <a href="<?php echo $list[$i]['href'];?>" class="list-group-item ellipsis"<?php echo $is_modal_js;?>>
					<span class="hidden-xs pull-right font-12 black">
						<i class="fa fa-clock-o"></i> <?php echo apms_datetime($list[$i]['date'], "Y.m.d");?>
					</span>
					<span class="wr-notice"></span>
					<strong class="black"><?php echo $list[$i]['subject'];?></strong>
					<?php if($list[$i]['wr_comment']) { ?>
						<span class="count red"><?php echo $list[$i]['wr_comment'];?></span>
					<?php } ?>
				</a>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<?php 
if($is_category) 
	include_once($board_skin_path.'/category.skin.php'); // 카테고리	
?>
