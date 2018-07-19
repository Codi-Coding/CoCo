<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5['module']        = "module";
$g5['subpage']       = "subpage";
$g5['legacy']        = "g4";

// 디렉토리
$g5['bbs']           = G5_BBS_DIR;
$g5['bbs_path']      = G5_BBS_PATH;
$g5['admin_path']    = G5_ADMIN_PATH;
$g5['module_path']   = G5_PATH . "/" . $g5['module']; /// 2010.10.20
$g5['subpage_path']  = $g5['module_path']."/".$g5['subpage'];
$g5['legacy_path']   = G5_PATH . "/" . $g5['legacy'];

$g5['bbs_url']       = G5_BBS_URL;
$g5['admin_url']     = G5_ADMIN_URL;
$g5['shop_admin_url'] = G5_ADMIN_URL.'/shop_admin';
$g5['module_url']    = G5_URL . "/" . $g5['module']; /// 2010.10.20
$g5['subpage_url']   = $g5['module_url']."/".$g5['subpage'];
$g5['legacy_url']    = G5_URL . "/" . $g5['legacy'];

/// g4 support
define('_G5_ALPHAUPPER_', 1); // 영대문자
define('_G5_ALPHALOWER_', 2); // 영소문자
define('_G5_ALPHABETIC_', 4); // 영대,소문자
define('_G5_NUMERIC_', 8); // 숫자
define('_G5_HANGUL_', 16); // 한글
define('_G5_SPACE_', 32); // 공백
define('_G5_SPECIAL_', 64); // 특수문자

$g5['charset'] = "utf-8";
$g5['bbs_img']       = "img";
$g5['bbs_img_path']  = G5_PATH . "/" . G5_BBS_DIR . "/" . $g5['bbs_img'];
$g5['bbs_img_url']   = G5_URL . "/" . G5_BBS_DIR . "/" . $g5['bbs_img'];
$g5['editor']        = "cheditor";
$g5['editor_path']   =  G5_PATH . "/" . $g5['editor'];
$g5['editor_url']    =  G5_URL . "/" . $g5['editor'];
$g5['cheditor4']     = "cheditor4";
$g5['cheditor4_path'] = G5_PATH . "/" . $g5['cheditor4'];
$g5['cheditor4_url'] =  G5_URL . "/" . $g5['cheditor4'];
$g5['is_cheditor5']  = true;
$g5['geditor']       = "geditor";
$g5['geditor_path']  =  G5_PATH . "/" . $g5['geditor'];
$g5['geditor_url']   =  G5_URL . "/" . $g5['geditor'];
$g5['editor_name']   = "geditor"; /// cheditor4, geditor
$g5['data_path']     = G5_DATA_PATH;
$g5['data_url']      = G5_DATA_URL;
$g5['link_count']    = G5_LINK_COUNT;

$config['cf_m_tel']  = "1234-1234";
$config['cf_m_sms']  = "010-1234-1234";
/// g4 support

$g5['visit2_table']  = G5_TABLE_PREFIX.'visit2'; // 보조 방문자 테이블

/// w builder support
$g5['config2w_table']          = G5_TABLE_PREFIX.'config2w'; // 기본환경 설정2w 테이블
$g5['config2w_board_table']    = G5_TABLE_PREFIX.'config2w_board'; // 기본환경 설정2w board 테이블
$g5['config2w_config_table']   = G5_TABLE_PREFIX.'config2w_config'; // 기본환경 설정2w basic 테이블
$g5['config2w_def_table']      = G5_TABLE_PREFIX.'config2w_def'; // 기본환경 설정2w_def 테이블
$g5['config2w_menu_table']     = G5_TABLE_PREFIX.'config2w_menu'; // 기본환경 설정2w_menu 테이블
$g5['config2w_m_table']        = G5_TABLE_PREFIX.'config2w_m'; // 기본환경 설정2w_m 테이블
$g5['config2w_m_board_table']  = G5_TABLE_PREFIX.'config2w_m_board'; // 기본환경 설정2w board 테이블
$g5['config2w_m_config_table'] = G5_TABLE_PREFIX.'config2w_m_config'; // 기본환경 설정2w basic 테이블
$g5['config2w_m_def_table']    = G5_TABLE_PREFIX.'config2w_m_def'; // 기본환경 설정2w_m_def 테이블

