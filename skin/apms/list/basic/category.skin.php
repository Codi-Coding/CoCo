<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$btn3 = (isset($wset['btn3']) && $wset['btn3']) ? $wset['btn3'] : 'black';

?>
<aside>
	<?php if($nav_title) { ?>
		<div class="list-nav">
			<span class="page-nav pull-right text-muted">
				<i class="fa fa-home"></i> 홈
				<?php
					if($is_nav) {		
						$nav_cnt = count($nav);
						for($i=0;$i < $nav_cnt; $i++) { 
							$nav[$i]['cnt'] = ($nav[$i]['cnt']) ? '('.number_format($nav[$i]['cnt']).')' : '';
				?>
						>
						<a href="./list.php?ca_id=<?php echo $nav[$i]['ca_id'];?>">
							<span class="text-muted"><?php echo $nav[$i]['name'];?><?php echo $nav[$i]['cnt'];?></span>
						</a>
					<?php } ?>
				<?php } else {
					echo ($page_nav1) ? ' > '.$page_nav1 : '';
					echo ($page_nav2) ? ' > '.$page_nav2 : '';
					echo ($page_nav3) ? ' > '.$page_nav3 : '';
					} 
				?>
			</span>
			<h3 class="div-title-underbar">
				<span class="div-title-underbar-bold font-22 border-<?php echo (isset($wset['ncolor']) && $wset['ncolor']) ? $wset['ncolor'] : 'color';?>">
					<b><?php echo $nav_title;?></b>
				</span>
			</h3>
		</div>
	<?php } ?>
	<?php if($is_cate) { 
		$ca_cnt = count($cate);
		$wset['ctype'] = (isset($wset['ctype']) && $wset['ctype']) ? $wset['ctype'] : '';
		$wset['mctab'] = (isset($wset['mctab']) && $wset['mctab']) ? $wset['mctab'] : 'color';

		//탭
		$category_tabs = (isset($wset['tab']) && $wset['tab']) ? $wset['tab'] : '';
		switch($category_tabs) {
			case '-top'		: $category_tabs .= ' tabs-'.$wset['mctab'].'-top'; break;
			case '-bottom'	: $category_tabs .= ' tabs-'.$wset['mctab'].'-bottom'; break;
			case '-line'	: $category_tabs .= ' tabs-'.$wset['mctab'].'-top tabs-'.$wset['mctab'].'-bottom'; break;
			case '-btn'		: $category_tabs .= ' tabs-'.$wset['mctab'].'-bg'; break;
			case '-box'		: $category_tabs .= ' tabs-'.$wset['mctab'].'-bg'; break;
			default			: $category_tabs .= ($wset['tabline']) ? ' tabs-'.$wset['mctab'].'-top' : ' trans-top'; break;
		}

		$cate_w = ($wset['ctype'] == "2") ? apms_bunhal($ca_cnt, $wset['bunhal']) : '';					
	?>
		<div class="list-category<?php echo (G5_IS_MOBILE) ? ' list-category-mobile' : '';?>">
			<div class="tabs div-tab<?php echo $category_tabs;?> hidden-xs">
				<ul class="nav nav-tabs<?php echo ($wset['ctype'] == "1") ? ' nav-justified' : '';?><?php echo ($cate_w) ? ' text-center' :'';?>">
					<?php for ($i=0; $i < $ca_cnt; $i++) { ?>
						<li<?php echo ($cate[$i]['on']) ? ' class="active"' : '';?><?php echo $cate_w;?>>
							<a href="./list.php?ca_id=<?php echo urlencode($cate[$i]['ca_id']);?>">
								<?php echo $cate[$i]['name'];?><?php if($cate[$i]['ca_id'] === $ca_id) echo '('.number_format($total_count).')';?>
							</a>
						</li>
					<?php } ?>
					<?php if($up_href) { ?>
						<li>
							<a href="<?php echo $up_href;?>">상위분류</a>
						</li>
					<?php } ?>
				</ul>
			</div>
			<div class="dropdown visible-xs">
				<a id="categoryLabel" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-<?php echo $wset['mctab'];?> btn-block">
					<?php echo ($ca_id) ? $ca['ca_name'] : '카테고리';?>(<?php echo number_format($total_count);?>)
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="categoryLabel">
					<?php for ($i=0; $i < $ca_cnt; $i++) { ?>
						<li<?php echo ($cate[$i]['on']) ? ' class="selected"' : '';?>>
							<a href="./list.php?ca_id=<?php echo urlencode($cate[$i]['ca_id']);?>"><?php echo $cate[$i]['name'];?></a>
						</li>
					<?php } ?>
					<?php if($up_href) { ?>
						<li role="separator" class="divider"></li>
						<li>
							<a href="<?php echo $up_href;?>">상위분류</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>

	<div class="list-sort">
		<div class="hidden-xs">
			<div class="pull-left">
				<a <?php echo ($sort == 'it_price' && $sortodr == 'desc') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_price&amp;sortodr=desc">높은가격순</a>
				<a <?php echo ($sort == 'it_price' && $sortodr == 'asc') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_price&amp;sortodr=asc">낮은가격순</a>
				<a <?php echo ($sort == 'it_sum_qty') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_sum_qty&amp;sortodr=desc">판매순</a>
				<a <?php echo ($sort == 'it_use_avg') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_use_avg&amp;sortodr=desc">평점순</a>
				<a <?php echo ($sort == 'it_use_cnt') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_use_cnt&amp;sortodr=desc">후기순</a>
				<a <?php echo ($sort == 'pt_comment') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>pt_comment&amp;sortodr=desc">댓글순</a>
				<a <?php echo ($sort == 'it_update_time') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_update_time&amp;sortodr=desc">최근순</a>
			</div>
			<div class="pull-right visible-lg">
				<a <?php echo ($sort == 'it_type1') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type1&amp;sortodr=desc">히트상품</a>
				<a <?php echo ($sort == 'it_type2') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type2&amp;sortodr=desc">추천상품</a>
				<a <?php echo ($sort == 'it_type3') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type3&amp;sortodr=desc">최신상품</a>
				<a <?php echo ($sort == 'it_type4') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type4&amp;sortodr=desc">인기상품</a>
				<a <?php echo ($sort == 'it_type5') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type5&amp;sortodr=desc">할인상품</a>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="dropdown visible-xs">
			<a id="sortLabel" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-<?php echo $btn3;?> btn-block">
				상품정렬
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="sortLabel">
				<li><a <?php echo ($sort == 'it_price' && $sortodr == 'desc') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_price&amp;sortodr=desc">높은가격순</a></li>
				<li><a <?php echo ($sort == 'it_price' && $sortodr == 'asc') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_price&amp;sortodr=asc">낮은가격순</a></li>
				<li><a <?php echo ($sort == 'it_sum_qty') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_sum_qty&amp;sortodr=desc">판매많은순</a></li>
				<li><a <?php echo ($sort == 'it_use_avg') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_use_avg&amp;sortodr=desc">평점높은순</a></li>
				<li><a <?php echo ($sort == 'it_use_cnt') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_use_cnt&amp;sortodr=desc">후기많은순</a></li>
				<li><a <?php echo ($sort == 'pt_comment') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>pt_comment&amp;sortodr=desc">댓글많은순</a></li>
				<li><a <?php echo ($sort == 'it_update_time') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_update_time&amp;sortodr=desc">최근등록순</a></li>
				<li role="separator" class="divider"></li>
				<li><a <?php echo ($sort == 'it_type1') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type1&amp;sortodr=desc">히트상품</a></li>
				<li><a <?php echo ($sort == 'it_type2') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type2&amp;sortodr=desc">추천상품</a></li>
				<li><a <?php echo ($sort == 'it_type3') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type3&amp;sortodr=desc">최신상품</a></li>
				<li><a <?php echo ($sort == 'it_type4') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type4&amp;sortodr=desc">인기상품</a></li>
				<li><a <?php echo ($sort == 'it_type5') ? 'class="on" ' : '';?>href="<?php echo $list_sort_href; ?>it_type5&amp;sortodr=desc">할인상품</a></li>

			</ul>
		</div>
	</div>
</aside>