<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/***************************************************************************************** 
 ■ [선택설정] 페이지 고정 1단 레이아웃 설정 - 항상 사이드 없는 1단 박스형으로 출력되는 페이지(게시판, 상품분류, 기본/일반문서 등)
 - 각 배열키에 해당되는 아이디를 띄어쓰기 없이 콤마(,)로 구분해서 등록
 - 기본문서(pid)는 테마관리 > 기분문서의 Page id 등록
 - 일반문서(hid)는 테마관리 > 일반문서의 html id 또는 메뉴설정에서 등록한 일반문서의 html id 등록
*****************************************************************************************/
$page_list = array(
	"ca_id"		=> "상품대분류코드,상품대분류코드",
	"gr_id"		=> "게시판그룹아이디,게시판그룹아이디",
	"bo_table"	=> "게시판아이디,게시판아이디",
	"pid"		=> "login,reg,regform,regresult,regmail,confirm,password,cart,orderform,orderview,inquiry,inquiryview,ppay,ppayform,ppayresult,partner",
	"hid"		=> "일반문서아이디,일반문서아이디"
);

/***************************************************************************************** 
 ■ 경고! 이하 내용은 절대 수정하지 마세요!
*****************************************************************************************/

// 툴팁함수
function tooltip($str, $opt='top') {
	// 모바일에서는 출력안함
	if(G5_IS_MOBILE) return;
	$tooltip = ' data-original-title="<nobr>'.$str.'</nobr>" data-toggle="tooltip" data-placement="'.$opt.'" data-html="true"';
	return $tooltip;
}

// 영카트 사용시
if(IS_YC) {
	thema_member('cart');
}

// 스크립트
apms_script('swipe');

// 데모설정
if($is_demo) {
	@include($demo_setup_file);
}

// 기본값 설정
$is_thema_size = (isset($at_set['size']) && $at_set['size'] > 0) ? $at_set['size'] : 1200;
$is_thema_font = ($at_set['font']) ? $at_set['font'] : 'ko';
$is_thema_layout = $at_set['layout'];
$is_content_style = ($at_set['content']) ? '-wide' : '';
$is_sticky_nav = $at_set['sticky'];
$is_top_nav = ($at_set['nav']) ? $at_set['nav'] : 'both';

$is_fixed_content = false;
if(IS_YC && isset($ca_id) && $ca_id && !$pid) {
	$page_chk = explode(",", $page_list['ca_id']);
	if(in_array(substr($ca_id,0,2), $page_chk)) {
		$is_fixed_content = true;
	}
} else if(isset($grid) && $grid) {
	unset($page_chk);
	$page_chk = explode(",", $page_list['gr_id']);
	if(in_array($grid, $page_chk)) {
		$is_fixed_content = true;
	}
	
	if(isset($bo_table) && $bo_table) {
		unset($page_chk);
		$page_chk = explode(",", $page_list['bo_table']);
		if(in_array($bo_table, $page_chk)) {
			$is_fixed_content = true;
		}
	} else if(isset($pid) && $pid) {
		unset($page_chk);
		$page_chk = explode(",", $page_list['pid']);
		if(in_array($pid, $page_chk)) {
			$is_fixed_content = true;
		}
	} else if(isset($hid) && $hid) {
		unset($page_chk);
		$page_chk = explode(",", $page_list['hid']);
		if(in_array($hid, $page_chk)) {
			$is_fixed_content = true;
		}
	}
} else if(isset($pid) && $pid) {
	unset($page_chk);
	$page_chk = explode(",", $page_list['pid']);
	if(in_array($pid, $page_chk)) {
		$is_fixed_content = true;
	}
} else if(isset($hid) && $hid) {
	unset($page_chk);
	$page_chk = explode(",", $page_list['hid']);
	if(in_array($hid, $page_chk)) {
		$is_fixed_content = true;
	}
}

// 칼럼
if($is_wide_layout) { //메인은 와이드 고정
	$col_content = 13;
} else if($is_fixed_content) { //메인은 와이드 고정
	$col_content = 12;
} else {
	$col_content = ($at_set['page']) ? $at_set['page'] : 9;
}

$col_content = (int)$col_content;

if($col_content == 13) { //Full Wide
	$col_name = '';
} else if($col_content == 12) { //One Column
	$col_name = 'one';
} else { // Two Column
	$col_name = 'two';
	$col_side = 12 - $col_content;
}

// 사이드 파일
if($col_name == 'two') {
	if($at_set['sfile']) {
		$is_side_file = THEMA_PATH.'/side/'.$at_set['sfile'].'.php';
		if(!is_file($is_side_file)) {
			$col_name = 'one';
		}
	} else {
		$col_name = 'one';
	}
}

// 메뉴높이
$is_menuh = (isset($at_set['mh']) && $at_set['mh'] > 0) ? $at_set['mh'] : 44;

