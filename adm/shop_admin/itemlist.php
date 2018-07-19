<?php
$sub_menu = '400300';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '상품관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

// 분류
$ca_list  = '<option value="">선택</option>'.PHP_EOL;
$sql = " select * from {$g5['g5_shop_category_table']} ";
if ($is_admin != 'super')
    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $len = strlen($row['ca_id']) / 2 - 1;
    $nbsp = '';
    for ($i=0; $i<$len; $i++) {
        $nbsp .= '&nbsp;&nbsp;&nbsp;';
    }

	if($row['as_line']) {
		$ca_list .= "<option value=\"\">".$nbsp."------------</option>\n";
	}

    $ca_list .= '<option value="'.$row['ca_id'].'">'.$nbsp.$row['ca_name'].'</option>'.PHP_EOL;
}

$where = " and ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " $where (a.ca_id like '$sca%' or a.ca_id2 like '$sca%' or a.ca_id3 like '$sca%') ";
}

if ($sfl == "")  $sfl = "it_name";

$sql_common = " from {$g5['g5_shop_item_table']} a ,
                     {$g5['g5_shop_category_table']} b
               where (a.ca_id = b.ca_id";
if ($is_admin != 'super')
    $sql_common .= " and b.ca_mb_id = '{$member['mb_id']}'";
$sql_common .= ") ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst) {
	$sst = "it_id";
    $sod = "desc";
}

if($sst == 'it_id') {
	$pth = "a.pt_num desc,";
	$ptt = "";
} else {
	$pth = "";
	$ptt = ", a.pt_num desc";
}

$sql_order = "order by $pth $sst $sod $ptt";

$sql  = " select *
           $sql_common
           $sql_order
           limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page;
$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

// APMS - 2014.07.25
include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');
$flist = array();
$flist = apms_form(1,0);

?>

<script src="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.admin.js"></script>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
    등록된 상품 <?php echo $total_count; ?>건
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

<label for="sca" class="sound_only">분류선택</label>
<select name="sca" id="sca">
    <option value="">전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name, as_line from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = '';
        for ($i=0; $i<$len; $i++) $nbsp .= '&nbsp;&nbsp;&nbsp;';

		if($row1['as_line']) {
			echo "<option value=\"\">".$nbsp."------------</option>\n";
		}

		echo '<option value="'.$row1['ca_id'].'" '.get_selected($sca, $row1['ca_id']).'>'.$nbsp.$row1['ca_name'].'</option>'.PHP_EOL;
    }
    ?>
</select>

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="it_name" <?php echo get_selected($sfl, 'it_name'); ?>>상품명</option>
    <option value="it_id" <?php echo get_selected($sfl, 'it_id'); ?>>상품코드</option>
    <option value="it_maker" <?php echo get_selected($sfl, 'it_maker'); ?>>제조사</option>
    <option value="it_origin" <?php echo get_selected($sfl, 'it_origin'); ?>>원산지</option>
    <option value="it_sell_email" <?php echo get_selected($sfl, 'it_sell_email'); ?>>판매자 e-mail</option>
	<!-- APMS - 2014.07.20 -->
	    <option value="pt_id" <?php echo get_selected($sfl, 'pt_id'); ?>>파트너 아이디</option>
	<!-- // -->
</select>

<label for="stx" class="sound_only">검색어</label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>

<div class="btn_add01 btn_add">
    <a href="./itemform.php">신규등록</a>
    <a href="./itemexcel.php" onclick="return excelform(this.href);" target="_blank">일괄등록</a>
</div>

