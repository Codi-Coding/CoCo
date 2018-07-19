<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($kind == "recv") {
    $kind_str = "보낸";
    $kind_date = "받은";
}
else {
    $kind_str = "받는";
    $kind_date = "보낸";
}

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
	<a href="./memo.php?kind=recv" class="btn btn-sm btn-black<?php echo ($kind == "recv") ? ' active' : '';?>">받은쪽지</a>
	<a href="./memo.php?kind=send" class="btn btn-sm btn-black<?php echo ($kind == "send") ? ' active' : '';?>">보낸쪽지</a>
	<a href="./memo_form.php" class="btn btn-sm btn-black<?php echo ($kind == "") ? ' active' : '';?>">쪽지쓰기</a>
</div>

<div class="memo-send-info">
	<span class="pull-right">
		<i class="fa fa-clock-o"></i>
		<span class="memo_view_subj"><?php echo $kind_date ?>시간</span>
		<strong><?php echo $memo['me_send_datetime'] ?></strong>
	</span>
	<i class="fa fa-user"></i>
	<span class="memo_view_subj"><?php echo $kind_str ?>사람</span>
    <strong><?php echo $nick ?></strong>
</div>

<div class="memo-content">
	<?php echo $memo_content; ?>
</div>

<p class="text-center">
	<?php if($prev_link) {  ?>
		<a href="<?php echo $prev_link ?>" class="btn btn-black btn-sm">이전</a>
	<?php }  ?>
	<?php if($next_link) {  ?>
	<a href="<?php echo $next_link ?>" class="btn btn-black btn-sm">다음</a>
	<?php }  ?>
	<?php if ($kind == 'recv') {  ?>
		<a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>"  class="btn btn-color btn-sm">답장</a>
	<?php }  ?>
	<a href="./memo.php?kind=<?php echo $kind ?><?php echo $qstr;?>" class="btn btn-black btn-sm">목록</a>
	<button type="button" onclick="window.close();" class="btn btn-black btn-sm">닫기</button>
</p>
<br>