<?php
if (!defined('_GNUBOARD_')) exit;

if($mode == "plist") {

	if($_POST['act_button'] == "선택승인") {

		if (!count($_POST['chk'])) {
			alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
		}
		
		$pt_register = date("Ymd"); //등록일
		for ($i=0; $i<count($_POST['chk']); $i++) {
			$k = $_POST['chk'][$i]; // 실제 번호를 넘김
			sql_query(" update {$g5['apms_partner']} set pt_register = '{$pt_register}', pt_partner = '{$_POST['ptr'][$k]}', pt_marketer = '{$_POST['pmkt'][$k]}', pt_level = '{$_POST['pt_level'][$k]}' where pt_id = '{$_POST['pt_id'][$k]}' ");

			//회원정보변경
			sql_query(" update {$g5['member_table']} set as_partner = '{$_POST['ptr'][$k]}', as_marketer = '{$_POST['pmkt'][$k]}' where mb_id = '{$_POST['pt_id'][$k]}' ", false);
		}

	} else if($_POST['act_button'] == "일괄수정") {

		for ($i=0; $i<count($_POST['pt_id']); $i++) {
			sql_query(" update {$g5['apms_partner']} set pt_partner = '{$_POST['ptr'][$i]}', pt_marketer = '{$_POST['pmkt'][$i]}', pt_level = '{$_POST['pt_level'][$i]}' where pt_id = '{$_POST['pt_id'][$i]}' ", false);

			//회원정보변경
			sql_query(" update {$g5['member_table']} set as_partner = '{$_POST['ptr'][$i]}', as_marketer = '{$_POST['pmkt'][$i]}' where mb_id = '{$_POST['pt_id'][$i]}' ", false);
		}

	}

	goto_url($go_url.'&amp;'.$qstr);
}

// 탈퇴 파트너수
$row = sql_fetch(" select count(*) as cnt from {$g5['apms_partner']} where pt_leave <> '' ");
$leave_count = $row['cnt'];

// 검색
$sql_search = "";
if ($stx) {
	$sql_search .= " and {$sfl} like '%{$stx}%' ";
}

