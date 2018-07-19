<?php
define('G5_IS_ADMIN', true);
include_once ('../common.php');
include_once(G5_LIB_PATH.'/apms.widget.lib.php');

if (!$is_demo && !$is_designer) {
    alert_close("관리자만 가능합니다.");
}

$skin_thema = '';
if($skin == 'list') { //상품목록
	if(!$ca_id) 
		alert_close('값이 넘어오지 않았습니다.');

	$row = sql_fetch(" select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id'");
	if (!$row['ca_id'])
		alert_close('값이 넘어오지 않았습니다.');

	$skin_set = $row['as_'.MOBILE_.'list_set'];
	$skin_name = (isset($name) && $name) ? $name : $row['ca_'.MOBILE_.'skin'];
	$skin_path = G5_SKIN_PATH.'/apms/list/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/list/'.$skin_name;
	$title = '상품목록';
} else if($skin == 'item') { //상품목록
	if(!$ca_id) 
		alert_close('값이 넘어오지 않았습니다.');

	$row = sql_fetch(" select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id'");
	if (!$row['ca_id'])
		alert_close('값이 넘어오지 않았습니다.');

	$skin_set = $row['as_'.MOBILE_.'item_set'];
	$skin_name = (isset($name) && $name) ? $name : $row['ca_'.MOBILE_.'skin_dir'];
	$skin_path = G5_SKIN_PATH.'/apms/item/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/item/'.$skin_name;
	$title = '상품설명';
} else if($skin == 'ev') { //이벤트 상품
	if(!$ev_id) 
		alert_close('값이 넘어오지 않았습니다.');

	$row = sql_fetch(" select * from {$g5['g5_shop_event_table']} where ev_id = '$ev_id' ");
	if (!$row['ev_id'])
		alert_close('값이 넘어오지 않았습니다.');

	$skin_set = $row['ev_'.MOBILE_.'set'];
	$skin_name = (isset($name) && $name) ? $name : $row['ev_'.MOBILE_.'skin'];
	$skin_path = G5_SKIN_PATH.'/apms/list/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/list/'.$skin_name;
	$title = '이벤트 상품목록';
} else if($skin == 'event') { //이벤트
	$row = apms_rows();
	$skin_set = $row['event_'.MOBILE_.'set'];
	$skin_name = (isset($name) && $name) ? $name : $row['event_'.MOBILE_.'skin'];
	$skin_path = G5_SKIN_PATH.'/apms/event/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/event/'.$skin_name;
	$title = '이벤트';
	$skin_thema = 'shop/event';
} else if($skin == 'type') { //상품유형
	$row = apms_rows();
	$skin_set = $row['type_'.MOBILE_.'set'];
	$skin_name = (isset($name) && $name) ? $name : $row['type_'.MOBILE_.'skin'];
	$skin_path = G5_SKIN_PATH.'/apms/type/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/type/'.$skin_name;
	$title = '상품유형';
	$skin_thema = 'shop/type';
} else if($skin == 'myshop') { //마이샵
	$row = apms_rows();
	$skin_set = $row['myshop_'.MOBILE_.'set'];
	$skin_name = (isset($name) && $name) ? $name : $row['myshop_'.MOBILE_.'skin'];
	$skin_path = G5_SKIN_PATH.'/apms/myshop/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/myshop/'.$skin_name;
	$title = '마이샵';
	$skin_thema = 'shop/myshop';
} else if($skin == 'search') { //상품검색
	$row = apms_rows();
	$skin_set = $row['search_'.MOBILE_.'set'];
	$skin_name = (isset($name) && $name) ? $name : $default['de_'.MOBILE_.'search_list_skin'];
	$skin_path = G5_SKIN_PATH.'/apms/search/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/search/'.$skin_name;
	$title = '상품검색';
	$skin_thema = 'shop/search';
} else if($skin == 'qa') { //상품문의
	$row = apms_rows();
	$skin_set = $row['qa_'.MOBILE_.'set'];
	$skin_name = (isset($name) && $name) ? $name : $row['qa_'.MOBILE_.'skin'];
	$skin_path = G5_SKIN_PATH.'/apms/qa/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/qa/'.$skin_name;
	$title = '상품문의';
	$skin_thema = 'shop/qa';
} else if($skin == 'use') { //상품후기
	$row = apms_rows();
	$skin_set = $row['use_'.MOBILE_.'set'];
	$skin_name = (isset($name) && $name) ? $name : $row['use_'.MOBILE_.'skin'];
	$skin_path = G5_SKIN_PATH.'/apms/use/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/use/'.$skin_name;
	$title = '상품후기';
	$skin_thema = 'shop/use';
} else if($skin == 'order') { //주문/결제
	$row = apms_rows();
	$skin_set = $row['order_'.MOBILE_.'set'];
	$skin_name = (isset($name) && $name) ? $name : $row['order_'.MOBILE_.'skin'];
	$skin_path = G5_SKIN_PATH.'/apms/order/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/order/'.$skin_name;
	$title = '주문/결제';
	$skin_thema = 'shop/order';
} else if($skin == 'cz') { //쿠폰존
	$row = apms_rows();
	$skin_set = $row['cz_'.MOBILE_.'set'];
	$skin_name = (isset($name) && $name) ? $name : $row['cz_'.MOBILE_.'skin'];
	$skin_path = G5_SKIN_PATH.'/apms/couponzone/'.$skin_name;
	$skin_url = G5_SKIN_URL.'/apms/couponzone/'.$skin_name;
	$title = '쿠폰존';
	$skin_thema = 'shop/couponzone';
} else {
   alert_close('값이 넘어오지 않았습니다.');
}

