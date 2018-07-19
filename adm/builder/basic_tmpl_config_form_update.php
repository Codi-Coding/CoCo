<?php // 굿빌더 ?>
<?php
$sub_menu = "350601";
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

if(preg_match('/^shop_/', $cf_templete)) {
    if(!defined('G5_SHOP_PATH')) alert('G5_SHOP_PATH 정의되지 않음. 쇼핑몰 모듈 설치 후 이용 바랍니다.');
    if(!file_exists(G5_SHOP_PATH) and !sql_query(" DESC {$g5['g5_shop_default_table']} ", false))
        alert('쇼핑몰 모듈 설치 후 이용 바랍니다.');
    if(!(defined('G5_USE_SHOP') && G5_USE_SHOP))
        alert('모듈 관리에서 쇼핑몰 설치 또는 이용 설정 후 이용 바랍니다.');
}

/// 템플릿 정보가 없을 경우 자동 생성

if($src_cf_id == '') $src_cf_id = 'basic';
$cf_id = $cf_templete;

$sql = " select count(*) as cnt from $g5[config2w_table] where cf_id='$cf_id' ";
$row = sql_fetch($sql);

if(!$row['cnt']) {
    /// sql_query(" lock tables $g5[config2w_table] ");
    if(file_exists("$g5[path]/$g5[tmpl_dir]/$cf_id/local_setup.php")) {

        include "$g5[path]/$g5[tmpl_dir]/$cf_id/local_setup.php";

        /// config2w
        $sql = " insert into $g5[config2w_table] set ";
        foreach($config2w_local as $key => $val) {
            if($key == 'cf_id') continue;
            $sql .= "$key='{$val}', ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= ", cf_id='$cf_id' ";
        ///echo $sql;
        sql_query($sql);

        /// config2w_config
        $sql = " insert into $g5[config2w_config_table] set ";
        foreach($config2w_config_local as $key => $val) {
            if($key == 'cf_id') continue;
            $sql .= "$key='{$val}', ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= ", cf_id='$cf_id' ";
        ///echo $sql;
        sql_query($sql);

        /// config2w_board
         for($i = 0; $i < count($config2w_board_all_local); $i++) {
            $sql = " insert into $g5[config2w_board_table] set ";
            foreach($config2w_board_all_local[$i] as $key => $val) {
                if($key == 'cf_id') continue;
                $sql .= "$key='{$val}', ";
            }
            $sql = rtrim($sql, ', ');
            $sql .= ", cf_id='$cf_id' ";
            ///echo $sql.'<br/>';
            sql_query($sql);
        }

        /// config2w_menu
        for($i = 0; $i < count($config2w_menu_local); $i++) {
            $sql = " insert into $g5[config2w_menu_table] set ";
            foreach($config2w_menu_local[$i] as $key => $val) {
                if($key == 'cf_id') continue;
                $sql .= "$key='{$val}', ";
            }
            $sql = rtrim($sql, ', ');
            $sql .= ", cf_menu='$cf_id' ";
            ///echo $sql.'<br/>';
            sql_query($sql);
        }

        /// config2w_m_def
        $sql = " insert into $g5[config2w_m_def_table] set ";
        foreach($config2w_m_def_local as $key => $val) {
            if($key == 'cf_templete') continue;
            $sql .= "$key='{$val}', ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= ", cf_templete='$cf_id' ";
        ///echo $sql;
        sql_query($sql);
    } else { 

        /// config2w
        $sql = " create temporary table tmp select * from $g5[config2w_table] where cf_id='$src_cf_id' ";
        /// echo $sql;
        sql_query($sql);

        $sql = " select max(id) as maxid from $g5[config2w_table] ";
        $row = sql_fetch($sql);

        if(isset($row['maxid'])) {
            $next_id = $row['maxid'] + 1; 
            $sql = " update tmp set id='$next_id', cf_id='$cf_id' ";
        } else {
            $sql = " update tmp set cf_id='$cf_id' ";
        }

        sql_query($sql);

        $sql = " insert into $g5[config2w_table] select * from tmp ";
        sql_query($sql);

        sql_query(" drop table tmp ");

        /// config2w_config
        $sql = " select * from $g5[config2w_config_table] where cf_id='$src_cf_id' ";
        $row = sql_fetch($sql);
        $sql = " insert into {$g5['config2w_config_table']}
            set 
                cf_id = '{$cf_id}',
                cf_new_skin = '{$row['cf_new_skin']}',
                cf_search_skin = '{$row['cf_search_skin']}',
                cf_connect_skin = '{$row['cf_connect_skin']}',
                cf_faq_skin = '{$row['cf_faq_skin']}',
                cf_qa_skin = '{$row['cf_qa_skin']}',
                cf_co_skin = '{$row['cf_co_skin']}',
                cf_member_skin = '{$row['cf_member_skin']}',
                cf_shop_skin = '{$row['cf_shop_skin']}',
                cf_contents_skin = '{$row['cf_contents_skin']}'
            ";
        sql_query($sql);

        /// config2w_board
        $sql = " insert into {$g5['config2w_board_table']} 
            select 
                '{$cf_id}', bo_table, bo_skin, bo_latest_skin 
            from {$g5['config2w_board_table']} 
            where
                cf_id='{$src_cf_id}' 
        ";
        sql_query($sql);

        /// config2w_menu
        $sql = " create temporary table tmp select * from $g5[config2w_menu_table] where cf_menu='$src_cf_id' ";
        /// echo $sql;
        sql_query($sql);
        $sql = " update tmp set cf_menu='$cf_id' ";
        sql_query($sql);
        $sql = " insert into $g5[config2w_menu_table] select * from tmp ";
        sql_query($sql);

        /// config2w_m_def
        $sql = " select * from $g5[config2w_m_def_table] where cf_templete = '$src_cf_id' ";
        $row = sql_fetch($sql);
        $sql = " insert into {$g5['config2w_m_def_table']}
            set 
                cf_templete = '{$cf_id}',
                cf_mobile_templete = '{$row['cf_mobile_templete']}'
            ";
        sql_query($sql);

        sql_query(" drop table tmp ");
    }
    /// sql_query(" unlock tables ");
}

///update all cf_templete value. 2012.11.24
///$sql = " update $g5[config2w_table] set cf_templete = '$cf_templete' ";
/// config2w_def_table 로 교체.
$sql = " update $g5[config2w_def_table] set cf_templete = '$cf_templete' ";
/// echo $sql;
sql_query($sql);

/// sql_query(" OPTIMIZE TABLE `$g5[config2w_table]` ");

$cfile = "$g5[path]/extend/templete.extend.php";
$bfile = "$g5[path]/extend.bak/templete.extend.php";
$arr = file($cfile);
copy($cfile, $bfile); 

for ($i = 0; $i < count($arr); $i++) {
    /// echo "$arr[$i]<br>";
    if( preg_match("/g5\['tmpl'\] = /", $arr[$i]) and preg_match("/change here, if needed/", $arr[$i]))
        $arr[$i] = "\$g5['tmpl'] = \"" .$cf_templete ."\"; /// change here, if needed\n";
}

$cstring = implode($arr);
file_put_contents($cfile, $cstring);

goto_url("./basic_tmpl_config_form.php");
?>
