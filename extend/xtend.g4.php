<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

///************************************************
/// g4
///************************************************

if(0) { ///
/// tmpl_path 지정을 위한 조정 및 지정 작업.
if($g4['path'] == '') $g4['path'] = ".";

$g4['tmpl_dir'] = "tmpl";
$g4['tmpl_default'] = "basic";

/// 아래에 호스트 리스트(소문자) 등록(초기 버젼).
/// $tmpl_arr = array("basic");
/// $g4['tmpl'] = $tmpl_arr[0];

/// 현재의 템플릿 디렉터리 검사
$arr = scandir("$g4[path]/$g4[tmpl_dir]");
$tmpl_arr = array();
for ($i = 0; $i < count($arr); $i++) {
if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g4[path]/$g4[tmpl_dir]/{$arr[$i]}")) continue;
      $tmpl_arr[] = $arr[$i];
}

/// 관리자 템플릿 설정으로 아래 g4['tmpl'] 자동 조정됨(현재 버젼)
/// $g4['tmpl'] = "basic_banner"; /// change here, if needed
$g4['tmpl'] = "g4_basic_biz"; /// change here, if needed

/// for test. valid for 1st page only
if(isset($_GET['tmpl_id'])) $g4['tmpl'] = $_GET['tmpl_id'];

/// tmpl, tmpl_path 조정 또는 지정
if($g4['tmpl'] == "" or !in_array($g4['tmpl'], $tmpl_arr))
    $g4['tmpl'] = "$g4[tmpl_default]";
$g4['tmpl_path'] = "$g4[path]/$g4[tmpl_dir]/$g4[tmpl]";

// 디렉토리
$g4['bbs']            = "bbs";
$g4['bbs_path']       = $g4['path'] . "/" . $g4['bbs'];
$g4['bbs_img']        = "img";
$g4['bbs_img_path']   = $g4['path'] . "/" . $g4['bbs'] . "/" . $g4['bbs_img'];
$g4['admin']          = "adm";
$g4['admin_path']     = $g4['path'] . "/" . $g4['admin'];
$g4['editor']         = "cheditor";
$g4['editor_path']    = $g4['path'] . "/" . $g4['editor'];
$g4['cheditor4']      = "cheditor4";
$g4['cheditor4_path'] = $g4['path'] . "/" . $g4['cheditor4'];
$g4['is_cheditor5']   = true;
$g4['geditor']        = "geditor";
$g4['geditor_path']   = $g4['path'] . "/" . $g4['geditor'];
$g4['lib']            = "lib";
$g4['lib_path']       = $g4['path'] . "/" . $g4['lib'];
$g4['module']         = "module";
$g4['module_path']    = $g4['path'] . "/" . $g4['module'];
$g4['subpage']        = "subpage";
$g4['subpage_path']   = $g4['module_path'] . "/" . $g4['subpage'];

// 자주 사용하는 값
// 서버의 시간과 실제 사용하는 시간이 틀린 경우 수정하세요.
// 하루는 86400 초입니다. 1시간은 3600초
// 6시간이 빠른 경우 time() + (3600 * 6);
// 6시간이 느린 경우 time() - (3600 * 6);
$g4['server_time']    = time();
$g4['time_ymd']       = date("Y-m-d", $g4['server_time']);
$g4['time_his']       = date("H:i:s", $g4['server_time']);
$g4['time_ymdhis']    = date("Y-m-d H:i:s", $g4['server_time']);

//
// 테이블 명
// (상수로 선언한것은 함수에서 global 선언을 하지 않아도 바로 사용할 수 있기 때문)
//
$g4['table_prefix']        = "g5_"; // 테이블명 접두사
$g4['write_prefix']        = $g4['table_prefix'] . "write_"; // 게시판 테이블명 접두사
$g4['auth_table']          = $g4['table_prefix'] . "auth";          // 관리권한 설정 테이블
$g4['config_table']        = $g4['table_prefix'] . "config";        // 기본환경 설정 테이블
$g4['group_table']         = $g4['table_prefix'] . "group";         // 게시판 그룹 테이블
$g4['group_member_table']  = $g4['table_prefix'] . "group_member";  // 게시판 그룹+회원 테이블
$g4['board_table']         = $g4['table_prefix'] . "board";         // 게시판 설정 테이블
$g4['board_file_table']    = $g4['table_prefix'] . "board_file";    // 게시판 첨부파일 테이블
$g4['board_good_table']    = $g4['table_prefix'] . "board_good";    // 게시물 추천,비추천 테이블
$g4['board_new_table']     = $g4['table_prefix'] . "board_new";     // 게시판 새글 테이블
$g4['login_table']         = $g4['table_prefix'] . "login";         // 로그인 테이블 (접속자수)
$g4['mail_table']          = $g4['table_prefix'] . "mail";          // 회원메일 테이블
$g4['member_table']        = $g4['table_prefix'] . "member";        // 회원 테이블
$g4['memo_table']          = $g4['table_prefix'] . "memo";          // 메모 테이블
$g4['poll_table']          = $g4['table_prefix'] . "poll";          // 투표 테이블
$g4['poll_etc_table']      = $g4['table_prefix'] . "poll_etc";      // 투표 기타의견 테이블
$g4['point_table']         = $g4['table_prefix'] . "point";         // 포인트 테이블
$g4['popular_table']       = $g4['table_prefix'] . "popular";       // 인기검색어 테이블
$g4['scrap_table']         = $g4['table_prefix'] . "scrap";         // 게시글 스크랩 테이블
$g4['visit_table']         = $g4['table_prefix'] . "visit";         // 방문자 테이블
$g4['visit_sum_table']     = $g4['table_prefix'] . "visit_sum";     // 방문자 합계 테이블
$g4['token_table']         = $g4['table_prefix'] . "token";         // 토큰 테이블
$g4['zip_table']           = $g4['table_prefix'] . "zip";           // 우편번호 테이블
$g4['syndi_log_table']     = $g4['table_prefix'] . "syndi_log";     // 우편번호 테이블
$g4['uniqid_table']        = $g4['table_prefix'] . "uniqid";        // 우편번호 테이블

$g4['cookie_domain']       = "";
$g4['link_count']          = 2;
$g4['charset']             = "utf-8";
$g4['phpmyadmin_dir']      = $g4['admin'] . "/phpMyAdmin/";
$g4['token_time']          = 3; // 토큰 유효시간

$g4['url']                 = "";
$g4['https_url']           = "";

$ShowHideType                = "timeout"; // 'default', 'simple', 'simple_timeout', 'timeout' 
$site_name                   = ""; // 여기에 사이트 네임 지정시 관리자 설정보다 우선 적용됨
$va                          = ".v";

$g4['default_thumb_width']   = 130;
$g4['default_thumb_height']  = 90;
$g4['default_thumb_quality'] = 90;

$g4['visit2_table']          = $g4['table_prefix'] . "visit2";         // 보조 방문자 테이블
$g4['config2_table']         = $g4['table_prefix'] . "config2";        // 기본환경 설정2 테이블
$g4['config2m_table']        = $g4['table_prefix'] . "config2m";        // 기본환경 설정2m 테이블
$g4['config2w_table']        = $g4['table_prefix'] . "config2w";        // 기본환경 설정2w 테이블
$g4['editor_name']           = "geditor"; /// cheditor4, geditor
$g4['mem_table']             = $g4['table_prefix'] . "memcheck";          // 로그인 정보 테이블을 추가합니다. 
$g4['shop5_path']            = $g4['path'] . "/" . "shop5"; /// 2010.10.20
$g4['shop5_adm_path']        = $g4['path'] . "/" .$g4['admin'] . "/shop5"; /// 2011.04.07
$g4['shop5_gr_id']           = "shop5"; /// 2011.04.01
$g4['syndi']                 = "syndi";
$g4['syndi_path']            = $g4['path'] . "/" . $g4['syndi'];
$config['cf_use_syndi']      = 0;
$config['cf_no_open_list']   = array("test");
$g4['admin_tmpl']            = "good_basic"; /// change here, if needed
$g4['admin_tmpl_path']       = $g4['admin_path'] . "/" . $g4['tmpl_dir'] ."/" .$g4['admin_tmpl'];

$use_mini_mobile             = 0;
if(file_exists("$g4[path]/m/group.php")) $use_mini_mobile = 1;

$g4['use_member_register']   = 1;
$g4['msg_nouse_member_register'] = "본 사이트에서는 현재 회원 등록을 받고 있지 않습니다";
$g4['use_visit_log']         = 1; /// visit log. visit2_table 필요
$g4['use_device_change']     = 1;

} /// if 0

/// wild mapping
$g4 = $g5;
$config2 = $config2w;
?>
