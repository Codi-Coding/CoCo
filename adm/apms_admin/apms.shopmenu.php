<?php
$sub_menu = '777002';
include_once('./_common.php');

if(!$cid) {
	alert_close("값이 넘어오지 않았습니다.");
}

check_demo();

if($mode == 'menu') {

	auth_check($auth[$sub_menu], 'w'); //쓰기 권한

	check_admin_token();

	for ($i=0; $i<count($_POST['ca_id']); $i++) {
		$sql = " update {$g5['g5_shop_category_table']}
					set ca_name             = '{$_POST['ca_name'][$i]}'
						, as_order          = '{$_POST['as_order'][$i]}'
						, as_icon			= '{$_POST['as_icon'][$i]}'
						, as_mobile_icon	= '{$_POST['as_mobile_icon'][$i]}'
						, as_link			= '{$_POST['as_link'][$i]}'
						, as_target			= '{$_POST['as_target'][$i]}'
						, as_line			= '{$_POST['as_line'][$i]}'
						, as_sp				= '{$_POST['as_sp'][$i]}'
						, as_show			= '{$_POST['as_show'][$i]}'
						, as_menu			= '{$_POST['as_menu'][$i]}'
						, as_menu_show		= '{$_POST['as_menu_show'][$i]}'
						, as_grade			= '{$_POST['as_grade'][$i]}'
						, as_equal			= '{$_POST['as_equal'][$i]}'
						, as_partner		= '{$_POST['as_partner'][$i]}'
						, as_min			= '{$_POST['as_min'][$i]}'
						, as_max			= '{$_POST['as_max'][$i]}'
						, as_title			= '{$_POST['as_title'][$i]}'
						, as_desc			= '{$_POST['as_desc'][$i]}'
						, as_thema			= '{$_POST['as_thema'][$i]}'
						, as_color			= '{$_POST['as_color'][$i]}'
						, as_mobile_thema	= '{$_POST['as_mobile_thema'][$i]}'
						, as_mobile_color	= '{$_POST['as_mobile_color'][$i]}'
				  where ca_id = '{$_POST['ca_id'][$i]}' ";
		sql_query($sql);
	}

	//자동메뉴 캐시
	apms_cache('apms_mobile_shop_menu', 0, "apms_chk_auto_menu(1,1,1)");
	apms_cache('apms_pc_shop_menu', 0, "apms_chk_auto_menu(1,0,1)");
	apms_cache('apms_mobile_bbs_menu', 0, "apms_chk_auto_menu(1,1)");
	apms_cache('apms_pc_bbs_menu', 0, "apms_chk_auto_menu(1)");

	//Move
	goto_url('./apms.shopmenu.php?cid='.$cid);
}

auth_check($auth[$sub_menu], 'r'); //읽기 권한

$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$cid' ";
$ca = sql_fetch($sql);
if (!$ca['ca_id']) {
	alert_close("등록된 분류가 아닙니다.");
}

$sql  = " select * from {$g5['g5_shop_category_table']} where length(ca_id) = '4' and ca_id like '$cid%' order by ca_order asc, ca_id asc ";
$result = sql_query($sql);
$cnt = @sql_num_rows($result);

if (!$cnt) {
	alert_close("등록된 하위분류가 없습니다.");
}

include_once(G5_PATH.'/head.sub.php');

