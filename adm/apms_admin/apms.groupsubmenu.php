<?php
$sub_menu = '777002';
include_once('./_common.php');

if(!$gr_id || !$cid) {
	alert_close('값이 넘어오지 않았습니다.');
}

check_demo();

if($mode == 'menu') {

	auth_check($auth[$sub_menu], 'w'); //쓰기 권한

	check_admin_token();

	if($opt == "add") {

		sql_query(" insert {$g5['apms_page']} set as_html = '3', as_code = '{$cid}', gr_id = '{$gr_id}' ", false);

	} else if($opt == "del") {

		sql_query(" delete from {$g5['apms_page']} where id = '{$id}' ", false);

		$row = sql_fetch(" select count(*) as cnt from {$g5['apms_page']} where gr_id = '{$gr_id}' and as_code = '{$cid}' and as_html = '3' ");

		//서브체크
		$is_sub = ($row['cnt']) ? 1 : 0;

		sql_query(" update {$g5['apms_page']} set as_menu = '{$is_sub}' where id = '{$cid}' ", false);

	} else if($opt == "save") {

		$cnt = count($_POST['id']);

		$z = 0;
		for($i=0; $i < $cnt; $i++) {

			if(!$_POST['id'][$i]) 
				continue;

			if($_POST['as_show'][$i] && $_POST['html_id'][$i] && $_POST['bo_subject'][$i]) 
				$z++;

			//html_table
			$sql = " update {$g5['apms_page']}
						set as_order				= '{$_POST['as_order'][$i]}'
							, bo_subject			= '{$_POST['bo_subject'][$i]}'
							, bo_mobile_subject		= '{$_POST['bo_mobile_subject'][$i]}'
							, as_icon				= '{$_POST['as_icon'][$i]}'
							, as_mobile_icon		= '{$_POST['as_mobile_icon'][$i]}'
							, as_title				= '{$_POST['as_title'][$i]}'
							, as_desc				= '{$_POST['as_desc'][$i]}'
							, as_link				= '{$_POST['as_link'][$i]}'
							, as_target				= '{$_POST['as_target'][$i]}'
							, as_show				= '{$_POST['as_show'][$i]}'
							, as_menu_show			= '{$_POST['as_menu_show'][$i]}'
							, as_grade				= '{$_POST['as_grade'][$i]}'
							, as_equal				= '{$_POST['as_equal'][$i]}'
							, as_wide				= '{$_POST['as_wide'][$i]}'
							, as_partner			= '{$_POST['as_partner'][$i]}'
							, as_min				= '{$_POST['as_min'][$i]}'
							, as_max				= '{$_POST['as_max'][$i]}'
							, html_id				= '{$_POST['html_id'][$i]}'
							, as_file				= '{$_POST['as_file'][$i]}'
							, as_skin				= '{$_POST['as_skin'][$i]}'
							, as_head				= '{$_POST['as_head'][$i]}'
							, as_hcolor				= '{$_POST['as_hcolor'][$i]}'
							where id = '{$_POST['id'][$i]}'
							";
			sql_query($sql);
		}

		//서브체크
		$is_sub = ($z) ? 1 : 0;

		sql_query(" update {$g5['apms_page']} set as_menu = '{$is_sub}' where id = '{$cid}' ", false);

		//자동메뉴 캐시
		if(IS_YC) {
			apms_cache('apms_mobile_shop_menu', 0, "apms_chk_auto_menu(1,1,1)");
			apms_cache('apms_pc_shop_menu', 0, "apms_chk_auto_menu(1,0,1)");
		}
		apms_cache('apms_mobile_bbs_menu', 0, "apms_chk_auto_menu(1,1)");
		apms_cache('apms_pc_bbs_menu', 0, "apms_chk_auto_menu(1)");
	}

	//Move
	goto_url('./apms.groupsubmenu.php?gr_id='.$gr_id.'&amp;cid='.$cid);
}

auth_check($auth[$sub_menu], 'r'); //읽기 권한

include_once(G5_LIB_PATH.'/apms.widget.lib.php');

$skinlist = array();
$headlist = array();

$skinlist = get_skin_dir('page', G5_SKIN_PATH);
$headlist = get_skin_dir('header', G5_SKIN_PATH);

$row1 = sql_fetch("select bo_subject from {$g5['apms_page']} where id = '{$cid}' ");

include_once(G5_PATH.'/head.sub.php');

?>
<script src="<?php echo G5_ADMIN_URL ?>/admin.js"></script>
<script src="<?php echo G5_ADMIN_URL ?>/apms_admin/apms.admin.js"></script>

<style>
	.sp { height:6px; }
	.sp1 { height:10px; }
