<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style>
	.od-tr td { line-height:20px !important; }
	.it-info ul { margin:0; padding:0; padding-left:20px; }
</style>

<h1><i class="fa fa-truck"></i> My Delivery List</h1>

<div class="well" style="padding-bottom:3px;">
	<form class="form" role="form" name="frm_delivery" method="get">
	<input type="hidden" name="ap" value="<?php echo $ap;?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>">
	<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">
		<div class="row">
			<div class="col-sm-2">
				<div class="form-group">
					<label for="done" class="sr-only">배송상태</label>
					<select name="done" id="done" class="form-control input-sm">
						<option value="">전체내역</option>
						<option value="1">미배송건</option>
						<option value="2">배송완료</option>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<label for="fr_date" class="sr-only">시작일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" required class="form-control input-sm" size="8" maxlength="8" readonly>
				</div>
			</div>
			<div class="col-sm-2">
				<label for="to_date" class="sr-only">종료일</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        <input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" required class="form-control input-sm" size="8" maxlength="8" readonly>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<button type="submit" class="btn btn-danger btn-sm btn-block"><i class="fa fa-truck"></i> 조회하기</button>
				</div>
			</div>
			<div class="col-sm-3">
				<label for="stx" class="sr-only">검색어</label>
				<div class="form-group input-group input-group-sm">
					<span class="input-group-addon">검색</span>
			        <input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="form-control input-sm" placeholder="주문번호 입력">
				</div>
			</div>
		</div>
	</form>
	<script>
	function sel_company(id, com) {
		$("#" + id).val(com);
	}
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

	document.getElementById("done").value = "<?php echo $done; ?>";
	</script>
</div>

<h3><i class="fa fa-cubes fa-lg"></i> <?php echo number_format($total_count); ?> Orders</h3>

