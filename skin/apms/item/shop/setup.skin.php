<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

if(!$wset['new']) $wset['new'] = 'red';
if(!$wset['btn1']) $wset['btn1'] = 'black';
if(!$wset['btn2']) $wset['btn2'] = 'color';
if(!$wset['ucont']) $wset['ucont'] = 60;
if(!$wmset['ucont']) $wmset['ucont'] = 60;
if(!$wset['qcont']) $wset['qcont'] = 60;
if(!$wmset['qcont']) $wmset['qcont'] = 60;

?>

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption>스킨설정</caption>
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
			네비컬러
		</td>
		<td>
			<select name="wset[ncolor]">
				<?php echo apms_color_options($wset['ncolor']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">버튼컬러</td>
		<td>
			<select name="wset[btn1]">
				<option value="">기본컬러</option>
				<?php echo apms_color_options($wset['btn1']);?>
			</select>
			&nbsp;
			주버튼
			<select name="wset[btn2]">
				<option value="">기본컬러</option>
				<?php echo apms_color_options($wset['btn2']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">그림자</td>
		<td>
			<select name="wset[shadow]">
				<?php echo apms_shadow_options($wset['shadow']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">판매자</td>
		<td>
			<label><input type="checkbox" name="wset[seller]" value="1"<?php echo ($wset['seller']) ? ' checked' : '';?>> 판매자 정보를 출력합니다.</label>
		</td>
	</tr>
	<tr>
		<td align="center">후기길이</td>
		<td>
			<input type="text" name="wset[ucont]" value="<?php echo ($wset['ucont']);?>" size="4" class="frm_input"> 자 - PC
			&nbsp;
			<input type="text" name="wmset[ucont]" value="<?php echo ($wmset['ucont']);?>" size="4" class="frm_input"> 자 - 모바일
		</td>
	</tr>
	<tr>
		<td align="center">문의길이</td>
		<td>
			<input type="text" name="wset[qcont]" value="<?php echo ($wset['qcont']);?>" size="4" class="frm_input"> 자 - PC
			&nbsp;
			<input type="text" name="wmset[qcont]" value="<?php echo ($wmset['qcont']);?>" size="4" class="frm_input"> 자 - 모바일
		</td>
	</tr>
	<tr>
		<td align="center">댓글설정</td>
		<td>
			회원사진
			<select name="wset[cmt_photo]">
				<option value=""<?php echo get_selected('', $wset['cmt_photo']); ?>>모두</option>
				<option value="1"<?php echo get_selected('1', $wset['cmt_photo']); ?>>PC만</option>
				<option value="2"<?php echo get_selected('2', $wset['cmt_photo']); ?>>모바일만</option>
				<option value="3"<?php echo get_selected('3', $wset['cmt_photo']); ?>>출력안함</option>
			</select>
			&nbsp;
			대댓글 이름
			<select name="wset[cmt_re]">
				<option value=""<?php echo get_selected('', $wset['cmt_re']); ?>>출력안함</option>
				<option value="1"<?php echo get_selected('1', $wset['cmt_re']); ?>>모두</option>
				<option value="2"<?php echo get_selected('2', $wset['cmt_re']); ?>>PC만</option>
				<option value="3"<?php echo get_selected('3', $wset['cmt_re']); ?>>모바일만</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="bg-light"><b>관련아이템 설정</b></td>
	</tr>
	<tr>
		<td align="center">썸네일</td>
		<td>
			<?php echo help('기본 400x540 - 미입력시 기본값 적용');?>
			<input type="text" name="wset[thumb_w]" value="<?php echo $wset['thumb_w']; ?>" class="frm_input" size="4">
			x
			<input type="text" name="wset[thumb_h]" value="<?php echo $wset['thumb_h']; ?>" class="frm_input" size="4">
			px 
			- 간격
			<input type="text" name="wset[gap]" value="<?php echo $wset['gap']; ?>" class="frm_input" size="4"> px (기본 15)
			&nbsp;
			<select name="wset[rshadow]">
				<?php echo apms_shadow_options($wset['rshadow']);?>
			</select>
			&nbsp;
			<label><input type="checkbox" name="wset[rinshadow]" value="1"<?php echo get_checked('1', $wset['rinshadow']); ?>> 내부그림자</label>
		</td>
	</tr>
	<tr>
		<td align="center">가로수</td>
		<td>
			<input type="text" name="wset[item]" value="<?php echo $wset['item']; ?>" class="frm_input" size="4"> 개
			(기본 4개, 반응형 기본 lg 3개, md 3개, sm 2개, xs 2개)
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
		<td align="center">출력설정</td>
		<td>
			<input type="text" name="wset[line]" value="<?php echo $wset['line']; ?>" class="frm_input" size="4"> 줄(기본 2)
			&nbsp;
			<label><input type="checkbox" name="wset[hit]" value="1"<?php echo get_checked('1', $wset['hit']);?>> 조회</label>
			&nbsp;
			<label><input type="checkbox" name="wset[cmt]" value="1"<?php echo get_checked('1', $wset['cmt']);?>> 댓글</label>
			&nbsp;
			<label><input type="checkbox" name="wset[buy]" value="1"<?php echo get_checked('1', $wset['buy']);?>> 구매</label>
			&nbsp;
			<label><input type="checkbox" name="wset[sns]" value="1"<?php echo get_checked('1', $wset['sns']);?>> SNS</label>
			&nbsp;
			<select name="wset[star]">
				<option value="">별점</option>
				<?php echo apms_color_options($wset['star']);?>
			</select>
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
			&nbsp;
			<label><input type="checkbox" name="wset[dot]" value="1"<?php echo get_checked('1', $wset['dot']); ?>> 페이징</label>
			&nbsp;
			<label><input type="checkbox" name="wset[lazy]" value="1"<?php echo get_checked('1', $wset['lazy']); ?>> Lazy</label>
			&nbsp;
			<label><input type="checkbox" name="wset[nav]" value="1"<?php echo get_checked('1', $wset['nav']); ?>> 화살표</label>
		</td>
	</tr>
	<tr>
		<td align="center">새아이템</td>
		<td>
			<input type="text" name="wset[newtime]" value="<?php echo ($wset['newtime']);?>" size="3" class="frm_input"> 시간 이내 등록 아이템
			&nbsp;
			색상
			<select name="wset[new]">
				<?php echo apms_color_options($wset['new']);?>
			</select>
		</td>
	</tr>
	</tbody>
	</table>
</div>