</style>
<div id="wrapper">
    <div id="container">

		<h1><b>"<?php echo $group['gr_subject'];?> > <?php echo $row1['bo_subject'];?>"</b> 서브메뉴 설정</h1>

		<div class="local_ov01 local_ov">
			보임, 아이디, PC 메뉴명이 설정된 메뉴만 출력되며, 일반문서의 메뉴추가는 하단의 일반메뉴추가를 클릭하시면 됩니다. 
		</div>

		<form id="menuform" name="menuform" method="post">
		<input type="hidden" name="mode" value="menu">
		<input type="hidden" name="opt" value="save">
		<input type="hidden" name="gr_id" value="<?php echo $gr_id;?>">
		<input type="hidden" name="cid" value="<?php echo $cid;?>">

		<div class="tbl_head01 tbl_wrap">
			<table>
			<thead>
			<tr>
			<th width=60>보임</th>
			<th width=60>순서</th>
			<th width=160>아이디/파일(/page/)</th>
			<th width=140>PC 메뉴명/아이콘</th>
			<th width=140>모바일 메뉴명/아이콘</th>
			<th>타이틀/설명글</th>
			<th width=140>링크/타켓</th>
			<th width=100>문서헤더</th>
			<th width=100>문서스킨</th>
			<th width=80>접근레벨</th>
			<th width=100>접근등급</th>
			<th width=60>제한</th>
			<th width=60>와이드</th>
			<?php if(USE_PARTNER) { ?>
				<th width=60>파트너</th>
			<?php } ?>
			<th width=40>보기</th>
			<th width=40>삭제</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$result = sql_query("select * from {$g5['apms_page']} where gr_id = '{$gr_id}' and as_code = '{$cid}' and as_html = '3' order by as_order");
				for ($z=0; $row=sql_fetch_array($result); $z++) {
					$bg = ($z%2 == 0) ? '' : ' style="background:#f2f5f9;"';
			?>
				<tr>
				<td align="center">
					<input type="checkbox" class="chk_show" name="as_show[<?php echo $z; ?>]" value="1"<?php echo ($row['as_show'] ? " checked" : ""); ?>>
				</td>
				<td align="center">
					<input type="text" name="as_order[<?php echo $z; ?>]" size="4" value="<?php echo $row['as_order']; ?>" class="frm_input">
				</td>
				<td>
					<input type="text" name="html_id[<?php echo $z;?>]" size="14" value="<?php echo $row['html_id'];?>" class="frm_input" required placeholder="문서아이디">
					<a href="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.page.edit.php?id=<?php echo $row['id'];?>" class="btn_frmline win_memo" style="background:<?php echo ($row['as_content']) ? 'orangered' : 'gray';?>;">
						편집
					</a>
					<div class="sp"></div>
					<input type="text" name="as_file[<?php echo $z;?>]" size="20" value="<?php echo $row['as_file'];?>" class="frm_input" placeholder="문서파일(/page/)">
				</td>
				<td>
					<input type="text" name="bo_subject[<?php echo $z;?>]" size="18" value="<?php echo $row['bo_subject'];?>" placeholder="PC 메뉴명" class="frm_input">
					<div class="sp"></div>
					<input type="text" name="as_icon[<?php echo $z;?>]" size="18" value="<?php echo $row['as_icon'];?>" placeholder="PC 아이콘" class="frm_input">
				</td>
				<td>
					<input type="text" name="bo_mobile_subject[<?php echo $z;?>]" size="18" value="<?php echo $row['bo_mobile_subject'];?>" placeholder="모바일 메뉴명" class="frm_input">
					<div class="sp"></div>
					<input type="text" name="as_mobile_icon[<?php echo $z;?>]" size="18" value="<?php echo $row['as_mobile_icon'];?>" placeholder="모바일 아이콘" class="frm_input">
				</td>
				<td>
					<input type="text" name="as_title[<?php echo $z;?>]" size="15" value="<?php echo $row['as_title'];?>" placeholder="타이틀" class="frm_input" style="width:98%;min-width:140px;">
					<div class="sp"></div>
					<input type="text" name="as_desc[<?php echo $z;?>]" size="15" value="<?php echo $row['as_desc'];?>" placeholder="설명글" class="frm_input" style="width:98%;min-width:140px;">
				</td>
				<td>
					<input type="text" name="as_link[<?php echo $z;?>]" size="20" value="<?php echo $row['as_link'];?>" placeholder="http://..." class="frm_input">
					<div class="sp"></div>
					<input type="text" name="as_target[<?php echo $z;?>]" size="20" value="<?php echo $row['as_target'];?>" placeholder="target" class="frm_input">
				</td>
				<td align="center">
					<select name="as_head[<?php echo $z;?>]" style="width:100;">
						<option value="">헤더 미사용</option>
						<?php
							for ($j=0; $j<count($headlist); $j++) {
								echo "<option value=\"".$headlist[$j]."\"".get_selected($row['as_head'], $headlist[$j]).">".$headlist[$j]."</option>\n";
							} 
						?>
					</select>
					<div class="sp1"></div>
					<select name="as_hcolor[<?php echo $z;?>]" style="width:100;">
						<?php echo apms_color_options($row['as_hcolor']);?>
					</select>
				</td>
				<td align="center">
					<select name="as_skin[<?php echo $z;?>]" style="width:100;">
						<option value="">스킨 미사용</option>
						<?php
							for ($j=0; $j<count($skinlist); $j++) {
								echo "<option value=\"".$skinlist[$j]."\"".get_selected($row['as_skin'], $skinlist[$j]).">".$skinlist[$j]."</option>\n";
							} 
						?>
					</select>
				</td>
				<td align="center">
					<nobr>
					<input type="text" name="as_min[<?php echo $z;?>]" size="2" value="<?php echo $row['as_min'];?>" placeholder="From" class="frm_input">
					~
					<input type="text" name="as_max[<?php echo $z;?>]" size="2" value="<?php echo $row['as_max'];?>" placeholder="To" class="frm_input">
					</nobr>
				</td>
				<td align="center">
					<nobr>
					<?php echo get_member_level_select("as_grade[".$z."]", 1, 10, $row['as_grade']); ?>
					<select name="as_equal[<?php echo $z; ?>]" style="width:40px;">
						<option value="0">≥</option>
						<option value="1"<?php if($row['as_equal'] == "1") echo " selected";?>>＝</option>
					</select>
					</nobr>
				</td>
				<td align="center">
					<select name="as_menu_show[<?php echo $z; ?>]" style="width:50px;">
						<option value="0">NO - 항상 메뉴 출력</option>
						<option value="1"<?php if($row['as_menu_show'] == "1") echo " selected";?>>YES - 접근 회원만 메뉴 출력</option>
					</select>
				</td>
				<td align="center">
					<input type="checkbox" name="as_wide[<?php echo $z; ?>]" value="1"<?php echo ($row['as_wide'] ? " checked" : ""); ?>>
				</td>
				<?php if(USE_PARTNER) { ?>
					<td align="center">
						<input type="checkbox" name="as_partner[<?php echo $z; ?>]" value="1"<?php echo ($row['as_partner'] ? " checked" : ""); ?>>
					</td>
				<?php } ?>
				<td align="center">
					<?php if($row['html_id']) { ?>
						<a href="<?php echo G5_BBS_URL;?>/page.php?hid=<?php echo urlencode($row['html_id']);?>" target="_blank">
							<i class="fa fa-share fa-lg"></i>
						</a>
					<?php } else { ?>
						-
					<?php } ?>
					<input type="hidden" name="id[<?php echo $z; ?>]" value="<?php echo $row['id'];?>">
				</td>
				<td align="center">
					<a href="./apms.groupsubmenu.php?gr_id=<?php echo $gr_id;?>&amp;mode=menu&amp;opt=del&amp;id=<?php echo $row['id'];?>&cid=<?php echo $cid;?>" class="menu-del">
						삭제
					</a>
				</td>
				</tr>
			<?php } ?>
			<?php
			if (!$z) {
				$colspan = (USE_PARTNER) ? 17 : 16;
				echo '<tr><td colspan="'.$colspan.'" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
			}
			?>
			</tbody>
			</table>
		</div>

		<div class="btn_confirm01 btn_confirm" style="text-align:center;">
			<button type="button" class="chk_all" class="btn_frmline">모두보임</button>
			<a href="<?php echo G5_BBS_URL;?>/ficon.php" class="btn_frmline win_memo">아이콘 검색</a>
			<a href="./apms.groupsubmenu.php?gr_id=<?php echo $gr_id;?>&amp;cid=<?php echo $cid;?>&amp;mode=menu&amp;opt=add" class="btn_frmline apms-confirm" style="background:#000;">
				일반메뉴추가
			</a>
			<input type="submit" value="일괄저장" class="btn_submit">
			<button type="button" onclick="self.close();" class="btn_frmline">창닫기</button>
		</div>

		</form>
	</div>
</div>
<div style="height:100px;"></div>
<script>
	var win_w = screen.width;
	var win_h = screen.height - 40;
	window.moveTo(0, 0);
	window.resizeTo(win_w, win_h);

	var menu_del = function(href) {
		if(confirm("정말 메뉴를 삭제 하시겠습니까?")) {
			apms_token(href);
		}
		return false;
	}

	$(function(){
		$('.menu-del').click(function() {
			menu_del(this.href);
			return false;
		});
		$('.chk_all').click(function(){
			$('#menuform .chk_show').attr('checked', true);
		});
	});
</script>

<?php include_once(G5_PATH.'/tail.sub.php'); ?>