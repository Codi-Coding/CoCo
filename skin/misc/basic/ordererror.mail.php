<?php
//주문 오류 알림 메일
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 메일 제목
$subject = $config['cf_title'].' 주문 오류 알림 메일';

?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>주문 오류 알림 메일</title>
</head>

<body>

<?php if($error == 'order') { ?>
	<p>주문정보를 DB에 입력하는 중 오류가 발생했습니다.</p>
<?php } else if($error == 'status') { ?>
    <p>주문 상품의 상태를 변경하는 중 DB 오류가 발생했습니다.</p>
<?php } ?>

<?php if($tno) { ?>
	<p>PG사의 <?php echo $od_settle_case;?>는 자동 취소되었습니다.</p>
	<p>취소 내역은 PG사 상점관리자에서 확인할 수 있습니다.</p>
<?php } ?>

<p>오류내용</p>
<p><?php echo $sql;?></p>
<p><?php echo sql_error_info();?></p>
<p>error file : <?php echo $_SERVER['SCRIPT_NAME'];?></p>

</body>
</html>
