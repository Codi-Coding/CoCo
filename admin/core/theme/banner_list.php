<?php
$sub_menu = "800500";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url1 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=banner_list';
$action_url2 = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=banner_list_update&amp;smode=1';

/**
 * 배너/광고 설정파일 폴더
 */
$banner_folder = G5_DATA_PATH.'/banner/';
$banner_config = $banner_folder.'banner.'.$this_theme.'.config.php';
if(@is_dir($banner_folder) && file_exists($banner_config) ) {
	@include_once($banner_config);
} else {
	@mkdir($banner_folder, G5_DIR_PERMISSION);
	@chmod($banner_folder, G5_DIR_PERMISSION);
	
	/**
	 * 설정파일이 없을 경우, 배너/광고 위치를 기본 설정
	 */
	$bn_loccd = array(
		"1" => "배너위치 1",
		"2" => "배너위치 2",
		"3" => "배너위치 3",
		"4" => "배너위치 4",
		"5" => "배너위치 5",
		"6" => "배너위치 6",
		"7" => "배너위치 7",
		"8" => "배너위치 8",
		"9" => "배너위치 9",
		"10" => "배너위치 ",
	);
	$qfile->save_file('bn_loccd', $banner_config, $bn_loccd, true);
}
if(is_array($bn_loccd)) ksort($bn_loccd);

/**
 * 배너 테이블에서 작업테마의 배너/광고 레코드 정보 가져오기
 */
$sql_common = " from {$g5['eyoom_banner']} ";

/**
 * 작업테마 조건문
 */
$sql_search = " where bn_theme='{$this_theme}' ";

/**
 * 배너/광고 위치별로 검색
 */
$loccd = clean_xss_tags(trim($_POST['loccd']));
$loccd = !$loccd ? clean_xss_tags(trim($_GET['loccd'])):$loccd;
if ($loccd) {
    $sql_search .= " and ( ";
    $sql_search .= " (bn_location = '{$loccd}') ";
    $sql_search .= " ) ";
}

$sql = " select count(*) as cnt {$sql_common} {$sql_search} order by bn_regdt desc ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} order by bn_regdt desc limit {$from_record}, {$rows}";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
	unset($bn_image);
	
	$banner_list[$i] = $row;

	$bn_file = G5_DATA_PATH.'/banner/'.$row['bn_theme'].'/'.$row['bn_img'];
	if (file_exists($bn_file) && $row['bn_img']) {
		$bn_url 	= G5_DATA_URL.'/banner/'.$row['bn_theme'].'/'.$row['bn_img'];
		$bn_image 	= "<img src='".$bn_url."' class='img-responsive'> ";
	}
	$bn_exposed = $row['bn_exposed']==0 ? 1:$row['bn_exposed'];
	$ratio = ceil(($row['bn_clicked']/$bn_exposed)*100);
	switch($row['bn_state']) {
		case '1': $bn_state = "보이기"; break;
		case '2': $bn_state = "<span style='color:#f30;'>숨기기</span>"; break;
	}

	if($row['bn_period'] == '1') {
		$banner_list[$i]['bn_start'] = '무제한';
		$banner_list[$i]['bn_end'] = '무제한';
	} else {
		$banner_list[$i]['bn_start'] = date('Y-m-d', strtotime($row['bn_start']));
		$banner_list[$i]['bn_end'] = date('Y-m-d', strtotime($row['bn_end']));
	}
	
	$banner_list[$i]['bn_image'] 	= $bn_image;
	$banner_list[$i]['bn_ratio'] 	= $ratio;
	$banner_list[$i]['bn_loccd'] 	= $bn_loccd[$row['bn_location']];
	$banner_list[$i]['bn_chg_code']	= "&lt;!--{@eb_banner({$row['bn_location']})}--&gt;{.html}&lt;!--{/}--&gt;";
}

/**
 * Paging 
 */
$paging = $thema->pg_pages($tpl_name,"./?dir=theme&amp;pid=banner_list&amp;thema={$this_theme}&amp;{$qstr}&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'bn_loccd' 		=> $bn_loccd,
	'banner_list' 	=> $banner_list,
));