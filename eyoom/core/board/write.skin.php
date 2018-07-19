<?php
if (!defined('_GNUBOARD_')) exit;

$uid = get_uniqid();

/**
 * 글등록 회수 제한이 있는지 체크
 */
if ($eyoom_board['bo_write_limit'] && !$is_admin) {
	if (!$is_member) {
		alert("본 게시판은 하루 글작성 회수제한이 있는 게시판으로 비회원은 글을 작성하실 수 없습니다.");
	} else {
		$wr_limit = sql_fetch("select count(*) as cnt from {$write_table} where (mb_id = '{$member['mb_id']}' or wr_ip = '" . $_SERVER['REMOTE_ADDR'] . "') and wr_datetime between '" . date('Y-m-d') . " 00:00:00' and '" . date('Y-m-d') . " 23:59:59' ");
		if ($wr_limit['cnt'] >= $eyoom_board['bo_write_limit']) {
			alert("[{$board['bo_subject']}]에는 하루에 {$eyoom_board['bo_write_limit']}개의 글을 작성하실 수 있습니다.");
		}
	}
}

// summernote는 모바일에서 사용가능 하기에 editor 재설정
if(G5_IS_MOBILE && $config['cf_editor'] == 'summernote' && $eyoom_board['bo_use_summernote_mo'] == '1') {
	$is_dhtml_editor = false;
	$is_dhtml_editor_use = true;
	
	// 모바일에서는 G5_IS_MOBILE_DHTML_USE 설정에 따라 DHTML 에디터 적용
	if ($config['cf_editor'] && $is_dhtml_editor_use && $board['bo_use_dhtml_editor'] && $member['mb_level'] >= $board['bo_html_level']) {
	    $is_dhtml_editor = true;
	
	    if(is_file(G5_EDITOR_PATH.'/'.$config['cf_editor'].'/autosave.editor.js'))
	        $editor_content_js = '<script src="'.G5_EDITOR_URL.'/'.$config['cf_editor'].'/autosave.editor.js"></script>'.PHP_EOL;
	}
	$editor_html = editor_html('wr_content', $content, $is_dhtml_editor);
	$editor_js = '';
	$editor_js .= get_editor_js('wr_content', $is_dhtml_editor);
	$editor_js .= chk_editor_js('wr_content', $is_dhtml_editor);
}

// wr_1에 작성자의 레벨정보 입력
if($is_member) {
	if($w==''||$w=='r') {
		$wr_1 = $member['mb_level']."|".$eyoomer['level'];
	} else if($w=='u' && $wr_1 && $is_anonymous) {
		list($gnu_level,$eyoom_level,$anonymous) = explode('|',$wr_1);
		$wr_1 = $gnu_level."|".$eyoom_level;
		if($anonymous == 'y') {
			$anonymous_checked = 'checked="checked"';
		}
	}
}

/**
 * 채택게시판의 설정값 가져오기 위해 소스추가
 */
if (preg_match('/adopt/i',$eyoom_board['bo_skin']) && $eyoom_board['bo_use_adopt_point'] == '1') {
	$_wr_4 = unserialize($wr_4);
	$adopt_point = $_wr_4['adopt_point'];
}

// wr_4 변수값 암호화
$wr_4 = $eb->encrypt_md5($wr_4);

for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) {
	$wr_link[$i]['link_val'] = $write['wr_link'.$i]; 
}

// $file 변수 중복 제거 후, 첨부파일 갯수 세팅
$wr_file = array();
if(in_array($file, $eb->get_subdir_filename(G5_EXTEND_PATH))) unset($file);
for ($i=0; $is_file && $i<$file_count; $i++) {
	$wr_file[$i]['file'] = $file[$i]['file'];
	$wr_file[$i]['size'] = $file[$i]['size'];
	$wr_file[$i]['source'] = $file[$i]['source'];
	$wr_file[$i]['bf_content'] = $file[$i]['bf_content'];
}

// 태그 정보
if ($eyoom['use_tag'] == 'y' && $eyoom_board['bo_use_tag'] == '1' && $member['mb_level'] >= $eyoom_board['bo_tag_level']) {
	$tag_info = $eb->get_tag_info($bo_table, $wr_id);
	if($tag_info['wr_tag']) {
		$write['wr_tag'] = $tag_info['wr_tag'];
		$wr_tags = explode(',', $tag_info['wr_tag']);
	}
	if(isset($wr_tags)) $tpl->assign('wr_tags', $wr_tags);
}

