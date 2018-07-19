<?php
function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

function rcopy($src, $dst) {
    if (file_exists($dst)) delTree($dst);
    if (is_dir($src)) {
        mkdir($dst);
        $files = scandir($src);
        foreach ($files as $file)
        if ($file != "." && $file != "..") rcopy("$src/$file", "$dst/$file");
    }
    else if (file_exists($src)) copy($src, $dst);
}
@set_time_limit(0);
$gmnow = gmdate('D, d M Y H:i:s') . ' GMT';
header('Expires: 0'); // rfc2616 - Section 14.21
header('Last-Modified: ' . $gmnow);
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0
@header('Content-Type: text/html; charset=utf-8');
@header('X-Robots-Tag: noindex');

include_once ('../config.php');
include_once ('../lib/common.lib.php');

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

$title = GB_VERSION." 설치 완료 3/3";
include_once ('./install.inc.php');

//print_r($_POST); exit;

$lang        = $_POST['lang'];
$mysql_host  = $_POST['mysql_host'];
$mysql_user  = $_POST['mysql_user'];
$mysql_pass  = $_POST['mysql_pass'];
$mysql_db    = $_POST['mysql_db'];
$table_prefix= $_POST['table_prefix'];
$admin_id    = $_POST['admin_id'];
$admin_pass  = $_POST['admin_pass'];
$admin_name  = $_POST['admin_name'];
$admin_email = $_POST['admin_email'];
$g5_install = 0;
if (isset($_POST['g5_install']))
    $g5_install  = $_POST['g5_install'];
$g5_shop_prefix = $_POST['g5_shop_prefix'];
$g5_shop_install = $_POST['g5_shop_install'];
$g5_contents_prefix = $_POST['g5_contents_prefix'];
$g5_contents_install = $_POST['g5_contents_install'];

if ($g5_shop_install || $g5_contents_install) {
    // 필수 모듈 체크
    require_once('./shop.library.check.php');
}

$dblink = sql_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if (!$dblink) {
?>

<div class="ins_inner">
    <p>MySQL Host, User, Password 를 확인해 주십시오.</p>
    <div class="inner_btn"><a href="./install_config.php">뒤로가기</a></div>
</div>

<?php
    include_once ('./install.inc2.php');
    exit;
}

