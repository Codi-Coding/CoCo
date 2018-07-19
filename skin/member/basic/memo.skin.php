<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

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

<table class="div-table table">
<tbody>
<tr class="active">
	<th class="text-center" scope="col">번호</th>
	<th class="text-center" scope="col"><?php echo  ($kind == "recv") ? "보낸사람" : "받는사람";  ?></th>
	<th class="text-center" scope="col">보낸시간</th>
	<th class="text-center" scope="col">읽은시간</th>
	<th class="text-center" scope="col">관리</th>
</tr>
<?php for ($i=0; $i<count($list); $i++) {  ?>
	<tr>
		<td class="text-center"><?php echo $list[$i]['num'] ?></td>
		<td><b><?php echo $list[$i]['name'] ?></b></td>
		<td class="text-center"><a href="<?php echo $list[$i]['view_href'] ?>"><?php echo $list[$i]['send_datetime'] ?></a></td>
		<td class="text-center"><a href="<?php echo $list[$i]['view_href'] ?>"><?php echo $list[$i]['read_datetime'] ?></a></td>
		<td class="text-center"><a href="<?php echo $list[$i]['del_href'] ?>" onclick="del(this.href); return false;">삭제</a></td>
	</tr>
<?php } ?>
<?php if ($i==0) { echo '<tr><td colspan="5" class="text-muted text-center" height="150">자료가 없습니다.</td></tr>'; }  ?>
<tr>
<td colspan="5" class="text-center active">
        쪽지 보관일수는 최장 <strong><?php echo $config['cf_memo_del'] ?></strong>일 입니다.
</tbody>
</table>
<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en" style="margin-top:0; padding-top:0;">
			<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>
<p class="text-center">
	<button type="button" onclick="window.close();" class="btn btn-black btn-sm">닫기</button>
</p>
