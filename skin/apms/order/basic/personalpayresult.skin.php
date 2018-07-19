<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>

<div class="panel panel-primary">
	<div class="panel-heading"><strong><i class="fa fa-ticket fa-lg"></i> 개인결제번호 : <?php echo $pp_id; ?></strong></div>
	<div class="table-responsive">
		<table class="div-table table bsk-tbl bg-white">
		<col width="120">
		<tbody>
		<?php if($pp['od_id']) { ?>
			<tr>
			<th scope="row">주문번호</th>
			<td><?php echo $pp['od_id']; ?></td>
			</tr>
		<?php } ?>
			<tr>
			<th scope="row">결제방식</th>
			<td><?php echo $pp['pp_settle_case']; ?></td>
			</tr>
		<?php if($pp_receipt_price) { ?>
			<tr class="active">
			<th scope="row">결제금액</th>
			<td><?php echo $pp_receipt_price; ?></td>
			</tr>
			<tr>
			<th scope="row">결제일시</th>
			<td><?php echo is_null_time($pp['pp_receipt_time']) ? '' : $pp['pp_receipt_time']; ?></td>
			</tr>
		<?php } ?>
		<?php if($app_no_subj) { // 승인번호, 휴대폰번호, 거래번호 ?>
			<tr>
			<th scope="row"><?php echo $app_no_subj; ?></th>
			<td><?php echo $app_no; ?></td>
			</tr>
		<?php } ?>
		<?php if($disp_bank) { // 계좌정보 ?>
			<tr>
			<th scope="row">입금자명</th>
			<td><?php echo get_text($pp['pp_deposit_name']); ?></td>
			</tr>
			<tr>
			<th scope="row">입금계좌</th>
			<td><?php echo get_text($pp['pp_bank_account']); ?></td>
			</tr>
		<?php } ?>
		<?php if($disp_receipt) { ?>
			<tr>
			<th scope="row">영수증</th>
			<td>
			<?php if($hp_receipt_script) { ?>
				<a href="javascript:;" onclick="<?php echo $hp_receipt_script; ?>">영수증 출력</a>
			<?php } ?>

			<?php if($card_receipt_script) { ?>
				<a href="javascript:;" onclick="<?php echo $card_receipt_script; ?>">영수증 출력</a>
			<?php } ?>
			<td>
			</td>
			</tr>
		<?php } ?>
		<?php if($is_cash_receipt) { ?>
			<tr>
			<th scope="row">현금영수증</th>
			<td>
			<?php if($cash_receipt_script) { ?>
				<a href="javascript:;" onclick="<?php echo $cash_receipt_script; ?>">현금영수증 확인하기</a>
			<?php } else { ?>
				<a href="javascript:;" onclick="window.open('<?php echo G5_SHOP_URL; ?>/taxsave.php?tx=personalpay&od_id=<?php echo $pp_id; ?>', 'taxsave', 'width=550,height=400,scrollbars=1,menus=0');">현금영수증을 발급하시려면 클릭하십시오.</a>
			<?php } ?>
			</td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading"><strong><i class="fa fa-money fa-lg"></i> 결제합계</strong></div>
	<div class="table-responsive">
		<table class="div-table table bsk-tbl bg-white">
		<col width="120">
		<tbody>
		<tr>	
			<th scope="row">총주문액</th>
			<td class="text-right"><strong><?php echo display_price($pp['pp_price']); ?></strong></td>
		</tr>
		<?php if ($misu_price > 0) { ?>
			<tr class="active">
				<th scope="row">미결제액</th>
				<td class="text-right"><strong><?php echo display_price($misu_price);?></strong></td>
			</tr>
		<?php } ?> 
		<tr>
			<th scope="row" id="alrdy">결제금액</th>
			<td class="text-right"><strong><?php echo $wanbul; ?></strong></td>
		</tr>
		</tbody>
		</table>
	</div>
</div>

<?php if ($is_account_test) { ?>
	<div class="alert alert-danger">
		관리자가 가상계좌 테스트를 한 경우에만 보입니다.
	</div>

	<form class="form" role="form" method="post" action="http://devadmin.kcp.co.kr/Modules/Noti/TEST_Vcnt_Noti_Proc.jsp" target="_blank">
		<div class="panel panel-default">
			<div class="panel-heading"><strong><i class="fa fa-cog fa-lg"></i> 모의입금처리</strong></div>
			<div class="table-responsive">
				<table class="div-table table bsk-tbl bg-white">
				<col width="120">
				<tbody>
				<tr>
					<th scope="col"><label for="e_trade_no">KCP 거래번호</label></th>
					<td><input type="text" name="e_trade_no" value="<?php echo $pp['pp_tno']; ?>" class="form-control input-sm"></td>
				</tr>
				<tr>
					<th scope="col"><label for="deposit_no">입금계좌</label></th>
					<td><input type="text" name="deposit_no" value="<?php echo $deposit_no; ?>" class="form-control input-sm"></td>
				</tr>
				<tr>
					<th scope="col"><label for="req_name">입금자명</label></th>
					<td><input type="text" name="req_name" value="<?php echo $pp['pp_deposit_name']; ?>" class="form-control input-sm"></td>
				</tr>
				<tr>
					<th scope="col"><label for="noti_url">입금통보 URL</label></th>
					<td><input type="text" name="noti_url" value="<?php echo G5_SHOP_URL; ?>/settle_kcp_common.php" class="form-control input-sm"></td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
		<div id="sod_fin_test" class="text-center">
			<input type="submit" value="입금통보 테스트" class="btn btn-color btn-sm">
		</div>
	</form>
<?php } ?>

<p class="print-hide text-center">
	<button type="button" onclick="apms_print();" class="btn btn-black btn-sm"><i class="fa fa-print"></i> 프린트</button>
	<?php if($setup_href) { ?>
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	<?php } ?>
</p>
