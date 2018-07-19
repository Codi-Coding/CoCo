<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

if($mode == 'bpage') {
	//HTML
	if($opt == 'insert') {

		if(!$_POST['html_id']) alert("PAGE ID를 입력해 주세요.");

		$row = sql_fetch("select html_id from {$g5['apms_page']} where html_id = '{$_POST['html_id']}' and as_html = '0' ", false);
		if($row['html_id']) {
			alert("이미 등록된 기본문서입니다.");
		} else {

			if(!$_POST['as_file'] || $_POST['as_shop']) $_POST['html_gr_id'] = '';

			$sql = " insert {$g5['apms_page']} 
						set gr_id					= '{$_POST['html_gr_id']}', 
							html_id					= '{$_POST['html_id']}', 
							as_file					= '{$_POST['as_file']}', 
							as_title				= '{$_POST['as_title']}', 
							as_desc					= '{$_POST['as_desc']}', 
							as_head					= '{$_POST['as_head']}', 
							as_hcolor				= '{$_POST['as_hcolor']}', 
							bo_subject				= '{$_POST['bo_subject']}', 
							as_wide					= '{$_POST['as_wide']}', 
							as_partner				= '{$_POST['as_partner']}', 
							as_html					= '0' ";

			sql_query($sql, false);
		}

	} else if($opt == 'edit') {
		$cnt = count($_POST['id']);
		for($i=0; $i < $cnt; $i++) {

			if(!$_POST['id'][$i]) continue;

			$sql = " update {$g5['apms_page']}
						set gr_id					= '{$_POST['html_gr_id'][$i]}'
							, as_file				= '{$_POST['as_file'][$i]}'
							, as_title				= '{$_POST['as_title'][$i]}'
							, as_desc				= '{$_POST['as_desc'][$i]}'
							, as_head				= '{$_POST['as_head'][$i]}'
							, as_hcolor				= '{$_POST['as_hcolor'][$i]}'
							, as_grade				= '{$_POST['as_grade'][$i]}'
							, as_equal				= '{$_POST['as_equal'][$i]}'
							, as_wide				= '{$_POST['as_wide'][$i]}'
							, as_partner			= '{$_POST['as_partner'][$i]}'
							, as_min				= '{$_POST['as_min'][$i]}'
							, as_max				= '{$_POST['as_max'][$i]}'
							, bo_subject			= '{$_POST['bo_subject'][$i]}'
							where id = '{$_POST['id'][$i]}'
							";
			sql_query($sql);
		}
	} else if($opt == 'del') {
		$cn = $_POST['chk_id'];
		$cnt = count($cn);
		for($i=0; $i < $cnt; $i++) {
			$n = $cn[$i];
			$id = $_POST['id'][$n];
			if(!$id) continue;
			sql_query(" delete from {$g5['apms_page']} where id = '$id' ", false);
		}
	}

	//Move
	goto_url($go_url);
}

//Header
include_once(G5_LIB_PATH.'/apms.widget.lib.php');

$headskin = get_skin_dir('header');

//Group List
$html_gr = array();
$result = sql_query("select gr_id, gr_subject from {$g5['group_table']} order by gr_order", false);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$html_gr[$i][0] = $row['gr_id'];
	$html_gr[$i][1] = $row['gr_subject'];
}

$result = sql_query("select * from {$g5['apms_page']} where as_html = '0' order by gr_id desc, id ");
$row_cnt = @sql_num_rows($result);

?>
<div class="local_ov01 local_ov">
	회원가입, 현재접속자, 새글모음, 전체검색, 마이페이지, 장바구니, 주문서 등
</div>