// 확장필드
if ($bo_extend) {
	$ex_address = false;
	foreach ($exbo as $ex_fname => $exinfo) {
		unset($ex_required);
		if ($exinfo['ex_form'] == 'address') $ex_address = true;
		$ex_required = $exinfo['ex_required'] == 'y' ? ' required': '';
		$ex_value[$ex_fname] = $write[$ex_fname];
		
		switch($exinfo['ex_form']) {
			case 'text':
				$ex_write[$ex_fname] = '
<label for="'.$ex_fname.'" class="label">'.$exinfo['ex_subject'].'</label>
<label class="input">
    <input type="text" name="'.$ex_fname.'" id="'.$ex_fname.'" value="'.$ex_value[$ex_fname].'"'.$ex_required.'>
</label>
				';
				break;
			
			case 'radio':
				$ex_write[$ex_fname] = '
<label class="label">'.$exinfo['ex_subject'].'</label>
<div class="inline-group">
				';
				$ex_item = explode('|', $exinfo['ex_item_value']);
				if (is_array($ex_item)) {
					foreach($ex_item as $key => $value) {
						unset($chedked);
						if ($value == $ex_value[$ex_fname]) $chedked = ' checked';
						$ex_write[$ex_fname] .= '
	<label for="'.$ex_fname.'_'.($key+1).'" class="radio"><input type="radio" name="'.$ex_fname.'" id="'.$ex_fname.'_'.($key+1).'" value="'.$value.'"'.$chedked.'><i></i>'.$value.'</label>
						';
					}
				}
				$ex_write[$ex_fname] .= '
</div>
				';
				break;
				
			case 'checkbox':
				$ex_write[$ex_fname] = '
<label class="label">'.$exinfo['ex_subject'].'</label>
<div class="inline-group">
				';
				$ex_item = explode('|', $exinfo['ex_item_value']);
				$ex_value_item = explode('^|^', $ex_value[$ex_fname]);
				if (is_array($ex_item)) {
					foreach($ex_item as $key => $value) {
						unset($chedked);
						$ex_key = $ex_fname.'_'.($key+1);
						if (in_array($value, $ex_value_item)) {
							$chedked = ' checked';
							$ex_value[$ex_key] = $value;
						} else {
							$ex_value[$ex_key] = '';
						}
						$ex_write[$ex_fname] .= '
	<label for="'.$ex_fname.'_'.($key+1).'" class="checkbox"><input type="checkbox" name="'.$ex_fname.'['.($key+1).']" id="'.$ex_fname.'_'.($key+1).'" value="'.$value.'"'.$chedked.'><i></i>'.$value.'</label>
						';
					}
				}
				$ex_write[$ex_fname] .= '
</div>
				';
				break;
				
			case 'select':
				$ex_write[$ex_fname] = '
<label class="label">'.$exinfo['ex_subject'].'</label>
<label class="select">
	<select name="'.$ex_fname.'" id="'.$ex_fname.'">
				';
				$ex_item = explode('|', $exinfo['ex_item_value']);
				if (is_array($ex_item)) {
					foreach($ex_item as $key => $value) {
						unset($selected);
						if ($value == $ex_value[$ex_fname]) $selected = ' selected';
						$ex_write[$ex_fname] .= '
		<option value="'.$value.'"'.$selected.'>'.$value.'</option>
						';
					}
				}
				$ex_write[$ex_fname] .= '
	</select>
	<i></i>
</label>
				';
				break;
				
			case 'textarea':
				$var_editor = $ex_fname . '_editor_html';
				$$var_editor = editor_html($ex_fname, $ex_value[$ex_fname], $is_dhtml_editor);
				$editor_js .= get_editor_js($ex_fname, $is_dhtml_editor);
				$editor_js .= $exinfo['ex_required'] ? chk_editor_js($ex_fname, $is_dhtml_editor): '';
				
				$ex_write[$ex_fname] = '
<label class="label">'.$exinfo['ex_subject'].'</label>
<label class="textarea textarea-resizable">'.$$var_editor.'</label>
				';
				break;
				
			case 'address':
				$address_info[$ex_fname] = explode('^|^', $ex_value[$ex_fname]);
				
				$ex_write[$ex_fname] = '
<div class="col col-12">
	<label class="label margin-left-5">'.$exinfo['ex_subject'].'</label>
</div>
<div class="col col-4">
	<label for="'.$ex_fname.'_zip" class="sound_only">우편번호</label>
	<label class="input">
		<i class="icon-append fa fa-question-circle"></i>
    	<input type="text" name="'.$ex_fname.'[zip]" value="'.$address_info[$ex_fname][0].'" id="'.$ex_fname.'_zip"  size="5" maxlength="6">
    	<b class="tooltip tooltip-top-right">우편번호 (주소 검색 버튼을 클릭하여 조회)</b>
	</label>
</div>
<div class="col col-4">
	<button type="button" onclick="win_zip(\'fwrite\', \''.$ex_fname.'[zip]\', \''.$ex_fname.'[addr1]\', \''.$ex_fname.'[addr2]\', \''.$ex_fname.'[addr3]\', \''.$ex_fname.'[addr_jibeon]\');" class="btn-e btn-e-indigo rounded address-search-btn">주소 검색</button>
</div>
<div class="clearfix margin-bottom-10"></div>
<div class="col col-12">
    <label class="input">
    	<input type="text" name="'.$ex_fname.'[addr1]" value="'.$address_info[$ex_fname][1].'" id="'.$ex_fname.'_addr1"  size="50">
    </label>
    <div class="note margin-bottom-10"><strong>Note:</strong> 기본주소</div>
</div>
<div class="clear"></div>
<div class="col col-6">
    <label class="input">
    	<input type="text" name="'.$ex_fname.'[addr2]" value="'.$address_info[$ex_fname][2].'" id="'.$ex_fname.'_addr2" size="50">
    </label>
    <div class="note margin-bottom-10"><strong>Note:</strong> 상세주소</div>
</div>
<div class="col col-6">
    <label class="input">
    	<input type="text" name="'.$ex_fname.'[addr3]" value="'.$address_info[$ex_fname][3].'" id="'.$ex_fname.'_addr3" size="50" readonly="readonly">
    </label>
    <div class="note margin-bottom-10"><strong>Note:</strong> 참고항목</div>
</div>
<input type="hidden" name="'.$ex_fname.'[addr_jibeon]" value="'.$address_info[$ex_fname][4].'">
				';
				break;
		}
	}

	$tpl->assign(array(
		'ex_value' => $ex_value,
		'ex_write' => $ex_write,
		'address_info' => $address_info,
	));
}

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
if ($eyoom_board['bo_use_addon_map'] == '1' || (isset($ex_address) && $ex_address)) {
	add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/write.skin.php');

// Template define
$tpl->define_template('board',$eyoom_board['bo_skin'],'write.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);