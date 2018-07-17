<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

if ($himg_src) 
	echo '<div id="faq_himg" class="faq-img"><img src="'.$himg_src.'" alt=""></div>';

?>

<div class="faq-box">
    <form class="form" role="form" name="faq_search_form" method="get">
    <input type="hidden" name="fm_id" value="<?php echo $fm_id;?>">
		<div class="row">
			<div class="col-sm-3 col-sm-offset-3 col-xs-7">
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-tags"></i></span>
				    <input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="form-control input-sm" placeholder="검색어">
				</div>
			</div>
			<div class="col-sm-3 col-xs-5">
				<div class="form-group">
					<button type="submit" class="btn btn-black btn-sm btn-block"><i class="fa fa-search"></i> 검색하기</button>
				</div>
			</div>
		</div>
	</form>
</div>

<?php echo '<div id="faq_hhtml" class="faq-html">'.$faq_head_html.'</div>'; // 상단 HTML ?>

<?php if(count($faq_master_list)){ ?>
	<aside class="faq-category">
		<div class="div-tab tabs trans-top hidden-xs">
			<ul class="nav nav-tabs">
			<?php
			foreach($faq_master_list as $v){
				$category_active = '';
				if($v['fm_id'] == $fm_id){ // 현재 선택된 카테고리라면
					$category_active = ' class="active"';
				}
			?>
				<li<?php echo $category_active;?>>
					<a href="<?php echo $category_href;?>?fm_id=<?php echo $v['fm_id'];?>">
						<?php echo $category_msg.$v['fm_subject'];?>
					</a>
				</li>
			<?php }	?>
		</div>
		<div class="dropdown visible-xs">
			<a id="categoryLabel" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-color btn-block">
				카테고리
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="categoryLabel">
			<?php
			foreach($faq_master_list as $v){
				$category_selected = '';
				if($v['fm_id'] == $fm_id){ // 현재 선택된 카테고리라면
					$category_selected = ' class="selected"';
				}
			?>
				<li<?php echo $category_selected;?>>
					<a href="<?php echo $category_href;?>?fm_id=<?php echo $v['fm_id'];?>">
						<?php echo $category_msg.$v['fm_subject'];?>
					</a>
				</li>
			<?php }	?>
			</ul>
		</div>
	</aside>
<?php } ?>

<section class="faq-content">
	<?php if( count($faq_list) ){ // FAQ 내용 ?>
		<div class="div-panel no-animation panel-group at-toggle" id="faq_accordion">
			<?php
				$i = 1;
				foreach($faq_list as $key=>$v){
					if(empty($v))
						continue;
			?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#faq_accordion" href="#faq_collapse<?php echo $i;?>">
							<span class="panel-icon"></span> <b><?php echo apms_get_text($v['fa_subject']); ?></b>
						</a>
					</div>
					<div id="faq_collapse<?php echo $i;?>" class="panel-collapse collapse">
						<div class="panel-body">
							<?php echo apms_content(conv_content($v['fa_content'], 1)); ?>
						</div>
					</div>
				</div>
			<?php $i++; } ?>
		</div>
	<?php } else {
		if($stx){
			echo '<div class="faq-none text-center">검색된 FAQ가 없습니다.</div>';
		} else {
			echo '<div class="faq-none text-center">등록된 FAQ가 없습니다.';
			if($is_admin)
				echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용하십시오.';
			echo '</div>';
		}
	}
	?>
</section>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>

<?php 
	 // 하단 HTML
	echo '<div id="faq_thtml" class="faq-html">'.$faq_tail_html.'</div>';

	if ($timg_src) 
		echo '<div id="faq_timg" class="faq-img"><img src="'.$timg_src.'" alt=""></div>';

	if ($admin_href) 
		echo '<p class="text-center"><a href="'.$admin_href.'" class="btn btn-black btn-sm">FAQ 수정</a></p>'; 
?>