if (!$sst) {
    $sst = "a.pt_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql_common = " from {$g5['apms_partner']} a left join {$g5['member_table']} b on ( a.pt_id = b.mb_id ) ";

$sql = " select count(*) as cnt $sql_common where (1) $sql_search ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.*, b.mb_nick, b.mb_email, b.mb_homepage {$sql_common} where (1) {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="?ap=plist" class="ov_listall">전체목록</a>';

?>
<style>
	.tbl_head02 td { text-align:center; }
	.pt-request { color:orangered; }
	.pg_wrap { padding-top:0px; padding-right:20px; }
</style>
<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="ov_listall">현재 <b><?php echo number_format($total_count) ?></b>명 파트너가 있습니다.</span>
    탈퇴 <?php echo number_format($leave_count) ?></a>명
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<input type="hidden" name="ap" value="plist">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="b.mb_nick"<?php echo get_selected($sfl, "b.mb_nick"); ?>>닉네임</option>
    <option value="a.mb_nick"<?php echo get_selected($sfl, "a.pt_name"); ?>>담당자</option>
	<option value="a.pt_id"<?php echo get_selected($sfl, "a.pt_id"); ?>>아이디</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit" value="검색">

</form>

<form name="fmemberlist" id="fmemberlist" action="./apms.admin.php" onsubmit="return fmemberlist_submit(this);" method="post">
<input type="hidden" name="ap" value="plist">
<input type="hidden" name="mode" value="plist">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">회원 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">번호</th>
        <th scope="col">구분</th>
		<th scope="col"><?php echo apms_sort_link('a.pt_register') ?>승인일</a> / <?php echo apms_sort_link('a.pt_leave') ?>탈퇴일</a></th>
        <th scope="col"><?php echo apms_sort_link('a.pt_partner') ?>판매자</a></th>
        <th scope="col" colspan="2">
			<?php echo apms_sort_link('a.pt_marketer') ?>추천인</a>
			/	
			<?php echo apms_sort_link('a.pt_level') ?>레벨</a>
		</th>
		<th scope="col"><?php echo apms_sort_link('a.pt_type') ?>유형</a></th>
		<th scope="col"><?php echo apms_sort_link('b.mb_id') ?>닉네임</a></th>
        <th scope="col"><?php echo apms_sort_link('a.pt_name') ?>담당자</a></th>
        <th scope="col"><?php echo apms_sort_link('a.pt_hp') ?>담당자 연락처</a></th>
        <th scope="col"><?php echo apms_sort_link('a.pt_email') ?>담당자 이메일</a></th>
        <th scope="col"><?php echo apms_sort_link('a.pt_company') ?>정산</a></th>
        <th scope="col"><?php echo apms_sort_link('a.pt_bank_limit') ?>출금</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
	$list_num = $total_count - ($page - 1) * $rows;
    for ($i=0; $row=sql_fetch_array($result); $i++) {

		//구분
		$is_check = false;
		if($row['pt_leave']) { //탈퇴
			$p_active = '<span class="mb_leave_msg">탈퇴</span>';
			$p_status = '<span class="mb_leave_msg"><strike>'.preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $row['pt_leave']).'</strike></span>';
		} else if($row['pt_register']) { //등록
			$p_active = '활동';
			$p_status = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $row['pt_register']);
		} else { //신청
			$p_active = '<span class="pt-request">대기</span>';
			$p_status = '<span class="pt-request">신청</span>';
			$is_check = true;
		}

		//유형
		$p_type = ($row['pt_type'] == "2") ? '개인' : '기업';

		$p_name = '탈퇴('.$row['pt_id'].')';
		if($row['mb_nick']) {
			$p_name = apms_sideview($row['pt_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);
		}

		//수정
		$p_mod = '<a href="./apms.admin.php?ap=pform&amp'.$qstr.'&amp;pt_id='.$row['pt_id'].'">수정</a>';

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td headers="mb_list_chk" class="td_chk" align="center">
            <input type="hidden" name="pt_id[<?php echo $i ?>]" value="<?php echo $row['pt_id'] ?>" id="pt_id_<?php echo $i ?>">
			<?php if($is_check) { ?>
	            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
			<?php } else { ?>
				*
			<?php } ?>
        </td>
        <td align="center"><?php echo $list_num;?></td>
		<td align="center"><?php echo $p_active;?></td>
		<td align="center"><?php echo $p_status;?></td>
        <td align="center">
            <input type="checkbox" name="ptr[<?php echo $i ?>]" value="1" id="ptr_<?php echo $i ?>"<?php echo ($row['pt_partner']) ? ' checked' : '';?>>
		</td>
        <td align="center">
            <input type="checkbox" name="pmkt[<?php echo $i ?>]" value="1" id="pmkt_<?php echo $i ?>"<?php echo ($row['pt_marketer']) ? ' checked' : '';?>>
		</td>
        <td  align="center" style="width:50px;">
			<?php echo get_member_level_select("pt_level[$i]", 1, 10, $row['pt_level']) ?>
        </td>
		<td align="center"><?php echo $p_type;?></td>
		<td align="center"><?php echo $p_name;?></td>
		<td align="center"><b><?php echo $row['pt_name'];?></b></td>
		<td align="center"><?php echo $row['pt_hp'];?></td>
		<td align="center"><?php echo $row['pt_email'];?></td>
		<td align="center"><?php echo $row['pt_company'];?></td>
		<td align="center"><?php echo ($row['pt_bank_limit']) ? '불가' : '가능';?></td>
		<td align="center"><?php echo $p_mod;?></td>
    </tr>
	<?php $list_num--; } ?>
	<?php if ($i == 0) { ?>
        <tr><td colspan="15" class="empty_table">등록된 파트너가 없습니다.</td></tr>
    <?php } ?>
    </tbody>
    </table>
</div>

<div class="btn_confirm01 btn_confirm" style="float:left">
    <input type="submit" name="act_button" value="선택승인" onclick="document.pressed=this.value" class="btn_submit">
    <input type="submit" name="act_button" value="일괄수정" onclick="document.pressed=this.value" class="btn_submit">
</div>

<div style="float:right;">
	<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;ap=plist&amp;page='); ?>
</div>

<div style="clear:both;"></div>

</form>

<script>
function fmemberlist_submit(f)
{
    if(document.pressed == "선택승인") {

		if (!is_checked("chk[]")) {
			alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
			return false;
		}

        if(!confirm("선택한 파트너를 정말 등록승인하시겠습니까?")) {
            return false;
        }

    } else if(document.pressed == "일괄수정") {

        if(!confirm("판매자와 추천인을 일괄수정하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>
