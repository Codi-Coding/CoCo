<?php
include_once('./_common.php');

@mkdir(G5_DATA_PATH."/cache/theme", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/cache/theme", G5_DIR_PERMISSION);
@mkdir(G5_DATA_PATH."/cache/theme/everyday", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/cache/theme/everyday", G5_DIR_PERMISSION);

$save_file = G5_DATA_PATH.'/cache/theme/everyday/maincategory.php';
$maincategory = array();
$setting = array();
$ca_ids = array();

if(is_file($save_file))
    include($save_file);

$count = count($_POST['ca_id']);

if(!empty($maincategory))
    $ca_ids = array_keys($maincategory);

for($i=0; $i<$count; $i++) {
    $ca_id = substr(trim($_POST['ca_id'][$i]), 0, 2);

    $sql = " select count(*) as cnt from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and length(ca_id) = '2' ";
    $row = sql_fetch($sql);

    if(!$row['cnt'])
        continue;

    if(array_key_exists($ca_id, $setting))
        continue;

    $tmp = $maincategory[$ca_id];

    // 삭제체크됐다면 파일 삭제
    if($_POST['bn_del'][$ca_id] && $tmp['file']) {
        @unlink($tmp['file']);
        $tmp['file'] = '';
    }

    $setting[$ca_id] = array('file' => $tmp['file'], 'link' => '');

    // 파일처리
    if($_FILES['ca_bn_'.$ca_id]['name']) {
        $file = $_FILES['ca_bn_'.$ca_id]['tmp_name'];
        $size = getimagesize($file);
        $ext  = array('1' => 'gif', '2' => 'jpg', '3' => 'png');

        // gif, jpg, png 파일만 업로드
        if($size[2] >= 1 && $size[2] <= 3) {
            $name = 'ca_bn_'.$ca_id.'.'.$ext[$size[2]];
            $dir  = dirname($save_file);
            upload_file($file, $name, $dir);

            $setting[$ca_id]['file'] = $dir.'/'.$name;
        }
    }

    $link = trim($_POST['ca_link'][$ca_id]);
    if($link)
        $setting[$ca_id]['link'] = str_replace(array("\'", '\"', "'", '"'), '', strip_tags($link));
}

// 카테고리가 삭제됐다면 파일 삭제
if(!empty($ca_ids) && !empty($setting)) {
    foreach($ca_ids as $ca_id) {
        if(!array_key_exists($ca_id, $setting))
            @unlink($maincategory[$ca_id]['file']);
    }
}

// 캐시파일로 저장
$cache_fwrite = true;
if($cache_fwrite) {
    $handle = fopen($save_file, 'w');
    $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;";
    $cache_content .= "\n\n\$maincategory=".var_export($setting, true).";";
    fwrite($handle, $cache_content);
    fclose($handle);
}

goto_url('./maincategory.php');
?>