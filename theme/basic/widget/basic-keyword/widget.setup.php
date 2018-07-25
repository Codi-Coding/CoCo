<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

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
		<td align="center">키워드</td>
		<td>
			<?php echo help('키워드는 콤마(,)로 구분하여 복수 등록 가능');?>
			<textarea name="wset[q]" style="height:100px;"><?php echo $wset['q']; ?></textarea>
		</td>
	</tr>
	<tr>
		<td align="center">검색연결</td>
		<td>
			<select name="wset[search]">
				<option value=""<?php echo get_selected('', $wset['search']); ?>>게시물 검색</option>
				<option value="item"<?php echo get_selected('item', $wset['search']); ?>>상품 검색</option>
				<option value="tag"<?php echo get_selected('tag', $wset['search']); ?>>태그 검색</option>
			</select>
		</td>
	</tr>
	</tbody>
	</table>
</div>