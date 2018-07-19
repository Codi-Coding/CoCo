<?php
function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

function rcopy($src, $dst) {
    ///if (file_exists($dst)) delTree($dst);
    if (is_dir($src)) {
        @mkdir($dst);
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

$g5_path['path'] = "../../../..";
include_once ('../../../../config.php');
include_once ('../../../../data/dbconfig.php');
include_once ('../../../../lib/common.lib.php');
$title = "쇼핑몰 설치 완료 3/3";
include_once ('./install.inc.php');

//print_r($_POST); exit;

$mysql_host  = G5_MYSQL_HOST;
$mysql_user  = G5_MYSQL_USER;
$mysql_pass  = G5_MYSQL_PASSWORD;
$mysql_db    = G5_MYSQL_DB;

$table_prefix= $_POST['table_prefix'];
$g5_shop_install = 0;
$g5_shop_prefix = $_POST['g5_shop_prefix'];
if($g5_shop_prefix == '') $g5_shop_prefix = 'g5_shop_';
if (isset($_POST['g5_shop_install']))
    $g5_shop_install= $_POST['g5_shop_install'];

if(!$g5_shop_install) {
    echo '
<div class="ins_inner">
    <p>설치가 중단되었습니다.</p>
    <div class="inner_btn"><a href="../index.php">모듈 관리</a></div>
</div>
    ';
    exit;
}

$dblink = @sql_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
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

$select_db = @sql_select_db($mysql_db, $dblink);
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
    <h2>쇼핑몰 설치가 시작되었습니다.</h2>

    <ol>
<?php
// 쇼핑몰 테이블 생성 -----------------------------
if($g5_shop_install) {
    $file = implode('', file(G5_PATH.'/install/sql_builder_shop.sql'));
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

    $file = implode('', file(G5_PATH.'/install/sql_buildershop.sql'));
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
    ///exit;
}
// 테이블 생성 ------------------------------------
?>

        <li>전체 테이블 생성 완료</li>

<?php
// 쇼핑몰 설정

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
                    de_simg_width = '$simg_width',
                    de_simg_height = '$simg_height',
                    de_mimg_width = '$mimg_width',
                    de_mimg_height = '$mimg_height',
                    de_item_use_use = '1',
                    de_level_sell = '1',
                    de_code_dup_use = '1',
                    de_sms_cont1 = '{이름}님의 회원가입을 축하드립니다.\nID:{회원아이디}\n{회사명}',
                    de_sms_cont2 = '{이름}님 주문해주셔서 고맙습니다.\n{주문번호}\n{주문금액}원\n{회사명}',
                    de_sms_cont3 = '{이름}님께서 주문하셨습니다.\n{주문번호}\n{주문금액}원\n{회사명}',
                    de_sms_cont4 = '{이름}님 입금 감사합니다.\n{입금액}원\n주문번호:\n{주문번호}\n{회사명}',
                    de_sms_cont5 = '{이름}님 배송합니다.\n택배:{택배회사}\n운송장번호:\n{운송장번호}\n{회사명}'
                    ";

    sql_query($sql, true, $dblink);

    // 게시판 그룹 생성
    sql_query(" insert ignore into `{$table_prefix}group` set gr_id = 'shop', gr_subject = '쇼핑몰' ", true, $dblink);

    /// 샘플 상품 데이타
    $sql = " INSERT INTO `{$g5_shop_prefix}item` VALUES ('1414083905','10','','','','','테스트1','테스트','테스트','테스트','테스트','','',1,1,1,1,1,'테스트','테스트','테스트','테스트',20000,1,0,0,0,0,'',1,0,0,10000,0,0,0,0,0,0,0,0,0,'','','','',5,'2014-10-24 02:08:23','2016-05-07 18:09:44','127.0.0.1',0,0,'wear','a:8:{s:8:\"material\";s:22:\"상품페이지 참고\";s:5:\"color\";s:22:\"상품페이지 참고\";s:4:\"size\";s:22:\"상품페이지 참고\";s:5:\"maker\";s:22:\"상품페이지 참고\";s:7:\"caution\";s:22:\"상품페이지 참고\";s:16:\"manufacturing_ym\";s:22:\"상품페이지 참고\";s:8:\"warranty\";s:22:\"상품페이지 참고\";s:2:\"as\";s:22:\"상품페이지 참고\";}',0,0,'0.0','','','1414083905/floral199099__340.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),('1414261854','10','','','','','테스트2','테스트','테스트','테스트','테스트','','',1,1,1,1,1,'테스트','테스트','테스트','테스트',20000,10000,0,0,0,0,'',1,0,0,10000,0,0,0,0,0,0,0,0,0,'','','','',14,'2014-10-26 03:32:31','2016-05-07 18:32:54','127.0.0.1',0,0,'wear','a:8:{s:8:\"material\";s:22:\"상품페이지 참고\";s:5:\"color\";s:22:\"상품페이지 참고\";s:4:\"size\";s:22:\"상품페이지 참고\";s:5:\"maker\";s:22:\"상품페이지 참고\";s:7:\"caution\";s:22:\"상품페이지 참고\";s:16:\"manufacturing_ym\";s:22:\"상품페이지 참고\";s:8:\"warranty\";s:22:\"상품페이지 참고\";s:2:\"as\";s:22:\"상품페이지 참고\";}',0,0,'0.0','','','1414261854/gooseberry176450__340.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),('1414261954','10','','','','','테스트3','테스트','테스트','테스트','테스트','','',1,1,1,1,1,'테스트','테스트','테스트','테스트',20000,10000,0,0,0,0,'',1,0,0,10000,0,0,0,0,0,0,0,0,0,'','','','',20,'2014-10-26 03:34:06','2016-05-07 18:30:02','127.0.0.1',0,0,'wear','a:8:{s:8:\"material\";s:22:\"상품페이지 참고\";s:5:\"color\";s:22:\"상품페이지 참고\";s:4:\"size\";s:22:\"상품페이지 참고\";s:5:\"maker\";s:22:\"상품페이지 참고\";s:7:\"caution\";s:22:\"상품페이지 참고\";s:16:\"manufacturing_ym\";s:22:\"상품페이지 참고\";s:8:\"warranty\";s:22:\"상품페이지 참고\";s:2:\"as\";s:22:\"상품페이지 참고\";}',0,0,'0.0','','','1414261954/thyme167468__340.jpg','','','','','','','','','','','','','','','','','','','','','','','','','','','','','') ";

    sql_query($sql, true, $dblink);

}
?>

        <li>DB설정 완료</li>

<?php
//-------------------------------------------------------------------------------------------------

// 디렉토리 생성

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

    if(file_exists(G5_PATH.'/install/data/item')) {
        rcopy(G5_PATH.'/install/data/item', $data_path.'/item');
    }
}
?>

        <li>데이터 디렉토리 생성 완료</li>
<?php
//-------------------------------------------------------------------------------------------------

$file = '../../../../data/shop.dbconfig.php';
if(file_exists($file)) unlink($file);

if($g5_shop_install) {
    // 쇼핑몰 DB 설정 파일 생성
    $f = @fopen($file, 'w');

    fwrite($f, "<?php\n");
    fwrite($f, "if (!defined('_GNUBOARD_')) exit;\n");
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
    fwrite($f, "?>");
    fclose($f);
    @chmod($file, G5_FILE_PERMISSION);
?>

        <li>쇼핑몰 DB설정 파일 생성 완료 (<?php echo $file ?>)</li>
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
//-------------------------------------------------------------------------------------------------
?>
    </ol>

    <p>축하합니다. 쇼핑몰 설치가 완료되었습니다.</p>

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
        <a href="../index.php">모듈 관리로 이동</a>
    </div>

</div>

<?php
include_once ('./install.inc2.php');
?>
