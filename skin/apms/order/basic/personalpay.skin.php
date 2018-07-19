<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

$item_w = apms_img_width($list_mods);

?>
<style>
	.ppay-row { float:left; width:<?php echo $item_w;?>%; }
</style>

<div class="ppay-wrap">
	<div class="ppay-container">
		<?php for($i=0; $i < count($list); $i++) { ?>
			<?php if($i > 0 && $i%$list_mods == 0) { ?>
				<div class="clearfix"></div>
			<?php } ?>
			<div class="ppay-row">
				<div class="ppay-box">
					<div class="ppay-fa">
						<a href="<?php echo $list[$i]['pp_href'];?>"><i class="fa fa-user"></i></a>
					</div>
					<h2><a href="<?php echo $list[$i]['pp_href'];?>"><?php echo display_price($list[$i]['pp_price']);?></a></h2>
					<p class="text-muted">
						<?php echo get_text($list[$i]['pp_name']);?>님 개인결제
					</p>
				</div>
			</div>
		<?php } ?>
		<div class="clearfix"></div>
	</div>
</div>
<?php if(!$i) echo '<div class="well text-center bg-colorset">등록된 개인결제가 없습니다.</div>'.PHP_EOL; ?>

<div class="text-center">
	<ul class="pagination pagination-sm">
		<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
	</ul>
</div>

<?php if ($is_admin || $setup_href) { ?>
	<div class="text-center">
		<?php if($is_admin) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.admin.php?ap=thema"><i class="fa fa-cog"></i> 설정</a>
		<?php } ?>
		<?php if($setup_href) { ?>
			<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
				<i class="fa fa-cogs"></i> 스킨설정
			</a>
		<?php } ?>
		<div class="h30"></div>
	</div>
<?php } ?>
