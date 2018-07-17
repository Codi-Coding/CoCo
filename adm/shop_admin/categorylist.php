<?php
$sub_menu = '400200';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

// APMS - 2014.07.21
include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');

$flist = array();
$flist = apms_form(1,0);

$g5['title'] = '분류관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$where = " where ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

$sql_common = " from {$g5['g5_shop_category_table']} ";
if ($is_admin != 'super')
    $sql_common .= " $where ca_mb_id = '{$member['mb_id']}' ";
$sql_common .= $sql_search;


// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst)
{
    $sst  = "ca_id";
    $sod = "asc";
}
$sql_order = "order by $sst $sod";

// 출력할 레코드를 얻음
$sql  = " select *
             $sql_common
             $sql_order
             limit $from_record, $rows ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

// APMS - 2014.07.25
if(USE_G5_THEME) {
	$htxt = array('PC스킨폴더', 'PC스킨파일', '모바일스킨폴더', '모바일스킨파일');
} else { 
	$htxt = array('PC목록스킨', 'PC상품스킨', '모바일목록스킨', '모바일상품스킨');
	$itemskin = get_skin_dir('item', G5_SKIN_PATH.'/apms');
	$listskin = get_skin_dir('list', G5_SKIN_PATH.'/apms'); 
}
?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
    생성된 분류 수 <?php echo number_format($total_count); ?>개
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="ca_name"<?php echo get_selected($_GET['sfl'], "ca_name", true); ?>>분류명</option>
    <option value="ca_id"<?php echo get_selected($_GET['sfl'], "ca_id", true); ?>>분류코드</option>
    <option value="ca_mb_id"<?php echo get_selected($_GET['sfl'], "ca_mb_id", true); ?>>회원아이디</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>

<?php if ($is_admin == 'super') {?>
<div class="btn_add01 btn_add">
    <a href="./categoryform.php" id="cate_add">분류 추가</a>
    <a href="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.form.list.php" id="form_list">등록폼 관리</a>
</div>
<?php } ?>

