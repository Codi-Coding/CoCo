<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

if(!$wset['cont']) $wset['cont'] = 60;
if(!$wmset['cont']) $wmset['cont'] = 60;
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
		<td align="center">내용길이</td>
		<td>
			<input type="text" name="wset[cont]" value="<?php echo ($wset['cont']);?>" size="4" class="frm_input"> 자 - PC
			&nbsp;
			<input type="text" name="wmset[cont]" value="<?php echo ($wmset['cont']);?>" size="4" class="frm_input"> 자 - 모바일
		</td>
	</tr>
	</tbody>
	</table>
</div>