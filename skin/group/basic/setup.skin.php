<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록

$headskin = get_skin_dir('header');

?>
<div class="tbl_head01 tbl_wrap"><table>
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
		<td align="center">헤더</td>
		<td>
			<select name="wset[hskin]">
				<option value="">사용안함</option>
				<?php
				for ($k=0; $k<count($headskin); $k++) {
					echo "<option value=\"".$headskin[$k]."\"".get_selected($wset['hskin'], $headskin[$k]).">".$headskin[$k]."</option>\n";
				} 
				?>
			</select>
			&nbsp;
			<select name="wset[hcolor]">
				<?php echo apms_color_options($wset['hcolor']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">타이틀</td>
		<td>
			<label><input type="checkbox" name="wset[title]" value="1"<?php echo ($wset['title'] ? " checked" : ""); ?>> 출력안함</label>
		</td>
	</tr>
	<tr>
		<td align="center">베스트</td>
		<td>
			<label><input type="checkbox" name="wset[best]" value="1"<?php echo ($wset['best'] ? " checked" : ""); ?>> 출력안함</label>
		</td>
	</tr>
	</tbody>
	</table>
</div>
