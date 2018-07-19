<?php
@set_time_limit(0);
@header('Content-Type: text/html; charset=utf-8');
@header('X-Robots-Tag: noindex');

include_once ('../../config.php');
include_once ('../../lib/common.lib.php');

$title = G5_VERSION." &amp; 이윰빌더 설치 완료";
include_once ('./setup.head.php');
include_once ('../classes/qfile.class.php');

if( ! function_exists('safe_install_string_check') ){
    function safe_install_string_check( $str ) {
        $is_check = false;

        if(preg_match('#\);(passthru|eval|pcntl_exec|exec|system|popen|fopen|fsockopen|file|file_get_contents|readfile|unlink|include|include_once|require|require_once)\s?#i', $str)) {
            $is_check = true;
        }

        if(preg_match('#\$_(get|post|request)\s?\[.*?\]\s?\)#i', $str)){
            $is_check = true;
        }

        if($is_check){
            die("입력한 값에 안전하지 않는 문자가 포함되어 있습니다. 설치를 중단합니다.");
        }

        return $str;
    }
}

if (!$exists_db_config || !$exists_eyoom_config) {
	include_once ('./setup.tail.php');
	exit;
}

$mysql_host  		= safe_install_string_check($_POST['mysql_host']);
$mysql_user  		= safe_install_string_check($_POST['mysql_user']);
$mysql_pass  		= safe_install_string_check($_POST['mysql_pass']);
$mysql_db    		= safe_install_string_check($_POST['mysql_db']);
$table_prefix		= safe_install_string_check($_POST['table_prefix']);
$admin_id			= $_POST['admin_id'];
$admin_pass			= $_POST['admin_pass'];
$admin_name			= $_POST['admin_name'];
$admin_email		= $_POST['admin_email'];

$tm_key				= $_POST['tm_key'];
$cm_key				= $_POST['cm_key'];
$cm_salt			= $_POST['cm_salt'];
$tm_name			= $_POST['tm_name'];
$tm_shop			= $_POST['tm_shop'];
$tm_community		= $_POST['tm_community'];
$tm_mainside		= $_POST['tm_mainside'];
$tm_subside			= $_POST['tm_subside'];
$tm_mainpos			= $_POST['tm_mainpos'];
$tm_subpos			= $_POST['tm_subpos'];
$tm_shopmainside	= $_POST['tm_shopmainside'];
$tm_shopsubside		= $_POST['tm_shopsubside'];
$tm_shopmainpos		= $_POST['tm_shopmainpos'];
$tm_shopsubpos		= $_POST['tm_shopsubpos'];

// 테마키 체크
if (!$tm_key || strlen($tm_key) != 50) {
    echo '<script>alert("구매하신 테마의 라이선스키를 정확히 입력해 주세요."); history.go(-1);</script>';
    exit;
}

// 커스터머키 체크
if (!$cm_key || !$tm_name) {
    echo '<script>alert("정상적인 방법으로 설치해 주세요."); history.go(-1);</script>';
    exit;
}

$tm_path = '../..' . G5_PATH . '/eyoom/theme/' . $tm_name;
if (!is_dir($tm_path)) {
    echo '<script>alert("입력하신 테마 라이선스키와 설치하고자 하는 테마가 서로 일치하지 않습니다."); history.go(-1);</script>';
    exit;
}

// 사이드영역 출력여부 및 위치
$tm_mainside = ($tm_mainside == '' || $tm_mainside == 'n') ? 'n': 'y';
$tm_subside = ($tm_subside == '' || $tm_subside == 'n') ? 'n': 'y';
$tm_mainpos = ($tm_mainpos == '' || $tm_mainpos == 'n') ? 'right': 'left';
$tm_subpos = ($tm_subpos == '' || $tm_subpos == 'n') ? 'right': 'left';
$tm_shopmainside = ($tm_shopmainside == '' || $tm_shopmainside == 'n') ? 'n': 'y';
$tm_shopsubside = ($tm_shopsubside == '' || $tm_shopsubside == 'n') ? 'n': 'y';
$tm_shopmainpos = ($tm_shopmainpos == '' || $tm_shopmainpos == 'n') ? 'right': 'left';
$tm_shopsubpos = ($tm_shopsubpos == '' || $tm_shopsubpos == 'n') ? 'right': 'left';

if ($tm_shop == 'y' && defined('G5_YOUNGCART_VER')) {
	$g5_install = 0;
	if (isset($_POST['g5_install']))
	    $g5_install  = $_POST['g5_install'];
	$g5_shop_prefix = $_POST['g5_shop_prefix'];
	$g5_shop_install= $_POST['g5_shop_install'];
} else {
	$g5_shop_install = false;
}

/*************************************
 * DB 접속 및 실패시 예외처리
 ************************************/
$dblink = sql_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if (!$dblink) {
?>
<div class="ins_inner">
    <p>MySQL Host, User, Password 를 확인해 주십시오.</p>
    <div class="inner_btn"><a href="./setup.config.php">뒤로가기</a></div>
</div>
<?php
	include_once ('./setup.tail.php');
	exit;
}

/*************************************
 * Database 선택 및 예외처리
 ************************************/
$select_db = sql_select_db($mysql_db, $dblink);
if (!$select_db) {
?>
<div class="ins_inner">
    <p>MySQL DB 를 확인해 주십시오.</p>
    <div class="inner_btn"><a href="./setup.config.php">뒤로가기</a></div>
</div>
<?php
	include_once ('./setup.tail.php');
	exit;
}

$mysql_set_mode = 'false';
sql_set_charset('utf8', $dblink);
$result = sql_query(" SELECT @@sql_mode as mode ", true, $dblink);
$row = sql_fetch_array($result);
if($row['mode']) {
    sql_query("SET SESSION sql_mode = ''", true, $dblink);
    $mysql_set_mode = 'true';
}
unset($result);
unset($row);

/*************************************
 * 설치 시작
 ************************************/
?>
<ul id="progressbar">
	<li class="active">초기설정</li>
	<li class="active">라이선스 동의</li>
	<li class="active">정보입력</li>
	<li class="active">설치완료</li>
</ul>

<div class="ins_inner">
    <h3 class="ins_inner_title2">설치가 시작되었습니다.</h3>

    <ol>
<?php
$sql = " desc {$table_prefix}config";
$result = @sql_query($sql, false, $dblink);

// 그누보드5 재설치에 체크하였거나 그누보드5가 설치되어 있지 않다면
if($g5_install || !$result) {
	// 테이블 생성 ------------------------------------
	$file = implode('', file('../../install/gnuboard5.sql'));
	eval("\$file = \"$file\";");

	$file = preg_replace('/^--.*$/m', '', $file);
	$file = preg_replace('/`g5_([^`]+`)/', '`'.$table_prefix.'$1', $file);
	$f = explode(';', $file);
	for ($i=0; $i<count($f); $i++) {
	    if (trim($f[$i]) == '') continue;
	    sql_query($f[$i], true, $dblink);
	}
}

