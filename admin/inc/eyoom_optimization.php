<?php
include_once('./_common.php');

if ($is_admin != 'super') alert('최고관리자로 로그인 후 실행해 주십시오.', G5_URL);

$target = clean_xss_tags($_POST['tg']);
if(!$target) $target = 'respond';

switch($target) {
	case 'latest':
		$sql = "select * from {$g5['eyoom_new']} where (1) and (TO_DAYS('".G5_TIME_YMDHIS."') - TO_DAYS(bn_datetime)) < '{$config['cf_new_del']}' and wr_id=wr_parent order by bn_datetime desc";
		$res = sql_query($sql,false);
		for($i=0; $row=sql_fetch_array($res);$i++) {
			$tmp_table = $g5['write_prefix'].$row['bo_table'];
			$chk_sql = "select count(*) as cnt from {$tmp_table} where wr_id = '{$row['wr_id']}' ";
			$row2 = sql_fetch($chk_sql);
			if(!$row2['cnt']) {
				$sql2 = "delete from {$g5['eyoom_new']} where bo_table = '{$row['bo_table']}' and wr_parent = '{$row['wr_id']}'";
				sql_query($sql2, false);
			}
		}
		break;

	case 'respond':
		$sql = "select wr_mb_id from {$g5['eyoom_respond']} where re_chk = '0' ";
		$res = sql_query($sql,false);
		for($i=0; $row=sql_fetch_array($res);$i++) $respond[$row['wr_mb_id']][$i] = $row['wr_mb_id'];
		if (is_array($respond)) {
			foreach($respond as $mb_id => $val) {
				unset($count);
				$count = count($respond[$mb_id]);
				sql_query("update {$g5['eyoom_member']} set respond = '{$count}' where mb_id = '{$mb_id}' ");
			}
		}
		break;
}
$tocken = 'yes';

if($tocken) {
	$_value_array = array();
	$_value_array['result'] = $tocken;

	include_once EYOOM_CLASS_PATH."/json.class.php";

	$json = new Services_JSON();
	$output = $json->encode($_value_array);

	echo $output;
}
exit;
