<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 관련상품 전체 추출을 위해서 재세팅함
$rmods = 100;
$rrows = 1;

// 버튼컬러
$btn1 = (isset($wset['btn1']) && $wset['btn1']) ? $wset['btn1'] : 'black';
$btn2 = (isset($wset['btn2']) && $wset['btn2']) ? $wset['btn2'] : 'color';

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$item_skin_url.'/style.css" media="screen">', 0);

if($is_orderable) echo '<script src="'.$item_skin_url.'/shop.js"></script>'.PHP_EOL;

// 이미지처리
$j=0;
if($is_thumbview) { //썸네일보기시에만 사용
	$thumbnails = array();
	$item_image = '';
	$item_image_href = '';
	for($i=1; $i<=10; $i++) {
		if(!$it['it_img'.$i])
			continue;

		$thumb = get_it_thumbnail($it['it_img'.$i], 60, 60);

		if($thumb) {
			$org_url = G5_DATA_URL.'/item/'.$it['it_img'.$i];
			if($j == 0) {
				$item_image = $org_url; // 큰이미지
				$item_image_href = G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;ca_id='.$ca_id.'&amp;no='.$i; // 큰이미지 주소
			}
			$thumbnails[$j] = '<a data-href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;ca_id='.$ca_id.'&amp;no='.$i.'" data-ref="'.$org_url.'" target="_blank" class="thumb_item_image">'.$thumb.'<span class="sound_only"> '.$thumb_count.'번째 이미지 새창</span></a>';
			$j++;
		}
	}

	$is_thumbview = ($j > 0) ? true : false;
}

$attach_list = '';
if($is_download) {
	for($i=0; $i < count($download); $i++) {
		$download_href = ($download[$i]['href']) ? $download[$i]['href'] : 'javascript:alert(\'구매한 회원만 다운로드할 수 있습니다.\');';
		$attach_list .= '<a class="list-group-item break-word" href="'.$download_href.'">';
		if($download[$i]['free']) {
			if($download[$i]['guest_use']) {
				$attach_list .= '<span class="label label-default label-sp pull-right"><span class="font-11 en">Free</span></span>';
			} else {
				$attach_list .= '<span class="label label-primary label-sp pull-right"><span class="font-11 en">Join</span></span>'; 
			}
		} else {
			$attach_list .= '<span class="label label-danger label-sp pull-right"><span class="font-11 en">Paid</span></span>';
		}
		$attach_list .= '<i class="fa fa-download"></i> '.$download[$i]['source'].' ('.$download[$i]['size'].')</a>'.PHP_EOL;
	}
}

if($is_remaintime) { //이용기간 안내
	$remain_day = (int)(($is_remaintime - G5_SERVER_TIME) / 86400); //남은일수
	$attach_list .= '<a class="list-group-item" href="#"><i class="fa fa-bell"></i> '.date("Y.m.d H:i", $is_remaintime).'('.number_format($remain_day).'일 남음)까지 이용가능합니다.</a>'.PHP_EOL;
}

// 카운팅
$it_comment_cnt = ($it['pt_comment'] > 0) ? ' <b class="orangered en">'.number_format($it['pt_comment']).'</b>' : '';
$it_use_cnt = ($item_use_count > 0) ? ' <b class="orangered en">'.number_format($item_use_count).'</b>' : '';
$it_qa_cnt = ($item_qa_count > 0) ? ' <b class="orangered en">'.number_format($item_qa_count).'</b>' : '';

?>

<?php if($nav_title) { ?>
	<aside class="item-nav">
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
				<?php echo $nav_title;?>
			</span>
		</h3>
	</aside>
<?php } ?>

<?php echo $it_head_html; // 상단 HTML; ?>

<?php include_once('./itembuyform.php'); // 구매폼 ?>