// 쇼핑몰 테이블 생성 -----------------------------
if($g5_shop_install) {
    $file = implode('', file('../../install/gnuboard5shop.sql'));

    $file = preg_replace('/^--.*$/m', '', $file);
    $file = preg_replace('/`g5_shop_([^`]+`)/', '`'.$g5_shop_prefix.'$1', $file);
    $f = explode(';', $file);
    for ($i=0; $i<count($f); $i++) {
        if (trim($f[$i]) == '') continue;
        sql_query($f[$i], true, $dblink);
    }
}
// 테이블 생성 ------------------------------------
?>

        <li>전체 테이블 생성 완료</li>
<?php
$read_point = 0;
$write_point = 0;
$comment_point = 0;
$download_point = 0;

//-------------------------------------------------------------------------------------------------
// config 테이블 설정
if($g5_install || !$result) {
    $sql = " insert into `{$table_prefix}config`
                set cf_title = '".G5_VERSION."',
                    cf_theme = 'basic',
                    cf_admin = '$admin_id',
                    cf_admin_email = '$admin_email',
                    cf_admin_email_name = '".G5_VERSION."',
                    cf_use_point = '1',
                    cf_use_copy_log = '1',
                    cf_login_point = '100',
                    cf_memo_send_point = '500',
                    cf_cut_name = '15',
                    cf_nick_modify = '60',
                    cf_new_skin = 'basic',
                    cf_new_rows = '15',
                    cf_search_skin = 'basic',
                    cf_connect_skin = 'basic',
                    cf_read_point = '$read_point',
                    cf_write_point = '$write_point',
                    cf_comment_point = '$comment_point',
                    cf_download_point = '$download_point',
                    cf_write_pages = '10',
                    cf_mobile_pages = '5',
                    cf_link_target = '_blank',
                    cf_delay_sec = '30',
	                cf_filter = '18아,18놈,18새끼,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,ㅅㅂㄹㅁ',
                    cf_possible_ip = '',
                    cf_intercept_ip = '',
                    cf_member_skin = 'basic',
                    cf_mobile_new_skin = 'basic',
                    cf_mobile_search_skin = 'basic',
                    cf_mobile_connect_skin = 'basic',
                    cf_mobile_member_skin = 'basic',
                    cf_faq_skin = 'basic',
                    cf_mobile_faq_skin = 'basic',
                    cf_editor = 'smarteditor2',
                    cf_captcha_mp3 = 'basic',
                    cf_register_level = '2',
                    cf_register_point = '1000',
                    cf_icon_level = '2',
                    cf_leave_day = '30',
                    cf_search_part = '10000',
                    cf_email_use = '1',
                    cf_prohibit_id = 'admin,administrator,관리자,운영자,어드민,주인장,webmaster,웹마스터,sysop,시삽,시샵,manager,매니저,메니저,root,루트,su,guest,방문객',
                    cf_prohibit_email = '',
                    cf_new_del = '30',
                    cf_memo_del = '180',
                    cf_visit_del = '180',
                    cf_popular_del = '180',
                    cf_use_member_icon = '2',
                    cf_member_icon_size = '5000',
                    cf_member_icon_width = '22',
                    cf_member_icon_height = '22',
                    cf_login_minutes = '10',
                    cf_image_extension = 'gif|jpg|jpeg|png',
                    cf_flash_extension = 'swf',
                    cf_movie_extension = 'asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3',
                    cf_formmail_is_member = '1',
                    cf_page_rows = '15',
                    cf_mobile_page_rows = '15',
                    cf_cert_limit = '2',
                    cf_stipulation = '해당 홈페이지에 맞는 회원가입약관을 입력합니다.',
                    cf_privacy = '해당 홈페이지에 맞는 개인정보처리방침을 입력합니다.'
                    ";
    sql_query($sql, true, $dblink);

    // 1:1문의 설정
    $sql = " insert into `{$table_prefix}qa_config`
                ( qa_title, qa_category, qa_skin, qa_mobile_skin, qa_use_email, qa_req_email, qa_use_hp, qa_req_hp, qa_use_editor, qa_subject_len, qa_mobile_subject_len, qa_page_rows, qa_mobile_page_rows, qa_image_width, qa_upload_size, qa_insert_content )
              values
                ( '1:1문의', '회원|포인트', 'basic', 'basic', '1', '0', '1', '0', '1', '60', '30', '15', '15', '600', '1048576', '' ) ";
    sql_query($sql, true, $dblink);

    // 관리자 회원가입
    $sql = " insert into `{$table_prefix}member`
                set mb_id = '$admin_id',
                     mb_password = PASSWORD('$admin_pass'),
                     mb_name = '$admin_name',
                     mb_nick = '$admin_name',
                     mb_email = '$admin_email',
                     mb_level = '10',
                     mb_mailling = '1',
                     mb_open = '1',
                     mb_email_certify = '".G5_TIME_YMDHIS."',
                     mb_datetime = '".G5_TIME_YMDHIS."',
                     mb_ip = '{$_SERVER['REMOTE_ADDR']}'
                     ";
    sql_query($sql, true, $dblink);

    // 내용관리 생성
    sql_query(" insert into `{$table_prefix}content` set co_id = 'company', co_html = '1', co_subject = '회사소개', co_content= '<p align=center><b>회사소개에 대한 내용을 입력하십시오.</b></p>', co_skin = 'basic', co_mobile_skin = 'basic' ", true, $dblink);
    sql_query(" insert into `{$table_prefix}content` set co_id = 'privacy', co_html = '1', co_subject = '개인정보 처리방침', co_content= '<p align=center><b>개인정보 처리방침에 대한 내용을 입력하십시오.</b></p>', co_skin = 'basic', co_mobile_skin = 'basic' ", true, $dblink);
    sql_query(" insert into `{$table_prefix}content` set co_id = 'provision', co_html = '1', co_subject = '서비스 이용약관', co_content= '<p align=center><b>서비스 이용약관에 대한 내용을 입력하십시오.</b></p>', co_skin = 'basic', co_mobile_skin = 'basic' ", true, $dblink);

    // FAQ Master
    sql_query(" insert into `{$table_prefix}faq_master` set fm_id = '1', fm_subject = '자주하시는 질문' ", true, $dblink);
}

