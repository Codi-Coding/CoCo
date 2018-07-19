<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<aside>
	<form id="frmdetailsearch" name="frmdetailsearch" class="form-horizontal" role="form">
	<input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
	<input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
	<input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
		<div class="search-box" style="padding-bottom:0px;">
			<div class="form-group">
				<label class="col-sm-2 control-label"><b>검색범위</b></label>
				<div class="col-sm-9 item-sfl">
					<style>
						.item-sfl label { min-width:90px; margin-left:0px !important; }
					</style>
					<label class="checkbox-inline"><input type="checkbox" name="qname" id="ssch_qname" value="1" <?php echo $qname_check?'checked="checked"':'';?>> 상품명</label>
					<label class="checkbox-inline"><input type="checkbox" name="qexplan" id="ssch_qexplan" value="1" <?php echo $qexplan_check?'checked="checked"':'';?>> 상품설명</label>
					<label class="checkbox-inline"><input type="checkbox" name="qid" id="ssch_qid" value="1" <?php echo $qid_check?'checked="checked"':'';?>> 상품코드</label>
					<label class="checkbox-inline"><input type="checkbox" name="qtag" id="ssch_qtag" value="1" <?php echo $qtag_check?'checked="checked"':'';?>> 상품태그</label>
					<label class="checkbox-inline"><input type="checkbox" name="qbasic" id="ssch_qbasic" value="1" <?php echo $qbasic_check?'checked="checked"':'';?>> 기본설명</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><b>상품가격</b></label>
				<div class="col-sm-5">
					<div class="input-group input-group-sm">
						<input type="text" name="qfrom" value="<?php echo $qfrom; ?>" id="ssch_qfrom" class="form-control input-sm" size="10" placeholder="최소">
						<span class="input-group-addon" style="border-left:0px !important;">원</span>
						<span class="input-group-addon" style="border:0px !important; background:none !important;">-</span>
						<input type="text" name="qto" value="<?php echo $qto; ?>" id="ssch_qto" class="form-control input-sm" size="10" placeholder="최대">
						<span class="input-group-addon">원</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="ssch_q" class="col-sm-2 control-label"><b>검색어</b></label>
				<div class="col-sm-5">
					<input type="text" name="q" value="<?php echo $q; ?>" id="ssch_q" class="form-control input-sm" size="40" maxlength="30">
					<div class="h15 hidden-sm hidden-md hidden-lg"></div>
				</div>
				<div class="col-sm-3">
					<button type="submit" class="btn btn-<?php echo $btn2;?> btn-block btn-sm"><i class="fa fa-search fa-lg"></i> 검색하기</button>
				</div>
			</div>

			<div class="form-group">
				<label for="ssch_q" class="col-sm-2 control-label hidden-xs"><b>검색안내</b></label>
				<div class="col-sm-8">
					<p class="form-control-static">
						검색범위을 선택하지 않거나 상품가격을 입력하지 않으면 전체에서 검색하며, 검색어는 최대 30글자까지 여러개의 검색어를 공백으로 구분하여 입력 할수 있습니다.
					</p>
				</div>
			</div>
		</div>
	</form>

	<script>
		function set_sort(qsort) {
			var f = document.frmdetailsearch;
			var qorder = "desc";

			if(qsort == "it_price_min") {
				qsort = "it_price";
				qorder = "asc";
			}
			f.qsort.value = qsort;
			f.qorder.value = qorder;
			f.submit();
		}

		function set_ca_id(qcaid) {
			var f = document.frmdetailsearch;
			f.qcaid.value = qcaid;
			f.submit();
		}
	</script>

</asde>

<aside>
	<div class="row">
		<div class="col-sm-3">
			<div class="form-group input-group input-group-sm">
				<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				<select name="sortodr" onchange="set_ca_id(this.value); return false;" class="form-control input-sm">
					<option value="">전체분류(<?php echo number_format($total_count);?>)</option>
					<?php for($i=0;$i < count($category); $i++) { ?>
						<option value="<?php echo $category[$i]['ca_id'];?>"<?php echo ($qcaid === $category[$i]['ca_id']) ? ' selected' : '';?>><?php echo $category[$i]['ca_name'];?>(<?php echo number_format($category[$i]['cnt']);?>)</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-sm-6">

		</div>
		<div class="col-sm-3">
			<div class="form-group input-group input-group-sm">
				<span class="input-group-addon"><i class="fa fa-sort"></i></span>
				<select name="sortodr" onchange="set_sort(this.value); return false;" class="form-control input-sm">
					<option value="">정렬하기</option>
					<option value="it_sum_qty"<?php echo ($qsort == 'it_sum_qty') ? ' selected' : '';?>>판매많은순</option>
					<option value="it_price_min"<?php echo ($qsort == 'it_price' && $qorder == 'asc') ? ' selected' : '';?>>낮은가격순</option>
					<option value="it_price"<?php echo ($qsort == 'it_price' && $qorder == 'desc') ? ' selected' : '';?>>높은가격순</option>
					<option value="it_use_avg"<?php echo ($qsort == 'it_use_avg') ? ' selected' : '';?>>평점높은순</option>
					<option value="it_use_cnt"<?php echo ($qsort == 'it_use_cnt') ? ' selected' : '';?>>후기많은순</option>
					<option value="pt_good"<?php echo ($qsort == 'pt_good') ? ' selected' : '';?>>추천많은순</option>
					<option value="pt_comment"<?php echo ($qsort == 'pt_comment') ? ' selected' : '';?>>댓글많은순</option>
					<option value="it_update_time"<?php echo ($qsort == 'it_update_time') ? ' selected' : '';?>>최근등록순</option>
				</select>
			</div>
		</div>
	</div>
</aside>
