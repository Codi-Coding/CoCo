<?php
if (!defined('_GNUBOARD_')) exit;

// 게시판 관리자 이상 복사, 이동 가능
if ($is_admin != 'board' && $is_admin != 'group' && $is_admin != 'super' && !defined('G5_AUTOMOVE'))
	alert_close('게시판 관리자 이상 접근이 가능합니다.');

if ($sw != 'move' && $sw != 'copy')
	alert('sw 값이 제대로 넘어오지 않았습니다.');

if(!count($_POST['chk_bo_table']))
	alert('게시물을 '.$act.'할 게시판을 한개 이상 선택해 주십시오.', $url);

// 원본 파일 디렉토리
$src_dir = G5_DATA_PATH.'/file/'.$bo_table;

$save = array();
$save_count_write = 0;
$save_count_comment = 0;
$cnt = 0;

$sql = " select distinct wr_num from $write_table where wr_id in ({$wr_id_list}) order by wr_id ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
	$wr_num = $row['wr_num'];
	for ($i=0; $i<count($_POST['chk_bo_table']); $i++) {
		$move_bo_table = $_POST['chk_bo_table'][$i];

        // 취약점 18-0075 참고
        $sql = "select * from {$g5['board_table']} where bo_table = '".sql_real_escape_string($move_bo_table)."' ";
        $move_board = sql_fetch($sql);
        // 존재하지 않다면
        if( !$move_board['bo_table'] ) continue;

        $move_write_table = $g5['write_prefix'] . $move_bo_table;

        $src_dir = G5_DATA_PATH.'/file/'.$bo_table; // 원본 디렉토리
        $dst_dir = G5_DATA_PATH.'/file/'.$move_bo_table; // 복사본 디렉토리

		$count_write = 0;
		$count_comment = 0;

		$next_wr_num = get_next_num($move_write_table);

		$sql2 = " select * from $write_table where wr_num = '$wr_num' order by wr_parent, wr_is_comment, wr_comment desc, wr_id ";
		$result2 = sql_query($sql2);
		while ($row2 = sql_fetch_array($result2)) {
			$nick = cut_str($member['mb_nick'], $config['cf_cut_name']);
			if (!$row2['wr_is_comment'] && $config['cf_use_copy_log']) {
				if(strstr($row2['wr_option'], 'html')) {
					$log_tag1 = '<div class="content_'.$sw.'">';
					$log_tag2 = '</div>';
				} else {
					$log_tag1 = "\n";
					$log_tag2 = '';
				}
				
				if (defined('G5_AUTOMOVE')) {
					$row2['wr_content'] .= "\n".$log_tag1.'[이 게시물은 '.$auto_type.' 조건을 충족하여 자동으로 '.G5_TIME_YMDHIS.' '.$board['bo_subject'].'에서 '.($sw == 'copy' ? '복사' : '이동').' 됨]'.$log_tag2;
				} else {
					$row2['wr_content'] .= "\n".$log_tag1.'[이 게시물은 '.$nick.'님에 의해 '.G5_TIME_YMDHIS.' '.$board['bo_subject'].'에서 '.($sw == 'copy' ? '복사' : '이동').' 됨]'.$log_tag2;
				}
			}

			// 게시글 추천, 비추천수
			$wr_good = $wr_nogood = 0;
			if ($sw == 'move' && $i == 0) {
				$wr_good = $row2['wr_good'];
				$wr_nogood = $row2['wr_nogood'];
			}

			$sql = " insert into $move_write_table
						set wr_num = '$next_wr_num',
							 wr_reply = '{$row2['wr_reply']}',
							 wr_is_comment = '{$row2['wr_is_comment']}',
							 wr_comment = '{$row2['wr_comment']}',
							 wr_comment_reply = '{$row2['wr_comment_reply']}',
							 ca_name = '".addslashes($row2['ca_name'])."',
							 wr_option = '{$row2['wr_option']}',
							 wr_subject = '".addslashes($row2['wr_subject'])."',
							 wr_content = '".addslashes($row2['wr_content'])."',
							 wr_link1 = '".addslashes($row2['wr_link1'])."',
							 wr_link2 = '".addslashes($row2['wr_link2'])."',
							 wr_link1_hit = '{$row2['wr_link1_hit']}',
							 wr_link2_hit = '{$row2['wr_link2_hit']}',
							 wr_hit = '{$row2['wr_hit']}',
							 wr_good = '{$wr_good}',
							 wr_nogood = '{$wr_nogood}',
							 mb_id = '{$row2['mb_id']}',
							 wr_password = '{$row2['wr_password']}',
							 wr_name = '".addslashes($row2['wr_name'])."',
							 wr_email = '".addslashes($row2['wr_email'])."',
							 wr_homepage = '".addslashes($row2['wr_homepage'])."',
							 wr_datetime = '{$row2['wr_datetime']}',
							 wr_file = '{$row2['wr_file']}',
							 wr_last = '{$row2['wr_last']}',
							 wr_ip = '{$row2['wr_ip']}',
							 wr_1 = '".addslashes($row2['wr_1'])."',
							 wr_2 = '".addslashes($row2['wr_2'])."',
							 wr_3 = '".addslashes($row2['wr_3'])."',
							 wr_4 = '".addslashes($row2['wr_4'])."',
							 wr_5 = '".addslashes($row2['wr_5'])."',
							 wr_6 = '".addslashes($row2['wr_6'])."',
							 wr_7 = '".addslashes($row2['wr_7'])."',
							 wr_8 = '".addslashes($row2['wr_8'])."',
							 wr_9 = '".addslashes($row2['wr_9'])."',
							 wr_10 = '".addslashes($row2['wr_10'])."' ";
			sql_query($sql);

			$insert_id = sql_insert_id();

			// 코멘트가 아니라면
			if (!$row2['wr_is_comment']) {
				$save_parent = $insert_id;

				// 이윰뉴에서 해당 게시물 정보 가져옮
				$eyoom_tag = sql_fetch("select * from {$g5['eyoom_tag_write']} where tw_theme='{$theme}' and bo_table='$bo_table' and wr_id='{$row2['wr_id']}'");
				$eyoom_new = sql_fetch("select * from {$g5['eyoom_new']} where bo_table='$bo_table' and wr_id='{$row2['wr_id']}'");
				$en_image = unserialize($eyoom_new['wr_image']);
				unset($en_image['bf']);

				$sql3 = " select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' order by bf_no ";
				$result3 = sql_query($sql3);
				for ($k=0; $row3 = sql_fetch_array($result3); $k++) {
					if ($row3['bf_file']) {
                        // 원본파일을 복사하고 퍼미션을 변경
                        // 제이프로님 코드제안 적용
                        $copy_file_name = ($bo_table !== $move_bo_table) ? $row3['bf_file'] : $row2['wr_id'].'_copy_'.$insert_id.'_'.$row3['bf_file'];
                        @copy($src_dir.'/'.$row3['bf_file'], $dst_dir.'/'.$copy_file_name);
                        @chmod($dst_dir/$row3['bf_file'], G5_FILE_PERMISSION);
					}

					$sql = " insert into {$g5['board_file_table']}
								set bo_table = '$move_bo_table',
									 wr_id = '$insert_id',
									 bf_no = '{$row3['bf_no']}',
									 bf_source = '".addslashes($row3['bf_source'])."',
									 bf_file = '$copy_file_name',
									 bf_download = '{$row3['bf_download']}',
									 bf_content = '".addslashes($row3['bf_content'])."',
									 bf_filesize = '{$row3['bf_filesize']}',
									 bf_width = '{$row3['bf_width']}',
									 bf_height = '{$row3['bf_height']}',
									 bf_type = '{$row3['bf_type']}',
									 bf_datetime = '{$row3['bf_datetime']}' ";
					sql_query($sql);

					if ($sw == 'move' && $row3['bf_file']) {
						$save[$cnt]['bf_file'][$k] = $src_dir.'/'.$row3['bf_file'];
					}
					$en_image['bf'][$k] = str_replace(G5_PATH,'',$dst_dir.'/'.$row3['bf_file']);
				}
				$wr_image = serialize($en_image); // 이윰새글에 적용

				$count_write++;

				if ($sw == 'move' && $i == 0) {
					// 스크랩 이동
					sql_query(" update {$g5['scrap_table']} set bo_table = '$move_bo_table', wr_id = '$save_parent' where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' ");

					// 최신글 이동
					sql_query(" update {$g5['board_new_table']} set bo_table = '$move_bo_table', wr_id = '$save_parent', wr_parent = '$save_parent' where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' ");

					// 추천데이터 이동
					sql_query(" update {$g5['board_good_table']} set bo_table = '$move_bo_table', wr_id = '$save_parent' where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' ");

					// 이윰 새글 이동
					sql_query(" update {$g5['eyoom_new']} set bo_table = '$move_bo_table', wr_id = '$save_parent', wr_parent = '$save_parent', wr_image='{$wr_image}' where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' ");

					// 이윰 내글반응 이동
					sql_query(" update {$g5['eyoom_respond']} set bo_table = '$move_bo_table', wr_id = '$save_parent', pr_id = '$save_parent' where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' ");
					
					// 이윰 태그글
					if($eyoom_tag['wr_tag']) {
						sql_query(" update {$g5['eyoom_tag_write']} set bo_table = '$move_bo_table', wr_id = '$save_parent', wr_image='{$wr_image}' where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' and tw_theme = '{$theme}' ");
					} else {
						sql_query(" delete from {$g5['eyoom_tag_write']} where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' and tw_theme = '{$theme}' ");
					}
				}

				// 이윰 새글 복사
				if($sw == 'copy') {
					if(is_array($eyoom_new)) {
						unset($copy_set);
						foreach($eyoom_new as $key => $val) {
							if($key=='bn_id' || $key == 'bn_datetime') continue;
							else {
								if($key == 'bo_table') $val = $move_bo_table;
								if($key == 'wr_id') $val = $insert_id;
								if($key == 'wr_parent') $val = $insert_id;
								if($key == 'wr_image') $val = $wr_image;
								if($key == 'wr_subject' || $key == 'wr_content') {
									$val = addslashes(stripslashes($val));
								}
								$copy_set .= "{$key} = '{$val}', ";
							}
						}
						$copy_set .= "bn_datetime='".G5_TIME_YMDHIS."'";
						sql_query("insert into {$g5['eyoom_new']} set {$copy_set}");
					}
					
					if($eyoom_tag['wr_tag']) {
						unset($copy_set);
						foreach($eyoom_tag as $key => $val) {
							if($key=='tw_id' || $key == 'wr_datetime') continue;
							else {
								if($key == 'bo_table') $val = $move_bo_table;
								if($key == 'wr_id') $val = $insert_id;
								if($key == 'wr_image') $val = $wr_image;
								if($key == 'wr_subject' || $key == 'wr_content') {
									$val = addslashes(stripslashes($val));
								}
								$copy_set .= "{$key} = '{$val}', ";
							}
						}
						$copy_set .= "tw_datetime='".G5_TIME_YMDHIS."'";
						sql_query("insert into {$g5['eyoom_tag_write']} set {$copy_set}");
					} else {
						sql_query(" delete from {$g5['eyoom_tag_write']} where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' and tw_theme = '{$theme}' ");
					}
				}
			} else {
				$count_comment++;
				if ($sw == 'move') {
					// 최신글 이동
					sql_query(" update {$g5['board_new_table']} set bo_table = '$move_bo_table', wr_id = '$insert_id', wr_parent = '$save_parent' where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' ");

					// 이윰 새글 이동
					sql_query(" update {$g5['eyoom_new']} set bo_table = '$move_bo_table', wr_id = '$insert_id', wr_parent = '$save_parent' where bo_table = '$bo_table' and wr_id = '{$row2['wr_id']}' ");
				}
			}

			sql_query(" update $move_write_table set wr_parent = '$save_parent' where wr_id = '$insert_id' ");

			if ($sw == 'move')
				$save[$cnt]['wr_id'] = $row2['wr_parent'];

			$cnt++;
		}

		sql_query(" update {$g5['board_table']} set bo_count_write = bo_count_write + '$count_write' where bo_table = '$move_bo_table' ");
		sql_query(" update {$g5['board_table']} set bo_count_comment = bo_count_comment + '$count_comment' where bo_table = '$move_bo_table' ");

		delete_cache_latest($move_bo_table);
	}

	$save_count_write += $count_write;
	$save_count_comment += $count_comment;
}

