<?php
include_once('./_common.php');

if (!$opage['op_id']) {
   alert('존재하지 않는 외부페이지입니다.', G5_URL);
}

if ($member['mb_level'] < $opage['read_level']) {
    if ($is_member)
        alert('외부페이지를 볼수있는 권한이 없습니다.', G5_URL);
    else
        alert('외부페이지를 볼수있는 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', './login.php?wr_id='.$wr_id.$qstr.'&amp;op_id='.urlencode(G5_BBS_URL.'/opage.php?op_id='.$op_id));
}


if (G5_IS_MOBILE) {
    if ($opage['mobile_subject']) {
        $g5['title'] = $opage['mobile_subject'];
    } else {
        $g5['title'] = '모바일 외부 페이지';
    }
} else {
    if ($opage['subject']) {
        $g5['title'] = $opage['subject'];
    } else {
        $g5['title'] = '외부 페이지';
    }
}


@include ($opage['include_head']);

$cache_fwrite = false;
if(G5_USE_CACHE) {
    $cache_css_file = G5_DATA_PATH."/cache/opage/css/".md5($opage['op_id']).".ko.compiled.css";
    $cache_js_file  = G5_DATA_PATH."/cache/opage/js/".md5($opage['op_id']).".ko.compiled.js";
    $cache_php_file = G5_DATA_PATH."/cache/opage/html/".md5($opage['op_id']).".ko.compiled.php";

    if(!file_exists($cache_file)) {
        $cache_fwrite = true;
    } else {
        if($opage['cache_time'] > 0) {
            $filetime = filemtime($cache_file);
            if($filetime && $filetime < (G5_SERVER_TIME - 3600 * $opage['cache_time'])) {
                @unlink($cache_css_file);
                @unlink($cache_js_file);
                @unlink($cache_php_file);
                $cache_fwrite = true;
            }
        }
    }
}

if(!G5_USE_CACHE || $cache_fwrite) {
    if($cache_fwrite) {
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
        fwrite($php_handle, "<?php\nif (!defined('_GNUBOARD_')) exit;\n?>\n".$cache_php_content);
        fclose($php_handle);
    }
}

// HTML 편집 후 캐시파일 리헤쉬 시킴
if($rehash == 'Y') {
    goto_url(G5_BBS_URL.'/opage.php?op_id='.$opage['op_id']);
}

// 외부페이지 정보 인클루드
if(G5_USE_CACHE && !$w) {
    $cache_css_file = G5_DATA_PATH."/cache/opage/css/".md5($opage['op_id']).".ko.compiled.css";
    $cache_js_file  = G5_DATA_PATH."/cache/opage/js/".md5($opage['op_id']).".ko.compiled.js";
    $cache_css_url = G5_DATA_URL."/cache/opage/css/".md5($opage['op_id']).".ko.compiled.css";
    $cache_js_url  = G5_DATA_URL."/cache/opage/js/".md5($opage['op_id']).".ko.compiled.js";
    add_stylesheet('<link rel="stylesheet" href="'.$cache_css_url.'?'.filemtime($cache_css_file).'">', 0);
    add_javascript('<script src="'.$cache_js_url.'?'.filemtime($cache_js_file).'"></script>', 0);
    include_once(G5_DATA_PATH."/cache/opage/html/".md5($opage['op_id']).".ko.compiled.php");
}

