<?php
if (!defined('_GNUBOARD_')) exit;

// 답변글에 대한 내글반응 적용하기
if ($w == 'r') {
	$respond = array();
	$respond['type']		= 'reply';
	$respond['bo_table']	= $bo_table;
	$respond['pr_id']		= $_POST['wr_id'];
	$respond['wr_id']		= $wr_id;
	$respond['wr_subject']	= $wr_subject;
	$respond['wr_mb_id']	= $wr['mb_id'];
	if($_POST['anonymous'] == 'y') $anonymous = true;
	$eb->respond($respond);
}

// 업로드된 파일 정보 가져오기
$result = sql_query(" select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
for($i=0; $row=sql_fetch_array($result);$i++) {
	if(!preg_match("/.(gif|jpg|jpeg|png)$/i",$row['bf_file'])) continue;
	$wr_image['bf'][$i] = "/data/file/{$bo_table}/".$row['bf_file'];
}

// 내용중의 링크 이미지 정보 가져오기
$matches = get_editor_image(stripslashes($wr_content),false);
if($matches[1]) {
	foreach($matches[1] as $k => $image) {
		$p = parse_url($image);
		$host = preg_replace("/www\./i","",$p['host']);
		$_host = preg_replace("/www\./i","",$_SERVER['HTTP_HOST']);

		$ex_url = '';
		if($host != $_host) $ex_url = "http://".$host;
		$wr_image['url'][$k] = $ex_url . $p['path'];
	}
}
if($wr_image) $wr_image = serialize($wr_image);

if($eyoom_board['bo_use_addon_coding'] == '1') {
	$wr_content = $eb->remove_editor_code($wr_content);
}

if($eyoom_board['bo_use_addon_emoticon'] == '1') {
	$wr_content = $eb->remove_editor_emoticon($wr_content);	
}

// 여유필드 wr_4 활용
$wr_4 = unserialize($eb->decrypt_md5($wr_4));
if($eyoom_board['bo_use_addon_video'] == '1') {
	// 내용에서 동영상 정보 가져오기
	$video_info = array();
	$video_info = $eb->get_editor_video(strip_tags($wr_content));
	$wr_video = serialize($video_info[1]);
	if($video_info[1]) {
		$video_url = explode('|', $video_info[1][0]);
		
		$wr_4['is_video'] = true; // 비디오 내용이 있음
		$wr_4['thumb_src'] = $eb->make_thumb_from_video($video_url, $bo_table, $wr_id, $board['bo_gallery_width'], $board['bo_gallery_height'] );
	} else {
		unset($wr_4['is_video'], $wr_4['thumb_src']);
	}
	$wr_content = $eb->remove_editor_video($wr_content);
}

// 채택게시판 포인트
if (preg_match('/adopt/i',$eyoom_board['bo_skin']) && $eyoom_board['bo_use_adopt_point'] && $_POST['adopt_point']) {
	$adopt_point = (int)clean_xss_tags($_POST['adopt_point']);
	if ($adopt_point > $member['mb_point']) {
		alert("채택 포인트는 보유하고 있는 포인트보다 높게 사용하실 수 없습니다.");
	}
	
	if (!$is_admin) {
		if ($w == '') {
			insert_point($member['mb_id'], $adopt_point*(-1), "{$board['bo_subject']}게시판 채택 포인트 설정 차감-".date('ymdhis'), $bo_table, $wr_id, "{$bo_table}-{$wr_id}-".date('ymdhis')." 채택게시판 글쓰기");
		} else if ($w == 'u' && $wr_4['adopt_point'] != $adopt_point) {
			$adopt_diff = (int)$adopt_point - (int)$wr_4['adopt_point'];
			insert_point($member['mb_id'], $adopt_diff*(-1), "{$board['bo_subject']}게시판 채택 포인트 재설정-".date('ymdhis'), $bo_table, $wr_id, "{$bo_table}-{$wr_id}-".date('ymdhis'));
		}
	}
	$wr_4['adopt_point'] = $adopt_point;
}
$wr_4 = serialize($wr_4);

// 리턴 이미지가 있다면 $write_table update 
$up_set['wr_4'] = $wr_4;

if($eyoom_board['bo_use_addon_soundcloud'] == '1') {
	// 내용에서 사운드클라우드 정보 가져오기
	$wr_sound = $eb->get_editor_sound($wr_content);
	$wr_sound = serialize($wr_sound[1]);
	$wr_content = $eb->remove_editor_sound($wr_content);
}

// 내용글에서 텍스트 추출
$content = addslashes($eb->eyoom_text_abstract($wr_content, 300));

// 태그 정리
if ($eyoom['use_tag'] == 'y' && $eyoom_board['bo_use_tag'] == '1') {
	$del_tag 	= get_text($_POST['del_tag']);
	$wr_tag 	= get_text($_POST['wr_tag']);
	$del_tags 	= explode(',', $del_tag);
	$wr_tags 	= explode(',', $wr_tag);
	unset($wr_tag);
	if(is_array($wr_tags) && $_POST['wr_tag']) {
		if(!$del_tags) $del_tags = array();
		$i=0;
		foreach($wr_tags as $_tag) {
			if(!in_array($_tag, $del_tags)) {
				$tag_array[$i] = $_tag;
				$i++;
			}
		}
		
		if(isset($tag_array)) {
			$wr_tag = implode(',', $tag_array);
	
			$tag_score = $w == 'u' ? 5: 20;
			foreach($tag_array as $key => $_tag) {
				$info = sql_fetch("select tg_id, tg_regcnt, tg_score from {$g5['eyoom_tag']} where tg_theme = '{$theme}' and tg_word = '{$_tag}' ", false);
				$regcnt = $info['tg_regcnt'] + 1;
				if($info['tg_id']) {
					if($w == 'u') $regcnt--;
					$score = $info['tg_score'] + $tag_score + 1;
					$tag_sql = "update {$g5['eyoom_tag']} set tg_score = '{$score}', tg_regcnt = '{$regcnt}' where tg_id = '{$info['tg_id']}'";
				} else {
					$score = $tag_score + 10;
					$tag_sql = "insert into {$g5['eyoom_tag']} set tg_theme = '{$theme}', tg_word = '{$_tag}', tg_regcnt = '1', tg_score = '{$score}', tg_regdt='".G5_TIME_YMDHIS."'";
				}
				sql_query($tag_sql, false);
			}
		}
	}
}

$where = "bo_table = '{$bo_table}' and wr_id = '{$wr_id}'";

// 공통 $set
$common_set['bo_table'] 	= $bo_table;
$common_set['wr_id'] 		= $wr_id;
$common_set['wr_subject'] 	= $wr_subject;
$common_set['wr_content'] 	= $content;
$common_set['wr_option'] 	= "{$html},{$secret},{$mail}";
$common_set['wr_image'] 	= $wr_image;
$common_set['wr_1'] 		= $wr_1;
$common_set['wr_2'] 		= $wr_2;
$common_set['wr_3'] 		= $wr_3;
$common_set['wr_4'] 		= $wr_4;
$common_set['wr_5'] 		= $wr_5;
$common_set['wr_6'] 		= $wr_6;
$common_set['wr_7'] 		= $wr_7;
$common_set['wr_8'] 		= $wr_8;
$common_set['wr_9'] 		= $wr_9;
$common_set['wr_10'] 		= $wr_10;

$cmset = $eb->make_sql_set($common_set);
unset($common_set);

// 이윰 New insert set
$mb_nick = $member['mb_id'] ? $member['mb_nick']: $wr_name;

$insert_set['pr_id'] 		= $respond['pr_id'];
$insert_set['wr_parent'] 	= $wr_id;
$insert_set['ca_name'] 		= $ca_name;
$insert_set['mb_id']		= $member['mb_id'];
$insert_set['mb_name']		= $wr_name;
$insert_set['mb_nick']		= $mb_nick;
$insert_set['mb_level']		= $member['mb_level'];
$insert_set['wr_video']		= $wr_video;
$insert_set['wr_sound']		= $wr_sound;
$insert_set['wr_comment']	= 0;
$insert_set['wr_hit']		= 0;
$insert_set['bn_datetime']	= G5_TIME_YMDHIS;

$inset = $eb->make_sql_set($insert_set);

$insert_new = "insert into {$g5['eyoom_new']} set {$cmset},{$inset}";
unset($insert_set, $inset);

// 이윰 New update set
$update_set['pr_id']		= $respond['pr_id'];
$update_set['wr_parent'] 	= $wr_id;
$update_set['ca_name'] 		= $ca_name;
$update_set['wr_video']		= $wr_video;
$update_set['wr_sound']		= $wr_sound;

$upset = $eb->make_sql_set($update_set);;

$update_new = "update {$g5['eyoom_new']} set {$cmset},{$upset} where {$where}";
sql_query($update_new, false);
unset($update_set, $upset);

// 태그 set
if ($eyoom['use_tag'] == 'y' && $eyoom_board['bo_use_tag'] == '1' && isset($wr_tag)) {
	
	// 태그 insert set
	$wr_nick = $member['mb_id'] ? $member['mb_nick'] : $wr_name;
	
	$ins_tag_set['tw_theme']	= $theme;
	$ins_tag_set['wr_tag']		= $wr_tag;
	$ins_tag_set['mb_id']		= $member['mb_id'];
	$ins_tag_set['mb_name']		= $wr_name;
	$ins_tag_set['mb_nick']		= $wr_nick;
	$ins_tag_set['mb_level']	= $member['mb_level'];
	$ins_tag_set['wr_hit']		= 0;
	$ins_tag_set['tw_datetime']	= G5_TIME_YMDHIS;
	
	$tagset = $eb->make_sql_set($ins_tag_set);
	
	$insert_tag = "insert into {$g5['eyoom_tag_write']} set {$cmset},{$tagset}";
	unset($ins_tag_set, $tagset);
	
	// 태그 update set
	$up_tag_set['tw_theme']	= $theme;
	$up_tag_set['wr_tag']	= $wr_tag;
	
	$uptagset = $eb->make_sql_set($up_tag_set);
	
	$update_tag = "update {$g5['eyoom_tag_write']} set {$cmset},{$uptagset} where {$where} and tw_theme='{$theme}' ";
	sql_query($update_tag, false);
	unset($up_tag_set, $uptagset);
}

// Eyoom 새글
if ($w == '' || $w == 'r') {
	$new_query = $insert_new;
	if(isset($wr_tag)) $tag_query = $insert_tag;
	
	// 나의활동 
	switch($w) {
		default  : $act_type = 'new'; $eb->level_point($levelset['write']); break;
		case 'r' : $act_type = 'reply'; $eb->level_point($levelset['reply']); break;
	}
	$act_contents = array();
	$act_contents['bo_table'] = $bo_table;
	$act_contents['bo_name'] = $board['bo_subject'];
	$act_contents['wr_id'] = $wr_id;
	$act_contents['subject'] = $wr_subject;
	$act_contents['content'] = $content;
	$eb->insert_activity($member['mb_id'],$act_type,$act_contents);

} else if($w == 'u') {
	// 새글 정보가 이미 있다면 업데이트
	$new_post = sql_fetch("select * from {$g5['eyoom_new']} where $where");
	$new_query = $new_post['bn_id'] ? $update_new : $insert_new;
	
	// 태그 정보가 이미 있다면 업데이트
	if(isset($wr_tag)) {
		$tag_post = sql_fetch("select tw_id from {$g5['eyoom_tag_write']} where {$where} and tw_theme='{$theme}'");

		// 태그 작성 테이블에 글이 있다면 업데이트
		if($tag_post['tw_id']) {
			$tag_query = $update_tag;
		} else if($new_post['bn_id']) {
			// 이미 새글에 등록된 글이라면 새글 정보로 등록
			$ins_tag_set['tw_theme']	= $theme;
			$ins_tag_set['wr_tag']		= $wr_tag;
			$ins_tag_set['mb_id']		= $new_post['mb_id'];
			$ins_tag_set['mb_name']		= $new_post['mb_name'];
			$ins_tag_set['mb_nick']		= $new_post['mb_nick'];
			$ins_tag_set['mb_level']	= $new_post['mb_level'];
			$ins_tag_set['wr_hit']		= $new_post['wr_hit'];
			$ins_tag_set['tw_datetime']	= $new_post['bn_datetime'];
			
			$tagset = $eb->make_sql_set($ins_tag_set);
			$insert_tag = "insert into {$g5['eyoom_tag_write']} set {$cmset},{$tagset}";
			
			$tag_query = $insert_tag;
		} else {
			// 정말 새로 작성한 글이라면 새로 등록
			$tag_query = $insert_tag;
		}
	} else {
		// 태그 정보가 없다면 태그 포스트는 삭제
		$tag_query = "delete from {$g5['eyoom_tag_write']} where {$where} and tw_theme='{$theme}' ";
	}
}
if(isset($new_query)) sql_query($new_query, false);
if(isset($tag_query)) sql_query($tag_query, false);
unset($cmset, $new_query, $tag_query, $insert_new, $update_new, $insert_tag, $update_tag);

// 지뢰폭탄 포인트 심기
if ($w == '' || $w == 'r') {
	if($eyoom_board['bo_bomb_point'] > 0 && $eyoom_board['bo_bomb_point_limit'] > 0 && $eyoom_board['bo_bomb_point_cnt'] > 0) {
		for($i=0;$i<$eyoom_board['bo_bomb_point_cnt'];$i++) {
			$bomb[$i] = $eb->random_num($eyoom_board['bo_bomb_point_limit']-1);
		}
		if(is_array($bomb)) {
			$bomb = serialize($bomb);
			$up_set['wr_2'] = $bomb;
		}
	}
}

// $up_set 대상이 있다면
if(count($up_set) > 0 && is_array($up_set) ) {
	$j=0;
	foreach($up_set as $key => $val) {
		$set[$j] = " {$key} = '{$val}' ";
		$j++;
	}
	sql_query("update $write_table set " . implode(',', $set) ." where wr_id='{$wr_id}'");
}

// 확장필드
if ($bo_extend) {
	$j=0;
	foreach ($exbo as $ex_fname => $exinfo) {
		unset($ex_value);
		switch ($exinfo['ex_form']) {
			case 'text':
			case 'radio':
			case 'select':
			    if (isset($_POST[$ex_fname]) && settype($_POST[$ex_fname], 'string')) {
			        $ex_value= trim($_POST[$ex_fname]);
			    }
				break;
			case 'checkbox':
			case 'address':
			    if (isset($_POST[$ex_fname]) && settype($_POST[$ex_fname], 'array')) {
			        $ex_value= implode('^|^', $_POST[$ex_fname]);
			    }
				break;
			case 'textarea':
				if (isset($_POST[$ex_fname])) {
				    $ex_value = substr(trim($_POST[$ex_fname]),0,65536);
				    $ex_value = preg_replace("#[\\\]+$#", "", $ex_value);
				}

				if (substr_count($ex_value, '&#') > 50) {
				    alert("{$exinfo['ex_subject']}에 올바르지 않은 코드가 다수 포함되어 있습니다.");
				    exit;
				}
				break;
		}
		$ex_set[$j] = " {$ex_fname} = '{$ex_value}' ";
		$j++;
	}
	sql_query("update $write_table set " . implode(',', $ex_set) ." where wr_id='{$wr_id}'");
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/write_update.skin.php');

// 무한스크롤 리스트에서 뷰창을 띄웠을 경우
$qstr .= $wmode ? $qstr.'&wmode=1':'';