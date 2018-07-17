<?php
$sub_menu = '777002';
include_once('./_common.php');

if(!$gr_id) {
	alert_close('값이 넘어오지 않았습니다.');
}

check_demo();

if($mode == 'menu') {

	auth_check($auth[$sub_menu], 'w'); //쓰기 권한

	check_admin_token();

	if($opt == "add") {

		sql_query(" insert {$g5['apms_page']} set as_html = '2', gr_id = '{$gr_id}' ", false);

	} else if($opt == "del") {

		sql_query(" delete from {$g5['apms_page']} where id = '{$id}' or as_code = '{$id}' ", false);

	} else if($opt == "save") {

		$cnt = count($_POST['type']);

		for($i=0; $i < $cnt; $i++) {

			if($_POST['type'][$i] == "board") {

				if(!$_POST['id_board'][$i]) continue;

				//board_table
				$sql = " update {$g5['board_table']}
							set as_order				= '{$_POST['as_order'][$i]}'
								, bo_subject			= '{$_POST['bo_subject'][$i]}'
								, bo_mobile_subject		= '{$_POST['bo_mobile_subject'][$i]}'
								, bo_device				= '{$_POST['bo_device'][$i]}'
								, as_icon				= '{$_POST['as_icon'][$i]}'
								, as_mobile_icon		= '{$_POST['as_mobile_icon'][$i]}'
								, as_title				= '{$_POST['as_title'][$i]}'
								, as_desc				= '{$_POST['as_desc'][$i]}'
								, as_link				= '{$_POST['as_link'][$i]}'
								, as_target				= '{$_POST['as_target'][$i]}'
								, as_line				= '{$_POST['as_line'][$i]}'
								, as_sp					= '{$_POST['as_sp'][$i]}'
								, as_show				= '{$_POST['as_show'][$i]}'
								, as_menu				= '{$_POST['as_menu'][$i]}'
								, as_menu_show			= '{$_POST['as_menu_show'][$i]}'
								, as_grade				= '{$_POST['as_grade'][$i]}'
								, as_equal				= '{$_POST['as_equal'][$i]}'
								, as_wide				= '{$_POST['as_wide'][$i]}'
								, as_partner			= '{$_POST['as_partner'][$i]}'
								, as_min				= '{$_POST['as_min'][$i]}'
								, as_max				= '{$_POST['as_max'][$i]}'
								where bo_table = '{$_POST['id_board'][$i]}'
								";
				sql_query($sql);

			} else if($_POST['type'][$i] == "html" || $_POST['type'][$i] == "menu") {

				if(!$_POST['id'][$i]) continue;

				$m_sql = '';
				if($_POST['type'][$i] == "menu") {
					$m_sql .= "	, html_id				= '{$_POST['html_id'][$i]}'
								, as_file				= '{$_POST['as_file'][$i]}'
							";
				}

				//html_table
				$sql = " update {$g5['apms_page']}
							set as_order				= '{$_POST['as_order'][$i]}'
								, bo_subject			= '{$_POST['bo_subject'][$i]}'
								, bo_mobile_subject		= '{$_POST['bo_mobile_subject'][$i]}'
								, bo_device				= '{$_POST['bo_device'][$i]}'
								, as_icon				= '{$_POST['as_icon'][$i]}'
								, as_mobile_icon		= '{$_POST['as_mobile_icon'][$i]}'
								, as_title				= '{$_POST['as_title'][$i]}'
								, as_desc				= '{$_POST['as_desc'][$i]}'
								, as_link				= '{$_POST['as_link'][$i]}'
								, as_target				= '{$_POST['as_target'][$i]}'
								, as_line				= '{$_POST['as_line'][$i]}'
								, as_sp					= '{$_POST['as_sp'][$i]}'
								, as_show				= '{$_POST['as_show'][$i]}'
								, as_menu_show			= '{$_POST['as_menu_show'][$i]}'
								, as_grade				= '{$_POST['as_grade'][$i]}'
								, as_equal				= '{$_POST['as_equal'][$i]}'
								, as_wide				= '{$_POST['as_wide'][$i]}'
								, as_partner			= '{$_POST['as_partner'][$i]}'
								, as_min				= '{$_POST['as_min'][$i]}'
								, as_max				= '{$_POST['as_max'][$i]}'
								, as_skin				= '{$_POST['as_skin'][$i]}'
								, as_head				= '{$_POST['as_head'][$i]}'
								, as_hcolor				= '{$_POST['as_hcolor'][$i]}'
								$m_sql
								where id = '{$_POST['id'][$i]}'
								";
				sql_query($sql);
			}
		}

		//자동메뉴 캐시
		if(IS_YC) {
			apms_cache('apms_mobile_shop_menu', 0, "apms_chk_auto_menu(1,1,1)");
			apms_cache('apms_pc_shop_menu', 0, "apms_chk_auto_menu(1,0,1)");
		}
		apms_cache('apms_mobile_bbs_menu', 0, "apms_chk_auto_menu(1,1)");
		apms_cache('apms_pc_bbs_menu', 0, "apms_chk_auto_menu(1)");
	}

	//Move
	goto_url('./apms.groupmenu.php?gr_id='.$gr_id);
}

