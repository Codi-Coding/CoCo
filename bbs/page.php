<?php
include_once('./_common.php');

$is_main = false;

if(!$hid) alert('등록되지 않은 페이지입니다.');

$at = apms_page_thema($hid, 1);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$scrap_href = '';
$is_register = false;
$is_content = false;

if($at['co_id']) {
	$co = sql_fetch(" select * from {$g5['content_table']} where co_id = '{$at['co_id']}' ");
	if ($co['co_id']) {
		$is_content = true;
		$co_id = $co['co_id'];
	}
}

if($is_content) {
	$is_seometa = 'content'; //컨텐츠
	$g5['title'] = $co['co_subject'];

	$co_content = (G5_IS_MOBILE && $co['co_mobile_content']) ? $co['co_mobile_content'] : $co['co_content'];
	$page_html = conv_content($co_content, $co['co_html'], $co['co_tag_filter_use']);

	if(IS_YC) {
		// $src 를 $dst 로 변환
		unset($src);
		unset($dst);
		$src[] = "/{{쇼핑몰명}}|{{홈페이지제목}}/";
		//$dst[] = $default[de_subject];
		$dst[] = $config['cf_title'];
		$src[] = "/{{회사명}}|{{상호}}/";
		$dst[] = $default['de_admin_company_name'];
		$src[] = "/{{대표자명}}/";
		$dst[] = $default['de_admin_company_owner'];
		$src[] = "/{{사업자등록번호}}/";
		$dst[] = $default['de_admin_company_saupja_no'];
		$src[] = "/{{대표전화번호}}/";
		$dst[] = $default['de_admin_company_tel'];
		$src[] = "/{{팩스번호}}/";
		$dst[] = $default['de_admin_company_fax'];
		$src[] = "/{{통신판매업신고번호}}/";
		$dst[] = $default['de_admin_company_tongsin_no'];
		$src[] = "/{{사업장우편번호}}/";
		$dst[] = $default['de_admin_company_zip'];
		$src[] = "/{{사업장주소}}/";
		$dst[] = $default['de_admin_company_addr'];
		$src[] = "/{{운영자명}}|{{관리자명}}/";
		$dst[] = $default['de_admin_name'];
		$src[] = "/{{운영자e-mail}}|{{관리자e-mail}}/i";
		$dst[] = $default['de_admin_email'];
		$src[] = "/{{정보관리책임자명}}/";
		$dst[] = $default['de_admin_info_name'];
		$src[] = "/{{정보관리책임자e-mail}}|{{정보책임자e-mail}}/i";
		$dst[] = $default['de_admin_info_email'];

		$page_html = preg_replace($src, $dst, $page_html);
	}

} else {
	$is_seometa = 'page'; //페이지
	$g5['title'] = $at['title'];

	if($at['content']) { //직접입력
		$page_html = $at['content'];
	} else {
		ob_start();
		if($is_demo && is_file(THEMA_PATH.'/page/'.$hid.'.php')) { // 데모 페이지
			$page_path = THEMA_PATH.'/page';
			$page_url = THEMA_URL.'/page';
			@include_once($page_path.'/'.$hid.'.php');
		} else if($at['file']) {
			$page_file = G5_PATH.'/page/'.$at['file'];
			$page_path = str_replace("/".basename($page_file), "", $page_file);
			$page_url = str_replace(G5_PATH, G5_URL, $page_path);
			if(is_file($page_file)) {
				include_once($page_file);
			} else {
				echo '<br><br><p align="center">준비중 입니다.</p><br><br>';
			}
		} else {
			echo '<br><br><p align="center">존재하지 않는 페이지입니다.</p><br><br>';
		}
		$page_html = ob_get_contents();
		ob_end_clean();

		$page_html = str_replace("./", $page_url."/", $page_html);
	}
}

// SEO;
$seo_page_desc = apms_cut_text(preg_replace("!<style(.*?)<\/style>!is", "", $page_html), 200);
$matches = get_editor_image($page_html, false);
$seo_page_img = $matches[1][0];

include_once('./_head.php');

// 페이지스킨
$page_skin = $at['pskin'];
$page_skin_path = G5_SKIN_PATH.'/page/'.$page_skin;
$page_skin_url = G5_SKIN_URL.'/page/'.$page_skin;

// 페이지컨텐츠
if($is_content) {

	$page_content = '';

	if(is_file(G5_DATA_PATH.'/content/'.$co_id.'_h'))
		$page_content .= '<div id="ctt_himg" class="ctt_img"><img src="'.G5_DATA_URL.'/content/'.$co_id.'_h" alt=""></div>'.PHP_EOL;

	$page_content .= apms_content($page_html);

	if(is_file(G5_DATA_PATH.'/content/'.$co_id.'_t')) 
		$page_content .= '<div id="ctt_timg" class="ctt_img"><img src="'.G5_DATA_URL.'/content/'.$co_id.'_t" alt=""></div>'.PHP_EOL;

	if ($is_designer)
		$page_content .= '<p align="center"><br><a href="'.G5_ADMIN_URL.'/contentform.php?w=u&amp;co_id='.$co_id.'" class="btn_admin">내용 수정</a><br></p>';

} else {
	$page_content = apms_content($page_html);
}

if(G5_IS_MOBILE) {
	echo '<div class="page-wrap font-14">'.PHP_EOL;
} else {
	echo '<div class="page-wrap">'.PHP_EOL;
}

if($page_skin && is_file($page_skin_path.'/page.skin.php')) {
	include_once($page_skin_path.'/page.skin.php');
} else {
	if($header_skin)
		include_once('./header.php');

	echo $page_content;
}

echo '</div>'.PHP_EOL;

include_once('./_tail.php');
?>