// 좌측형 메뉴간격
$is_menup = (isset($at_set['ms']) && $at_set['ms'] > 0) ? $at_set['ms'] : 25;

// 전체형 메뉴높이
$is_menuph = (isset($at_set['mph']) && $at_set['mph'] > 0) ? $at_set['mph'] : 400;

// 서브메뉴 너비
$is_subw = (isset($at_set['subw']) && $at_set['subw'] > 0) ? $at_set['subw'] : 170;

// 전체메뉴 가로수
$is_allm = (isset($at_set['allm']) && $at_set['allm'] > 0) ? $at_set['allm'] : 7;

// 메뉴수
$menu_cnt = count($menu);

// 소셜아이콘
$sns_share_url  = (IS_YC && IS_SHOP) ? G5_SHOP_URL : G5_URL;
$sns_share_title = get_text($config['cf_title']);
$sns_share_img = THEMA_URL.'/assets/img';
$sns_share_icon = '<div class="sns-share-icon">'.PHP_EOL;
$sns_share_icon .= get_sns_share_link('facebook', $sns_share_url, $sns_share_title, $sns_share_img.'/sns_fb.png').PHP_EOL;
$sns_share_icon .= get_sns_share_link('twitter', $sns_share_url, $sns_share_title, $sns_share_img.'/sns_twt.png').PHP_EOL;
$sns_share_icon .= get_sns_share_link('googleplus', $sns_share_url, $sns_share_title, $sns_share_img.'/sns_goo.png').PHP_EOL;
$sns_share_icon .= get_sns_share_link('kakaostory', $sns_share_url, $sns_share_title, $sns_share_img.'/sns_kakaostory.png').PHP_EOL;
$sns_share_icon .= get_sns_share_link('kakaotalk', $sns_share_url, $sns_share_title, $sns_share_img.'/sns_kakao.png').PHP_EOL;
$sns_share_icon .= get_sns_share_link('naverband', $sns_share_url, $sns_share_title, $sns_share_img.'/sns_naverband.png').PHP_EOL;
$sns_share_icon .= '</div>';

// 컬러셋
$bootstrap_css = (_RESPONSIVE_) ? 'bootstrap.min.css' : 'bootstrap-apms.min.css';
$add_stylesheet = PHP_EOL.'<link rel="stylesheet" href="'.THEMA_URL.'/assets/bs3/css/'.$bootstrap_css.'" type="text/css" class="thema-mode">';
$add_stylesheet .= PHP_EOL.'<link rel="stylesheet" href="'.COLORSET_URL.'/colorset.css" type="text/css" class="thema-colorset">';
add_stylesheet($add_stylesheet,0);

// 페이지 배경
if(!$page_background) {
	if(isset($at_set['bgcolor']) && $at_set['bgcolor']) { // 배경색
		$page_background .= "background-color: ".$at_set['bgcolor']."; ";
	}
	if(isset($at_set['background']) && $at_set['background'] && $at_set['background'] != "none") { //배경이미지
		$page_background .= "background-image: url('".$at_set['background']."'); ";
		if(isset($at_set['bg']) && $at_set['bg']) { //중앙,상단,하단,패턴
			switch($at_set['bg']) {
				case "top"		: $page_background .= "background-position: center top;"; break;
				case "bottom"	: $page_background .= "background-position: center bottom;"; break;
				case "fixed"	: $page_background .= "background-size:100%; background-position: center top; background-attachment:scroll;"; break;
				case "pattern"	: $page_background .= "background-repeat: repeat; background-size:auto; background-attachment:scroll;"; break;
			}
		}
	}
}
?>
<style>
	<?php if($page_background) { ?>	
	body { <?php echo $page_background;?> }
	<?php } ?>
	.at-container {max-width:<?php echo $is_thema_size;?>px;}
	.no-responsive .wrapper, .no-responsive .at-container-wide { min-width:<?php echo $is_thema_size;?>px; }
	.no-responsive .boxed.wrapper, .no-responsive .at-container { width:<?php echo $is_thema_size;?>px; }
	.at-menu .nav-height { height:<?php echo $is_menuh;?>px; line-height:<?php echo $is_menuh;?>px !important; }
	.pc-menu, .pc-menu .nav-full-back, .pc-menu .nav-full-height { height:<?php echo $is_menuh;?>px; }
	.pc-menu .nav-top.nav-float .menu-a { padding:0px <?php echo $is_menup;?>px; }
	.pc-menu .nav-top.nav-float .sub-1div::before { left: <?php echo $is_menup;?>px; }
	.pc-menu .subm-w { width:<?php echo $is_subw;?>px; }
	@media all and (min-width:1200px) {
		.responsive .boxed.wrapper { max-width:<?php echo $is_thema_size;?>px; }
	}
</style>
