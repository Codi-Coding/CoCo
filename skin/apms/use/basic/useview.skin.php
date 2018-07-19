<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

$img = apms_it_thumbnail($view, 80, 80, false, true);
$it_price = ($view['it_tel_inq']) ? '전화문의' : number_format(get_price($view));

?>

<div class="view-wrap<?php echo (G5_IS_MOBILE) ? ' view-mobile font-14' : '';?>">
	<h1><?php if($view['is_photo']) { ?><img src="<?php echo $view['is_photo'];?>" class="photo" alt=""><?php } ?><?php echo $view['is_subject']; ?></h1>
	<div class="panel panel-default view-head" style="border-bottom:0;">
		<div class="panel-heading">
			<div class="font-12 text-muted">
				<?php echo apms_get_star($view['is_score'],'red font-14'); //별점 ?>
				<span class="sp"></span>
				<i class="fa fa-user"></i>
				<?php echo $view['is_name']; //등록자 ?>
				<span class="sp"></span>
				<i class="fa fa-clock-o"></i>
				<?php echo apms_date($view['is_time'], 'orangered', 'before'); //시간 ?>
			</div>
		</div>
	</div>

	<div class="view-content">
		<?php echo get_view_thumbnail($view['is_content'], $default['pt_img_width']); ?>
	</div>

	<div class="view-sns text-right">
		<?php 
			$sns_url  = G5_SHOP_URL.'/itemuseview.php?is_id='.$is_id;
			$sns_title = get_text($view['is_subject'].' : '.$view['it_name'].' | '.$config['cf_title']);
			$sns_img = $skin_url.'/img';
			echo apms_sns_share_icon($sns_url, $sns_title, $seometa['img']['src'], $sns_img);
		?>
	</div>

	<?php if($view['is_reply']) {
		//답글제목 : $view['is_reply_subject']
		//답글작성 : $view['is_reply_name']	
	?>
		<div class="view-content well" style="padding:15px;">
			<?php echo get_view_thumbnail($view['is_reply_content'], $default['pt_img_width']); ?>
		</div>
	<?php } ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Review Item</h3>
		</div>
		<div class="panel-body">
			<div class="item-media">
				<div class="media">
					<div class="item-photo pull-left">
						<?php echo ($img['src']) ? '<img src="'.$img['src'].'" alt="'.$img['src'].'">' : '<i class="fa fa-cube></i>'; ?>
					</div>
					<div class="media-body">
						<div class="media-heading">
							<a href="<?php echo $view['it_href'] ?>">
								<b><?php echo $view['it_name'] ?></b>
							</a>
						</div>
						<div class="media-info text-muted">
							<?php echo apms_get_star($view['it_use_avg'],'red font-14'); //평균별점 ?>
							<span class="sp"></span>
							<i class="fa fa-comment"></i> <?php echo ($view['pt_comment']) ? '<b class="red">'.number_format($view['pt_comment']).'</b>' : 0;?>
							<span class="hidden-xs">
								<span class="sp"></span>
								<i class="fa fa-krw"></i> <?php echo $it_price;?>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="view-btn">
	<div class="form-group pull-left">
		<button type="button" onclick="apms_print();" class="btn btn-black btn-sm"><i class="fa fa-print"></i> 프린트</button>
		<a href="./itemuselist.php?sfl=<?php echo urlencode('a.it_id');?>&amp;stx=<?php echo urlencode($view['it_id']);?>" class="btn btn-black btn-sm"><i class="fa fa-eye"></i> 더보기</a>
	</div>
	<div class="form-group pull-right">
		<?php if($view['is_edit_href']) { ?>
			<a href="<?php echo $view['is_edit_href']; ?>" class="btn btn-black btn-sm"><i class="fa fa-plus"></i><span class="hidden-xs"> 수정</span></a>
		<?php } ?>
		<?php if($view['is_del_href']) { ?>
			<a href="<?php echo $view['is_del_href']; ?>" class="btn btn-black btn-sm"><i class="fa fa-times"></i><span class="hidden-xs"> 삭제</span></a>
		<?php } ?>
		<a href="./itemuselist.php?<?php echo $qstr;?>" class="btn btn-black btn-sm"><i class="fa fa-bars"></i> 목록</a>
	</div>
	<div class="clearfix"></div>
</div>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });
});
</script>