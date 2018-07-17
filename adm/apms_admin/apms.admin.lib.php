<?php
if (!defined('_GNUBOARD_')) exit;

// APMS Config
$apms = array();

if(IS_YC) $apms = apms_config();

// 입력 폼 안내문
if (!function_exists('help')) {
	function help($help="")	{
		global $g5;

		$str  = '<span class="frm_info">'.str_replace("\n", "<br>", $help).'</span>';

		return $str;
	}
}

// 스킨경로를 얻는다
function apms_dir_list($skin, $len='') {

    $result_array = array();

    $dirname = G5_PATH.'/'.$skin.'/';

	if(!is_dir($dirname)) return;

	$handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if($file == "."||$file == "..") continue;

        if (is_dir($dirname.$file)) $result_array[] = $file;
    }
    closedir($handle);
    sort($result_array);

    return $result_array;
}

// 폴더내 파일을 얻는다
function apms_file_list($dir, $ext='php') {

	$arr = array();

    $file_path = G5_PATH.'/'.$dir.'/';

	if(!is_dir($file_path)) return;

	$handle = opendir($file_path);
	while ($file = readdir($handle)) {

		if($file == "."||$file == "..") continue;

		if($ext) {
			$tmp = apms_get_ext($file);
			if($tmp == $ext) {
				$name = explode(".".$ext, $file);
				$arr[] = $name[0];
			}
		} else {
			$arr[] = $file;
		}
	}
	closedir($handle);
	sort($arr);

	return $arr;
}

function apms_select_list($arr, $id, $val='', $first='', $size='80', $main='') {

	$str = '<select name="'.$id.'" style="width:'.$size.'px;">'."\n";
	if($first) {
		$str .= '<option value="">'.$first.'</option>'."\n";
	}
	if($main) {
		$str .= '<option value="#" '.get_selected('#', $val).'>기본메인</option>'."\n";
	}
	if($arr && !empty($arr)) {
		foreach($arr as $key=>$value) {
			$chk_sel = ($val == $arr[$key]) ? ' selected' : '';
			$str .= '<option value="'.$arr[$key].'"'.$chk_sel.'>'.$arr[$key].'</option>'."\n";
		}
	}
	$str .= '</select>'."\n";

	return $str;
}

function apms_select_arr($arr, $id, $val='', $first='', $size='80') {

	$str = '<select name="'.$id.'" style="width:'.$size.'px;">'."\n";
	if($first) $str .= '<option value="">'.$first.'</option>'."\n";
	$cnt = count($arr);
	for($i=0; $i < $cnt; $i++) {
		$arr[$i][1] = $arr[$i][1] ? $arr[$i][1] : $arr[$i][0];
		$chk_sel = ($val == $arr[$i][0]) ? ' selected' : '';
		$str .= '<option value="'.$arr[$i][0].'"'.$chk_sel.'>'.$arr[$i][1].'</option>'."\n";
	}
	$str .= '</select>'."\n";

	return $str;
}

function apms_thema_skin($arr, $t_id, $t_val, $s_id, $c_id, $first='', $size='80') {

	$str = '<select name="'.$t_id.'" style="width:'.$size.'px;" onchange="apms_colorset(this.value, \''.$s_id.'\', \''.$c_id.'\', \''.$size.'\');">'."\n";
	if($first) $str .= '<option value="">'.$first.'</option>'."\n";
	if($arr && !empty($arr)) {
		foreach($arr as $key=>$value) {
			$chk_sel = ($t_val == $arr[$key]) ? ' selected' : '';
			$str .= '<option value="'.$arr[$key].'"'.$chk_sel.'>'.$arr[$key].'</option>'."\n";
		}
	}
	$str .= '</select>'."\n";

	return $str;
}

