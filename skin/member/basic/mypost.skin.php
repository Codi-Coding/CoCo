<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<div class="sub-title">
	<h4>
		<?php if($member['photo']) { ?>
			<img src="<?php echo $member['photo'];?>" alt="">
		<?php } else { ?>
			<i class="fa fa-user"></i>
		<?php } ?>
		<?php echo $g5['title'];?>
	</h4>
</div>

<div class="btn-group btn-group-justified">
	<a href="./mypost.php?mode=1" class="btn btn-sm btn-black<?php echo ($mode == "1") ? ' active' : '';?>">게시물</a>
	<a href="./mypost.php?mode=2" class="btn btn-sm btn-black<?php echo ($mode == "2") ? ' active' : '';?>">댓글</a>
	<?php if(IS_YC) { ?>
	<a href="./mypost.php?mode=3" class="btn btn-sm btn-black<?php echo ($mode == "3") ? ' active' : '';?>">아이템 댓글</a>
	<a href="./mypost.php?mode=4" class="btn btn-sm btn-black<?php echo ($mode == "4") ? ' active' : '';?>">아이템 후기</a>
	<a href="./mypost.php?mode=5" class="btn btn-sm btn-black<?php echo ($mode == "5") ? ' active' : '';?>">아이템 문의</a>
	<?php } ?>
</div>

<div class="mypost-skin">
<?php
	switch($mode) {
		case '2'	: $skin_file = 'board.comment.skin.php'; break;
		case '3'	: $skin_file = 'item.comment.skin.php'; break;
		case '4'	: $skin_file = 'item.use.skin.php'; break;
		case '5'	: $skin_file = 'item.qa.skin.php'; break;
		default		: $skin_file = 'board.post.skin.php'; break;
	}
	include_once($skin_path.'/mypost/'.$skin_file);
?>
</div>
<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en" style="margin-top:10px;">
			<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<p class="text-center">
	<a class="btn btn-black btn-sm" href="#" onclick="window.close();">닫기</a>
</p>

<script>
$(function() {
	$("a.view_image").click(function() {
		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
		return false;
	});
});
</script>