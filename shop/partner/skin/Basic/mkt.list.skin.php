<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<h1><i class="fa fa-line-chart"></i> My Profit Report</h1>

<div class="well" style="padding-bottom:5px;">
	<form class="form" role="form" name="frm_salelist" method="get">
		<input type="hidden" name="ap" value="<?php echo $ap;?>">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label for="type" class="sr-only">수익타입</label>
					<select name="type" id="type" class="form-control input-sm">
						<option value="day">일간수익</option>
						<option value="month">월간수익</option>
						<option value="year">연간수익</option>
					</select>
				</div>
			</div>
			<div class="col-sm-3">
				<label for="fr_date" class="sr-only">시작일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" required class="form-control input-sm" size="8" maxlength="8" readonly>
				</div>
			</div>
			<div class="col-sm-3">
				<label for="to_date" class="sr-only">종료일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" required class="form-control input-sm" size="8" maxlength="8" readonly>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<button type="submit" class="btn btn-danger btn-sm btn-block"><i class="fa fa-shopping-cart"></i> 수익확인</button>
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

	document.getElementById("type").value = "<?php echo $type; ?>";
	</script>
</div>

<div class="table-responsive">
	<table class="table tbl bg-white">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col">년/월/일</th>
		<th class="text-center" scope="col">판매량</th>
		<th class="text-center" scope="col">총판매액(VAT포함)</th>
		<th class="text-center" scope="col">순판매액(VAT제외)</th>
		<th class="text-center" scope="col">순수익(적립)액</th>
		<th class="text-center" scope="col">인센티브</th>
		<th class="text-center" scope="col">총수익(적립)액</th>
		<th class="text-center" scope="col">수익(적립)율</th>
	</tr>
	<?php for ($i=0; $i < count($list); $i++) { ?>
		<tr<?php echo ($list[$i]['yoil'] == '일') ? ' style="background:#f5f5f5; font-weight:bold;"' : '';?>>
			<td class="text-center"><?php echo str_replace("-", "/", $list[$i]['date']);?></td>
			<td class="text-center"><?php echo number_format($list[$i]['qty']);?></td>
			<td class="text-right"><?php echo number_format($list[$i]['sale']);?></td>
			<td class="text-right"><?php echo number_format($list[$i]['net']);?></td>
			<td class="text-right"><?php echo number_format($list[$i]['profit']);?></td>
			<td class="text-right"><?php echo number_format($list[$i]['benefit']);?></td>
			<td class="text-right"><?php echo number_format($list[$i]['total']);?></td>
			<td class="text-right"><?php echo ($list[$i]['net'] > 0) ? round(($list[$i]['total'] / $list[$i]['net']) * 1000) / 10 : 0;?>%</td>
		</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="8" class="text-center">등록된 자료가 없습니다.</td></tr>
	<?php } else { ?>
		<tr style="background:#f5f5f5; font-weight:bold;">
			<td class="text-center"><b>합계</b></td>
			<td class="text-center"><b><?php echo number_format($tot['qty']);?></b></td>
			<td class="text-right"><b><?php echo number_format($tot['sale']);?></b></td>
			<td class="text-right"><b><?php echo number_format($tot['net']);?></b></td>
			<td class="text-right"><b><?php echo number_format($tot['profit']);?></b></td>
			<td class="text-right"><b><?php echo number_format($tot['benefit']);?></b></td>
			<td class="text-right"><b><?php echo number_format($tot['total']);?></b></td>
			<td class="text-right"><?php echo ($tot['net'] > 0) ? round(($tot['total'] / $tot['net']) * 1000) / 10 : 0;?>%</td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
</div>
