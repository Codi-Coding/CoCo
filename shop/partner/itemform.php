<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_EDITOR_LIB);
include_once(G5_LIB_PATH.'/iteminfo.lib.php');
include_once(G5_LIB_PATH.'/apms.partner.lib.php');
$upload_max_filesize = number_format($default['pt_upload_size']) . ' 바이트';

//분류권한
$is_cauth = apms_is_cauth();

$flist = array();
$flist = apms_form($is_cauth, $is_partner);

if ($w == "") {

	$html_title = " 등록";

    // 옵션은 쿠키에 저장된 값을 보여줌. 다음 입력을 위한것임
    //$it[ca_id] = _COOKIE[ck_ca_id];
    $it['ca_id'] = get_cookie("ck_ca_id");
    $it['ca_id2'] = get_cookie("ck_ca_id2");
    $it['ca_id3'] = get_cookie("ck_ca_id3");
    if (!$it['ca_id']) {
		$pt_where = ($is_cauth) ? "" : "where pt_use = '1'";
		$sql = " select ca_id from {$g5['g5_shop_category_table']} $pt_where order by ca_order, ca_id limit 1 ";
        $row = sql_fetch($sql);
        if (!$row['ca_id'])
            alert("등록된 분류가 없습니다. 관리자에게 문의해 주십시오.", "./index.php");

		$it['ca_id'] = $row['ca_id'];
    }

	$it['it_maker']  = stripslashes(get_cookie("ck_maker"));
    $it['it_origin'] = stripslashes(get_cookie("ck_origin"));

} else if ($w == "u") {

	$html_title = " 수정";

    $sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);

	if(!$it)
		alert('상품정보가 존재하지 않습니다.'); 

    if (!$is_auth) {
		if($it['pt_id'] != $member['mb_id'])
            alert("\'{$member['mb_id']}\' 님께서 수정 할 권한이 없는 상품입니다.");
	}

	// 첫번째 분류
	$ca_id = $it['ca_id'];

    $sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' ";
    $ca = sql_fetch($sql);

	$ss_name = 'ss_item_'.$it_id;
	if (!get_session($ss_name)) {
		set_session($ss_name, TRUE);
	}

} else {
   goto_url("./");
}

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;ap=list&amp;page='.$page;

$frm_submit = '<div class="btn_confirm01 btn_confirm"><input type="submit" value="확인" class="btn_submit" accesskey="s"> <a href="./?'.$qstr.'" class="btn_frmline">목록</a>';
if($it_id) $frm_submit .= PHP_EOL.'<a href="'.G5_SHOP_URL.'/item.php?it_id='.$it_id.'" target="blank" class="btn_frmline">보기</a> <a href="./?ap=item" class="btn_frmline">신규</a>';
$frm_submit .= '</div>';

include_once($skin_path.'/itemform.skin.php');

// 입력폼 선택
$flist_cnt = count($flist);

// 등록폼이 1개일 때
if($flist_cnt == 1 && $w == "") {
	$fn = $flist[0]['pi_id'];
	if($it_id) $cfn = 1;
}

