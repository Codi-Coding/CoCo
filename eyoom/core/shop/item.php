<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/item.php');
	return;
}

$it_id = trim($_GET['it_id']);

include_once(G5_LIB_PATH.'/iteminfo.lib.php');

// 분류사용, 상품사용하는 상품의 정보를 얻음
$sql = " select a.*, b.ca_name, b.ca_use from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b where a.it_id = '$it_id' and a.ca_id = b.ca_id ";
$it = sql_fetch($sql);
if (!$it['it_id'])
	alert('자료가 없습니다.');
if (!($it['ca_use'] && $it['it_use'])) {
	if (!$is_admin)
		alert('현재 판매가능한 상품이 아닙니다.');
}

// 분류 테이블에서 분류 상단, 하단 코드를 얻음
$sql = " select ca_skin_dir, ca_include_head, ca_include_tail, ca_cert_use, ca_adult_use from {$g5['g5_shop_category_table']} where ca_id = '{$it['ca_id']}' ";
$ca = sql_fetch($sql);

// 본인인증, 성인인증체크
if(!$is_admin) {
	$msg = shop_member_cert_check($it_id, 'item');
	if($msg)
		alert($msg, G5_SHOP_URL);
}

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

$g5['title'] = $it['it_name'].' &gt; '.$it['ca_name'];

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

if ($ca['ca_include_head']) {
	@include_once($ca['ca_include_head']);
} else {
	// 이윰 테일 디자인 출력
	@include_once(EYOOM_SHOP_PATH.'/shop.head.php');
}

// 분류 위치
// HOME > 1단계 > 2단계 ... > 6단계 분류
$ca_id = $it['ca_id'];

// 보안서버경로
if (G5_HTTPS_DOMAIN)
	$action_url = G5_HTTPS_DOMAIN.'/'.G5_SHOP_DIR.'/cartupdate.php';
else
	$action_url = './cartupdate.php';

// 이전 상품보기
$sql = " select it_id, it_name from {$g5['g5_shop_item_table']} where it_id > '$it_id' and SUBSTRING(ca_id,1,4) = '".substr($it['ca_id'],0,4)."' and it_use = '1' order by it_id asc limit 1 ";
$row = sql_fetch($sql);
if ($row['it_id']) {
	$prev_title = $row['it_name'];
	$prev_href = "./item.php?it_id=".$row['it_id'];
} else {
	$prev_title = '';
	$prev_href = '';
}

// 다음 상품보기
$sql = " select it_id, it_name from {$g5['g5_shop_item_table']} where it_id < '$it_id' and SUBSTRING(ca_id,1,4) = '".substr($it['ca_id'],0,4)."' and it_use = '1' order by it_id desc limit 1 ";
$row = sql_fetch($sql);
if ($row['it_id']) {
	$next_title = $row['it_name'];
	$next_href = "./item.php?it_id=".$row['it_id'];
} else {
	$next_title = '';
	$next_href = '';
}

// 고객선호도 별점수
$star_score = get_star_image($it['it_id']);

// 관리자가 확인한 사용후기의 개수를 얻음
$sql = " select count(*) as cnt from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ";
$row = sql_fetch($sql);
$item_use_count = $row['cnt'];

// 상품문의의 개수를 얻음
$sql = " select count(*) as cnt from `{$g5['g5_shop_item_qa_table']}` where it_id = '{$it_id}' ";
$row = sql_fetch($sql);
$item_qa_count = $row['cnt'];

// 관련상품의 개수를 얻음
if($default['de_rel_list_use']) {
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and  b.it_use='1' ";
    $row = sql_fetch($sql);
    $item_relation_count = $row['cnt'];
}

// 소셜 관련
$sns_title = get_text($it['it_name']).' | '.get_text($config['cf_title']);
$sns_url  = G5_SHOP_URL.'/item.php?it_id='.$it['it_id'];

// 상품품절체크
if(G5_SOLDOUT_CHECK)
    $is_soldout = is_soldout($it['it_id']);

// 주문가능체크
$is_orderable = true;
if(!$it['it_use'] || $it['it_tel_inq'] || $is_soldout)
	$is_orderable = false;

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
}

// 네이버 페이
include_once(G5_SHOP_PATH.'/settle_naverpay.inc.php');

/**** item : Start ****/
// 상품기본정보 및 주문폼
@include_once(EYOOM_SHOP_PATH.'/item_form.skin.php');

// 상품 상세정보
@include_once(EYOOM_SHOP_PATH.'/item_info.skin.php');

$tpl->define(array(
	'item_form_pc'	=> 'skin_pc/shop/' . $eyoom['shop_skin'] . '/item_form.skin.html',
	'item_form_mo'	=> 'skin_mo/shop/' . $eyoom['shop_skin'] . '/item_form.skin.html',
	'item_form_bs'	=> 'skin_bs/shop/' . $eyoom['shop_skin'] . '/item_form.skin.html',
	'item_info_pc'	=> 'skin_pc/shop/' . $eyoom['shop_skin'] . '/item_info.skin.html',
	'item_info_mo'	=> 'skin_mo/shop/' . $eyoom['shop_skin'] . '/item_info.skin.html',
	'item_info_bs'	=> 'skin_bs/shop/' . $eyoom['shop_skin'] . '/item_info.skin.html',
	'item_rel_pc'	=> 'skin_pc/shop/' . $eyoom['shop_skin'] . '/item_rel.skin.html',
	'item_rel_mo'	=> 'skin_mo/shop/' . $eyoom['shop_skin'] . '/item_rel.skin.html',
	'item_rel_bs'	=> 'skin_bs/shop/' . $eyoom['shop_skin'] . '/item_rel.skin.html',
));
/**** item : End ****/

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'item.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/item.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

if ($ca['ca_include_tail']) {
	@include_once($ca['ca_include_tail']);
} else {
	// 이윰 테일 디자인 출력
	@include_once(EYOOM_SHOP_PATH.'/shop.tail.php');
}