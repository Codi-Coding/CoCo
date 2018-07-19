<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/item.php');
    return;
}

include_once(G5_LIB_PATH.'/iteminfo.lib.php');

//이벤트
$ev_id = (isset($ev_id) && $ev_id) ? $ev_id : '';
if($ev_id) {
	$ev = sql_fetch(" select * from {$g5['g5_shop_event_table']} where ev_id = '$ev_id' and ev_use = 1 ");
	if (!$ev['ev_id']) $ev_id = '';
}

// 타입지정
$type_where = $type_qstr = '';
if(isset($type) && $type) {
	$type_where = " and it_type{$type} = '1'";
	$type_qstr = '&amp;type='.$type;
}

// 페이지 초기화
$is_item = true;
$itempage = $page;
$page = 0;

$it_id = trim($_GET['it_id']);

// 분류사용, 상품사용하는 상품의 정보를 얻음
$sql_ca = ($ca_id) ? "b.ca_id = '{$ca_id}'" : "a.ca_id = b.ca_id";
$sql = " select a.*, b.ca_name, b.ca_use from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b where a.it_id = '$it_id' and $sql_ca ";
$it = sql_fetch($sql);

if (!$it['it_id'])
    alert('자료가 없습니다.');

// 멤버쉽 확인 ------------------------
if (function_exists('apms_membership_item')) {
	apms_membership_item($it['it_id']);
}

// 이용권한 확인 ------------------------
$is_author = ($is_member && $it['pt_id'] && $it['pt_id'] == $member['mb_id']) ? true : false;
$is_purchaser = apms_admin($xp['xp_manager']);
$is_remaintime = '';
if (!$is_purchaser && !$is_auther) {
	$purchase = apms_it_payment($it['it_id']);
	$is_purchaser = ($purchase['ct_qty'] > 0) ? true : false;
	if($it['pt_day'] > 0) { //기간제 상품일 경우
		$is_remaintime = strtotime($purchase['pt_datetime']) + ($it['pt_day'] * $purchase['ct_qty'] * 86400);
		$is_purchaser = ($is_remaintime >= G5_SERVER_TIME) ? true : false;
	}
}

if ($is_admin || $is_author || $is_purchaser) {
	;
} else {
	if (!($it['ca_use'] && $it['it_use'])) {
        alert('판매가능한 상품이 아닙니다.');
	}

	$it['pt_explan'] = $it['pt_mobile_explan'] = '';
}

// ----------------------------------------------------------

// 분류코드
$ca_id = ($ca_id) ? $ca_id : $it['ca_id'];

// 공통쿼리
$it_sql_common = " it_use = '1' and (ca_id like '{$ca_id}%' or ca_id2 like '{$ca_id}%' or ca_id3 like '{$ca_id}%') $type_where ";

// 분류 테이블에서 분류 상단, 하단 코드를 얻음
//$sql = " select ca_{$mobile}skin_dir, ca_include_head, ca_include_tail, ca_cert_use, ca_adult_use from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ";
$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ";
$ca = sql_fetch($sql);

// 테마체크
$at = apms_ca_thema($ca_id, $ca);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

// 본인인증, 성인인증체크
$is_cert = false;
if(!$is_admin) {
    $is_cert = shop_member_cert_check($it_id, 'item');
    if($is_cert)
        alert($is_cert, G5_SHOP_URL);
}

// 등록자 정보
$author_id = ($it['pt_id']) ? $it['pt_id'] : $config['cf_admin'];
$author = apms_member($author_id);
$author_photo = $author['photo'];
if($author['mb_open']) {
	$author['homepage'] = set_http(clean_xss_tags($author['mb_homepage']));
	$author['email'] = $author['mb_email'];
} else {
	$author['email'] = $author['mb_email'] = '';
	$author['homepage'] = $author['mb_homepage'] = '';
}
$author['profile'] = ($author['mb_profile']) ? conv_content($author['mb_profile'],0) : '';
$author['signature'] = ($author['mb_signature']) ? apms_content(conv_content($author['mb_signature'], 1)) : '';

