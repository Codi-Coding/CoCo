<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<link rel="stylesheet" href="<?php echo G5_URL?>/css/lang_button.css">
<script>
function change_lang(lang, url) {
    var f = document.change;
    f.action = '<?php echo G5_BBS_URL; ?>/change_lang.php?l='+lang+'&u='+url;
    f.submit();
}
function toggle() {
    var f = document.getElementById('flags');
    f.style.display = (f.style.display != 'none' ? 'none' : '' );
    f.style.visibility = (f.style.visibility != 'hidden' ? 'hidden' : '' );
}
</script>
<!--
<script>
    $(document).mouseup(function (e){
    var container = $("#flags");
    if(container.has(e.target).length === 0) {
        //container.hide();
        var f = document.getElementById('flags');
        f.style.display = 'none';
        f.style.visibility = 'hidden';
    }
});
</script>
-->

<div id="lang">
<?php
$url = urlencode($_SERVER["REQUEST_URI"]);

echo '<form name="change" id="change" method="post">'.PHP_EOL;
echo '<img id="image" src="'.G5_LOCALE_IMG_URL.'/flag/'.$g5['flag_list'][$g5['lang']].'.png" onclick="javascript:toggle();" alt="'._t($g5['lang_name_list'][$g5['lang']]).'" title="'._t($g5['lang_name_list'][$g5['lang']]).'" style="float:right; margin-right:0;margin-top:1px"> '.PHP_EOL; /// w3
echo '<span id="flags" style="float:right; margin-top:15px;margin-right:-16px; display:none; visibility:hidden;border:1px solid #aaa;padding:14px 14px 14px 14px;background:#fff;color:#333">'.PHP_EOL;
echo '<center style="margin-bottom:14px">';
echo '<a href="#" onclick="javascript:toggle();" style="padding:5px 16px;background:#ff00ff;color:#fff">'.'Close'.'</a>';
echo '</center>';
for($i=0; $i<count($g5['lang_list']); $i++) {
    ///if($g5['lang_list'][$i] != $g5['lang']) {
    if(1) {
        echo '<img src="'.G5_LOCALE_IMG_URL.'/flag/'.$g5['flag_list'][$g5['lang_list'][$i]].'.png" onclick="javascript:change_lang(\''.$g5['lang_list'][$i].'\', \''.$url.'\');" alt="'._t($g5['lang_name_list'][$g5['lang_list'][$i]]).'" title="'._t($g5['lang_name_list'][$g5['lang_list'][$i]]).'" style="cursor:pointer;margin-bottom:5px"> ';
        echo '<a href=# onclick="javascript:change_lang(\''.$g5['lang_list'][$i].'\', \''.$url.'\');" alt="'._t($g5['lang_name_list'][$g5['lang_list'][$i]]).'">';
        if($g5['lang_list'][$i] == $g5['lang']) echo '<font color="#ff00ff">';
        if($g5['lang'] != 'en_US') echo '<b>'._t($g5['lang_name_list'][$g5['lang_list'][$i]]).'</b>, ';
        echo $g5['lang_name_list_en'][$g5['lang_list'][$i]];
        if($g5['lang_list'][$i] == $g5['lang']) echo '</font>';
        echo '</a><br/> '.PHP_EOL;
    }
}
echo '<center style="margin-top:16px">';
echo '<a href="#" onclick="javascript:toggle();" style="padding:5px 16px;background:#ff00ff;color:#fff">'.'Close'.'</a>';
echo '</center>';
echo '</span>'.PHP_EOL;
echo '</form>'.PHP_EOL;
?>
</div>