if($g5_shop_install) {
    // 이미지 사이즈
    $simg_width = 600;
    $simg_height = 0;
    $mimg_width = 1000;
    $mimg_height = 0;

    // default 설정 (쇼핑몰 설정)
    $sql = " insert into `{$g5_shop_prefix}default`
                set de_admin_company_name = '회사명',
                    de_admin_company_saupja_no = '123-45-67890',
                    de_admin_company_owner = '대표자명',
                    de_admin_company_tel = '02-123-4567',
                    de_admin_company_fax = '02-123-4568',
                    de_admin_tongsin_no = '제 OO구 - 123호',
                    de_admin_buga_no = '12345호',
                    de_admin_company_zip = '123-456',
                    de_admin_company_addr = 'OO도 OO시 OO구 OO동 123-45',
                    de_admin_info_name = '정보책임자명',
                    de_admin_info_email = '정보책임자 E-mail',
                    de_shop_skin = 'basic',
                    de_shop_mobile_skin = 'basic',
                    de_type1_list_use = '1',
                    de_type1_list_skin = 'main.10.skin.php',
                    de_type1_list_mod = '3',
                    de_type1_list_row = '2',
                    de_type1_img_width = '$simg_width',
                    de_type1_img_height = '$simg_height',
                    de_type2_list_use = '1',
                    de_type2_list_skin = 'main.10.skin.php',
                    de_type2_list_mod = '3',
                    de_type2_list_row = '2',
                    de_type2_img_width = '$simg_width',
                    de_type2_img_height = '$simg_height',
                    de_type3_list_use = '1',
                    de_type3_list_skin = 'main.10.skin.php',
                    de_type3_list_mod = '1',
                    de_type3_list_row = '3',
                    de_type3_img_width = '$simg_width',
                    de_type3_img_height = '$simg_height',
                    de_type4_list_use = '1',
                    de_type4_list_skin = 'main.10.skin.php',
                    de_type4_list_mod = '3',
                    de_type4_list_row = '1',
                    de_type4_img_width = '$simg_width',
                    de_type4_img_height = '$simg_height',
                    de_type5_list_use = '1',
                    de_type5_list_skin = 'main.10.skin.php',
                    de_type5_list_mod = '3',
                    de_type5_list_row = '1',
                    de_type5_img_width = '$simg_width',
                    de_type5_img_height = '$simg_height',
                    de_mobile_type1_list_use = '1',
                    de_mobile_type1_list_skin = 'main.10.skin.php',
                    de_mobile_type1_list_mod = '3',
                    de_mobile_type1_list_row = '2',
                    de_mobile_type1_img_width = '$simg_width',
                    de_mobile_type1_img_height = '$simg_height',
                    de_mobile_type2_list_use = '1',
                    de_mobile_type2_list_skin = 'main.10.skin.php',
                    de_mobile_type2_list_mod = '3',
                    de_mobile_type2_list_row = '2',
                    de_mobile_type2_img_width = '$simg_width',
                    de_mobile_type2_img_height = '$simg_height',
                    de_mobile_type3_list_use = '1',
                    de_mobile_type3_list_skin = 'main.10.skin.php',
                    de_mobile_type3_list_mod = '3',
                    de_mobile_type3_list_row = '2',
                    de_mobile_type3_img_width = '$simg_width',
                    de_mobile_type3_img_height = '$simg_height',
                    de_mobile_type4_list_use = '1',
                    de_mobile_type4_list_skin = 'main.10.skin.php',
                    de_mobile_type4_list_mod = '3',
                    de_mobile_type4_list_row = '2',
                    de_mobile_type4_img_width = '$simg_width',
                    de_mobile_type4_img_height = '$simg_height',
                    de_mobile_type5_list_use = '1',
                    de_mobile_type5_list_skin = 'main.10.skin.php',
                    de_mobile_type5_list_mod = '3',
                    de_mobile_type5_list_row = '2',
                    de_mobile_type5_img_width = '$simg_width',
                    de_mobile_type5_img_height = '$simg_height',
                    de_bank_use = '1',
                    de_bank_account = 'OO은행 12345-67-89012 예금주명',
                    de_vbank_use = '0',
                    de_iche_use = '0',
                    de_card_use = '0',
                    de_settle_min_point = '5000',
                    de_settle_max_point = '50000',
                    de_settle_point_unit = '100',
                    de_cart_keep_term = '15',
                    de_card_point = '0',
                    de_point_days = '7',
                    de_pg_service = 'kcp',
                    de_kcp_mid = '',
                    de_send_cost_case = '차등',
                    de_send_cost_limit = '20000;30000;40000',
                    de_send_cost_list = '4000;3000;2000',
                    de_hope_date_use = '0',
                    de_hope_date_after = '3',
                    de_baesong_content = '배송 안내 입력전입니다.',
                    de_change_content = '교환/반품 안내 입력전입니다.',
                    de_rel_list_use = '1',
                    de_rel_list_skin = 'relation.10.skin.php',
                    de_rel_list_mod = '3',
                    de_rel_img_width = '$simg_width',
                    de_rel_img_height = '$simg_height',
                    de_mobile_rel_list_use = '1',
                    de_mobile_rel_list_skin = 'relation.10.skin.php',
                    de_mobile_rel_list_mod = '3',
                    de_mobile_rel_img_width = '$simg_width',
                    de_mobile_rel_img_height = '$simg_height',
                    de_search_list_skin = 'list.10.skin.php',
                    de_search_img_width = '$simg_width',
                    de_search_img_height = '$simg_height',
                    de_search_list_mod = '3',
                    de_search_list_row = '5',
                    de_mobile_search_list_skin = 'list.10.skin.php',
                    de_mobile_search_img_width = '$simg_width',
                    de_mobile_search_img_height = '$simg_height',
                    de_mobile_search_list_mod = '3',
                    de_mobile_search_list_row = '5',
                    de_listtype_list_skin = 'list.10.skin.php',
                    de_listtype_img_width = '$simg_width',
                    de_listtype_img_height = '$simg_height',
                    de_listtype_list_mod = '3',
                    de_listtype_list_row = '5',
                    de_mobile_listtype_list_skin = 'list.10.skin.php',
                    de_mobile_listtype_img_width = '$simg_width',
                    de_mobile_listtype_img_height = '$simg_height',
                    de_mobile_listtype_list_mod = '3',
                    de_mobile_listtype_list_row = '5',
                    de_simg_width = '$simg_width',
                    de_simg_height = '$simg_height',
                    de_mimg_width = '$mimg_width',
                    de_mimg_height = '$mimg_height',
                    de_item_use_use = '1',
                    de_level_sell = '1',
                    de_code_dup_use = '1',
                    de_card_test = '1',
                    de_sms_cont1 = '{이름}님의 회원가입을 축하드립니다.\nID:{회원아이디}\n{회사명}',
                    de_sms_cont2 = '{이름}님 주문해주셔서 고맙습니다.\n{주문번호}\n{주문금액}원\n{회사명}',
                    de_sms_cont3 = '{이름}님께서 주문하셨습니다.\n{주문번호}\n{주문금액}원\n{회사명}',
                    de_sms_cont4 = '{이름}님 입금 감사합니다.\n{입금액}원\n주문번호:\n{주문번호}\n{회사명}',
                    de_sms_cont5 = '{이름}님 배송합니다.\n택배:{택배회사}\n운송장번호:\n{운송장번호}\n{회사명}'
                    ";
    sql_query($sql, true, $dblink);

    // 게시판 그룹 생성
    sql_query(" insert into `{$table_prefix}group` set gr_id = 'shop', gr_subject = '쇼핑몰' ", true, $dblink);

    // 게시판 생성
    $tmp_bo_table   = array ("qa", "free", "notice");
    $tmp_bo_subject = array ("질문답변", "자유게시판", "공지사항");
    for ($i=0; $i<count($tmp_bo_table); $i++)
    {
        $sql = " insert into `{$table_prefix}board`
                    set bo_table = '$tmp_bo_table[$i]',
                        gr_id = 'shop',
                        bo_subject = '$tmp_bo_subject[$i]',
                        bo_device           = 'both',
                        bo_admin            = '',
                        bo_list_level       = '1',
                        bo_read_level       = '1',
                        bo_write_level      = '1',
                        bo_reply_level      = '1',
                        bo_comment_level    = '1',
                        bo_html_level       = '1',
                        bo_link_level       = '1',
                        bo_count_modify     = '1',
                        bo_count_delete     = '1',
                        bo_upload_level     = '1',
                        bo_download_level   = '1',
                        bo_read_point       = '-1',
                        bo_write_point      = '5',
                        bo_comment_point    = '1',
                        bo_download_point   = '-20',
                        bo_use_category     = '0',
                        bo_category_list    = '',
                        bo_use_sideview     = '0',
                        bo_use_file_content = '0',
                        bo_use_secret       = '0',
                        bo_use_dhtml_editor = '0',
                        bo_use_rss_view     = '0',
                        bo_use_good         = '0',
                        bo_use_nogood       = '0',
                        bo_use_name         = '0',
                        bo_use_signature    = '0',
                        bo_use_ip_view      = '0',
                        bo_use_list_view    = '0',
                        bo_use_list_content = '0',
                        bo_use_email        = '0',
                        bo_table_width      = '100',
                        bo_subject_len      = '60',
                        bo_mobile_subject_len      = '30',
                        bo_page_rows        = '15',
                        bo_mobile_page_rows = '15',
                        bo_new              = '24',
                        bo_hot              = '100',
                        bo_image_width      = '800',
                        bo_skin             = 'basic',
                        bo_mobile_skin      = 'basic',
                        bo_include_head     = '_head.php',
                        bo_include_tail     = '_tail.php',
                        bo_content_head     = '',
                        bo_content_tail     = '',
                        bo_mobile_content_head     = '',
                        bo_mobile_content_tail     = '',
                        bo_insert_content   = '',
                        bo_gallery_cols     = '4',
                        bo_gallery_width    = '600',
                        bo_gallery_height   = '0',
                        bo_mobile_gallery_width = '600',
                        bo_mobile_gallery_height= '0',
                        bo_upload_count     = '2',
                        bo_upload_size      = '1048576',
                        bo_reply_order      = '1',
                        bo_use_search       = '0',
                        bo_order            = '0'
                        ";
        sql_query($sql, true, $dblink);

        // 게시판 테이블 생성
        $file = file("../../adm/sql_write.sql");
        $sql = implode($file, "\n");

        $create_table = $table_prefix.'write_' . $tmp_bo_table[$i];

        // sql_board.sql 파일의 테이블명을 변환
        $source = array("/__TABLE_NAME__/", "/;/");
        $target = array($create_table, "");
        $sql = preg_replace($source, $target, $sql);
        sql_query($sql, true, $dblink);
    }
}
?>

        <li>DB설정 완료</li>

