<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

// 경험치룰별 합계
function apms_exp_sum($mb_id, $type, $opt='') {
    global $g5;

	$po_rel_sql = ($opt) ? "po_rel_action = '{$type}'" : "po_rel_table = '{$type}'";

	$row = sql_fetch(" select SUM(po_point) as point from {$g5['point_table']} where mb_id = '$mb_id' and $po_rel_sql ", false);
	
	$point = $row['point'];

    return $point;
}

// 통합건 등록
function apms_exp_insert($mb_id, $point, $content='', $rel_table='', $rel_action=''){
	global $g5;

	if(!$point) return;

    // 포인트 건별 생성
    $po_expire_date = '9999-12-31';

	$po_expired = 0;
    if($point < 0) {
        $po_expired = 1;
        $po_expire_date = G5_TIME_YMD;
    }

	$mb_point = get_point_sum($mb_id);

	$po_mb_point = $mb_point + $point;

    $sql = " insert into {$g5['point_table']}
                set mb_id = '$mb_id',
                    po_datetime = '".G5_TIME_YMDHIS."',
                    po_content = '".addslashes($content)."',
                    po_point = '$point',
                    po_use_point = '0',
                    po_mb_point = '$po_mb_point',
                    po_expired = '$po_expired',
                    po_expire_date = '$po_expire_date',
                    po_rel_table = '$rel_table',
                    po_rel_id = '',
                    po_rel_action = '$rel_action' ";
    sql_query($sql);

	return;
}

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

	// 자료가 많을 경우 대비 설정변경
	@ini_set('memory_limit', '-1');

	//포인트 초기화
	if($dpo == "2") {

		echo '<ul style="line-height:22px;">'.PHP_EOL;

		//회원정보의 포인트, 경험치, 회원레벨 초기화
		sql_query(" update {$g5['member_table']} set as_level = '1', as_exp = '0', mb_point = '0' ", false);

		//출력
		echo '<li>회원정보의 포인트, 경험치, 회원레벨 초기화 완료</li>'.PHP_EOL;
		
		//모든 게시물의 회원레벨 초기화
		$result = sql_query(" select bo_table, bo_subject from `{$g5['board_table']}` where bo_table <> '' ", false);
		while($row=sql_fetch_array($result)) {
			sql_query(" update `{$g5['write_prefix']}{$row['bo_table']}` set as_level = '1' ", false); // 게시물

			//출력
			echo '<li>['.$row['bo_subject'].'] 게시물의 회원레벨 초기화 완료</li>'.PHP_EOL;
		}

		//출력
		echo '<li><b>모든 게시물의 회원레벨 초기화 완료</b></li>'.PHP_EOL;

		// 상품댓글 레벨 초기화
		if(IS_YC) {	
			sql_query(" update `{$g5['apms_comment']}` set wr_level = '1' ", false); // 상품댓글

			//출력
			echo '<li>상품댓글의 회원레벨 초기화 완료</b></li>'.PHP_EOL;
		}

		//모든 포인트 내역 삭제
		sql_query(" delete from {$g5['point_table']} ", false);

		//출력
		echo '<li>포인트 테이블의 모든 로그 삭제 완료</li>'.PHP_EOL;
		echo '</ul>';

		sql_free_result($result);

	//포인트 통합
	} else if($dpo == "1") {

		$msg = '['.G5_TIME_YMD.'] ';

		if($page <= $total_page) {

			$start_rows = ($page - 1) * $rows; 

			$result = sql_query("select mb_id, mb_point from {$g5['member_table']} where mb_email_certify <> '' and mb_leave_date = '' and mb_intercept_date = '' limit $start_rows, $rows ", false);
			while($row=sql_fetch_array($result)) {
				
				// 현재 보유 포인트
				$po_point = $row['mb_point'];

				if($dxp) {
					// 경험치 초기화

					// 읽기 포인트
					$po_read = apms_exp_sum($row['mb_id'], '읽기', 1); 

					// 다운로드 포인트
					$po_download = apms_exp_sum($row['mb_id'], '다운로드', 1); 

					// 제외 합계
					$po_exp = $po_read + $po_download; 

					// 포인트 통합분
					$po_misc = $po_point - $po_exp;

					// 다운로드, 읽기, 열람을 제외한 모든 포인트 내역 삭제
					sql_query(" delete from {$g5['point_table']} where mb_id = '{$row['mb_id']}' and po_rel_action not in ('읽기', '다운로드', '열람') ", false);

					// 통합 내역 등록
					apms_exp_insert($row['mb_id'], $po_misc, $msg.'포인트 통합분', '@passive');

				} else {
					// 경험치 유지

					//-- rel_table
					// 로그인 포인트	
					$po_login = apms_exp_sum($row['mb_id'], '@login'); 

					// 출석 포인트
					$po_chulsuk = apms_exp_sum($row['mb_id'], '@chulsuk'); 

					// 구매 포인트
					$po_delivery = apms_exp_sum($row['mb_id'], '@delivery'); 

					//-- rel_action

					// 쓰기 포인트
					$po_write = apms_exp_sum($row['mb_id'], '쓰기', 1); 

					// 댓글 포인트
					$po_comment = apms_exp_sum($row['mb_id'], '댓글', 1); 

					// 읽기 포인트
					$po_read = apms_exp_sum($row['mb_id'], '읽기', 1); 

					// 추천 포인트
					$po_good = apms_exp_sum($row['mb_id'], '@good', 1); 

					// 비추천 포인트
					$po_nogood = apms_exp_sum($row['mb_id'], '@nogood', 1); 

					// 다운로드 포인트
					$po_download = apms_exp_sum($row['mb_id'], '다운로드', 1); 

					// 열람 포인트
					$po_reading = apms_exp_sum($row['mb_id'], '열람', 1); 

					//-- rel_table

					// 관리자 포인트	
					$po_admin = apms_exp_sum($row['mb_id'], '@exp'); 

					// 경험치 합계
					$po_exp = $po_admin + $po_login + $po_chulsuk + $po_delivery + $po_write + $po_comment + $po_read + $po_good + $po_nogood + $po_download + $po_reading;

					// 그밖에 포인트
					$po_misc = $po_point - $po_exp;

					// 다운로드, 읽기, 열람을 제외한 모든 포인트 내역 삭제
					sql_query(" delete from {$g5['point_table']} where mb_id = '{$row['mb_id']}' and po_rel_action not in ('읽기', '다운로드', '열람') ", false);

					// 통합 내역 건별 등록
					apms_exp_insert($row['mb_id'], $po_login, $msg.'로그인 포인트 통합분', '@login');
					apms_exp_insert($row['mb_id'], $po_chulsuk, $msg.'출석 포인트 통합분', '@chulsuk');
					apms_exp_insert($row['mb_id'], $po_delivery, $msg.'구매 포인트 통합분', '@delivery');
					apms_exp_insert($row['mb_id'], $po_write, $msg.'쓰기 포인트 통합분', '', '쓰기');
					apms_exp_insert($row['mb_id'], $po_comment, $msg.'댓글 포인트 통합분', '', '댓글');
					apms_exp_insert($row['mb_id'], $po_good, $msg.'추천 포인트 통합분', '', '@good');
					apms_exp_insert($row['mb_id'], $po_nogood, $msg.'비추천 포인트 통합분', '', '@nogood');
					apms_exp_insert($row['mb_id'], $po_admin, $msg.'관리자 포인트 통합분', '@exp');
					apms_exp_insert($row['mb_id'], $po_misc, $msg.'그밖에 포인트 통합분', '@passive');
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

			goto_url('./apms.exp.default.php?act=ok&amp;dpo=1&amp;dxp='.$dxp.'&amp;page='.$page.'&amp;token='.get_admin_token());
		}
	}

?>	
    <script type='text/javascript'> 
		alert('포인트 <?php echo ($dpo == "1") ? "통합" : "초기화";?> 작업을 완료했습니다.'); 
		self.close();
	</script>
<?php } else { ?>
	<script src="<?php echo G5_ADMIN_URL ?>/admin.js"></script>
	<form id="pointform" name="pointform" method="post" onsubmit="return point_submit(this);">
	<input type="hidden" name="act" value="ok">
	<div style="padding:10px">
		<div style="border:1px solid #ddd; background:#f5f5f5; color:#000; padding:10px; line-height:20px;">
			<b><i class="fa fa-bolt"></i> 포인트 정리</b>
		</div>
		<div style="border:1px solid #ddd; border-top:0px; padding:10px; padding-left:20px; line-height:22px;">
			<p class="red">
				<b>[주의] 실행 후 복구가 안되니 반드시 DB 백업을 먼저 하신 이후 실행해 주시기 바랍니다.</b>
			</p>
			<p>
				<label>
					<input type="radio" name="dpo" value="1"> <b>회원 포인트 및 경험치별 포인트 내역 통합</b>
				</label>
			</p>
			<ul style="margin-top:0px; margin-bottom:15px;">
				<li>이메일 미인증 회원과 탈퇴 및 차단회원은 작업시 제외됩니다.</li>
				<li>포인트 내역 중 읽기와 다운로드 내역은 통합에서 제외됩니다.</li>
				<li>
					총 <b><?php echo number_format($total_page);?></b> 작업(<?php echo number_format($total_count);?>명) 중 
					<input type="text" name="page" value="<?php echo $page;?>" size="6" class="frm_input"> 번째 작업부터 실행합니다.
				</li>
				<li style="list-style:none; margin-left:-17px; margin-top:10px;">
					<label>
						<input type="checkbox" name="dxp" value="1">
						경험치 초기화 : 통합작업 완료 후 "레벨 업데이트" 재실행 필요
					</label>
				</li>

			</ul>
			<p>
				<label>
					<input type="radio" name="dpo" value="2"> <b>[주의]</b> 전체 포인트 초기화(삭제) - 모든 게시물과 자료의 회원레벨도 1레벨로 초기화
				</label>
			</p>
		</div>
		<br>
		<div class="btn_confirm01 btn_confirm">
			<input type="submit" value="실행하기" class="btn_submit" accesskey="s">
		</div>
	</div>
	</form>
	<script>
		function point_submit(f) {
			var $radios = $('#pointform input:radio[name=dpo]');
			if($radios.is(':checked') == false) {
				alert("실행할 항목을 선택해 주세요.");
				return false;
			}

			if(!confirm("실행후 완료메시지가 나올 때까지 기다려 주세요.\n\n정말 실행하시겠습니까?")) {
				return false;	
			} 

			return true;
		}
	</script>
<?php } ?>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>