// 오늘 본 상품 저장 시작
// tv 는 today view 약자
$saved = false;
$tv_idx = (int)get_session("ss_tv_idx");
if ($tv_idx > 0) {
    for ($i=1; $i<=$tv_idx; $i++) {
        if (get_session("ss_tv[$i]") == $it_id) {
            $saved = true;
            break;
        }
    }
}

if (!$saved) {
    $tv_idx++;
    set_session("ss_tv_idx", $tv_idx);
    set_session("ss_tv[$tv_idx]", $it_id);
}
// 오늘 본 상품 저장 끝

// 조회수 증가
if (get_cookie('ck_it_id') != $it_id) {
    sql_query(" update {$g5['g5_shop_item_table']} set it_hit = it_hit + 1 where it_id = '$it_id' "); // 1증가
    set_cookie("ck_it_id", $it_id, 3600); // 1시간동안 저장
}

// 첨부파일, 태그, 옵션
$is_download = 0;
$is_viewer = 0;
$is_torrent = false;

// 첨부파일이 있으면 실행
if($it['pt_file']) {

	$view_ok = array("1", "2", "3", "4");
	$attach = array();
	$torrent = array();
	$free_view = array();
	$free_down = array();
	$pay_view = array();
	$pay_down = array();
	$download = array();
	$viewer = array();

	$attach = apms_get_file('item', $it['it_id']);
	$attach_cnt = count($attach);
	for($i=0; $i < $attach_cnt; $i++) {
		$attach[$i]['free'] = 1;
		if($attach[$i]['purchase_use']) {
			$attach[$i]['free'] = 0;
			if($is_admin || $is_author || $is_purchaser) { // 링크 재설정
				;
			} else {
				$attach[$i]['href'] = '';
				$attach[$i]['href_view'] = '';
			}
		}

		if($attach[$i]['view_use'] && in_array($attach[$i]['ext'], $view_ok)) {
			if($attach[$i]['purchase_use']) {
				$pay_view[] = $attach[$i];
			} else {
				$free_view[] = $attach[$i];
			}
			$is_viewer++;
		}

		if($attach[$i]['download_use']) {
			if($attach[$i]['purchase_use']) {
				$pay_down[] = $attach[$i];
			} else {
				$free_down[] = $attach[$i];
			}
			$is_download++;
		}
	}

	if($is_download) {
		for($i=0; $i < count($pay_down); $i++) {
			$download[] = $pay_down[$i];
		}
		for($i=0; $i < count($free_down); $i++) {
			$download[] = $free_down[$i];
		}
	}

	if($is_viewer) {
		for($i=0; $i < count($pay_view); $i++) {
			$viewer[] = $pay_view[$i];
		}
		for($i=0; $i < count($free_view); $i++) {
			$viewer[] = $free_view[$i];
		}
	}

	// 토렌트 정보
	if($attach['torrent']) {
		$torrent = apms_get_torrent($attach);
		$is_torrent = true;
	}
}

// 썸네일보기
$is_thumbview = ($it['pt_img']) ? false : true;

// 페이지체크
$ss_name = 'ss_item_'.$it['it_id'];
if (!get_session($ss_name)) {
	set_session($ss_name, TRUE);
}

//날짜
$it['datetime'] = strtotime($it['it_time']);

// 추천
$is_good = ($default['pt_good_use']) ? true : false;
$good_href = G5_SHOP_URL.'/good.php?it_id='.$it['it_id'].'&amp;good=good';
$nogood_href = G5_SHOP_URL.'/good.php?it_id='.$it['it_id'].'&amp;good=nogood';

if(G5_IS_MOBILE) {
	$it['it_explan'] = ($it['it_mobile_explan']) ? $it['it_mobile_explan'] : $it['it_explan'];
	$it['pt_explan'] = ($it['pt_mobile_explan']) ? $it['pt_mobile_explan'] : $it['pt_explan'];
} 

// 보안서버경로
if (G5_HTTPS_DOMAIN)
    $action_url = G5_HTTPS_DOMAIN.'/'.G5_SHOP_DIR.'/cartupdate.php';
else
    $action_url = './cartupdate.php';

