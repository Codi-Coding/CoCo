<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$ca_cnt = count($categories);
$cate_w = ($boset['ctype'] == "2") ? apms_bunhal($ca_cnt + 1, $boset['bunhal']) : ''; //전체 포함으로 +1 해줌

?>

<aside class="list-category">
	<div class="div-tab<?php echo $boset['tab'];?> tabs<?php echo ($boset['tabline']) ? '' : ' trans-top';?> hidden-xs">
		<ul class="nav nav-tabs<?php echo ($boset['ctype'] == "1") ? ' nav-justified' :'';?><?php echo ($cate_w) ? ' text-center' :'';?>">
			<li<?php echo (!$sca) ? ' class="active"' : '';?><?php echo $cate_w;?>>
				<a href="./board.php?bo_table=<?php echo $bo_table;?>">
					전체<?php if(!$sca) echo '('.number_format($total_count).')';?>
				</a>
			</li>
			<?php for ($i=0; $i < $ca_cnt; $i++) { ?>
				<li<?php echo ($categories[$i] == $sca) ? ' class="active"' : '';?><?php echo $cate_w;?>>
					<a href="./board.php?bo_table=<?php echo $bo_table;?>&amp;sca=<?php echo urlencode($categories[$i]);?>">
						<?php echo $categories[$i];?><?php if($categories[$i] == $sca) echo '('.number_format($total_count).')';?>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="dropdown visible-xs">
		<a id="categoryLabel" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-color btn-block">
			<?php echo ($sca) ? $sca : '전체';?>(<?php echo number_format($total_count);?>)
		</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="categoryLabel">
			<li<?php if(!$sca) echo ' class="selected"';?>>
				<a href="./board.php?bo_table=<?php echo $bo_table;?>">전체</a>
			</li>
			<?php for ($i=0; $i < $ca_cnt; $i++) { ?>
				<li<?php if($categories[$i] == $sca) echo ' class="selected"';?>>
					<a href="./board.php?bo_table=<?php echo $bo_table;?>&amp;sca=<?php echo urlencode($categories[$i]);?>"><?php echo $categories[$i];?></a>
				</li>
			<?php } ?>
		</ul>
	</div>
</aside>