<form id="pageform" name="pageform" method="post">
<input type="hidden" name="ap" value="bpage">
<input type="hidden" name="mode" value="bpage">
<input type="hidden" name="opt" value="insert">
<div class="tbl_head01 tbl_wrap">
	<ul style="padding:10px 30px; background:#f9f9f9; border:1px solid #f2f2f2; margin-bottom:10px; line-height:20px;">
		<li><b>문서등록</b> - 실행파일 위치는 그누보드 루트를 기준으로 실행파일의 경로와 파일명을 입력하시면 됩니다.</li>
	</ul>
	<table>
	<thead>
	<tr>
	<th class="m-40">*</th>
	<th class="m-100">메뉴등록</th>
	<th class="m-120">PAGE ID</th>
	<th class="m-120">메뉴명</th>
	<th class="m-160">실행파일 위치(/root/)</th>
	<th class="m-160">타이틀</th>
	<th class="m-160">설명글</th>
	<th class="m-100">헤더스킨</th>
	<th class="m-100">헤더컬러</th>
	<th class="m-60">와이드</th>
	<?php if(USE_PARTNER) { ?>
		<th class="m-60">파트너</th>
	<?php } ?>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td align="center"><i class="fa fa-plus"></i></td>
	<td align="center"><?php echo apms_select_arr($html_gr, 'html_gr_id','', '미등록', 100); ?></td>
	<td align="center"><input type="text" name="html_id" size="14" value="" class="frm_input w-max"></td>
	<td align="center"><input type="text" name="bo_subject" size="20" value="" class="frm_input w-max"></td>
	<td><input type="text" name="as_file" size="40" value="" class="frm_input w-max"></td>
	<td><input type="text" name="as_title" size="40" value="" class="frm_input w-max"></td>
	<td><input type="text" name="as_desc" size="40" value="" class="frm_input w-max"></td>
	<td align="center">
		<select name="as_head" style="width:90px;">
			<option value="">사용안함</option>
			<?php
			for ($k=0; $k<count($headskin); $k++) {
				echo "<option value=\"".$headskin[$k]."\">".$headskin[$k]."</option>\n";
			} 
			?>
		</select>
	</td>
	<td align="center">
		<select name="as_hcolor">
			<?php echo apms_color_options('');?>
		</select>
	</td>
	<td align="center"><input type="checkbox" name="as_wide" value="1"></td>
	<?php if(USE_PARTNER) { ?>
		<td align="center"><input type="checkbox" name="as_partner" value="1"></td>
	<?php } ?>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm01 btn_confirm" style="text-align:center;">
	<a href="<?php echo G5_BBS_URL;?>/ficon.php" class="btn_frmline win_memo">아이콘 검색</a>
	<input type="submit" value="등록하기" class="btn_submit">
</div>

</form>

<br><br>

<form id="pagegrouplistform" name="pagegrouplistform" method="post" onsubmit="return apmsform_submit(this);">
<input type="hidden" name="ap" value="bpage">
<input type="hidden" name="mode" value="bpage">
<input type="hidden" name="opt" value="edit">

