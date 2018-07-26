<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 컨텐츠상품
$ct_it = implode(",", $g5['apms_automation']);

// 업데이트하기
if($save) {

    for ($i=0; $i<count($_POST['od_id']); $i++) {

		if(!$_POST['od_id'][$i] || !$_POST['it_id'][$i] || !$_POST['pt_id'][$i]) continue;

		if($_POST['pt_send'][$i] && $_POST['pt_send_num'][$i]) {
			$ct_status = '배송';
		} else if($_POST['ct_status'][$i] == '입금' || $_POST['ct_status'][$i] == '준비' || $_POST['ct_status'][$i] == '배송') {
			$ct_status = $_POST['ct_status'][$i];
		} else {
			continue;
		}

        $sql = "update {$g5['g5_shop_cart_table']}
                   set pt_send        = '".addslashes($_POST['pt_send'][$i])."',
                       pt_send_num    = '".addslashes($_POST['pt_send_num'][$i])."',
                       ct_status	  = '{$ct_status}'
                 where od_id = '{$_POST['od_id'][$i]}' and it_id = '{$_POST['it_id'][$i]}' and pt_id = '{$_POST['pt_id'][$i]}' and find_in_set(pt_it, '{$ct_it}')=0 and ct_select = '1' ";
        sql_query($sql);
    }
	
	//이동하기
	if($done == "1") { //미배송건은 페이지 없음
		goto_url('./apms.admin.php?ap='.$ap.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;done='.$done.'&amp;save_stx='.$stx.'&amp;stx='.$stx);
	} else {
		goto_url('./apms.admin.php?ap='.$ap.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;done='.$done.'&amp;save_stx='.$stx.'&amp;stx='.$stx.'&amp;page='.$page);
	}
}

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$list = array();

$fr_date = ($fr_date) ? $fr_date : date("Ymd", G5_SERVER_TIME - 15*86400); //보름전
$to_date = ($to_date) ? $to_date : date("Ymd", G5_SERVER_TIME); //오늘

$fr_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
$to_day = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);

// 상태
if(isset($done) && $done) { 
	$ct_status = ($done == "2") ? '배송' : '입금,준비'; 
} else { 
	$ct_status = '입금,준비,배송'; 
} 

// 검색
$sql_search1 = "";
$sql_search2 = "";
if ($stx != "") {
	$stx = str_replace("-", "", $stx);
	$sql_search1 .= " and od_id like '%$stx%' ";
	$sql_search2 .= " and a.od_id like '%$stx%' ";
	if ($save_stx != $stx)
        $page = 1;
}

// group by에 파트너 아이디로도 묶어 줌. 즉, 주문번호 + 파트너아이디로 group by & 파트너 있는 상품만 체크
$sql_common1 = " from {$g5['g5_shop_cart_table']} where find_in_set(ct_status, '{$ct_status}') and find_in_set(pt_it, '{$ct_it}')=0 and pt_id <> '' and ct_select = '1' $sql_search1 and SUBSTRING(ct_select_time,1,10) between '$fr_day' and '$to_day' group by od_id, pt_id ";

$cnt = sql_query(" select count(*) as cnt $sql_common1 ");
$total_cnt = @sql_num_rows($cnt);

sql_free_result($cnt);

$sql_common2 = " from {$g5['g5_shop_cart_table']} a left join {$g5['member_table']} b on ( a.pt_id = b.mb_id ) where find_in_set(a.ct_status, '{$ct_status}') and find_in_set(a.pt_it, '{$ct_it}')=0 and a.pt_id <> '' and a.ct_select = '1' $sql_search2 and SUBSTRING(a.ct_select_time,1,10) between '$fr_day' and '$to_day' group by a.od_id, a.pt_id ";

$rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];

$total_count = $total_cnt;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
$page = ($page > 1) ? $page : 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$start_rows = ($page - 1) * $rows; // 시작 열을 구함
$list_num = $total_count - ($page - 1) * $rows;

