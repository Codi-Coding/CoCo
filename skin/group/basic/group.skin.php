<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 헤더 출력
if(isset($wset['hskin']) && $wset['hskin']) {
	$header_skin = $wset['hskin'];
	$header_color = $wset['hcolor'];
	include_once('./header.php');
}

// 타이틀 출력
if(!isset($wset['title']) || (isset($wset['title']) && !$wset['title'])) {
	echo apms_widget('title', 'group-title-'.$gr_id, '', '', $group_skin_path);
	echo '<div class="h30"></div>';
}
?>

<!-- 2단 그룹메인 -->

<?php if(!isset($wset['best']) || (isset($wset['best']) && !$wset['best'])) { // 베스트 ?>
	<div class="row">
		<div class="col-sm-6">
			<div class="div-title-wrap">
				<div class="div-title">
					<b>월간 베스트</b>
				</div>
				<div class="div-sep-wrap">
					<div class="div-sep sep-bold"></div>
				</div>
			</div>
			<?php // 최근 30일간 베스트 
				echo apms_widget('list', 'group-month-'.$gr_id, 'rows=10 gr_list='.$gr_id.' cache=300 rank=red sort=hit term=day dayterm=30 date=m.d', 'rows=7', $group_skin_path);
			?>
			<div class="h30"></div>
		</div>
		<div class="col-sm-6">
			<div class="div-title-wrap">
				<div class="div-title">
					<b>주간 베스트</b>
				</div>
				<div class="div-sep-wrap">
					<div class="div-sep sep-bold"></div>
				</div>
			</div>
			<?php // 최근 7일간 베스트 
				echo apms_widget('list', 'group-week-'.$gr_id, 'rows=10 gr_list='.$gr_id.' cache=300 rank=green sort=hit term=day dayterm=7 date=m.d', 'rows=7', $group_skin_path);
			?>
			<div class="h30"></div>
		</div>
	</div>
	<div class="h30"></div>
<?php } //베스트 끝 ?>

<div class="row">
<?php 
// 보드추출
$bo_device = (G5_IS_MOBILE) ? 'pc' : 'mobile';
$sql = " select bo_table, bo_subject from {$g5[board_table]} where gr_id = '{$gr_id}' and bo_list_level <= '{$member[mb_level]}' and bo_device <> '{$bo_device}' and as_show = '1' ";
if(!$is_admin) $sql .= " and bo_use_cert = '' ";
$sql .= " order by as_order, bo_order ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
	<?php if($i > 0 && $i%2 == 0) { ?>
			</div>
		<div class="row">
	<?php } ?>
	<div class="col-sm-6">
		<div class="div-title-wrap">
			<div class="div-title">
				<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $row['bo_table']; ?>">
					<b><?php echo get_text($row['bo_subject']); ?></b>
				</a>
			</div>
			<div class="div-sep-wrap">
				<div class="div-sep sep-bold"></div>
			</div>
		</div>

		<?php //보드별 추출 
			echo apms_widget('list', 'group-list-'.$row['bo_table'], 'rows=10 bo_list='.$row['bo_table'].' cache=300 icon={아이콘:caret-right} date=m.d', 'rows=7', $group_skin_path);
		?>

		<div class="h30"></div>
	</div>
<?php } ?>
</div>

<?php if($setup_href) { ?>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>
