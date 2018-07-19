<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록

$skinlist = apms_skin_file_list(G5_PATH.'/css/head', 'css');

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
		<th scope="col">목록헤드스킨</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center">장바구니</td>
		<td>
			<select name="wset[chead]">
				<option value="">기본헤드</option>
				<?php
					for ($k=0; $k<count($skinlist); $k++) {
						echo "<option value=\"".$skinlist[$k]."\"".get_selected($wset['chead'], $skinlist[$k]).">".$skinlist[$k]."</option>\n";
					} 
				?>
			</select>
			&nbsp;
			기본컬러	
			<select name="wset[ccolor]">
				<?php echo apms_color_options($wset['ccolor']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">주소록</td>
		<td>
			<select name="wset[ahead]">
				<option value="">기본헤드</option>
				<?php
					for ($k=0; $k<count($skinlist); $k++) {
						echo "<option value=\"".$skinlist[$k]."\"".get_selected($wset['ahead'], $skinlist[$k]).">".$skinlist[$k]."</option>\n";
					} 
				?>
			</select>
			&nbsp;
			기본컬러	
			<select name="wset[acolor]">
				<?php echo apms_color_options($wset['acolor']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">주문서</td>
		<td>
			<select name="wset[ohead]">
				<option value="">기본헤드</option>
				<?php
					for ($k=0; $k<count($skinlist); $k++) {
						echo "<option value=\"".$skinlist[$k]."\"".get_selected($wset['ohead'], $skinlist[$k]).">".$skinlist[$k]."</option>\n";
					} 
				?>
			</select>
			&nbsp;
			기본컬러	
			<select name="wset[ocolor]">
				<?php echo apms_color_options($wset['ocolor']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">주문내역</td>
		<td>
			<select name="wset[ivhead]">
				<option value="">기본헤드</option>
				<?php
					for ($k=0; $k<count($skinlist); $k++) {
						echo "<option value=\"".$skinlist[$k]."\"".get_selected($wset['ivhead'], $skinlist[$k]).">".$skinlist[$k]."</option>\n";
					} 
				?>
			</select>
			&nbsp;
			기본컬러	
			<select name="wset[ivcolor]">
				<?php echo apms_color_options($wset['ivcolor']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">주문목록</td>
		<td>
			<select name="wset[ihead]">
				<option value="">기본헤드</option>
				<?php
					for ($k=0; $k<count($skinlist); $k++) {
						echo "<option value=\"".$skinlist[$k]."\"".get_selected($wset['ihead'], $skinlist[$k]).">".$skinlist[$k]."</option>\n";
					} 
				?>
			</select>
			&nbsp;
			기본컬러	
			<select name="wset[icolor]">
				<?php echo apms_color_options($wset['icolor']);?>
			</select>
		</td>
	</tr>
	</tbody>
	</table>
</div>