// 테마스킨 체크
if(isset($ts) && $ts && $skin_thema) {
	define('THEMA', $ts);
	define('THEMA_PATH', G5_PATH.'/thema/'.$ts);
	define('THEMA_URL', G5_URL.'/thema/'.$ts);
	list($skin_path, $skin_url) = apms_skin_thema($skin_thema, $skin_path, $skin_url); 
}

$skin_file = $skin_path.'/setup.skin.php';

if(!file_exists($skin_file)) {
    alert_close('설정을 할 수 없는 스킨입니다.');
}

if($mode == "save") {

	if (!$is_designer) {
		alert("관리자만 가능합니다.");
	}

	$wset = (isset($del) && $del) ? '' : apms_pack($_POST['wset']);

	if(isset($both) && $both) { //PC, 모바일 동일값 적용
		if($skin == 'list') {
			sql_query(" update {$g5['g5_shop_category_table']} set as_list_set = '{$wset}', as_mobile_list_set = '{$wset}' where ca_id = '{$ca_id}' ", false);
		} else if($skin == 'item') {
			sql_query(" update {$g5['g5_shop_category_table']} set as_item_set = '{$wset}', as_mobile_item_set = '{$wset}' where ca_id = '{$ca_id}' ", false);
		} else if($skin == 'ev') {
			sql_query(" update {$g5['g5_shop_event_table']} set ev_set = '{$wset}', ev_mobile_set = '{$wset}' where ev_id = '{$ev_id}' ", false);
		} else {
			sql_query(" update {$g5['apms_rows']} set {$skin}_set = '{$wset}', {$skin}_mobile_set = '{$wset}' ", false);
		}
	} else {
		if(G5_IS_MOBILE) {
			if($skin == 'list') {
				sql_query(" update {$g5['g5_shop_category_table']} set as_mobile_list_set = '{$wset}' where ca_id = '{$ca_id}' ", false);
			} else if($skin == 'item') {
				sql_query(" update {$g5['g5_shop_category_table']} set as_mobile_item_set = '{$wset}' where ca_id = '{$ca_id}' ", false);
			} else if($skin == 'ev') {
				sql_query(" update {$g5['g5_shop_event_table']} set ev_mobile_set = '{$wset}' where ev_id = '{$ev_id}' ", false);
			} else {
				sql_query(" update {$g5['apms_rows']} set {$skin}_mobile_set = '{$wset}' ", false);
			}
		} else {
			if($skin == 'list') {
				sql_query(" update {$g5['g5_shop_category_table']} set as_list_set = '{$wset}' where ca_id = '{$ca_id}' ", false);
			} else if($skin == 'item') {
				sql_query(" update {$g5['g5_shop_category_table']} set as_item_set = '{$wset}' where ca_id = '{$ca_id}' ", false);
			} else if($skin == 'ev') {
				sql_query(" update {$g5['g5_shop_event_table']} set ev_set = '{$wset}' where ev_id = '{$ev_id}' ", false);
			} else {
				sql_query(" update {$g5['apms_rows']} set {$skin}_set = '{$wset}' ", false);
			}
		}
	}

	// 하위분류 일괄적용
	if($csub && ($skin == 'list' || $skin == 'item')) {

		//리스트 설정값
        $len = strlen($ca_id);
		if($skin == 'list') {
			$ca = sql_fetch(" select as_list_set, as_mobile_list_set from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' ", false);

			if(isset($both) && $both) { //PC, 모바일 동일값 적용
				$as_list_set = "as_list_set = '".addslashes($ca['as_list_set'])."', as_mobile_list_set = '".addslashes($ca['as_mobile_list_set'])."'";
			} else {
				if(G5_IS_MOBILE) {
					$as_list_set = "as_mobile_list_set = '".addslashes($ca['as_mobile_list_set'])."'";
				} else {
					$as_list_set = "as_list_set = '".addslashes($ca['as_list_set'])."'";
				}
			}

			sql_query(" update {$g5['g5_shop_category_table']} set $as_list_set where SUBSTRING(ca_id,1,$len) = '$ca_id' ", false);

		} else if($skin == 'item') {
			$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' ", false);

			if(isset($both) && $both) { //PC, 모바일 동일값 적용
				$as_item_set = "as_item_set = '".addslashes($ca['as_item_set'])."', as_mobile_item_set = '".addslashes($ca['as_mobile_item_set'])."'";
			} else {
				if(G5_IS_MOBILE) {
					$as_item_set = "as_mobile_item_set = '".addslashes($ca['as_mobile_item_set'])."'";
				} else {
					$as_item_set = "as_item_set = '".addslashes($ca['as_item_set'])."'";
				}
			}

			sql_query(" update {$g5['g5_shop_category_table']} set $as_item_set where SUBSTRING(ca_id,1,$len) = '$ca_id' ", false);
		}
	}

	$goto_url = './skin.setup.php?skin='.urlencode($skin).'&amp;ts='.urlencode($ts);
	if($ca_id) $goto_url .= '&amp;ca_id='.urlencode($ca_id);
	if($ev_id) $goto_url .= '&amp;ev_id='.urlencode($ev_id);
	if($name) $goto_url .= '&amp;name='.urlencode($name);

	goto_url($goto_url);
}

