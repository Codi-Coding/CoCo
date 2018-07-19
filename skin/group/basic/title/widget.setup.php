<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

if(!$wset['slider']) $wset['slider'] = 0;
if(!$wset['slider_h']) $wset['slider_h'] = 35;
if(!$wmset['slider_h']) $wmset['slider_h'] = 60;
?>

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption>위젯설정</caption>
	<colgroup>
		<col class="grid_1">
		<col class="grid_2">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col" colspan="2">구분</th>
		<th scope="col">설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center" rowspan="3">공통</td>
		<td align="center">스타일</td>
		<td>
			<?php echo help('밀리초(ms)는 천분의 1초입니다. ex) 5초 = 5000ms');?>
			<select name="wset[effect]">
				<?php echo apms_carousel_options($wset['effect']);?>
			</select>
			<input type="text" name="wset[interval]" value="<?php echo $wset['interval']; ?>" class="frm_input" size="4"> ms 간격
			&nbsp;
			<select name="wset[shadow]">
				<?php echo apms_shadow_options($wset['shadow']);?>
			</select>
			&nbsp;
			<label><input type="checkbox" name="wset[nav]" value="1"<?php echo get_checked('1', $wset['nav']); ?>> 네비 숨김</label>
		</td>
	</tr>
	<tr>
		<td align="center">높이설정</td>
		<td>
			<?php echo help('타이틀 세로높이로 타이틀 가로너비의 몇 %를 양수로 입력');?>
			<input type="text" name="wset[slider_h]" value="<?php echo $wset['slider_h']; ?>" class="frm_input" size="4"> % - PC
			&nbsp;
			<input type="text" name="wmset[slider_h]" value="<?php echo $wmset['slider_h']; ?>" class="frm_input" size="4">
			% - 모바일
		</td>
	</tr>
	<tr>
		<td align="center"><b>슬라이더</b></td>
		<td>
			<input type="text" name="wset[slider]" value="<?php echo $wset['slider']; ?>" class="frm_input" size="4"> 개 - 입력후 저장하시면 슬라이더가 생성됩니다.
		</td>
	</tr>
	<?php for ($i=1; $i <= $wset['slider']; $i++) { //총 7개 ?>
		<tr>
			<td align="center" rowspan="6">#<?php echo $i;?></td>
			<td align="center" class="bg-light"><b>사용여부</b></td>
			<td class="bg-light">
				<label><input type="checkbox" name="wset[use<?php echo $i;?>]" value="1"<?php echo get_checked('1', $wset['use'.$i]); ?>> <b>출력하기</b></label>
			</td>
		</tr>
		<tr>
			<td align="center">이미지</td>
			<td>
				<input type="text" name="wset[img<?php echo $i;?>]" value="<?php echo ($wset['img'.$i]);?>" id="img<?php echo $i;?>" size="42" class="frm_input"> 
				<a href="<?php echo G5_BBS_URL;?>/widget.image.php?fid=img<?php echo $i;?>" class="btn_frmline win_scrap">이미지선택</a>
			</td>
		</tr>
		<tr>
			<td align="center">역마진</td>
			<td>
				<?php echo help('이미지 상단 역마진으로 이미지 가로너비의 몇 %를 양수로 입력');?>
				<input type="text" name="wset[mm<?php echo $i;?>]" value="<?php echo $wset['mm'.$i]; ?>" class="frm_input" size="4"> % - PC
				&nbsp;
				<input type="text" name="wmset[mm<?php echo $i;?>]" value="<?php echo $wmset['mm'.$i]; ?>" class="frm_input" size="4">
				% - 모바일 (이미지 가로대비 세로 비율)
			</td>
		</tr>
		<tr>
			<td align="center">타이틀</td>
			<td>
				<a href="<?php echo G5_BBS_URL;?>/ficon.php?fid=title<?php echo $i;?>" class="btn_frmline win_scrap">아이콘 선택</a>
				&nbsp;
				<span class="gray">미입력시 출력안됨</span>
				<div style="height:8px;"></div>
				<textarea id="title<?php echo $i;?>" name="wset[title<?php echo $i;?>]"><?php echo $wset['title'.$i]; ?></textarea>
			</td>
		</tr>
		<tr>
			<td align="center">링크</td>
			<td>
				<?php echo help('URL(http://...)을 입력해야 하며, 미입력시 링크가 걸리지 않습니다.');?>
				<input type="text" name="wset[link<?php echo $i;?>]" value="<?php echo $wset['link'.$i]; ?>" size="52" class="frm_input" placeholder="http://...">
			</td>
		</tr>
		<tr>
			<td align="center">라벨</td>
			<td>
				<select name="wset[label<?php echo $i;?>]">
					<option value=""<?php echo get_selected('', $wset['label'.$i]); ?>>사용안함</option>
					<?php echo apms_color_options($wset['label'.$i]); ?>
				</select>
				&nbsp;
				<a href="<?php echo G5_BBS_URL;?>/ficon.php?fid=txt<?php echo $i;?>" class="btn_frmline win_scrap">아이콘 선택</a>
				<div style="height:8px;"></div>
				<textarea id="txt<?php echo $i;?>" name="wset[txt<?php echo $i;?>]" placeholder="영어 3자 또는 아이콘 등 입력"><?php echo $wset['txt'.$i]; ?></textarea>
			</td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
</div>