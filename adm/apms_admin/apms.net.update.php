<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');

if($act == 'ok') {
	// 자료가 많을 경우 대비 설정변경
	set_time_limit ( 0 );
	ini_set('memory_limit', '512M');

	// 공급가 수정하기
	$result = sql_query(" select * from {$g5['g5_shop_cart_table']} where ct_select = '1' ");
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$netsale = $row['pt_sale'] - $row['pt_commission'] - $row['pt_point'] + $row['pt_incentive'];
		if($row['ct_notax']) {
			$net = $netsale;
			$vat = 0;
		} else {
			list($net, $vat) = apms_vat($netsale);
		}

		sql_query(" update {$g5['g5_shop_cart_table']} set pt_net = '$net' where ct_id = '{$row['ct_id']}' ");
	}
?>	
    <script type='text/javascript'> 
		alert('파트너 자료 업데이트를 완료했습니다.'); 
		self.close();
	</script>
<?php } else { ?>
	<form id="defaultform" name="defaultform" method="post" onsubmit="return update_submit(this);">
	<input type="hidden" name="act" value="ok">
	<div style="padding:10px">
		<div style="border:1px solid #ddd; background:#f5f5f5; color:#000; padding:10px; line-height:20px;">
			<b><i class="fa fa-bolt"></i> 파트너 자료 업데이트</b>
		</div>
		<div style="border:1px solid #ddd; border-top:0px; padding:10px;line-height:22px;">
			<ul>
				<li>파트너의 공급가액 및 부가세 등 오류를 재계산하여 수정합니다.</li>
				<li>실행시 전체 거래내역에 자동으로 반영되므로 시간이 걸릴 수 있습니다.</li>
			</ul>
		</div>
		<br>
		<div class="btn_confirm01 btn_confirm">
			<input type="submit" value="실행하기" class="btn_submit" accesskey="s">
		</div>
	</div>
	</form>
	<script>
		function update_submit(f) {
			if(!confirm("실행후 완료메시지가 나올 때까지 기다려 주세요.\n\n정말 실행하시겠습니까?")) {
				return false;	
			} 

			return true;
		}
	</script>
<?php } ?>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>