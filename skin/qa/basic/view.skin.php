<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$attach_list = '';
if ($view['download_count']) {
	for ($i=0; $i<$view['download_count']; $i++) {
		$attach_list .= '<a class="list-group-item view_file_download" href="'.$view['download_href'][$i].'" target="_blank">';
		$attach_list .= '<i class="fa fa-link"></i> '.$view['download_source'][$i].'</a>'.PHP_EOL;
	}
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

// 사진
$view['photo'] = apms_photo_url($view['mb_id']);

?>

<div class="view-wrap<?php echo (G5_IS_MOBILE) ? ' view-mobile font-14' : '';?>">
	<h1><?php if($view['photo']) { ?><img src="<?php echo $view['photo'];?>" class="photo" alt=""><?php } ?><?php echo $view['subject']; ?></h1>
	<div class="panel panel-default view-head<?php echo ($attach_list) ? '' : ' no-attach';?>">
		<div class="panel-heading">
			<div class="font-12 text-muted">
				<i class="fa fa-user"></i>
				<?php echo $view['name']; //등록자 ?>
				<?php if($view['category']) { ?>
					<span class="hidden-xs">
						<span class="sp"></span>
						<i class="fa fa-tag"></i>
						<?php echo $view['category']; //분류 ?>
					</span>
				<?php } ?>
				<?php if($view['hp']) { ?>
					<span class="sp"></span>
					<i class="fa fa-phone"></i> <?php echo $view['hp']; //연락처 ?>
				<?php } ?>
				<?php if($view['email']) { ?>
					<span class="sp"></span>
					<i class="fa fa-envelope-o"></i> <?php echo $view['email']; //이메일 ?>
				<?php } ?>
				<span class="pull-right">
					<i class="fa fa-clock-o"></i>
					<?php echo apms_date(strtotime($view['qa_datetime']), 'orangered', 'before'); //시간 ?>
				</span>
			</div>
		</div>
	   <?php
			if($attach_list) {
				echo '<div class="list-group font-12">'.$attach_list.'</div>'.PHP_EOL;
			}
		?>
	</div>

	<?php
		// 이미지 출력
		if($view['img_count']) {
			echo '<div class="view-img">'.PHP_EOL;
			for ($i=0; $i<$view['img_count']; $i++) {
                echo get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']);
			}
			echo '</div>'.PHP_EOL;
		}
	 ?>

	<div class="view-content">
		<?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?>
	</div>

	<?php if($view['qa_type'] || $update_href || $delete_href) { ?> 
		<div class="print-hide text-right">
			<div class="btn-group">
				<?php if($view['qa_type']) { ?>
					<a href="<?php echo $rewrite_href; ?>" class="btn btn-black btn-sm">추가질문</a>
				<?php } ?>
				<?php if ($update_href) { ?><a href="<?php echo $update_href ?>" class="btn btn-black btn-sm"><i class="fa fa-plus"></i> 수정</a><?php } ?>
				<?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" class="btn btn-black btn-sm" onclick="del(this.href); return false;"><i class="fa fa-times"></i> 삭제</a><?php } ?>
			</div>
		</div>
		<div class="h15"></div>
	<?php } ?>

	<?php
    // 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
    if(!$view['qa_type']) {
        if($view['qa_status'] && $answer['qa_id'])
            include_once($skin_path.'/view.answer.skin.php');
        else
            include_once($skin_path.'/view.answerform.skin.php');
    }
    ?>
</div>

<?php //관련질문
	if($view['rel_count']) { 
		$category_option = '';
?>
	<div class="print-hide list-wrap">
		<h3 class="div-title-underline-thin" style="padding:0px; margin:30px 0px 10px;">
			Relations
		</h3>
		<?php 
			$list = $rel_list;
			$list_cnt = count($list);
			include_once($skin_path.'/list.rows.php');
		?>
	</div>
<?php } ?>

<div class="print-hide view-btn">
	<div class="form-group text-right">
		<div class="btn-group">
			<a href="javascript:;" onclick="apms_print();" class="btn btn-black btn-sm"><i class="fa fa-print"></i> 프린트</a>
			<?php if ($prev_href) { ?><a href="<?php echo $prev_href ?>" class="btn btn-black btn-sm"><i class="fa fa-chevron-circle-left"></i> 이전</a><?php } ?>
			<?php if ($next_href) { ?><a href="<?php echo $next_href ?>" class="btn btn-black btn-sm"><i class="fa fa-chevron-circle-right"></i> 다음</a><?php } ?>
			<a href="<?php echo $list_href ?>" class="btn btn-black btn-sm"><i class="fa fa-bars"></i> 목록</a>
			<?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn btn-color btn-sm"><i class="fa fa-pencil"></i> 글쓰기</a><?php } ?>
		</div>
	</div>
</div>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });
});
</script>