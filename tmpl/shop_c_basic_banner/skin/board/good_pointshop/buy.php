<?php
$g5_path = "../../..";
include_once("$g5_path/common.php");

if (!$bo_table && !$wr_id)
    die("bo_table 혹은 wr_id 가 없습니다.");

include_once("$board_skin_path/buy.lib.php");
///include_once("$g5[path]/head.sub.php");

if (!$write)
    alert("bo_table 과 wr_id 를 확인하십시오.");

if (!$point)
    alert("point 를 입력해주세요.");

///판매자 정보 가져오기/// 
///$sql = " select * from $g5[member_table] 
///          where mb_id = '$wr_5' " ; 
///$result = sql_query($sql); 
///$row=sql_fetch_array($result);

//주문자 코드
$order_id = time();

/// 갯수 곱하기
if($wr_2) $point = $point * $wr_2;

if($wr_8 != "Open") alert("현재 판매하고 있지 않습니다.");

/// 포인트 부족 검사
if($mb_point < $point)  alert("포인트가 부족합니다.");

/// 데이타 매핑
$buyer_name  = $member['mb_name'];
$buyer_email = $member['mb_email'];
$buyer_hp    = $member['mb_hp'];
$buyer_tel   = $member['mb_tel'];
$buyer_addr1 = $member['mb_addr'];
$buyer_addr2 = "";
$buyer_ch    = "";
$buyer_name2   = $wr_11;
$buyer_email2  = $wr_12;
$buyer_hp2     = $wr_13;
$buyer_tel2    = $wr_14;
$buyer_addr1_2 = $wr_15;
$buyer_addr2_2 = "";
$buyer_opt1    = $wr_content; /// 추가

//회원데이타 업로드
$point_sql  = " order_id       = '$order_id',
    bo_table       = '$bo_table',
    wr_id          = '$wr_id',
    mb_id          = '$member[mb_id]',
    b_name         = '$buyer_name',
    order_time     = '$g5[time_ymdhis]',
    b_tel          = '$buyer_tel',
    b_hp           = '$buyer_hp',
    b_email        = '$buyer_email',
    b_addr1        = '$buyer_addr1',
    b_addr2        = '$buyer_addr2',
    b_ch           = '$buyer_ch',
    b_name2        = '$buyer_name2',
    b_tel2         = '$buyer_tel2',
    b_hp2          = '$buyer_hp2',
    b_email2       = '$buyer_email2',
    b_addr1_2      = '$buyer_addr1_2',
    b_addr2_2      = '$buyer_addr2_2',
    b_ch2          = '$buyer_ch2',
    b_opt1         = '$buyer_opt1' ";

$point_result = sql_query( " insert into $g5_point_table set $point_sql " );

//고객 주문정보가 정산적이라면, 고객의 포인트점수를 차감한다.
if($point_result){
    //고객의 포인트 점수를 차감한다.
    $board_point  = -$point;
    /// 주문번호 반영하여 포인트 처리되도록
    insert_point($member[mb_id], $board_point, " 포인트상품 $wr_id 구매", $bo_table, $wr_id, "구매: $order_id");
    alert(number_format($point)." 포인트로 구매하였습니다.");
} else {
    alert("포인트 테이블에 삽입되지 못했습니다.\\n\\n긍금하신사항은 관리자에게 문의 바랍니다.");
}

///point_buy($wr_id, $point);

?>

<!--
<script language=javascript>
alert("<?php echo number_format($point)?> 포인트로 구매하였습니다.");
</script>
-->
<?php
goto_url(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr);
///include_once("$g5[path]/tail.sub.php");
?>