$g5['path'] = G5_PATH;

/// templete 아이디 등 추출
$config2w = sql_fetch(" select cf_templete from $g5[config2w_table] limit 1 ", false);
/// 아래 내용으로 교체됨. 위 내용은 호환성 배려 유지
$config2w_def = sql_fetch(" select * from $g5[config2w_def_table] limit 1 ", false);
/// -- end --
$g5['cf_templete'] = $config2w_def['cf_templete'] ? $config2w_def['cf_templete'] : $config2w['cf_templete'];

/// tmpl_path 지정을 위한 조정 및 지정 작업.
if($g5['path'] == '') $g5['path'] = ".";
///$g5['tmpl_dir'] = "tmpl";
$g5['tmpl_dir'] = G5_TMPL_DIR;
$g5['tmpl_default'] = "basic";
/// 현재의 템플릿 디렉터리 검사
$arr = scandir("$g5[path]/$g5[tmpl_dir]");
$tmpl_arr = array();
for ($i = 0; $i < count($arr); $i++) {
if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[path]/$g5[tmpl_dir]/{$arr[$i]}")) continue;
      $tmpl_arr[] = $arr[$i];
}

/// 관리자 템플릿 설정으로 아래 g5['tmpl'] 자동 조정됨(현재 버젼). 설정값이 없을 경우 이전 사용 값으로 지정.
$g5['tmpl'] = $g5['cf_templete'];
if(!$g5['tmpl']) ///*** do not remove
$g5['tmpl'] = "theme_shop_basic_pro"; /// change here, if needed

/// for test & demo.
unset($input_tmpl);
if(isset($_GET['tmpl']))  $input_tmpl = $_GET['tmpl']; /// GET first
if(isset($_POST['tmpl'])) $input_tmpl = $_POST['tmpl'];

if(isset($input_tmpl)) {
    if($input_tmpl != $_SESSION['tmpl']) $input_tmpl_changed = 1; /// 추가. 2015.12.17
    $g5['tmpl'] = $input_tmpl;
    if($input_tmpl) $_SESSION['tmpl'] = $input_tmpl;
    else unset($_SESSION['tmpl']);

    ///unset($_SESSION['mobile_tmpl']); /// 2015.10.17. mobile tmpl session 초기화
}

if(isset($_SESSION['tmpl']))
    $g5['tmpl'] = $_SESSION['tmpl'];
if($g5['tmpl'] == "" or !in_array($g5['tmpl'], $tmpl_arr))
    $g5['tmpl'] = $g5['cf_templete'];

/// tmpl, tmpl_path 조정 또는 지정
if($g5['tmpl'] == "" or !in_array($g5['tmpl'], $tmpl_arr))
    $g5['tmpl'] = "$g5[tmpl_default]";

/// url
$g5['url']          = G5_URL;
$g5['tmpl_path'] = "$g5[path]/$g5[tmpl_dir]/$g5[tmpl]";
$g5['tmpl_url']  = "$g5[url]/$g5[tmpl_dir]/$g5[tmpl]";

/// g5&yc5 builder

define('G5_TMPL_PATH', $g5['tmpl_path']);
define('G5_TMPL_URL', $g5['tmpl_url'] );

$g5['mobile_path'] = G5_MOBILE_PATH;
$g5['mobile_url']  = G5_MOBILE_URL;

///$g5['mobile_tmpl_dir']  = 'tmpl';
$g5['mobile_tmpl_dir']  = G5_TMPL_DIR;

/// 현재의 템플릿 디렉터리 검사
$arr = scandir("$g5[mobile_path]/$g5[mobile_tmpl_dir]");
$mobile_tmpl_arr = array();
for ($i = 0; $i < count($arr); $i++) {
if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}")) continue;
      $mobile_tmpl_arr[] = $arr[$i];
}

/// mobile templete 아이디 등 추출
$config2w_m = sql_fetch(" select cf_templete from $g5[config2w_m_table] limit 1 ", false);
/// 아래 내용으로 교체됨. 위 내용은 호환성 배려 유지
$config2w_m_def = sql_fetch(" select * from $g5[config2w_m_def_table] limit 1 ", false);
/// -- end --
$g5['cf_mobile_templete'] = $config2w_m_def['cf_templete'] ? $config2w_m_def['cf_templete'] : $config2w_m['cf_templete'];

