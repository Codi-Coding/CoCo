<?php
if (!defined('_GNUBOARD_')) exit;

if($mode == "basic") {

	check_token();

	$apms_stipulation = substr($_POST['apms_stipulation'],0,65536);
	$apms_stipulation = preg_replace("#[\\\]+$#", "", $apms_stipulation);

	$apms_notice = substr($_POST['apms_notice'],0,65536);
	$apms_notice = preg_replace("#[\\\]+$#", "", $apms_notice);

	$apms_account_no = substr($_POST['apms_account_no'],0,65536);
	$apms_account_no = preg_replace("#[\\\]+$#", "", $apms_account_no);

	$apms_payment_no = substr($_POST['apms_payment_no'],0,65536);
	$apms_payment_no = preg_replace("#[\\\]+$#", "", $apms_payment_no);

	$sql = " update {$g5['apms']}
				set apms_company            = '{$_POST['apms_company']}'
					, apms_personal           = '{$_POST['apms_personal']}'
					, apms_register           = '{$_POST['apms_register']}'
					, apms_email_yes          = '{$_POST['apms_email_yes']}'
					, apms_cert_yes           = '{$_POST['apms_cert_yes']}'
					, apms_adult_yes          = '{$_POST['apms_adult_yes']}'
					, apms_partner	          = '{$_POST['apms_partner']}'
					, apms_marketer	          = '{$_POST['apms_marketer']}'
					, apms_commission_1       = '{$_POST['apms_commission_1']}'
					, apms_commission_2       = '{$_POST['apms_commission_2']}'
					, apms_commission_3       = '{$_POST['apms_commission_3']}'
					, apms_commission_4       = '{$_POST['apms_commission_4']}'
					, apms_commission_5       = '{$_POST['apms_commission_5']}'
					, apms_benefit1		      = '{$_POST['apms_benefit1']}'
					, apms_benefit2		      = '{$_POST['apms_benefit2']}'
					, apms_benefit3		      = '{$_POST['apms_benefit3']}'
					, apms_benefit4		      = '{$_POST['apms_benefit4']}'
					, apms_benefit5		      = '{$_POST['apms_benefit5']}'
					, apms_benefit6		      = '{$_POST['apms_benefit6']}'
					, apms_benefit7		      = '{$_POST['apms_benefit7']}'
					, apms_benefit8		      = '{$_POST['apms_benefit8']}'
					, apms_benefit9		      = '{$_POST['apms_benefit9']}'
					, apms_benefit10	      = '{$_POST['apms_benefit10']}'
					, apms_payment		      = '{$_POST['apms_payment']}'
					, apms_payment_cut	      = '{$_POST['apms_payment_cut']}'
					, apms_payment_day	      = '{$_POST['apms_payment_day']}'
					, apms_payment_limit      = '{$_POST['apms_payment_limit']}'
					, apms_admin_name         = '{$_POST['apms_admin_name']}'
					, apms_admin_email        = '{$_POST['apms_admin_email']}'
					, apms_admin_hp           = '{$_POST['apms_admin_hp']}'
					, apms_stipulation	      = '$apms_stipulation'
					, apms_notice		      = '$apms_notice'
					, apms_account_no	      = '$apms_account_no'
					, apms_skin		          = '{$_POST['apms_skin']}'
					, apms_1			      = '{$_POST['apms_1']}'
					, apms_2			      = '{$_POST['apms_2']}'
					, apms_3			      = '{$_POST['apms_3']}'
					, apms_4			      = '{$_POST['apms_4']}'
					, apms_5			      = '{$_POST['apms_5']}'
					, apms_6			      = '{$_POST['apms_6']}'
					, apms_7			      = '{$_POST['apms_7']}'
					, apms_8			      = '{$_POST['apms_8']}'
					, apms_9			      = '{$_POST['apms_9']}'
					, apms_10			      = '{$_POST['apms_10']}'
			";
	sql_query($sql);

	goto_url($go_url);
}

$token = get_token();

$frm_submit = '<div class="btn_confirm01 btn_confirm"><input type="submit" value="확인" class="btn_submit" accesskey="s"></div>';

?>

<div class="local_ov01 local_ov">
	<b>주의!</b> 파트너 유형과 회원 유형이 설정되어 있어야 파트너 등록신청을 받을 수 있습니다.
</div>

<form name="apms_configform" id="apms_configform" method="post">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
<input type="hidden" name="ap" value="<?php echo $ap;?>">
<input type="hidden" name="mode" value="<?php echo $ap;?>">