$result = sql_query(" select a.od_id, a.pt_id, b.mb_nick, b.mb_email, b.mb_homepage $sql_common2 order by a.od_id desc limit $start_rows, $rows ", false);
for ($i=0; $row=sql_fetch_array($result); $i++) { 

	// 주문정보
	$list[$i] = sql_fetch(" select * from {$g5['g5_shop_order_table']} where od_id = '{$row['od_id']}' ");
	$list[$i]['num'] = $list_num;
	$list[$i]['uid'] = md5($row['od_id'].$list[$i]['od_time'].$list[$i]['od_ip']);

	// 파트너정보
	$list[$i]['od_id'] = $row['od_id'];
	$list[$i]['pt_id'] = $row['pt_id'];

	if($row['pt_id']) {
		$list[$i]['pt_name'] = '탈퇴';
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

	// 주문자
	$list[$i]['od_name'] = apms_sideview($list[$i]['mb_id'], get_text($list[$i]['od_name']), $list[$i]['od_email'], '');

	// 주문상품 - 파트너 아이디로도 체크
	$sql1 = " select a.od_id, a.pt_id, a.ct_status, a.it_id, a.it_name, a.ct_send_cost, a.it_sc_type, a.pt_send, a.pt_send_num, b.pt_msg1, b.pt_msg2, b.pt_msg3
			  from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
			  where a.od_id = '{$row['od_id']}' and a.pt_id = '{$row['pt_id']}' and find_in_set(a.ct_status, '{$ct_status}') and find_in_set(a.pt_it, '{$ct_it}')=0  and a.ct_select = '1'
			  group by a.it_id
			  order by a.ct_id ";

	$result1 = sql_query($sql1);
	for($j=0; $row1=sql_fetch_array($result1); $j++) {

		$list[$i]['it'][$j] = $row1;

		// 상품명
		$list[$i]['it'][$j]['name'] = stripslashes($row1['it_name']);

		// 상품주소
		$list[$i]['it'][$j]['href'] = G5_SHOP_URL.'/item.php?it_id='.$list[$i]['it'][$j]['it_id'];

		// 상품옵션
		$list[$i]['it'][$j]['option'] = print_item_options($row1['it_id'], $row['od_id'], $row1['pt_msg1'], $row1['pt_msg2'], $row1['pt_msg3'], $ct_status, 1);

		// 합계금액 계산
		$sql2 = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
					SUM(ct_qty) as qty
					from {$g5['g5_shop_cart_table']}
					where it_id = '{$row1['it_id']}'
					and od_id = '{$row['od_id']}' ";
		$sum = sql_fetch($sql2);

		// 배송비
		switch($row1['ct_send_cost']) {
			case 1:
				$ct_send_cost = '착불';
				break;
			case 2:
				$ct_send_cost = '무료';
				break;
			default:
				$ct_send_cost = '선불';
				break;
		}

		// 조건부무료
		if($row1['it_sc_type'] == 2) {
			$sendcost = get_item_sendcost($row1['it_id'], $sum['price'], $sum['qty'], $row['od_id']);

			if($sendcost == 0)
				$ct_send_cost = '무료';
		}

		$list[$i]['it'][$j]['sendcost'] = $ct_send_cost;

		$cost = sql_fetch("select sc_price from {$g5['apms_sendcost']} where it_id = '{$row1['it_id']}'	and od_id = '{$row['od_id']}' and pt_id = '{$row['pt_id']}' ", false);

		$list[$i]['it'][$j]['sc_price'] = $cost['sc_price'];

		// 문의전화
		$list[$i]['it'][$j]['tel'] = get_delivery_inquiry($row1['pt_send'], $row1['pt_send_num']);
	}

	// 셀합치기
	$list[$i]['rowspan'] = ($j > 1) ? $j : 0;
	$list_num--;
}

//print_r2($list);

// 페이징
$list_page = './apms.admin.php?ap='.$ap.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;done='.$done.'&amp;save_stx='.$stx.'&amp;stx='.$stx.'&amp;page=';
?>

<style>
	.od-tr td { line-height:20px !important; }
	.od-send { width:140px; }
	.it-info ul { margin:0; padding:0; padding-left:20px; }
	.pg_wrap { padding-top:0px; padding-left:20px; }
</style>

<div class="local_ov01 local_ov">
	배송가능한 상품의 주문건 중 입금/준비/배송상태의 주문만 출력됩니다. 미배송건은 입금/준비상태, 배송완료는 배송중인 주문건을 말합니다.
</div>

<form name="frm_delivery" class="local_sch02 local_sch" method="get">
<input type="hidden" name="ap" value="<?php echo $ap;?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">
<div class="sch_last">
    <strong>주문조회</strong>
	<select name="done" id="done">
		<option value="">전체내역</option>
		<option value="1">미배송건</option>
		<option value="2">배송완료</option>
	</select>
	<input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" required class="frm_input" size="10" maxlength="10" readonly>
	<input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" required class="frm_input" size="10" maxlength="10" readonly>
	<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="frm_input" autocomplete="off" placeholder="주문번호 검색">
	<input type="submit" value="확인" class="btn_submit">
</div>
</form>
<script>
function sel_company(id, com) {
	$("#" + id).val(com);
}
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

document.getElementById("done").value = "<?php echo $done; ?>";
</script>

<form class="form" role="form" name="fdeliveryupdate" method="post" autocomplete="off">
<input type="hidden" name="ap" value="<?php echo $ap;?>">
<input type="hidden" name="save" value="1">
<input type="hidden" name="fr_date" value="<?php echo $fr_date; ?>">
<input type="hidden" name="to_date" value="<?php echo $to_date; ?>">
<input type="hidden" name="done" value="<?php echo $done; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
	<ul style="background: rgb(249, 249, 249); padding: 10px 30px; border: 1px solid rgb(242, 242, 242); line-height: 20px; margin-bottom: 10px;">
		<li>총 <b><?php echo number_format($total_count); ?></b>건의 
			<?php
				switch($done) {
					case '1'	: echo '미배송'; break;
					case '2'	: echo '배송완료된'; break;
				}
			?>
			주문이 있습니다.
		</li>
	</ul>
	<table>
    <caption>주문 내역 목록</caption>
	<thead>
	<tr>
		<th scope="col">번호</th>
		<th scope="col">파트너</th>
		<th scope="col">주문서</th>
		<th scope="col">주문번호</th>
		<th scope="col">주문자(연락처)</th>
		<th scope="col">배송정보(이름/연락처/주소/메모)</th>
		<th scope="col" style="width:60px;">이미지</th>
		<th scope="col">주문상품</th>
		<th scope="col">상품코드</th>
		<th scope="col">배송비</th>
		<th scope="col" style="width:160px;">배송회사</th>
		<th scope="col" style="width:160px;">운송장번호</th>
		<th scope="col">상태</th>
	</tr>
	</thead>
	<tbody>
	<?php 
		$z = 0;
		for ($i=0; $i < count($list); $i++) { 

			// 쉘합치기
			$rowspan = ($list[$i]['rowspan']) ? ' rowspan="'.$list[$i]['rowspan'].'"' : '';

			for ($j=0; $j < count($list[$i]['it']); $j++) {
	?>
			<tr class="od-tr">
               <?php if($j == 0) { ?>
					<td align="center"<?php echo $rowspan;?>>
						<?php echo $list[$i]['num'];?>
					</td>
					<td align="center"<?php echo $rowspan;?>>
						<b><?php echo $list[$i]['pt_name'];?></b>
						<?php echo ($list[$i]['pt_id']) ? '<br>('.$list[$i]['pt_id'].')' : '';?>
					</td>
					<td align="center"<?php echo $rowspan;?>>
						<a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $list[$i]['od_id']; ?>">
							<i class="fa fa-file-text-o fa-lg"></i>
						</a>
					</td>
					<td align="center"<?php echo $rowspan;?>>
						<a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $list[$i]['od_id']; ?>&amp;uid=<?php echo $list[$i]['uid']; ?>" class="orderitem">
							<?php echo $list[$i]['od_num'];?>
						</a>
					</td>
					<td align="center"<?php echo $rowspan;?>>
						<b><?php echo $list[$i]['od_name'];?></b>
						<br>
						(<?php echo implode( " / ", array($list[$i]['od_tel'], $list[$i]['od_hp']));?>)
					</td>
					<td<?php echo $rowspan;?>>
						<strong><?php echo $list[$i]['od_b_name'];?></strong> (<?php echo implode( " / ", array($list[$i]['od_b_tel'], $list[$i]['od_b_hp']));?>)
						<br>
                        (<?php echo $list[$i]['od_b_zip1'].$list[$i]['od_b_zip2']; ?>)
                        <?php echo get_text($list[$i]['od_b_addr1']); ?>
						<?php echo get_text($list[$i]['od_b_addr2']); ?>
                        <?php echo get_text($list[$i]['od_b_addr3']); ?>
		                <?php if ($default['de_hope_date_use'] && $list[$i]['od_hope_date']) { ?>
							<br>
							희망배송일 : <?php echo $list[$i]['od_hope_date']; ?>(<?php echo get_yoil($list[$i]['od_hope_date']); ?>)
						<?php } ?>
						<?php if ($list[$i]['od_memo']) { ?>
							<br>
							<span style="color:#0099ff;">전달메시지 : <?php echo get_text($list[$i]['od_memo'], 1);?></span>
						<?php } ?>
					</td>
				<?php } ?>
				<td align="center">
					<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $list[$i]['it'][$j]['it_id']; ?>">
						<?php echo get_it_image($list[$i]['it'][$j]['it_id'], 50, 50); ?>
					</a>
				</td>
				<td class="it-info">
					<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $list[$i]['it'][$j]['it_id']; ?>">
						<b><?php echo $list[$i]['it'][$j]['name'];?></b>
					</a>
					<?php echo $list[$i]['it'][$j]['option'];?>
				</td>
				<td align="center">
					<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $list[$i]['it'][$j]['it_id']; ?>">
						<?php echo $list[$i]['it'][$j]['it_id'];?>
					</a>
				</td>
				<td align="center">
					<?php echo $list[$i]['it'][$j]['sendcost'];?>
					<?php if($list[$i]['it'][$j]['sc_price']) { ?>
						<br>
						(<?php echo number_format($list[$i]['it'][$j]['sc_price']);?>원)
					<?php } ?>
				</td>
				<td align="center">
					<input type="hidden" name="od_id[<?php echo $z; ?>]" value="<?php echo $list[$i]['it'][$j]['od_id']; ?>">
			        <input type="hidden" name="pt_id[<?php echo $z; ?>]" value="<?php echo $list[$i]['it'][$j]['pt_id']; ?>">
					<input type="hidden" name="it_id[<?php echo $z; ?>]" value="<?php echo $list[$i]['it'][$j]['it_id']; ?>">
					<select class="od-send" onchange="sel_company('com_<?php echo $z;?>', this.value)">
						<?php echo get_delivery_company($list[$i]['it'][$j]['pt_send'], '배송업체 선택');?>
					</select>
					<div style="height:6px;"></div>
					<input type="text" id="com_<?php echo $z;?>" name="pt_send[<?php echo $z; ?>]" value="<?php echo $list[$i]['it'][$j]['pt_send']; ?>" class="frm_input od-send">
				</td>
				<td align="center">
					<?php if($list[$i]['it'][$j]['tel']) { ?>
						<?php echo str_replace("문의전화: ", "", $list[$i]['it'][$j]['tel']);?>
						<div style="height:6px;"></div>
					<?php } ?>
					<input type="text" name="pt_send_num[<?php echo $z; ?>]" value="<?php echo $list[$i]['it'][$j]['pt_send_num']; ?>" class="frm_input od-send">
				</td>
				<td align="center">
					<select name="ct_status[<?php echo $z; ?>]">
						<option value="입금"<?php echo get_selected($list[$i]['it'][$j]['ct_status'],'입금');?>>입금</option>
						<option value="준비"<?php echo get_selected($list[$i]['it'][$j]['ct_status'],'준비');?>>준비</option>
						<option value="배송"<?php echo get_selected($list[$i]['it'][$j]['ct_status'],'배송');?>>배송</option>
					</select>
				</td>
			</tr>
		<?php $z++; } ?>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="13" class="empty_table">등록된 주문내역이 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm" style="float:right">
	<input type="submit" value="배송일괄처리" class="btn_submit">
</div>

<div style="float:left">
	<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $list_page); ?>
</div>
<div style="clear:both;"></div>
</form>
 
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
