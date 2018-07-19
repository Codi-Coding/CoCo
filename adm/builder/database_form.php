<?php // 굿빌더 ?>
<?php
$sub_menu = "350801";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "데이타베이스 업그레이드";
include_once ("../admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>

<section class="cbox">
<div style="float:right">데이타베이스: <?php echo G5_MYSQL_DB?></div>
<h2>업그레이드 검사</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td valign=top style="padding:10px 5px 5px 5px">
<?php
echo "<b>[템플릿 데이타 추가]</b><br><br>";
include_once("./database_tmpl.inc.php");
echo "<br><br>";

echo "<br><b>[DB 업그레이드 검사]</b><br><br>";

$check_count = 0;

/// 게시판 관련 (단순 추가)
if(!isset($config['cf_point_term'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_point_term` int(11) NOT NULL DEFAULT '0' AFTER `cf_use_point` ", true);
}

// config2w_m 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_m_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_m_table']." 생성<br>";
}

// config2w_def 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_def_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_def_table']." 생성<br>";
}

// config2w_m_def 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_m_def_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_m_def_table']." 생성<br>";
}

if(defined('G5_USE_SHOP') && G5_USE_SHOP) {

/// paypal
if(isset($default['de_currency_code']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."의 de_currency_code를 de_paypal_currency_code로 변경<br>";
}

if(isset($default['de_exchange_rate']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."의 de_exchange_rate를 de_paypal_exchange_rate로 변경<br>";
}

if(!isset($default['de_paypal_test']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_paypal_test를 추가<br>";
}

/// alipay
if(!isset($default['de_alipay_use']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_use를 추가<br>";
}

if(!isset($default['de_alipay_test']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_test를 추가<br>";
}

if(!isset($default['de_alipay_service_type']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_service_type을 추가<br>";
}

if(!isset($default['de_alipay_partner']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_partner를 추가<br>";
}

if(!isset($default['de_alipay_key']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_key를 추가<br>";
}

if(!isset($default['de_alipay_seller_id']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_seller_id를 추가<br>";
}

if(!isset($default['de_alipay_seller_email']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_seller_email을 추가<br>";
}

if(!isset($default['de_alipay_currency']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_currency를 추가<br>";
}

if(!isset($default['de_alipay_exchange_rate']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_alipay_exchange_rate를 추가<br>";
}

/// authorize.net
if(!isset($default['de_anet_use'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_use를 추가<br>";
}

if(!isset($default['de_anet_test'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_test를 추가<br>";
}

if(!isset($default['de_anet_id'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_id를 추가<br>";
}

if(!isset($default['de_anet_key'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_key를 추가<br>";
}

if(!isset($default['de_anet_test_mode'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_test_mode를 추가<br>";
}

if(!isset($default['de_anet_exchange_rate']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_anet_exchange_rate를 추가<br>";
}

/// order
$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_order_table']}` LIKE 'od_status_detail' ";
$row = sql_fetch($sql);

if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['g5_shop_order_table']."에 od_status_detail을 추가<br>";
}

/// order
$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_order_table']}` LIKE 'od_test' ";
$row = sql_fetch($sql);

if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['g5_shop_order_table']."에 od_test를 추가<br>";
}

/// cart
$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_cart_table']}` LIKE 'ct_status_detail' ";
$row = sql_fetch($sql);

if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['g5_shop_cart_table']."에 ct_status_detail을 추가<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_cart_table']}` LIKE 'ct_select_time' ";
$row = sql_fetch($sql);

if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['g5_shop_cart_table']."에 ct_select_time을 추가<br>";
}

// 상품메모 필드 추가
if(!sql_query(" select it_shop_memo from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    $check_count++;
    echo $g5['g5_shop_item_table']."에 it_shop_memo를 추가<br>";
}

// 현금영수증 필드 추가
if(!sql_query(" select pp_cash from {$g5['g5_shop_personalpay_table']} limit 1 ", false)) {
    $check_count++;
    echo $g5['g5_shop_personalpay_table']."에 pp_cach를 추가 (이외 5 개 포함)<br>";
}

// cart 테이블 index 추가
if(!sql_fetch(" show keys from {$g5['g5_shop_cart_table']} where Key_name = 'it_id' ")) {
    $check_count++;
    echo $g5['g5_shop_cart_table']."에 it_id를 추가 (이외 1 개 포함)<br>";
}

// 모바일 이니시스 계좌이체 결과 전달을 위한 테이블 추가
if(!sql_query(" DESCRIBE {$g5['g5_shop_inicis_log_table']} ", false)) {
    $check_count++;
    echo $g5['g5_shop_inicis_log_table']." 생성<br>";
}

// 결제정보 임시저장 테이블 추가
if(isset($g5['g5_shop_order_data_table']) && !sql_query(" DESCRIBE {$g5['g5_shop_order_data_table']} ", false)) {
    $check_count++;
    echo $g5['g5_shop_order_data_table']." 생성<br>";
}

// inicis 필드 추가
if(!isset($default['de_inicis_mid'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_inicis_mid, de_inicis_admin_key 필드 추가<br>";
}

// 모바일 초기화면 이미지 줄 수 필드 추가
if(!isset($default['de_mobile_type1_list_row'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_mobile_type1_list_row를 추가 (이외 4 개 포함)<br>";
}

// 모바일 관련상품 이미지 줄 수 필드 추가
if(!isset($default['de_mobile_rel_list_mod'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_mobile_rel_list_mod를 추가<br>";
}

// 모바일 검색상품 이미지 줄 수 필드 추가
if(!isset($default['de_mobile_search_list_row'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_mobile_search_list_row를 추가<br>";
}

// 모바일 상품 출력줄수 필드 추가
if(!sql_query(" select ca_mobile_list_row from {$g5['g5_shop_category_table']} limit 1 ", false)) {
    $check_count++;
    echo $g5['g5_shop_category_table']."에 ca_mobile_list_row를 추가<br>";
}

// 접속기기 필드 추가
if(!sql_query(" select bn_device from {$g5['g5_shop_banner_table']} limit 0, 1 ")) {
    $check_count++;
    echo $g5['g5_shop_banner_table']."에 bn_device를 추가<br>";
}

if(isset($default['de_include_index']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에서 de_include_index를 삭제 (이외 4 개 포함)<br>";
}

if(!isset($default['de_easy_pay_use']))
{
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_easy_pay_use를 추가 (이외 5 개 포함)<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_event_table']}` LIKE 'ev_mobile_list_row' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['g5_shop_event_table']."에 `ev_mobile_list_row를 추가<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_inicis_log_table']}` LIKE 'P_AUTH_NO' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['g5_shop_inicis_log_table']."에 `P_AUTH_NO를 추가<br>";
}

// 네이버페이 필드추가
if(!isset($default['de_naverpay_mid'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 `de_naverpay_mid 외 5 개의 필드를 추가<br>";
}

// 지식쇼핑 PID 필드추가
if(!sql_query(" select ec_mall_pid from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    $check_count++;
    echo $g5['g5_shop_item_table']."에 `ec_mall_pid를 추가<br>";
}

// 쿠폰존 테이블 추가
if(isset($g5['g5_shop_coupon_zone_table'])) {
    if(!sql_query(" DESCRIBE {$g5['g5_shop_coupon_zone_table']} ", false)) {
        $check_count++;
        echo $g5['g5_shop_coupon_zone_table']." 생성<br>";
    }
}

// 유형별상품리스트 설정필드 추가
if(!isset($default['de_listtype_list_skin'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_listtype_list_skin 외 9 개 필드 추가<br>";
}

// 이니시스 삼성페이 사용여부 필드 추가
if(!isset($default['de_samsung_pay_use'])) {
    $check_count++;
    echo $g5['g5_shop_default_table']."에 de_easy_pay_use 필드 추가<br>";
}

} /// if G5_USE_SHOP

///if(defined('G5_USE_TMPL_SKIN') and G5_USE_TMPL_SKIN) {
if(1) {

// config2w_config 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_config_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_config_table']."생성<br>";
}

// config2w_board 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_board_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_board_table']."생성<br>";
}

// config2w_m_config 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_m_config_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_m_config_table']."생성<br>";
}

// config2w_m_board 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['config2w_m_board_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_m_board_table']."생성<br>";
}

} /// if G5_USE_TMPL_SKIN

if(!isset($config2w['cf_use_common_logo']))
{
    $check_count++;
    echo $g5['config2w_table']."에 cf_use_common_logo를 추가 (이외 2 개 포함)<br>";
}

if(!isset($config2w_m['cf_use_common_logo']))
{
    $check_count++;
    echo $g5['config2w_m_table']."에 cf_use_common_logo를 추가 (이외 2 개 포함)<br>";
}

/*
$sql = " SHOW COLUMNS FROM `{$g5['config2w_table']}` LIKE 'cf_site_name' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_table']."에 cf_site_name을 추가 (이외 9 개 포함)<br>";
}
*/

$sql = " SHOW COLUMNS FROM `{$g5['config2w_table']}` LIKE 'id' or LIKE 'cf_templete' ";
$row = sql_fetch($sql);
if(isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_table']."에 id 및 cf_templete을 삭제<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_m_table']}` LIKE 'id' or LIKE 'cf_templete' ";
$row = sql_fetch($sql);
if(isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_m_table']."에 id 및 cf_templete을 삭제<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_config_table']}` LIKE 'cf_co_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_config_table']."에 cf_co_skin을 추가<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_m_config_table']}` LIKE 'cf_mobile_co_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_m_config_table']."에 cf_mobile_co_skin을 추가<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_def_table']}` LIKE 'lang' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_def_table']."에 lang, lang_list 추가<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_m_def_table']}` LIKE 'cf_mobile_templete' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_m_def_table']."에 cf_mobile_templete 추가<br>";
}

if(!isset($config['cf_theme']))
{
    $check_count++;
    echo $g5['config_table']."에 cf_theme을 추가 (이외 1 개 포함)<br>";
}

if(isset($config['cf_include_index']))
{
    $check_count++;
    echo $g5['config_table']."에서 cf_include_index를 삭제 (이외 2 개 포함)<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_config_table']}` LIKE 'cf_contents_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_config_table']."에 cf_contents_skin을 추가<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['config2w_m_config_table']}` LIKE 'cf_mobile_contents_skin' ";
$row = sql_fetch($sql);
if(!isset($row['Field']))
{
    $check_count++;
    echo $g5['config2w_m_config_table']."에 cf_mobile_contents_skin을 추가<br>";
}

if(!isset($config2w['cf_menu'])) {
    $check_count++;
    echo $g5['config2w_table']."에 cf_menu를 추가<br>";
}

if(isset($config2w_m['cf_menu'])) {
    $check_count++;
    echo $g5['config2w_m_table']."의 cf_menu를 cf_menu_style로 변경<br>";
}

if(!sql_query(" DESC {$g5['config2w_menu_table']} ", false)) {
    $check_count++;
    echo $g5['config2w_menu_table']." 생성<br>";
    echo "(".$g5['config2w_table']."에서 메뉴 필드들 삭제)"."<br>";
}

if(!isset($config2w_def['cf_header_logo'])) {
    $check_count++;
    echo $g5['config2w_def_table']."에 cf_header_logo외 14 개 필드 추가<br>";
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_explan' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $check_count++;
    echo $g5['board_table']."에 bo_explan 필드 추가<br>";
}

if (!isset($config2w_def['cf_contact_info'])) {
    $check_count++;
    echo $g5['config2w_def_table']."에 cf_contact_info외 4 개 필드 추가<br>";
}

if($check_count == 0) {
    echo "업그레이드할 내용이 없습니다.";
} else {
    echo "<br><b>".$check_count." 항목의 업그레이드가 필요합니다.</b>";
    echo "<br><br><div class='btn_confirm01 btn_confirm'><a href='./database_form_update.php' class='btn_submit' style='display:inline-block;line-height:2.2'>데이타베이스 업그레이드</a></div>";
}

?>
    </td>
</tr>
</table>
</section>

<?php
include_once ("../admin.tail.php");
?>
