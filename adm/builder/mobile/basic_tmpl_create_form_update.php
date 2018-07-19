<?php // 굿빌더 ?>
<?php
$sub_menu = "350702";
include_once("./_common.php");

function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

function rcopy($src, $dst) {
    ///if (file_exists($dst)) delTree($dst);
    if (is_dir($src)) {
        @mkdir($dst);
        $files = scandir($src);
        foreach ($files as $file)
        if ($file != "." && $file != "..") rcopy("$src/$file", "$dst/$file");
    }
    else if (file_exists($src)) copy($src, $dst);
}

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if($src_cf_id == '') $src_cf_id = 'basic';

if(1) {

/// config2w_m_config
$sql = " select * from $g5[config2w_m_config_table] where cf_id='$cf_id' ";
$row = sql_fetch($sql);

if(!$row) {
$sql = " select * from $g5[config2w_m_config_table] where cf_id='$src_cf_id' ";
$row = sql_fetch($sql);
$sql = " insert into {$g5['config2w_m_config_table']}
    set 
        cf_id = '{$cf_id}',
        cf_mobile_new_skin = '{$row['cf_mobile_new_skin']}',
        cf_mobile_search_skin = '{$row['cf_mobile_search_skin']}',
        cf_mobile_connect_skin = '{$row['cf_mobile_connect_skin']}',
        cf_mobile_faq_skin = '{$row['cf_mobile_faq_skin']}',
        cf_mobile_qa_skin = '{$row['cf_mobile_qa_skin']}',
        cf_mobile_co_skin = '{$row['cf_mobile_co_skin']}',
        cf_mobile_member_skin = '{$row['cf_mobile_member_skin']}',
        cf_mobile_shop_skin = '{$row['cf_mobile_shop_skin']}',
        cf_mobile_contents_skin = '{$row['cf_mobile_contents_skin']}'
    ";
sql_query($sql);
}

/// config2w_m_board
$sql = " select * from $g5[config2w_m_board_table] where cf_id='$cf_id' ";
$row = sql_fetch($sql);

if(!$row) {
$sql = " insert into {$g5['config2w_m_board_table']} 
    select 
        '{$cf_id}', bo_table, bo_mobile_skin, bo_mobile_latest_skin 
    from {$g5['config2w_m_board_table']} 
    where
        cf_id='{$src_cf_id}' 
    ";
sql_query($sql);
}

} /// if 1

if(!$chk_no_copy_file or !file_exists("$g5[mobile_path]/$g5[mobile_tmpl_dir]/$cf_id")) {
    /// exec("cp -a $g5[mobile_path]/$g5[mobile_tmpl_dir]/$src_cf_id $g5[mobile_path]/$g5[mobile_tmpl_dir]/$cf_id 2>&1");
    rcopy("$g5[mobile_path]/$g5[mobile_tmpl_dir]/$src_cf_id", "$g5[mobile_path]/$g5[mobile_tmpl_dir]/$cf_id");
}

/// config2w_m
$sql = " select count(*) as cnt from $g5[config2w_m_table] where cf_id='$cf_id' ";
$row = sql_fetch($sql);
if($row['cnt'])
    alert("템플릿 데이타베이스 정보가 이미 존재합니다.");

/// sql_query(" lock tables $g5[config2w_m_table] ");

$sql = " create temporary table tmp select * from $g5[config2w_m_table] where cf_id='$src_cf_id' ";
/// echo $sql;
sql_query($sql);

$sql = " select max(id) as maxid from $g5[config2w_m_table] ";
$row = sql_fetch($sql);

if(isset($row['maxid'])) {
    $next_id = $row['maxid'] + 1; 
    $sql = " update tmp set id='$next_id', cf_id='$cf_id' ";
} else {
    $sql = " update tmp set cf_id='$cf_id' ";
}

sql_query($sql);

$sql = " insert into $g5[config2w_m_table] select * from tmp ";
sql_query($sql);

sql_query(" drop table tmp ");

/// sql_query(" OPTIMIZE TABLE `$g5[config2w_m_table]` ");

/// sql_query(" unlock tables ");

goto_url("./basic_tmpl_create_form.php");
?>
