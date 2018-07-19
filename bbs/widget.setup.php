<?php
define('G5_IS_ADMIN', true);
include_once ('../common.php');
include_once(G5_LIB_PATH.'/apms.widget.lib.php');

$wset = array();
$wmset = array();

$wid = (isset($wid)) ? apms_escape_string($wid) : '';
$wdir = (isset($wdir)) ? $wdir : '';
$wdemo = (isset($wdemo)) ? $wdemo : '';
$mode = (isset($mode)) ? $mode : '';
$add = (isset($add)) ? apms_escape_string($add) : '';
$wname = (isset($wname)) ? apms_escape_string($wname) : '';
$thema = (isset($thema)) ? apms_escape_string($thema) : '';

if (!$is_demo && !$is_designer) {
    alert_close("관리자만 가능합니다.");
}

if (!$wid) {
	alert("설정값 아이디가 없습니다.");
}

// 타입설정
$type = ($add) ? 101 : 100;

if($mode == "save") {

	if (!$is_designer) {
		alert("관리자만 가능합니다.");
	}

	$wconfig = apms_pack($_POST['wset']);
	$sql_wm = "";
	if($_POST['wmset']) {
		$wmconfig = apms_pack($_POST['wmset']);
		$sql_wm = ", data_1 = '{$wmconfig}'";
	}

	// 기존값 삭제
	sql_query(" delete from {$g5['apms_data']} where type = '{$type}' and data_q = '{$wid}' ");

	// 신규등록
	sql_query(" insert {$g5['apms_data']} set type = '{$type}', data_q = '{$wid}', data_set = '{$wconfig}' $sql_wm ");

	// 캐시 갱신
	if($add) { // 애드온
		$c_name1 = 'aid_'.$wid; //캐시아이디 - PC
		$c_name2 = 'aid_'.$wid.'_m'; //캐시아이디 - MOBILE
	} else {
		$c_name1 = 'wid_'.$wid; //캐시아이디 - PC
		$c_name2 = 'wid_'.$wid.'_m'; //캐시아이디 - MOBILE
	}
	sql_query(" update {$g5['apms_cache']} set c_datetime = '0' where c_name = '$c_name1' ", false);
	sql_query(" update {$g5['apms_cache']} set c_datetime = '0' where c_name = '$c_name2' ", false);

	$goto_url = './widget.setup.php?wid='.urlencode($wid).'&amp;wname='.urlencode($wname).'&amp;thema='.urlencode($thema);
	if($add) $goto_url .= '&amp;add=1';
	if($wdemo) $goto_url .= '&amp;wdemo=1';
	if($wdir) $goto_url .= '&amp;wdir='.urlencode($wdir);

	if($del) { //초기화시
		sql_query(" delete from {$g5['apms_data']} where type = '{$type}' and data_q = '{$wid}' ", false);
		sql_query(" delete from {$g5['apms_cache']} where c_name = '$c_name1' ", false);
		sql_query(" delete from {$g5['apms_cache']} where c_name = '$c_name2' ", false);
	}

	goto_url($goto_url);
}

if (!$wdir && !$wdemo && !$is_designer) {
    alert_close("관리자만 가능합니다.");
}

if(!$wid || !$thema) {
    alert_close('값이 넘어오지 않았습니다.');
}

define('THEMA', $thema);
define('THEMA_PATH', G5_PATH.'/thema/'.$thema);
define('THEMA_URL', G5_URL.'/thema/'.$thema);

if($wdir) {
	$widget_url = G5_URL.$wdir.'/'.$wname;
	$widget_path = G5_PATH.$wdir.'/'.$wname;
	$widget_file = $widget_path.'/widget.setup.php';
} else if($wname) {
	if($add) {
		$widget_url = G5_SKIN_URL.'/addon/'.$wname;
		$widget_path = G5_SKIN_PATH.'/addon/'.$wname;
	} else {
		$widget_url = THEMA_URL.'/widget/'.$wname;
		$widget_path = THEMA_PATH.'/widget/'.$wname;
	}
	$widget_file = $widget_path.'/widget.setup.php';
} else {
   alert_close('값이 넘어오지 않았습니다.');
}

if(!file_exists($widget_file)) {
    alert_close('설정을 할 수 없는 위젯입니다.');
}

// 불러오기
$row = sql_fetch("select data_set, data_1 from {$g5['apms_data']} where type = '{$type}' and data_q = '{$wid}' limit 1 ");

if($row['data_set']) {
	$wset = apms_unpack($row['data_set']);
	$wmset = apms_unpack($row['data_1']);
} else if(isset($opt) && $opt) {
	$wset = apms_query($opt);
	$wmset = (isset($mopt) && $mopt) ? apms_query($mopt) : $wset;
}

if($add) { // 애드온
	$txt = '애드온';
	$loc = ($wdir) ? $wdir : '/skin/addon/'.$wname;
} else {
	$txt = '위젯';
	$loc = ($wdir) ? $wdir : '/thema/'.THEMA.'/widget/'.$wname;
}

// 초기값
$wset['new'] = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red';

$g5['title'] = $txt.' 설정';
include_once(G5_PATH.'/head.sub.php');
?>
<style>
 .local_desc01 ul, .local_desc01 ol { padding-bottom:0px; }
</style>
<div id="sch_widget_frm" class="new_win bsp_new_win">
    <h1 style="margin-bottom:0px;">
		<?php echo $txt;?> 아이디 : <span style="letter-spacing:0px;"><?php echo $wid;?></span>
	</h1>
	<div class="local_ov01 local_ov" style="border-top:1px solid #e9e9e9;">
		<?php if($is_demo) { ?>
			<?php echo $txt;?> 폴더명 : <?php echo $wname;?>
		<?php } else { ?>
			<?php echo $txt;?> 파일위치 : <?php echo $loc;?>
		<?php } ?>
	</div>

	<form id="wsetup" name="wsetup" method="post">
	<input type="hidden" name="mode" value="save">
	<input type="hidden" name="wid" value="<?php echo $wid;?>">
	<input type="hidden" name="wname" value="<?php echo $wname;?>">
	<input type="hidden" name="wdir" value="<?php echo $wdir;?>">
	<input type="hidden" name="wdemo" value="<?php echo $wdemo;?>">
	<input type="hidden" name="thema" value="<?php echo $thema;?>">
	<input type="hidden" name="add" value="<?php echo $add;?>">

	<?php include_once($widget_file); ?>

	<div style="margin:0 20px 20px;">
		<label><input type="checkbox" name="del" value="1"> <?php echo $txt;?> 초기화 및 캐시 삭제하기</label>
	</div>

    <div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit" accesskey="s">
		<button type="button" onclick="window.close();">닫기</button>
    </div>
	</form>
	<br>
</div>
<script>
var win_h = parseInt($('#sch_widget_frm').height()) + 80;
if(win_h > screen.height) {
    win_h = screen.height - 40;
}

window.moveTo(0, 0);
window.resizeTo(<?php echo (isset($win_size) && $win_size > 0) ? $win_size : 640;?>, win_h);
</script>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
