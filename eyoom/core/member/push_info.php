<?php
define('_GNUBOARD_', true);

// 회원만 접근
if(!$_POST['mb_id']) exit;
$mb_id = $_POST['mb_id'];

// 푸쉬파일 가져오기
$push_tocken = false;
$push_path = '../../../data/member/push';
if(!@is_dir($push_path)) {
	@mkdir($push_path, 0755);
	@chmod($push_path, 0755);
}
$push_file = $push_path.'/push.'.$mb_id.'.php';
if(file_exists($push_file)) {
	include_once($push_file);
} else exit;

// 푸시적용 항목
$push_item = array(
	'respond',
	'memo',
	'following',
	'unfollow',
	'likes',
	'guest',
	'levelup',
	'adopt',
);

foreach($push_item as $val) {
	if($push[$val]) {
		$item = $val;
		$push_tocken = true;
		break;
	}
}

// 푸시가 있다면 넘겨주기
if($push_tocken) {
	include_once "../../classes/json.class.php";

	$json = new Services_JSON();
	$output = $json->encode($push);

	// 푸쉬알람 등록
	if(!$push[$item]['alarm']) {
		$push[$item]['alarm'] = true;
		
		include_once "../../classes/qfile.class.php";
		$qfile	= new qfile;
		$qfile->save_file("push",$push_file,$push);
	}
	echo $output;
}
exit;