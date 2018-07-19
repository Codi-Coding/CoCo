<?php // 굿빌더 ?>
<?php
$sub_menu = "350202";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

//$cf_width_main_total = $cf_width_main_left + $cf_width_main + $cf_width_main_right;
$sql = " update $g5[config2w_def_table] set
     cf_header_logo = 
     '$cf_header_logo', 
     cf_site_name = 
     '$cf_site_name',
     cf_site_addr = 
     '$cf_site_addr',
     cf_zip = 
     '$cf_zip',
     cf_tel = 
     '$cf_tel',
     cf_fax = 
     '$cf_fax',
     cf_email = 
     '$cf_email',
     cf_site_owner = 
     '$cf_site_owner',
     cf_biz_num = 
     '$cf_biz_num',
     cf_ebiz_num = 
     '$cf_ebiz_num',
     cf_info_man = 
     '$cf_info_man',
     cf_info_email = 
     '$cf_info_email',
     cf_copyright = 
     '$cf_copyright',
     cf_keywords = 
     '$cf_keywords',
     cf_description = 
     '$cf_description'
";
$sql .= ",
    cf_contact_info = 
    '$cf_contact_info',
    cf_google_map_pos = 
    '$cf_google_map_pos',
    cf_google_map_api_key = 
    '$cf_google_map_api_key',
    cf_google_captcha_api_key = 
    '$cf_google_captcha_api_key',
    cf_google_captcha_api_secret = 
    '$cf_google_captcha_api_secret'
"; /// 2017.06.23
//$sql .= " where cf_id='$g5[tmpl]' "; /// 2012.11.24

//echo $sql;
sql_query($sql);

/// sql_query(" OPTIMIZE TABLE `$g5[config2w_def_table]` ");

goto_url("./basic_config_form.php");
?>
