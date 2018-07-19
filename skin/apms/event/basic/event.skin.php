<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>

<?php for($i=0; $i < count($event); $i++) { // 배너만 출력함 ?>
	<div class="div-title-wrap">
		<div class="div-title"><a href="<?php echo $event[$i]['ev_href'];?>"><b><?php echo $event[$i]['ev_subject'];?></b></a></div>
		<div class="div-sep-wrap">
			<div class="div-sep sep-bold"></div>
		</div>
	</div>
	<div class="event-img">
		<a href="<?php echo $event[$i]['ev_href'];?>">
			<img src="<?php echo $event[$i]['ev_banner'];?>" alt="<?php echo $event[$i]['ev_subject'];?>" class="img-responsive img-center">
		</a>
	</div>
	<?php if($wset['shadow']) echo apms_shadow($wset['shadow']);?>
	<div class="h30"></div>
<?php } ?>

<?php if(!$i) { ?>
	<div class="event-none text-center text-muted">현재 진행 중인 이벤트가 없습니다.</div>
<?php } ?>

<?php if($total_page > 1) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
		<div class="clearfix"></div>
	</div>
<?php } ?>

<?php if ($is_admin || $setup_href || $admin_href) { ?>
	<div class="text-center">
		<?php if ($admin_href) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo $admin_href;?>"><i class="fa fa-th-large"></i> 관리</a>
		<?php } ?>
		<?php if($is_admin) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.admin.php?ap=thema"><i class="fa fa-cog"></i> 설정</a>
		<?php } ?>
		<?php if ($setup_href) { ?>
			<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>"><i class="fa fa-cogs"></i> 스킨설정</a>
		<?php } ?>
		<div class="h30"></div>
	</div>
<?php } ?>