$select_db = sql_select_db($mysql_db, $dblink);
if (!$select_db) {
?>

<div class="ins_inner">
    <p>MySQL DB 를 확인해 주십시오.</p>
    <div class="inner_btn"><a href="./install_config.php">뒤로가기</a></div>
</div>

<?php
    include_once ('./install.inc2.php');
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
?>

<div class="ins_inner">
    <h2><?php echo GB_VERSION ?> 설치가 시작되었습니다.</h2>

    <ol>
<?php
$sql = " desc {$table_prefix}config";
$result = @sql_query($sql, false, $dblink);

// 굿빌더가 설치되어 있지 않다면
// 테이블 생성 ------------------------------------
if($g5_install || !$result) {
    $file = implode('', file('./sql_builder.sql'));
    eval("\$file = \"$file\";");

    $file = preg_replace('/^--.*$/m', '', $file);
    $file = preg_replace('|^/\*.*$|m', '', $file);
    $file = preg_replace('/`g5_([^`]+`)/', '`'.$table_prefix.'$1', $file);
    $f = explode(';', $file);
    for ($i=0; $i<count($f); $i++) {
        if (trim($f[$i]) == '') continue;
	///echo $f[$i].'<br>';
        sql_query($f[$i], true, $dblink);
    }
}

// 쇼핑몰 테이블 생성 -----------------------------
if($g5_shop_install) {
    $file = implode('', file('./sql_builder_shop.sql'));
    eval("\$file = \"$file\";");

    $file = preg_replace('/^--.*$/m', '', $file);
    $file = preg_replace('|^/\*.*$|m', '', $file);
    $file = preg_replace('/`g5_([^`]+`)/', '`'.$table_prefix.'$1', $file);
    $f = explode(';', $file);
    for ($i=0; $i<count($f); $i++) {
        if (trim($f[$i]) == '') continue;
	///echo $f[$i].'<br>';
        sql_query($f[$i], true, $dblink);
    }

    $file = implode('', file('./sql_buildershop.sql'));
    eval("\$file = \"$file\";");

    $file = preg_replace('/^--.*$/m', '', $file);
    $file = preg_replace('|^/\*.*$|m', '', $file);
    $file = preg_replace('/`g5_shop_([^`]+`)/', '`'.$g5_shop_prefix.'$1', $file);
    $f = explode(';', $file);
    for ($i=0; $i<count($f); $i++) {
        if (trim($f[$i]) == '') continue;
	///echo $f[$i].'<br>';
        sql_query($f[$i], true, $dblink);
    }
}

// 컨텐츠몰 테이블 생성 -----------------------------
if($g5_contents_install) {
    $file = implode('', file('./sql_builder_contents.sql'));
    eval("\$file = \"$file\";");

    $file = preg_replace('/^--.*$/m', '', $file);
    $file = preg_replace('|^/\*.*$|m', '', $file);
    $file = preg_replace('/`g5_([^`]+`)/', '`'.$table_prefix.'$1', $file);
    $f = explode(';', $file);
    for ($i=0; $i<count($f); $i++) {
        if (trim($f[$i]) == '') continue;
	///echo $f[$i].'<br>';
        sql_query($f[$i], true, $dblink);
    }

    $file = implode('', file('./sql_buildercontents.sql'));

    $file = preg_replace('/^--.*$/m', '', $file);
    $file = preg_replace('|^/\*.*$|m', '', $file);
    $file = preg_replace('/`g5_contents_([^`]+`)/', '`'.$g5_contents_prefix.'$1', $file);
    $f = explode(';', $file);
    for ($i=0; $i<count($f); $i++) {
        if (trim($f[$i]) == '') continue;
	///echo $f[$i].'<br>';
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
                set cf_title = '사이트 이름',
                    cf_admin = '$admin_id',
                    cf_admin_email = '$admin_email',
                    cf_admin_email_name = '사이트 이름',
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
                    cf_email_use = '0',
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
                    cf_member_img_size = '50000',
                    cf_member_img_width = '60',
                    cf_member_img_height = '60',
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
    $sql .= ",
                    cf_social_login_use = 1,
                    cf_social_servicelist = 'naver,kakao,facebook,google,twitter,payco',
                    cf_1_subj = '사이트 이름',
                    cf_2_subj = '사이트 주소',
                    cf_3_subj = '저작권 명시',
                    cf_4_subj = 'Keywords',
                    cf_5_subj = 'Description',
                    cf_6_subj = '대표자',
                    cf_7_subj = '사업자 등록 번호',
                    cf_8_subj = '대표 전화',
                    cf_9_subj = '팩스',
                    cf_10_subj = '이메일',
                    cf_1 = '사이트 이름',
                    cf_2 = '사이트 주소',
                    cf_3 = 'Copyright (c) 2010',
                    cf_4 = '사이트 키워드들',
                    cf_5 = '사이트에 대한 설명',
                    cf_6 = '대표자',
                    cf_7 = '사업자 등록 번호',
                    cf_8 = '대표 전화',
                    cf_9 = '팩스',
                    cf_10 = '이메일'
                    ";

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

    // 1:1문의 설정
    $sql = " insert into `{$table_prefix}qa_config`
                ( qa_title, qa_category, qa_skin, qa_mobile_skin, qa_use_email, qa_req_email, qa_use_hp, qa_req_hp, qa_use_editor, qa_subject_len, qa_mobile_subject_len, qa_page_rows, qa_mobile_page_rows, qa_image_width, qa_upload_size, qa_insert_content )
              values
                ( '1:1문의', '회원|포인트', 'basic', 'basic', '1', '0', '1', '0', '1', '60', '30', '15', '15', '600', '1048576', '' ) ";
    sql_query($sql, true, $dblink);

    // FAQ Master
    sql_query(" insert into `{$table_prefix}faq_master` set fm_id = '1', fm_subject = '자주하시는 질문' ", true, $dblink);
}

if($g5_shop_install) {

    // 이미지 사이즈
    $simg_width = 230;
    $simg_height = 230;
    $mimg_width = 320;
    $mimg_height = 320;

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
                    de_shop_skin = 'good_basic_simple',
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
                    de_type3_list_mod = '3',
                    de_type3_list_row = '2',
                    de_type3_img_width = '$simg_width',
                    de_type3_img_height = '$simg_height',
                    de_type4_list_use = '1',
                    de_type4_list_skin = 'main.10.skin.php',
                    de_type4_list_mod = '3',
                    de_type4_list_row = '2',
                    de_type4_img_width = '$simg_width',
                    de_type4_img_height = '$simg_height',
                    de_type5_list_use = '1',
                    de_type5_list_skin = 'main.10.skin.php',
                    de_type5_list_mod = '3',
                    de_type5_list_row = '2',
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

    /// 샘플 상품 데이타
    $sql = " INSERT INTO `{$g5_shop_prefix}item` VALUES ('1414083905','10','','','','','테스트1','테스트','테스트','테스트','테스트','','',1,1,1,1,1,'테스트','테스트','테스트','테스트',20000,1,0,0,0,0,'',1,0,0,10000,0,0,0,0,0,0,0,0,0,'','','','',5,'2014-10-24 02:08:23','2016-05-07 18:09:44','127.0.0.1',0,0,'wear','a:8:{s:8:\"material\";s:22:\"상품페이지 참고\";s:5:\"color\";s:22:\"상품페이지 참고\";s:4:\"size\";s:22:\"상품페이지 참고\";s:5:\"maker\";s:22:\"상품페이지 참고\";s:7:\"caution\";s:22:\"상품페이지 참고\";s:16:\"manufacturing_ym\";s:22:\"상품페이지 참고\";s:8:\"warranty\";s:22:\"상품페이지 참고\";s:2:\"as\";s:22:\"상품페이지 참고\";}',0,0,'0.0','','','1414083905/floral199099__340.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),('1414261854','10','','','','','테스트2','테스트','테스트','테스트','테스트','','',1,1,1,1,1,'테스트','테스트','테스트','테스트',20000,10000,0,0,0,0,'',1,0,0,10000,0,0,0,0,0,0,0,0,0,'','','','',14,'2014-10-26 03:32:31','2016-05-07 18:32:54','127.0.0.1',0,0,'wear','a:8:{s:8:\"material\";s:22:\"상품페이지 참고\";s:5:\"color\";s:22:\"상품페이지 참고\";s:4:\"size\";s:22:\"상품페이지 참고\";s:5:\"maker\";s:22:\"상품페이지 참고\";s:7:\"caution\";s:22:\"상품페이지 참고\";s:16:\"manufacturing_ym\";s:22:\"상품페이지 참고\";s:8:\"warranty\";s:22:\"상품페이지 참고\";s:2:\"as\";s:22:\"상품페이지 참고\";}',0,0,'0.0','','','1414261854/gooseberry176450__340.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),('1414261954','10','','','','','테스트3','테스트','테스트','테스트','테스트','','',1,1,1,1,1,'테스트','테스트','테스트','테스트',20000,10000,0,0,0,0,'',1,0,0,10000,0,0,0,0,0,0,0,0,0,'','','','',20,'2014-10-26 03:34:06','2016-05-07 18:30:02','127.0.0.1',0,0,'wear','a:8:{s:8:\"material\";s:22:\"상품페이지 참고\";s:5:\"color\";s:22:\"상품페이지 참고\";s:4:\"size\";s:22:\"상품페이지 참고\";s:5:\"maker\";s:22:\"상품페이지 참고\";s:7:\"caution\";s:22:\"상품페이지 참고\";s:16:\"manufacturing_ym\";s:22:\"상품페이지 참고\";s:8:\"warranty\";s:22:\"상품페이지 참고\";s:2:\"as\";s:22:\"상품페이지 참고\";}',0,0,'0.0','','','1414261954/thyme167468__340.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','','') ";
    sql_query($sql, true, $dblink);
}

if($g5_contents_install) {
    // 이미지 사이즈
    $simg_width = 250;
    $simg_height = 250;
    $mimg_width = 345;
    $mimg_height = 345;

    // default 설정 (컨텐츠몰 설정)
    $sql = " insert into `{$g5_contents_prefix}default`
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
                    de_contents_skin = 'basic',
                    de_contents_mobile_skin = 'basic',
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
                    de_type3_list_mod = '3',
                    de_type3_list_row = '2',
                    de_type3_img_width = '$simg_width',
                    de_type3_img_height = '$simg_height',
                    de_type4_list_use = '1',
                    de_type4_list_skin = 'main.10.skin.php',
                    de_type4_list_mod = '3',
                    de_type4_list_row = '2',
                    de_type4_img_width = '$simg_width',
                    de_type4_img_height = '$simg_height',
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
                    de_movie_skin = 'movie.10.skin.php',
                    de_bank_use = '1',
                    de_bank_account = 'OO은행 12345-67-89012 예금주명',
                    de_vbank_use = '0',
                    de_iche_use = '0',
                    de_card_use = '0',
                    de_cash_use = '0',
                    de_cash_charge_use = '0',
                    de_cash_charge_price = '10000:11000|20000:22000|30000:33000|50000:55000',
                    de_settle_min_point = '5000',
                    de_settle_max_point = '50000',
                    de_settle_point_unit = '100',
                    de_cart_keep_term = '15',
                    de_card_point = '0',
                    de_point_days = '7',
                    de_pg_service = 'kcp',
                    de_kcp_mid = '',
                    de_rel_list_use = '1',
                    de_rel_list_skin = 'relation.10.skin.php',
                    de_rel_list_mod = '3',
                    de_rel_img_width = '230',
                    de_rel_img_height = '230',
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
                    de_simg_width = '$simg_width',
                    de_simg_height = '$simg_height',
                    de_mimg_width = '$mimg_width',
                    de_mimg_height = '$mimg_height',
                    de_item_use_use = '1',
                    de_code_dup_use = '1',
                    de_sms_cont1 = '{이름}님의 회원가입을 축하드립니다.\nID:{회원아이디}\n{회사명}',
                    de_sms_cont2 = '{이름}님 주문해주셔서 고맙습니다.\n{주문번호}\n{주문금액}원\n{회사명}',
                    de_sms_cont3 = '{이름}님께서 주문하셨습니다.\n{주문번호}\n{주문금액}원\n{회사명}',
                    de_sms_cont4 = '{이름}님 입금 감사합니다.\n{입금액}원\n주문번호:\n{주문번호}\n{회사명}'
                    ";
    sql_query($sql, true, $dblink);
    // 게시판 그룹 생성
    sql_query(" insert into `{$table_prefix}group` set gr_id = 'contents', gr_subject = '컨텐츠몰' ", true, $dblink);

    // 내용관리 생성
    sql_query(" insert into `{$table_prefix}content` set co_id = 'license', co_html = '1', co_subject = '라이센스 정책', co_content= '<p align=center><b>라이센스 정책에 대한 내용을 입력하십시오.</b></p>' ", true, $dblink);
    sql_query(" insert into `{$table_prefix}content` set co_id = 'guide', co_html = '1', co_subject = '이용안내', co_content= '<p align=center><b>이용안내에 대한 내용을 입력하십시오.</b></p>' ", true, $dblink);

    /// 샘플 상품 데이타
    $sql = " INSERT INTO `{$g5_contents_prefix}item` VALUES ('1451141280','10','','','','','테스트1',0,1,1,1,1,'테스트','','','','','','','','','','','','','테스트','테스트','',10000,0,0,'',1,0,'','','','','','','',5,'2015-12-26 23:53:57','2018-01-23 01:28:03','127.0.0.1',0,0,1,1,0,'0.0','1451141280/gooseberry176450__340.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),('1460561522','10','','','','','테스트2',0,1,1,1,1,'테스트','','','','','','','','','','','','','테스트','테스트','<p>테스트&nbsp;</p>',10000,0,0,'',1,0,'','','','','','','',1,'2016-04-14 00:34:32','2018-01-23 01:27:39','127.0.0.1',0,0,0,0,0,'0.0','1460561522/anemones293153__340.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),('1460561677','10','','','','','테스트3',0,1,1,1,1,'테스트','','','','','','','','','','','','','<p>테스트&nbsp;</p>','테스트&nbsp;','<p>테스트&nbsp;</p>',10000,0,0,'',1,0,'','','','','','','',3,'2016-04-14 00:36:49','2018-01-23 01:27:00','127.0.0.1',0,0,0,0,0,'0.0','1460561677/alpineedelwei181720__340.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','','') ";
    sql_query($sql, true, $dblink);

    $sql = " INSERT INTO `{$g5_contents_prefix}item_option` VALUES (1,'우먼','1451141280','e569a489654450cb55d6a5b57ac1e3db','','de19a9feb5d0112ef871ec932c5a8bdd','gooseberry-176450__340.jpg',42536,0,1,1,1),(2,'테스트','1460561522','58756983ae9a4e063ce6e1528cb8d3ba','','310f3935d89aff611979cad2b2678d42','anemones-293153__340.jpg',49420,0,1,1,1),(3,'테스트','1460561677','1328c85b5b5dfb7bccc5019a994ab9e8','','cf2b7d69541dbc8f2d262b803d2acdd0','alpine-edelwei-181720__340.jpg',42830,0,1,1,1) ";
    sql_query($sql, true, $dblink);
}
?>
<?php
$row = sql_fetch(" select count(*) as cnt from `{$table_prefix}config2w_def` ", true, $dblink);
if($row['cnt'])
    $sql = " update `{$table_prefix}config2w_def` set lang='$lang' ";
else
    $sql = " insert into `{$table_prefix}config2w_def` set lang='$lang' ";
sql_query($sql, true, $dblink);
?>

        <li>DB설정 완료</li>

<?php
//-------------------------------------------------------------------------------------------------

// 디렉토리 생성
$dir_arr = array (
    $data_path.'/cache',
    $data_path.'/editor',
    $data_path.'/file',
    $data_path.'/geditor',
    $data_path.'/log',
    $data_path.'/member',
    $data_path.'/member_image',
    $data_path.'/session',
    $data_path.'/content',
    $data_path.'/faq',
    $data_path.'/tmp'
);

for ($i=0; $i<count($dir_arr); $i++) {
    @mkdir($dir_arr[$i], G5_DIR_PERMISSION);
    @chmod($dir_arr[$i], G5_DIR_PERMISSION);
}

if(file_exists('./data/file')) {
    rcopy('./data/file', '../data/file');
}
?>
        <li>데이터 디렉토리 생성 완료</li>
<?php

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

    if(file_exists('./data/item')) {
        rcopy('./data/item', '../data/item');
    }

    ?>
        <li>쇼핑몰 데이터 디렉토리 생성 완료</li>
    <?php
}

if($g5_contents_install) {
    $dir_arr = array (
        $data_path.'/cmbanner',
        $data_path.'/common',
        $data_path.'/cmevent',
        $data_path.'/cmitem',
        $data_path.'/contents'
    );

    for ($i=0; $i<count($dir_arr); $i++) {
        @mkdir($dir_arr[$i], G5_DIR_PERMISSION);
        @chmod($dir_arr[$i], G5_DIR_PERMISSION);
    }

    if(file_exists('./data/cmitem')) {
        rcopy('./data/cmitem', '../data/cmitem');
    }

    if(file_exists('./data/contents')) {
        rcopy('./data/contents', '../data/contents');
    }

    ?>
        <li>컨텐츠몰 데이터 디렉토리 생성 완료</li>
    <?php
}
?>
<?php
//-------------------------------------------------------------------------------------------------

// DB 설정 파일 생성
$file = '../'.G5_DATA_DIR.'/'.G5_DBCONFIG_FILE;
$f = @fopen($file, 'w');

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
fwrite($f, "\$g5['social_profile_table'] = G5_TABLE_PREFIX.'member_social_profiles'; // 소셜 로그인 테이블\n");
fwrite($f, "\n");
fwrite($f, "if(file_exists(G5_DATA_PATH.'/shop.dbconfig.php')) include_once G5_DATA_PATH.'/shop.dbconfig.php';\n");
fwrite($f, "if(file_exists(G5_DATA_PATH.'/contents.dbconfig.php')) include_once G5_DATA_PATH.'/contents.dbconfig.php';\n");
fwrite($f, "?>");

fclose($f);
@chmod($file, G5_FILE_PERMISSION);
?>
        <li>DB설정 파일 생성 완료 (<?php echo $file ?>)</li>
<?php
$file = '../extend/config.extend.php';
$f = @fopen($file, 'w');

fwrite($f, "<?php\n");
fwrite($f, "if (!defined('_GNUBOARD_')) exit;\n");
fwrite($f, "\n");
fwrite($f, "define('G5_USE_TMPL_SKIN', true);\n");
fwrite($f, "?>");

fclose($f);
@chmod($file, G5_FILE_PERMISSION);
?>
        <li>확장 설정 파일 생성 완료 (<?php echo $file ?>)</li>
<?php
$file = '../extend/config.ml.extend.php';
$f = @fopen($file, 'w');

fwrite($f, "<?php\n");
fwrite($f, "if (!defined('_GNUBOARD_')) exit;\n");
fwrite($f, "\n");
fwrite($f, "define('G5_USE_MULTI_LANG', true);\n");
fwrite($f, "define('G5_USE_MULTI_LANG_SINGLE', false);\n");
fwrite($f, "define('G5_USE_MULTI_LANG_DB', false);\n");
fwrite($f, "?>");

fclose($f);
@chmod($file, G5_FILE_PERMISSION);
?>
        <li>확장 설정 파일 생성 완료 (<?php echo $file ?>)</li>
<?php
if($g5_shop_install) {
    $file = '../data/shop.dbconfig.php';
    if(file_exists($file)) unlink($file);

    // 쇼핑몰 DB 설정 파일 생성
    $f = @fopen($file, 'w');

    fwrite($f, "<?php\n");
    fwrite($f, "if (!defined('_GNUBOARD_')) exit;\n");
    fwrite($f, "\n");
    fwrite($f, "define('G5_USE_SHOP', true);\n\n");
    fwrite($f, "define('G5_SHOP_TABLE_PREFIX', '{$g5_shop_prefix}');\n");
    fwrite($f, "\n");
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
    fwrite($f, "?>");

    fclose($f);
    @chmod($file, G5_FILE_PERMISSION);
    ?>
        <li>쇼핑몰 DB설정 파일 생성 완료 (<?php echo $file ?>)</li>
    <?php
}

if($g5_contents_install) {
    $file = '../data/contents.dbconfig.php';
    if(file_exists($file)) unlink($file);

    // 컨텐츠몰 DB 설정 파일 생성
    $f = @fopen($file, 'w');

    fwrite($f, "<?php\n");
    fwrite($f, "if (!defined('_GNUBOARD_')) exit;\n");
    fwrite($f, "\n");
    fwrite($f, "define('G5_USE_CONTENTS', true);\n\n");
    fwrite($f, "define('G5_CONTENTS_TABLE_PREFIX', '{$g5_contents_prefix}');\n\n");
    fwrite($f, "\$g5['g5_contents_default_table'] = G5_CONTENTS_TABLE_PREFIX.'default'; // 컨텐츠몰설정 테이블\n");
    fwrite($f, "\$g5['g5_contents_banner_table'] = G5_CONTENTS_TABLE_PREFIX.'banner'; // 배너 테이블\n");
    fwrite($f, "\$g5['g5_contents_cart_table'] = G5_CONTENTS_TABLE_PREFIX.'cart'; // 장바구니 테이블\n");
    fwrite($f, "\$g5['g5_contents_category_table'] = G5_CONTENTS_TABLE_PREFIX.'category'; // 상품분류 테이블\n");
    fwrite($f, "\$g5['g5_contents_event_table'] = G5_CONTENTS_TABLE_PREFIX.'event'; // 이벤트 테이블\n");
    fwrite($f, "\$g5['g5_contents_event_item_table'] = G5_CONTENTS_TABLE_PREFIX.'event_item'; // 상품, 이벤트 연결 테이블\n");
    fwrite($f, "\$g5['g5_contents_item_table'] = G5_CONTENTS_TABLE_PREFIX.'item'; // 상품 테이블\n");
    fwrite($f, "\$g5['g5_contents_item_option_table'] = G5_CONTENTS_TABLE_PREFIX.'item_option'; // 상품옵션 테이블\n");
    fwrite($f, "\$g5['g5_contents_item_use_table'] = G5_CONTENTS_TABLE_PREFIX.'item_use'; // 상품 사용후기 테이블\n");
    fwrite($f, "\$g5['g5_contents_item_qa_table'] = G5_CONTENTS_TABLE_PREFIX.'item_qa'; // 상품 질문답변 테이블\n");
    fwrite($f, "\$g5['g5_contents_item_relation_table'] = G5_CONTENTS_TABLE_PREFIX.'item_relation'; // 관련 상품 테이블\n");
    fwrite($f, "\$g5['g5_contents_order_table'] = G5_CONTENTS_TABLE_PREFIX.'order'; // 주문서 테이블\n");
    fwrite($f, "\$g5['g5_contents_order_delete_table'] = G5_CONTENTS_TABLE_PREFIX.'order_delete'; // 주문서 삭제 테이블\n");
    fwrite($f, "\$g5['g5_contents_wish_table'] = G5_CONTENTS_TABLE_PREFIX.'wish'; // 보관함(위시리스트) 테이블\n");
    fwrite($f, "\$g5['g5_contents_coupon_table'] = G5_CONTENTS_TABLE_PREFIX.'coupon'; // 쿠폰정보 테이블\n");
    fwrite($f, "\$g5['g5_contents_coupon_log_table'] = G5_CONTENTS_TABLE_PREFIX.'coupon_log'; // 쿠폰사용정보 테이블\n");
    fwrite($f, "\$g5['g5_contents_cash_table'] = G5_CONTENTS_TABLE_PREFIX.'cash'; // 캐시 충전 테이블\n");
    fwrite($f, "\$g5['g5_contents_cash_history_table'] = G5_CONTENTS_TABLE_PREFIX.'cash_history'; // 캐시 충전, 사용 내역 테이블\n");
    fwrite($f, "\$g5['g5_contents_order_data_table'] = G5_CONTENTS_TABLE_PREFIX.'order_data'; // 모바일 결제정보 임시저장 테이블\n");
    fwrite($f, "\$g5['g5_contents_inicis_log_table'] = G5_CONTENTS_TABLE_PREFIX.'inicis_log'; // 이니시스 모바일 계좌이체 로그 테이블\n");

    fwrite($f, "?>");

    fclose($f);
    @chmod($file, G5_FILE_PERMISSION);
    ?>
        <li>컨텐츠몰 DB설정 파일 생성 완료 (<?php echo $file ?>)</li>
    <?php
}
?>

<?php
// data 디렉토리 및 하위 디렉토리에서는 .htaccess .htpasswd .php .phtml .html .htm .inc .cgi .pl 파일을 실행할수 없게함.
$f = fopen($data_path.'/.htaccess', 'w');
$str = <<<EOD
<FilesMatch "\.(htaccess|htpasswd|[Pp][Hh][Pp]|[Pp][Hh][Tt]|[Pp]?[Hh][Tt][Mm][Ll]?|[Ii][Nn][Cc]|[Cc][Gg][Ii]|[Pp][Ll])">
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

if($g5_contents_install) {
    @copy('./cm_logo_img', $data_path.'/common/cm_logo_img');
    @copy('./cm_logo_img', $data_path.'/common/cm_logo_img2');
    @copy('./cm_mobile_logo_img', $data_path.'/common/cm_mobile_logo_img');
    @copy('./cm_mobile_logo_img', $data_path.'/common/cm_mobile_logo_img2');
}
//-------------------------------------------------------------------------------------------------
?>
    </ol>

    <p>축하합니다. <?php echo GB_VERSION ?> 설치가 완료되었습니다.</p>

</div>

<div class="ins_inner">

    <h2>환경설정 변경은 다음의 과정을 따르십시오.</h2>

    <ol>
        <li>메인화면으로 이동</li>
        <li>관리자 로그인</li>
        <li>관리자 모드 접속</li>
        <li>환경설정 메뉴의 기본환경설정 페이지로 이동</li>
    </ol>

    <div class="inner_btn">
        <a href="../">굿빌더로 이동</a>
    </div>

</div>

<?php
include_once ('./install.inc2.php');
?>