if($w == "" && !$fn) {

?>
	<style>
		.new_win { line-height:1.4; }
		.new_win h1 { line-height:60px; margin:0px; font-weight:bold; }
		.itemform { margin:0 auto; max-width:300px; }
		.itemform ul { list-style:none; margin:0; padding:15px 15px 30px; }
		.itemform ul li { line-height:32px; }
	</style>
	<div class="new_win">
		<h1><b>상품 등록폼 선택</b></h1>
		<form name="fitemform" onsubmit="return fitemformcheck(this)">
		<input type="hidden" name="ap" value="item">
		<input type="hidden" name="w" value="<?php echo $w; ?>">
		<?php if($it_id) { ?>
			<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
			<input type="hidden" name="cfn" value="1">
		<?php } ?>
		<div class="itemform">
			<ul>
			<?php for($i=0; $i < $flist_cnt; $i++) { ?>
				<li><label><input type="radio" name="fn" value="<?php echo $flist[$i]['pi_id'];?>"> <?php echo $flist[$i]['pi_name'];?></label></li>
			<?php } ?>
			</ul>
		</div>
		<?php echo $frm_submit;?>

		</form>
	</div>
	<script>
		function fitemformcheck(f) {
			var formtype = $("input:radio[name=fn]:checked").val();
			if (!formtype) {
				alert("등록폼을 선택해 주세요.");
				return false;
			}
		}
	</script>

<?php

} else { // 입력폼이 있다면...

	$frow = array();
	if($it_id) {
		$fn = ($cfn) ? $fn : $ca['pt_form'];
		$frow = apms_form_skin($fn);
		if(!$frow['pi_id']) {
			$crow = array();
			$crow = apms_form_skin('', $it['ca_id']);
			$fn = $crow['pi_id'];
			$fskin = $crow['pi_file'];
			$fname = $crow['pi_name'];
		} else {
			$fskin = $frow['pi_file'];
			$fname = $frow['pi_name'];
		}
	} else {
		$frow = apms_form_skin($fn);
		$fskin = $frow['pi_file'];
		$fname = $frow['pi_name'];
	}

	// 등록폼
	$form_skin_path = G5_SKIN_PATH.'/apms/form';
	$form_skin_url = G5_SKIN_URL.'/apms/form';
	$fskin_file = $form_skin_path.'/'.$fskin;

	include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

	// 분류리스트
	$category_select = '';
	$script = '';
	$sql = " select * from {$g5['g5_shop_category_table']} ";
	$sql .= " where pt_form = '{$fn}' ";
	if (!$is_cauth) {
		//$sql .= " and pt_use = '1' and (pt_cate = '' or pt_cate = '{$member['mb_id']}')";
		$sql .= " and pt_use = '1' and (pt_cate = '' or find_in_set('{$member['mb_id']}', pt_cate))";
	}
	$sql .= " order by ca_order, ca_id ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++)
	{
		$len = strlen($row['ca_id']) / 2 - 1;

		$nbsp = "";
		for ($i=0; $i<$len; $i++)
			$nbsp .= "&nbsp;&nbsp;&nbsp;";


		if($row['as_line']) {
			$category_select .= "<option value=\"\">".$nbsp."------------</option>\n";
		}

		$category_select .= "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";

		$script .= "ca_use['{$row['ca_id']}'] = {$row['ca_use']};\n";
		$script .= "ca_stock_qty['{$row['ca_id']}'] = {$row['ca_stock_qty']};\n";
		//$script .= "ca_explan_html['$row[ca_id]'] = $row[ca_explan_html];\n";
		$script .= "ca_sell_email['{$row['ca_id']}'] = '{$row['ca_sell_email']}';\n";
	}

	if(!$category_select) {
		alert("지정한 등록폼을 사용하는 분류가 없습니다.\\n\\n다른 등록폼을 선택해 주세요.");
	}

	$is_reserve = ($default['pt_reserve_end'] > 0 && $default['pt_reserve_day'] > 0 && $default['pt_reserve_cache'] > 0) ? true : false;
	$is_reserve = ($is_reserve && ($is_auth || $default['pt_reserve_use'] == "1")) ? true : false;

	$reserve_none = ($it['it_time'] && $default['pt_reserve_none'] > 0) ? (strtotime($it['it_time']) + $default['pt_reserve_none'] * 60 * 60) - G5_SERVER_TIME : 1;
	$is_reserve_none = ($is_auth || $reserve_none > 0) ? false : true;

	list($pt_rdate, $pt_rhour, $pt_rminute) = apms_reserve_end($it['pt_reserve']);
	if($default['pt_reserve_cache'] > 0) list($pt_edate, $pt_ehour, $pt_eminute) = apms_reserve_end($it['pt_end'],1);

	// 파트너 분류
	$sql_pt = "and pt_use = '1'";

	$form_title = $fname.' '.$html_title;

?>
	<style>
		.new_win { line-height:1.4; overflow:hidden; }
		.new_win h1 { font-size:16px; font-weight:bold; line-height:60px; margin:0; }
		.new_win h2 { font-size:14px; padding:0px; line-height:40px; margin:0 20px 10px; font-weight:bold; }
		.new_win .anchor { margin:10px 0px !important; }
		.new_win .local_desc { margin-top:-10px; }
		.new_win .tbl_wrap { margin:0 0 20px; }
		.new_win .tbl_wrap label { margin:0; }
		.new_win .tbl_wrap th { text-align:right; padding-left:6px; padding-right:6px; }
		.new_win .tbl_wrap th label { font-weight:bold; }
		.new_win .tbl_wrap caption { display:none; }
		.new_win .compare_wrap { margin:0 0 10px; }
		.new_win .compare_wrap h3 { font-size:14px; font-weight:bold; }
		.new_win td label { font-weight:normal !important; }
		.new_win fieldset legend { display:none !important; }
		#sit_compact { margin:0 0 -1px; }
		#sit_option_addfrm_btn { top:45px; }
	</style>
	<div class="new_win">
		<div style="float:right; margin:20px;">
			<form name="changeitemform">
				<input type="hidden" name="ap" value="item">
				<input type="hidden" name="w" value="<?php echo $w; ?>">
				<input type="hidden" name="sca" value="<?php echo $sca; ?>">
				<input type="hidden" name="sst" value="<?php echo $sst; ?>">
				<input type="hidden" name="sod"  value="<?php echo $sod; ?>">
				<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
				<input type="hidden" name="stx"  value="<?php echo $stx; ?>">
				<input type="hidden" name="page" value="<?php echo $page; ?>">

				<?php if($it_id) { ?>
					<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
					<input type="hidden" name="cfn" value="1">
				<?php } ?>
				<select name="fn">
					<?php echo apms_form_option('select', $flist, $fn);?>
				</select>
				<button type="submit" class="btn_frmline">폼변경</button>
			</form>
		</div>

		<h1><?php echo $form_title;?></h1>

		<div style="clear:both;"></div>	

		<form name="fitemform" action="./itemformupdate.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off" onsubmit="return fitemformcheck(this)">
			<input type="hidden" name="codedup" value="<?php echo $default['de_code_dup_use']; ?>">
			<input type="hidden" name="ap" value="item">
			<input type="hidden" name="w" value="<?php echo $w; ?>">
			<input type="hidden" name="fn" value="<?php echo $fn; ?>">
			<input type="hidden" name="sca" value="<?php echo $sca; ?>">
			<input type="hidden" name="sst" value="<?php echo $sst; ?>">
			<input type="hidden" name="sod"  value="<?php echo $sod; ?>">
			<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
			<input type="hidden" name="stx"  value="<?php echo $stx; ?>">
			<input type="hidden" name="page" value="<?php echo $page; ?>">

			<?php @include_once($fskin_file); ?>

		</form>
	</div>
<?php } //닫기 ?>
