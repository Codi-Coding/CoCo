<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록

if($boset['gap_r'] == "") $boset['gap_r'] = 15;
if($boset['gap_b'] == "") $boset['gap_b'] = 30;

?>

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption>보드스킨설정</caption>
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
		<td align="center">간격설정</td>
		<td>
			<input type="text" name="boset[gap_r]" value="<?php echo ($boset['gap_r']);?>" size="4" class="frm_input"> px 좌우간격
			&nbsp;
			<input type="text" name="boset[gap_b]" value="<?php echo ($boset['gap_b']);?>" size="4" class="frm_input"> px 상하간격
		</td>
	</tr>
	<tr>
		<td align="center" rowspan="2">카테고리</td>
		<td>
			<select name="boset[tab]">
				<?php echo apms_tab_options($boset['tab']);?>
			</select>
			&nbsp;
			<label><input type="checkbox" name="boset[tabline]" value="1" <?php echo ($boset['tabline']) ? ' checked' : '';?>> 일반탭 상단라인 출력</label>
		</td>
	</tr>
	<tr>
		<td>
			<label><input type="radio" name="boset[ctype]" value="" <?php echo (!$boset['ctype']) ? ' checked' : '';?>> 일반형</label>
			&nbsp;
			<label><input type="radio" name="boset[ctype]" value="1"<?php echo ($boset['ctype'] == "1") ? ' checked' : '';?>> 배분형</label>
			&nbsp;
			<label><input type="radio" name="boset[ctype]" value="2"<?php echo ($boset['ctype'] == "2") ? ' checked' : '';?>> 분할형</label>
			-
			가로 최대 <input type="text" name="boset[bunhal]" value="<?php echo ($boset['bunhal']);?>" size="2" class="frm_input"> 개 출력
		</td>
	</tr>
	<tr>
		<td align="center">출력설정</td>
		<td>
			<select name="boset[shadow]">
				<?php echo apms_shadow_options($boset['shadow']);?>
			</select>
			&nbsp;
			<label><input type="checkbox" name="boset[sort]" value="1"<?php echo ($boset['sort']) ? ' checked' : '';?>> 글정렬버튼</label>

		</td>
	</tr>
	<tr>
		<td align="center">영상너비</td>
		<td>
			<?php echo help('본문 동영상 최대 너비로 미설정시 APMS 기본설정값이 적용됨');?>
			<input type="text" name="boset[video]" value="<?php echo ($boset['video']);?>" size="8" class="frm_input" placeholder="ex) 800px"> % 또는 px 단위까지 입력
		</td>
	</tr>
	<tr>
		<td align="center">댓글설정</td>
		<td>
			회원사진
			<select name="boset[cmt_photo]">
				<option value=""<?php echo get_selected('', $boset['cmt_photo']); ?>>모두</option>
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
			<label><input type="checkbox" name="boset[cgood]" value="1"<?php echo ($boset['cgood']) ? ' checked' : '';?>> 추천</label>
			&nbsp;
			<label><input type="checkbox" name="boset[cnogood]" value="1"<?php echo ($boset['cnogood']) ? ' checked' : '';?>> 비추천</label>
		</td>
	</tr>
	<tr>
		<td align="center">태그등록</td>
		<td>
			<select name="boset[tag]">
				<?php echo apms_grade_options($boset['tag']);?>
			</select>
			등급 이상 회원만 가능
		</td>
	</tr>
	</tbody>
	</table>
</div>