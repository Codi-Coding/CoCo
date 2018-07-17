<?php
include_once('./_common.php');

// 세션확인
$ss_name = 'ss_item_'.$pf_id;
if(!get_session($ss_name)) {
	alert_close("정상적인 접근이 아닙니다.");
}

if(!$pf_id) {
	alert_close("값이 제대로 넘어오지 않았습니다.");
}

// 상품정보
$it = apms_it($pf_id);

if(!$it['it_id']) {
	alert_close("존재하지 않는 자료입니다.");
}

// 다운로드
$no = (int)$no;

$file = sql_fetch(" select * from {$g5['apms_file']} where pf_id = '$pf_id' and pf_dir = '1' and pf_no = '$no' ");
if (!$file['pf_file']) {
    alert_close('파일 정보가 존재하지 않습니다.');
}

$filepath = G5_DATA_PATH.'/item/'.$pf_id.'/'.$file['pf_file'];
$filepath = addslashes($filepath);
if (!is_file($filepath) || !file_exists($filepath)) {
    alert_close('파일이 존재하지 않습니다.');
}

$ext_ok = array("1", "2", "3", "4");
if(!in_array($file['pf_ext'], $ext_ok)) { 
	alert_close("볼 수 없는 확장자를 가진 파일입니다.");
}

// 최고관리자와 판매자는 통과...
if(apms_admin($xp['xp_manager']) || ($is_member && $member['mb_id'] == $it['pt_id'])) {
	;
} else {
	if(!$file['pf_view_use']) { 
		alert_close("보기가 불가능한 파일입니다.");
	}

	if($file['pf_purchase_use']) { 

		// 비회원은 이용불가
		if($is_guest) {
			alert_close("회원만 보기가 가능합니다.");
		}

		// 구매여부
		$is_purchaser = false;
		$is_remaintime = '';
		$purchase = apms_it_payment($it['it_id']);
		$is_purchaser = ($purchase['ct_qty'] > 0) ? true : false;
		if($it['pt_day'] > 0) { //기간제 상품일 경우
			$is_remaintime = strtotime($purchase['pt_datetime']) + ($it['pt_day'] * $purchase['ct_qty'] * 86400);
			$is_purchaser = ($is_remaintime >= G5_SERVER_TIME) ? true : false;
		}

		// 사용로그 
		if($is_purchaser) {
			apms_it_used($purchase['od_id'], $it['pt_id'], $it['it_id'], $it['it_name'], $file['pf_source']);
		} else if($is_remaintime) {
			alert_close("이용기간(".date("Y/m/d H:i", $is_remaintime).")이 만료되었습니다.\\n\\n재구매후 이용가능합니다.");
		} else {
			alert_close("구매가 완료된 회원만 이용가능합니다.");
		}
	} else {
		// 비회원은 이용불가
		if(!$file['pf_guest_use'] && $is_guest) {
			alert_close("회원만 보기가 가능합니다.");
		}
	}

    // 보기 카운트 증가
    sql_query(" update {$g5['apms_file']} set pf_view = pf_view + 1 where pf_id = '$pf_id' and pf_dir = '1' and pf_no = '$no' ");
}

// 파일주소
$fileurl = G5_DATA_URL.'/item/'.$pf_id.'/'.$file['pf_file'];

if(!$ca_id) $ca_id = $it['ca_id'];
if(!defined('THEMA_PATH')) {
	$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
	$at = apms_ca_thema($ca_id, $ca, 1);
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
	$item_skin = apms_itemview_skin($at['item'], $ca_id, $it['ca_id']);

	// 스킨설정
	$wset = array();
	if($ca['as_'.MOBILE_.'item_set']) {
		$wset = apms_unpack($ca['as_'.MOBILE_.'item_set']);
	}

	// 데모
	if($is_demo) {
		@include (THEMA_PATH.'/assets/demo.config.php');
	}

	$item_skin_path = G5_SKIN_PATH.'/apms/item/'.$item_skin;
	$item_skin_url = G5_SKIN_URL.'/apms/item/'.$item_skin;
}

$g5['body_script'] = ' oncontextmenu="return false" onselectstart="return false" ondragstart="return false" ';
include_once(G5_PATH.'/head.sub.php');

if($file['pf_ext'] == "1") { //이미지 파일이면
	$width = $file['pf_width'];
	$height = $file['pf_height'];

	include_once($item_skin_path.'/viewimage.skin.php');

} else if($file['pf_ext'] == "2" || $file['pf_ext'] == "3") { //비디오 또는 오디오 파일이면

	$info = pathinfo($file['pf_source']);
	$filename = basename($file['pf_source'],'.'.$info['extension']);

	//이미지와 캡션이 있는지 검사
	$i_arr = array();
	$c_arr = array();
	$result = sql_query(" select * from {$g5['apms_file']} where pf_id = '$pf_id' and pf_dir = '1' and (pf_ext = '1' or pf_ext = '5')");
	while ($row = sql_fetch_array($result)) {
		$url = G5_DATA_URL.'/item/'.$pf_id.'/'.$row['pf_file'];
		$tmp = pathinfo($row['pf_source']);
		$name = basename($row['pf_source'],'.'.$tmp['extension']);
		if($filename == $name) {
			if($row['pf_ext'] == "5") { // 자막
				$c_arr[] = $url;
			} else {
				$i_arr[] = $url;
			}
		}
	}

	$image = ($i_arr[0]) ? 'image: "'.$i_arr[0].'",' : ''; //이미지
	$caption = ($c_arr[0]) ? 'tracks: [{file: "'.$c_arr[0].'"}],' : ''; //캡션

	include_once($item_skin_path.'/viewvideo.skin.php');

} else if($file['pf_ext'] == "4") {

	include_once($item_skin_path.'/viewpdf.skin.php');

} 
?>
<script type="text/javascript">

	//IE에서 금지합니다
	function click() {
		if ((event.button==2) || (event.button==3)) { 
			alert('마우스 오른쪽 버튼이 금지되었습니다'); 
	   } 
	} 
	document.onmousedown=click 

	//IE 이외에서도 금지합니다-Netscape
	if (navigator.appName == "Netscape") {
		document.captureEvents(Event.MOUSEDOWN) 
		document.onmousedown = checkClick 

		function checkClick(ev) { 
			if (ev.which != 1) { 
				alert('마우스 오른쪽 버튼이 금지되었습니다') 
				return false 
			} 
		} 
	} 
</script>
<?php 
include_once(G5_PATH.'/tail.sub.php'); 
?>