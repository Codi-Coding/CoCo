<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록
if($boset['gap'] == "") $boset['gap'] = 5;
if($boset['min_h'] == "") $boset['min_h'] = 180;

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
	<td align="center">모자이크</td>
	<td>
		<input type="text" name="boset[gap]" value="<?php echo ($boset['gap']);?>" size="4" class="frm_input"> px 간격
		&nbsp;
		최소 높이 <input type="text" name="boset[min_h]" value="<?php echo ($boset['min_h']);?>" size="4" class="frm_input"> px
	</td>
</tr>
<tr>
	<td align="center">날짜출력</td>
	<td>
		<select name="boset[date]">
			<option value=""<?php echo get_selected('', $boset['date']); ?>>출력안함</option>
			<?php echo apms_color_options($boset['date']);?>
		</select>
		&nbsp;
		<label><input type="checkbox" name="boset[trans]" value="1"<?php echo ($boset['trans']) ? ' checked' : '';?>> 반투명표시</label>
		&nbsp;
		<label><input type="checkbox" name="boset[right]" value="1"<?php echo ($boset['right']) ? ' checked' : '';?>> 우측표시</label>
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