<form class="form" role="form" name="fdeliveryupdate" method="post" autocomplete="off">
<input type="hidden" name="ap" value="<?php echo $ap;?>">
<input type="hidden" name="save" value="1">
<input type="hidden" name="fr_date" value="<?php echo $fr_date; ?>">
<input type="hidden" name="to_date" value="<?php echo $to_date; ?>">
<input type="hidden" name="done" value="<?php echo $done; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="table-responsive">
	<table class="table tbl bg-white">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col">번호</th>
		<th class="text-center" scope="col">주문번호</th>
		<th class="text-center" scope="col">주문자(연락처)</th>
		<th class="text-center" scope="col">배송정보(이름/연락처/주소/메모)</th>
		<th class="text-center" scope="col" style="width:50px;">이미지</th>
		<th class="text-center" scope="col">주문상품</th>
		<th class="text-center" scope="col">상품코드</th>
		<th class="text-center" scope="col">배송비</th>
		<th class="text-center" scope="col">배송회사</th>
		<th class="text-center" scope="col">운송장번호</th>
		<th class="text-center" scope="col">상태</th>
	</tr>
	<?php 
		$z = 0;
		for ($i=0; $i < count($list); $i++) { 

			// 쉘합치기
			$rowspan = ($list[$i]['rowspan']) ? ' rowspan="'.$list[$i]['rowspan'].'"' : '';

			for ($j=0; $j < count($list[$i]['it']); $j++) {
	?>
			<tr class="od-tr">
               <?php if($j == 0) { ?>
					<td class="text-center"<?php echo $rowspan;?>>
						<?php echo $list[$i]['num'];?>
					</td>
					<td class="text-center"<?php echo $rowspan;?>>
						<a href="<?php echo $list[$i]['inquiry']; ?>" class="win_point">
							<?php echo $list[$i]['od_num'];?>
						</a>
					</td>
					<td class="text-center"<?php echo $rowspan;?>>
						<?php echo $list[$i]['od_name'];?>
						<br>
						(<?php echo implode(" / ", array($list[$i]['od_tel'], $list[$i]['od_hp']));?>) 
					</td>
					<td<?php echo $rowspan;?>>
						<strong><?php echo $list[$i]['od_b_name'];?></strong> (<?php echo implode( " / ", array($list[$i]['od_b_tel'], $list[$i]['od_b_hp']));?>)
						<br>
                        (<?php echo $list[$i]['od_b_zip1'].$list[$i]['od_b_zip2']; ?>)
                        <?php echo get_text($list[$i]['od_b_addr1']); ?>
						<?php echo get_text($list[$i]['od_b_addr2']); ?>
                        <?php echo get_text($list[$i]['od_b_addr3']); ?>
		                <?php if ($default['de_hope_date_use'] && $list[$i]['od_hope_date']) { ?>
							<br>
							희망배송일 : <?php echo $list[$i]['od_hope_date']; ?>(<?php echo get_yoil($list[$i]['od_hope_date']); ?>)
						<?php } ?>
						<?php if ($list[$i]['od_memo']) { ?>
							<br>
							<span style="color:#0099ff;">전달메시지 : <?php echo get_text($list[$i]['od_memo'], 1);?></span>
						<?php } ?>
					</td>
				<?php } ?>
				<td class="text-center">
					<a href="<?php echo $list[$i]['it'][$j]['href'];?>" target="_blank">
						<?php echo get_it_image($list[$i]['it'][$j]['it_id'], 40, 40);?>
					</a>
				</td>
				<td class="it-info">
					<a href="<?php echo $list[$i]['it'][$j]['href'];?>" target="_blank">
						<b><?php echo $list[$i]['it'][$j]['name'];?></b>
					</a>
					<?php echo $list[$i]['it'][$j]['option'];?>
				</td>
				<td class="text-center">
					<a href="<?php echo $list[$i]['it'][$j]['href'];?>" target="_blank">
						<?php echo $list[$i]['it'][$j]['it_id'];?>
					</a>
				</td>
				<td class="text-center">
					<?php echo $list[$i]['it'][$j]['sendcost'];?>
					<?php if($list[$i]['it'][$j]['sc_price']) { ?>
						<br>
						(<?php echo number_format($list[$i]['it'][$j]['sc_price']);?>원)
					<?php } ?>
				</td>
				<td>
					<input type="hidden" name="od_id[<?php echo $z; ?>]" value="<?php echo $list[$i]['it'][$j]['od_id']; ?>">
					<input type="hidden" name="it_id[<?php echo $z; ?>]" value="<?php echo $list[$i]['it'][$j]['it_id']; ?>">
					<select class="form-control input-sm" onchange="sel_company('com_<?php echo $z;?>', this.value)">
						<?php echo get_delivery_company($list[$i]['it'][$j]['pt_send'], '배송업체 선택');?>
					</select>
					<div style="height:8px;"></div>
					<input type="text" id="com_<?php echo $z;?>" name="pt_send[<?php echo $z; ?>]" value="<?php echo $list[$i]['it'][$j]['pt_send']; ?>" class="form-control input-sm">
				</td>
				<td>
					<?php if($list[$i]['it'][$j]['tel']) { ?>
						<div class="help-block">
							<?php echo str_replace("문의전화: ", "", $list[$i]['it'][$j]['tel']);?>
						</div>
					<?php } ?>
					<input type="text" name="pt_send_num[<?php echo $z; ?>]" value="<?php echo $list[$i]['it'][$j]['pt_send_num']; ?>" class="form-control input-sm">
				</td>
				<td class="text-center">
					<select name="ct_status[<?php echo $z; ?>]" class="form-control input-sm">
						<option value="입금"<?php echo get_selected($list[$i]['it'][$j]['ct_status'],'입금');?>>입금</option>
						<option value="준비"<?php echo get_selected($list[$i]['it'][$j]['ct_status'],'준비');?>>준비</option>
						<option value="배송"<?php echo get_selected($list[$i]['it'][$j]['ct_status'],'배송');?>>배송</option>
					</select>
				</td>
			</tr>
		<?php $z++; } ?>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="11" class="text-center">등록된 주문내역이 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div style="margin-bottom:20px;">
	<div class="form-group pull-left">
		<ul class="pagination pagination-sm en" style="margin-top:0; padding-top:0;">
			<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
		</ul>
	</div>
	<div class="form-group pull-right">			
		<button type="submit" class="btn btn-default">배송일괄처리</button>
	</div>
	<div class="clearfix"></div>
</div>

</form>
