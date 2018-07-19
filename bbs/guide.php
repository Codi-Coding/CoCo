<?php
define('_INDEX_', true);
include_once('./_common.php');
include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');

if($is_demo || $is_admin) {
	;
} else {
	alert('이용권한이 없습니다.');
}

if(!file_exists(G5_BBS_PATH.'/manual/menu.php')) {
	alert('APMS 사용매뉴얼이 설치되어 있지 않습니다.');
}

// 테마설정값 불러오기
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

$page_title = 'APMS Manual';
$page_desc = 'APMS 사용매뉴얼';
$at_set['main'] = $at_set['page'] = 12;

include_once('./_head.php');

apms_script('code');
apms_script('lightbox');

// 메뉴선택
function menu_on($name) {
	global $fdir, $fname, $cfdir;

	$on = ($fdir == $cfdir && $fname == $name) ? ' active' : '';

	return $on;
}

if(!isset($config['as_thema']) || !$config['as_thema']) {
	echo '<br><p align=center>APMS가 설치되어 있지 않습니다. <br><br> 관리자 접속후 관리자화면 > 테마관리에서 APMS를 설치해 주세요.</p></br>';
} else {
?>
	<div class="row">
		<div class="col-sm-9">
			<?php // Content
				if($fdir && $fname && file_exists(G5_BBS_PATH.'/manual/'.$fdir.'/'.$fname.'.php')) {
					@include_once(G5_BBS_PATH.'/manual/'.$fdir.'/'.$fname.'.php'); // Content
				} else {
			?>
				<?php if($fdir || $fname) { // Error ?>
					<div class="div-title-wrap">
						<h2 class="div-title">Error</h2>
						<div class="div-sep-wrap">
							<div class="div-sep sep-bold"></div>
						</div>
					</div>
					<div class="div-box-shadow">
						<div class="div-box text-center">
							존재하지 않는 페이지입니다.
						</div>
					</div>
				<?php } else { // Intro ?>
					<div class="div-title-wrap">
						<h2 class="div-title">Instruction</h2>
						<div class="div-sep-wrap">
							<div class="div-sep sep-bold"></div>
						</div>
					</div>
					<div class="div-box-shadow">
						<div class="div-box">
							APMS 사용설명서입니다. 
						</div>
					</div>
				<?php } ?>
			<?php } ?>
			<div class="clearfix h40"></div>
		</div>
		<div class="col-sm-3">
			<?php @include_once(G5_BBS_PATH.'/manual/menu.php'); ?>
			<div class="clearfix h20"></div>
		</div>
	</div>
<?php }
include_once('./_tail.php');
?>