<div class="item-head">
	<h1><?php if($author['photo']) { ?><img src="<?php echo $author['photo'];?>" class="photo" alt=""><?php } ?><?php echo stripslashes($it['it_name']); ?></h1>
	<div class="panel panel-default item-details<?php echo ($attach_list) ? '' : ' no-attach';?>">
		<div class="panel-heading">
			<div class="panel-title">
				<div class="font-12 text-muted">
					<?php echo apms_get_star($it['it_use_avg'],'fa-lg red'); //평균별점 ?>

					<span class="sp"></span>
					<i class="fa fa-user"></i>
					<?php echo $author['name']; //등록자 ?>

					<span class="sp"></span>
					<i class="fa fa-comment"></i>
					<?php echo $it_comment_cnt;?>

					<span class="hidden-xs">
						<span class="sp"></span>
						<i class="fa fa-shopping-cart"></i>
						<?php echo number_format($it['it_sum_qty']); //판매량 ?>

						<span class="sp"></span>
						<i class="fa fa-pencil"></i>
						<?php echo $it_use_cnt; //후기수 ?>

						<span class="sp"></span>
						<i class="fa fa-question-circle"></i>
						<?php echo $it_qa_cnt; //문의수 ?>

						<span class="sp"></span>
						<i class="fa fa-eye"></i>
						<?php echo number_format($it['it_hit']); //조회수 ?>
					</span>
					<span class="hidden-xs pull-right">
						<i class="fa fa-clock-o"></i>
						<?php echo apms_datetime($it['datetime'], 'Y.m.d H:i'); //시간 ?>
					</span>
				</div>
			</div>
		</div>
	   <?php
			if($attach_list) {
				echo '<div class="list-group font-12">'.$attach_list.'</div>'.PHP_EOL;
			}
		?>
	</div>
</div>

<?php if($is_thumbview) { // 썸네일보기 ?>
	<div class="item-image">
		<a href="<?php echo $item_image_href;?>" id="item_image_href" class="popup_item_image" target="_blank" title="크게보기">
			<img id="item_image" src="<?php echo $item_image;?>" alt="">
		</a>
		<?php if($wset['shadow']) echo apms_shadow($wset['shadow']); //그림자 ?>
	</div>
	<div class="item-thumb text-center">
	<?php 
		for($i=0; $i < count($thumbnails); $i++) { 
			echo $thumbnails[$i]; 
		} 
	?>
	</div>
	<script>
		$(function(){
			$(".thumb_item_image").hover(function() {
				var img = $(this).attr("data-ref");
				var url = $(this).attr("data-href");
				$("#item_image").attr("src", img);
				$("#item_image_href").attr("href", url);
				return true;
			});
			// 이미지 크게보기
			$(".popup_item_image").click(function() {
				var url = $(this).attr("href");
				var top = 10;
				var left = 10;
				var opt = 'scrollbars=yes,top='+top+',left='+left;
				popup_window(url, "largeimage", opt);

				return false;
			});
		});
	</script>
	<?php echo apms_line('fa', 'fa-picture-o'); //라인 ?> 
<?php } ?>

<?php if($is_viewer || $is_link) { 
	// 보기용 첨부파일 확장자에 따른 FA 아이콘 - array(이미지, 비디오, 오디오, PDF)
	$viewer_fa = array("picture-o", "video-camera", "music", "file-powerpoint-o");
?>
	<div class="item-view-box">
		<?php if($is_link) { ?>
			<?php for($i=0; $i < count($link); $i++) { ?>
				<a href="<?php echo $link[$i]['url']; ?>" target="_blank" class="at-tip" title="<?php echo ($link[$i]['name']) ? $link[$i]['name'] : '관련링크'; ?>"><i class="fa fa-<?php echo ($link[$i]['fa']) ? $link[$i]['fa'] : 'link';?>"></i></a>
			<?php } ?>
		<?php } ?>

		<?php if($is_viewer) { ?>
			<?php for($i=0; $i < count($viewer); $i++) { $v = ($viewer[$i]['ext'] - 1); ?>
				<?php if($viewer[$i]['href_view']) { ?>
					<a href="<?php echo $viewer[$i]['href_view'];?>" class="view_win at-tip" title="<?php echo ($viewer[$i]['free']) ? '무료보기' : '바로보기';?>">
				<?php } else { ?>
					<a onclick="alert('구매한 회원만 볼 수 있습니다.');" class="at-tip" title="유료보기">
				<?php } ?>
					<i class="fa fa-<?php echo $viewer_fa[$v];?>"></i>
				</a>
			<?php } ?>
		<?php } ?>
		<script>
			var view_win = function(href) {
				var new_win = window.open(href, 'view_win', 'left=0,top=0,width=640,height=480,toolbar=0,location=0,scrollbars=0,resizable=1,status=0,menubar=0');
				new_win.focus();
			}
			$(function() {
				$(".view_win").click(function() {
					view_win(this.href);
					return false;
				});
			});
		</script>
	</div>
	<?php echo apms_line('fa', 'fa-gift'); //라인 ?> 
<?php } ?>