function apms_colorset_skin($t_val, $c_id, $c_val, $opt='', $size='80') {

	$arr = array();

	if(is_dir(G5_PATH.'/thema/'.$t_val.'/colorset')) {
		$skin_path = G5_PATH.'/thema/'.$t_val.'/colorset/';
	} else {
		$skin_path = G5_PATH.'/thema/'.$t_val.'/skin/colorset/';
	}

	$opt = ($opt) ? $opt : '컬러셋 선택';

	$str = '<select name="'.$c_id.'" style="width:'.$size.'px;">'."\n";
	if(!$t_val) $str .= '<option value="">'.$opt.'</option>'."\n";
	if($t_val && is_dir($skin_path)) {
		$handle = opendir($skin_path);
		while ($file = readdir($handle)) {
			if($file == "."||$file == "..") continue;
			if (is_dir($skin_path.$file)) $arr[] = $file;
		}
		closedir($handle);
		sort($arr);

		if($arr && !empty($arr)) {
			foreach($arr as $key=>$value) {
				$chk_sel = ($c_val == $arr[$key]) ? ' selected' : '';
				$str .= '<option value="'.$arr[$key].'"'.$chk_sel.'>'.$arr[$key].'</option>'."\n";
			}
		}
	}
	$str .= '</select>'."\n";

	return $str;
}

// APMS Form
function apms_form($is_auth, $is_partner) {
	global $g5;
	
	if(!$is_auth && !$is_partner) return;

	$list = array();

	$pt_use = ($is_auth) ? "" : "and pi_use = '1'";
	$sql = " select * from {$g5['apms_form']} where pi_show = '1' $pt_use order by pi_order, pi_id ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
	}

	return $list;
}

function apms_form_option($type, $flist, $val='') {

	$cnt = count($flist);

	$str = '';
	if($type == "name") {
		for($i=0; $i < $cnt; $i++) {
			if ($val == $flist[$i]['pi_id']) {
				$str = $flist[$i]['pi_name'];
				return $str;
			}
		}
	} else if($type == "select") {
		for($i=0; $i < $cnt; $i++) {
			$selected = ($val == $flist[$i]['pi_id']) ? ' selected' : '';
			$str .= '<option value="'.$flist[$i]['pi_id'].'"'.$selected.'>'.$flist[$i]['pi_name'].'</option>'."\n";
		}
	}

	return $str;
}

