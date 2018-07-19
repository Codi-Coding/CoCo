<?php
if (!defined('_GNUBOARD_')) exit;

function sql_affected_rows($link=null)
{
    global $g5;

    if(!$link)
        $link = $g5['connect_db'];

    if(function_exists('mysqli_affected_rows') && G5_MYSQLI_USE)
        return mysqli_affected_rows($link);
    else
        return mysql_affected_rows($link);
}

$check_count = 0;
$add_count = 0;

/// 버젼 6.0.5 부터 DB 변경 여부 확인
$sql1 = " SHOW COLUMNS FROM `{$g5['config2w_table']}` LIKE 'id' ";
$row1 = sql_fetch($sql1);
$sql2 = " SHOW COLUMNS FROM `{$g5['config2w_table']}` LIKE 'cf_templete' ";
$row2 = sql_fetch($sql2);
if(isset($row1['Field']) or isset($row2['Field'])) return;

if(sql_query(" DESC {$g5['config2w_table']} ", false)) {
    echo "(템플릿 관련 테이블에 추가된 템플릿에 대한 데이타 추가)<br>";

    $file = implode('', file('./database_tmpl.sql'));
    eval("\$file = \"$file\";");
    $file = preg_replace('/^--.*$/m', '', $file);
    $file = preg_replace('|^/\*.*$|m', '', $file);
    $file = preg_replace('/`g5_([^`]+`)/', '`'.G5_TABLE_PREFIX.'$1', $file);
    $f = explode(';', $file);
    $num_add = 0;
    for ($i=0; $i<count($f); $i++) {
        if (trim($f[$i]) == '') continue;
        $check_count++;
	///echo $f[$i].'<br>';
        $res = sql_query($f[$i]);
        if($res and sql_affected_rows() > 0) $add_count++;
    }
}

if($add_count == 0) {
    echo "<br>추가된 내용이 없습니다.";
} else {
    echo "<br><b>".$check_count." 항목 중 ".$add_count." 항목이 추가되었습니다.</b>";
}
?>
