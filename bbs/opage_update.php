<?php
include_once('./_common.php');

if (!$is_admin)
    alert('접근권한이 없습니다.', G5_URL);

sql_query(" update {$g5['opage_table']} set css_editor = '$css_editor', js_editor = '$js_editor', html_editor = '$html_editor' where op_id = '$op_id' ");

if(G5_USE_CACHE) {
    $cache_css_file = G5_DATA_PATH."/cache/opage/css/".md5($opage['op_id']).".ko.compiled.css";
    $cache_js_file  = G5_DATA_PATH."/cache/opage/js/".md5($opage['op_id']).".ko.compiled.js";
    $cache_php_file = G5_DATA_PATH."/cache/opage/html/".md5($opage['op_id']).".ko.compiled.php";

    @unlink($cache_css_file);
    @unlink($cache_js_file);
    @unlink($cache_php_file);

    $css_handle = fopen($cache_css_file, 'w');
    $cache_css_content = $opage['css_editor'];
    fwrite($css_handle, $cache_css_content);
    fclose($css_handle);
    $js_handle = fopen($cache_js_file , 'w');
    $cache_js_content = $opage['js_editor'];
    fwrite($js_handle, $cache_js_content);
    fclose($js_handle);
    $php_handle = fopen($cache_php_file, 'w');
    $cache_php_content = $opage['html_editor'];
    fwrite($php_handle, $cache_php_content);
    fclose($php_handle);
}

goto_url(G5_BBS_URL.'/opage.php?op_id='.$_POST['op_id'].'&amp;rehash=Y');
?>