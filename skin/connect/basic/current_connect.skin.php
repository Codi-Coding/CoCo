<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css">', 0);

// 목록헤드
if(isset($wset['hskin']) && $wset['hskin']) {
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/head/'.$wset['hskin'].'.css" media="screen">', 0);
	$head_class = 'list-head';
} else {
	$head_class = (isset($wset['hcolor']) && $wset['hcolor']) ? 'border-'.$wset['hcolor'] : 'border-black';
}

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>

<div class="list-board">
	<div class="div-head <?php echo $head_class;?>">
		<span class="num">번호</span>
		<span class="name">이름</span>
		<span class="subj">위치</span>
	</div>
	<ul id="list-container" class="board-list">
    <?php
    for ($i=0; $i<count($list); $i++) {
        //$location = conv_content($list[$i]['lo_location'], 0);
        $location = $list[$i]['lo_location'];
        // 최고관리자에게만 허용
        // 이 조건문은 가능한 변경하지 마십시오.
        if ($list[$i]['lo_url'] && $is_admin == 'super') $display_location = "<a href=\"".$list[$i]['lo_url']."\">".$location."</a>";
        else $display_location = $location;
    ?>
		<li class="list-item">
			<div class="num">
				<?php echo $list[$i]['num'] ?>
			</div>
			<div class="name">
				<span class="ellipsis"><?php echo $list[$i]['name']; ?></span>
			</div>
			<div class="subj">
				<span class="ellipsis"><?php echo $display_location ?></span>
			</div>
        </li>
    <?php } ?>
    </ul>
	<?php if ($i == 0) { ?>
		<div class="none text-center text-muted">현재 접속자가 없습니다.</div>
	<?php } ?>
</div>

<?php if($setup_href) { ?>
	<div class="h30"></div>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>

<div class="h30"></div>
