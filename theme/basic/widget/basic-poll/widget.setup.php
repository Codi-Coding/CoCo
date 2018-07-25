<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

if(!$wset['poll']) $wset['poll'] = 'navy';
if(!$wset['result']) $wset['result'] = 'lightgray';
if(!$wset['admin']) $wset['admin'] = 'lightgray';

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
		<td align="center">글아이콘</td>
		<td>
			<input type="text" name="wset[icon]" id="fcon" value="<?php echo ($wset['icon']);?>" size="50" class="frm_input"> 
			<a href="<?php echo G5_BBS_URL;?>/ficon.php?fid=fcon" class="btn_frmline win_scrap">아이콘 선택</a>
		</td>
	</tr>
	<tr>
		<td align="center">버튼컬러</td>
		<td>
			<select name="wset[poll]">
				<?php echo apms_color_options($wset['poll']);?>
			</select>
			투표
			&nbsp;
			<select name="wset[result]">
				<?php echo apms_color_options($wset['result']);?>
			</select>
			결과
			&nbsp;
			<select name="wset[admin]">
				<?php echo apms_color_options($wset['admin']);?>
			</select>
			관리
		</td>
	</tr>
	<tr>
		<td align="center">추출투표</td>
		<td>
			<input type="text" name="wset[rows]" value="<?php echo $wset['rows']; ?>" class="frm_input" size="3"> 개 - PC
			&nbsp;
			<input type="text" name="wmset[rows]" value="<?php echo $wmset['rows']; ?>" class="frm_input" size="3"> 개 - 모바일
			&nbsp;
			<label><input type="checkbox" name="wset[rdm]" value="1"<?php echo get_checked('1', $wset['rdm']);?>> 투표섞기</label>
		</td>
	</tr>
	<tr>
		<td align="center">투표지정</td>
		<td>
			<?php echo help('투표아이디(po_id)를 콤마(,)로 구분해서 복수 등록 가능');?>
			<input type="text" name="wset[po_list]" value="<?php echo $wset['po_list']; ?>" size="46" class="frm_input">
			&nbsp;
			<label><input type="checkbox" name="wset[except]" value="1"<?php echo get_checked('1', $wset['except']);?>> 제외하기</label>
		</td>
	</tr>
	</tbody>
	</table>
</div>