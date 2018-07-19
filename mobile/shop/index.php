<?php
include_once('./_common.php');

///define("_INDEX_", TRUE);

if(file_exists(G5_THEME_MSHOP_PATH.'/index.php')) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
} else {
    include_once(G5_MSHOP_PATH.'/shop.head.php'); ///goodbuilder. 헤드 별도.
    include_once(G5_MSHOP_SKIN_PATH.'/index.skin.php'); ///goodbuilder. 스킨 형태로, 본문 내용만.
    include_once(G5_MSHOP_PATH.'/shop.tail.php'); ///goodbuilder. 테일 별도
}
?>
