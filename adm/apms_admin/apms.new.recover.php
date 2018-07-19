<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

function new_recover_sql_query($sql, $error=G5_DISPLAY_SQL_ERROR, $link=null) {
    global $g5;

    if(!$link)
        $link = $g5['connect_db'];

    $sql = trim($sql);
    if(function_exists('mysqli_query') && G5_MYSQLI_USE) {
        if ($error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if ($error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }

    return $result;
}

include_once(G5_PATH.'/head.sub.php');

if($act == 'ok') {

	check_admin_token();

	// 자료가 많을 경우 대비 설정변경
	@ini_set('memory_limit', '-1');

	// 한 번에 1000개씩 처리
	$rows = 1000;

	if(!$page) $page = 1;

	// 첫페이지
	if($page > 1) {
		$cnt = sql_fetch(" select count(*) as cnt from {$g5['board_new_table']} ", false);
		$total_count = $cnt['cnt']; //총 등록수
	} else {
		// 새글 DB 전체 지우기
		sql_query(" delete from {$g5['board_new_table']} ");

		// 최근글 삭제일 체크
		$sql_where = "";
		if(isset($config['cf_new_del']) && $config['cf_new_del'] > 0) {
			$recover_date = date('Y-m-d H:i:s', (G5_SERVER_TIME - $config['cf_new_del'] * 86400));
			$sql_where = "where as_publish = '1' or (wr_datetime >= '{$recover_date}' and as_publish = '0')";
		}

		// 보드그룹
		$sql = '';
		$result1 = sql_query(" select bo_table from {$g5['board_table']} where as_new = '0' ", false);
		for ($i=0; $row1=sql_fetch_array($result1); $i++) {

			if(!$row1['bo_table']) continue;

			$tmp_write_table = $g5['write_prefix'] . $row1['bo_table'];

			$tmp_sql = $tmp_write_table.'.wr_id, ';
			$tmp_sql .= $tmp_write_table.'.wr_parent, ';
			$tmp_sql .= $tmp_write_table.'.mb_id, ';
			$tmp_sql .= $tmp_write_table.'.wr_datetime';

			$sql .= " select '{$row1['bo_table']}' as bo_table, wr_id, wr_datetime from $tmp_write_table $sql_where UNION ALL ";

		}

		$sql = substr($sql,0,-10);
		$sql = " select * from (".$sql.") as a order by wr_datetime ";
		$result2 = new_recover_sql_query($sql);
		for ($i=0; $row2=sql_fetch_array($result2); $i++) {
			// 새글 등록
			sql_query("insert into {$g5['board_new_table']} (bo_table, wr_id, bn_datetime) values ('{$row2['bo_table']}','{$row2['wr_id']}','{$row2['wr_datetime']}')");
		}

		sql_free_result($result1);
		sql_free_result($result2);

		//게시물 페이지 계산
		$total_count = $i; //총 등록수
	}

	$total_page  = ceil($total_count / $rows);

	if($page <= $total_page) {

		$start_rows = ($page - 1) * $rows; 

		$result3 = sql_query(" select bn_id, bo_table, wr_id from {$g5['board_new_table']} limit $start_rows, $rows ", false);
		while($row3=sql_fetch_array($result3)) {

			$start_rows++;

			$bo_table = $row3['bo_table'];
			$bn_id = $row3['bn_id'];
			$wr_id = $row3['wr_id'];

			if(!$bo_table || !$bn_id || !$wr_id) continue;

			$tmp_write_table = $g5['write_prefix'] . $bo_table; 

			$row = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$wr_id}' ", false);

			$as_secret = (strstr($row['wr_option'], 'secret')) ? 1 : 0;

			if($row['wr_is_comment']) { //댓글 
				$sql = " update {$g5['board_new_table']} 
							set wr_parent = '{$row['wr_parent']}',
								mb_id = '{$row['mb_id']}',
								as_lucky = '{$row['as_lucky']}',
								as_secret = '{$as_secret}',
								as_re_mb = '{$row['as_re_mb']}'
							where bn_id = '{$bn_id}' ";

			} else { //글
				$ea = sql_fetch(" select count(*) as event from {$g5['apms_event']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ", false);
				$sql = " update {$g5['board_new_table']} 
							set wr_parent = '{$row['wr_parent']}',
								mb_id = '{$row['mb_id']}',
								as_comment = '{$row['wr_comment']}',
								as_hit = '{$row['wr_hit']}',
								as_good = '{$row['wr_good']}',
								as_nogood = '{$row['wr_nogood']}',
								as_link = '{$row['as_link']}',
								as_poll = '{$row['as_poll']}',
								as_download = '{$row['as_download']}',
								as_event = '{$ea['event']}',
								as_secret = '{$as_secret}',
								as_type = '{$row['as_type']}',
								as_list = '{$row['as_list']}',
								as_publish = '{$row['as_publish']}',
								as_extra = '{$row['as_extra']}',
								as_reply = '{$row['wr_reply']}',
								as_re_mb = '{$row['as_re_mb']}',
								as_video = '{$row['as_video']}',
								as_update = '{$row['as_update']}'
							where bn_id = '{$bn_id}' ";
			}

			sql_query($sql, false);	
		}

		sql_free_result($result3);

		$per = round(($page / $total_page) * 100);

?>
	<br><br>
	<div class="tbl_frm01 tbl_wrap font-16" style="font-family:tahoma; text-align:center;">
		<table>
		<tbody>
		<tr class="bg-black">
			<td>구분</td>
			<td>게시물수</td>
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

		goto_url('./apms.new.recover.php?act=ok&amp;page='.$page.'&amp;token='.get_admin_token());
	}

?>	

	<script type='text/javascript'> 
		alert('총 <?php echo number_format($total_count);?>건의 새글을 복구하였습니다.'); 
		self.close();
	</script>
<?php } else { ?>
	<script src="<?php echo G5_ADMIN_URL ?>/admin.js"></script>
	<form id="defaultform" name="defaultform" method="post" onsubmit="return update_submit(this);">
	<input type="hidden" name="act" value="ok">
	<div style="padding:10px">
		<div style="border:1px solid #ddd; background:#f5f5f5; color:#000; padding:10px; line-height:20px;">
			<b><i class="fa fa-refresh"></i> 새글DB 복구하기</b>
		</div>
		<div style="border:1px solid #ddd; border-top:0px; padding:10px;line-height:22px;">
			<ul>
				<li><b class="red">[주의] 반드시 DB 백업을 먼저 하신 이후 실행해 주시기 바랍니다.</b></li>
				<li>환경설정 > 기본환경설정 > 최근 게시물 삭제일(<b><?php echo $config['cf_new_del'];?>일</b>) 기준으로 새글DB 자료를 복구합니다.</li>
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