/// 2015.10.17 추가. 디폴트 기본 템플릿별 디폴트 모바일 템플릿 
if(isset($config2w_m_def['cf_mobile_templete'])) {
    $config2w_m_def = sql_fetch(" select * from $g5[config2w_m_def_table] where cf_templete = '{$g5['tmpl']}' ", false);
    if($config2w_m_def['cf_mobile_templete']) $g5['cf_mobile_templete'] = $config2w_m_def['cf_mobile_templete'];
}

$g5['mobile_tmpl'] = $g5['cf_mobile_templete'];
if(!$g5['mobile_tmpl']) ///*** do not remove
$g5['mobile_tmpl'] = "basic"; /// mobile, change here, if needed

/// for test & demo.
unset($input_mobile_tmpl);
if(isset($_GET['mobile_tmpl']))  $input_mobile_tmpl = $_GET['mobile_tmpl']; /// GET first
if(isset($_POST['mobile_tmpl'])) $input_mobile_tmpl = $_POST['mobile_tmpl'];
if($input_tmpl_changed) $input_mobile_tmpl = $g5['cf_mobile_templete'];

if(isset($input_mobile_tmpl)) {
    $g5['mobile_tmpl'] = $input_mobile_tmpl;
    if($input_mobile_tmpl) $_SESSION['mobile_tmpl'] = $input_mobile_tmpl;
    else unset($_SESSION['mobile_tmpl']);
}

if(isset($_SESSION['mobile_tmpl']))
    $g5['mobile_tmpl'] = $_SESSION['mobile_tmpl'];
if($g5['mobile_tmpl'] == "" or !in_array($g5['mobile_tmpl'], $mobile_tmpl_arr))
    $g5['mobile_tmpl'] = $g5['cf_mobile_templete'];

$g5['mobile_tmpl_path'] = $g5['mobile_path'].'/'.$g5['mobile_tmpl_dir'].'/'.$g5['mobile_tmpl'];
$g5['mobile_tmpl_url']  = $g5['mobile_url'].'/'.$g5['mobile_tmpl_dir'].'/'.$g5['mobile_tmpl'];

define('G5_MOBILE_TMPL_PATH', $g5['mobile_tmpl_path']);
define('G5_MOBILE_TMPL_URL', $g5['mobile_tmpl_url']);

/// work(admin) templete
$g5['work_tmpl'] = $_SESSION['tmpl'] ? $_SESSION['tmpl'] : '';
$g5['mobile_work_tmpl'] = $_SESSION['mobile_tmpl'] ? $_SESSION['mobile_tmpl'] : '';

/// w builder support

/// config2w 정보 추출
$config2w = array();
$config2w = sql_fetch(" select * from $g5[config2w_table] where cf_id='$g5[tmpl]' ", false); /// 2012.06.29
$config2w_org = $config2w;
/// if(is_array($config2w)) $config = array_merge($config, $config2w);

$g5['menu'] = $config2w['cf_menu'];

$config2w_menu = sql_fetch(" select * from $g5[config2w_menu_table] where cf_menu='$g5[menu]' ", false); /// 2012.06.29
if(is_array($config2w_menu))
    $config2w = array_merge($config2w, $config2w_menu);

$config2w_m = array();
$config2w_m = sql_fetch(" select * from $g5[config2w_m_table] where cf_id='$g5[mobile_tmpl]' ", false);
/// if(is_array($config2w_m)) $config = array_merge($config, $config2w_m);

/// 공통 이용 설정 적용
if($config2w['cf_use_common_addr'] and $g5['tmpl'] != 'basic') {
    $common_field_string = "cf_header_logo, cf_site_name, cf_site_addr, cf_zip, cf_tel, cf_fax, cf_email, cf_site_owner, cf_biz_num, cf_ebiz_num, cf_info_man, cf_info_email, cf_copyright, cf_keywords, cf_description";
    $que = " select $common_field_string from $g5[config2w_table] where cf_id='basic' ";
    $res = sql_query($que);
    $config2w_common = sql_fetch_array($res);
    if(is_array($config2w_common)) $config2w = array_merge($config2w, array_filter(array_map('trim', $config2w_common)));
}

