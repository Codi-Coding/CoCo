<?php // 굿빌더 ?>
<?php
if (!defined('_GNUBOARD_')) exit;

// 검색
function outsearch($skin_dir="good_basic")
{
    global $config, $member, $g5, $config2; /// config2 2012.09.08

    ///$outsearch_skin_path = G5_SKIN_PATH."/outsearch/$skin_dir";
    ///$outsearch_skin_url = G5_SKIN_URL."/outsearch/$skin_dir";

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        $outsearch_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/outsearch/'.$match[1];
        $outsearch_skin_url = str_replace(G5_PATH, G5_URL, $outsearch_skin_path);
        $skin_dir = $match[1];
    } else {
        $outsearch_skin_path = G5_SKIN_PATH.'/outsearch/'.$skin_dir;
        $outsearch_skin_url  = G5_SKIN_URL.'/outsearch/'.$skin_dir;
    }

    ob_start();
    include_once ("$outsearch_skin_path/outsearch.skin.php");
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