<?php
//-------------------------------------------------------------------------------------------------

// 디렉토리 생성
$dir_arr = array (
    $data_path.'/cache',
    $data_path.'/editor',
    $data_path.'/file',
    $data_path.'/log',
    $data_path.'/member',
    $data_path.'/session',
    $data_path.'/content',
    $data_path.'/faq',
    $data_path.'/tmp'
);

for ($i=0; $i<count($dir_arr); $i++) {
    @mkdir($dir_arr[$i], G5_DIR_PERMISSION);
    @chmod($dir_arr[$i], G5_DIR_PERMISSION);
}

if($g5_shop_install) {
    $dir_arr = array (
        $data_path.'/banner',
        $data_path.'/common',
        $data_path.'/event',
        $data_path.'/item'
    );

    for ($i=0; $i<count($dir_arr); $i++) {
        @mkdir($dir_arr[$i], G5_DIR_PERMISSION);
        @chmod($dir_arr[$i], G5_DIR_PERMISSION);
    }
}
?>

        <li>데이터 디렉토리 생성 완료</li>

<?php
//-------------------------------------------------------------------------------------------------

// DB 설정 파일 생성
$file = $data_path . '/' . G5_DBCONFIG_FILE;
$f = @fopen($file, 'a');

fwrite($f, "<?php\n");
fwrite($f, "if (!defined('_GNUBOARD_')) exit;\n");
fwrite($f, "define('G5_MYSQL_HOST', '{$mysql_host}');\n");
fwrite($f, "define('G5_MYSQL_USER', '{$mysql_user}');\n");
fwrite($f, "define('G5_MYSQL_PASSWORD', '{$mysql_pass}');\n");
fwrite($f, "define('G5_MYSQL_DB', '{$mysql_db}');\n");
fwrite($f, "define('G5_MYSQL_SET_MODE', {$mysql_set_mode});\n\n");
fwrite($f, "define('G5_TABLE_PREFIX', '{$table_prefix}');\n\n");
fwrite($f, "\$g5['write_prefix'] = G5_TABLE_PREFIX.'write_'; // 게시판 테이블명 접두사\n\n");
fwrite($f, "\$g5['auth_table'] = G5_TABLE_PREFIX.'auth'; // 관리권한 설정 테이블\n");
fwrite($f, "\$g5['config_table'] = G5_TABLE_PREFIX.'config'; // 기본환경 설정 테이블\n");
fwrite($f, "\$g5['group_table'] = G5_TABLE_PREFIX.'group'; // 게시판 그룹 테이블\n");
fwrite($f, "\$g5['group_member_table'] = G5_TABLE_PREFIX.'group_member'; // 게시판 그룹+회원 테이블\n");
fwrite($f, "\$g5['board_table'] = G5_TABLE_PREFIX.'board'; // 게시판 설정 테이블\n");
fwrite($f, "\$g5['board_file_table'] = G5_TABLE_PREFIX.'board_file'; // 게시판 첨부파일 테이블\n");
fwrite($f, "\$g5['board_good_table'] = G5_TABLE_PREFIX.'board_good'; // 게시물 추천,비추천 테이블\n");
fwrite($f, "\$g5['board_new_table'] = G5_TABLE_PREFIX.'board_new'; // 게시판 새글 테이블\n");
fwrite($f, "\$g5['login_table'] = G5_TABLE_PREFIX.'login'; // 로그인 테이블 (접속자수)\n");
fwrite($f, "\$g5['mail_table'] = G5_TABLE_PREFIX.'mail'; // 회원메일 테이블\n");
fwrite($f, "\$g5['member_table'] = G5_TABLE_PREFIX.'member'; // 회원 테이블\n");
fwrite($f, "\$g5['memo_table'] = G5_TABLE_PREFIX.'memo'; // 메모 테이블\n");
fwrite($f, "\$g5['poll_table'] = G5_TABLE_PREFIX.'poll'; // 투표 테이블\n");
fwrite($f, "\$g5['poll_etc_table'] = G5_TABLE_PREFIX.'poll_etc'; // 투표 기타의견 테이블\n");
fwrite($f, "\$g5['point_table'] = G5_TABLE_PREFIX.'point'; // 포인트 테이블\n");
fwrite($f, "\$g5['popular_table'] = G5_TABLE_PREFIX.'popular'; // 인기검색어 테이블\n");
fwrite($f, "\$g5['scrap_table'] = G5_TABLE_PREFIX.'scrap'; // 게시글 스크랩 테이블\n");
fwrite($f, "\$g5['visit_table'] = G5_TABLE_PREFIX.'visit'; // 방문자 테이블\n");
fwrite($f, "\$g5['visit_sum_table'] = G5_TABLE_PREFIX.'visit_sum'; // 방문자 합계 테이블\n");
fwrite($f, "\$g5['uniqid_table'] = G5_TABLE_PREFIX.'uniqid'; // 유니크한 값을 만드는 테이블\n");
fwrite($f, "\$g5['autosave_table'] = G5_TABLE_PREFIX.'autosave'; // 게시글 작성시 일정시간마다 글을 임시 저장하는 테이블\n");
fwrite($f, "\$g5['cert_history_table'] = G5_TABLE_PREFIX.'cert_history'; // 인증내역 테이블\n");
fwrite($f, "\$g5['qa_config_table'] = G5_TABLE_PREFIX.'qa_config'; // 1:1문의 설정테이블\n");
fwrite($f, "\$g5['qa_content_table'] = G5_TABLE_PREFIX.'qa_content'; // 1:1문의 테이블\n");
fwrite($f, "\$g5['content_table'] = G5_TABLE_PREFIX.'content'; // 내용(컨텐츠)정보 테이블\n");
fwrite($f, "\$g5['faq_table'] = G5_TABLE_PREFIX.'faq'; // 자주하시는 질문 테이블\n");
fwrite($f, "\$g5['faq_master_table'] = G5_TABLE_PREFIX.'faq_master'; // 자주하시는 질문 마스터 테이블\n");
fwrite($f, "\$g5['new_win_table'] = G5_TABLE_PREFIX.'new_win'; // 새창 테이블\n");
fwrite($f, "\$g5['menu_table'] = G5_TABLE_PREFIX.'menu'; // 메뉴관리 테이블\n");