function apms_form_skin($pi_id, $ca_id='') {
	global $g5;

	$row = array();
	
	if($ca_id) {
		$ca = array();
		$ca = sql_fetch(" select pt_form from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
		$pi_id = $ca['pt_form'];
	}

	if($pi_id) {
		$row = sql_fetch(" select * from {$g5['apms_form']} where pi_id = '{$pi_id}' ");
	}

	return $row;
}

// APMS Form List
function apms_form_list() {

	$arr = array();

	$path = G5_SKIN_PATH.'/apms/form';
	if(is_dir($path)) {
		$handle = opendir($path);
		while ($file = readdir($handle)) {
			if($file == "."||$file == "..") continue;
			$ext = apms_get_ext($file);
			if($ext == 'php') {
				$arr[] = $file;
			}
		}
		closedir($handle);
		sort($arr);
	}

	return $arr;
}

function apms_form_list_option($flist, $val='') {

	$cnt = count($flist);

	$str = '';
	for($i=0; $i < $cnt; $i++) {
		$selected = ($val == $flist[$i]) ? ' selected' : '';
		$str .= '<option value="'.$flist[$i].'"'.$selected.'>'.$flist[$i].'</option>'."\n";
    }

	return $str;
}

// 판매예약, 종료
function apms_reserve_end($time, $opt='') {

	if($time) {
		$date = date("Y-m-d", $time);
		$hour = date("H", $time);
		$minute = date("i", $time);
	} else {
		if($opt) {
			return; //종료일 처리시
		} else {
			$time = strtotime(G5_TIME_YMDHIS);
			$date = date("Y-m-d", $time);
			$hour = date("H", $time);
			$minute = floor(date("i", $time) / 10) * 10;
		}
	}

	$retime = array($date, $hour, $minute);

	return $retime;
}

// Delete Comment
function apms_delete_comment($it_id) {
	global $g5;

	if(!$it_id) return;

	sql_query(" delete from {$g5['apms_comment']} where it_id = '{$it_id}' ");
}

// Delete File
function apms_delete_dir($it_id) {

	if(!$it_id) return;

	$path = G5_DATA_PATH.'/item/'.$it_id;
	if(is_dir($path)) {
		$handle = opendir($path);
		while ($file = readdir($handle)) {
			if($file == "."||$file == "..") continue;
			@unlink($path.'/'.$file);
		}
		closedir($handle);
		rmdir($path);
	}
}

// Upload File
function apms_upload_file($dir, $pf_id) {
	global $config, $g5, $default;

	if(!$pf_id) return;

	//파일타입 설정
	switch($dir) {
		case 'item'		: $pf_dir = 1; $pf_file = G5_DATA_PATH.'/item/'.$pf_id; break;
		case 'partner'	: $pf_dir = 2; $pf_file = G5_DATA_PATH.'/apms/'.$dir; break;
		default			: return;
	}

	//디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
	@mkdir($pf_file, G5_DIR_PERMISSION);
	@chmod($pf_file, G5_DIR_PERMISSION);

	$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

	// 가변 파일 업로드
	$file_upload_msg = '';
	$upload = array();
	for ($i=0; $i<count($_FILES['pf_file']['name']); $i++) {
		$upload[$i]['id']	    = $pf_id;
		$upload[$i]['dir']     = $pf_dir;
		$upload[$i]['file']     = '';
		$upload[$i]['source']   = '';
		$upload[$i]['filesize'] = 0;
		$upload[$i]['image']    = array();
		$upload[$i]['image'][0] = '';
		$upload[$i]['image'][1] = '';
		$upload[$i]['image'][2] = '';
		$upload[$i]['guest_use'] = (isset($_POST['pf_guest'][$i]) && $_POST['pf_guest'][$i]) ? 1 : 0;
		$upload[$i]['purchase_use'] = (isset($_POST['pf_purchase'][$i]) && $_POST['pf_purchase'][$i]) ? 1 : 0;
		$upload[$i]['download_use'] = (isset($_POST['pf_download'][$i]) && $_POST['pf_download'][$i]) ? 1 : 0;
		$upload[$i]['view_use'] = (isset($_POST['pf_view'][$i]) && $_POST['pf_view'][$i]) ? 1 : 0;

		// 삭제에 체크가 되어있다면 파일을 삭제합니다.
		if (isset($_POST['pf_file_del'][$i]) && $_POST['pf_file_del'][$i]) {
			$upload[$i]['del_check'] = true;

			$row = sql_fetch(" select pf_file from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' and pf_no = '{$i}' ");
			@unlink($pf_file.'/'.$row['pf_file']);

		} else {
			$upload[$i]['del_check'] = false;
		}

		$tmp_file  = $_FILES['pf_file']['tmp_name'][$i];
		$filesize  = $_FILES['pf_file']['size'][$i];
		$filename  = $_FILES['pf_file']['name'][$i];
		$filename  = get_safe_filename($filename);

		// 서버에 설정된 값보다 큰파일을 업로드 한다면
		if ($filename) {
			if ($_FILES['pf_file']['error'][$i] == 1) {
				$file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.ini_get('upload_max_filesize').')된 값보다 크므로 업로드 할 수 없습니다.\\n';
				continue;
			}
			else if ($_FILES['pf_file']['error'][$i] != 0) {
				$file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
				continue;
			}

			//기존 등록파일이 있으면 삭제함
			if(!$upload[$i]['del_check']) {
				$row = sql_fetch(" select pf_file from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' and pf_no = '{$i}' ");
				if($row['pf_file']) {
					@unlink($pf_file.'/'.$row['pf_file']);
				}
			}
		}

		if (is_uploaded_file($tmp_file)) {
			// 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
			if (!$is_admin && $filesize > $default['pt_upload_size']) {
				$file_upload_msg .= '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이 설정('.number_format($default['pt_upload_size']).' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
				continue;
			}

			//=================================================================\
			// 090714
			// 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
			// 에러메세지는 출력하지 않는다.
			//-----------------------------------------------------------------
			$timg = @getimagesize($tmp_file);
			// image type
			if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
				 preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
				if ($timg['2'] < 1 || $timg['2'] > 16)
					continue;
			}
			//=================================================================

			$upload[$i]['image'] = $timg;

			// 프로그램 원래 파일명
			$upload[$i]['source'] = $filename;
			$upload[$i]['filesize'] = $filesize;

			// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
			$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

			shuffle($chars_array);
			$shuffle = implode('', $chars_array);

			// 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
	        $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

			$dest_file = $pf_file.'/'.$upload[$i]['file'];

			// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
			$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['pf_file']['error'][$i]);

			// 올라간 파일의 퍼미션을 변경합니다.
			chmod($dest_file, G5_FILE_PERMISSION);
		}
	}

	//------------------------------------------------------------------------------
	// 가변 파일 업로드
	for ($i=0; $i<count($upload); $i++)	{

		//파일유형체크
		$upload[$i]['ext'] = apms_check_ext($upload[$i]['source']);

		if (!get_magic_quotes_gpc()) {
			$upload[$i]['source'] = addslashes($upload[$i]['source']);
		}

		$row = sql_fetch(" select count(*) as cnt from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' and pf_no = '{$i}' ");
		if ($row['cnt']) {
			// 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
	        // 그렇지 않다면 내용만 업데이트 합니다.
			if ($upload[$i]['del_check'] || $upload[$i]['file']) {
				$sql = " update {$g5['apms_file']}
							set pf_source		= '{$upload[$i]['source']}',
								pf_file			= '{$upload[$i]['file']}',
								pf_filesize		= '{$upload[$i]['filesize']}',
								pf_width		= '{$upload[$i]['image']['0']}',
								pf_height		= '{$upload[$i]['image']['1']}',
								pf_type			= '{$upload[$i]['image']['2']}',
								pf_guest_use	= '{$upload[$i]['guest_use']}',
								pf_purchase_use = '{$upload[$i]['purchase_use']}',
								pf_download_use = '{$upload[$i]['download_use']}',
								pf_view_use		= '{$upload[$i]['view_use']}',
								pf_ext			= '{$upload[$i]['ext']}',
								pf_datetime		= '".G5_TIME_YMDHIS."'
						  where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' and pf_no = '{$i}' ";
				sql_query($sql);

			} else {
				$sql = " update {$g5['apms_file']}
							set	pf_guest_use	= '{$upload[$i]['guest_use']}',
								pf_purchase_use = '{$upload[$i]['purchase_use']}',
								pf_download_use = '{$upload[$i]['download_use']}',
								pf_view_use		= '{$upload[$i]['view_use']}'
						  where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' and pf_no = '{$i}' ";
				sql_query($sql);
			}
		} else {
			$sql = " insert into {$g5['apms_file']}
						set pf_id				= '{$upload[$i]['id']}',
							pf_no				= '{$i}',
							pf_source			= '{$upload[$i]['source']}',
							pf_file				= '{$upload[$i]['file']}',
							pf_download			= '0',
							pf_filesize			= '{$upload[$i]['filesize']}',
							pf_width			= '{$upload[$i]['image']['0']}',
							pf_height			= '{$upload[$i]['image']['1']}',
							pf_type				= '{$upload[$i]['image']['2']}',
							pf_guest_use		= '{$upload[$i]['guest_use']}',
							pf_purchase_use		= '{$upload[$i]['purchase_use']}',
							pf_download_use		= '{$upload[$i]['download_use']}',
							pf_view_use			= '{$upload[$i]['view_use']}',
							pf_dir				= '{$upload[$i]['dir']}',
							pf_ext				= '{$upload[$i]['ext']}',
							pf_datetime			= '".G5_TIME_YMDHIS."' ";
			sql_query($sql);
		}
	}

	// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
	// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
	$row = sql_fetch(" select max(pf_no) as max_pf_no from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' ");
	for ($i=(int)$row['max_pf_no']; $i>=0; $i--) {
		$row2 = sql_fetch(" select pf_file from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' and pf_no = '{$i}' ");

		// 정보가 있다면 빠집니다.
		if ($row2['pf_file']) break;

		// 그렇지 않다면 정보를 삭제합니다.
		sql_query(" delete from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '{$pf_dir}' and pf_no = '{$i}' ");
	}

	// 상품일 경우 상품정보를 업데이트 합니다.
	if($dir == 'item') {
		$cnt = sql_fetch(" select count(*) as cnt from {$g5['apms_file']} where pf_id = '{$pf_id}' and pf_dir = '1' ", false);
		sql_query(" update {$g5['g5_shop_item_table']} set pt_file = '{$cnt['cnt']}' where it_id = '{$pf_id}' ", false);
	}

	return $file_upload_msg;
}