<form name="fcategorylist" method="post" action="./categorylistupdate.php" autocomplete="off">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div id="sct" class="tbl_head02 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="2" id="sct_order">출력순서</th>
        <th scope="col" rowspan="2"><?php echo subject_sort_link("ca_id"); ?>분류코드</a></th>
        <th scope="col" id="sct_cate"><?php echo subject_sort_link("ca_name"); ?>분류명</a></th>
        <th scope="col" id="sct_amount">상품수</th>
        <th scope="col" id="sct_sell"<?php echo (USE_PARTNER) ? '' : ' rowspan="2"';?>><?php echo subject_sort_link("ca_use"); ?>판매가능</a></th>
		<th scope="col" id="sct_amount"<?php echo (USE_PARTNER) ? '' : ' rowspan="2"';?>>본인인증</th>
		<th scope="col" id="sct_adultcert"<?php echo (USE_PARTNER) ? '' : ' rowspan="2"';?>>성인인증</th>
		<th scope="col" id="sct_imgw">PC이미지 폭</th>
        <th scope="col" id="sct_imgh">PC이미지 높이</th>
        <th scope="col" id="sct_imgcol">PC 가로수</th>
		<th scope="col" id="sct_imgrow">PC 세로수</th>
        <th scope="col" id="sct_pcskin"><?php echo $htxt[0];?></th>
        <th scope="col" id="sct_pcskin"><?php echo $htxt[1];?></th>
        <th scope="col" id="sct_itemform"><?php echo subject_sort_link("pt_form"); ?> 상품등록폼</a></th>
		<th scope="col" rowspan="2">관리</th>
    </tr>
    <tr>
        <th scope="col" id="sct_admin"><?php echo subject_sort_link("ca_mb_id"); ?>관리회원아이디</a></th>
		<th scope="col" id="sct_sell"><?php echo subject_sort_link("ca_stock_qty"); ?>기본재고</a></th>
		<?php if(USE_PARTNER) { ?>
	        <th scope="col" id="sct_adultcert"><?php echo subject_sort_link("pt_use"); ?>파트너</a></th>
			<th scope="col"><?php echo subject_sort_link("pt_point"); ?>등록비</a></th>
		    <th scope="col"><?php echo subject_sort_link("pt_limit"); ?>등록제한</a></th>
		<?php } ?>
		<th scope="col" id="sct_imgw">모바일이미지 폭</th>
		<th scope="col" id="sct_imgh">모바일이미지 높이</th>
		<th scope="col" id="sct_mobileimg">모바일 가로수</th>
		<th scope="col" id="sct_mobileimg">모바일 세로수</th>
        <th scope="col" id="sct_mskin"><?php echo $htxt[2];?></th>
        <th scope="col" id="sct_mskin"><?php echo $htxt[3];?></th>
		<th scope="col" id="sct_itemlist">상품목록출력</th>
		<!-- APMS : 2014.07.20 -->

    </tr>
    </thead>
    <tbody>
    <?php
	for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $level = strlen($row['ca_id']) / 2 - 1;
        $p_ca_name = '';

        if ($level > 0) {
            $class = 'class="name_lbl"'; // 2단 이상 분류의 label 에 스타일 부여 - 지운아빠 2013-04-02
            // 상위단계의 분류명
            $p_ca_id = substr($row['ca_id'], 0, $level*2);
            $sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$p_ca_id' ";
            $temp = sql_fetch($sql);
            $p_ca_name = $temp['ca_name'].'의하위';
        } else {
            $class = '';
        }

        $s_level = '<div><label for="ca_name_'.$i.'" '.$class.'><span class="sound_only">'.$p_ca_name.''.($level+1).'단 분류</span></label></div>';
        $s_level_input_size = 25 - $level *2; // 하위 분류일 수록 입력칸 넓이 작아짐 - 지운아빠 2013-04-02

        if ($level+2 < 6) $s_add = '<a href="./categoryform.php?ca_id='.$row['ca_id'].'&amp;'.$qstr.'">추가</a> '; // 분류는 5단계까지만 가능
        else $s_add = '';
        $s_upd = '<a href="./categoryform.php?w=u&amp;ca_id='.$row['ca_id'].'&amp;'.$qstr.'"><span class="sound_only">'.get_text($row['ca_name']).' </span>수정</a> ';

        if ($is_admin == 'super')
            $s_del = '<a href="./categoryformupdate.php?w=d&amp;ca_id='.$row['ca_id'].'&amp;'.$qstr.'" onclick="return delete_confirm(this);"><span class="sound_only">'.get_text($row['ca_name']).' </span>삭제</a> ';

        // 해당 분류에 속한 상품의 수
        $sql1 = " select COUNT(*) as cnt from {$g5['g5_shop_item_table']}
                      where ca_id = '{$row['ca_id']}'
                      or ca_id2 = '{$row['ca_id']}'
                      or ca_id3 = '{$row['ca_id']}' ";
        $row1 = sql_fetch($sql1);

        // 스킨 Path
		if(USE_G5_THEME) {
			if(!$row['ca_skin_dir'])
				$g5_shop_skin_path = G5_SHOP_SKIN_PATH;
			else {
				if(preg_match('#^theme/(.+)$#', $row['ca_skin_dir'], $match))
					$g5_shop_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
				else
					$g5_shop_skin_path  = G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$row['ca_skin_dir'];
			}

			if(!$row['ca_mobile_skin_dir'])
				$g5_mshop_skin_path = G5_MSHOP_SKIN_PATH;
			else {
				if(preg_match('#^theme/(.+)$#', $row['ca_mobile_skin_dir'], $match))
					$g5_mshop_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
				else
					$g5_mshop_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$row['ca_mobile_skin_dir'];
			}
		}

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td headers="sct_order" class="td_code" rowspan="2">
            <label for="ca_order<?php echo $i; ?>" class="sound_only">출력순서</label>
            <input type="text" name="ca_order[<?php echo $i; ?>]" value='<?php echo $row['ca_order']; ?>' id="ca_order<?php echo $i; ?>" required class="required frm_input" size="3">
        </td>
        <td class="td_code" rowspan="2">
            <input type="hidden" name="ca_id[<?php echo $i; ?>]" value="<?php echo $row['ca_id']; ?>">
            <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row['ca_id']; ?>"><?php echo $row['ca_id']; ?></a>
        </td>
        <td headers="sct_cate" class="sct_name sct_name<?php echo $level; ?>"><?php echo $s_level; ?> <input type="text" name="ca_name[<?php echo $i; ?>]" value="<?php echo get_text($row['ca_name']); ?>" id="ca_name<?php echo $i; ?>" required class="frm_input full_input required"></td>
        <td headers="sct_amount" class="td_amount"><a href="./itemlist.php?sca=<?php echo $row['ca_id']; ?>"><?php echo $row1['cnt']; ?></a></td>
		<td headers="sct_admin" class="td_possible"<?php echo (USE_PARTNER) ? '' : ' rowspan="2"';?>>
            <input type="checkbox" name="ca_use[<?php echo $i; ?>]" value="1" id="ca_use<?php echo $i; ?>" <?php echo ($row['ca_use'] ? "checked" : ""); ?>>
            <label for="ca_use<?php echo $i; ?>">판매</label>
        </td>
		<td headers="sct_hpcert" class="td_possible"<?php echo (USE_PARTNER) ? '' : ' rowspan="2"';?>>
            <input type="checkbox" name="ca_cert_use[<?php echo $i; ?>]" value="1" id="ca_cert_use_yes<?php echo $i; ?>" <?php if($row['ca_cert_use']) echo 'checked="checked"'; ?>>
            <label for="ca_cert_use_yes<?php echo $i; ?>">사용</label>
        </td>
		<td headers="sct_adultcert" class="td_possible"<?php echo (USE_PARTNER) ? '' : ' rowspan="2"';?>>
            <input type="checkbox" name="ca_adult_use[<?php echo $i; ?>]" value="1" id="ca_adult_use_yes<?php echo $i; ?>" <?php if($row['ca_adult_use']) echo 'checked="checked"'; ?>>
            <label for="ca_adult_use_yes<?php echo $i; ?>">사용</label>
        </td>
		<td headers="sct_imgw" class="td_output">
            <label for="ca_out_width<?php echo $i; ?>" class="sound_only">출력이미지 폭</label>
            <input type="text" name="ca_img_width[<?php echo $i; ?>]" value="<?php echo get_text($row['ca_img_width']); ?>" id="ca_out_width<?php echo $i; ?>" required class="required frm_input" size="3" > <span class="sound_only">픽셀</span>
        </td>
        <td headers="sct_imgh" class="td_output">
            <label for="ca_img_height<?php echo $i; ?>" class="sound_only">출력이미지 높이</label>
            <input type="text" name="ca_img_height[<?php echo $i; ?>]" value="<?php echo $row['ca_img_height']; ?>" id="ca_img_height<?php echo $i; ?>" required class="required frm_input" size="3" > <span class="sound_only">픽셀</span>
        </td>
        <td headers="sct_imgcol" class="td_imgline">
            <label for="ca_lineimg_num<?php echo $i; ?>" class="sound_only">1줄당 이미지 수</label>
            <input type="text" name="ca_list_mod[<?php echo $i; ?>]" size="3" value="<?php echo $row['ca_list_mod']; ?>" id="ca_lineimg_num<?php echo $i; ?>" required class="required frm_input"> <span class="sound_only">개</span>
        </td>
        <td headers="sct_imgrow" class="td_imgline">
            <label for="ca_imgline_num<?php echo $i; ?>" class="sound_only">이미지 줄 수</label>
            <input type="text" name="ca_list_row[<?php echo $i; ?>]" value='<?php echo $row['ca_list_row']; ?>' id="ca_imgline_num<?php echo $i; ?>" required class="required frm_input" size="3"> <span class="sound_only">줄</span>
        </td>
		<td headers="sct_pcskin">
			<?php if(USE_G5_THEME) { ?>
				<label for="ca_skin_dir<?php echo $i; ?>" class="sound_only">PC스킨폴더</label>
				<?php echo get_skin_select('shop', 'ca_skin_dir'.$i, 'ca_skin_dir['.$i.']', $row['ca_skin_dir'], 'class="skin_dir"'); ?>
			<?php } else { ?>
				<label for="ca_skin<?php echo $i; ?>" class="sound_only">PC목록스킨</label>
		        <select id="ca_skin<?php echo $i; ?>" name="ca_skin[<?php echo $i; ?>]">
				<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($row['ca_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} ?>
	            </select>
			<?php } ?>
        </td>
        <td headers="sct_pcskin">
			<?php if(USE_G5_THEME) { ?>
				<label for="ca_skin<?php echo $i; ?>" class="sound_only">PC스킨파일</label>
				<select id="ca_skin<?php echo $i; ?>" name="ca_skin[<?php echo $i; ?>]">
					<?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", $g5_shop_skin_path, $row['ca_skin']); ?>
				</select>
			<?php } else { ?>
				<label for="ca_skin_dir<?php echo $i; ?>" class="sound_only">PC상품스킨</label>
				<select id="ca_skin_dir<?php echo $i; ?>" name="ca_skin_dir[<?php echo $i; ?>]">
				<?php for ($k=0; $k<count($itemskin); $k++) {
					echo "<option value=\"".$itemskin[$k]."\"".get_selected($row['ca_skin_dir'], $itemskin[$k]).">".$itemskin[$k]."</option>\n";
				} ?>
				</select>
			<?php } ?>
        </td>
		<td class="td_mng">
			<select name="pt_form[<?php echo $i; ?>]" id="pt_form[<?php echo $i; ?>]" style="width:80px;">
				<option value="">사용안함</option>
				<?php echo apms_form_option('select', $flist, $row['pt_form']);?>
			</select>
        </td>
		<td class="td_mng" rowspan="2">
            <?php echo $s_add; ?>
            <?php echo $s_vie; ?>
            <?php echo $s_upd; ?>
            <?php echo $s_del; ?>
        </td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td headers="sct_admin" class="td_mng">
            <?php if ($is_admin == 'super') {?>
            <label for="ca_mb_id<?php echo $i; ?>" class="sound_only">관리회원아이디</label>
            <input type="text" name="ca_mb_id[<?php echo $i; ?>]" value="<?php echo $row['ca_mb_id']; ?>" id="ca_mb_id<?php echo $i; ?>" class="frm_input full_input" size="15" maxlength="20">
            <?php } else { ?>
            <input type="hidden" name="ca_mb_id[<?php echo $i; ?>]" value="<?php echo $row['ca_mb_id']; ?>">
            <?php echo $row['ca_mb_id']; ?>
            <?php } ?>
        </td>
        <td headers="sct_sell" class="td_amount">
            <label for="ca_stock_qty<?php echo $i; ?>" class="sound_only">기본재고</label>
            <input type="text" name="ca_stock_qty[<?php echo $i; ?>]" value="<?php echo $row['ca_stock_qty']; ?>" id="ca_stock_qty<?php echo $i; ?>" required class="required frm_input" size="8" > <span class="sound_only">개</span>
        </td>
		<?php if(USE_PARTNER) { ?>
			<td headers="sct_sell" class="td_possible">
		        <input type="checkbox" name="pt_use[<?php echo $i; ?>]" value="1" id="pt_use<?php echo $i; ?>"<?php echo ($row['pt_use'] ? ' checked' : ''); ?>>
			    <label for="pt_use<?php echo $i; ?>">사용</label>
	        </td>
			<td headers="sct_sell" class="td_possible">
				<input type="text" name="pt_point[<?php echo $i; ?>]" value='<?php echo $row['pt_point']; ?>' id="pt_point<?php echo $i; ?>" class="frm_input sit_camt" size="8">
			</td>
			<td headers="sct_sell" class="td_possible">
				<input type="text" name="pt_limit[<?php echo $i; ?>]" value='<?php echo $row['pt_limit']; ?>' id="pt_limit<?php echo $i; ?>" class="frm_input sit_camt" size="6">
			</td>
		<?php } ?>
		<td headers="sct_imgw" class="td_output">
            <label for="ca_mobile_out_width<?php echo $i; ?>" class="sound_only">출력이미지 폭</label>
            <input type="text" name="ca_mobile_img_width[<?php echo $i; ?>]" value="<?php echo get_text($row['ca_mobile_img_width']); ?>" id="ca_mobile_out_width<?php echo $i; ?>" required class="required frm_input" size="3" > <span class="sound_only">픽셀</span>
        </td>
        <td headers="sct_imgh" class="td_output">
            <label for="ca_mobile_img_height<?php echo $i; ?>" class="sound_only">출력이미지 높이</label>
            <input type="text" name="ca_mobile_img_height[<?php echo $i; ?>]" value="<?php echo $row['ca_mobile_img_height']; ?>" id="ca_mobile_img_height<?php echo $i; ?>" required class="required frm_input" size="3" > <span class="sound_only">픽셀</span>
        </td>
		<td headers="sct_mobileimg" class="td_output">
            <label for="ca_mobileimg_num<?php echo $i; ?>" class="sound_only">모바일 1줄당 이미지 수</label>
            <input type="text" name="ca_mobile_list_mod[<?php echo $i; ?>]" size="3" value="<?php echo $row['ca_mobile_list_mod']; ?>" id="ca_mobileimg_num<?php echo $i; ?>" required class="required frm_input"> <span class="sound_only">개</span>
        </td>
        <td headers="sct_mobilerow" class="td_output">
            <label for="ca_mobileimg_row<?php echo $i; ?>" class="sound_only">모바일 이미지 줄 수</label>
            <input type="text" name="ca_mobile_list_row[<?php echo $i; ?>]" value='<?php echo $row['ca_mobile_list_row']; ?>' id="ca_mobileimg_row<?php echo $i; ?>" required class="required frm_input" size="3">
        </td>
		<!-- APMS : 2014.07.20 -->
		<td headers="sct_mskin">
			<?php if(USE_G5_THEME) { ?>
				<label for="ca_mobile_skin_dir<?php echo $i; ?>" class="sound_only">모바일스킨폴더</label>
				<?php echo get_mobile_skin_select('shop', 'ca_mobile_skin_dir'.$i, 'ca_mobile_skin_dir['.$i.']', $row['ca_mobile_skin_dir'], 'class="skin_dir"'); ?>
			<?php } else { ?>
				<label for="ca_mobile_skin<?php echo $i; ?>" class="sound_only">모바일목록스킨</label>
				<select id="ca_mobile_skin<?php echo $i; ?>" name="ca_mobile_skin[<?php echo $i; ?>]">
				<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($row['ca_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} ?>
				</select>
			<?php } ?>
        </td>
        <td headers="sct_mskin">
			<?php if(USE_G5_THEME) { ?>
				<label for="ca_mobile_skin<?php echo $i; ?>" class="sound_only">모바일스킨파일</label>
				<select id="ca_mobile_skin<?php echo $i; ?>" name="ca_mobile_skin[<?php echo $i; ?>]">
					<?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", $g5_mshop_skin_path, $row['ca_mobile_skin']); ?>
				</select>
			<?php } else { ?>
				<label for="ca_mobile_skin_dir<?php echo $i; ?>" class="sound_only">모바일상품스킨</label>
				<select id="ca_mobile_skin_dir<?php echo $i; ?>" name="ca_mobile_skin_dir[<?php echo $i; ?>]">
				<?php for ($k=0; $k<count($itemskin); $k++) {
					echo "<option value=\"".$itemskin[$k]."\"".get_selected($row['ca_mobile_skin_dir'], $itemskin[$k]).">".$itemskin[$k]."</option>\n";
				} ?>
				</select>
			<?php } ?>
        </td>
		<td class="td_mng">
			<label for="pt_item<?php echo $i; ?>" class="sound_only">상품목록출력</label>
			<select name="pt_item[<?php echo $i; ?>]" id="pt_item<?php echo $i; ?>" style="width:80px;">
				<option value="0"<?php echo get_selected('0', $row['pt_item']); ?>>출력안함</option>
				<option value="1"<?php echo get_selected('1', $row['pt_item']); ?>>모두출력</option>
				<option value="2"<?php echo get_selected('2', $row['pt_item']); ?>>PC만 출력</option>
				<option value="3"<?php echo get_selected('3', $row['pt_item']); ?>>모바일만 출력</option>
			</select>
		</td>
		<!-- // -->
	</tr>
    <?php }
    if ($i == 0) echo "<tr><td colspan=\"15\" class=\"empty_table\">자료가 한 건도 없습니다.</td></tr>\n"; // APMS : 2014.07.20
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <input type="submit" value="일괄수정">
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function() {
    $("select.skin_dir").on("change", function() {
        var type = "";
        var dir = $(this).val();
        if(!dir)
            return false;

        var id = $(this).attr("id");
        var $sel = $(this).siblings("select");
        var sval = $sel.find("option:selected").val();

        if(id.search("mobile") > -1)
            type = "mobile";

        $sel.load(
            "./ajax.skinfile.php",
            { dir : dir, type : type, sval: sval }
        );
    });
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
