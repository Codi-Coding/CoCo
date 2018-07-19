<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');

if(!$opt) {
	if(!$xp_point) $xp_point = $xp['xp_point'];
	if(!$xp_max) $xp_max = $xp['xp_max'];
	if(!$xp_rate) $xp_rate = $xp['xp_rate'];
}

?>

<style>
	.exp-title { padding:12px; font:bold 18px dotum; letter-spacing:-1px; color:#fff; background:#000; }
	.exp-desc { margin:10px 0px; background:#fafafa; border:1px solid #ddd; line-height:1.6; padding-right:10px; }
	.exp-tbl{width:100%; border-collapse:collapse;border:0;padding:0;} 
	.exp-tbl td, .exp-tbl th{ padding:5px;border:1px solid #ddd; line-height:1.6; text-align:center;}
	.exp-tbl td.head { background:#f5f5f5; font-weight:bold;}
	.exp-tbl .exp-btn {cursor:pointer; width:100px; padding:30px 0; background:red; font-weight:bold; color:#ffffff; border:0px; cursor:pointer;}
	.exp-tbl .ok-btn {cursor:pointer; width:100px; padding:30px 0; background:#1f7bc2; font-weight:bold; color:#ffffff; border:0px; cursor:pointer;}
</style>
<div class="exp-title">
	레벨별 경험치(XP) 시뮬레이터
</div>
<div style="padding:10px;">
	<div class="exp-desc">
		<ul>
		<li>각 레벨별 레벨업 경험치는 이전 레벨의 레벨업 경험치 + 기준경험치 * 경험치증가율(xp rate) 만큼 증가합니다.
		<li>따라서 xp rate 값이 0 이면 레벨업 경험치는 모든 레벨이 동일하게 됩니다.(고정)
		</ul>
	</div>

	<table border=0 class="exp-tbl">
	<form id="expform" name="expform" method="post">
	<input type="hidden" name="opt" value="exp">
	<col width=100><col width=110><col width=110><col width=130><col />
	<tr>
	<td class=head>최대레벨</td>
	<td class=head>기준경험치</td>
	<td class=head>경험치증가율</td>
	</tr>
	<tr>
	<td><input type=text size=10 id="xp_max" name="xp_max" value="<?php echo $xp_max; ?>" class="frm_input" required></td>
	<td><input type=text size=10 id="xp_point" name="xp_point" value="<?php echo $xp_point; ?>" class="frm_input" required></td>
	<td><input type=text size=10 id="xp_rate" name="xp_rate" value="<?php echo $xp_rate; ?>" class="frm_input" required></td>
	</tr>
	</table>

	<br>

	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="시뮬레이션" class="btn_submit" accesskey="s">
		<button type="button" onclick="xp_submit();">등록하기</button>
	</div>

	<br>

	<table class="exp-tbl">
	<col width=60><col width=130><col width=130><col width=130><col />
	<tr>
	<td class=head>레벨</td>
	<td class=head>최소 경험치</td>
	<td class=head>최대 경험치</td>
	<td class=head>레벨업 경험치</td>
	<td class=head>비고</td>
	</tr>
	<tr>
	<td>1</td>
	<td>0</td>
	<td><?php echo number_format($xp_point); ?></td>
	<td><?php echo number_format($xp_point); ?></td>
	</tr>
	<?php
		$min_xp = $xp_point;
		for ($i=2; $i <= $xp_max; $i++) {
			$xp_plus = $xp_point + $xp_point * ($i - 1) * $xp_rate;
			$max_xp = $min_xp + $xp_plus;
	?>
		<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo number_format($min_xp); ?></td>
		<td><?php echo number_format($max_xp); ?></td>
		<td><?php echo number_format($xp_plus); ?></td>
		<td>&nbsp;</td>
		</tr>
			
	<?php	$min_xp = $max_xp; } ?>
	</table>

	<br>

	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="시뮬레이션" class="btn_submit" accesskey="s">
		<button type="button" onclick="xp_submit();">등록하기</button>
	</div>

	<br>

	</form>
</div>

<script> 
	function xp_submit() {
		var xp_point = document.getElementById("xp_point").value;
		var xp_rate = document.getElementById("xp_rate").value;
		var xp_max = document.getElementById("xp_max").value;

		opener.document.basicform.xp_point.value = xp_point;
		opener.document.basicform.xp_rate.value = xp_rate;
		opener.document.basicform.xp_max.value = xp_max;
		self.close();
	}
</script>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>