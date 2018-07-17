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
	<a href="./shopping.php?mode=1" class="btn btn-sm btn-black<?php echo ($mode == "1") ? ' active' : '';?>">구매완료</a>
	<a href="./shopping.php?mode=2" class="btn btn-sm btn-black<?php echo ($mode == "2") ? ' active' : '';?>">배송중</a>
	<a href="./shopping.php?mode=3" class="btn btn-sm btn-black<?php echo ($mode == "3") ? ' active' : '';?>">주문접수</a>
</div>

<style>
	.shopping-skin table > tr > td { line-height:22px; }
	.it-opt ul { margin:0px; padding:0px; padding-left:15px; }
	.it-info ul { margin:0px; padding:0px; padding-left:15px; }
	.it-info ul li { white-space:nowrap; }
</style>
<div class="shopping-skin">
	<table class="div-table table">
	<tbody>
	<tr class="active">
		<th class="text-center" scope="col"><nobr>번호</nobr></th>
		<th class="text-center" scope="col">이미지</th>
		<th class="text-center" scope="col">아이템명</th>
		<th class="text-center" scope="col">주문번호</th>
		<th class="text-center" scope="col">배송/이용정보</th>
	</tr>
	<?php for ($i=0; $i<count($list); $i++)	{ ?>
		<tr>
			<td class="text-center">
				<?php echo $list[$i]['num']; ?>
			</td>
			<td class="text-center">
				<a href="<?php echo $list[$i]['it_href'];?>" target="_blank">
					<?php echo get_it_image($list[$i]['it_id'], 50, 50);?>
				</a>
			</td>
			<td>
				<a href="<?php echo $list[$i]['it_href'];?>" target="_blank">
					<b><?php echo $list[$i]['it_name']; ?></b>
					<?php if($list[$i]['option']) { ?>
						<div class="it-opt text-muted">
							<?php echo $list[$i]['option'];?>
						</div>
					<?php } ?>
				</a>
			</td>
			<td class="text-center">
				<a href="<?php echo $list[$i]['od_href'];?>" target="_blank">
					<nobr><?php echo $list[$i]['od_num']; ?></nobr>
				</a>
				<?php if($list[$i]['seller']) { ?>
					<div>
						<b><?php echo $list[$i]['seller'];?></b>
					</div>
				<?php } ?>
			</td>
			<td class="it-info">
				<ul>
				<?php if($mode == "3") { //입금 ?>
					<li>
						<a href="<?php echo $list[$i]['od_href'];?>" target="_blank">
							주문서확인
						</a>
					</li>
				<?php } else if ($list[$i]['is_delivery']) { // 배송가능 ?>

					<?php if($list[$i]['de_company'] && $list[$i]['de_invoice']) { ?>
						<li>
							<?php echo $list[$i]['de_company'];?>
							<?php echo $list[$i]['de_invoice'];?>
						</li>
						<?php if($list[$i]['de_check']) { ?>
							<li>
								<?php echo str_replace("문의전화: ", "", $list[$i]['de_check']);?>
							</li>
						<?php } ?>
					<?php } ?>
					<?php if($list[$i]['de_confirm']) { //수령확인 ?>
						<li>
							<a href="<?php echo $list[$i]['de_confirm'];?>" class="delivery-confirm">
								<span class="orangered">수령확인</span>
							</a>
						</li>
					<?php } ?>

				<?php } else { //배송불가 - 컨텐츠 ?>

					<?php if($list[$i]['use_date']) { ?>
						<li>최종일시 : <?php echo $list[$i]['use_date'];?></li>
					<?php } ?>
					<?php if($list[$i]['use_file']) { ?>
						<li>최종자료 : <?php echo $list[$i]['use_file'];?></li>
					<?php } ?>
					<?php if($list[$i]['use_cnt']) { ?>
						<li>이용횟수 : <?php echo number_format($list[$i]['use_cnt']);?>회</li>
					<?php } ?>

				<?php } ?>
				</ul>
			</td>
		</tr>
	<?php }  ?>
	<?php if ($i == 0) { ?>
		<tr>
			<td colspan="5" class="text-center text-muted" height="150">
				자료가 없습니다.
			</td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
	<tr class="active">
		<td colspan="5" class="text-center">
			<?php if($mode == "2") { ?>
				수령확인된 아이템에 한해 포인트 등이 적립됩니다.
			<?php } else if($mode == "3") { ?>
				주문서 기준으로 현재 입금 및 배송 준비 중인 아이템 내역입니다.
			<?php } else { ?>
				주문서 기준으로 구매가 최종완료된 아이템 내역입니다.
			<?php } ?>
		</td>
	</tr>
	</tfoot>
	</table>

	<?php if($total_count > 0) { ?>
		<div class="text-center">
			<ul class="pagination pagination-sm" style="margin-top:10px;">
				<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
			</ul>
		</div>
	<?php } ?>
</div>

<p class="text-center">
	<a class="btn btn-black btn-sm" href="#" onclick="window.close();">닫기</a>
</p>

<script>
$(function(){
	$(".delivery-confirm").click(function(){
		if(confirm("상품을 수령하셨습니까?\n\n확인시 배송완료 처리가됩니다.")) {
			return true;
		}
		return false;
	});
});
</script>
