<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 분류
$categories = explode('|', $qaconfig['qa_category']); // 구분자가 | 로 되어 있음
$ca_cnt = count($categories);
?>

<aside class="list-category">
	<div class="div-tab tabs trans-top hidden-xs">
		<ul class="nav nav-tabs">
			<li<?php echo (!$sca) ? ' class="active"' : '';?>>
				<a href="./qalist.php">
					전체<?php if(!$sca) echo '('.number_format($total_count).')';?>
				</a>
			</li>
			<?php for ($i=0; $i < $ca_cnt; $i++) { ?>
				<li<?php echo ($categories[$i] == $sca) ? ' class="active"' : '';?>>
					<a href="./qalist.php?sca=<?php echo urlencode($categories[$i]);?>">
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
				<a href="./qalist.php">전체</a>
			</li>
			<?php for ($i=0; $i < $ca_cnt; $i++) { ?>
				<li<?php if($categories[$i] == $sca) echo ' class="selected"';?>>
					<a href="./qalist.php?sca=<?php echo urlencode($categories[$i]);?>"><?php echo $categories[$i];?></a>
				</li>
			<?php } ?>
		</ul>
	</div>
</aside>