<form name="fitemlistupdate" method="post" action="./itemlistupdate.php" onsubmit="return fitemlist_submit(this);" autocomplete="off">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head02 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="3">
            <label for="chkall" class="sound_only">상품 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('it_id', 'sca='.$sca); ?>상품코드</a></th>
        <th scope="col" colspan="8">분류</th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('pt_main', 'sca='.$sca); ?>메인</a></th>
		<th scope="col" rowspan="3"><?php echo subject_sort_link('it_order', 'sca='.$sca); ?>순서</a></th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('it_use', 'sca='.$sca, 1); ?>판매</a></th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('it_soldout', 'sca='.$sca, 1); ?>품절</a></th>
        <th scope="col" rowspan="3"><?php echo subject_sort_link('it_hit', 'sca='.$sca, 1); ?>조회</a></th>
        <th scope="col" rowspan="3">관리</th>
    </tr>
    <tr>
        <th scope="col" rowspan="2" id="th_img">이미지</th>
        <th scope="col" rowspan="2" id="th_pc_title"><?php echo subject_sort_link('it_name', 'sca='.$sca); ?>상품명</a></th>
		<th scope="col" id="th_amt"><?php echo subject_sort_link('it_price', 'sca='.$sca); ?>판매가격</a></th>
        <th scope="col" id="th_camt"><?php echo subject_sort_link('it_cust_price', 'sca='.$sca); ?>시중가격</a></th>
		<!-- APMS - 2014.07.20 -->
			<th scope="col" id="th_fee"><?php echo subject_sort_link('pt_commision', 'sca='.$sca); ?>수수료(%)</a></th>
			<th scope="col" id="th_start"><?php echo subject_sort_link('pt_reserve', 'sca='.$sca); ?>예약일</a></th>
	        <th scope="col" id="th_type">상품종류</a></th>
		<!-- // -->
    </tr>
    <tr>
		<th scope="col" id="th_pt"><?php echo subject_sort_link('it_point', 'sca='.$sca); ?>포인트</a></th>
        <th scope="col" id="th_qty"><?php echo subject_sort_link('it_stock_qty', 'sca='.$sca); ?>재고</a></th>
		<!-- APMS - 2014.07.20 -->
			<th scope="col" id="th_icnt"><?php echo subject_sort_link('pt_incentive', 'sca='.$sca); ?>인센티브(%)</a></th>
			<th scope="col" id="th_end"><?php echo subject_sort_link('pt_end', 'sca='.$sca); ?>종료일</a></th>
	        <th scope="col" id="th_cmt">댓글사용</th>
		<!-- // -->
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
        $bg = 'bg'.($i%2);

        $it_point = $row['it_point'];
        if($row['it_point_type'])
            $it_point .= '%';
    ?>
    <tr class="<?php echo $bg; ?>">
        <td rowspan="3" class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
        </td>
		<!-- APMS - 2014.07.20 -->
		<td rowspan="3" class="td_num" style="white-space:nowrap">
            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
			<?php if($row['pt_it']) { ?>
				<div style="font-size:11px; letter-spacing:-1px;"><?php echo apms_pt_it($row['pt_it'],1);?></div>
			<?php } ?>
			<b><?php echo $row['it_id']; ?></b>
			<?php if($row['pt_id']) { ?>
				<div style="font-size:11px; letter-spacing:-1px;"><?php echo $row['pt_id'];?></div>
			<?php } ?>
        </td>
		<!-- // -->
		<td colspan="8">
            <label for="ca_id_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?> 기본분류</label>
            <select name="ca_id[<?php echo $i; ?>]" id="ca_id_<?php echo $i; ?>" required>
                <?php echo conv_selected_option($ca_list, $row['ca_id']); ?>
            </select>
            <label for="ca_id2_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?> 2차분류</label>
            <select name="ca_id2[<?php echo $i; ?>]" id="ca_id2_<?php echo $i; ?>">
                <?php echo conv_selected_option($ca_list, $row['ca_id2']); ?>
            </select>
            <label for="ca_id3_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?> 3차분류</label>
            <select name="ca_id3[<?php echo $i; ?>]" id="ca_id3_<?php echo $i; ?>">
                <?php echo conv_selected_option($ca_list, $row['ca_id3']); ?>
            </select>
        </td>
        <td rowspan="3" class="td_chk">
            <label for="main_<?php echo $i; ?>" class="sound_only">메인상품</label>
            <input type="checkbox" name="pt_main[<?php echo $i; ?>]" <?php echo ($row['pt_main'] ? 'checked' : ''); ?> value="1" id="main_<?php echo $i; ?>">
        </td>
		<td rowspan="3" class="td_mngsmall">
            <label for="order_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_order[<?php echo $i; ?>]" value="<?php echo $row['it_order']; ?>" id="order_<?php echo $i; ?>" class="frm_input" size="3">
        </td>
        <td rowspan="3" class="td_chk">
            <label for="use_<?php echo $i; ?>" class="sound_only">판매여부</label>
            <input type="checkbox" name="it_use[<?php echo $i; ?>]" <?php echo ($row['it_use'] ? 'checked' : ''); ?> value="1" id="use_<?php echo $i; ?>">
        </td>
        <td rowspan="3" class="td_chk">
            <label for="soldout_<?php echo $i; ?>" class="sound_only">품절</label>
            <input type="checkbox" name="it_soldout[<?php echo $i; ?>]" <?php echo ($row['it_soldout'] ? 'checked' : ''); ?> value="1" id="soldout_<?php echo $i; ?>">
        </td>
        <td rowspan="3" class="td_num"><?php echo $row['it_hit']; ?></td>
        <td rowspan="3" class="td_mng">
            <a href="./itemform.php?w=u&amp;it_id=<?php echo $row['it_id']; ?>&amp;fn=<?php echo $row['pt_form'];?>&amp;ca_id=<?php echo $row['ca_id']; ?>&amp;<?php echo $qstr; ?>"><span class="sound_only"><?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?> </span>수정</a>
            <a href="./itemcopy.php?it_id=<?php echo $row['it_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>" class="itemcopy" target="_blank"><span class="sound_only"><?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?> </span>복사</a>
            <a href="<?php echo $href; ?>"><span class="sound_only"><?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?> </span>보기</a>
        </td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td rowspan="2" class="td_img"><a href="<?php echo $href; ?>"><?php echo get_it_image($row['it_id'], 50, 50); ?></a></td>
        <td headers="th_pc_title" rowspan="2" class="td_input">
			<?php echo help(apms_form_option('name', $flist, $row['pt_form']));?>
            <label for="name_<?php echo $i; ?>" class="sound_only">상품명</label>
            <input type="text" name="it_name[<?php echo $i; ?>]" value="<?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?>" id="name_<?php echo $i; ?>" required class="frm_input required" size="30">
        </td>
        <td headers="th_amt" class="td_numbig td_input">
            <label for="price_<?php echo $i; ?>" class="sound_only">판매가격</label>
            <input type="text" name="it_price[<?php echo $i; ?>]" value="<?php echo $row['it_price']; ?>" id="price_<?php echo $i; ?>" class="frm_input sit_amt" size="7">
        </td>
        <td headers="th_camt" class="td_numbig td_input">
            <label for="cust_price_<?php echo $i; ?>" class="sound_only">시중가격</label>
            <input type="text" name="it_cust_price[<?php echo $i; ?>]" value="<?php echo $row['it_cust_price']; ?>" id="cust_price_<?php echo $i; ?>" class="frm_input sit_camt" size="7">
        </td>
		<td headers="th_amt" class="td_numbig td_input">
			<label for="commission_<?php echo $i; ?>" class="sound_only">수수료</label>
			<input type="text" name="pt_commission[<?php echo $i; ?>]" value="<?php echo $row['pt_commission']; ?>" id="commission_<?php echo $i; ?>" class="frm_input sit_amt" size="3">
		</td>
		<td headers="th_amt" class="td_num">
			<?php echo ($default['pt_reserve_cache'] > 0 && $row['pt_reserve_use'] && $row['pt_reserve']) ? date("Y.m.d", $row['pt_reserve']) : '-'; ?>
		</td>
		<td headers="th_amt" class="td_num">
			<?php if(!$row['pt_it']) $row['pt_it'] = 1; ?>
			<select name="pt_it[<?php echo $i; ?>]" id="pt_it_[<?php echo $i; ?>]" style="width:74px;">
				<option value="">종류선택</option>
				<?php echo apms_pt_it($row['pt_it']); ?>
			</select>
		</td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td headers="th_pt" class="td_numbig td_input"><?php echo $it_point; ?></td>
        <td headers="th_qty" class="td_numbig td_input">
            <label for="stock_qty_<?php echo $i; ?>" class="sound_only">재고</label>
            <input type="text" name="it_stock_qty[<?php echo $i; ?>]" value="<?php echo $row['it_stock_qty']; ?>" id="stock_qty_<?php echo $i; ?>" class="frm_input sit_qty" size="7">
        </td>
		<!-- APMS - 2014.07.14 -->
			<td headers="th_amt" class="td_numbig td_input">
				<label for="incentive_<?php echo $i; ?>" class="sound_only">인센티브</label>
				<input type="text" name="pt_incentive[<?php echo $i; ?>]" value="<?php echo $row['pt_incentive']; ?>" id="incentive_<?php echo $i; ?>" class="frm_input sit_camt" size="3">
			</td>
			<td headers="th_amt" class="td_num">
				<?php echo ($default['pt_reserve_cache'] > 0 && $row['pt_end']) ? date("Y.m.d", $row['pt_end']) : '-'; ?>
			</td>
			<td headers="th_amt" class="td_num">
				<select name="pt_comment_use[<?php echo $i; ?>]" id="pt_comment_use_<?php echo $i; ?>" style="width:74px;">
					<option value="0"<?php echo get_selected('0', $row['pt_comment_use']); ?>>사용안함</option>
					<option value="1"<?php echo get_selected('1', $row['pt_comment_use']); ?>>모두등록</option>
					<option value="2"<?php echo get_selected('2', $row['pt_comment_use']); ?>>나만등록</option>
				</select>
			</td>
		<!-- // -->
    </tr>
    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="16" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
    <?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
    <?php } ?>
</div>
<!-- <div class="btn_confirm01 btn_confirm">
    <input type="submit" value="일괄수정" class="btn_submit" accesskey="s">
</div> -->
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fitemlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function() {
    $(".itemcopy").click(function() {
        var href = $(this).attr("href");
        window.open(href, "copywin", "left=100, top=100, width=300, height=200, scrollbars=0");
        return false;
    });
});

function excelform(url)
{
    var opt = "width=600,height=450,left=10,top=10";
    window.open(url, "win_excel", opt);
    return false;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