// 이벤트 상품일 경우 - 전체목록, 이전, 다음 출력안함
if($ev_id) {
	$ca['pt_item'] = "";
	$prev_item = $prev_href = '';
	$next_item = $next_href = '';
} else {
	// 이전 상품보기
	$prev_next_sql = "and (ca_id = '{$ca_id}' or ca_id2 = '{$ca_id}' or ca_id3 = '{$ca_id}') and it_use = '1' $type_where ";
	$sql = " select it_id, it_name from {$g5['g5_shop_item_table']} where it_id > '$it_id' $prev_next_sql order by it_id asc limit 1 ";
	$row = sql_fetch($sql);
	if ($row['it_id']) {
		$prev_item = get_text($row['it_name']);
		$prev_href = './item.php?it_id='.$row['it_id'].'&amp;ca_id='.$ca_id.$type_qstr;
	} else {
		$prev_item = $prev_href = '';
	}

	// 다음 상품보기
	$sql = " select it_id, it_name from {$g5['g5_shop_item_table']} where it_id < '$it_id' $prev_next_sql order by it_id desc limit 1 ";
	$row = sql_fetch($sql);
	if ($row['it_id']) {
		$next_item = get_text($row['it_name']);
		$next_href = './item.php?it_id='.$row['it_id'].'&amp;ca_id='.$ca_id.$type_qstr;
	} else {
		$next_item = $next_href = '';
	}
}

// 고객선호도 별점수
//$star_score = get_star_image($it['it_id']);

// 관리자가 확인한 사용후기의 개수를 얻음
//$row = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ");
$item_use_count = (int)$it['it_use_cnt'];

// 상품문의의 개수를 얻음
//$row = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_item_qa_table']}` where it_id = '{$it_id}' ");
$item_qa_count = (int)$it['pt_qa'];

// 관련상품의 개수를 얻음
$item_relation_count = 0;
if($default['de_rel_list_use']) {
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
    $row = sql_fetch($sql);
    $item_relation_count = $row['cnt'];
}
$is_relation = ($item_relation_count > 0) ? true : false;

// 소셜 관련
$sns_title = get_text($it['it_name']).' | '.get_text($config['cf_title']);
$sns_url  = G5_SHOP_URL.'/item.php?it_id='.$it['it_id'];

// 상품품절체크
if(G5_SOLDOUT_CHECK)
    $is_soldout = is_soldout($it['it_id']);

// 주문가능체크
$is_orderable = true;
if(!$it['it_use'] || $it['it_tel_inq'] || $is_soldout) {
    $is_orderable = false;
}

// 주문폼 출력체크
$is_orderform = 1;
if($it['pt_order']) {
    $is_orderable = false;
	$is_orderform = '';
}

// 네이버페이
$naverpay_button_js = '';
if($is_orderable) {
    // 선택 옵션
    $option_item = get_item_options($it['it_id'], $it['it_option_subject']);

    // 추가 옵션
    $supply_item = get_item_supply($it['it_id'], $it['it_supply_subject']);

    // 상품 선택옵션 수
    $option_count = 0;
    if($it['it_option_subject']) {
        $temp = explode(',', $it['it_option_subject']);
        $option_count = count($temp);
    }

    // 상품 추가옵션 수
    $supply_count = 0;
    if($it['it_supply_subject']) {
        $temp = explode(',', $it['it_supply_subject']);
        $supply_count = count($temp);
    }

	include_once(G5_SHOP_PATH.'/settle_naverpay.inc.php');
}

// 정보고시
$ii = array();
$is_ii = false;
if($it['it_info_value']) { // 상품 정보 고시
	$info_data = unserialize(stripslashes($it['it_info_value']));
	if(is_array($info_data)) {
		$gubun = $it['it_info_gubun'];
		$info_array = $item_info[$gubun]['article'];
		$i = 0;
		foreach($info_data as $key=>$val) {
			$ii[$i]['title'] = $info_array[$key][0];
			$ii[$i]['value'] = $val;
			$i++;
		}
		$is_ii = true;
	} else {																
		if($is_admin) {
			$ii[0]['title'] = '출력오류';
			$ii[0]['value'] = '상품 정보 고시 정보가 올바르게 저장되지 않았습니다. config.php 파일의 G5_ESCAPE_FUNCTION 설정을 addslashes 로 변경하신 후 관리자 &gt; 상품정보 수정에서 상품 정보를 다시 저장해주세요.';
			$is_ii = true;
		}
	}
}

