<?php
if (!defined('_GNUBOARD_')) exit;

// 첨부파일이 있다면 파일처리
$upload_max_filesize = ini_get('upload_max_filesize');

// POST 변수가 없는 경우는 첨부파일의 용량이 오버했을 때 나타나는 현상
if (empty($_POST)) {
	alert("파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\npost_max_size=".ini_get('post_max_size')." , upload_max_filesize=".$upload_max_filesize."\\n게시판관리자 또는 서버관리자에게 문의 바랍니다.");
}

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);

$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

// 본 댓글의 저장값 다시 가져오기
$cdata = sql_fetch("select wr_content, wr_link2 from {$write_table} where wr_id='{$comment_id}'", false);

// 첨부 이미지 삭제처리
if($_POST['del_cmtimg']) {
	$dfile = unserialize($cdata['wr_link2']);
	if(is_array($dfile)) {
		foreach($dfile as $i => $file) {
			$del_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$file['file'];
			@unlink($del_file);
			$delimg = "update {$write_table} set wr_link2 = '' where wr_id = '{$comment_id}'";
			sql_query($delimg,false);
		}
	}
}

// 가변 파일 업로드
$file_upload_msg = '';
$upload = array();
for ($i=0; $i<count($_FILES['cmt_file']['name']); $i++) {
	$upload[$i]['file']     = '';
	$upload[$i]['source']   = '';
	$upload[$i]['filesize'] = 0;
	$upload[$i]['image']    = array();
	$upload[$i]['image'][0] = '';
	$upload[$i]['image'][1] = '';
	$upload[$i]['image'][2] = '';

	$tmp_file  = $_FILES['cmt_file']['tmp_name'][$i];
	$filesize  = $_FILES['cmt_file']['size'][$i];
	$filename  = $_FILES['cmt_file']['name'][$i];
	$filename  = get_safe_filename($filename);
	if(!$filename) break;

	// 서버에 설정된 값보다 큰파일을 업로드 한다면
	if ($filename) {
		if ($_FILES['cmt_file']['error'][$i] == 1) {
			$file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
			continue;
		}
		else if ($_FILES['cmt_file']['error'][$i] != 0) {
			$file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
			continue;
		}
	}

	// 이미 등록된 이미지가 있다면 이전 이미지는 삭제처리
	$dfile = unserialize($cdata['wr_link2']);
	if(is_array($dfile) && !$_POST['del_cmtimg']) {
		foreach($dfile as $i => $file) {
			$del_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$file['file'];
			@unlink($del_file);
		}
	}

	if (is_uploaded_file($tmp_file)) {
		// 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
		if (!$is_admin && $filesize > $board['bo_upload_size']) {
			$file_upload_msg .= '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이 게시판에 설정('.number_format($board['bo_upload_size']).' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
			continue;
		}

		$timg = @getimagesize($tmp_file);
		// image type
		if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
			 preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
			if ($timg['2'] < 1 || $timg['2'] > 16)
				continue;
		}
		$upload[$i]['image'] = $timg;

		// 프로그램 원래 파일명
		$upload[$i]['source'] = $filename;
		$upload[$i]['filesize'] = $filesize;

		// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
		$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

		shuffle($chars_array);
		$shuffle = implode('', $chars_array);

		// 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
		$upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));

		$dest_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload[$i]['file'];

		// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
		$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['cmt_file']['error'][$i]);

		// 올라간 파일의 퍼미션을 변경합니다.
		chmod($dest_file, G5_FILE_PERMISSION);

		$wr_image['bf'][$i] = str_replace(G5_PATH,'',$dest_file);

		// 업로드 이미지가 있다면 wr_link2 필드에 업데이트
		$sql = "update {$write_table} set wr_link2 = '".serialize($upload)."' where wr_id='{$comment_id}'";
		sql_query($sql,false);

		// Eyoom NEW 테이블에 이미지 정보처리
		if($timg) {
			$wr_image = serialize($wr_image);
			$img_set = ",wr_image	= '{$wr_image}'";
		}
	}
}

