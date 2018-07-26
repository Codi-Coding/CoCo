<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<div id="sch_target_frm" class="new_win scp_new_win">
    <h1>출금신청서</h1>

    <form name="ftarget" method="post" action="./payupdate.php">
	<input type="hidden" name="ap" value="<?php echo $ap;?>">
	<input type="hidden" name="pp_amount" value="<?php echo $row['pp_amount']; ?>">
	<input type="hidden" name="pp_means" value="<?php echo $row['pp_means']; ?>">
	<input type="hidden" name="pp_field" value="<?php echo $row['pp_field']; ?>">

    <div class="tbl_head02 tbl_wrap">
        <table>
        <colgroup>
            <col class="grid_2">
            <col class="grid_2">
            <col>
		</colgroup>
        <caption>신청내역</caption>
        <thead>
        <tr>
            <th scope="col">구분</th>
            <th colspan="2" scope="col">주요내용</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td align="center">출금방법</td><td colspan="2"><?php echo $pp_means; ?></td>
        </tr>
		<?php if(!$row['pp_means']) { ?>
			<tr>
				<td align="center">입금계좌</td><td colspan="2"><?php echo ($partner['pt_bank_account']) ? $partner['pt_bank_name'].' '.$partner['pt_bank_account'].' '.$partner['pt_bank_holder'] : '미등록';?></td>
			</tr>
		<?php } ?>
		<tr>
            <td align="center">정산유형</td><td colspan="2"><?php echo $row['pp_company']; ?></td>
        </tr>
		<tr>
            <td align="center">정산방법</td><td colspan="2"><?php echo $pp_flag; ?></td>
        </tr>
		<tr>
            <td align="center">신청금액</td><td align="right"><b><?php echo number_format($row['pp_amount']); ?>원</b></td><td></td>
        </tr>
        <tr>
            <td align="center">공급가액</td><td align="right"><?php echo number_format($row['pp_net']); ?>원</td><td>(신청금액 / 1.1)</td>
        </tr>
        <tr>
            <td align="center">부가세</td><td align="right"><?php echo number_format($row['pp_vat']); ?>원</td><td>(공급가액의 10%)</td>
        </tr>
		<tr>
            <td align="center">제세공과</td><td align="right"><?php echo number_format($pp['tax']);?>원</td><td>(공급가액에 대한 원천징수 3.3% 등)</td>
        </tr>
        <tr>
            <td align="center">실지급액</td><td align="right"><b><?php echo number_format($pp['pay']);?>원</b></td><td>(실입금/전환금액)</td>
        </tr>
        <tr>
            <td align="center">신고금액</td><td align="right"><?php echo number_format($pp['shingo']);?>원</td><td>(세무서 신고금액)</td>
        </tr>
		<tr>
            <td align="center">메모</td><td colspan="2">
				<?php echo conv_content(trim($pp_memo), 0);?>
				<textarea name="pp_memo" style="display:none;"><?php echo trim($pp_memo);?></textarea>
			</td>
        </tr>
		</tbody>
        </table>
    </div>

	<div class="btn_confirm01 btn_confirm">
		<input class="btn_submit" accesskey="s" type="submit" value="신청">
		<button type="button" onclick="window.close();">닫기</button>
    </div>

	</form>
</div>
