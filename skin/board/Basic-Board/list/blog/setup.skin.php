<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록
if($boset['cont'] == "") $boset['cont'] = 120;
if($boset['m_cont'] == "") $boset['m_cont'] = 60;
if($boset['color'] == "") $boset['color'] = 'green';

?>
<table>
<caption>목록스킨설정</caption>
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
	<td align="center">목록수</td>
	<td>
		<input type="text" name="bo_page_rows" value="<?php echo $board['bo_page_rows'];?>" size="4" class="frm_input" > 개 - PC
		&nbsp;
		<input type="text" name="bo_mobile_page_rows" value="<?php echo $board['bo_mobile_page_rows'];?>" size="4" class="frm_input" > 개 - 모바일
	</td>
</tr>
<tr>
	<td align="center">출력설정</td>
	<td>
		<select name="boset[shadow]">
			<?php echo apms_shadow_options($boset['shadow']);?>
		</select>
		&nbsp;
		날짜색상
		<select name="boset[color]">
			<?php echo apms_color_options($boset['color']);?>
		</select>
		&nbsp;
		<label><input type="checkbox" name="boset[name]" value="1"<?php echo ($boset['name']) ? ' checked' : '';?>> 이름출력</label>
		&nbsp;
		<select name="boset[tack]">
			<option value=""<?php echo get_selected('', $boset['tack']); ?>>이미지</option>
			<option value="1"<?php echo get_selected('1', $boset['tack']); ?>>제목</option>
			<option value="2"<?php echo get_selected('2', $boset['tack']); ?>>이미지/제목</option>
		</select>
		라벨
	</td>
</tr>
<tr>
	<td align="center">목록내용</td>
	<td>
		<input type="text" name="boset[cont]" value="<?php echo ($boset['cont']);?>" size="4" class="frm_input" > 자 - PC
		&nbsp;
		<input type="text" name="boset[m_cont]" value="<?php echo ($boset['m_cont']);?>" size="4" class="frm_input" > 자 - 모바일
	</td>
</tr>
<tr>
	<td align="center">제목길이</td>
	<td>
		<input type="text" name="bo_subject_len" value="<?php echo $board['bo_subject_len'];?>" size="4" class="frm_input" > 자 - PC
		&nbsp;
		<input type="text" name="bo_mobile_subject_len" value="<?php echo $board['bo_mobile_subject_len'];?>" size="4" class="frm_input" > 자 - 모바일
	</td>
</tr>
</tbody>
</table>