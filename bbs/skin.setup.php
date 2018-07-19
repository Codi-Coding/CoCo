<?php
define('G5_IS_ADMIN', true);
include_once ('../common.php');

if (!$is_demo && !$is_designer) {
    alert_close("관리자만 가능합니다.");
}

include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');
include_once(G5_LIB_PATH.'/apms.widget.lib.php');

if($skin == 'group') { //보드그룹
	$group_skin_path = G5_SKIN_PATH.'/group/'.$group['as_'.MOBILE_.'main'];
	$group_skin_url = G5_SKIN_URL.'/group/'.$group['as_'.MOBILE_.'main'];
	$skin_path = $group_skin_path;
	$skin_url = $group_skin_url;
	$title = $group['gr_subject'].' 보드그룹';
} else if($skin == 'connect') { //현재접속자
	$skin_path = $connect_skin_path;
	$skin_url = $connect_skin_url;
	$title = '현재접속자';
} else if($skin == 'faq') { //faq
	$skin_path = $faq_skin_path;
	$skin_url = $faq_skin_url;
	$title = 'FAQ';
} else if($skin == 'member') { //회원스킨
	$skin_path = $member_skin_path;
	$skin_url = $member_skin_url;
	$title = '회원스킨';
} else if($skin == 'new') { //새글
	$skin_path = $new_skin_path;
	$skin_url = $new_skin_url;
	$title = '새글모음';
} else if($skin == 'search') { //게시물검색
	$skin_path = $search_skin_url;
	$skin_url = $search_skin_path;
	$title = '게시물검색';
} else if($skin == 'tag') { //태그박스
	$skin_path = get_skin_path('tag', (G5_IS_MOBILE ? $config['as_mobile_tag_skin'] : $config['as_tag_skin']));
	$skin_url = get_skin_url('tag', (G5_IS_MOBILE ? $config['as_mobile_tag_skin'] : $config['as_tag_skin']));
	$title = '태그박스';
} else if($skin == 'qa') { //1:1문의
	$qaconfig = get_qa_config();
	$skin_path = get_skin_path('qa', (G5_IS_MOBILE ? $qaconfig['qa_mobile_skin'] : $qaconfig['qa_skin']));
	$skin_url = get_skin_url('qa', (G5_IS_MOBILE ? $qaconfig['qa_mobile_skin'] : $qaconfig['qa_skin']));
	$title = '1:1문의';
} else {
   alert_close('값이 넘어오지 않았습니다.');
}

// 테마스킨 체크
if(isset($ts) && $ts) {
	define('THEMA', $ts);
	define('THEMA_PATH', G5_PATH.'/thema/'.$ts);
	define('THEMA_URL', G5_URL.'/thema/'.$ts);
	list($skin_path, $skin_url) = apms_skin_thema($skin, $skin_path, $skin_url); 
}

$skin_file = $skin_path.'/setup.skin.php';

if(!is_file($skin_file)) {
    alert_close('설정을 할 수 없는 스킨입니다.');
}

if(isset($mode) && $mode == "save") {

	if (!$is_designer) {
		alert("관리자만 가능합니다.");
	}

	$wset = (isset($del) && $del) ? '' : apms_pack($_POST['wset']);

	$sql_group = $ins_group = "";
	if($gr_id) {
		$sql_group = "and data_1 = '{$gr_id}'";
		$ins_group = ", data_1 = '{$gr_id}'";
	}

	// 등록여부 체크
	if(G5_IS_MOBILE) {
		$data = sql_fetch(" select * from {$g5['apms_data']} where type = '30' and data_q = '{$skin}_mobile' $sql_group ");
		if($data['id']) {
			sql_query(" update {$g5['apms_data']} set data_set = '{$wset}' where type = '30' and data_q = '{$skin}_mobile' $sql_group ");
		} else {
			sql_query(" insert {$g5['apms_data']} set type = '30', data_q = '{$skin}_mobile', data_set = '{$wset}' $ins_group ");
		}
	} else {
		$data = sql_fetch(" select * from {$g5['apms_data']} where type = '30' and data_q = '{$skin}' $sql_group ");
		if($data['id']) {
			sql_query(" update {$g5['apms_data']} set data_set = '{$wset}' where type = '30' and data_q = '{$skin}' $sql_group ");
		} else {
			sql_query(" insert {$g5['apms_data']} set type = '30', data_q = '{$skin}', data_set = '{$wset}' $ins_group ");
		}
	}

	if(isset($both) && $both) { //PC, 모바일 동일값 적용
		if(G5_IS_MOBILE) { //모바일은 PC값
			$data = sql_fetch(" select * from {$g5['apms_data']} where type = '30' and data_q = '{$skin}' $sql_group ");
			if($data['id']) {
				sql_query(" update {$g5['apms_data']} set data_set = '{$wset}' where type = '30' and data_q = '{$skin}' $sql_group ");
			} else {
				sql_query(" insert {$g5['apms_data']} set type = '30', data_q = '{$skin}', data_set = '{$wset}' $ins_group ");
			}
		} else { //PC는 모바일값
			$data = sql_fetch(" select * from {$g5['apms_data']} where type = '30' and data_q = '{$skin}_mobile' $sql_group ");
			if($data['id']) {
				sql_query(" update {$g5['apms_data']} set data_set = '{$wset}' where type = '30' and data_q = '{$skin}_mobile' $sql_group ");
			} else {
				sql_query(" insert {$g5['apms_data']} set type = '30', data_q = '{$skin}_mobile', data_set = '{$wset}' $ins_group ");
			}
		}
	}

	$goto_url = './skin.setup.php?skin='.urlencode($skin).'&amp;ts='.urlencode($ts);
	if($gr_id)
		$goto_url .= '&amp;gr_id='.$gr_id;

	goto_url($goto_url);
}

$wset = (G5_IS_MOBILE) ? apms_skin_set($skin.'_mobile', $gr_id) : apms_skin_set($skin, $gr_id);

$g5['title'] = $title.' 스킨설정';
include_once(G5_PATH.'/head.sub.php');
?>
<div id="sch_skin_frm" class="new_win bsp_new_win">
    <h1><?php echo $g5['title'];?></h1>
	<form id="fsetup" name="fsetup" method="post">
	<input type="hidden" name="mode" value="save">
	<input type="hidden" name="skin" value="<?php echo $skin;?>">
	<input type="hidden" name="ts" value="<?php echo $ts;?>">
	<input type="hidden" name="gr_id" value="<?php echo (isset($gr_id) && $gr_id) ? $gr_id : '';?>">

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
var win_h = parseInt($('#sch_skin_frm').height()) + 80;
if(win_h > screen.height) {
    win_h = screen.height - 40;
}

window.moveTo(0, 0);
window.resizeTo(<?php echo (isset($win_size) && $win_size > 0) ? $win_size : 640;?>, win_h);
</script>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
