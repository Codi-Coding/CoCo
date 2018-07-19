<?php // 굿빌더 ?>
<?php
if (!defined('_GNUBOARD_')) exit;

// 최근 게시물수 출력
function outnew($skin_dir="basic")
{
    global $config, $g5;

    ///$outnew_skin_path = "$g5[path]/skin/outnew/$skin_dir";
    ///$outnew_skin_url = "$g5[url]/skin/outnew/$skin_dir";

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        $outnew_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/outnew/'.$match[1];
        $outnew_skin_url = str_replace(G5_PATH, G5_URL, $outnew_skin_path);
        $skin_dir = $match[1];
    } else {
        $outnew_skin_path = G5_SKIN_PATH.'/outnew/'.$skin_dir;
        $outnew_skin_url  = G5_SKIN_URL.'/outnew/'.$skin_dir;
    }

    ob_start();
    include_once ("$outnew_skin_path/outnew.skin.php");
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
