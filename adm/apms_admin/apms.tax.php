<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');

?>

<style>
	.exp-title { padding:12px; font:bold 18px dotum; letter-spacing:-1px; color:#fff; background:#000; }
	.exp-desc { margin:10px 0px; background:#fafafa; border:1px solid #ddd; line-height:1.6; padding-right:10px; }
	.exp-tbl{width:100%; border-collapse:collapse;border:0;padding:0;} 
	.exp-tbl td, .exp-tbl th{ padding:5px;border:1px solid #ddd; line-height:1.6; text-align:center;}
	.exp-tbl td.head { background:#f5f5f5; font-weight:bold;}
	.exp-tbl .exp-btn {cursor:pointer; width:100px; padding:5px 0; background:red; font-weight:bold; color:#ffffff; border:0px; cursor:pointer;}
</style>
<div class="exp-title">
	개인 파트너 원천징수내역
</div>
<div style="padding:10px;">
	<table border=0 class="exp-tbl">
	<form id="taxform" name="taxform" method="post">
	<input type="hidden" name="opt" value="tax">
	<tr>
	<td class=head>시작년월일</td>
	<td class=head>종료년월일</td>
	<td class=head>내역보기</td>
	</tr>
	<tr>
	<td><input type=text size=12 id="fr_date" name="fr_date" value="<?php echo ($fr_date) ? $fr_date : G5_TIME_YMD; ?>" class="frm_input" required></td>
	<td><input type=text size=12 id="to_date" name="to_date" value="<?php echo ($to_date) ? $to_date : G5_TIME_YMD; ?>" class="frm_input" required></td>
	<td><input type="submit" value="확인" class="exp-btn" accesskey="s"></td>
	</tr>
	</table>
	</form>

	<?php if($fr_date && $to_date) { ?>
	<br>

	<table class="exp-tbl">
	<tr>
	<td class=head>번호</td>
	<td class=head>일시</td>
	<td class=head>신고금액</td>
	<td class=head>원천징수(3.3%)</td>
	<td class=head>실지급액</td>
	<td class=head>이름</td>
	<td class=head>주민등록번호(사업자등록번호 항목)</td>
	<td class=head>은행정보</td>
	</tr>
	<?php
		$sql = " select a.*, b.pt_bank_name, b.pt_bank_holder, b.pt_company_saupja from {$g5['apms_payment']} a left join {$g5['apms_partner']} b on ( a.mb_id = b.pt_id ) 
					where a.pp_means <> '1' and a.pp_confirm = '1' and a.pp_company = '개인(원천징수)' and SUBSTRING(a.pp_datetime,1,10) between '$fr_date' and '$to_date' 
					order by a.pp_datetime ";
		$result = sql_query($sql);
	    for ($i=0; $row=sql_fetch_array($result); $i++) {
	?>
		<tr>
		<td><?php echo $i + 1;?></td>
		<td><?php echo substr($row['pp_datetime'], 0, 10);?></td>
		<td><?php echo $row['pp_shingo'];?></td>
		<td><?php echo $row['pp_tax'];?></td>
		<td><?php echo $row['pp_pay'];?></td>
		<td><?php echo ($row['pp_name']) ? $row['pp_name'] : $row['pt_bank_holder'];?></td>
		<td><?php echo ($row['pp_jumin']) ? $row['pp_jumin'] : $row['pt_company_saupja'];?></td>
		<td><?php echo ($row['pp_bank']) ? $row['pp_bank'] : $row['pt_bank_name'];?></td>
		</tr>
	<?php } ?>
	<?php if(!$i) { ?>
		<tr><td colspan="8" style="padding:100px 0px;">자료가 없습니다.</td></tr>
	<?php } ?>
	</table>
	<?php } ?>
</div>

<?php include_once(G5_PATH.'/tail.sub.php'); ?>