<?php
$g5_path = "../../..";
include_once("$g5_path/common.php");
include_once("$board_skin_path/buy.lib.php");

if (!$bo_table && !$wr_id)
    die("bo_table 혹은 wr_id 가 없습니다.");

if (!$write)
    alert_only("bo_table 과 wr_id 를 확인하십시오.");

$sql = " select wr_subject from $write_table where wr_id = '$wr_id' ";
$row = sql_fetch($sql);

$g5[title] = get_text($row[wr_subject])." 구매 내역";

include_once("$g5[path]/head.sub.php");

echo "<script language=\"javascript\" src=\"$g5[legacy_url]/js/sideview.js\"></script>\n";

$order_info = "구매 번호 내림차순 정렬";
$orderby = "order_id desc";

$row = sql_fetch(" select count(*) as cnt from $g5_point_table where wr_id = '$wr_id' ");
$total_count = $total = $row[cnt];

$rows = $config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
?>
<div style="height:50px; clear:both;">

    <div style="float:left; margin:20px 20px 0 10px;">
        <b style="color:#0000A0;">구매 내역</b>
        <span style="color:#888;">(<?php echo $order_info?>)</span>
    </div>

    <div style="float:right; margin:20px 10px 10px 0;">
    총 구매자수 : <?php echo number_format($total)?> 
    </div>
</div>

<table border=0 cellspacing=1 width=100% align=center>
<tr>
    <td colspan=5 height=2 bgcolor="#cccccc"></td>
</tr>
<tr bgcolor="#e7e7e7">
    <td align=center style="font-weight:bold;" width=50 height=30> 번호 </td>
    <td align=center style="font-weight:bold;" width=50> 회원 </td>
    <td align=center style="font-weight:bold;" width=100> 구매 일자 </td>
    <td align=center style="font-weight:bold;"> 구매자 정보 </td>
    <td align=center style="font-weight:bold;"> 수령자 정보 </td>
</tr>
<?php
if (!$total)
    echo "<tr><td colspan=5 height=50 align=center> 구매 내역이 없습니다. </td></tr>";


$qry = sql_query(" select * from $g5_point_table where wr_id = '$wr_id' order by $orderby limit $from_record, $rows");
//$num = sql_num_rows($qry);
$k = 0;
while ($row = sql_fetch_array($qry)) 
{
    $num = $total_count - ($page - 1) * $config[cf_page_rows] - $k;

    ///$bgcolor = "#FAB074"; 
    $bgcolor = "#ffffff";

    $k++;
?>
<tr bgcolor="<?php echo $bgcolor?>">
    <td align=center height=25> <?php echo $num?> </td>
    <td align=center>
    <?php
    echo $row[mb_id];
    $date = date("Y-m-d H:i:s", strtotime($row[order_time]));
    ?> 
    </td>
    <td align=center> <?php echo $date?> </td>
    <td align=left> <?php echo "$row[b_name] / $row[b_tel] / $row[b_hp] / $row[b_email] <br> $row[b_addr1] $row[b_addr2]"?> </td>
    <td align=left> <?php echo "$row[b_name2] / $row[b_tel2] / $row[b_hp2] / $row[b_email2] <br> $row[b_addr1_2] $row[b_addr2_2]"?> </td>
</tr>
<tr>
    <td colspan=5 height=1 bgcolor="#efefef"></td>
</tr>
<?php } ?>
<tr>
    <td colspan=5 height=2 bgcolor="#cccccc"></td>
</tr>
</table>

<?php
$qstr = "bo_table=$bo_table&wr_id=$wr_id";
?>
<br />
<div align=center><?php echo get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");?></div>

<div style="text-align:center; margin-top:30px;">
<input type=button value="닫     기" onclick="self.close()">
</div>

<div style="height:50px;">&nbsp;</div>

</div>

<?php
include_once("$g5[path]/tail.sub.php");
?>