// Comment
$is_comment = ($it['pt_comment_use']) ? true : false;

// Tag
$is_tag = false;
if($it['pt_tag']) {
	$tag_list = apms_get_tag($it['pt_tag']);
	if($tag_list) $is_tag = true;
}

// CCL
$is_ccl = false;
if($it['pt_ccl']) {
	switch($it['pt_ccl']) {
		case '1' : $ccl_img = 'lic_by_g.gif'; $ccl_href = 'by/2.0/kr/'; $ccl_license = '저작자표시'; break;
		case '2' : $ccl_img = 'lic_by_nc_g.gif'; $ccl_href = 'by-nc/2.0/kr/'; $ccl_license = '저작자표시-비영리'; break;
		case '3' : $ccl_img = 'lic_by_nd_g.gif'; $ccl_href = 'by-nd/2.0/kr/'; $ccl_license = '저작자표시-변경금지'; break;
		case '4' : $ccl_img = 'lic_by_sa_g.gif'; $ccl_href = 'by-sa/2.0/kr/'; $ccl_license = '저작자표시-동일조건변경허락'; break;
		case '5' : $ccl_img = 'lic_by_nc_sa_g.gif'; $ccl_href = 'by-nc-sa/2.0/kr/'; $ccl_license = '저작자표시-비영리-동일조건변경허락'; break;
		case '6' : $ccl_img = 'lic_by_nc_nd_g.gif'; $ccl_href = 'by-nc-nd/2.0/kr/'; $ccl_license = '저작자표시-비영리-변경금지'; break;
	}

	if($ccl_img) {
		$ccl_img = G5_URL.'/img/ccl/'.$ccl_img;
		$ccl_license = '<a href="http://creativecommons.org/licenses/'.$ccl_href.'" target="_blank">크리에이티브 커먼즈 '.$ccl_license.' 2.0 대한민국 라이선스</a>';
		$is_ccl = true;
	}
}

// 네비게이션
$nav = array();

if($ev_id) {
	$is_nav = true;
	$nav_title = get_text($ev['ev_subject']);
} else {
	// 분류내 상품수
	$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where $it_sql_common ");
	$total_items = $row['cnt'];

	$len = strlen($ca_id) / 2;
	$n=0;
	for ($i=1; $i<=$len; $i++) {
		$code = substr($ca_id,0,$i*2);
		$nav[$n]['ca_id'] = $code;

		$row = sql_fetch(" select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$code' ");
		$nav[$n]['name'] = $row['ca_name'];

		if($ca_id === $code) { // 현재 분류와 일치체크
			$nav[$n]['on'] = true;
			$nav[$n]['cnt'] = $total_items;
		} else {
			$nav[$n]['on'] = false;
			$nav[$n]['cnt'] = 0;
		}

		$n++;
	}

	$is_nav = ($n > 0) ? true : false;
	$nav_title = get_text($ca['ca_name']);
}

// 링크
$link_video = array();
$is_link = false;
$j = 0;
for($i=1; $i < 3; $i++) {
	if($it['pt_link'.$i]) {
		list($link[$j]['url'], $link[$j]['name'], $link[$j]['fa']) = explode("|", $it['pt_link'.$i]);
		$link_video[$i] = $link[$j]['url'];
		$j++;
		$is_link = true;
	}
}

// SEO 메타태그
$is_seometa = 'it';

//Code
if($default['pt_code']) {
	apms_script('code');
}

