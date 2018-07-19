<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

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
	<a href="./response.php" class="btn btn-sm btn-black<?php echo (!$read) ? ' active' : '';?>">미확인 반응내역(<b><?php echo number_format($member['response']);?></b>건)</a>
	<a href="./response.php?read=1" class="btn btn-sm btn-black<?php echo ($read) ? ' active' : '';?>">확인 반응내역(180일)</a>
</div>

<div class="myresponse-skin table-responsive" style="border-left:0px; border-right:0px;">
	<table class="div-table table">
	<col width="40">
	<col width="50">
	<col>
	<col width="80">
	<tbody> 
	<?php for ($i=0; $i < count($list); $i++) { ?>
		<tr>
		<td class="text-center text-muted ">
			<?php echo ($read) ? $list[$i]['num'] : '<i class="fa fa-commenting fa-2x"></i>';?>
		</td>
		<td class="photo text-center">
			<?php echo ($list[$i]['photo']) ? '<img src="'.$list[$i]['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
		</td>
		<td style="white-space:normal !important;">
			<a href="#" onclick="<?php echo $list[$i]['href'];?>">
				<b><?php echo $list[$i]['subject'];?></b>
			</a>
			<div class="media-info text-muted font-11" style="margin-top:4px;">
				<?php echo $list[$i]['name'];?> 외
				&nbsp;
				<?php if($list[$i]['reply_cnt']) { ?>
					<i class="fa fa-comments-o"></i> <?php echo $list[$i]['reply_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['comment_cnt']) { ?>
					<i class="fa fa-comment"></i> <?php echo $list[$i]['comment_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['comment_reply_cnt']) { ?>
					<i class="fa fa-comments"></i> <?php echo $list[$i]['comment_reply_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['good_cnt']) { ?>
					<i class="fa fa-thumbs-up"></i> <?php echo $list[$i]['good_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['nogood_cnt']) { ?>
					<i class="fa fa-thumbs-down"></i> <?php echo $list[$i]['nogood_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['use_cnt']) { ?>
					<i class="fa fa-pencil"></i> <?php echo $list[$i]['use_cnt'];?>
				<?php } ?>
				<?php if($list[$i]['qa_cnt']) { ?>
					<i class="fa fa-question-circle"></i> <?php echo $list[$i]['qa_cnt'];?>
				<?php } ?>
			</div>
		</td>
		<td class="text-muted">
			<?php echo apms_date($list[$i]['date'], 'orangered', 'before', 'm.d', 'Y.m.d');?>
		</td>
		</tr>		
	<?php } ?>
	<?php if($i == 0) { ?>
		<tr>
		<td colspan="4">
			<div class="text-center text-muted" style="padding:80px 0px;">등록된 내글반응이 없습니다.</div>
		</td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="clearfix"></div>

<div class="text-center">
	<ul class="pagination pagination-sm en" style="margin-top:0;">
		<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
	</ul>
</div>

<p class="text-center">
	<a class="btn btn-color btn-sm" href="<?php echo $all_href;?>">일괄확인</a>
	<a class="btn btn-black btn-sm" href="<?php echo $recount_href;?>">리카운트</a>
	<a class="btn btn-black btn-sm" href="#" onclick="window.close();">닫기</a>
</p>
