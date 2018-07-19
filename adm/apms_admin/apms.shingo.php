<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

if($mode == 'shingo') {

	$row = sql_fetch(" select * from {$g5['apms_shingo']} where id = '$id' ");

	if($row['id']) {
		if($row['flag']) {

			//신고카운트 초기화 변경
			sql_query(" update {$g5['apms_comment']} set wr_shingo = '0' where wr_id = '{$row['wr_id']}' ");

			$write = sql_fetch(" select mb_id from {$g5['apms_comment']} where wr_id = '{$row['wr_id']}' ");

			$it = apms_it($row['bo_table']);

			$wr_ment = "[".$it['it_name']."] 아이템에 달린 회원님의 댓글";

		} else {

			//신고카운트 초기화 변경
			sql_query(" update {$g5['write_prefix']}{$row['bo_table']} set as_shingo = '0' where wr_id = '{$row['wr_id']}' ");

			$bo = sql_fetch(" select bo_subject from {$g5['board_table']} where bo_table = '{$row['bo_table']}' ", false);

			$write = sql_fetch(" select wr_subject, mb_id from {$g5['write_prefix']}{$row['bo_table']} where wr_id = '{$row['wr_id']}' ");

			if($row['wr_id'] <> $row['wr_parent']) {
				$org = sql_fetch(" select wr_subject from {$g5['write_prefix']}{$row['bo_table']} where wr_id = '{$row['wr_parent']}' ");
				$wr_ment = "[".$bo['bo_subject']."] 게시판에 있는 [".$org['wr_subject']."] 제목의 글에 달린 회원님의 댓글";
			} else {
				$wr_ment = "[".$bo['bo_subject']."] 게시판에 있는 [".$write['wr_subject']."] 제목의 회원님의 글";
			}
		}

		//기존 신고내역 삭제
		sql_query(" delete from {$g5['apms_shingo']} where bo_table = '{$row['bo_table']}' and wr_id = '{$row['wr_id']}' and flag = '{$row['flag']}' ");

		//쪽지
		$send_msg = $wr_ment."에 대한 잠금처리가 해제되었음을 알려드립니다.";

		// 회원 아이디와 메세지가 있으면 쪽지 보냄
		if($write['mb_id'] && $send_msg) {
			$recv_id = $write['mb_id']; // 받는 사람 아이디
			$send_id = $config['cf_admin']; // 보내는 사람

			//쪽지 번호 뽑기
			$tmp_row = sql_fetch(" select max(me_id) as max_me_id from {$g5['memo_table']} ");
			$me_id = $tmp_row['max_me_id'] + 1;
				
			// 쪽지 INSERT
			$sql = " insert into {$g5['memo_table']} ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo ) values ( '$me_id', '$recv_id', '$send_id', '".G5_TIME_YMDHIS."', '$send_msg' ) ";
			sql_query($sql);
		}
	}

	// 이동
	goto_url('./apms.admin.php?ap=shingo&amp;page='.$page);
}

// 테이블의 전체 레코드수만 얻음
$row = sql_fetch(" select count(*) as cnt from {$g5['apms_shingo']} where mb_id = '@shingo' ");
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "select * from {$g5['apms_shingo']} where mb_id = '@shingo' order by id desc limit $from_record, {$config['cf_page_rows']} ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    <?php if ($page > 1) {?><a href="<?php echo $_SERVER['PHP_SELF']; ?>">처음으로</a> | <?php } ?>
    <span>전체 내용 <?php echo $total_count; ?>건</span>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">구분</th>
        <th scope="col">신고내용</th>
        <th scope="col">바로가기</th>
		<th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
		if($row['flag']) {
			$row2 = sql_fetch("select * from {$g5['apms_comment']} where wr_id = '{$row['wr_id']}' ");

			$gubun = '상품댓글';
			$href = G5_SHOP_URL.'/item.php?it_id='.$row['bo_table'].'#c_'.$row['wr_id'];

			$content = conv_content($row2['wr_content'], 0, 'wr_content');
			$content = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' alt='' style='max-width:100%;border:0;'>", $content);

		} else {
			$row2 = sql_fetch("select * from {$g5['write_prefix']}{$row['bo_table']} where wr_id = '{$row['wr_id']}' ");
			if($row['wr_id'] == $row['wr_parent']) {
				$gubun = '게시물';
				$href = G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row['wr_id'];

				$html = 0;
				if (strstr($row2['wr_option'], 'html1'))
					$html = 1;
				else if (strstr($row2['wr_option'], 'html2'))
					$html = 2;

				$content = conv_content($row2['wr_content'], $html);
			} else {
				$gubun = '보드댓글';
				$href = G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row['wr_parent'].'#c_'.$row['wr_id'];

				$content = conv_content($row2['wr_content'], 0, 'wr_content');
				$content = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' alt='' style='max-width:100%;border:0;'>", $content);
			}
		}

		$content = apms_content($content);
	?>
    <tr>
        <td class="td_mng"><?php echo $gubun; ?></td>
        <td>
			<?php echo $content; ?>
		</td>
        <td class="td_mng">
			<a href="<?php echo $href;?>" target="_blank">원문보기</a>
		</td>
        <td class="td_mng">
            <a href="./apms.admin.php?ap=shingo&amp;mode=shingo&amp;id=<?php echo $row['id']; ?>&amp;page=<?php echo $page;?>" class="apms-confirm">
				해제
			</a>
        </td>
    </tr>
    <?php
    }
    if ($i == 0) {
        echo '<tr><td colspan="4" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['PHP_SELF']}?ap=shingo&amp;page="); ?>
