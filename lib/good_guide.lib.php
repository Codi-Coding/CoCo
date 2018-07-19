<?php // 굿빌더 ?>
<?php
if (!defined('_GNUBOARD_')) exit;

// 고객 센타 글 추출
function guide($skin_dir="basic", $bo_table, $wr_id)
{
    global $g5;

    ///$guide_skin_path = "$g5[path]/skin/guide/$skin_dir";
    ///$guide_skin_url = "$g5[url]/skin/guide/$skin_dir";

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        $guide_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/guide/'.$match[1];
        $guide_skin_url = str_replace(G5_PATH, G5_URL, $guide_skin_path);
        $skin_dir = $match[1];
    } else {
        $guide_skin_path = G5_SKIN_PATH.'/guide/'.$skin_dir;
        $guide_skin_url  = G5_SKIN_URL.'/guide/'.$skin_dir;
    }

    $board_guide = sql_fetch(" select * from {$g5['board_table']} where bo_table = '$bo_table' ");

    $view_guide = array();

    $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    $sql = " select * from $tmp_write_table where wr_id='$wr_id'";
    $view_guide = sql_fetch($sql);

    ob_start();
    include "$guide_skin_path/guide.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
} 
?>
