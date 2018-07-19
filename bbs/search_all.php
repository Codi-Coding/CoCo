<?php // 굿빌더 ?>
<?php
include_once('./_common.php');

if($sfl) {
    include_once G5_BBS_PATH."/search.php";
} else if($qname) {
    include_once G5_SHOP_PATH."/search.php";
} else if($bbs_search) {
    $sfl = "wr_subject||wr_content";
    $sop = "and";
    $stx = $q_string;
    include_once G5_BBS_PATH."/search.php";
} else {
    $_GET['q'] = $q_string;
    include_once G5_SHOP_PATH."/search.php";
}
?>
