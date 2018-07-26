<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<style>
	.it-options ul { padding:0; margin:0; list-style:none; color:#888; font-size:11px; }
</style>
<div class="new_win">
    <h1>주문서</h1>

	<div class="tbl_head01 tbl_wrap">
		<table>
		<tr>
			<th scope="row">이미지</th>
			<th scope="row">상품명</th>
			<th scope="row">상태</th>
			<th scope="row">배송비</th>
		</tr>
		<tbody>
		<?php for($i=0;$i < count($item); $i++) { ?>
			<tr>
				<td align="center">
					<?php echo get_it_image($item[$i]['it_id'], 40, 40); ?>
				</td>
				<td>
					<a href="<?php echo G5_SHOP_URL;?>/item.php?it_id=<?php echo $item[$i]['it_id'];?>" target="_blank">
						<b><?php echo stripslashes($item[$i]['it_name']); ?></b>
					</a>
					<div class="it-options" style="margin-top:4px;">
						<?php echo $item[$i]['it_options'];?>
					</div>
				</td>
				<td align="center"><?php echo $item[$i]['ct_status']; ?></td>
				<td align="center">
					<?php echo $item[$i]['send'];?>
					<?php if($item[$i]['sendcost']) { ?>
						<br>
						(<?php echo number_format($item[$i]['sendcost']);?>원)
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
	</div>

	<div class="tbl_head01 tbl_wrap">
		<table>
		<colgroup>
			<col class="grid_3">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">주문번호</th>
			<td><?php echo $od_id; ?></td>
		</tr>
		<tr>
			<th scope="row">주문일시</th>
			<td><?php echo $od['od_time']; ?></td>
		</tr>
		<tr>
			<th scope="row">결제방식</th>
			<td>
				<?php echo $od['od_settle_case']; ?>
				<?php echo ($od['od_receipt_time'] != "0000-00-00 00:00:00") ? '('.$od['od_receipt_time'].')' : ''; ?>
			</td>
		</tr>
		</tbody>
		</table>
	</div>

	<?php if($is_delivery) { //배송상품 ?>

		<p><h3><b>주문하신 분</b></h3></p>

		<div class="tbl_head01 tbl_wrap">
			<table>
			<colgroup>
				<col class="grid_3">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">이 름</th>
				<td><?php echo get_text($od['od_name']); ?><?php echo $buyer;?></td>
			</tr>
			<tr>
				<th scope="row">전화번호</th>
				<td><?php echo get_text($od['od_tel']); ?></td>
			</tr>
			<tr>
				<th scope="row">핸드폰</th>
				<td><?php echo get_text($od['od_hp']); ?></td>
			</tr>
			<tr>
				<th scope="row">주 소</th>
				<td><?php echo get_text(sprintf("(%s-%s)", $od['od_zip1'], $od['od_zip2']).' '.print_address($od['od_addr1'], $od['od_addr2'], $od['od_addr3'], $od['od_addr_jibeon'])); ?></td>
			</tr>
			<tr>
				<th scope="row">E-mail</th>
				<td><?php echo get_text($od['od_email']); ?></td>
			</tr>
			</tbody>
			</table>
		</div>

		<p><h3><b>받으시는 분</b></h3></p>

		<div class="tbl_head01 tbl_wrap">
			<table>
			<colgroup>
				<col class="grid_3">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">이 름</th>
				<td><?php echo get_text($od['od_b_name']); ?></td>
			</tr>
			<tr>
				<th scope="row">전화번호</th>
				<td><?php echo get_text($od['od_b_tel']); ?></td>
			</tr>
			<tr>
				<th scope="row">핸드폰</th>
				<td><?php echo get_text($od['od_b_hp']); ?></td>
			</tr>
			<tr>
				<th scope="row">주 소</th>
				<td><?php echo get_text(sprintf("(%s-%s)", $od['od_b_zip1'], $od['od_b_zip2']).' '.print_address($od['od_b_addr1'], $od['od_b_addr2'], $od['od_b_addr3'], $od['od_b_addr_jibeon'])); ?></td>
			</tr>
			<?php
			// 희망배송일을 사용한다면
			if ($default['de_hope_date_use'])
			{
			?>
			<tr>
				<th scope="row">희망배송일</th>
				<td><?php echo substr($od['od_hope_date'],0,10).' ('.get_yoil($od['od_hope_date']).')' ;?></td>
			</tr>
			<?php }
			if ($od['od_memo'])
			{
			?>
			<tr>
				<th scope="row">전하실 말씀</th>
				<td><?php echo conv_content($od['od_memo'], 0); ?></td>
			</tr>
			<?php } ?>
			</tbody>
			</table>
		</div>

	<?php } else { ?>
		<p><h3><b>결제하신 분</b></h3></p>

		<div class="tbl_head01 tbl_wrap">
			<table>
			<colgroup>
				<col class="grid_3">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">이 름</th>
				<td><?php echo get_text($od['od_name']); ?><?php echo $buyer;?></td>
			</tr>
			<tr>
				<th scope="row">연락처</th>
				<td><?php echo get_text($od['od_tel']); ?></td>
			</tr>
			<tr>
				<th scope="row">E-mail</th>
				<td><?php echo get_text($od['od_email']); ?></td>
			</tr>
			<tr>
				<th scope="row">메 모</th>
				<td><?php echo conv_content($od['od_memo'], 0); ?></td>
			</tr>
			</tbody>
			</table>
		</div>
	<?php } ?>
</div>

<div class="btn_confirm01 btn_confirm">
	<button onclick="window.close();" type="button">닫기</button>
</div>
