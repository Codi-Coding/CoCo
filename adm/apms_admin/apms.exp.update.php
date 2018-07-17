<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

include_once(G5_PATH.'/head.sub.php');

//한 번에 1000개씩 처리
$rows = 1000;

//회원 페이지 계산
$total = sql_fetch("select count(*) as cnt from {$g5['member_table']} where mb_email_certify <> '' and mb_leave_date = '' and mb_intercept_date = '' ", false);
$total_count = $total['cnt'];
$total_page  = ceil($total_count / $rows);

if(!$page) $page = 1;

if($act == 'ok') {

	check_admin_token();

	//자료가 많을 경우 대비 설정변경
	@ini_set('memory_limit', '-1');

	if($page <= $total_page) {

		$start_rows = ($page - 1) * $rows; 

		$result = sql_query("select mb_id from {$g5['member_table']} where mb_email_certify <> '' and mb_leave_date = '' and mb_intercept_date = '' limit $start_rows, $rows ", false);
		while($row=sql_fetch_array($result)) {
			$info = check_xp($row['mb_id']); // 경험치 레벨 업데이트
			if($info['change']) {
				change_xp($row['mb_id'], $info['level']); // 변경된 레벨 반영
			}
			$start_rows++;
		}

		sql_free_result($result);

		$per = round(($page / $total_page) * 100);
?>
	<br><br>
	<div class="tbl_frm01 tbl_wrap font-16" style="font-family:tahoma; text-align:center;">
		<table>
		<tbody>
		<tr class="bg-black">
			<td>구분</td>
			<td>회원수</td>
			<td>작업수</td>
			<td>진행율</td>
		</tr>
		<tr>
			<td>전체</td>
			<td><?php echo number_format($total_count);?></td>
			<td><?php echo number_format($total_page);?></td>
			<td rowspan="2"><b class="red font-24"><?php echo $per;?>%</b></td>
		</tr>
		<tr>
			<td><b>작업</b></td>
			<td><b class="blue"><?php echo number_format($start_rows);?></b></td>
			<td><b class="deepblue"><?php echo number_format($page);?></b></td>
		</tr>
		</tbody>
		</table>
	</div>
<?php
		//20페이지마다 1초씩 쉬기
		//if($page > 1 && ($page - 1)%20 == 0) {
		//	sleep(1);
		//}

		//페이지 증가
		$page++;

		goto_url('./apms.exp.update.php?act=ok&amp;page='.$page.'&amp;token='.get_admin_token());
	}

?>	
	<script type='text/javascript'> 
		alert('회원레벨 업데이트를 완료했습니다.'); 
		self.close();
	</script>
<?php } else { ?>
	<script src="<?php echo G5_ADMIN_URL ?>/admin.js"></script>
	<form id="defaultform" name="defaultform" method="post" onsubmit="return update_submit(this);">
	<input type="hidden" name="act" value="ok">
	<div style="padding:10px">
		<div style="border:1px solid #ddd; background:#f5f5f5; color:#000; padding:10px; line-height:20px;">
			<b><i class="fa fa-bolt"></i> 회원 레벨(경험치) 업데이트</b>
		</div>
		<div style="border:1px solid #ddd; border-top:0px; padding:10px;line-height:22px;">
			<ul>
				<li><b class="red">[주의] 반드시 DB 백업을 먼저 하신 이후 실행해 주시기 바랍니다.</b></li>
				<li>이메일 미인증 회원과 탈퇴 및 차단회원은 작업시 제외됩니다.</li>
				<li>경험치룰 변경 후 실행시 회원레벨이 변경된 경험치룰로 재산정됩니다.</li>
				<li>수정된 회원레벨은 회원정보와 전체 게시물에 자동으로 반영됩니다.</li>
				<li>
					총 <b><?php echo number_format($total_page);?></b> 작업(<?php echo number_format($total_count);?>명) 중 
					<input type="text" name="page" value="<?php echo $page;?>" size="6" class="frm_input"> 번째 작업부터 실행합니다.
				</li>
			</ul>
		</div>
		<br>
		<div class="btn_confirm01 btn_confirm">
			<input type="submit" value="실행하기" class="btn_submit" accesskey="s">
		</div>
	</div>
	</form>
	<script>
		function update_submit(f) {
			if(!confirm("실행후 완료메시지가 나올 때까지 기다려 주세요.\n\n정말 실행하시겠습니까?")) {
				return false;	
			} 

			return true;
		}
	</script>
<?php } ?>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>