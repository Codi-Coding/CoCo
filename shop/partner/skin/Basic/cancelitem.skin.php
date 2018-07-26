<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<h1><i class="fa fa-cart-arrow-down"></i> My Cancel Items</h1>

<div class="well" style="padding-bottom:3px;">
	<form class="form" role="form" name="frm_saleitem" method="get">
	<input type="hidden" name="ap" value="<?php echo $ap;?>">
		<div class="row">
			<div class="col-sm-2 col-xs-6">
				<label for="fr_date" class="sr-only">시작일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" class="form-control input-sm" size="8" maxlength="8" readonly placeholder="시작일">
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<label for="to_date" class="sr-only">종료일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" class="form-control input-sm" size="8" maxlength="8" readonly placeholder="종료일">
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
					<label for="sfl" class="sr-only">검색옵션</label>
					<select name="sfl" id="sfl" class="form-control input-sm">
						<option value="a.it_name"<?php echo get_selected($sfl, 'a.it_name');?>>상품명</option>
						<option value="a.it_id"<?php echo get_selected($sfl, 'a.it_id');?>>상품코드</option>
						<option value="a.od_id"<?php echo get_selected($sfl, 'a.od_id');?>>주문번호</option>
					</select>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
					<div class="form-group">
					    <label for="stx" class="sound_only">검색어</label>
					    <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="form-control input-sm" placeholder="검색어">
					</div>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
					<button type="submit" class="btn btn-danger btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
					<a href="./?ap=<?php echo $ap;?>" class="btn btn-primary btn-sm btn-block"><i class="fa fa-refresh"></i> 리셋</a>
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

<h3><i class="fa fa-cubes fa-lg"></i> <?php echo number_format($total_count); ?> Items</h3>

<div class="table-responsive">
	<table class="table tbl bg-white">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col">번호</th>
		<th class="text-center" scope="col">취소일</th>
		<th class="text-center" scope="col">구매자</th>
		<th width="60" class="text-center" scope="col">이미지</th>
		<th class="text-center" scope="col">취소상품</th>
		<th class="text-center" scope="col">상품코드</th>
		<th class="text-center" scope="col">취소금액(원)</th>
		<th class="text-center" scope="col">수수료</th>
		<th class="text-center" scope="col">포인트</th>
		<th class="text-center" scope="col">인센티브</th>
		<th class="text-center" scope="col">취소매출(원)</th>
		<th class="text-center" scope="col">공급가</th>
		<th class="text-center" scope="col">부가세</th>
		<th class="text-center" scope="col">주문번호</th>
		<th class="text-center" scope="col">주문서</th>
	</tr>
	<?php for ($i=0; $i < count($list); $i++) { ?>
	<tr>
		<td class="text-center">
			<?php echo $list[$i]['num'];?>
		</td>
		<td class="text-center">
			<?php echo $list[$i]['date'];?>
		</td>
		<td class="text-center">
			<?php echo $list[$i]['buyer']; ?>
		</td>
		<td class="text-center">
			<a href="<?php echo $list[$i]['href'];?>" target="_blank">
				<?php echo get_it_image($list[$i]['it_id'], 40, 40);?>
			</a>
		</td>
		<td>
			<a href="<?php echo $list[$i]['href']; ?>">
				<b><?php echo $list[$i]['it_name'];?></b>
			</a>
			<div class="text-muted" style="margin-top:4px;">
				<?php echo $list[$i]['option'];?>
			</div>
		</td>
		<td class="text-center">
			<a href="<?php echo $list[$i]['href'];?>" target="_blank">
				<?php echo $list[$i]['it_id'];?>
			</a>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['sale']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['commission']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['point']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['incentive']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['netsale']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['net']); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['vat']); ?>
		</td>
		<td class="text-center">
			<a href="<?php echo $list[$i]['inquiry']; ?>" class="win_point">
				<?php echo $list[$i]['od_num'];?>
			</a>
		</td>
		<td class="text-center">
			<a href="<?php echo $list[$i]['inquiry']; ?>" class="win_point">
				<i class="fa fa-file-text-o fa-lg"></i>
			</a>
		</td>
	</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="15" class="text-center">등록된 자료가 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<div class="clearfix"></div>
