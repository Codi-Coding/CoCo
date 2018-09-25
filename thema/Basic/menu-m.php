<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>
<div class="m-wrap">
	<div class="at-container">
		<div class="m-table en">
			<div class="m-list">
				<div class="m-nav" id="mobile_nav">
					<ul class="clearfix flex">
						<li>
							<a href="/shop/list.php?ca_id=10">검색</a>
						</li>
						<li>
							<a href="<?php echo $at_href['main'];?>">추천/컨셉</a>
						</li>
						<li>
							<a href="/shop/list.php?ca_id=20">모아보기</a>
						</li>
						<li>
							<a href="/shop/fittingroom.php">피팅룸</a>
						</li>
						<li>
							<a href="javascript:;" onclick="sidebar_open('sidebar-menu');"><i class="fa fa-bars"></i></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
