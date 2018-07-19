<?php
$g5_path = '../../..';
include_once($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

if(!$is_member) exit;

if (substr_count($content, "&#") > 50) {
	alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
	exit;
}

$w = $_POST["w"];
$mb_id  = trim($_POST['mb_id']);
$gu_id  = trim($_POST['gu_id']);
$gu_name  = trim($_POST['gu_name']);
if(!$mb_id) exit;
if(!$gu_id) exit;
if(!$gu_name) exit;

if ($w == '' && $_SESSION['ss_datetime'] >= (G5_SERVER_TIME - $config['cf_delay_sec']) && !$is_admin)
	alert('너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.');

set_session('ss_datetime', G5_SERVER_TIME);

$sql = "insert into {$g5['eyoom_guest']} set mb_id='{$mb_id}', gu_id='{$gu_id}', gu_name='{$gu_name}', content='{$content}', gu_regdt='".G5_TIME_YMDHIS."'";
sql_query($sql, false);
$mb_photo = $eb->mb_photo($gu_id);

// 푸쉬알람
$user = $eb->get_user_info($mb_id);
if($user['onoff_push_guest'] == 'on' && $mb_id != $member['mb_id']) $eb->set_push("guest",$gu_id,$mb_id,$gu_name,'');

// 나의활동 
$act_contents = array();
$act_contents['mb_id'] = $mb_id;
$act_contents['mb_name'] = $user['mb_nick'];
$act_contents['content'] = $content;
$eb->insert_activity($member['mb_id'],"guest",$act_contents);

$output['mb_nick'] = $gu_name;
$output['mb_photo'] = $mb_photo;
$output['datetime'] = G5_TIME_YMDHIS;
include_once EYOOM_CLASS_PATH."/json.class.php";

$json = new Services_JSON();
$data = $json->encode($output);
echo $data;
exit;