<?php // 비디오
	$item_video = apms_link_video($link_video);
	if($item_video) {
		echo apms_line('fa', 'fa-video-camera');
		echo $item_video;
	}
?>

<?php if ($is_torrent) { // 토렌트 파일정보 ?>
	<?php for($i=0; $i < count($torrent); $i++) { ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-cube"></i> <?php echo $torrent[$i]['name'];?></h3>
			</div>
			<div class="panel-body">
				<span class="pull-right hidden-xs text-muted en font-11"><i class="fa fa-clock-o"></i> <?php echo date("Y-m-d H:i", $torrent[$i]['date']);?></span>
				<?php if ($torrent[$i]['is_size']) { ?>
						<b class="en font-16"><i class="fa fa-cube"></i> <?php echo $torrent[$i]['info']['name'];?> (<?php echo $torrent[$i]['info']['size'];?>)</b>
				<?php } else { ?>
					<p><b class="en font-16"><i class="fa fa-cubes"></i> Total <?php echo $torrent[$i]['info']['total_size'];?></b></p>
					<div class="text-muted font-12">
						<?php for ($j=0;$j < count($torrent[$i]['info']['file']);$j++) { 
							echo ($j + 1).'. '.implode(', ', $torrent[$i]['info']['file'][$j]['name']).' ('.$torrent[$i]['info']['file'][$j]['size'].')<br>'."\n";
						} ?>
					</div>
				<?php } ?>
			</div>
			<ul class="list-group">
				<li class="list-group-item en font-14 break-word"><i class="fa fa-magnet"></i> <?php echo $torrent[$i]['magnet'];?></li>
				<li class="list-group-item break-word">
					<div class="text-muted" style="font-size:12px;">
						<?php for ($j=0;$j < count($torrent[$i]['tracker']);$j++) { ?>
							<i class="fa fa-tags"></i> <?php echo $torrent[$i]['tracker'][$j];?><br>
						<?php } ?>
					</div>
				</li>
				<?php if($torrent[$i]['comment']) { ?>
					<li class="list-group-item en font-14 break-word"><i class="fa fa-bell"></i> <?php echo $torrent[$i]['comment'];?></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
<?php } ?>

<div class="item-explan">
	<?php if ($it['pt_explan']) { // 구매회원에게만 추가로 보이는 상세설명 ?>
		<div class="well"><?php echo apms_explan($it['pt_explan']); ?></div>
	<?php } ?>
	<?php echo apms_explan($it['it_explan']); ?>
</div>

<?php if ($is_good) { // 추천 ?>
	<div class="item-good-box">
		<span class="item-good">
			<a href="#" onclick="apms_good('<?php echo $it_id;?>', '', 'good', 'it_good'); return false;">
				<b id="it_good"><?php echo number_format($it['pt_good']) ?></b>
				<br>
				<i class="fa fa-thumbs-up"></i>
			</a>
		</span>
		<span class="item-nogood">
			<a href="#" onclick="apms_good('<?php echo $it_id;?>', '', 'nogood', 'it_nogood'); return false;">
				<b id="it_nogood"><?php echo number_format($it['pt_nogood']) ?></b>
				<br>
				<i class="fa fa-thumbs-down"></i>
			</a>
		</span>
	</div>
<?php } ?>

<?php if ($is_tag) { // 태그 ?>
	<p class="item-tag"><i class="fa fa-tags"></i> <?php echo $tag_list;?></p>
<?php } ?>

<div class="item-icon">
	<div class="pull-right">
		<div class="form-group">
			<a href="#" class="btn btn-<?php echo $btn1;?> btn-sm" onclick="apms_recommend('<?php echo $it['it_id']; ?>', '<?php echo $ca_id; ?>'); return false;"><i class="fa fa-send"></i> 추천</a>
			<a href="#" class="btn btn-<?php echo ($is_orderform) ? $btn1 : $btn2;?> btn-sm" onclick="apms_wishlist('<?php echo $it['it_id']; ?>'); return false;"><i class="fa fa-heart"></i> 위시</a>
			<?php if($is_orderform) { // 주문가능시에만 출력 ?>
				<a href="#" class="btn btn-<?php echo $btn2;?> btn-sm" data-toggle="modal" data-target="#buyModal" onclick="return false;"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs">주문/담기</span></a>
			<?php } ?>
		</div>
	</div>
	<div class="pull-left">
		<div class="form-group">
			<?php include_once(G5_SNS_PATH."/item.sns.skin.php"); ?>
		</div>
	</div>
	<div class="clearfix"></div>
</div>

<?php if ($is_ccl) { // CCL ?>
	<div class="well">
		<img src="<?php echo $ccl_img;?>" alt="CCL" />  &nbsp; 본 자료는 <u><?php echo $ccl_license;?></u>에 따라 이용할 수 있습니다.
	</div>
<?php } ?>

<?php if($wset['seller']) { // 판매자 ?>
	<div class="panel panel-default item-seller">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php if($author['partner']) { ?>
					<a href="<?php echo $at_href['myshop'];?>?id=<?php echo $author['mb_id'];?>" class="pull-right">
						<span class="label label-primary"><span class="font-11 en">My Shop</span></span>
					</a>
				<?php } ?>
				Seller
			</h3>
		</div>
		<div class="panel-body">
			<div class="pull-left text-center auth-photo">
				<div class="img-photo">
					<?php echo ($author['photo']) ? '<img src="'.$author['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
				</div>
				<div class="btn-group" style="margin-top:-30px;white-space:nowrap;">
					<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'like', 'it_like'); return false;" title="Like">
						<i class="fa fa-thumbs-up"></i> <span id="it_like"><?php echo number_format($author['liked']) ?></span>
					</button>
					<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'follow', 'it_follow'); return false;" title="Follow">
						<i class="fa fa-users"></i> <span id="it_follow"><?php echo $author['followed']; ?></span>
					</button>
				</div>
			</div>
			<div class="auth-info">
				<div style="margin-bottom:4px;">
					<span class="pull-right">Lv.<?php echo $author['level'];?></span>
					<b><?php echo $author['name']; ?></b> &nbsp;<span class="text-muted font-11"><?php echo $author['grade'];?></span>
				</div>
				<div class="div-progress progress progress-striped no-margin">
					<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($author['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($author['exp_per']);?>%;">
						<span class="sr-only"><?php echo number_format($author['exp']);?> (<?php echo $author['exp_per'];?>%)</span>
					</div>
				</div>
				<p style="margin-top:10px;">
					<?php echo ($author['signature']) ? $author['signature'] : '등록된 서명이 없습니다.'; ?>
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<?php } ?>

<?php if ($is_relation) { ?>
	<div class="div-title-wrap">
		<div class="div-title" style="line-height:30px;">
			<i class="fa fa-cubes fa-lg lightgray"></i> <b>관련아이템</b>
		</div>
		<div class="div-sep-wrap">
			<div class="div-sep sep-bold"></div>
		</div>
	</div>
	<?php include_once('./itemrelation.php'); ?>
<?php } ?>

<?php
	// 위젯에서 해당글 클릭시 이동위치 : icv - 댓글, iuv - 후기, iqv - 문의
	// 댓글사용에 따른 두번째 탭처리
	$active_tab =($is_comment) ? false : true;
?>
<div id="item-tab" class="div-tab tabs<?php echo ($wset['tabline']) ? '' : ' trans-top';?>">
	<ul class="nav nav-tabs nav-justified">
		<?php if($is_comment) { // 댓글 ?>
			<li class="active"><a href="#item-cmt" data-toggle="tab"><b>댓글<?php echo $it_comment_cnt;?></b></a></li>
		<?php } ?>
		<li<?php echo ($active_tab) ? ' class="active"' : '';?>><a href="#item-review" data-toggle="tab"><b>후기글<?php echo $it_use_cnt;?></b></a></li>
		<li><a href="#item-qa" data-toggle="tab"><b>문의글<?php echo $it_qa_cnt;?></b></a></li>
	</ul>
	<div class="tab-content" style="border:0px; padding:20px 0px;">
		<?php if($is_comment) { // 댓글 ?>
			<div class="tab-pane active" id="item-cmt">
				<div id="icv"></div>
				<?php include_once('./itemcomment.php'); ?>
			</div>
		<?php } ?>
		<div class="tab-pane<?php echo ($active_tab) ? ' active' : '';?>" id="item-review">
			<div id="iuv"></div>
			<div id="itemuse">
				<?php include_once('./itemuse.php'); ?>
			</div>
		</div>
		<div class="tab-pane" id="item-qa">
			<div id="iqv"></div>
			<div id="itemqa">
				<?php include_once('./itemqa.php'); ?>
			</div>
		</div>
	</div>							
</div>

<?php echo $it_tail_html; // 하단 HTML ?>

<div class="btn-group btn-group-justified">
	<?php if($prev_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $prev_href;?>" title="<?php echo $prev_item;?>"><i class="fa fa-chevron-circle-left"></i> 이전</a>
	<?php } ?>
	<?php if($next_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $next_href;?>" title="<?php echo $next_item;?>"><i class="fa fa-chevron-circle-right"></i> 다음</a>
	<?php } ?>
	<?php if($edit_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $edit_href;?>"><i class="fa fa-plus"></i><span class="hidden-xs"> 수정</span></a>
	<?php } ?>
	<?php if ($write_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $write_href;?>"><i class="fa fa-upload"></i><span class="hidden-xs"> 등록</span></a>
	<?php } ?>
	<?php if($item_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $item_href;?>"><i class="fa fa-th-large"></i><span class="hidden-xs"> 관리</span></a>
	<?php } ?>
	<?php if($setup_href) { ?>
		<a class="btn btn-<?php echo $btn1;?> win_memo" href="<?php echo $setup_href;?>"><i class="fa fa-cogs"></i><span class="hidden-xs"> 스킨설정</span></a>
	<?php } ?>
	<a class="btn btn-<?php echo $btn2;?>" href="<?php echo $list_href;?>"><i class="fa fa-bars"></i> 목록</a>
</div>

<div class="h30"></div>

<script>
// Wishlist
function apms_wishlist(it_id) {
	if(!it_id) {
		alert("코드가 올바르지 않습니다.");
		return false;
	}

	$.post("./itemwishlist.php", { it_id: it_id },	function(error) {
		if(error != "OK") {
			alert(error.replace(/\\n/g, "\n"));
			return false;
		} else {
			if(confirm("위시리스트에 담겼습니다.\n\n바로 확인하시겠습니까?")) {
				document.location.href = "./wishlist.php";
			}
		}
	});

	return false;
}

// Recommend
function apms_recommend(it_id, ca_id) {
	if (!g5_is_member) {
		alert("회원만 추천하실 수 있습니다.");
	} else {
		url = "./itemrecommend.php?it_id=" + it_id + "&ca_id=" + ca_id;
		opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
		popup_window(url, "itemrecommend", opt);
	}
}

$(function() {
	$("a.view_image").click(function() {
		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
		return false;
	});
});
</script>

<?php include_once('./itemlist.php'); // 분류목록 ?>
