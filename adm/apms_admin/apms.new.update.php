<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

function post_update_sql_query($sql, $error=G5_DISPLAY_SQL_ERROR, $link=null) {
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

function post_update_sql_fetch($sql, $error=G5_DISPLAY_SQL_ERROR, $link=null) {
    global $g5;

    if(!$link)
        $link = $g5['connect_db'];

    $result = post_update_sql_query($sql, $error, $link);
    $row = sql_fetch_array($result);
    return $row;
}

include_once(G5_PATH.'/head.sub.php');

//한 번에 1000개씩 처리
$rows = 1000;

//총 등록글수
$sql_total = $sql_result = '';
$result1 = sql_query(" select bo_table from {$g5['board_table']} where bo_table <> '' ", false);
for ($i=0; $row1=sql_fetch_array($result1); $i++) {

	$tmp_write_table = $g5['write_prefix'] . $row1['bo_table'];

	$sql_total .= " select wr_id from $tmp_write_table where wr_is_comment = '0' UNION ALL ";

	$sql_result .= " select '{$row1['bo_table']}' as bo_table, wr_id, wr_datetime from $tmp_write_table where wr_is_comment = '0' UNION ALL ";
}
$sql_total = " select count(*) as cnt from (".substr($sql_total,0,-10).") as a";
$total = post_update_sql_fetch($sql_total, false);
$total_count = $total['cnt'];
$total_page  = ceil($total_count / $rows);

if(!$page) $page = 1;

if($act == 'ok') {

	check_admin_token();

	//자료가 많을 경우 대비 설정변경
	@ini_set('memory_limit', '-1');

	if($page <= $total_page) {

		$start_rows = ($page - 1) * $rows; 

		$sql_result = " select * from (".substr($sql_result,0,-10).") as a order by wr_datetime limit $start_rows, $rows ";
		$result = post_update_sql_query($sql_result);
		while($row2=sql_fetch_array($result)) {

			$bo_table = $row2['bo_table'];

			$tmp_write_table = $g5['write_prefix'] . $bo_table;

			// 글가져오기
			$row = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row2['wr_id']}' ", false);
		
			if($row['wr_id']) {

				//첨부파일이 있으면
				$fa = sql_fetch(" select sum(bf_download) as download from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$row['wr_id']}' ", false);
				$as_download = $fa['download'];

				//글타입 체크
				$row['chk_img'] = true;
				$wtype = apms_wr_type($bo_table, $row);

				// 글업데이트
				sql_query(" update {$tmp_write_table} set as_download = '{$as_download}', as_list = '{$wtype['as_list']}', as_thumb = '".addslashes($wtype['as_thumb'])."', as_video = '{$wtype['as_video']}' where wr_id = '{$row['wr_id']}' ", false);

				unset($vinfo);
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

		goto_url('./apms.new.update.php?act=ok&amp;page='.$page.'&amp;token='.get_admin_token());
	}

	//총 등록글수
	$sum = sql_fetch("select sum(bo_count_write + bo_count_comment) as sum from {$g5['board_table']} where bo_table <> '' $sql_grp ", false);

?>	
	<script type='text/javascript'> 
		alert('게시물 업데이트를 완료했습니다.'); 
		self.close();
	</script>
<?php } else { ?>
	<script src="<?php echo G5_ADMIN_URL ?>/admin.js"></script>
	<form id="defaultform" name="defaultform" method="post" onsubmit="return update_submit(this);">
	<input type="hidden" name="act" value="ok">
	<div style="padding:10px">
		<div style="border:1px solid #ddd; background:#f5f5f5; color:#000; padding:10px; line-height:20px;">
			<b><i class="fa fa-bolt"></i> 게시물 업데이트</b>
		</div>
		<div style="border:1px solid #ddd; border-top:0px; padding:10px;line-height:22px;">
			<ul>
				<li><b class="red">[주의] 반드시 DB 백업을 먼저 하신 이후 실행해 주시기 바랍니다.</b></li>
				<li>게시물 타입, 다운로드, 썸네일 등 게시물(댓글제외)에 필요한 추가정보를 업데이트합니다.</li>
				<li>업데이트된 게시물을 새글DB에 반영하기 위해서는 "<b>새글DB 복구</b>"를 실행해야 합니다.</li>
				<li>
					총 <b><?php echo number_format($total_page);?></b> 작업(<?php echo number_format($total_count);?>건) 중 
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