if($g5_shop_install) {
    fwrite($f, "\n");
    fwrite($f, "define('G5_USE_SHOP', true);\n\n");
    fwrite($f, "define('G5_SHOP_TABLE_PREFIX', '{$g5_shop_prefix}');\n\n");
    fwrite($f, "\$g5['g5_shop_default_table'] = G5_SHOP_TABLE_PREFIX.'default'; // 쇼핑몰설정 테이블\n");
    fwrite($f, "\$g5['g5_shop_banner_table'] = G5_SHOP_TABLE_PREFIX.'banner'; // 배너 테이블\n");
    fwrite($f, "\$g5['g5_shop_cart_table'] = G5_SHOP_TABLE_PREFIX.'cart'; // 장바구니 테이블\n");
    fwrite($f, "\$g5['g5_shop_category_table'] = G5_SHOP_TABLE_PREFIX.'category'; // 상품분류 테이블\n");
    fwrite($f, "\$g5['g5_shop_event_table'] = G5_SHOP_TABLE_PREFIX.'event'; // 이벤트 테이블\n");
    fwrite($f, "\$g5['g5_shop_event_item_table'] = G5_SHOP_TABLE_PREFIX.'event_item'; // 상품, 이벤트 연결 테이블\n");
    fwrite($f, "\$g5['g5_shop_item_table'] = G5_SHOP_TABLE_PREFIX.'item'; // 상품 테이블\n");
    fwrite($f, "\$g5['g5_shop_item_option_table'] = G5_SHOP_TABLE_PREFIX.'item_option'; // 상품옵션 테이블\n");
    fwrite($f, "\$g5['g5_shop_item_use_table'] = G5_SHOP_TABLE_PREFIX.'item_use'; // 상품 사용후기 테이블\n");
    fwrite($f, "\$g5['g5_shop_item_qa_table'] = G5_SHOP_TABLE_PREFIX.'item_qa'; // 상품 질문답변 테이블\n");
    fwrite($f, "\$g5['g5_shop_item_relation_table'] = G5_SHOP_TABLE_PREFIX.'item_relation'; // 관련 상품 테이블\n");
    fwrite($f, "\$g5['g5_shop_order_table'] = G5_SHOP_TABLE_PREFIX.'order'; // 주문서 테이블\n");
    fwrite($f, "\$g5['g5_shop_order_delete_table'] = G5_SHOP_TABLE_PREFIX.'order_delete'; // 주문서 삭제 테이블\n");
    fwrite($f, "\$g5['g5_shop_wish_table'] = G5_SHOP_TABLE_PREFIX.'wish'; // 보관함(위시리스트) 테이블\n");
    fwrite($f, "\$g5['g5_shop_coupon_table'] = G5_SHOP_TABLE_PREFIX.'coupon'; // 쿠폰정보 테이블\n");
    fwrite($f, "\$g5['g5_shop_coupon_zone_table'] = G5_SHOP_TABLE_PREFIX.'coupon_zone'; // 쿠폰존 테이블\n");
    fwrite($f, "\$g5['g5_shop_coupon_log_table'] = G5_SHOP_TABLE_PREFIX.'coupon_log'; // 쿠폰사용정보 테이블\n");
    fwrite($f, "\$g5['g5_shop_sendcost_table'] = G5_SHOP_TABLE_PREFIX.'sendcost'; // 추가배송비 테이블\n");
    fwrite($f, "\$g5['g5_shop_personalpay_table'] = G5_SHOP_TABLE_PREFIX.'personalpay'; // 개인결제 정보 테이블\n");
    fwrite($f, "\$g5['g5_shop_order_address_table'] = G5_SHOP_TABLE_PREFIX.'order_address'; // 배송지이력 정보 테이블\n");
    fwrite($f, "\$g5['g5_shop_item_stocksms_table'] = G5_SHOP_TABLE_PREFIX.'item_stocksms'; // 재입고SMS 알림 정보 테이블\n");
    fwrite($f, "\$g5['g5_shop_order_data_table'] = G5_SHOP_TABLE_PREFIX.'order_data'; // 모바일 결제정보 임시저장 테이블\n");
    fwrite($f, "\$g5['g5_shop_inicis_log_table'] = G5_SHOP_TABLE_PREFIX.'inicis_log'; // 이니시스 모바일 계좌이체 로그 테이블\n");
}

