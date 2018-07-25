<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

if(!$wset['mode']) $wset['mode'] = 'np';

?>

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption>위젯설정</caption>
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
		<td align="center">추출갯수</td>
		<td>
			<input type="text" name="wset[rows]" value="<?php echo $wset['rows']; ?>" class="frm_input" size="3"> 개 - PC
			&nbsp;
			<input type="text" name="wmset[rows]" value="<?php echo $wmset['rows']; ?>" class="frm_input" size="3"> 개 - 모바일
			&nbsp;
			<input type="text" name="wset[page]" value="<?php echo $wset['page'];?>" size="3" class="frm_input"> 페이지 자료
		</td>
	</tr>
	<tr>
		<td align="center">추출모드</td>
		<td>
			<select name="wset[mode]">
				<?php echo apms_member_options($wset['mode']);?>
			</select>
			&nbsp;
			<label>
				<input type="checkbox" name="wset[cnt]" value="1"<?php echo get_checked('1', $wset['cnt']); ?>> 포인트 등 통계값 출력
			</label>
		</td>
	</tr>
	<tr>
		<td align="center">제외등급</td>
		<td>
			<?php echo help('제외 회원등급을 콤마(,)로 구분해서 복수 등록 가능 - 일부 모드 적용안됨');?>
			<input type="text" name="wset[ex_grade]" value="<?php echo $wset['ex_grade']; ?>" size="60" class="frm_input">
		</td>
	</tr>
	<tr>
		<td align="center">제외회원</td>
		<td>
			<?php echo help('제외 회원아이디를 콤마(,)로 구분해서 복수 등록 가능');?>
			<input type="text" name="wset[ex_mb]" value="<?php echo $wset['ex_mb']; ?>" size="60" class="frm_input">
		</td>
	</tr>
	<tr>
		<td align="center">출석보드</td>
		<td>
			<?php echo help('출석부 보드아이디 1개만 등록 가능');?>
			<input type="text" name="wset[bo_table]" value="<?php echo $wset['bo_table']; ?>" size="60" class="frm_input">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td align="center">추출보드</td>
		<td>
			<?php echo help('보드아이디를 콤마(,)로 구분해서 복수 등록 가능, 미입력시 전체 게시판 적용');?>
			<input type="text" name="wset[bo_list]" value="<?php echo $wset['bo_list']; ?>" size="60" class="frm_input">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td align="center">추출그룹</td>
		<td>
			<?php echo help('그룹아이디를 콤마(,)로 구분해서 복수 등록 가능, 설정시 추출보드는 적용안됨');?>
			<input type="text" name="wset[gr_list]" value="<?php echo $wset['gr_list']; ?>" size="60" class="frm_input">
		</td>
	</tr>
	<tr>
		<td align="center">제외설정</td>
		<td>
			<label><input type="checkbox" name="wset[except]" value="1"<?php echo get_checked('1', $wset['except']);?>> 지정한 보드/그룹 제외</label>
		</td>
	</tr>
	<tr>
		<td align="center">아이콘</td>
		<td>
			<input type="text" name="wset[icon]" id="fcon" value="<?php echo ($wset['icon']);?>" size="30" class="frm_input"> 
			<a href="<?php echo G5_BBS_URL;?>/icon.php?fid=fcon" class="btn_frmline win_scrap">아이콘 선택</a>
			&nbsp;
			<select name="wset[icolor]">
				<option value=""<?php echo get_selected('', $wset['icolor']); ?>>기본컬러</option>
				<?php echo apms_color_options($wset['icolor']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">기간설정</td>
		<td>
			<select name="wset[term]">
				<?php echo apms_term_options($wset['term']);?>
			</select>
			&nbsp;
			<input type="text" name="wset[dayterm]" value="<?php echo $wset['dayterm'];?>" size="3" class="frm_input"> 일전까지 자료(일자지정 설정시 적용)
		</td>
	</tr>
	<tr>
		<td align="center">랭크표시</td>
		<td>
			<select name="wset[rank]">
				<option value=""<?php echo get_selected('', $wset['rank']); ?>>표시안함</option>
				<?php echo apms_color_options($wset['rank']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">캐시사용</td>
		<td>
			<input type="text" name="wset[cache]" value="<?php echo $wset['cache']; ?>" class="frm_input" size="4"> 초 간격으로 캐싱
		</td>
	</tr>
	</tbody>
	</table>
</div>