auth_check($auth[$sub_menu], 'r'); //읽기 권한

include_once(G5_LIB_PATH.'/apms.widget.lib.php');

$result2 = sql_query("select * from {$g5['board_table']} where gr_id = '{$gr_id}' ");
for ($k=0; $row2=sql_fetch_array($result2); $k++) {
	$bo[$k] = $row2;
}
$result3 = sql_query("select * from {$g5['apms_page']} where gr_id = '{$gr_id}' and as_html <> '3'");
for ($k=$k; $row3=sql_fetch_array($result3); $k++) {
	$bo[$k] = $row3;
}

$bo_cnt = count($bo);

if($bo_cnt > 0) $bo = apms_sort($bo, 'as_order');

$skinlist = array();
$headlist = array();

$skinlist = get_skin_dir('page', G5_SKIN_PATH);
$headlist = get_skin_dir('header', G5_SKIN_PATH);

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

		<h1><b>"<?php echo $group['gr_subject'];?>"</b> 서브메뉴 설정</h1>

		<div class="local_ov01 local_ov">
			보임, 아이디, PC 메뉴명이 설정된 메뉴만 출력되며, 일반문서의 메뉴추가는 하단의 일반메뉴추가를 클릭하시면 됩니다.
		</div>

		<form id="menuform" name="menuform" method="post">
		<input type="hidden" name="mode" value="menu">
		<input type="hidden" name="opt" value="save">
		<input type="hidden" name="gr_id" value="<?php echo $gr_id;?>">

		<div class="tbl_head01 tbl_wrap">
			<table>
			<thead>
			<tr>
			<th width=60>보임</th>
			<th width=60>출력기기</th>
			<th width=60>서브메뉴</th>
			<th width=60>순서</th>
			<th width=160>아이디/파일(/page/)</th>
			<th width=140>PC 메뉴명/아이콘</th>
			<th width=140>모바일 메뉴명/아이콘</th>
			<th>타이틀/설명글</th>
			<th width=140>링크/타켓</th>
			<th width=100>문서헤더</th>
			<th width=100>문서스킨</th>
			<th width=120>상단라인</th>
			<th width=60>나눔</th>
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
				$z = 0;
				for ($k=0; $k < $bo_cnt; $k++) {
					$chk_asr = false;
					$bg = ($z%2 == 0) ? '' : ' style="background:#f2f5f9;"';
			?>
				<tr>
				<td align="center">
					<input type="checkbox" class="chk_show" name="as_show[<?php echo $z; ?>]" value="1"<?php echo ($bo[$k]['as_show'] ? " checked" : ""); ?>>
				</td>
				<td align="center"<?php echo $rowspan;?>>
					<select name="bo_device[<?php echo $z; ?>]">
						<option value="both"<?php if($bo[$k]['bo_device'] == 'both') echo ' selected';?>>모두</option>
						<option value="pc"<?php if($bo[$k]['bo_device'] == 'pc') echo ' selected';?>>PC</option>
						<option value="mobile"<?php if($bo[$k]['bo_device'] == 'mobile') echo ' selected';?>>모바일</option>
					</select>
				</td>
				<td align="center">
					<?php if($bo[$k]['bo_table']) { ?>
						<select name="as_menu[<?php echo $z; ?>]" style="width:50px;">
							<option value="0">YES - 분류 출력</option>
							<option value="1"<?php if($bo[$k]['as_menu'] == "1") echo " selected";?>>NO - 출력 안함</option>
							<option value="2"<?php if($bo[$k]['as_menu'] == "2") echo " selected";?>>PC만 분류출력</option>
						</select>
					<?php } else { ?>
						<?php if($bo[$k]['as_html'] == "2") { ?>
							<a href="./apms.groupsubmenu.php?gr_id=<?php echo $gr_id;?>&amp;cid=<?php echo $bo[$k]['id'];?>" class="btn_frmline win_profile"
							style="background:<?php echo ($bo[$k]['as_menu']) ? 'orangered' : 'gray';?>;">
								<nobr>설정</nobr>
							</a>							
						<?php } else { ?>
							-
						<?php } ?>
					<?php } ?>
				</td>
				<td align="center">
					<input type="text" name="as_order[<?php echo $z; ?>]" size="4" value="<?php echo $bo[$k]['as_order']; ?>" class="frm_input">
				</td>
				<td>
					<?php if($bo[$k]['bo_table']) { ?>
						<input type="hidden" name="type[<?php echo $z;?>]" value="board">
						<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo[$k]['bo_table'];?>" target="_blank">
							보드 - <?php echo $bo[$k]['bo_table'];?>
						</a>
					<?php } else { ?>
						<input type="hidden" name="id[<?php echo $z;?>]" value="<?php echo $bo[$k]['id'];?>">
						<?php if($bo[$k]['as_html'] == "2") { ?>
							<input type="hidden" name="type[<?php echo $z;?>]" value="menu">
							<input type="text" name="html_id[<?php echo $z;?>]" size="14" value="<?php echo $bo[$k]['html_id'];?>" class="frm_input" required placeholder="문서아이디">
							<a href="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.page.edit.php?id=<?php echo $bo[$k]['id'];?>" class="btn_frmline win_memo" style="background:<?php echo ($bo[$k]['as_content']) ? 'orangered' : 'gray';?>;">
								편집
							</a>
							<div class="sp"></div>
							<input type="text" name="as_file[<?php echo $z;?>]" size="20" value="<?php echo $bo[$k]['as_file'];?>" class="frm_input" placeholder="문서파일(/page/)">
						<?php } else if($bo[$k]['as_html'] == "1") { ?>
							<input type="hidden" name="type[<?php echo $z;?>]" value="html">
							<a href="<?php echo G5_BBS_URL;?>/page.php?hid=<?php echo urlencode($bo[$k]['html_id']);?>" target="_blank">
								일반 - <?php echo $bo[$k]['html_id'];?>
							</a>
						<?php } else { ?>
							<input type="hidden" name="type[<?php echo $z;?>]" value="html">
							<a href="<?php echo G5_URL;?>/<?php echo $bo[$k]['as_file'];?>" target="_blank">
								기본 - <?php echo $bo[$k]['html_id'];?>
							</a>
						<?php } ?>
					<?php } ?>					
				</td>
				<td>
					<input type="text" name="bo_subject[<?php echo $z;?>]" size="18" value="<?php echo $bo[$k]['bo_subject'];?>" placeholder="PC 메뉴명" class="frm_input">
					<div class="sp"></div>
					<input type="text" name="as_icon[<?php echo $z;?>]" size="18" value="<?php echo $bo[$k]['as_icon'];?>" placeholder="PC 아이콘" class="frm_input">
				</td>
				<td>
					<input type="text" name="bo_mobile_subject[<?php echo $z;?>]" size="18" value="<?php echo $bo[$k]['bo_mobile_subject'];?>" placeholder="모바일 메뉴명" class="frm_input">
					<div class="sp"></div>
					<input type="text" name="as_mobile_icon[<?php echo $z;?>]" size="18" value="<?php echo $bo[$k]['as_mobile_icon'];?>" placeholder="모바일 아이콘" class="frm_input">
				</td>
				<td>
					<input type="text" name="as_title[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['as_title'];?>" placeholder="타이틀" class="frm_input" style="width:98%;min-width:140px;">
					<div class="sp"></div>
					<input type="text" name="as_desc[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['as_desc'];?>" placeholder="설명글" class="frm_input" style="width:98%;min-width:140px;">
				</td>
				<td>
					<input type="text" name="as_link[<?php echo $z;?>]" size="20" value="<?php echo $bo[$k]['as_link'];?>" placeholder="http://..." class="frm_input">
					<div class="sp"></div>
					<input type="text" name="as_target[<?php echo $z;?>]" size="20" value="<?php echo $bo[$k]['as_target'];?>" placeholder="target" class="frm_input">
				</td>
				<td align="center">
					<?php if($bo[$k]['bo_table']) { ?>
						-
					<?php } else { ?>
						<select name="as_head[<?php echo $z;?>]" style="width:100;">
							<option value="">헤더 미사용</option>
							<?php
								for ($j=0; $j<count($headlist); $j++) {
									echo "<option value=\"".$headlist[$j]."\"".get_selected($bo[$k]['as_head'], $headlist[$j]).">".$headlist[$j]."</option>\n";
								} 
							?>
						</select>
						<div class="sp1"></div>
						<select name="as_hcolor[<?php echo $z;?>]" style="width:100;">
							<?php echo apms_color_options($bo[$k]['as_hcolor']);?>
						</select>
					<?php } ?>
				</td>
				<td align="center">
					<?php if($bo[$k]['bo_table']) { ?>
						-
					<?php } else { ?>
						<select name="as_skin[<?php echo $z;?>]" style="width:100;">
							<option value="">스킨 미사용</option>
							<?php
								for ($j=0; $j<count($skinlist); $j++) {
									echo "<option value=\"".$skinlist[$j]."\"".get_selected($bo[$k]['as_skin'], $skinlist[$j]).">".$skinlist[$j]."</option>\n";
								} 
							?>
						</select>
					<?php } ?>
				</td>
				<td align="center">
					<input type="text" name="as_line[<?php echo $z;?>]" size="15" value="<?php echo $bo[$k]['as_line'];?>" class="frm_input">
				</td>
				<td align="center">
					<input type="checkbox" name="as_sp[<?php echo $z; ?>]" value="1"<?php echo ($bo[$k]['as_sp'] ? " checked" : ""); ?>>
				</td>
				<td align="center">
					<nobr>
					<input type="text" name="as_min[<?php echo $z;?>]" size="2" value="<?php echo $bo[$k]['as_min'];?>" placeholder="From" class="frm_input">
					~
					<input type="text" name="as_max[<?php echo $z;?>]" size="2" value="<?php echo $bo[$k]['as_max'];?>" placeholder="To" class="frm_input">
					</nobr>
				</td>
				<td align="center">
					<nobr>
					<?php echo get_member_level_select("as_grade[".$z."]", 1, 10, $bo[$k]['as_grade']); ?>
					<select name="as_equal[<?php echo $z; ?>]" style="width:40px;">
						<option value="0">≥</option>
						<option value="1"<?php if($bo[$k]['as_equal'] == "1") echo " selected";?>>＝</option>
					</select>
					</nobr>
				</td>
				<td align="center">
					<select name="as_menu_show[<?php echo $z; ?>]" style="width:50px;">
						<option value="0">NO - 항상 메뉴 출력</option>
						<option value="1"<?php if($bo[$k]['as_menu_show'] == "1") echo " selected";?>>YES - 접근 회원만 메뉴 출력</option>
					</select>
				</td>
				<td align="center">
					<input type="checkbox" name="as_wide[<?php echo $z; ?>]" value="1"<?php echo ($bo[$k]['as_wide'] ? " checked" : ""); ?>>
				</td>
				<?php if(USE_PARTNER) { ?>
					<td align="center">
						<input type="checkbox" name="as_partner[<?php echo $z; ?>]" value="1"<?php echo ($bo[$k]['as_partner'] ? " checked" : ""); ?>>
					</td>
				<?php } ?>
				<td align="center">
					<?php if($bo[$k]['bo_table']) { ?>
						<input type="hidden" name="id_board[<?php echo $z;?>]" value="<?php echo $bo[$k]['bo_table'];?>">
						<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo[$k]['bo_table'];?>" target="_blank">
							<i class="fa fa-share fa-lg"></i>
						</a>
					<?php } else { ?>
						<?php if($bo[$k]['html_id']) { ?>
							<?php if($bo[$k]['as_html'] == "1" || $bo[$k]['as_html'] == "2") { ?>
								<a href="<?php echo G5_BBS_URL;?>/page.php?hid=<?php echo urlencode($bo[$k]['html_id']);?>" target="_blank">
									<i class="fa fa-share fa-lg"></i>
								</a>
							<?php } else { ?>
								<a href="<?php echo G5_URL;?>/<?php echo $bo[$k]['as_file'];?>" target="_blank">
									<i class="fa fa-share fa-lg"></i>
								</a>
							<?php } ?>
						<?php } else { ?>
							-
						<?php } ?>
					<?php } ?>
				</td>
				<td align="center">
					<?php if(!$bo[$k]['bo_table'] && $bo[$k]['as_html'] == "2") { ?>
						<a href="./apms.groupmenu.php?gr_id=<?php echo $gr_id;?>&amp;mode=menu&amp;opt=del&amp;id=<?php echo $bo[$k]['id'];?>" class="menu-del">
							삭제
						</a>
					<?php } else { ?>
						-
					<?php } ?>
				</td>
				</tr>
			<?php $z++; } ?>
			<?php
			if (!$k) {
				$colspan = (USE_PARTNER) ? 20 : 19;
				echo '<tr><td colspan="'.$colspan.'" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
			}
			?>
			</tbody>
			</table>
		</div>

		<div class="btn_confirm01 btn_confirm" style="text-align:center;">
			<button type="button" class="chk_all" class="btn_frmline">모두보임</button>
			<a href="<?php echo G5_BBS_URL;?>/ficon.php" class="btn_frmline win_memo">아이콘 검색</a>
			<a href="./apms.groupmenu.php?gr_id=<?php echo $gr_id;?>&amp;mode=menu&amp;opt=add" class="btn_frmline apms-confirm" style="background:#000;">
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
		if(confirm("일반메뉴 삭제시 서브메뉴까지 일괄 삭제됩니다.\n\n정말 일반메뉴를 삭제 하시겠습니까?")) {
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