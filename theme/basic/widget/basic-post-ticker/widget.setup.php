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
		<td align="center">가로수</td>
		<td>
			<input type="text" name="wset[item]" value="<?php echo $wset['item']; ?>" class="frm_input" size="4"> 개
			(기본 1개, 반응형 기본 lg 1개, md 1개, sm 1개, xs 1개)
			<div class="h10"></div>
			<table>
			<thead>
			<tr>
				<th scope="col">구분</th>
				<th scope="col">lg(1199px~)</th>
				<th scope="col">md(991px~)</th>
				<th scope="col">sm(767px~)</th>
				<th scope="col">xs(480px~)</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td align="center">가로(개)</td>
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
			</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">글제목</td>
		<td>
			<input type="text" name="wset[gap]" value="<?php echo ($wset['gap']);?>" size="4" class="frm_input"> px 간격(기본 20)
			-
			글링크
			<select name="wset[modal]">
				<option value=""<?php echo get_selected('', $wset['modal']);?>>글내용 - 현재창</option>
				<option value="1"<?php echo get_selected('1', $wset['modal']);?>>글내용 - 모달창</option>
				<option value="2"<?php echo get_selected('2', $wset['modal']);?>>링크#1 - 새창</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">글아이콘</td>
		<td>
			<input type="text" name="wset[icon]" id="fcon" value="<?php echo ($wset['icon']);?>" size="50" class="frm_input"> 
			<a href="<?php echo G5_BBS_URL;?>/ficon.php?fid=fcon" class="btn_frmline win_scrap">아이콘 선택</a>
		</td>
	</tr>
	<tr>
		<td align="center">제목강조</td>
		<td>
			<?php echo help('강조하는 글의 순번을 콤마(,)로 구분해서 등록. 바(|)를 이용하여 red, blue, green, crimson, orangred 등의 기본 컬러설정 가능. ex) 1|red,4|blue,6');?>
			<input type="text" name="wset[strong]" value="<?php echo ($wset['strong']);?>" size="60" class="frm_input"> 
		</td>
	</tr>
	<tr>
		<td align="center">날짜모양</td>
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
		<td align="center">자동실행</td>
		<td>
			<?php echo help('밀리초(ms)는 천분의 1초입니다. ex) 3초 = 3000ms');?>
			<input type="text" name="wset[auto]" value="<?php echo $wset['auto']; ?>" class="frm_input" size="4"> ms - PC 
			&nbsp;
			<input type="text" name="wmset[auto]" value="<?php echo $wmset['auto']; ?>" class="frm_input" size="4"> ms - 모바일 (기본 3000, 0 입력시 미실행) 

		</td>
	</tr>
	<tr>
		<td align="center">슬라이더</td>
		<td>
			<input type="text" name="wset[speed]" value="<?php echo $wset['speed']; ?>" class="frm_input" size="4"> ms 속도(기본 200)
			&nbsp;
			<label><input type="checkbox" name="wset[rdm]" value="1"<?php echo get_checked('1', $wset['rdm']); ?>> 랜덤</label>
		</td>
	</tr>
	<tr>
		<td align="center">추출글수</td>
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