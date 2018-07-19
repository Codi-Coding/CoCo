<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록
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
		<td align="center">목록헤드</td>
		<td>
			<select name="wset[hskin]">
				<option value="">기본헤드</option>
			<?php
				$skinlist = apms_skin_file_list(G5_PATH.'/css/head', 'css');
				for ($k=0; $k<count($skinlist); $k++) {
					echo "<option value=\"".$skinlist[$k]."\"".get_selected($wset['hskin'], $skinlist[$k]).">".$skinlist[$k]."</option>\n";
				} 
			?>
			</select>
			&nbsp;
			기본컬러	
			<select name="wset[hcolor]">
				<?php echo apms_color_options($wset['hcolor']);?>
			</select>
		</td>
	</tr>
	</tbody>
	</table>
</div>