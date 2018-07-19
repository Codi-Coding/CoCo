<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

$list = apms_poll_rows($wset);
$list_cnt = count($list);

if(!$list_cnt) return; // 투표가 없으면 출력안함

global $is_admin, $member;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

$skin_dir = $wname; //위젯명

// 버튼색
$btn_poll = (isset($wset['poll']) && $wset['poll']) ? $wset['poll'] : 'navy';
$btn_result = (isset($wset['result']) && $wset['result']) ? $wset['result'] : 'lightgray';
$btn_admin = (isset($wset['admin']) && $wset['admin']) ? $wset['admin'] : 'lightgray';

// 투표섞기
if($list_cnt > 0 && isset($wset['rdm']) && $wset['rdm']) {
	shuffle($list);
}

// 아이콘
$icon = (isset($wset['icon']) && $wset['icon']) ? apms_fa($wset['icon']) : '';

$widget_id = apms_id();

?>
<div class="basic-poll">
	<div class="panel-group" id="<?php echo $widget_id;?>" role="tablist" aria-multiselectable="true">
		<?php for($i=0; $i < $list_cnt; $i++) { ?>
			<div class="panel panel-default">
				<div class="panel-heading" id="<?php echo $widget_id;?>H<?php echo $i;?>" role="tab">
					<a aria-expanded="true" data-parent="#<?php echo $widget_id;?>" aria-controls="<?php echo $widget_id;?>G<?php echo $i;?>" href="#<?php echo $widget_id;?>G<?php echo $i;?>" data-toggle="collapse">
						<?php echo $icon; ?>
						<?php echo $list[$i]['po_subject'] ?>
					</a>
				</div>
				<div class="panel-collapse collapse<?php echo($i == 0) ? ' in' : '';?>" id="<?php echo $widget_id;?>G<?php echo $i;?>">
					<div class="panel-body">
						<form class="form" role="form" id="fpoll<?php echo $i;?>" name="fpoll<?php echo $i;?>" action="<?php echo G5_BBS_URL; ?>/poll_update.php" onsubmit="return fpoll_submit(this,'<?php echo $list[$i]['po_level'];?>');" method="post">
							<input type="hidden" name="po_id" value="<?php echo $list[$i]['po_id'] ?>">
							<input type="hidden" name="skin_dir" value="<?php echo $skin_dir; ?>">
							<ul class="poll-list">
								<?php for ($j=1; $j<=9 && $list[$i]["po_poll{$j}"]; $j++) {  ?>
									<li>
										<label><input type="radio" name="gb_poll" id="gb_poll_<?php echo $i ?>_<?php echo $j ?>" value="<?php echo $j ?>"> <?php echo $list[$i]['po_poll'.$j] ?></label>
									</li>
								<?php } ?>
							</ul>
							<div class="text-center">
								<div class="btn-group">
									<button type="submit" class="btn btn-<?php echo $btn_poll;?> btn-sm"><i class="fa fa-check"></i> 투표</button>
									<a href="<?php echo G5_BBS_URL;?>/poll_result.php?po_id=<?php echo $list[$i]['po_id'];?>&amp;skin_dir=<?php echo urlencode($skin_dir);?>" target="_blank" onclick="fpoll_result(this.href, '<?php echo $list[$i]['po_level'];?>'); return false;" class="btn btn-<?php echo $btn_result;?> btn-sm"><i class="fa fa-bar-chart"></i> 결과</a>
									<?php if($is_admin == 'super') { ?>
										<a href="<?php echo G5_ADMIN_URL; ?>/poll_list.php" class="btn btn-<?php echo $btn_admin;?> btn-sm"><i class="fa fa-th-large"></i> 관리</a>
									<?php } ?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php if(!$list_cnt) { ?>
		<div class="poll-none">
			등록된 설문이 없습니다.
		</div>
	<?php } ?>
</div>
<?php if($setup_href) { ?>
	<div class="text-center btn-wset p10">
		<a href="<?php echo $setup_href;?>" class="win_memo">
			<span class="text-muted"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>
<script>
function fpoll_submit(f, lvl) {
	var mb_lvl = <?php echo ($member['mb_level']) ? $member['mb_level'] : 1;?>;

	if(mb_lvl < lvl) {
        alert('권한 ' + lvl + ' 이상의 회원만 투표에 참여하실 수 있습니다.'); 
		return false;
	} else {
		var chk = "";
		for (i=0; i<f.gb_poll.length;i ++) {
			if (f.gb_poll[i].checked == true) {
				chk = f.gb_poll[i].value;
				break;
			}
		}

		if (chk == "") {
			alert("투표하실 설문항목을 선택하세요");
			return false;
		}

		var new_win = window.open("about:blank", "win_poll", "width=616,height=500,scrollbars=yes,resizable=yes"); 
		f.target = "win_poll"; 

		return true;
	}

	return false;
}
function fpoll_result(url, lvl) {
	var mb_lvl = <?php echo ($member['mb_level']) ? $member['mb_level'] : 1;?>;

	if(mb_lvl < lvl) {
		alert('권한 ' + lvl + ' 이상의 회원만 결과를 보실 수 있습니다.'); 
	} else {
		win_poll(url);
	}
	return false;
}
</script>