$wset = apms_unpack($skin_set);

$g5['title'] = $title.' 스킨설정';
include_once(G5_PATH.'/head.sub.php');
?>
<div id="sch_shop_frm" class="new_win bsp_new_win">
    <h1><?php echo $g5['title'];?></h1>
	<form id="fsetup" name="fsetup" method="post">
	<input type="hidden" name="mode" value="save">
	<input type="hidden" name="skin" value="<?php echo $skin;?>">
	<input type="hidden" name="name" value="<?php echo $name;?>">
	<input type="hidden" name="ca_id" value="<?php echo $ca_id;?>">
	<input type="hidden" name="ev_id" value="<?php echo $ev_id;?>">
	<input type="hidden" name="ts" value="<?php echo $ts;?>">

	<?php include_once($skin_file); ?>

	<div style="margin:0 20px 20px;">
		<?php if($skin == 'list' || $skin == 'item') { ?>
			<label><input type="checkbox" name="csub" value="1"> 하위분류 일괄적용하기</label>
			&nbsp;
		<?php } ?>
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
var win_h = parseInt($('#sch_shop_frm').height()) + 80;
if(win_h > screen.height) {
    win_h = screen.height - 40;
}

window.moveTo(0, 0);
window.resizeTo(<?php echo (isset($win_size) && $win_size > 0) ? $win_size : 640;?>, win_h);
</script>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
