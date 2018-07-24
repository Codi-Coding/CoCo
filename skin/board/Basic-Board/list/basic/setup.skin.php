<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록

if(!$boset['hcolor']) $boset['hcolor'] = 'black';

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
	<td align="center">목록헤드</td>
	<td>
		<select name="boset[hskin]">
			<option value="">기본헤드</option>
		<?php
			$skinlist = apms_skin_file_list(G5_PATH.'/css/head', 'css');
			for ($k=0; $k<count($skinlist); $k++) {
				echo "<option value=\"".$skinlist[$k]."\"".get_selected($skinlist[$k], $boset['hskin']).">".$skinlist[$k]."</option>\n";
			} 
		?>
		</select>
		&nbsp;
		기본컬러	
		<select name="boset[hcolor]">
			<?php echo apms_color_options($boset['hcolor']);?>
		</select>
	</td>
</tr>
<tr>
	<td align="center">목록갯수</td>
	<td>
		<input type="text" name="bo_page_rows" value="<?php echo $board['bo_page_rows'];?>" size="4" class="frm_input" > 개 - PC
		&nbsp;
		<input type="text" name="bo_mobile_page_rows" value="<?php echo $board['bo_mobile_page_rows'];?>" size="4" class="frm_input" > 개 - 모바일
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
	<td align="center">보임설정</td>
	<td>
		<label><input type="checkbox" name="boset[lcate]" value="1"<?php echo get_checked('1', $boset['lcate']);?>> 분류</label>
		&nbsp;
		<label><input type="checkbox" name="boset[lthumb]" value="1"<?php echo get_checked('1', $boset['lthumb']);?>> 포토</label>
		&nbsp;
		<label><input type="checkbox" name="boset[ldown]" value="1"<?php echo get_checked('1', $boset['ldown']);?>> 다운</label>
		&nbsp;
		<label><input type="checkbox" name="boset[lvisit]" value="1"<?php echo get_checked('1', $boset['lvisit']);?>> 방문</label>
		&nbsp;
		<label><input type="checkbox" name="boset[lgood]" value="1"<?php echo get_checked('1', $boset['lgood']);?>> 추천</label>
		&nbsp;
		<label><input type="checkbox" name="boset[lnogood]" value="1"<?php echo get_checked('1', $boset['lnogood']);?>> 비추</label>
	</td>
</tr>
<tr>
	<td align="center">숨김설정</td>
	<td>
		<label><input type="checkbox" name="boset[lnum]" value="1"<?php echo get_checked('1', $boset['lnum']);?>> 번호</label>
		&nbsp;
		<label><input type="checkbox" name="boset[lname]" value="1"<?php echo get_checked('1', $boset['lname']);?>> 이름</label>
		&nbsp;
		<label><input type="checkbox" name="boset[ldate]" value="1"<?php echo get_checked('1', $boset['ldate']);?>> 날짜</label>
		&nbsp;
		<label><input type="checkbox" name="boset[lhit]" value="1"<?php echo get_checked('1', $boset['lhit']);?>> 조회</label>
	</td>
</tr>
<tr>
	<td align="center">기타설정</td>
	<td>
		<label><input type="checkbox" name="boset[vicon]" value="1"<?php echo get_checked('1', $boset['vicon']);?>> 포토에 동영상 표시 아이콘 출력안함</label>
	</td>
</tr>
</tbody>
</table>