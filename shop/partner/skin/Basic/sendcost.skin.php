<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<h1>
	<i class="fa fa-tags"></i> My Sendcost List
</h1>

<div class="well" style="padding-bottom:3px;">
	<form class="form" role="form" name="frm_sendcost" method="get">
	<input type="hidden" name="ap" value="<?php echo $ap;?>">
		<div class="row">
			<div class="col-sm-2">
				<label for="fr_date" class="sr-only">시작일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" class="form-control input-sm" size="8" maxlength="8" placeholder="시작일" readonly>
				</div>
			</div>
			<div class="col-sm-2">
				<label for="to_date" class="sr-only">종료일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" class="form-control input-sm" size="8" maxlength="8" placeholder="종료일" readonly>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="sfl" class="sr-only">검색방법</label>
					<select name="sfl" id="sfl" class="form-control input-sm">
						<option value="od_id"<?php echo get_selected($sfl, 'od_id');?>>주문번호</option>
						<option value="it_id"<?php echo get_selected($sfl, 'it_id');?>>상품코드</option>
						<option value="it_name"<?php echo get_selected($sfl, 'it_name');?>>상품명</option>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<label for="stx" class="sr-only">검색어</label>
				<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="form-control input-sm">
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<button type="submit" class="btn btn-danger btn-sm btn-block"><i class="fa fa-search"></i> 검색하기</button>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<a href="./?ap=sendcost" class="btn btn-primary btn-sm btn-block"><i class="fa fa-refresh"></i> 초기화</a>
				</div>
			</div>
		</div>
	</form>
	<script>
		$(function() {
			$("#fr_date, #to_date").datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "yymmdd",
				showButtonPanel: true,
				yearRange: "c-99:c+99",
				maxDate: "+0d"
			});
		});
	</script>
</div>

<h3><i class="fa fa-cubes fa-lg"></i> <?php echo number_format($total_count); ?> Sendcosts</h3>

<div class="table-responsive">
	<table class="table tbl bg-white">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col">번호</th>
		<th class="text-center" scope="col" style="width:60px;">이미지</th>
		<th class="text-center" scope="col">배송상품</th>
		<th class="text-center" scope="col">상품코드</th>
		<th class="text-center" scope="col">배송비 조건</th>
		<th class="text-center" scope="col">배송비(원)</th>
		<th class="text-center" scope="col">주문서</th>
		<th class="text-center" scope="col">주문번호</th>
		<th class="text-center" scope="col">주문일시</th>
		<th class="text-center" scope="col">정산일시</th>
	</tr>
	<?php for ($i=0; $i < count($list); $i++) { ?>
		<tr>
			<td class="text-center">
				<?php echo $list[$i]['num'];?>
			</td>
			<td class="text-center">
				<a href="<?php echo $list[$i]['href'];?>" target="_blank">
					<?php echo get_it_image($list[$i]['it_id'], 40, 40);?>
				</a>
			</td>
			<td>
				<a href="<?php echo $list[$i]['href'];?>" target="_blank">
					<?php echo $list[$i]['it_name'];?>
				</a>
			</td>
			<td class="text-center">
				<a href="<?php echo $list[$i]['href'];?>" target="_blank">
					<nobr><?php echo $list[$i]['it_id'];?></nobr>
				</a>
			</td>
			<td class="text-center">
				<?php echo $list[$i]['sc_type'];?>
			</td>
			<td class="text-right">
				<?php echo ($list[$i]['sc_price']) ? number_format($list[$i]['sc_price']) : '-'; ?>
			</td>
			<td class="text-center">
				<a href="<?php echo $list[$i]['inquiry']; ?>" class="win_point">
					<i class="fa fa-file-text-o fa-lg"></i>
				</a>
			</td>
			<td class="text-center">
				<a href="<?php echo $list[$i]['inquiry']; ?>" class="win_point">
					<?php echo $list[$i]['od_num'];?>
				</a>
			</td>
			<td class="text-center">
				<?php echo $list[$i]['sc_datetime'];?>
			</td>
			<td class="text-center">
				<?php echo $list[$i]['pt_datetime'];?>
			</td>
		</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="10" class="text-center">등록된 배송비 내역이 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="text-center">
	<ul class="pagination pagination-sm en">
		<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
	</ul>
</div>

</form>