?>
<script src="<?php echo G5_ADMIN_URL ?>/admin.js"></script>
<div id="wrapper">
    <div id="container">

		<h1><b><?php echo $ca['ca_name'];?></b> 분류 서브메뉴 설정</h1>

		<form id="menuform" name="menuform" method="post">
		<input type="hidden" name="mode" value="menu">
		<input type="hidden" name="cid" value="<?php echo $cid;?>">

		<div class="tbl_head01 tbl_wrap">
			<table>
			<thead>
			<tr>
			<th width=40><nobr>보임</nobr></th>
			<th width=90 colspan="2">서브메뉴</th>
			<th width=80><nobr>순서</nobr></th>
			<th width=80><nobr>코드</nobr></th>
			<th width=100>분류(메뉴명)</th>
			<th width=100>PC 아이콘</th>
			<th width=100>모바일 아이콘</th>
			<th width=180>타이틀</th>
			<th style="min-width:160px;">설명글</th>
			<th width=120>링크</th>
			<th width=60>타켓</th>
			<th width=120>상단라인</th>
			<th width=60>나눔</th>
			<th width=80>접근레벨</th>
			<th width=100>접근등급</th>
			<th width=60>제한</th>
			<?php if(USE_PARTNER) { ?>
				<th width=60>파트너</th>
			<?php } ?>
			<th width=40>보기</th>
			</tr>
			</thead>
			<tbody>
			<?php for ($i=0; $row=sql_fetch_array($result); $i++) {	
				// 서브메뉴
				$sub = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_category_table']} where length(ca_id) = '6' and ca_id like '{$row['ca_id']}%' ");
			?>
				<tr>
				<td align="center">
					<input type="checkbox" class="chk_show" name="as_show[<?php echo $i; ?>]" value="1"<?php echo ($row['as_show'] ? " checked" : ""); ?>>
				</td>
				<?php if($sub['cnt']) { ?>
					<td align="center">
						<a href="./apms.shopmenu2.php?cid=<?php echo $row['ca_id'];?>" class="btn_frmline win_profile"><nobr>서브메뉴설정</nobr></a>
					</td>
					<td align="center">
						<select name="as_menu[<?php echo $i; ?>]" style="width:50px;">
							<option value="0">YES - 하위 분류 출력</option>
							<option value="1"<?php if($row['as_menu'] == "1") echo " selected";?>>하위 분류 출력안함</option>
							<option value="2"<?php if($row['as_menu'] == "2") echo " selected";?>>PC만 하위 분류 출력</option>
						</select>
					</td>
				<?php } else { ?>
					<td colspan="2" align="center">
						없음
					</td>
				<?php } ?>
				<td align=center width=40>
					<input type="text" name="as_order[<?php echo $i; ?>]" value='<?php echo $row['as_order']; ?>' size="3" class="frm_input">
				</td>
				<td>
					<input type="hidden" name="ca_id[<?php echo $i; ?>]" value="<?php echo $row['ca_id']; ?>">
					<a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row['ca_id']; ?>" target="_blank"><?php echo $row['ca_id']; ?></a>
				</td>
				<td align=center>
					<input type="text" name="ca_name[<?php echo $i; ?>]" size="15" value="<?php echo get_text($row['ca_name']); ?>" required placeholder="분류명" class="frm_input">
				</td>
				<td align=center>
					<input type="text" name="as_icon[<?php echo $i;?>]" size="15" value="<?php echo $row['as_icon'];?>" placeholder="PC 아이콘" class="frm_input">
				</td>
				<td align=center>
					<input type="text" name="as_mobile_icon[<?php echo $i;?>]" size="15" value="<?php echo $row['as_mobile_icon'];?>" placeholder="모바일 아이콘" class="frm_input">
				</td>
				<td align=center>
					<input type="text" name="as_title[<?php echo $i;?>]" size="15" value="<?php echo $row['as_title'];?>" placeholder="타이틀" class="frm_input" style="width:98%;min-width:200px;">
				</td>
				<td align=center>
					<input type="text" name="as_desc[<?php echo $i;?>]" size="15" value="<?php echo $row['as_desc'];?>" placeholder="설명글" class="frm_input" style="width:98%;min-width:200px;">
				</td>
				<td align=center>
					<input type="text" name="as_link[<?php echo $i;?>]" size="15" value="<?php echo $row['as_link'];?>" placeholder="http://..." class="frm_input">
				</td>
				<td align=center>
					<input type="text" name="as_target[<?php echo $i;?>]" size="10" value="<?php echo $row['as_target'];?>" placeholder="target" class="frm_input">
				</td>
				<td align=center>
					<input type="text" name="as_line[<?php echo $i;?>]" size="15" value="<?php echo $row['as_line'];?>" class="frm_input">
				</td>
				<td align="center">
					<input type="checkbox" name="as_sp[<?php echo $i; ?>]" value="1"<?php echo ($row['as_sp'] ? " checked" : ""); ?>>
				</td>
				<td align=center>
					<nobr>
					<input type="text" name="as_min[<?php echo $i;?>]" size="2" value="<?php echo $row['as_min'];?>" placeholder="From" class="frm_input">
					~
					<input type="text" name="as_max[<?php echo $i;?>]" size="2" value="<?php echo $row['as_max'];?>" placeholder="To" class="frm_input">
					</nobr>

				</td>
				<td align=center>
					<nobr>
					<?php echo get_member_level_select("as_grade[".$i."]", 1, 10, $row['as_grade']); ?>
					<select name="as_equal[<?php echo $i; ?>]" style="width:40px;">
						<option value="0">≥</option>
						<option value="1"<?php if($row['as_equal'] == "1") echo " selected";?>>＝</option>
					</select>
					</nobr>
				</td>
				<td align=center>
					<select name="as_menu_show[<?php echo $i; ?>]" style="width:50px;">
						<option value="0">NO - 항상 메뉴 출력</option>
						<option value="1"<?php if($row['as_menu_show'] == "1") echo " selected";?>>YES - 접근 회원만 메뉴 출력</option>
					</select>
				</td>
				<?php if(USE_PARTNER) { ?>
					<td align="center">
						<input type="checkbox" name="as_partner[<?php echo $i; ?>]" value="1"<?php echo ($row['as_partner'] ? " checked" : ""); ?>>
					</td>
				<?php } ?>
				<td>
					<a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row['ca_id']; ?>" target="_blank">
						<i class="fa fa-share fa-lg"></i>
					</a>
				</td>
				</tr>
			<?php } ?>
			<?php
		    if (!$i) {
				$colspan = (USE_PARTNER) ? 19 : 18;
				echo '<tr><td colspan="'.$colspan.'" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
			}
			?>
			</tbody>
			</table>
		</div>

		<div class="btn_confirm01 btn_confirm" style="text-align:center;">
			<button type="button" class="chk_all" class="btn_frmline">모두보임</button>
			<a href="<?php echo G5_BBS_URL;?>/ficon.php" class="btn_frmline win_memo">아이콘 검색</a>
			<input type="submit" value="일괄저장" class="btn_submit">
			<button type="button" onclick="self.close();" class="btn_frmline">창닫기</button>
		</div>

		</form>
	</div>
</div>
<script>
	var win_w = screen.width;
	var win_h = screen.height - 40;
	window.moveTo(0, 0);
	window.resizeTo(win_w, win_h);

	$(function(){
		$('.chk_all').click(function(){
			$('#menuform .chk_show').attr('checked', true);
		});
	});
</script>

<?php include_once(G5_PATH.'/tail.sub.php'); ?>