fwrite($f, "?>");

fclose($f);
@chmod($file, G5_FILE_PERMISSION);
?>

        <li>DB설정 파일 생성 완료 (<?php echo $file ?>)</li>

<?php
// data 디렉토리 및 하위 디렉토리에서는 .htaccess .htpasswd .php .phtml .html .htm .inc .cgi .pl 파일을 실행할수 없게함.
$f = fopen($data_path.'/.htaccess', 'w');
$str = <<<EOD
<FilesMatch "\.(htaccess|htpasswd|[Pp][Hh][Pp]|[Pp]?[Hh][Tt][Mm][Ll]?|[Ii][Nn][Cc]|[Cc][Gg][Ii]|[Pp][Ll])">
Order allow,deny
Deny from all
</FilesMatch>
EOD;
fwrite($f, $str);
fclose($f);

if($g5_shop_install) {
    @copy('./logo_img', $data_path.'/common/logo_img');
    @copy('./logo_img', $data_path.'/common/logo_img2');
    @copy('./mobile_logo_img', $data_path.'/common/mobile_logo_img');
    @copy('./mobile_logo_img', $data_path.'/common/mobile_logo_img2');
}
//-------------------------------------------------------------------------------------------------

// 이윰테마를 기본 홈테마로 설정
$sql = "update `{$table_prefix}config` set cf_theme='' where cf_theme!='' ";
sql_query($sql, true, $dblink);

$qfile = new qfile;

$eyoom_theme_config = $data_path.'/eyoom.' . $tm_name . '.config.php';

// 샵테마라면
$shop_theme = $tm_shop == 'y' ? $tm_name: '';
$work_url 	= $_SERVER['HTTP_HOST'];

// eyoom 기본설정
$eyoom = array(
	"theme" => $tm_name,
	"shop_theme" => $shop_theme,
	"is_shop_theme" => $tm_shop,
	"is_community_theme" => $tm_community,
	"work_url" => $work_url,
	"real_url" => "",
	"theme_selector" => "n",
	"bootstrap" => "1",
	"outlogin_skin" => "basic",
	"connect_skin" => "basic",
	"popular_skin" => "basic",
	"poll_skin" => "basic",
	"visit_skin" => "basic",
	"new_skin" => "basic",
	"member_skin" => "basic",
	"faq_skin" => "basic",
	"qa_skin" => "basic",
	"search_skin" => "basic",
	"shop_skin" => "basic",
	"newwin_skin" => "basic",
	"mypage_skin" => "basic",
	"signature_skin" => "basic",
	"respond_skin" => "basic",
	"push_skin" => "basic",
	"board_skin" => "basic",
	"emoticon_skin" => "basic",
	"tag_skin" => "basic",
	"use_gnu_outlogin" => "n",
	"use_gnu_connect" => "n",
	"use_gnu_popular" => "n",
	"use_gnu_poll" => "n",
	"use_gnu_visit" => "n",
	"use_gnu_new" => "n",
	"use_gnu_member" => "n",
	"use_gnu_faq" => "n",
	"use_gnu_qa" => "n",
	"use_gnu_search" => "n",
	"use_gnu_shop" => "n",
	"use_gnu_newwin" => "n",
	"use_eyoom_admin" => "y",
	"use_eyoom_menu" => "y",
	"use_eyoom_shopmenu" => "n",
	"use_sideview" => "y",
	"use_main_side_layout" => "y",
	"use_sub_side_layout" => "y",
	"use_shopmain_side_layout" => "y",
	"use_shopsub_side_layout" => "y",
	"use_shop_mobile" => "n",
	"use_tag" => "n",
	"use_board_control" => "n",
	"use_theme_info" => "n",
	"tag_dpmenu_count" => "20",
	"tag_dpmenu_sort" => "regdt",
	"tag_recommend_count" => "5",
	"pos_main_side_layout" => "right",
	"pos_sub_side_layout" => "right",
	"pos_shopmain_side_layout" => "right",
	"pos_shopsub_side_layout" => "right",
	"level_icon_gnu" => "basic",
	"use_level_icon_gnu" => "n",
	"level_icon_eyoom" => "basic",
	"use_level_icon_eyoom" => "n",
	"push_reaction" => "y",
	"push_sound" => "push_sound_01.mp3",
	"push_time" => "10000",
	"photo_width" => "150",
	"photo_height" => "150",
	"cover_width" => "845",
	"cover_height" => "250",
	"countdown" => "n",
	"countdown_skin" => "basic",
	"countdown_date" => "",
	"use_social_login" => "y",
	"use_search_image" => "y",
	"search_image_width" => "300",
	"search_image_height" => "0",
	"group_latest_cnt" => "7",
);

// eyoom 설정파일 생성
$qfile->save_file('eyoom', $eyoom_config_file, $eyoom);
unset($eyoom['shop_theme']);

$eyoom['is_shop_theme'] 			= $tm_shop;
$eyoom['is_community_theme']		= $tm_community;
$eyoom['work_url'] 					= $work_url;
$eyoom['real_url'] 					= "";
$eyoom['use_main_side_layout']		= $tm_mainside;
$eyoom['use_sub_side_layout']		= $tm_subside;
$eyoom['pos_main_side_layout']		= $tm_mainpos;
$eyoom['pos_sub_side_layout']		= $tm_subpos;
$eyoom['use_shopmain_side_layout']	= $tm_shopmainside;
$eyoom['use_shopsub_side_layout']	= $tm_shopsubside;
$eyoom['pos_shopmain_side_layout']	= $tm_shopmainpos;
$eyoom['pos_shopsub_side_layout']	= $tm_shopsubpos;

$qfile->save_file('eyoom', $eyoom_theme_config, $eyoom);