// Button
$item_href = $edit_href = '';
if(USE_PARTNER) {
	if ($is_admin == 'super' || $is_author) {
		$item_href = G5_SHOP_URL.'/partner/?ap=list';
		$edit_href = G5_SHOP_URL.'/partner/?ap=item&amp;w=u&amp;it_id='.$it_id.'&amp;fn='.$ca['pt_form'];
	}
	$write_href = ($is_admin == 'super' || IS_PARTNER) ? G5_SHOP_URL.'/partner/?ap=item&amp;fn='.$ca['pt_form'] : '';
} else {
	if ($is_admin == 'super') {
		$item_href = G5_ADMIN_URL.'/shop_admin/itemlist.php';
		$edit_href = G5_ADMIN_URL.'/shop_admin/itemform.php?w=u&amp;it_id='.$it_id.'&amp;fn='.$ca['pt_form'];
	}
	$write_href = ($is_admin == 'super') ? G5_ADMIN_URL.'/shop_admin/itemform.php?fn='.$ca['pt_form'] : '';
}

if($ev_id) {
	$list_href = ($itempage) ? './event.php?ev_id='.urlencode($ev_id).'&amp;page='.$itempage : './event.php?ev_id='.urlencode($ev_id);
} else {
	$list_href = ($itempage) ? './list.php?ca_id='.$ca_id.'&amp;page='.$itempage : './list.php?ca_id='.$ca_id;
}

$it_head_html = conv_content($it['it_'.MOBILE_.'head_html'], 1);
$it_tail_html = conv_content($it['it_'.MOBILE_.'tail_html'], 1);

// Rows
$itemrows = array();
$itemrows = apms_rows('icomment_'.MOBILE_.'rows, iuse_'.MOBILE_.'rows, iqa_'.MOBILE_.'rows, irelation_'.MOBILE_.'mods, irelation_'.MOBILE_.'rows');

// 스킨경로
$item_skin = apms_itemview_skin($at['item'], $ca_id, $it['ca_id']);

