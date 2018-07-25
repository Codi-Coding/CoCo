<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가
?>

<!-- Search -->
<div class="div-title-underline-thin en">
	<b>SEARCH</b>
</div>
<div class="sidebar-search">
	<form id="ctrlSearch" name="ctrlSearch" method="get" onsubmit="return sidebar_search(this);" role="form" class="form">
		<div class="row">
			<div class="col-xs-6">
				<select name="url" class="form-control input-sm">
					<option value="<?php echo $at_href['search'];?>">게시물</option>
					<?php if(IS_YC) { ?>
						<option value="<?php echo $at_href['isearch'];?>">상품</option>
						<option value="<?php echo $at_href['iuse'];?>">후기</option>
						<option value="<?php echo $at_href['iqa'];?>">문의</option>
					<?php } ?>
					<option value="<?php echo $at_href['tag'];?>">태그</option>
				</select>
			</div>
			<div class="col-xs-6">
				<select name="sop" id="sop" class="form-control input-sm">
					<option value="or">또는</option>
					<option value="and">그리고</option>
				</select>	
			</div>
		</div>
		<div class="input-group input-group-sm" style="margin-top:8px;">
			<input type="text" name="stx" class="form-control input-sm" value="<?php echo $stx;?>" placeholder="검색어는 두글자 이상">
			<span class="input-group-btn">
				<button type="submit" class="btn btn-navy btn-sm"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</form>				
</div>