// 이윰 레벨포인트 기본설정
$levelset = array(
	"gnu_name" => '포인트',
	"eyoom_name" => '경험치',
	"login" => '20',
	"write" => '10',
	"reply" => '10',
	"read" => '1',
	"cmt" => '5',
	"good" => '1',
	"regood" => '1',
	"nogood" => '1',
	"renogood" => '1',
	"memo" => '1',
	"following" => '2',
	"follower" => '2',
	"banner" => '5',
	"goodsview" => '1',
	"cart" => '1',
	"wishlist" => '1',
	"recommend" => '5',
	"review" => '5',
	"goodsqa" => '5',
	"order" => '15',
	"cancel" => '0',
	"gnu_alias_2" => '지하계',
	"gnu_alias_3" => '지상계',
	"gnu_alias_4" => '중간계',
	"gnu_alias_5" => '천상계',
	"gnu_alias_6" => '태양계',
	"gnu_alias_7" => '은하계',
	"gnu_alias_8" => '우주계',
	"gnu_alias_9" => '신',
	"max_use_gnu_level" => '7',
	"cnt_gnu_level_2" => '5',
	"cnt_gnu_level_3" => '10',
	"cnt_gnu_level_4" => '15',
	"cnt_gnu_level_5" => '20',
	"cnt_gnu_level_6" => '25',
	"cnt_gnu_level_7" => '30',
	"cnt_gnu_level_8" => '35',
	"cnt_gnu_level_9" => '40',
	"calc_level_point" => '100',
	"calc_level_ratio" => '200',
);
// 이윰 레벨포인트 설정파일 생성
$qfile->save_file('levelset', $levelset_config, $levelset);

$levelinfo = array(
	"1" => array("name" => "Level 1","min" => "0","max" => "200"),
	"2" => array("name" => "Level 2","min" => "200","max" => "600"),
	"3" => array("name" => "Level 3","min" => "600","max" => "1200"),
	"4" => array("name" => "Level 4","min" => "1200","max" => "2000"),
	"5" => array("name" => "Level 5","min" => "2000","max" => "3000"),
	"6" => array("name" => "Level 6","min" => "3000","max" => "4200"),
	"7" => array("name" => "Level 7","min" => "4200","max" => "5600"),
	"8" => array("name" => "Level 8","min" => "5600","max" => "7200"),
	"9" => array("name" => "Level 9","min" => "7200","max" => "9000"),
	"10" => array("name" => "Level 10","min" => "9000","max" => "11000"),
	"11" => array("name" => "Level 11","min" => "11000","max" => "13200"),
	"12" => array("name" => "Level 12","min" => "13200","max" => "15600"),
	"13" => array("name" => "Level 13","min" => "15600","max" => "18200"),
	"14" => array("name" => "Level 14","min" => "18200","max" => "21000"),
	"15" => array("name" => "Level 15","min" => "21000","max" => "24000"),
	"16" => array("name" => "Level 16","min" => "24000","max" => "27200"),
	"17" => array("name" => "Level 17","min" => "27200","max" => "30600"),
	"18" => array("name" => "Level 18","min" => "30600","max" => "34200"),
	"19" => array("name" => "Level 19","min" => "34200","max" => "38000"),
	"20" => array("name" => "Level 20","min" => "38000","max" => "42000"),
	"21" => array("name" => "Level 21","min" => "42000","max" => "46200"),
	"22" => array("name" => "Level 22","min" => "46200","max" => "50600"),
	"23" => array("name" => "Level 23","min" => "50600","max" => "55200"),
	"24" => array("name" => "Level 24","min" => "55200","max" => "60000"),
	"25" => array("name" => "Level 25","min" => "60000","max" => "65000"),
	"26" => array("name" => "Level 26","min" => "65000","max" => "70200"),
	"27" => array("name" => "Level 27","min" => "70200","max" => "75600"),
	"28" => array("name" => "Level 28","min" => "75600","max" => "81200"),
	"29" => array("name" => "Level 29","min" => "81200","max" => "87000"),
	"30" => array("name" => "Level 30","min" => "87000","max" => "93000"),
	"31" => array("name" => "Level 31","min" => "93000","max" => "99200"),
	"32" => array("name" => "Level 32","min" => "99200","max" => "105600"),
	"33" => array("name" => "Level 33","min" => "105600","max" => "112200"),
	"34" => array("name" => "Level 34","min" => "112200","max" => "119000"),
	"35" => array("name" => "Level 35","min" => "119000","max" => "126000"),
	"36" => array("name" => "Level 36","min" => "126000","max" => "133200"),
	"37" => array("name" => "Level 37","min" => "133200","max" => "140600"),
	"38" => array("name" => "Level 38","min" => "140600","max" => "148200"),
	"39" => array("name" => "Level 39","min" => "148200","max" => "156000"),
	"40" => array("name" => "Level 40","min" => "156000","max" => "164000"),
	"41" => array("name" => "Level 41","min" => "164000","max" => "172200"),
	"42" => array("name" => "Level 42","min" => "172200","max" => "180600"),
	"43" => array("name" => "Level 43","min" => "180600","max" => "189200"),
	"44" => array("name" => "Level 44","min" => "189200","max" => "198000"),
	"45" => array("name" => "Level 45","min" => "198000","max" => "207000"),
	"46" => array("name" => "Level 46","min" => "207000","max" => "216200"),
	"47" => array("name" => "Level 47","min" => "216200","max" => "225600"),
	"48" => array("name" => "Level 48","min" => "225600","max" => "235200"),
	"49" => array("name" => "Level 49","min" => "235200","max" => "245000"),
	"50" => array("name" => "Level 50","min" => "245000","max" => "255000"),
	"51" => array("name" => "Level 51","min" => "255000","max" => "265200"),
	"52" => array("name" => "Level 52","min" => "265200","max" => "275600"),
	"53" => array("name" => "Level 53","min" => "275600","max" => "286200"),
	"54" => array("name" => "Level 54","min" => "286200","max" => "297000"),
	"55" => array("name" => "Level 55","min" => "297000","max" => "308000"),
	"56" => array("name" => "Level 56","min" => "308000","max" => "319200"),
	"57" => array("name" => "Level 57","min" => "319200","max" => "330600"),
	"58" => array("name" => "Level 58","min" => "330600","max" => "342200"),
	"59" => array("name" => "Level 59","min" => "342200","max" => "354000"),
	"60" => array("name" => "Level 60","min" => "354000","max" => "366000"),
	"61" => array("name" => "Level 61","min" => "366000","max" => "378200"),
	"62" => array("name" => "Level 62","min" => "378200","max" => "390600"),
	"63" => array("name" => "Level 63","min" => "390600","max" => "403200"),
	"64" => array("name" => "Level 64","min" => "403200","max" => "416000"),
	"65" => array("name" => "Level 65","min" => "416000","max" => "429000"),
	"66" => array("name" => "Level 66","min" => "429000","max" => "442200"),
	"67" => array("name" => "Level 67","min" => "442200","max" => "455600"),
	"68" => array("name" => "Level 68","min" => "455600","max" => "469200"),
	"69" => array("name" => "Level 69","min" => "469200","max" => "483000"),
	"70" => array("name" => "Level 70","min" => "483000","max" => "497000"),
	"71" => array("name" => "Level 71","min" => "497000","max" => "511200"),
	"72" => array("name" => "Level 72","min" => "511200","max" => "525600"),
	"73" => array("name" => "Level 73","min" => "525600","max" => "540200"),
	"74" => array("name" => "Level 74","min" => "540200","max" => "555000"),
	"75" => array("name" => "Level 75","min" => "555000","max" => "570000"),
	"76" => array("name" => "Level 76","min" => "570000","max" => "585200"),
	"77" => array("name" => "Level 77","min" => "585200","max" => "600600"),
	"78" => array("name" => "Level 78","min" => "600600","max" => "616200"),
	"79" => array("name" => "Level 79","min" => "616200","max" => "632000"),
	"80" => array("name" => "Level 80","min" => "632000","max" => "648000"),
	"81" => array("name" => "Level 81","min" => "648000","max" => "664200"),
	"82" => array("name" => "Level 82","min" => "664200","max" => "680600"),
	"83" => array("name" => "Level 83","min" => "680600","max" => "697200"),
	"84" => array("name" => "Level 84","min" => "697200","max" => "714000"),
	"85" => array("name" => "Level 85","min" => "714000","max" => "731000"),
	"86" => array("name" => "Level 86","min" => "731000","max" => "748200"),
	"87" => array("name" => "Level 87","min" => "748200","max" => "765600"),
	"88" => array("name" => "Level 88","min" => "765600","max" => "783200"),
	"89" => array("name" => "Level 89","min" => "783200","max" => "801000"),
	"90" => array("name" => "Level 90","min" => "801000","max" => "819000"),
	"91" => array("name" => "Level 91","min" => "819000","max" => "837200"),
	"92" => array("name" => "Level 92","min" => "837200","max" => "855600"),
	"93" => array("name" => "Level 93","min" => "855600","max" => "874200"),
	"94" => array("name" => "Level 94","min" => "874200","max" => "893000"),
	"95" => array("name" => "Level 95","min" => "893000","max" => "912000"),
	"96" => array("name" => "Level 96","min" => "912000","max" => "931200"),
	"97" => array("name" => "Level 97","min" => "931200","max" => "950600"),
	"98" => array("name" => "Level 98","min" => "950600","max" => "970200"),
	"99" => array("name" => "Level 99","min" => "970200","max" => "990000"),
	"100" => array("name" => "Level 100","min" => "990000","max" => "1010000"),
	"101" => array("name" => "Level 101","min" => "1010000","max" => "1030200"),
	"102" => array("name" => "Level 102","min" => "1030200","max" => "1050600"),
	"103" => array("name" => "Level 103","min" => "1050600","max" => "1071200"),
	"104" => array("name" => "Level 104","min" => "1071200","max" => "1092000"),
	"105" => array("name" => "Level 105","min" => "1092000","max" => "1113000"),
);
// 이윰 레벨포인트 설정파일 생성
$qfile->save_file('levelinfo', $levelinfo_config, $levelinfo, true);
?>

		<li>이윰빌더 설정파일 생성 완료</li>