// 상품군
function apms_it_gubun($it_gubun, $opt='wear') {
	global $item_info;

	if(!$it_gubun) $it_gubun = $opt;

	$str = '';
	foreach($item_info as $key=>$value) {
		$opt_value = $key;
		$opt_text  = $value['title'];
		$str .= '<option value="'.$opt_value.'" '.get_selected($opt_value, $it_gubun).'>'.$opt_text.'</option>'.PHP_EOL;
	}

	return $str;
}

// 상품분류
function apms_it_category($is_auth, $is_partner) {
	global $g5, $is_admin, $member;

	$sql = " select * from {$g5['g5_shop_category_table']} ";
	if($is_admin != 'super') {
		if ($is_auth) {
			$sql .= " where ca_mb_id = '{$member['mb_id']}' ";
		} else {
			$sql .= " where pt_use = '1' ";
		}
	}
	$sql .= " order by ca_order, ca_id ";
	$result = sql_query($sql);
	$str = '';
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$len = strlen($row['ca_id']) / 2 - 1;
		$nbsp = "";
		for ($i=0; $i<$len; $i++)
			$nbsp .= "&nbsp;&nbsp;&nbsp;";

		$selected = ($ca_id == $row['ca_id']) ? ' selected' : '';
		$str .= "<option value=\"{$row['ca_id']}\"".$selected.">$nbsp{$row['ca_name']}</option>\n";
	}

	return $str;
}