if ($w == 'u') {
    add_stylesheet('<link rel="stylesheet" href="'.G5_PLUGIN_URL.'/codemirror/lib/codemirror.css">', 0);
    add_javascript('<script src="'.G5_PLUGIN_URL.'/codemirror/lib/codemirror.js"></script>', 0);
    add_javascript('<script src="'.G5_PLUGIN_URL.'/codemirror/mode/xml/xml.js"></script>', 0);
    add_javascript('<script src="'.G5_PLUGIN_URL.'/codemirror/mode/javascript/javascript.js"></script>', 0);
    add_javascript('<script src="'.G5_PLUGIN_URL.'/codemirror/mode/css/css.js"></script>', 0);
    add_javascript('<script src="'.G5_PLUGIN_URL.'/codemirror/mode/htmlmixed/htmlmixed.js"></script>', 0);
    echo '<style>.title_bar,.CodeMirror,footer_bar{font-size:14px;line-height1.42857143;color:#333;background-color:#fff}.title_bar,.footer_bar{background:#f5f5f5;color:#777;font-weight:bold;padding:10px;border:1px solid #ddd;font-family:"Roboto",sans-serif}.title_bar:before,.footer_bar:before,.title_bar:after,.footer_bar:after{display:table;content:" "}.title_bar:after,.footer_bar:after{clear:both}.title_header{text-align:center;font-size:1.05em}</style>'.PHP_EOL;
    echo '<form name="fwritebox" method="post" action="'.G5_BBS_URL.'/opage_update.php" onsubmit="return fwritebox_submit(this);">'.PHP_EOL;
    echo '<input type="hidden" name="w" value="u">'.PHP_EOL;
    echo '<input type="hidden" name="op_id" value="'.$opage['op_id'].'">'.PHP_EOL;
    echo '<div class="title_bar" id="css_div"><div class="title_header">CSS 편집</div></div>'.PHP_EOL;
    echo '<textarea name="css_editor" id="css_editor">'.$opage['css_editor'].'</textarea>'.PHP_EOL;
    echo '<div class="title_bar" id="js_div"><div class="title_header">JS 편집</div></div>'.PHP_EOL;
    echo '<textarea name="js_editor" id="js_editor">'.$opage['js_editor'].'</textarea>'.PHP_EOL;
    echo '<div class="title_bar" id="html_div"><div class="title_header">HTML 편집</div></div>'.PHP_EOL;
    echo '<textarea name="html_editor" id="html_editor">'.$opage['html_editor'].'</textarea>'.PHP_EOL;
    echo '<div class="footer_bar"><input type="submit" style="float:right;" class="btn_submit" value="내용 저장"><a href="'.G5_BBS_URL.'/opage.php?op_id='.$opage['op_id'].'" style="float:right;margin-right:10px;" class="btn01">돌아가기</a></div>'.PHP_EOL;
    echo '</form>'.PHP_EOL;
    echo '<script>'.PHP_EOL;
    echo 'var editor = CodeMirror.fromTextArea(document.getElementById("css_editor"), {'.PHP_EOL;
    echo '    lineNumbers: true,'.PHP_EOL;
    echo '    mode: "text/css",'.PHP_EOL;
    echo '    matchBrackets: true'.PHP_EOL;
    echo '});'.PHP_EOL;
    echo 'var editor = CodeMirror.fromTextArea(document.getElementById("js_editor"), {'.PHP_EOL;
    echo '    lineNumbers: true,'.PHP_EOL;
    echo '    mode: "text/javascript",'.PHP_EOL;
    echo '    matchBrackets: true'.PHP_EOL;
    echo '});'.PHP_EOL;
    echo 'var editor = CodeMirror.fromTextArea(document.getElementById("html_editor"), {'.PHP_EOL;
    echo '    lineNumbers: true,'.PHP_EOL;
    echo '    mode: "text/html",'.PHP_EOL;
    echo '    matchBrackets: true'.PHP_EOL;
    echo '});'.PHP_EOL;
    echo '</script>'.PHP_EOL;
}
if ($is_admin && !$w) {
    echo '<div style="clear:both;width:100%;padding:10px 0;">';
    echo '<a href="'.G5_BBS_URL.'/opage.php?w=u&op_id='.$opage['op_id'].'" style="float:right;" class="btn01">HTML 편집</a>';
    echo '<a href="'.G5_ADMIN_URL.'/opage_form.php?w=u&op_id='.$opage['op_id'].'" style="float:right;margin-right:10px;" class="btn_admin">외부페이지 설정</a>';
    echo '</div>';
}

@include ($opage['include_tail']);
?>