// 스킨설정
$wset = array();
if($ca['as_'.MOBILE_.'item_set']) {
	$wset = apms_unpack($ca['as_'.MOBILE_.'item_set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$item_skin_path = G5_SKIN_PATH.'/apms/item/'.$item_skin;
$item_skin_url = G5_SKIN_URL.'/apms/item/'.$item_skin;

// 셋업
$setup_href = '';
if (!$ev_id && is_file($item_skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
    $setup_href = './skin.setup.php?skin=item&amp;name='.urlencode($item_skin).'&amp;ca_id='.urlencode($ca_id);
}

// 페이지 타이틀
$g5['title'] = $it['it_name'].' > '.$it['ca_name'];

// 분류 상단 코드가 있으면 출력하고 없으면 기본 상단 코드 출력
if (!G5_IS_MOBILE && $ca['ca_include_head'])
    @include_once($ca['ca_include_head']);
else
    include_once('./_head.php');

$item_skin_file = $item_skin_path.'/item.skin.php';
if(file_exists($item_skin_file)) {
	include_once($item_skin_file);
} else {
	echo '<p>'.str_replace(G5_PATH.'/', '', $item_skin_file).' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</p>';
}

// 네이버페이
if($naverpay_button_js) {
?>
	<script>
	function fsubmit_check(f)
	{
		// 판매가격이 0 보다 작다면
		if (document.getElementById("it_price").value < 0) {
			alert("전화로 문의해 주시면 감사하겠습니다.");
			return false;
		}

		if($(".it_opt_list").size() < 1) {
			alert("상품의 선택옵션을 선택해 주십시오.");
			return false;
		}

		var val, io_type, result = true;
		var sum_qty = 0;
		var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
		var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
		var $el_type = $("input[name^=io_type]");

		$("input[name^=ct_qty]").each(function(index) {
			val = $(this).val();

			if(val.length < 1) {
				alert("수량을 입력해 주십시오.");
				result = false;
				return false;
			}

			if(val.replace(/[0-9]/g, "").length > 0) {
				alert("수량은 숫자로 입력해 주십시오.");
				result = false;
				return false;
			}

			if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
				alert("수량은 1이상 입력해 주십시오.");
				result = false;
				return false;
			}

			io_type = $el_type.eq(index).val();
			if(io_type == "0")
				sum_qty += parseInt(val);
		});

		if(!result) {
			return false;
		}

		if(min_qty > 0 && sum_qty < min_qty) {
			alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
			return false;
		}

		if(max_qty > 0 && sum_qty > max_qty) {
			alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
			return false;
		}

		return true;
	}
	</script>
<?php 
} //네이버페이

// 댓글
if($is_comment && $is_comment_write) {
?>
	<script>
	var save_before = '';
	var save_html = document.getElementById('it_vc_w').innerHTML;

	function fviewcomment_submit(f)	{
		var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
		var subject = "";
		var content = "";
		$.ajax({
			url: g5_bbs_url+"/ajax.filter.php",
			type: "POST",
			data: {
				"subject": "",
				"content": f.wr_content.value
			},
			dataType: "json",
			async: false,
			cache: false,
			success: function(data, textStatus) {
				subject = data.subject;
				content = data.content;
			}
		});

		if (content) {
			alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
			f.wr_content.focus();
			return false;
		}

		// 양쪽 공백 없애기
		var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
		document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
		if (!document.getElementById('wr_content').value) {
			alert("댓글을 입력하여 주십시오.");
			f.wr_content.focus();
			return false;
		}

		if (typeof(f.wr_name) != 'undefined') {
			f.wr_name.value = f.wr_name.value.replace(pattern, "");
			if (f.wr_name.value == '') {
				alert('이름이 입력되지 않았습니다.');
				f.wr_name.focus();
				return false;
			}
		}

		if (typeof(f.wr_password) != 'undefined') {
			f.wr_password.value = f.wr_password.value.replace(pattern, "");
			if (f.wr_password.value == '') {
				alert('비밀번호가 입력되지 않았습니다.');
				f.wr_password.focus();
				return false;
			}
		}

		set_comment_token(f);

		document.getElementById("btn_submit").disabled = "disabled";

		return true;
	}

	function comment_box(comment_id, work) {
		var el_id;
		// 댓글 아이디가 넘어오면 답변, 수정
		if (comment_id) {
			if (work == 'c')
				el_id = 'reply_' + comment_id;
			else
				el_id = 'edit_' + comment_id;
		}
		else
			el_id = 'it_vc_w';

		if (save_before != el_id) {
			if (save_before) {
				document.getElementById(save_before).style.display = 'none';
				document.getElementById(save_before).innerHTML = '';
			}

			document.getElementById(el_id).style.display = '';
			document.getElementById(el_id).innerHTML = save_html;
			// 댓글 수정
			if (work == 'cu') {
				document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
				if (document.getElementById('secret_comment_'+comment_id).value)
					document.getElementById('wr_secret').checked = true;
				else
					document.getElementById('wr_secret').checked = false;
			}

			document.getElementById('comment_id').value = comment_id;
			document.getElementById('w').value = work;

			// 페이지
			if (comment_id) {
				document.getElementById('comment_page').value = document.getElementById('comment_page_'+comment_id).value;
				document.getElementById('comment_url').value = document.getElementById('comment_url_'+comment_id).value;
			} else {
				document.getElementById('comment_page').value = '';
				document.getElementById('comment_url').value = './itemcomment.php?it_id=<?php echo $it_id;?>&ca_id=<?php echo $ca_id;?>&crows=<?php echo $crows;?>';
			}

			save_before = el_id;
		}
	}

	comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

	$(function() {
		$("textarea#wr_content[maxlength]").live("keyup change", function() {
			var str = $(this).val()
			var mx = parseInt($(this).attr("maxlength"))
			if (str.length > mx) {
				$(this).val(str.substr(0, mx));
				return false;
			}
		});
		<?php if($is_comment_sns) { ?>
		// sns 등록
			$("#it_vc_send_sns").load(
				"./itemcommentsns.php?it_id=<?php echo $it_id; ?>",
				function() {
					save_html = document.getElementById('it_vc_w').innerHTML;
				}
			);
		<?php } ?>
	});
	</script>
<?php 
} // 댓글

if (!G5_IS_MOBILE && $ca['ca_include_tail'])
    @include_once($ca['ca_include_tail']);
else
    include_once('./_tail.php');

?>
