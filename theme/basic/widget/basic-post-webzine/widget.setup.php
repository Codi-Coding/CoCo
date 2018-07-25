<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

if(!$wset['new']) $wset['new'] = 'red';

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
		<td align="center">썸네일</td>
		<td>
			<?php echo help('기본 400x300(4:3) - 미입력시 기본값 적용');?>
			<input type="text" name="wset[thumb_w]" value="<?php echo $wset['thumb_w']; ?>" class="frm_input" size="4">
			x
			<input type="text" name="wset[thumb_h]" value="<?php echo $wset['thumb_h']; ?>" class="frm_input" size="4">
			px 
			&nbsp;
			<label><input type="checkbox" name="wset[right]" value="1"<?php echo get_checked('1', $wset['right']); ?>> 우측위치</label>
			&nbsp;
			<label><input type="checkbox" name="wset[vicon]" value="1"<?php echo get_checked('1', $wset['vicon']); ?>> 동영상아이콘 숨김</label>
		</td>
	</tr>
	<tr>
		<td align="center">목록수</td>
		<td>
			<input type="text" name="wset[rows]" value="<?php echo $wset['rows']; ?>" class="frm_input" size="4"> 개 - PC
			&nbsp;
			<input type="text" name="wmset[rows]" value="<?php echo $wmset['rows']; ?>" class="frm_input" size="4"> 개 - 모바일
			&nbsp;
			<input type="text" name="wset[page]" value="<?php echo $wset['page'];?>" size="4" class="frm_input"> 페이지
			&nbsp;
			<select name="wset[main]">
				<option value=""<?php echo get_selected('', $wset['main']); ?>>모든글</option>
				<option value="1"<?php echo get_selected('1', $wset['main']); ?>>메인글</option>
			</select>
			추출
		</td>
	</tr>
	<tr>
		<td align="center">반응형</td>
		<td>
			<table>
			<thead>
			<tr>
				<th scope="col">구분</th>
				<th scope="col">기본</th>
				<th scope="col">lg(1199px~)</th>
				<th scope="col">md(991px~)</th>
				<th scope="col">sm(767px~)</th>
				<th scope="col">xs(480px~)</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td align="center">가로갯수(개)</td>
				<td align="center">
					<input type="text" name="wset[item]" value="<?php echo $wset['item']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[lg]" value="<?php echo $wset['lg']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[md]" value="<?php echo $wset['md']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[sm]" value="<?php echo $wset['sm']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[xs]" value="<?php echo $wset['xs']; ?>" class="frm_input" size="4">
				</td>
			</tr>
			<tr>
				<td align="center">좌우간격(px)</td>
				<td align="center">
					<input type="text" name="wset[gap]" value="<?php echo $wset['gap']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[lgg]" value="<?php echo $wset['lgg']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[mdg]" value="<?php echo $wset['mdg']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[smg]" value="<?php echo $wset['smg']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[xsg]" value="<?php echo $wset['xsg']; ?>" class="frm_input" size="4">
				</td>
			</tr>
			<tr>
				<td align="center">상하간격(px)</td>
				<td align="center">
					<input type="text" name="wset[gapb]" value="<?php echo $wset['gapb']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[lgb]" value="<?php echo $wset['lgb']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[mdb]" value="<?php echo $wset['mdb']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[smb]" value="<?php echo $wset['smb']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[xsb]" value="<?php echo $wset['xsb']; ?>" class="frm_input" size="4">
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">텍스트</td>
		<td>
			<input type="text" name="wset[line]" value="<?php echo $wset['line']; ?>" class="frm_input" size="4"> 줄(기본 3줄)
			&nbsp;
			<label><input type="checkbox" name="wset[cate]" value="1"<?php echo get_checked('1', $wset['cate']);?>> 분류</label>
			&nbsp;
			<label><input type="checkbox" name="wset[bold]" value="1"<?php echo get_checked('1', $wset['bold']); ?>> 볼드체</label>
		</td>
	</tr>
	<tr>
		<td align="center">글링크</td>
		<td>
			<select name="wset[modal]">
				<option value=""<?php echo get_selected('', $wset['modal']);?>>글내용 - 현재창</option>
				<option value="1"<?php echo get_selected('1', $wset['modal']);?>>글내용 - 모달창</option>
				<option value="2"<?php echo get_selected('2', $wset['modal']);?>>링크#1 - 새창</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">날짜출력</td>
		<td>
			<input type="text" name="wset[dtype]" value="<?php echo $wset['dtype'];?>" size="8" class="frm_input" >
			(Y.m.d, Y/m/d 등 날짜타입)
			&nbsp;
			<label><input type="checkbox" name="wset[date]" value="1"<?php echo get_checked('1', $wset['date']);?>> 출력</label>
			&nbsp;
			<label><input type="checkbox" name="wset[dtxt]" value="1"<?php echo get_checked('1', $wset['dtxt']);?>> 몇 초,시간 전 스타일</label>
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
		<td align="center">추출분류</td>
		<td>
			<?php echo help('분류를 콤마(,)로 구분해서 복수 등록 가능, 단일보드 추출시에만 적용됨');?>
			<input type="text" name="wset[ca_list]" value="<?php echo $wset['ca_list']; ?>" size="60" class="frm_input">
		</td>
	</tr>
	<tr>
		<td align="center">제외설정</td>
		<td>
			<label><input type="checkbox" name="wset[except]" value="1"<?php echo get_checked('1', $wset['except']); ?>> 지정한 보드/그룹 제외</label>
			&nbsp;
			<label><input type="checkbox" name="wset[ex_ca]" value="1"<?php echo get_checked('1', $wset['ex_ca']); ?>> 지정한 분류제외</label>
		</td>
	</tr>
	<tr>
		<td align="center">새글설정</td>
		<td>
			<input type="text" name="wset[newtime]" value="<?php echo ($wset['newtime']);?>" size="4" class="frm_input"> 시간 이내 등록 글
			&nbsp;
			색상
			<select name="wset[new]">
				<?php echo apms_color_options($wset['new']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">정렬설정</td>
		<td>
			<select name="wset[sort]">
				<?php echo apms_rank_options($wset['sort']);?>
			</select>
			&nbsp;
			랭크표시
			<select name="wset[rank]">
				<option value=""<?php echo get_selected('', $wset['rank']); ?>>표시안함</option>
				<?php echo apms_color_options($wset['rank']);?>
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
			<input type="text" name="wset[dayterm]" value="<?php echo $wset['dayterm'];?>" size="4" class="frm_input"> 일전까지 자료(일자지정 설정시 적용)
		</td>
	</tr>
	<tr>
		<td align="center">회원지정</td>
		<td>
			<?php echo help('회원아이디를 콤마(,)로 구분해서 복수 등록 가능');?>
			<input type="text" name="wset[mb_list]" value="<?php echo $wset['mb_list']; ?>" size="46" class="frm_input">
			&nbsp;
			<label><input type="checkbox" name="wset[ex_mb]" value="1"<?php echo get_checked('1', $wset['ex_mb']); ?>> 제외하기</label>
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