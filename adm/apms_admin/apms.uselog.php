<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$list = array();

// 검색
if($qstr) 
	$qstr = '&amp;'.$qstr;

$sql_search = "";
if (isset($_REQUEST['ptid']) && $_REQUEST['ptid'])  {
	$ptid = get_search_string(trim($_REQUEST['ptid']));
    if ($ptid) {
		$sql_search .= " and a.pt_id like '%$ptid%' ";
        $qstr .= '&amp;ptid=' . urlencode($ptid);
	}
} else {
    $ptid = '';
}

if (isset($_REQUEST['mbid']) && $_REQUEST['mbid'])  {
	$mbid = get_search_string(trim($_REQUEST['mbid']));
    if ($mbid) {
		$sql_search .= " and a.mb_id like '%$mbid%' ";
        $qstr .= '&amp;mbid=' . urlencode($mbid);
	}
} else {
    $mbid = '';
}

if (isset($_REQUEST['mbname']) && $_REQUEST['mbname'])  {
	$mbname = get_search_string(trim($_REQUEST['mbname']));
    if ($mbname) {
		$sql_search .= " and b.mb_nick like '%$mbname%' ";
        $qstr .= '&amp;mbname=' . urlencode($mbname);
	}
} else {
    $mbid = '';
}

if (isset($_REQUEST['itid']) && $_REQUEST['itid'])  {
	$itid = get_search_string(trim($_REQUEST['itid']));
    if ($itid) {
		$sql_search .= " and a.it_id like '%$itid%' ";
        $qstr .= '&amp;itid=' . urlencode($itid);
	}
} else {
    $itid = '';
}

if (isset($_REQUEST['itname']) && $_REQUEST['itname'])  {
	$itname = get_search_string(trim($_REQUEST['itname']));
    if ($itname) {
		$sql_search .= " and a.it_name like '%$itname%' ";
        $qstr .= '&amp;itname=' . urlencode($itname);
	}
} else {
    $itname = '';
}

if (isset($_REQUEST['odid']) && $_REQUEST['odid'])  {
	$odid = str_replace("-", "", $odid);
	$odid = get_search_string(trim($_REQUEST['odid']));
    if ($odid) {
		$sql_search .= " and a.od_id like '%$odid%' ";
        $qstr .= '&amp;odid=' . urlencode($odid);
	}
} else {
    $odid = '';
}

// 조회시 이동
if($save) {
	goto_url('./apms.admin.php?ap='.$ap.'&amp;'.$qstr);
}

$rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];

$sql_common = " from {$g5['apms_use_log']} a left join {$g5['member_table']} b on ( a.mb_id = b.mb_id ) where (1) $sql_search ";

$orderby = ($sfl) ? 'a.id desc' : 'a.use_datetime desc';