// http://kr1.php.net/manual/en/function.curl-setopt-array.php 참고
if (!function_exists('curl_setopt_array')) {
   function curl_setopt_array(&$ch, $curl_options)
   {
       foreach ($curl_options as $option => $value) {
           if (!curl_setopt($ch, $option, $value)) {
               return false;
           } 
       }
       return true;
   }
}


// 네이버 신디케이션에 ping url 을 curl 로 전달합니다.
function apms_naver_syndi_ping($it_id) {
    global $config, $is_admin;

    $token = trim($config['cf_syndi_token']);

    // 토큰값이 없다면 네이버 신디케이션 사용안함
    if ($token == '') return 0;

    // curl library 가 지원되어야 합니다.
    if (!function_exists('curl_init')) return -1;

    $ping_auth_header = "Authorization: Bearer " . $token;
    $ping_url = urlencode( APMS_PLUGIN_URL . "/syndi/ping.php?it_id={$it_id}" );
    $ping_client_opt = array( 
        CURLOPT_URL => "https://apis.naver.com/crawl/nsyndi/v2", 
        CURLOPT_POST => true, 
        CURLOPT_POSTFIELDS => "ping_url=" . $ping_url, 
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 10, 
        CURLOPT_TIMEOUT => 10, 
        CURLOPT_HTTPHEADER => array("Host: apis.naver.com", "Pragma: no-cache", "Accept: */*", $ping_auth_header)
    ); 

    //print_r2($ping_client_opt); exit;
    $ping = curl_init(); 
    curl_setopt_array($ping, $ping_client_opt); 
    $response = curl_exec($ping); 
    curl_close($ping);

    return $response;
}

function apms_is_cauth() {
    global $g5, $is_admin, $member;

	$is_cauth = false;

	if($is_admin == 'super') {
		$is_cauth = true;
	} else {
		//상품관리 체크
		$sql = "select au_auth from {$g5['auth_table']} where mb_id = '{$member['mb_id']}' and au_menu = '400300'";
		$row = sql_fetch($sql, false);
		if($row['au_auth']) {
			$is_cauth = true;
		}
	}

	return $is_cauth;
}

?>