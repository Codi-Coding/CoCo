<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$list = array();

// 검색
$sql_search = "";
if ($stx) {
	if($sfl == "a.od_id") {
		$stx = str_replace("-", "", $stx);
	}
	$sql_search .= " and {$sfl} like '%$stx%' ";
}

//조회기간이 있으면
$sql_date = '';
if(isset($fr_date) && $fr_date && isset($to_date) && $to_date) {
	$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
	$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);
	$sql_date .= "and SUBSTRING(a.sc_datetime,1,10) between '$fr_day' and '$to_day'";
	$qstr .= '&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date;

} else {
	$fr_date = $to_date = '';
}

$sql_common = " from {$g5['apms_sendcost']} a left join {$g5['member_table']} b on ( a.pt_id = b.mb_id ) where a.pt_id <> '' and a.sc_flag = '1' $sql_search $sql_date ";

$row = sql_fetch(" select count(*) as cnt {$sql_common} ");
$total_count = $row['cnt'];

$rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];

$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
$page = ($page > 1) ? $page : 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$start_rows = ($page - 1) * $rows; // 시작 열을 구함
$list_num = $total_count - ($page - 1) * $rows;
$result = sql_query(" select a.*, b.mb_nick, b.mb_email, b.mb_homepage $sql_common order by a.sc_id desc limit $start_rows, $rows ", false);
for ($i=0; $row=sql_fetch_array($result); $i++) { 

	$list[$i] = $row;
	$list[$i]['num'] = $list_num;

	$list[$i]['pt_name'] = '탈퇴';
	if($row['pt_id']) {
		if($row['mb_nick']) {
			$list[$i]['pt_name'] = apms_sideview($row['pt_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);
		}
	} else {
		$list[$i]['pt_name'] = '-';
	}

	// 주문번호에 - 추가
	switch(strlen($row['od_id'])) {
		case 16:
			$disp_od_id = substr($row['od_id'],0,8).'-'.substr($row['od_id'],8);
			break;
		default:
			$disp_od_id = substr($row['od_id'],0,6).'-'.substr($row['od_id'],6);
			break;
	}

	$list[$i]['od_num'] = $disp_od_id; 

	if(!$list[$i]['it_name']) {
		$it = apms_it($row['it_id']);
		$list[$i]['it_name'] = $it['it_name'];
	}

	$list_num--;
}

//print_r2($list);

// 페이징
$list_page = './apms.admin.php?ap='.$ap.$qstr.'&amp;page=';
?>

<div class="local_ov01 local_ov">
	<a href="./apms.admin.php?ap=sendcost" class="ov_listall">전체목록</a>
	총 <b><?php echo number_format($total_count); ?></b>건의 파트너별 개별 배송비 정산내역이 있습니다.
</div>

<form name="frm_sendcost" class="local_sch02 local_sch" method="get">
<input type="hidden" name="ap" value="<?php echo $ap;?>">
<div class="sch_last">
    <strong>주문일자</strong>
	<input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" class="frm_input" size="10" maxlength="10">
	~
	<input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" class="frm_input" size="10" maxlength="10">
	<select name="sfl" id="sfl">
		<option value="b.mb_nick"<?php echo get_selected($sfl, 'b.mb_nick');?>>닉네임</option>
		<option value="a.pt_id"<?php echo get_selected($sfl, 'a.pt_id');?>>아이디</option>
		<option value="a.od_id"<?php echo get_selected($sfl, 'a.od_id');?>>주문번호</option>
		<option value="a.it_id"<?php echo get_selected($sfl, 'a.it_id');?>>상품코드</option>
		<option value="a.it_name"<?php echo get_selected($sfl, 'a.it_name');?>>상품명</option>
	</select>
	<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="frm_input" autocomplete="off">
	<input type="submit" value="검색" class="btn_submit">
</div>
</form>
<script>
$(function() {
	$("#fr_date, #to_date").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yymmdd",
		showButtonPanel: true,
		yearRange: "c-99:c+99",
		maxDate: "+0d"
	});
});
</script>

<div class="tbl_head01 tbl_wrap">
	<table>
    <caption>배송비 내역 목록</caption>
	<thead>
	<tr>
		<th scope="col">번호</th>
		<th scope="col">파트너</th>
		<th scope="col" style="width:60px;">이미지</th>
		<th scope="col">배송상품</th>
		<th scope="col">상품코드</th>
		<th scope="col">배송비 조건</th>
		<th scope="col">배송비(원)</th>
		<th scope="col">주문서</th>
		<th scope="col">주문번호</th>
		<th scope="col">주문일시</th>
		<th scope="col">정산일시</th>
	</tr>
	</thead>
	<tbody>
	<?php for ($i=0; $i < count($list); $i++) { ?>
		<tr>
			<td align="center">
				<?php echo $list[$i]['num'];?>
			</td>
			<td align="center">
				<b><?php echo $list[$i]['pt_name'];?></b>
				<?php echo ($list[$i]['pt_id']) ? '<br>('.$list[$i]['pt_id'].')' : '';?>
			</td>
			<td align="center">
				<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $list[$i]['it_id']; ?>">
					<?php echo get_it_image($list[$i]['it_id'], 50, 50); ?>
				</a>
			</td>
			<td>
				<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $list[$i]['it_id']; ?>">
					<?php echo $list[$i]['it_name'];?>
				</a>
			</td>
			<td align="center">
				<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $list[$i]['it_id']; ?>">
					<?php echo $list[$i]['it_id'];?>
				</a>
			</td>
			<td align="center">
				<?php echo $list[$i]['sc_type'];?>
			</td>
			<td align="right">
				<?php echo ($list[$i]['sc_price']) ? number_format($list[$i]['sc_price']) : '-'; ?>
			</td>
			<td align="center">
				<a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $list[$i]['od_id']; ?>">
					<i class="fa fa-file-text-o fa-lg"></i>
				</a>
			</td>
			<td align="center">
				<a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $list[$i]['od_id']; ?>&amp;uid=<?php echo $list[$i]['uid']; ?>" class="orderitem">
					<?php echo $list[$i]['od_num'];?>
				</a>
			</td>
			<td align="center">
				<?php echo $list[$i]['sc_datetime'];?>
			</td>
			<td align="center">
				<?php echo $list[$i]['pt_datetime'];?>
			</td>
		</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="11" class="empty_table">등록된 배송비 내역이 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $list_page); ?>
 
<script>
$(function(){
     // 주문상품보기
    $(".orderitem").on("click", function() {
        var $this = $(this);
        var od_id = $this.text().replace(/[^0-9]/g, "");

        if($this.next("#orderitemlist").size())
            return false;

        $("#orderitemlist").remove();

        $.post(
            "../shop_admin/ajax.orderitem.php",
            { od_id: od_id },
            function(data) {
                $this.after("<div id=\"orderitemlist\"><div class=\"itemlist\"></div></div>");
                $("#orderitemlist .itemlist")
                    .html(data)
                    .append("<div id=\"orderitemlist_close\"><button type=\"button\" id=\"orderitemlist-x\" class=\"btn_frmline\">닫기</button></div>");
            }
        );

        return false;
    });

    // 상품리스트 닫기
    $(".orderitemlist-x").on("click", function() {
        $("#orderitemlist").remove();
    });

    $("body").on("click", function() {
        $("#orderitemlist").remove();
    });
});
</script>
