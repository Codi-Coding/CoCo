<?php
include_once('./_common.php');

if($g5['is_db_trans'] && file_exists($g5['locale_path'].'/include/ml/shop'.'/largeimage.ml.php')) { include_once $g5['locale_path'].'/include/ml/shop'.'/largeimage.ml.php'; return; }

if(defined('G5_USE_OLD_CODE') && G5_USE_OLD_CODE) { include_once G5_SHOP_PATH.'/largeimage_old.php'; return; }

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/largeimage.php');
    return;
}

$it_id = $_GET['it_id'];
$no = $_GET['no'];

$sql = " select it_id, it_name, it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10
            from {$g5['g5_shop_item_table']} where it_id='$it_id' ";
$row = sql_fetch_array(sql_query($sql));

if(!$row['it_id'])
    alert_close(_t('상품정보가 존재하지 않습니다.'));

$imagefile = G5_DATA_PATH.'/item/'.$row['it_img'.$no];
$imagefileurl = G5_DATA_URL.'/item/'.$row['it_img'.$no];
$size = getimagesize($imagefile);

$g5['title'] = _t($row['it_name'])." ($it_id)";
include_once(G5_PATH.'/head.sub.php');

$skin = G5_SHOP_SKIN_PATH.'/largeimage.skin.php';

if(is_file($skin))
    include_once($skin);
else
    echo '<p>'.str_replace(G5_PATH.'/', '', $skin)._t('파일이 존재하지 않습니다.').'</p>';

include_once(G5_PATH.'/tail.sub.php');
?>
