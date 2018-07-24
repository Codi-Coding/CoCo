<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록

$skinlist = array();

$boset['list_skin'] = (isset($boset['list_skin']) && $boset['list_skin']) ? $boset['list_skin'] : 'basic';
$boset['view_skin'] = (isset($boset['view_skin']) && $boset['view_skin']) ? $boset['view_skin'] : 'basic';
$boset['write_skin'] = (isset($boset['write_skin']) && $boset['write_skin']) ? $boset['write_skin'] : 'basic';

?>
<script>
function apms_change_skin(id, type, skin) {
	$.get("./board.skin.php?bo_table=<?php echo $bo_table;?>&type="+type+"&skin="+skin, function (data) {
		$("#"+id).html(data);
	});
}
$(function(){
	$("#howto").click(function() {
		$("#guide").toggle();
	});
});
</script>
<div class="tbl_head01 tbl_wrap">

	<p><b>■ 보드설정</b></p>
	<table>
	<caption>보드설정</caption>
	<colgroup>
		<col class="grid_2">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">구분</th>
		<th scope="col">설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center">
			헤더출력
		</td>
		<td>
			<select name="boset[header_skin]">
				<option value="">사용안함</option>
				<?php
					$skinlist = get_skin_dir('header');
					for ($k=0; $k<count($skinlist); $k++) {
						echo "<option value=\"".$skinlist[$k]."\"".get_selected($skinlist[$k], $boset['header_skin']).">".$skinlist[$k]."</option>\n";
					} 
				?>
			</select>
			&nbsp;
			<select name="boset[header_color]">
				<?php echo apms_color_options($boset['header_color']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">목록링크</td>
		<td>
			<select name="boset[modal]">
				<option value=""<?php echo get_selected('', $boset['modal']);?>>글내용 - 현재창</option>
				<option value="1"<?php echo get_selected('1', $boset['modal']);?>>글내용 - 모달창</option>
				<option value="2"<?php echo get_selected('2', $boset['modal']);?>>링크#1 - 새창</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">상단검색</td>
		<td>
			<select name="boset[tsearch]">
				<option value="">사용안함</option>
				<?php echo apms_color_options($boset['tsearch']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">정렬추가</td>
		<td>
			<label><input type="checkbox" name="boset[scmt]" value="1"<?php echo get_checked('1', $boset['scmt']);?>> 댓글순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[sdload]" value="1"<?php echo get_checked('1', $boset['sdload']);?>> 다운순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[svisit]" value="1"<?php echo get_checked('1', $boset['svisit']);?>> 방문순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[spoll]" value="1"<?php echo get_checked('1', $boset['spoll']);?>> 참여순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[supdate]" value="1"<?php echo get_checked('1', $boset['supdate']);?>> 업데이트순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[sdown]" value="1"<?php echo get_checked('1', $boset['sdown']);?>> 다운점수순</label>
		</td>
	</tr>
	<tr>
		<td align="center" rowspan="2">카테고리</td>
		<td>
			<select name="boset[tab]">
				<?php echo apms_tab_options($boset['tab']);?>
			</select>
			&nbsp;
			<label><input type="checkbox" name="boset[tabline]" value="1"<?php echo get_checked($boset['tabline'], '1');?>> 일반탭 상단라인 출력</label>
			-
			탭/버튼컬러
			<select name="boset[mctab]">
				<?php echo apms_color_options($boset['mctab']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<label><input type="radio" name="boset[ctype]" value=""<?php echo get_checked('', $boset['ctype']);?>> 일반형</label>
			&nbsp;
			<label><input type="radio" name="boset[ctype]" value="1"<?php echo get_checked('1', $boset['ctype']);?>> 배분형</label>
			&nbsp;
			<label><input type="radio" name="boset[ctype]" value="2"<?php echo get_checked('2', $boset['ctype']);?>> 분할형</label>
			-
			가로 최대 <input type="text" name="boset[bunhal]" value="<?php echo $boset['bunhal'];?>" size="2" class="frm_input"> 개 출력
		</td>
	</tr>
	<tr>
		<td align="center">버튼컬러</td>
		<td>
			<select name="boset[btn1]">
				<option value="">기본컬러</option>
				<?php echo apms_color_options($boset['btn1']);?>
			</select>
			&nbsp;
			주버튼컬러
			<select name="boset[btn2]">
				<option value="">기본컬러</option>
				<?php echo apms_color_options($boset['btn2']);?>
			</select>

		</td>
	</tr>
	<tr>
		<td align="center">포토컬러</td>
		<td>
			<select name="boset[icolor]">
				<?php echo apms_color_options($boset['icolor']);?>
			</select>
			&nbsp;
			<label><input type="checkbox" name="boset[ibg]" value="1"<?php echo get_checked('1', $boset['ibg']);?>> 배경색으로 적용</label>
		</td>
	</tr>
	<tr>
		<td align="center">대표포토</td>
		<td>
			<input type="text" name="boset[ficon]" id="ficon" value="<?php echo ($boset['ficon']);?>" size="30" class="frm_input"> 
			<a href="<?php echo G5_BBS_URL;?>/ficon.php?fid=ficon" class="btn_frmline win_scrap">아이콘 선택</a>
		</td>
	</tr>
	<tr>
		<td align="center">영상너비</td>
		<td>
			<?php echo help('본문 동영상 최대 너비로 미설정시 APMS 기본설정값이 적용됨');?>
			<input type="text" name="boset[video]" value="<?php echo $boset['video'];?>" size="8" class="frm_input" placeholder="ex) 800px"> % 또는 px 단위까지 입력
		</td>
	</tr>
	<tr>
		<td align="center">댓글설정</td>
		<td>
			회원사진
			<select name="boset[cmt_photo]">
				<option value=""<?php echo get_selected('', $boset['cmt_photo']); ?>>모두출력</option>
				<option value="1"<?php echo get_selected('1', $boset['cmt_photo']); ?>>PC만</option>
				<option value="2"<?php echo get_selected('2', $boset['cmt_photo']); ?>>모바일만</option>
				<option value="3"<?php echo get_selected('3', $boset['cmt_photo']); ?>>출력안함</option>
			</select>
			&nbsp;
			대댓글 이름
			<select name="boset[cmt_re]">
				<option value=""<?php echo get_selected('', $boset['cmt_re']); ?>>출력안함</option>
				<option value="1"<?php echo get_selected('1', $boset['cmt_re']); ?>>모두</option>
				<option value="2"<?php echo get_selected('2', $boset['cmt_re']); ?>>PC만</option>
				<option value="3"<?php echo get_selected('3', $boset['cmt_re']); ?>>모바일만</option>
			</select>
			&nbsp;
			<label><input type="checkbox" name="boset[cgood]" value="1"<?php echo get_checked('1', $boset['cgood']);?>> 댓글추천</label>
			&nbsp;
			<label><input type="checkbox" name="boset[cnogood]" value="1"<?php echo get_checked('1', $boset['cnogood']);?>> 비추천</label>
		</td>
	</tr>
	<tr>
		<td align="center">태그등록</td>
		<td>
			<select name="boset[tag]">
				<option value="">관리자</option>
				<?php echo apms_grade_options($boset['tag']);?>
			</select>
			등급 이상 회원만 태그등록 허용
		</td>
	</tr>
	</tbody>
	</table>

	<br><br>

	<p>
		<b>■ 목록스킨</b>
		&nbsp;
		<select name="boset[list_skin]" onchange="apms_change_skin('list_skin', 'list', this.value);">
		<?php
			unset($skinlist);
			$skinlist = get_skin_dir('list', $board_skin_path);
			$boset['list_skin'] = (is_dir($board_skin_path.'/list/'.$boset['list_skin'])) ? $boset['list_skin'] : $skinlist[0];
			for ($k=0; $k<count($skinlist); $k++) {
				echo "<option value=\"".$skinlist[$k]."\"".get_selected($skinlist[$k], $boset['list_skin']).">".$skinlist[$k]."</option>\n";
			} 
		?>
		</select>
	</p>
	<div id="list_skin">
		<?php @include_once($board_skin_path.'/list/'.$boset['list_skin'].'/setup.skin.php');?>
	</div>

	<br><br>

	<p>
		<b>■ 내용스킨</b>
		&nbsp;
		<select name="boset[view_skin]" onchange="apms_change_skin('view_skin', 'view', this.value);">
		<?php
			unset($skinlist);
			$skinlist = get_skin_dir('view', $board_skin_path);
			$boset['view_skin'] = (is_dir($board_skin_path.'/view/'.$boset['view_skin'])) ? $boset['view_skin'] : $skinlist[0];
			for ($k=0; $k<count($skinlist); $k++) {
				echo "<option value=\"".$skinlist[$k]."\"".get_selected($skinlist[$k], $boset['view_skin']).">".$skinlist[$k]."</option>\n";
			} 
		?>
		</select>
	</p>
	<div id="view_skin">
		<?php @include_once($board_skin_path.'/view/'.$boset['view_skin'].'/setup.skin.php');?>
	</div>

	<br><br>

	<p>
		<b>■ 쓰기스킨</b>
		&nbsp;
		<select name="boset[write_skin]" onchange="apms_change_skin('write_skin', 'write', this.value);">
		<?php
			unset($skinlist);
			$skinlist = get_skin_dir('write', $board_skin_path);
			$boset['write_skin'] = (is_dir($board_skin_path.'/write/'.$boset['write_skin'])) ? $boset['write_skin'] : $skinlist[0];
			for ($k=0; $k<count($skinlist); $k++) {
				echo "<option value=\"".$skinlist[$k]."\"".get_selected($skinlist[$k], $boset['write_skin']).">".$skinlist[$k]."</option>\n";
			} 
		?>
		</select>
	</p>
	<div id="write_skin">
		<?php @include_once($board_skin_path.'/write/'.$boset['write_skin'].'/setup.skin.php');?>
	</div>

	<br><br>


</div>