<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록
if($boset['gap_r'] == "") $boset['gap_r'] = 15;
if($boset['gap_b'] == "") $boset['gap_b'] = 40;
if(!$boset['icolor']) $boset['icolor'] = 'green';
if($boset['cont'] == "") $boset['cont'] = 100;
if($boset['m_cont'] == "") $boset['m_cont'] = 60;

?>
<input type="hidden" name="boset[as_icon]" value="1">
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
		<label><input type="checkbox" name="boset[masonry]" value="1"<?php echo ($boset['masonry']) ? ' checked' : '';?>> 메이선리</label>
		&nbsp;
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
		<?php echo help('메이선리 적용시 썸네일 높이를 0으로 설정해 주세요.');?>
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
	<td align="center">이미지</td>
	<td>
		<select name="boset[shadow]">
			<?php echo apms_shadow_options($boset['shadow']);?>
		</select>
		&nbsp;
		가로수
		<input type="text" name="bo_gallery_cols" value="<?php echo $board['bo_gallery_cols'];?>" size="4" class="frm_input" > 개 - PC
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
	<td align="center">간격설정</td>
	<td>
		<input type="text" name="boset[gap_r]" value="<?php echo ($boset['gap_r']);?>" size="4" class="frm_input"> px 좌우간격
		&nbsp;
		<input type="text" name="boset[gap_b]" value="<?php echo ($boset['gap_b']);?>" size="4" class="frm_input"> px 상하간격
	</td>
</tr>
<tr>
	<td align="center">아이콘색</td>
	<td>
		<select name="boset[icolor]">
			<?php echo apms_color_options($boset['icolor']);?>
		</select>
		&nbsp;
		<label><input type="checkbox" name="boset[ibg]" value="1"<?php echo ($boset['ibg']) ? ' checked' : '';?>> 배경색으로 적용</label>
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
</tbody>
</table>