<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<!-- 쿠폰 선택 시작 { -->
<div id="od_coupon_frm">
    <?php if($is_coupon) { ?>
		<div class="table-responsive">
			<table class="div-table table">
			<thead>
			<tr class="active">
				<th class="text-center" scope="col">쿠폰명</th>
				<th class="text-center" scope="col">할인금액</th>
				<th class="text-center" scope="col">적용</th>
			</tr>
			</thead>
			<tbody>
			<?php for($i=0; $i < count($list); $i++) { ?>
				<tr>
					<td>
						<input type="hidden" name="o_cp_id[]" value="<?php echo $list[$i]['cp_id']; ?>">
						<input type="hidden" name="o_cp_prc[]" value="<?php echo $list[$i]['dc']; ?>">
						<input type="hidden" name="o_cp_subj[]" value="<?php echo $list[$i]['cp_subject']; ?>">
						<?php echo get_text($list[$i]['cp_subject']); ?>
					</td>
					<td class="text-right"><?php echo number_format($list[$i]['dc']); ?></td>
					<td class="text-center"><button type="button" class="od_cp_apply btn btn-black btn-xs">적용</button></td>
				</tr>
			<?php }	?>
			</tbody>
			</table>
		</div>
	<?php } else { ?>
		<p class="text-center">사용할 수 있는 쿠폰이 없습니다.</p>
    <?php } ?>

	<br>

    <div class="text-center">
        <button type="button" id="od_coupon_close" class="btn btn-black btn-sm">닫기</button>
    </div>
</div>
<!-- } 쿠폰 선택 끝 -->