if($config2w['cf_use_common_menu'] and $g5['menu'] != 'basic') {
    $que = " select * from $g5[config2w_menu_table] where cf_menu='basic' ";
    $res = sql_query($que);
    $config2w_common = sql_fetch_array($res);
    if(is_array($config2w_common)) $config2w = array_merge($config2w, array_filter(array_map('trim', $config2w_common)));
}

/// 템플릿 사용 가능 여부 검사
if(!(defined('G5_IS_ADMIN') && G5_IS_ADMIN)) {
    if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) {
        if(preg_match('/shop_/', $g5['cf_templete'])) {
            echo $g5['cf_templete'].": 쇼핑몰 설치 및 이용 설정 후 이용 가능한 템플릿입니다.<br>";
            exit;
        } 
        if(preg_match('/shop_/', $g5['cf_mobile_templete'])) {
            echo "mobile ".$g5['cf_mobile_templete'].": 쇼핑몰 설치 및 이용 설정 후 이용 가능한 모바일 템플릿입니다.<br>";
            exit;
        }
    }
}

function call_name($name) {
$cf_name = $name;
$f_tmp = explode("(", $cf_name);
$f_name = trim($f_tmp[0]);
$f_tmp = explode(")", $f_tmp[1]);
$f_para = explode(",", $f_tmp[0]);
for($p = 0; $p < count($f_para); $p++) { $f_para[$p] = trim(trim($f_para[$p]), "\""); }
return call_user_func_array($f_name, $f_para);
}

if(0) { /// 2014.04.15
if($config2w['cf_header_logo'])
	$config['cf_1'] = $config2w['cf_header_logo'];
if($config2w['cf_site_addr'])
	$config['cf_2'] = $config2w['cf_site_addr'];
if($config2w['cf_copyright'])
	$config['cf_3'] = $config2w['cf_copyright'];
if($config2w['cf_keywords'])
	$config['cf_4'] = $config2w['cf_keywords'];
if($config2w['cf_description'])
	$config['cf_5'] = $config2w['cf_description'];
} ///

$ShowHideType = "timeout"; // 'default', 'simple', 'simple_timeout', 'timeout' 
$site_name = ""; // 여기에 사이트 네임 지정시 관리자 설정보다 우선 적용됨
$va = ".v";

$ShowHide_ext = ".".$ShowHideType;
if(!($ShowHideType == 'simple' or $ShowHideType == 'simple_timeout' or $ShowHideType == 'timeout'))
    $ShowHide_ext = ".timeout";

/// $board['bo_table_width'] = 100; /// 테이플 폭을 100%로 사용. 임시. board 테이블 필드 추가해야.
///*** $board['bo_table_width'] = $board['bo_w_table_width'];
///*** $board['bo_skin'] = $board['bo_w_skin'];

/// member register
$g5['use_member_register']   = 1;
$g5['msg_nouse_member_register'] = "본 사이트에서는 현재 회원 등록을 받고 있지 않습니다";
/// visit log. visit2_table 필요
$g5['use_visit_log']         = 1;

$g5['server_time']    = G5_SERVER_TIME;
$g5['time_ymd']       = G5_TIME_YMD;
$g5['time_his']       = G5_TIME_HIS;
$g5['time_ymdhis']    = G5_TIME_YMDHIS;

/// use g5 menu
$g5['use_builder_menu']   = 1;

/// reassign default font (템플릿 내의 style.css 또는 boot_change.css)
$font_list                =  array("", "nanumgothic", "malgungothic");
$g5['def_font']           = $font_list[1]; /// 0 템플릿 지정 폰트, 1 나눔 고딕, 2 맑은 고딕
$g5['def_font_g4_no_use'] = 0; /// g4_ 스타일 템플릿의 경우, 위 폰트 재지정 기능을 사용하지 않으려면 1로 

if(!function_exists('_t')) {
/// new. 번역 함수
function _t($msgid) {
    global $g5;
    global $messages;

    if($msgid == '' or !$g5['is_trans'])
        return $msgid;
    else if($g5['use_gettext'] && function_exists('gettext'))
        return _($msgid);
    else
        return $messages[$msgid] ? $messages[$msgid] : $msgid;
}
}
?>