<section>
	<div class="tbl_frm01 tbl_wrap">
		<table>
        <colgroup>
            <col class="grid_4">
            <col>
		</colgroup>
        <tbody>
        <tr>
            <th scope="row">파트너 전체알림</th>
            <td>
                <textarea id="apms_notice" name="apms_notice" rows="5" placeholder="파트너 전체알림 내용을 입력합니다."><?php echo $apms['apms_notice'] ?></textarea>
            </td>
        </tr>
		<tr>
            <th scope="row" style="border-top:0;">파트너 분야</th>
            <td style="border-top:0;">
				<label><input type="checkbox" name="apms_partner" value="1" id="apms_partner"<?php echo $apms['apms_partner'] ? ' checked' : ''; ?>> 판매자(셀러)</label>
				&nbsp; &nbsp;
				<label><input type="checkbox" name="apms_marketer" value="1" id="apms_marketer"<?php echo $apms['apms_marketer'] ? ' checked' : ''; ?>> 추천인(마케터)</label>
			</td>
		</tr>
		<tr>
            <th scope="row" style="border-top:0;">파트너 유형</th>
            <td style="border-top:0;">
				<label><input type="checkbox" name="apms_company" value="1" id="apms_company"<?php echo $apms['apms_company'] ? ' checked' : ''; ?>> 기업 파트너</label>
				&nbsp; &nbsp;
				<label><input type="checkbox" name="apms_personal" value="1" id="apms_personal"<?php echo $apms['apms_personal'] ? ' checked' : ''; ?>> 개인 파트너</label>
			</td>
		</tr>
		<tr>
			<th scope="row">파트너 등록</th>
            <td>
				<label><input type="radio" name="apms_register" value="0"<?php echo ($apms['apms_register'] == "0") ? ' checked' : ''; ?>> 심사등록</label>
				&nbsp; &nbsp;
				<label><input type="radio" name="apms_register" value="1"<?php echo ($apms['apms_register'] == "1") ? ' checked' : ''; ?>> 자동등록</label>
			</td>
		</tr>
		<tr>
		   <th scope="row">파트너 조건</th>
            <td>
				<label><input type="checkbox" name="apms_email_yes" value="1" id="apms_email_yes"<?php echo $apms['apms_email_yes'] ? ' checked' : ''; ?>> 이메일 인증</label>
				&nbsp; &nbsp;
				<label><input type="checkbox" name="apms_cert_yes" value="1" id="apms_cert_yes"<?php echo $apms['apms_cert_yes'] ? ' checked' : ''; ?>> 본인인증</label>
				&nbsp; &nbsp;
				<label><input type="checkbox" name="apms_adult_yes" value="1" id="apms_adult_yes"<?php echo $apms['apms_adult_yes'] ? ' checked' : ''; ?>> 성인인증</label>
			</td>
		</tr>
		<tr>
			<th scope="row">일반상품 수수료</th>
            <td>
                부가세를 포함한 총판매금액에서 수수료 <input type="text" name="apms_commission_1" value="<?php echo $apms['apms_commission_1'] ?>" id="apms_commission_1" class="required numeric frm_input" size="4"> % 를 공제후 판매자(셀러)에게 적립
			</td>
		</tr>
		<tr>
			<th scope="row">컨텐츠상품 수수료</th>
            <td>
                부가세를 포함한 총판매금액에서 수수료 <input type="text" name="apms_commission_2" value="<?php echo $apms['apms_commission_2'] ?>" id="apms_commission_2" class="required numeric frm_input" size="4"> % 를 공제후 판매자(셀러)에게 적립
			</td>
		</tr>
		<tr>
			<th scope="row">추천인(마케터) 인센티브</th>
            <td>
				<?php echo help('레벨에 따라 기본 적립금액의 %를 추가 적립되며, 개별 인센티브율과 더해서 반영됩니다. ex) 총수익 = 기본 적립금액 + 기본 적립금액 × (레벨% + 개별 인센티브%)');?>
				<table>
				<tr style="background:#fafafa;">
					<td>구분</td>
					<td>1레벨</td>
					<td>2레벨</td>
					<td>3레벨</td>
					<td>4레벨</td>
					<td>5레벨</td>
					<td>6레벨</td>
					<td>7레벨</td>
					<td>8레벨</td>
					<td>9레벨</td>
					<td>10레벨</td>
					<td>비고</td>
				</tr>
				<tr>
					<td>인센티브</td>
					<td>
						<input type="text" name="apms_benefit1" value="<?php echo $apms['apms_benefit1'] ?>" id="apms_benefit1" class="required numeric frm_input" size="6"> %
					</td>
					<td>
						<input type="text" name="apms_benefit2" value="<?php echo $apms['apms_benefit2'] ?>" id="apms_benefit2" class="required numeric frm_input" size="6"> %
					</td>
					<td>
						<input type="text" name="apms_benefit3" value="<?php echo $apms['apms_benefit3'] ?>" id="apms_benefit3" class="required numeric frm_input" size="6"> %
					</td>
					<td>
						<input type="text" name="apms_benefit4" value="<?php echo $apms['apms_benefit4'] ?>" id="apms_benefit4" class="required numeric frm_input" size="6"> %
					</td>
					<td>
						<input type="text" name="apms_benefit5" value="<?php echo $apms['apms_benefit5'] ?>" id="apms_benefit5" class="required numeric frm_input" size="6"> %
					</td>
					<td>
						<input type="text" name="apms_benefit6" value="<?php echo $apms['apms_benefit6'] ?>" id="apms_benefit6" class="required numeric frm_input" size="6"> %
					</td>
					<td>
						<input type="text" name="apms_benefit7" value="<?php echo $apms['apms_benefit7'] ?>" id="apms_benefit7" class="required numeric frm_input" size="6"> %
					</td>
					<td>
						<input type="text" name="apms_benefit8" value="<?php echo $apms['apms_benefit8'] ?>" id="apms_benefit8" class="required numeric frm_input" size="6"> %
					</td>
					<td>
						<input type="text" name="apms_benefit9" value="<?php echo $apms['apms_benefit9'] ?>" id="apms_benefit9" class="required numeric frm_input" size="6"> %
					</td>
					<td>
						<input type="text" name="apms_benefit10" value="<?php echo $apms['apms_benefit10'] ?>" id="apms_benefit10" class="required numeric frm_input" size="6"> %
					</td>
					<td></td>
				</tr>
				</table>
			</td>
		</tr>

		<tr>
			<th scope="row">출금조건</th>
            <td>
                출금신청은 <input type="text" name="apms_payment" value="<?php echo $apms['apms_payment'] ?>" id="apms_payment" class="required numeric frm_input" size="8"> 원부터 만원단위로 신청
				&nbsp; &nbsp;
				<label><input type="checkbox" name="apms_payment_cut" value="1" id="apms_payment_cut"<?php echo $apms['apms_payment_cut'] ? ' checked' : ''; ?>> 천원단위로 신청가능</label>
			</td>
		</tr>
		<tr>
			<th scope="row">출금제한</th>
            <td>
                출금신청은 매월/매주 <input type="text" name="apms_payment_limit" value="<?php echo $apms['apms_payment_limit'] ?>" id="apms_payment_limit" class="frm_input" size="40" placeholder="날짜는 01,15,25 형태로 등록 - 콤마(,)로 구분"> 가능
				&nbsp; &nbsp;
				<label><input type="checkbox" name="apms_payment_day" value="1" id="apms_payment_day"<?php echo $apms['apms_payment_day'] ? ' checked' : ''; ?>> 요일단위로 설정(월,화,수,목,금,토,일 형태 입력)</label>
			</td>
		</tr>
		<tr>
            <th scope="row">출금현황 제외회원</th>
            <td>
                <textarea id="apms_account_no" name="apms_account_no" rows="5" placeholder="출금관리의 전체현황에서 제외할 회원아이디를 콤마(,)로 구분해서 등록"><?php echo $apms['apms_account_no'] ?></textarea>
            </td>
        </tr>
		<tr>
            <th scope="row">담당자 이름</th>
            <td>
				<input type="text" name="apms_admin_name" value="<?php echo $apms['apms_admin_name'] ?>" id="apms_admin_name" class="frm_input" size="30">
			</td>
		</tr>
		<tr>
			<th scope="row">담당자 이메일</th>
            <td>
				<input type="text" name="apms_admin_email" value="<?php echo $apms['apms_admin_email'] ?>" id="apms_admin_email" class="frm_input" size="30">
			</td>
		</tr>
		<tr>
            <th scope="row">담당자 연락처</th>
            <td>
				<input type="text" name="apms_admin_hp" value="<?php echo $apms['apms_admin_hp'] ?>" id="apms_admin_hp" class="frm_input" size="30">
			</td>
        </tr>
        <tr>
            <th scope="row">파트너 가입약관</th>
            <td>
                <textarea id="apms_stipulation" name="apms_stipulation" rows="5" placeholder="파트너 가입약관 내용을 입력합니다."><?php echo $apms['apms_stipulation'] ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row">대시보드 스킨</th>
            <td>
				<?php 
					$dashboard_list = apms_dir_list(G5_SHOP_DIR.'/partner/skin'); 
					echo apms_select_list($dashboard_list, 'apms_skin', $apms['apms_skin'], '', 160);
				?>
            </td>
        </tr>
		<?php for($i=1;$i <= 10;$i++) { ?>
			<tr>
				<th scope="row">여분필드<?php echo $i;?></th>
				<td>
					<input type="text" name="apms_<?php echo $i;?>" value="<?php echo $apms['apms_'.$i] ?>" id="apms_<?php echo $i;?>" class="frm_input" size="60">
				</td>
			</tr>
			<tr>
		<?php } ?>
		</tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

</form>
