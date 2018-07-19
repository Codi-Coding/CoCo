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

<table class="div-table table">
<tbody>
<tr class="bg-black">
	<th class="text-center" scope="col">번호</th>
	<th class="text-center" scope="col">게시판</th>
	<th class="text-center" scope="col">제목</th>
	<th class="text-center" scope="col">보관일시</th>
	<th class="text-center" scope="col">삭제</th>
</tr>
<?php for ($i=0; $i<count($list); $i++) {  ?>
<tr>
	<td class="text-center"><?php echo $list[$i]['num'] ?></td>
	<td class="text-center"><a href="<?php echo $list[$i]['opener_href'] ?>" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href'] ?>'; return false;"><?php echo $list[$i]['bo_subject'] ?></a></td>
	<td><a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; return false;"><?php echo $list[$i]['subject'] ?></a></td>
	<td class="text-center"><?php echo $list[$i]['ms_datetime'] ?></td>
	<td class="text-center"><a href="<?php echo $list[$i]['del_href'];  ?>" onclick="del(this.href); return false;">삭제</a></td>
</tr>
<?php }  ?>
<?php if ($i == 0) echo '<tr><td colspan="5" class="text-center text-muted" height=150>자료가 없습니다.</td></tr>';  ?>
</tbody>
</table>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en" style="margin-top:0px;">
			<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<p class="text-center">
	<button type="button" class="btn btn-black btn-sm" onclick="window.close();">닫기</button>
</p>
