<?php // 굿빌더 ?>
<?php
if (!defined('_GNUBOARD_')) exit; 

/// 함수 정의 시작 
// 최신글 추출 - 선택한 그룹별로 원하는 수만큼 보여줌 
function latest_group($skin_dir="", $gr_id, $rows=10, $subject_len=40, $cols=1, $category="", $orderby="") 
{ 
    global $config; 
    global $g5; 

    /// group name & is_admin
    global $is_admin; 
    $sql0group = " select gr_subject from $g5[group_table] where gr_id = '$gr_id' "; 
    $rs0group = sql_query($sql0group); 
    $row0group=sql_fetch_array($rs0group); 
    $gr_subject = $row0group['gr_subject'];

    $list = array(); 
    $limitrows = $rows; 

    $sqlgroup = " select bo_table, bo_subject from $g5[board_table] where gr_id = '$gr_id' and bo_use_search=1 and (bo_10 = '' or bo_10 = '{$g5['tmpl']}') order by bo_order_search"; 
    $rsgroup = sql_query($sqlgroup); 

    if (!$skin_dir) $skin_dir = $config['cf_latest_skin'];

    ///$latest_skin_path = "$g5[path]/skin/latest/$skin_dir"; 
    ///$latest_skin_url = "$g5[url]/skin/latest/$skin_dir"; 

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
        $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        $skin_dir = $match[1];
    } else {
        $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
        $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
    }

    for ($j=0, $k=0; $rowgroup=sql_fetch_array($rsgroup); $j++) { 
        $bo_table = $rowgroup[bo_table]; 

        // 테이블 이름구함 
        $sql = " select * from {$g5[board_table]} where bo_table = '$bo_table'"; 
        $board = sql_fetch($sql); 

        $tmp_write_table = $g5[write_prefix] . $bo_table; // 게시판 테이블 실제이름 

        // 옵션에 따라 정렬 
        $sql = "select * from $tmp_write_table where wr_is_comment = 0 "; 
        $sql .= (!$category) ? "" : " and ca_name = '$category' "; 
        $sql .= (!$orderby) ? "  order by wr_id desc " : "  order by $orderby desc, wr_id desc "; 
        $sql .= " limit $limitrows"; 

        $result = sql_query($sql); 

        for ($i=0; $row = sql_fetch_array($result); $i++, $k++) { 

            if(!$orderby) {
                $op_list[$k] = $row[wr_datetime];
            } else { 
                $op_list[$k] = is_string($row[$orderby]) ? sprintf("%-256s", $row[$orderby]) : sprintf("%016d", $row[$orderby]); 
                $op_list[$k] .= $row[wr_datetime]; 
            }
 
            $list[$k] = get_list($row, $board, $latest_skin_url, $subject_len); 

            $list[$k][bo_table] = $board[bo_table]; 
            $list[$k][bo_subject] = $board[bo_subject]; 

            $list[$k][bo_wr_subject] = cut_str($board[bo_subject] . $list[$k][wr_subject], $subject_len); 
        } 
    } 

    if($k>0) array_multisort($op_list, SORT_DESC, $list); 
    if($k>$rows) array_splice($list, $rows); 

    ob_start(); 
    include "$latest_skin_path/latest.skin.php"; 
    $content = ob_get_contents(); 
    ob_end_clean(); 

    return $content; 
} 
/// 함수 정의 끝 

// 게시판 그룹을 LIST 형식으로 얻음
// 현재 그룹과 일치하면 bold 로 표시
function get_group_list($cur_gr_id)
{
    global $g5, $is_admin, $member;

    $sql = " select gr_id, gr_subject from $g5[group_table] a ";
    if ($is_admin == "group") {
        $sql .= " left join $g5[member_table] b on (b.mb_id = a.gr_admin)
                  where b.mb_id = '$member[mb_id]' ";
    }
    $sql .= " order by a.gr_id ";

    $result = sql_query($sql);

    if($cur_gr_id == "")
        $str = "[<b>"._t("전체")."</b>]";
    else
        $str = "[<a href='$g5[bbs_path]/good_group.php?gr_id='>"._t("전체")."</a>]";

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $str .= " | ";
        $str .= "[";
        if($row[gr_id] == $cur_gr_id)
            $str .= "<b>".$row[gr_subject]."</b>";
        else 
            $str .= "<a href='$g5[bbs_path]/good_group.php?gr_id=$row[gr_id]'>$row[gr_subject]</a>";
        $str .= "]";
    }
    return $str;
}
/// 함수 정의 끝 
?>