delete_cache_latest($bo_table);

if ($sw == 'move') {
	for ($i=0; $i<count($save); $i++) {
		for ($k=0; $k<count($save[$i]['bf_file']); $k++)
			@unlink($save[$i]['bf_file'][$k]);

		sql_query(" delete from $write_table where wr_parent = '{$save[$i]['wr_id']}' ");
		sql_query(" delete from {$g5['board_new_table']} where bo_table = '$bo_table' and wr_id = '{$save[$i]['wr_id']}' ");
		sql_query(" delete from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '{$save[$i]['wr_id']}' ");
		$w_id[$i] = $save[$i]['wr_id'];
	}
	sql_query(" update {$g5['board_table']} set bo_count_write = bo_count_write - '$save_count_write', bo_count_comment = bo_count_comment - '$save_count_comment' where bo_table = '$bo_table' ");
}

if (!defined('G5_AUTOMOVE')) {
	$msg = '해당 게시물을 선택한 게시판으로 '.$act.' 하였습니다.';
	$opener_href = './board.php?bo_table='.$bo_table.'&amp;page='.$page.'&amp;'.$qstr;
	
	// 무한스크롤 모달창 닫기
	if ($wmode) {
		if(isset($w_id) && $w_id) $wr_id = implode('|',$w_id);
		$opener_script = "opener.close_modal('".$wr_id."');";
	} else {
		$opener_script = "opener.document.location.href = \"".$opener_href."\";";
	}
	

	echo "
		<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
		<script>
		alert(\"".$msg."\");
		".$opener_script."
		window.close();
		</script>
		<noscript>
		<p>
			\"".$msg."\"
		</p>
		<a href=\"".$opener_href."\">돌아가기</a>
		</noscript>
	";
	exit;
} else {
	$msg = '조건을 충족하여 해당 게시물을 ['.$binfo['bo_subject'].']으로 '.$act.' 하였습니다.';
	$href = './board.php?bo_table='.$tg_table;

	echo "
		<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
		<script>
		alert(\"".$msg."\");
		document.location.href = '".$href."';
		</script>
		<noscript>
		<p>
			\"".$msg."\"
		</p>
		<a href=\"".$href."\">돌아가기</a>
		</noscript>
	";
}