<div class="tbl_head01 tbl_wrap">
	<ul style="padding:10px 30px; background:#f9f9f9; border:1px solid #f2f2f2; margin-bottom:10px; line-height:20px;">
		<li>PAGE ID($pid)값으로 체크를 하며, 실행파일의 위치는 그누보드 루트를 기준으로 실행파일의 경로와 파일명을 입력하시면 됩니다.</li>
		<li><b>메뉴등록시 선택한 보드그룹의 서브메뉴로 출력되며, 등록 후 메뉴설정 > 그룹/분류 > 서브메뉴설정에서 메뉴보임을 체크하셔야 화면에 출력</b>됩니다.</b></li>
	</ul>
	<table>
	<thead>
	<tr>
	<th class="m-40"><input type="checkbox" class="pagegroup_chk"></th>
	<th class="m-100">메뉴등록</th>
	<th class="m-120">PAGE ID</th>
	<th class="m-120">메뉴명</th>
	<th class="m-160">실행파일 위치(/root/)</th>
	<th class="m-160">타이틀</th>
	<th class="m-160">설명글</th>
	<th class="m-100">헤더스킨</th>
	<th class="m-100">헤더컬러</th>
	<th class="m-80">접근레벨</th>
	<th class="m-100">접근등급</th>
	<th class="m-60">와이드</th>
	<?php if(USE_PARTNER) { ?>
		<th class="m-60">파트너</th>
	<?php } ?>
	<th class="m-40">보기</th>
	</tr>
	</thead>
	<tbody>
	<?php for ($z=0; $row=sql_fetch_array($result); $z++) {	
			$bg = ($z%2 == 0) ? '' : ' bgcolor="#fafafa"';		
	?>
		<tr<?php echo $bg; ?>>
		<td align="center">
			<input type="checkbox" name="chk_id[]" value="<?php echo $z;?>">
			<input type="hidden" name="id[<?php echo $z;?>]" value="<?php echo $row['id'];?>">
		</td>
		<td align="center">
			<?php echo apms_select_arr($html_gr, 'html_gr_id['.$z.']', $row['gr_id'], '미등록', 80); ?>
		</td>
		<td align="center">
			<nobr><?php echo $row['html_id'];?></nobr>
		</td>
		<td align="center">
			<input type="text" name="bo_subject[<?php echo $z;?>]" size="20" value="<?php echo $row['bo_subject'];?>" placeholder="메뉴명" class="frm_input w-max">
		</td>
		<td>
			<input type="text" name="as_file[<?php echo $z;?>]" size="20" value="<?php echo $row['as_file'];?>" class="frm_input w-max">
		</td>
		<td>
			<input type="text" name="as_title[<?php echo $z;?>]" size="25" value="<?php echo $row['as_title'];?>" placeholder="타이틀" class="frm_input w-max">
		</td>
		<td>
			<input type="text" name="as_desc[<?php echo $z;?>]" size="25" value="<?php echo $row['as_desc'];?>" placeholder="설명글" class="frm_input w-max">
		</td>
		<td align="center">
			<select name="as_head[<?php echo $z; ?>]" style="width:90px;">
				<option value="">사용안함</option>
				<?php
				for ($k=0; $k<count($headskin); $k++) {
					echo "<option value=\"".$headskin[$k]."\"".get_selected($row['as_head'], $headskin[$k]).">".$headskin[$k]."</option>\n";
				} 
				?>
			</select>
		</td>
		<td align="center">
			<select name="as_hcolor[<?php echo $z; ?>]">
				<?php echo apms_color_options($row['as_hcolor']);?>
			</select>
		</td>
		<td align="center">
			<nobr><input type="text" name="as_min[<?php echo $z;?>]" size="2" value="<?php echo $row['as_min'];?>" placeholder="From" class="frm_input"> ~ <input type="text" name="as_max[<?php echo $z;?>]" size="2" value="<?php echo $row['as_max'];?>" placeholder="To" class="frm_input"></nobr>
		</td>
		<td align="center">
			<?php echo get_member_level_select("as_grade[".$z."]", 1, 10, $row['as_grade']); ?>
			<select name="as_equal[<?php echo $z; ?>]" style="width:40px;">
				<option value="0">≥</option>
				<option value="1"<?php if($row['as_equal'] == "1") echo " selected";?>>＝</option>
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
			<?php if($row['as_file']) { ?>
				<a href="<?php echo G5_URL;?>/<?php echo $row['as_file'];?>" target="_blank"><i class="fa fa-share fa-lg"></i></a>
			<?php } else { ?>
				-
			<?php } ?>
		</td>
		</tr>
	<?php } ?>
	<?php
    if (!$z) {
		$colspan = (USE_PARTNER) ? 14 : 13;
		echo '<tr><td colspan="'.$colspan.'" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
	}
	?>
	</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm" style="text-align:center;">
	<input type="submit" value="선택삭제" onclick="document.pressed=this.value" class="btn_submit">
	<a href="<?php echo G5_BBS_URL;?>/ficon.php" class="btn_frmline win_memo">아이콘 검색</a>
	<input type="submit" value="일괄저장" onclick="document.pressed=this.value" class="btn_submit">
</div>

</form>

<script>
	function apmsform_submit(f) {

		if(document.pressed == "일괄저장") {
			return true;
		}

		var chk_count = 0;

		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
				chk_count++;
		}

		if (!chk_count) {
			alert(document.pressed + "할 자료를 하나 이상 선택하세요.");
			return false;
		}

		if(document.pressed == "선택삭제") {
			if (!confirm("선택한 자료를 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다."))
				return false;

			f.opt.value = 'del';
			return true;
		}

		return false;
	}

	$(function(){
		$('.pagegroup_chk').click(function(){
			$('#pagegrouplistform input[name="chk_id[]"]').attr('checked', this.checked);
		});
	});

</script>