// 답변글에 대한 내글반응 적용하기
if ($w == 'c') {
	if($reply_char) {
		$prev = sql_fetch(" select mb_id from {$write_table} where wr_id = '$_POST[comment_id]' and wr_is_comment = 1 and wr_comment_reply = '".substr($tmp_comment_reply,0,-1)."' ");
		$type = 'cmt_re';
		$pr_id = $_POST['comment_id'];
		$wr_mb_id = $prev['mb_id']; // 부모댓글 작성자 아이디
	} else {
		$type = 'cmt';
		$pr_id = $_POST['wr_id'];
		$wr_mb_id = $wr['mb_id']; // 부모글 작성자 아이디
	}

	$respond = array();
	$respond['type']		= $type;
	$respond['bo_table']	= $bo_table;
	$respond['pr_id']		= $pr_id;
	$respond['wr_id']		= $wr_id;
	$respond['wr_cmt']		= $comment_id;
	$respond['wr_subject']	= $wr_subject;
	$respond['wr_mb_id']	= $wr_mb_id;
	if($_POST['anonymous'] == 'y') $anonymous = true;
	$eb->respond($respond);
}

$wr_content = $cdata['wr_content'];
$wr_content = $eb->remove_editor_code($wr_content);
$wr_content = $eb->remove_editor_emoticon($wr_content);

$wr_video = $eb->get_editor_video($wr_content);
$wr_video = serialize($wr_video[1]);
$wr_sound = $eb->get_editor_sound($wr_content);
$wr_sound = serialize($wr_sound[1]);

$wr_content = $eb->remove_editor_video($wr_content);
$wr_content = $eb->remove_editor_sound($wr_content);
$wr_content = htmlspecialchars($wr_content);

// Eyoom 새글에 등록
if ($w == 'c') {
	// 원글관련 댓글수 증가
	sql_query(" update {$g5['eyoom_new']} set wr_comment = wr_comment + 1 where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
	$query = "
		insert into {$g5['eyoom_new']} set 
			bo_table	= '{$bo_table}',
			pr_id		= '{$respond['pr_id']}',
			wr_id		= '{$comment_id}',
			wr_parent	= '{$wr_id}',
			ca_name		= '{$wr['ca_name']}',
			wr_content	= '{$wr_content}',
			wr_option	= '{$wr_secret}',
			bn_datetime = '".G5_TIME_YMDHIS."',
			mb_id		= '{$mb_id}',
			mb_name		= '{$member['mb_name']}',
			mb_nick		= '{$member['mb_nick']}',
			mb_level	= '{$wr_1}',
			wr_image	= '{$wr_image}',
			wr_video	= '{$wr_video}',
			wr_sound	= '{$wr_sound}'
	";

	// 나의 활동
	$act_contents = array();
	$act_contents['bo_table'] = $bo_table;
	$act_contents['bo_name'] = $board['bo_subject'];
	$act_contents['wr_id'] = $comment_id;
	$act_contents['wr_parent'] = $wr_id;
	$act_contents['content'] = $wr_content;
	$eb->insert_activity($mb_id,$type,$act_contents);
	$eb->level_point($levelset['cmt']);

	// 댓글 포인트
	if($eyoom_board['bo_firstcmt_point'] || $eyoom_board['bo_bomb_point'] || $eyoom_board['bo_lucky_point']) {
		$point = $eb->point_comment();
		if(is_array($point)) {
			$point = serialize($point);
			// 댓글의 경우 wr_link1을 사용하지 않기에 활용
			sql_query(" update $write_table set wr_link1 = '{$point}' where wr_id='{$comment_id}'");
		}
	}

} else if($w == 'cu') {
	$set = "
		bo_table	= '{$bo_table}',
		pr_id		= '{$respond['pr_id']}',
		wr_id		= '{$comment_id}',
		wr_parent	= '{$wr_id}',
		ca_name		= '{$wr['ca_name']}',
		wr_content	= '{$wr_content}',
		wr_option	= '{$wr_secret}',
		mb_level	= '{$wr_1}',
	";
	if($wr_image) $set .= " wr_image = '{$wr_image}', ";
	if($wr_video) $set .= " wr_video = '{$wr_video}', ";
	if($wr_sound) $set .= " wr_sound = '{$wr_sound}', ";
	$set .= " bn_datetime = bn_datetime ";
	
	$query = "update {$g5['eyoom_new']} set {$set} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}'";
}
if($query) sql_query($query);
unset($query);

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/write_comment_update.skin.php');

// 무한스크롤 리스트에서 뷰창을 띄웠을 경우
$qstr .= $wmode ? $qstr.'&wmode=1':'';

if($goback) {
	delete_cache_latest($bo_table);
	$mb_photo = $eb->mb_photo($mb_id);
	$output['mb_nick'] = $member['mb_nick'];
	$output['mb_photo'] = $mb_photo;
	$output['datetime'] = G5_TIME_YMDHIS;
	include_once EYOOM_CLASS_PATH."/json.class.php";

	$json = new Services_JSON();
	$data = $json->encode($output);
	echo $data;
	exit;
}