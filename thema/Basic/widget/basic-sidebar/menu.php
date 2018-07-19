<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가
?>

<!-- Categroy -->
<div class="div-title-underline-thin en">
	<b>MENU</b>
</div>

<div class="sidebar-icon-tbl">
	<div class="sidebar-icon-cell">
		<a href="<?php echo $at_href['home']; ?>">
			<i class="fa fa-home circle light-circle normal"></i>
			<span>홈으로</span>
		</a>
	</div>
	<div class="sidebar-icon-cell">
		<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo_event;?>">
			<i class="fa fa-gift circle light-circle normal"></i>
			<span>이벤트</span>
		</a>
	</div>
	<div class="sidebar-icon-cell">
		<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo_chulsuk;?>">
			<i class="fa fa-calendar-check-o circle light-circle normal"></i>
			<span>출석부</span>
		</a>
	</div>
	<div class="sidebar-icon-cell">
		<a href="<?php echo $at_href['secret'];?>">
			<i class="fa fa-commenting circle light-circle normal"></i>
			<span>1:1 문의</span>
		</a>
	</div>
</div>

<div class="sidebar-menu panel-group" id="<?php echo $menu_id;?>" role="tablist" aria-multiselectable="true">
	<?php 
		for($i=1; $i < $menu_cnt; $i++) { 
			$cate_id = $menu_id.'_c'.$i;
			$sub_id = $menu_id.'_s'.$i;
	?>
		<?php if($menu[$i]['is_sub']) { //서브메뉴가 있을 때 ?>
			<div class="panel">
				<div class="ca-head<?php echo ($menu[$i]['on'] == "on") ? ' active' : '';?>" role="tab" id="<?php echo $cate_id;?>">
					<a href="#<?php echo $sub_id;?>" data-toggle="collapse" data-parent="#<?php echo $menu_id;?>" aria-expanded="true" aria-controls="<?php echo $sub_id;?>" class="is-sub">
						<span class="ca-href pull-right" onclick="sidebar_href('<?php echo $menu[$i]['href']; ?>');">&nbsp;</span>
						<?php echo $menu[$i]['name']; ?>
						<?php echo ($menu[$i]['new'] == "new") ? $menu_new : '';?>
					</a>
				</div>
				<div id="<?php echo $sub_id;?>" class="panel-collapse collapse<?php echo ($menu[$i]['on'] == "on") ? ' in' : '';?>" role="tabpanel" aria-labelledby="<?php echo $cate_id;?>">
					<ul class="ca-sub">
					<?php for($j=0; $j < count($menu[$i]['sub']); $j++) { ?>
						<?php if($menu[$i]['sub'][$j]['line']) { //구분라인 ?>
							<li class="ca-line">
								<?php echo $menu[$i]['sub'][$j]['line'];?>
							</li>
						<?php } ?>
						<li<?php echo ($menu[$i]['sub'][$j]['on'] == "on") ? ' class="on"' : '';?>>
							<a href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
								<?php echo $menu[$i]['sub'][$j]['name']; ?>
								<?php echo ($menu[$i]['sub'][$j]['new'] == "new") ? $menu_new : '';?>
							</a>
						</li>
					<?php } ?>
					</ul>
				</div>
			</div>
		<?php } else { ?>
			<div class="panel">
				<div class="ca-head<?php echo ($menu[$i]['on'] == "on") ? ' active' : '';?>" role="tab">
					<a href="<?php echo $menu[$i]['href'];?>"<?php echo $menu[$i]['target'];?> class="no-sub">
						<?php echo $menu[$i]['name'];?>
						<?php echo ($menu[$i]['new'] == "new") ? $menu_new : '';?>
					</a>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
</div>

<div class="h20"></div>

<!-- Stats -->
<div class="div-title-underline-thin en">
	<b>STATS</b>
</div>

<ul style="padding:0px 15px; margin:0; list-style:none;">
	<li><a href="<?php echo $at_href['connect'];?>">
		<span class="pull-right"><?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb'] > 0) ? '(<b class="orangered">'.number_format($stats['now_mb']).'</b>)' : ''; ?> 명</span>현재 접속자</a>
	</li>
	<li><span class="pull-right"><?php echo number_format($stats['visit_today']); ?> 명</span>오늘 방문자</li>
	<li><span class="pull-right"><?php echo number_format($stats['visit_yesterday']); ?> 명</span>어제 방문자</li>
	<li><span class="pull-right"><?php echo number_format($stats['visit_max']); ?> 명</span>최대 방문자</li>
	<li><span class="pull-right"><?php echo number_format($stats['visit_total']); ?> 명</span>전체 방문자</li>
	<li><span class="pull-right"><?php echo number_format($menu[0]['count_write']); ?> 개</span>전체 게시물</li>
	<li><span class="pull-right"><?php echo number_format($menu[0]['count_comment']); ?> 개</span>전체 댓글수</li>
	<li><span class="pull-right sidebar-tip" data-original-title="<nobr>오늘 <?php echo $stats['join_today'];?> 명 / 어제 <?php echo $stats['join_yesterday'];?> 명</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><?php echo number_format($stats['join_total']); ?> 명</span>전체 회원수
	</li>
</ul>
