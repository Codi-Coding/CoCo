<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록
if($boset['cont'] == "") $boset['cont'] = 100;
if($boset['m_cont'] == "") $boset['m_cont'] = 60;
if($boset['color'] == "") $boset['color'] = 'black';

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
	<td align="center">스타일</td>
	<td>
		<label><input type="checkbox" name="boset[lightbox]" value="1"<?php echo ($boset['lightbox']) ? ' checked' : '';?>> 라이트박스</label>
	</td>
</tr>
<tr>
	<td align="center">목록수</td>
	<td>
		<?php echo help('2단 스타일 사용시 짝수로 입력해 주세요.');?>
		<input type="text" name="bo_page_rows" value="<?php echo $board['bo_page_rows'];?>" size="4" class="frm_input" > 개 - PC
		&nbsp;
		<input type="text" name="bo_mobile_page_rows" value="<?php echo $board['bo_mobile_page_rows'];?>" size="4" class="frm_input" > 개 - 모바일
	</td>
</tr>
<tr>
	<td align="center">썸네일</td>
	<td>
		<?php echo help('썸네일 높이를 0으로 설정해 주세요.');?>
		<input type="text" name="bo_gallery_width" value="<?php echo $board['bo_gallery_width'];?>" size="4" class="frm_input" > 
		x
		<input type="text" name="bo_gallery_height" value="<?php echo $board['bo_gallery_height'];?>" size="4" class="frm_input" > px - PC
		&nbsp;
		<input type="text" name="bo_mobile_gallery_width" value="<?php echo $board['bo_mobile_gallery_width'];?>" size="4" class="frm_input" > 
		x
		<input type="text" name="bo_mobile_gallery_height" value="<?php echo $board['bo_mobile_gallery_height'];?>" size="4" class="frm_input" > px - 모바일
	</td>
</tr>
<tr>
	<td align="center">타임라인</td>
	<td>
		<select name="boset[sep]">
			<option value=""<?php echo get_selected('', $boset['sep']); ?>>월별</option>
			<option value="day"<?php echo get_selected('day', $boset['sep']); ?>>일별</option>
			<option value="year"<?php echo get_selected('year', $boset['sep']); ?>>연별</option>
		</select>
		&nbsp;
		<select name="boset[color]">
			<?php echo apms_color_options($boset['color']);?>
		</select>
		&nbsp;
		<select name="boset[dadan]">
			<option value=""<?php echo get_selected('', $boset['dadan']); ?>>2단 스타일</option>
			<option value=" timeline-one"<?php echo get_selected(' timeline-one', $boset['dadan']); ?>>1단 스타일</option>
		</select>
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
<tr>
	<td align="center">내용길이</td>
	<td>
		<input type="text" name="boset[cont]" value="<?php echo $boset['cont'];?>" size="4" class="frm_input" > 자 - PC
		&nbsp;
		<input type="text" name="boset[m_cont]" value="<?php echo $boset['m_cont'];?>" size="4" class="frm_input" > 자 - 모바일
	</td>
</tr>
<tr>
	<td align="center">출력설정</td>
	<td>
		<select name="boset[shadow]">
			<?php echo apms_shadow_options($boset['shadow']);?>
		</select>
		&nbsp;
		<label><input type="checkbox" name="boset[photo]" value="1"<?php echo ($boset['photo']) ? ' checked' : '';?>> 회원사진출력</label>
		&nbsp;
		<select name="boset[tack]">
			<option value=""<?php echo get_selected('', $boset['tack']); ?>>이미지</option>
			<option value="1"<?php echo get_selected('1', $boset['tack']); ?>>제목</option>
			<option value="2"<?php echo get_selected('2', $boset['tack']); ?>>이미지/제목</option>
		</select>
		라벨
	</td>
</tr>
</tbody>
</table>