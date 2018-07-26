<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_LIB_PATH.'/apms.account.lib.php');

if($mode == "payment") {

	//goto_url($go_url.'&amp;'.$qstr);
}

//검색결과
$sql_common = " from {$g5['apms_payment']} ";

$sql_search = "";
if ($stx) {
    $sql_search .= " and {$sfl} like '%{$stx}%' ";
}

$sql_common = " from {$g5['apms_payment']} a left join {$g5['member_table']} b on ( a.mb_id = b.mb_id ) where (1) $sql_search ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];

$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$sql = " select a.*, b.mb_nick, b.mb_email, b.mb_homepage {$sql_common} order by a.pp_confirm, a.pp_id desc limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="?ap=payment" class="ov_listall">전체목록</a>';

//전체현황
$account = array();
$account = apms_balance_sheet("@all");

$marketer = array();
$marketer = apms_balance_sheet("@all", 1);

//세션등록
set_session('pp_inquiry_id', $member['mb_id']);

?>
<style>
	.tbl_head02 td { text-align:center; }
	.pt-request { color:orangered; }
	.pt-complete,
	.pt-complete a,
	.pt-complete span { color:#888; }
</style>
<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    총 <?php echo number_format($total_count) ?> 건
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<input type="hidden" name="ap" value="payment">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="a.pp_id"<?php echo get_selected($sfl, "a.pp_id"); ?>>접수번호</option>
	<option value="b.mb_nick"<?php echo get_selected($sfl, "b.mb_nick"); ?>>닉네임</option>
	<option value="a.mb_id"<?php echo get_selected($sfl, "a.mb_id"); ?>>아이디</option>
	<option value="a.pp_staff"<?php echo get_selected($sfl, "a.pp_staff"); ?>>담당자ID</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" class="btn_submit" value="검색">

</form>

<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
		<th scope="col">구 분</th>
		<th scope="col">총판매액(원)</th>
		<th scope="col">총수수료(원)</th>
		<th scope="col">총포인트(점)</th>
		<th scope="col">총순매출/순적립액(원)</th>
		<th scope="col">총인센티브(원)</th>
		<th scope="col">총배송비(원)</th>
		<th scope="col">총적립액(원)</th>
		<th scope="col">총지급액(원)</th>
		<th scope="col">지급요청(원)</th>
		<th scope="col">현재잔액(원)</th>
    </tr>
    </thead>
    <tbody>
	<tr>
		<td align="center">판매자(셀러)</td>
		<td align="right"><?php echo number_format($account['sale']);?></td>
		<td align="right"><b><?php echo number_format($account['commission']);?></b></td>
		<td align="right"><?php echo number_format($account['point']);?></td>
		<td align="right"><?php echo number_format($account['netsale']);?></td>
		<td align="right"><?php echo number_format($account['intensive']);?></td>
		<td align="right"><?php echo number_format($account['sendcost']);?></td>
		<td align="right"><b><?php echo number_format($account['netgross']);?></b></td>
		<td align="right"><?php echo number_format($account['payment']);?></td>
		<td align="right"><b><?php echo number_format($account['request']);?></b></td>
		<td align="right"><b><?php echo number_format($account['balance']);?></b></td>
	</tr>
	<tr>
		<td align="center">마케터(추천인)</td>
		<td align="right"><?php echo number_format($marketer['sale']);?></td>
		<td align="right">-</td>
		<td align="right">-</td>
		<td align="right"><?php echo number_format($marketer['profit']);?></td>
		<td align="right"><?php echo number_format($marketer['benefit']);?></td>
		<td align="right">-</td>
		<td align="right"><b><?php echo number_format($marketer['netgross']);?></b></td>
		<td align="right"><?php echo number_format($marketer['payment']);?></td>
		<td align="right"><b><?php echo number_format($marketer['request']);?></b></td>
		<td align="right"><b><?php echo number_format($marketer['balance']);?></b></td>
	</tr>
	<tr class="bg-light">
		<td align="center"><b>합 &nbsp; 계</b></td>
		<td align="right">-</td>
		<td align="right"><b><?php echo number_format($account['commission']);?></b></td>
		<td align="right"><?php echo number_format($account['point']);?></td>
		<td align="right"><?php echo number_format($account['netsale'] + $marketer['profit']);?></td>
		<td align="right"><?php echo number_format($account['intensive'] + $marketer['benefit']);?></td>
		<td align="right"><?php echo number_format($account['sendcost']);?></td>
		<td align="right"><b><?php echo number_format($account['netgross'] + $marketer['netgross']);?></b></td>
		<td align="right"><?php echo number_format($account['payment'] + $marketer['payment']);?></td>
		<td align="right"><b><?php echo number_format($account['request'] + $marketer['request']);?></b></td>
		<td align="right"><b><?php echo number_format($account['balance'] + $marketer['balance']);?></b></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="local_desc01 local_desc">
    <p>
        출금신청 목록은 신청/완료/취소 순으로 출력되며, 계정현황에는 회사 판매분과 츨금현황 제외회원의 내역은 포함되어 있지 않습니다.
		&nbsp;
		<b>[<a href="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.tax.php" target="_blank" style="text-decoration:none;">개인 파트너 원천징수내역</a>]</b>
    </p>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
		<th scope="col">번호</th>
		<th scope="col">상태</th>
		<th scope="col">접수번호</th>
        <th scope="col">담당자</th>
		<th scope="col">신청일</th>
		<th scope="col">파트너</th>
		<th scope="col">신청인</th>
		<th scope="col">출금방법</th>
		<th scope="col">정산유형</th>
		<th scope="col">신청금액(원)</th>
		<th scope="col">공급가액(원)</th>
		<th scope="col">부가세(원)</th>
		<th scope="col">제세공과(원)</th>
		<th scope="col">실지급액(원)</th>
		<th scope="col">신고금액(원)</th>
		<th scope="col">메모</th>
		<th scope="col">비고</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

		$pp_num = $total_count - ($page - 1) * $rows - $i;

		$pp_no = $row['pp_id'];
		$pp_date = date("Y/m/d H:i", strtotime($row['pp_datetime']));

		switch($row['pp_means']) {
			case '1'	: $pp_means = AS_MP.'전환'; break;
			default		: $pp_means = '통장입금'; break;
		}

		switch($row['pp_confirm']) {
			case '1'	: $pp_confirm = '<span class="gray">완료</span>'; break;
			case '2'	: $pp_confirm = '<span class="crimson">취소</span>'; break;
			default		: $pp_confirm = '<span class="orangered">신청</span>'; break;
		}

		$pp_partner = ($row['pp_field']) ? '마케터' : '판매자';
		$pp_memo = (trim($row['pp_memo'])) ? '■' : '';
		$pp_ans = (trim($row['pp_ans'])) ? '◎' : '';

		$pp_amount = $row['pp_amount'];
		$pp_net = ceil($row['pp_amount'] / 1.1);
		$pp_vat = $row['pp_amount'] - $pp_net;
		$pp_tax = $row['pp_tax'];
		$pp_pay = $row['pp_pay'];
		$pp_shingo = $row['pp_shingo'];

		//유형
		$pp_type = ($row['pp_type'] == "2") ? '개인' : '기업';
		$pp_company = $row['pp_company'];

		$pp_name = '탈퇴('.$row['mb_id'].')';
		if($row['mb_nick']) {
			$pp_name = apms_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['wr_homepage']);
		}
		
		$pp_staff = '';
		if($row['pp_staff']) {
			$sinfo = get_member($row['pp_staff'], 'mb_nick, mb_email, mb_homepage');
			if($sinfo['mb_nick']) {
				$pp_staff = get_sideview($row['pp_staff'], get_text($sinfo['mb_nick']), $sinfo['mb_email'], $sinfo['mb_homepage']);
			}
		}

		//수정
		$pp_mod = '<a href="./apms.inquiry.php?no='.$row['pp_id'].'" class="mod-inquiry">수정</a>';

        //$bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo ($row['pp_confirm'] == "1") ? 'bg1 pt-complete' : 'bg0';?>">
        <td align="center"><?php echo $pp_num;?></td>
        <td align="center"><?php echo $pp_confirm;?></td>
		<td align="center"><?php echo $pp_no;?></td>
        <td align="center"><?php echo ($pp_staff) ? $pp_staff : '-';?></td>
		<td align="center"><?php echo $pp_date;?></td>
        <td align="center"><?php echo $pp_partner;?></td>
		<td align="center"><b><?php echo $pp_name;?></b></td>
		<td align="center"><?php echo $pp_means;?></td>
		<td align="center"><?php echo $pp_company;?></td>
		<td align="right"><?php echo number_format($pp_amount);?></td>
        <td align="right"><?php echo number_format($pp_net);?></td>
        <td align="right"><?php echo number_format($pp_vat);?></td>
		<td align="right"><?php echo number_format($pp_tax);?></td>
        <td align="right"><?php echo number_format($pp_pay);?></td>
        <td align="right"><?php echo number_format($pp_shingo);?></td>
		<td align="center"><?php echo $pp_memo;?></td>
        <td align="center"><?php echo $pp_ans;?></td>
        <td align="center"><?php echo $pp_mod;?></td>
	</tr>

	<?php
    }
    if ($i == 0)
        echo "<tr><td colspan=\"18\" class=\"empty_table\">자료가 없습니다.</td></tr>";
    ?>
    </tbody>
    </table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;ap='.$ap.'&amp;page='); ?>

<script>
$(function() {
    $(".mod-inquiry").click(function() {
        var opt = "left=50,top=50,width=520,height=600,scrollbars=1";
        var url = this.href;
        window.open(url, "win_inquiry", opt);
		return false;
	});
});
</script>
