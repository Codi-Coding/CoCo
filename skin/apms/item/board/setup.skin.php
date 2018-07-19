<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

if($wset['rgap_r'] == "") $wset['rgap_r'] = 15;
if($wset['rgap_b'] == "") $wset['rgap_b'] = 30;

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
		<td align="center">간격설정</td>
		<td>
			<input type="text" name="wset[rgap_r]" value="<?php echo ($wset['rgap_r']);?>" size="4" class="frm_input"> px 좌우간격
			&nbsp;
			<input type="text" name="wset[rgap_b]" value="<?php echo ($wset['rgap_b']);?>" size="4" class="frm_input"> px 상하간격
		</td>
	</tr>
	<tr>
		<td align="center">그림자</td>
		<td>
			<select name="wset[rshadow]">
				<?php echo apms_shadow_options($wset['rshadow']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">출력설정</td>
		<td>
			<label><input type="checkbox" name="wset[rcmt]" value="1"<?php echo ($wset['rcmt']) ? ' checked' : '';?>> 댓글</label>
			&nbsp;
			<label><input type="checkbox" name="wset[rbuy]" value="1"<?php echo ($wset['rbuy']) ? ' checked' : '';?>> 구매수</label>
			&nbsp;
			<label><input type="checkbox" name="wset[rsns]" value="1"<?php echo ($wset['rsns']) ? ' checked' : '';?>> SNS아이콘</label>
			&nbsp;
			<label><input type="checkbox" name="wset[rstar]" value="1"<?php echo ($wset['rstar']) ? ' checked' : '';?>> 별점</label>
			<select name="wset[rscolor]">
				<?php echo apms_color_options($wset['rscolor']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">새아이템</td>
		<td>
			<input type="text" name="wset[rnewtime]" value="<?php echo ($wset['rnewtime']);?>" size="3" class="frm_input"> 시간 이내 등록 아이템
			&nbsp;
			색상
			<select name="wset[rnew]">
				<?php echo apms_color_options($wset['rnew']);?>
			</select>
		</td>
	</tr>
	</tbody>
	</table>
</div>