<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

define('G5_MOBILE_SKIN_PATH', G5_MOBILE_PATH .'/'.G5_SKIN_DIR);
define('G5_MOBILE_SKIN_URL',  G5_MOBILE_URL .'/'.G5_SKIN_DIR);

if(defined('G5_USE_TMPL_SKIN') and G5_USE_TMPL_SKIN) {

/// 템플릿 스킨 디렉터리 경로
define('G5_TMPL_SKIN_PATH',              G5_TMPL_PATH.'/'.G5_SKIN_DIR);
define('G5_TMPL_SKIN_URL',               G5_TMPL_URL.'/'.G5_SKIN_DIR);
define('G5_MOBILE_TMPL_SKIN_PATH',       G5_MOBILE_TMPL_PATH.'/'.G5_SKIN_DIR);
define('G5_MOBILE_TMPL_SKIN_URL',        G5_MOBILE_TMPL_URL.'/'.G5_SKIN_DIR);

$config2w_config = array();
$config2w_config = sql_fetch(" select * from $g5[config2w_config_table] where cf_id='$g5[tmpl]' ", false);

$config2w_board = array();
$config2w_board = sql_fetch(" select * from $g5[config2w_board_table] where cf_id='$g5[tmpl]' and bo_table='$bo_table' ", false);

$config2w_m_config = array();
$config2w_m_config = sql_fetch(" select * from $g5[config2w_m_config_table] where cf_id='$g5[mobile_tmpl]' ", false);

$config2w_m_board = array();
$config2w_m_board = sql_fetch(" select * from $g5[config2w_m_board_table] where cf_id='$g5[mobile_tmpl]' and bo_table='$bo_table' ", false);

if(!(defined('G5_IS_ADMIN') && G5_IS_ADMIN)) {

$board['bo_skin']          = $config2w_board['bo_skin'] ? $config2w_board['bo_skin'] : $board['bo_skin'];
$config['cf_member_skin']  = $config2w_config['cf_member_skin'] ? $config2w_config['cf_member_skin'] : $config['cf_member_skin'];
$config['cf_new_skin']     = $config2w_config['cf_new_skin'] ? $config2w_config['cf_new_skin'] : $config['cf_new_skin'];
$config['cf_search_skin']  = $config2w_config['cf_search_skin'] ? $config2w_config['cf_search_skin'] : $config['cf_search_skin'];
$config['cf_connect_skin'] = $config2w_config['cf_connect_skin'] ? $config2w_config['cf_connect_skin'] : $config['cf_connect_skin'];
$config['cf_faq_skin']     = $config2w_config['cf_faq_skin'] ? $config2w_config['cf_faq_skin'] : $config['cf_faq_skin'];
$config['cf_qa_skin']     = $config2w_config['cf_qa_skin'] ? $config2w_config['cf_qa_skin'] : $config['cf_qa_skin'];
$config['cf_co_skin'] = $config2w_config['cf_co_skin'] ? $config2w_config['cf_co_skin'] : $config['cf_co_skin'];

$board['bo_mobile_skin']          = $config2w_m_board['bo_mobile_skin'] ? $config2w_m_board['bo_mobile_skin'] : $board['bo_mobile_skin'];
$config['cf_mobile_member_skin']  = $config2w_m_config['cf_mobile_member_skin'] ? $config2w_m_config['cf_mobile_member_skin'] : $config['cf_mobile_member_skin'];
$config['cf_mobile_new_skin']     = $config2w_m_config['cf_mobile_new_skin'] ? $config2w_m_config['cf_mobile_new_skin'] : $config['cf_mobile_new_skin'];
$config['cf_mobile_search_skin']  = $config2w_m_config['cf_mobile_search_skin'] ? $config2w_m_config['cf_mobile_search_skin'] : $config['cf_mobile_search_skin'];
$config['cf_mobile_connect_skin'] = $config2w_m_config['cf_mobile_connect_skin'] ? $config2w_m_config['cf_mobile_connect_skin'] : $config['cf_mobile_connect_skin'];
$config['cf_mobile_faq_skin']     = $config2w_m_config['cf_mobile_faq_skin'] ? $config2w_m_config['cf_mobile_faq_skin'] : $config['cf_mobile_faq_skin'];
$config['cf_mobile_qa_skin']     = $config2w_m_config['cf_mobile_qa_skin'] ? $config2w_m_config['cf_mobile_qa_skin'] : $config['cf_mobile_qa_skin'];
$config['cf_mobile_co_skin']     = $config2w_m_config['cf_mobile_co_skin'] ? $config2w_m_config['cf_mobile_co_skin'] : $config['cf_mobile_co_skin'];

/*
if (G5_IS_MOBILE) {

    $board_skin_path    = G5_MOBILE_SKIN_PATH.'/board/'.$board['bo_mobile_skin'];
    $board_skin_url     = G5_MOBILE_SKIN_URL .'/board/'.$board['bo_mobile_skin'];
    $member_skin_path   = G5_MOBILE_SKIN_PATH.'/member/'.$config['cf_mobile_member_skin'];
    $member_skin_url    = G5_MOBILE_SKIN_URL .'/member/'.$config['cf_mobile_member_skin'];
    $new_skin_path      = G5_MOBILE_SKIN_PATH.'/new/'.$config['cf_mobile_new_skin'];
    $new_skin_url       = G5_MOBILE_SKIN_URL .'/new/'.$config['cf_mobile_new_skin'];
    $search_skin_path   = G5_MOBILE_SKIN_PATH.'/search/'.$config['cf_mobile_search_skin'];
    $search_skin_url    = G5_MOBILE_SKIN_URL .'/search/'.$config['cf_mobile_search_skin'];
    $connect_skin_path  = G5_MOBILE_SKIN_PATH.'/connect/'.$config['cf_mobile_connect_skin'];
    $connect_skin_url   = G5_MOBILE_SKIN_URL .'/connect/'.$config['cf_mobile_connect_skin'];
    $faq_skin_path      = G5_MOBILE_SKIN_PATH .'/faq/'.$config['cf_mobile_faq_skin'];
    $faq_skin_url       = G5_MOBILE_SKIN_URL .'/faq/'.$config['cf_mobile_faq_skin'];
    $qa_skin_path      = G5_MOBILE_SKIN_PATH .'/qa/'.$config['cf_mobile_qa_skin'];
    $qa_skin_url       = G5_MOBILE_SKIN_URL .'/qa/'.$config['cf_mobile_qa_skin'];
    $co_skin_path      = G5_MOBILE_SKIN_PATH .'/co/'.$config['cf_mobile_co_skin'];
    $co_skin_url       = G5_MOBILE_SKIN_URL .'/co/'.$config['cf_mobile_co_skin'];

} else {

    $board_skin_path    = G5_SKIN_PATH.'/board/'.$board['bo_skin'];
    $board_skin_url     = G5_SKIN_URL .'/board/'.$board['bo_skin'];
    $member_skin_path   = G5_SKIN_PATH.'/member/'.$config['cf_member_skin'];
    $member_skin_url    = G5_SKIN_URL .'/member/'.$config['cf_member_skin'];
    $new_skin_path      = G5_SKIN_PATH.'/new/'.$config['cf_new_skin'];
    $new_skin_url       = G5_SKIN_URL .'/new/'.$config['cf_new_skin'];
    $search_skin_path   = G5_SKIN_PATH.'/search/'.$config['cf_search_skin'];
    $search_skin_url    = G5_SKIN_URL .'/search/'.$config['cf_search_skin'];
    $connect_skin_path  = G5_SKIN_PATH.'/connect/'.$config['cf_connect_skin'];
    $connect_skin_url   = G5_SKIN_URL .'/connect/'.$config['cf_connect_skin'];
    $faq_skin_path      = G5_SKIN_PATH.'/faq/'.$config['cf_faq_skin'];
    $faq_skin_url       = G5_SKIN_URL.'/faq/'.$config['cf_faq_skin'];
    $qa_skin_path      = G5_SKIN_PATH.'/qa/'.$config['cf_qa_skin'];
    $qa_skin_url       = G5_SKIN_URL.'/qa/'.$config['cf_qa_skin'];
    $co_skin_path      = G5_SKIN_PATH.'/co/'.$config['cf_co_skin'];
    $co_skin_url       = G5_SKIN_URL.'/co/'.$config['cf_co_skin'];

}
*/

if (defined('G5_USE_SHOP') and G5_USE_SHOP) {
    $default['de_shop_skin']        = $config2w_config['cf_shop_skin'] ? $config2w_config['cf_shop_skin'] : $default['de_shop_skin'];
    $default['de_shop_mobile_skin'] = $config2w_m_config['cf_mobile_shop_skin'] ? $config2w_m_config['cf_mobile_shop_skin'] : $default['de_shop_mobile_skin'];

/*
    define('G5_SHOP_SKIN_PATH',  G5_SKIN_PATH.'/shop/'.$default['de_shop_skin']);
    define('G5_SHOP_SKIN_URL',   G5_SKINURL .'/shop/'.$default['de_shop_skin']);
    define('G5_MSHOP_SKIN_PATH', G5_MOBILE_SKIN_PATH.'/shop/'.$default['de_shop_mobile_skin']);
    define('G5_MSHOP_SKIN_URL',  G5_MOBILE_SKIN_URL .'/shop/'.$default['de_shop_mobile_skin']);
*/
}

if (defined('G5_USE_CONTENTS') and G5_USE_CONTENTS) {
    $setting['de_contents_skin']        = $config2w_config['cf_contents_skin'] ? $config2w_config['cf_contents_skin'] : $setting['de_contents_skin'];
    $setting['de_contents_mobile_skin'] = $config2w_m_config['cf_mobile_contents_skin'] ? $config2w_m_config['cf_mobile_contents_skin'] : $setting['de_contents_mobile_skin'];

}

} /// if(!(defined('G5_IS_ADMIN') && G5_IS_ADMIN))

} /// if G5_USE_TMPL_SKIN
?>
