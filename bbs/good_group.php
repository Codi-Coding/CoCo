<?php // 굿빌더 ?>
<?php
// 상대 경로
$g5_path = "..";
include_once("$g5_path/common.php");
include_once("$g5[path]/lib/latest.lib.php");

if($gr_id)
    $g5[title] = "[" .$group[gr_subject] ."]" ." "._t("그룹 최신 글");
else
    $g5[title] = _t("전체 그룹 최신 글");
include_once("./_head.php");
?>

<!-- 메인화면 최신글 시작 -->
<table width="97%" cellpadding=0 cellspacing=0 align=center>
<tr><td align=right><?php echo get_group_list($gr_id)?>&nbsp;</td></tr>
<tr>
    <td valign=top>
    <?php
    //  최신글
    if($gr_id)
        $sql = " select bo_table, bo_subject from $g5[board_table] 
              where gr_id = '$gr_id' and bo_use_search=1  
                and bo_list_level <= '$member[mb_level]'
                and (bo_10 = '' or bo_10 = '{$g5['tmpl']}')
              order by bo_table ";
    else
        $sql = " select gr_id, bo_table, bo_subject from $g5[board_table]
              where bo_use_search=1 and bo_list_level <= '$member[mb_level]'
                 and (bo_10 = '' or bo_10 = '{$g5['tmpl']}')
              order by gr_id, bo_table ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
        // 스킨은 입력하지 않을 경우 관리자 > 환경설정의 최신글 스킨경로를 기본 스킨으로 합니다.

        // 사용방법
        // latest(스킨, 게시판아이디, 출력라인, 글자수);
        if(!isset($row_group))
            $row_group = get_group($row[gr_id]);
        else if($row[gr_id] != $row_group[gr_id])
            $row_group = get_group($row[gr_id]);

        if(!$gr_id) echo "&nbsp;[<a href='$g5[bbs_path]/good_group.php?gr_id=$row[gr_id]'>" .$row_group[gr_subject] ."</a>]";
        echo "<div class=sideBoxGrN>" .latest("good_basic", $row[bo_table], 5, 70) ."</div>"; /// good
        echo "<p></p>";
    }
    ?>
    </td>
</tr>
</table>
<!-- 메인화면 최신글 끝 -->

<?php
include_once("./_tail.php");
?>
