<?php
$sub_menu = "300100";
define('G5_IS_ADMIN', true);
include_once ('../common.php');
if(!$is_demo) {
	include_once(G5_ADMIN_PATH.'/admin.lib.php');
	auth_check($auth[$sub_menu], 'w');
}
include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');
include_once(G5_LIB_PATH.'/apms.widget.lib.php');

if(!$bo_table) {
    alert_close('값이 넘어오지 않았습니다.');
}

$skin_file = $board_skin_path.'/setup.skin.php';

if(!file_exists($skin_file)) {
    alert_close('설정을 할 수 없는 보드입니다.');
}

if($mode == "save") {

	if ($is_demo && !$is_designer) {
		alert("관리자만 가능합니다.");
	}

	$boset = (isset($del) && $del) ? '' : apms_pack($_POST['boset']);

	if(isset($both) && $both) { //PC, 모바일 동일값 적용
		sql_query(" update {$g5['board_table']} set as_set = '{$boset}', as_mobile_set = '{$boset}' where bo_table = '{$bo_table}' ", false);
	} else {
		if(G5_IS_MOBILE) {
			sql_query(" update {$g5['board_table']} set as_mobile_set = '{$boset}' where bo_table = '{$bo_table}' ", false);
		} else {
			sql_query(" update {$g5['board_table']} set as_set = '{$boset}' where bo_table = '{$bo_table}' ", false);
		}
	}

	@include_once($board_skin_path.'/setupsave.skin.php');

	// 스킨별 저장
	if($_POST['boset']['list_skin']) {
		$list_skin_path = $board_skin_path.'/list/'.$_POST['boset']['list_skin'];
		@include_once($list_skin_path.'/setupsave.skin.php');
	}

	if($_POST['boset']['view_skin']) {
		$view_skin_path = $board_skin_path.'/view/'.$_POST['boset']['view_skin'];
		@include_once($view_skin_path.'/setupsave.skin.php');
	}

	goto_url('./board.setup.php?bo_table='.$bo_table);
}

$boset = apms_unpack($board['as_'.MOBILE_.'set']);

$g5['title'] = $board['bo_subject'].' 보드설정';
include_once(G5_PATH.'/head.sub.php');
?>
<div id="sch_board_frm" class="new_win bsp_new_win">
    <h1><?php echo $g5['title'];?></h1>
	<form id="fsetup" name="fsetup" method="post">
	<input type="hidden" name="mode" value="save">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table;?>">

	<?php include_once($skin_file); ?>

	<div style="margin:0 20px 20px;">
		<label><input type="checkbox" name="del" value="1"> 설정값 초기화</label>
		&nbsp;
		<label><input type="checkbox" name="both" value="1"> PC/모바일 동일설정 적용</label>
	</div>

    <div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit" accesskey="s">
		<button type="button" onclick="window.close();">닫기</button>
    </div>
	</form>
	<br>
</div>
<script>
var win_h = parseInt($('#sch_board_frm').height()) + 80;
if(win_h > screen.height) {
    win_h = screen.height - 40;
}

window.moveTo(0, 0);
window.resizeTo(<?php echo (isset($win_size) && $win_size > 0) ? $win_size : 640;?>, win_h);
</script>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