$row = sql_fetch(" select count(*) as cnt {$sql_common} ");
$total_count = $row['cnt'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
$page = ($page > 1) ? $page : 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$start_rows = ($page - 1) * $rows; // 시작 열을 구함
$list_num = $total_count - ($page - 1) * $rows;
$result = sql_query(" select a.*, b.mb_nick, b.mb_email, b.mb_homepage $sql_common order by $orderby limit $start_rows, $rows ", false);
$pt_tmp_id = '';
$pt_tmp_name = '';
for ($i=0; $row=sql_fetch_array($result); $i++) { 

	$list[$i] = $row;
	$list[$i]['num'] = $list_num;
	$list[$i]['img'] = get_it_image($row['it_id'], 50, 50);

	if($row['pt_id']) {
		$list[$i]['pt_name'] = '탈퇴';
		if($pt_tmp_id == $row['pt_id']) {
			$list[$i]['pt_name'] = $pt_tmp_name;
		} else {
			$pmb = get_member($row['pt_id'], 'mb_nick, mb_email, mb_homepage');
			if($pmb['mb_nick']) {
				$list[$i]['pt_name'] = apms_sideview($row['pt_id'], get_text($pmb['mb_nick']), $pmb['mb_email'], $pmb['mb_homepage']);
			}
		}
		$pt_tmp_id = $row['pt_id'];
		$pt_tmp_name = $list[$i]['pt_name'];
	} else {
		$list[$i]['pt_name'] = '-';
	}

	if($row['mb_nick']) {
		$list[$i]['mb_name'] = apms_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);
	} else {
		$list[$i]['mb_name'] = '탈퇴';
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
$list_page = './apms.admin.php?ap='.$ap.'&amp;'.$qstr.'&amp;page=';
?>

<div class="local_ov01 local_ov">
	<a href="./apms.admin.php?ap=uselog" class="ov_listall">전체목록</a>
	총 <b><?php echo number_format($total_count); ?></b>건의 컨텐츠 이용내역이 있습니다.
</div>

<form name="frm_uselog" method="get">
<input type="hidden" name="ap" value="<?php echo $ap;?>">
<input type="hidden" name="save" value="1">
<div class="tbl_head01 tbl_wrap">
	<table>
    <caption>이용내역 조회</caption>
        <colgroup>
            <col class="grid_3">
            <col class="grid_4">
            <col class="grid_4">
            <col class="grid_4">
			<col class="grid_4">
            <col class="grid_4">
            <col class="grid_4">
			<col>
        </colgroup>
	<thead>
	<tr>
		<th scope="col">출력순서</th>
		<th scope="col">판매회원 아이디</th>
		<th scope="col">이용회원 아이디</th>
		<th scope="col">이용회원 닉네임</th>
		<th scope="col">상품코드</th>
		<th scope="col">상품명</th>
		<th scope="col">주문번호</th>
		<th scope="col">비고</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center">
			<select name="sst" id="sst">
				<option value="">등록일순</option>
				<option value="1"<?php echo get_selected($sst, '1');?>>이용일순</option>
			</select>
		</td>
		<td align="center">
			<input type="text" name="ptid" value="<?php echo $ptid; ?>" id="ptid" class="frm_input">
		</td>
		<td align="center">
			<input type="text" name="mbid" value="<?php echo $mbid; ?>" id="mbid" class="frm_input">
		</td>
		<td align="center">
			<input type="text" name="mbname" value="<?php echo $mbname; ?>" id="mbid" class="frm_input">
		</td>
		<td align="center">
			<input type="text" name="itid" value="<?php echo $itid; ?>" id="itid" class="frm_input">
		</td>
		<td align="center">
			<input type="text" name="itname" value="<?php echo $itname; ?>" id="itname" class="frm_input">
		</td>
		<td align="center">
			<input type="text" name="odid" value="<?php echo $odid; ?>" id="odid" class="frm_input">
		</td>
		<td align="center">
			&nbsp;
		</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="검색하기" class="btn_submit">
	<a class="btn_frmline" href="./apms.admin.php?ap=uselog">전체목록</a>
</div>

</form>

<br>

<div class="tbl_head01 tbl_wrap">
	<table>
    <caption>이용내역 목록</caption>
	<thead>
	<tr>
		<th scope="col">번호</th>
		<th scope="col">판매회원</th>
		<th scope="col">이용회원</th>
		<th scope="col">주문서</th>
		<th scope="col">주문번호</th>
		<th scope="col" style="width:60px;">이미지</th>
		<th scope="col">상품코드</th>
		<th scope="col">이용상품</th>
		<th scope="col">최종 이용파일</th>
		<th scope="col">최종 이용일시</th>
		<th scope="col">이용횟수</th>
		<th scope="col">등록일</th>
	</tr>
	</thead>
	<tbody>
	<?php for ($i=0; $i < count($list); $i++) { ?>
		<tr>
			<td align="center">
				<?php echo $list[$i]['num'];?>
			</td>
			<td align="center">
				<?php echo $list[$i]['pt_name'];?>
				<?php echo ($list[$i]['pt_id']) ? '<br>('.$list[$i]['pt_id'].')' : '';?>
			</td>
			<td align="center">
				<?php echo $list[$i]['mb_name'];?>
				<?php echo ($list[$i]['mb_id']) ? '<br>('.$list[$i]['mb_id'].')' : '';?>
			</td>
			<?php if($list[$i]['od_id']) { ?>
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
			<?php } else { ?>
				<td align="center">
					-
				</td>
				<td align="center">
					-
				</td>
			<?php } ?>
			<td align="center">
				<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $list[$i]['it_id']; ?>">
					<?php echo $list[$i]['img'];?>
				</a>
			</td>
			<td align="center">
				<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $list[$i]['it_id']; ?>">
					<?php echo $list[$i]['it_id'];?>
				</a>
			</td>
			<td>
				<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $list[$i]['it_id']; ?>">
					<?php echo $list[$i]['it_name'];?>
				</a>
			</td>
			<td>
				<?php echo ($list[$i]['use_file']) ? $list[$i]['use_file'] : '-'; ?>
			</td>
			<td align="center">
				<?php echo $list[$i]['use_datetime'];?>
			</td>
			<td align="center">
				<?php echo ($list[$i]['use_cnt']) ? number_format($list[$i]['use_cnt']) : '-';?>
			</td>
			<td align="center">
				<?php echo $list[$i]['use_regdate'];?>
			</td>
		</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="12" class="empty_table">등록된 이용내역이 없습니다.</td></tr>
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