<?php
// 템플릿 폴더 생성
$template_dir = $data_path . '/_complie';
$cache_dir = $data_path . '/_cache';
@mkdir($template_dir, 0755, true);
@mkdir($cache_dir, 0755, true);
?>

		<li>템플릿 폴더 생성 완료</li>

<?php
// DB 테이블 생성

$sql = " desc `{$table_prefix}eyoom_member`";
$result = @sql_query($sql, false, $dblink);

if(!$result) {

    // 테이블 생성 ------------------------------------
    $file = implode('', file('./eyoom.table.sql'));
    eval("\$file = \"$file\";");

    $file = preg_replace('/^--.*$/m', '', $file);
    $file = preg_replace('/`g5_([^`]+`)/', '`'.$table_prefix.'$1', $file);
    $f = explode(';', $file);

    for ($i=0; $i<count($f); $i++) {
        if (trim($f[$i]) == '') continue;
        sql_query($f[$i], false, $dblink) or die(mysqli_error());
    }

    // 이윰메뉴 생성 -----------------------------------
    if (file_exists('./eyoom.menu.'.$tm_name.'.sql')) {
	    $file = implode('', file('./eyoom.menu.'.$tm_name.'.sql'));
	    eval("\$file = \"$file\";");

	    $file = preg_replace('/`g5_([^`]+`)/', '`'.$table_prefix.'$1', $file);
	    if ($g5_root != '' && $g5_root != '/') {
		    $file = str_replace("`me_link` = '", "`me_link` = '{$g5_root}", $file);
	    }
	    $q = explode(';', $file);

	    for ($i=0; $i<count($q); $i++) {
	        if (trim($q[$i]) == '') continue;
	        sql_query($q[$i], false, $dblink) or die(mysqli_error());
	    }
    }
}

// 테마 테이블에 테마정보 입력
$info = sql_fetch("select * from `{$table_prefix}eyoom_theme` where tm_name = '{$tm_name}' ", false, $dblink);
$tm_set = "
	tm_key = '{$tm_key}',
	cm_key = '{$cm_key}',
	cm_salt = '{$cm_salt}'
";

unset($update, $insert, $sql);
if ($info['tm_name']) {
	$update = "update `{$table_prefix}eyoom_theme` set {$tm_set}, tm_last = '" . G5_TIME_YMDHIS . "' where tm_name = '{$tm_name}' ";
    sql_query($update, false, $dblink);
} else {
	$insert = "insert into `{$table_prefix}eyoom_theme` set tm_name = '{$tm_name}', {$tm_set}, tm_time = '" . G5_TIME_YMDHIS . "' ";
    sql_query($insert, false, $dblink);
}

// 홈페이지 제목 - 기본값
$sql = "update `{$table_prefix}config` set cf_title = '이윰빌더', cf_admin_email_name = '메일발송 담당자' ";
sql_query($sql, false, $dblink);
?>
		<li>이윰빌더 DB 테이블 생성 완료</li>

    </ol>

    <p><strong class="color-red">축하합니다. 설치가 완료되었습니다.</strong></p>

</div>

<div class="ins_inner">

    <h3 class="ins_inner_title2">환경설정 변경은 다음의 과정을 따르십시오.</h2>

    <ol>
        <li>메인화면으로 이동</li>
        <li>관리자 로그인</li>
        <li>관리자 모드 접속</li>
        <li>환경설정 메뉴의 기본환경설정 페이지로 이동</li>
    </ol>

	<div class="inner_btn">
	    <a href="../../index.php" class="inner_abtn">메인페이지로 이동</a>
	</div>

</div>

<?php
include_once ('./setup.tail.php');
?>