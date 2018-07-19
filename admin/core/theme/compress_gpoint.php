<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

if($is_admin != 'super') alert('최고관리자만 설정을 변경할 수 있습니다.');

$action_url = EYOOM_ADMIN_URL."/?dir=theme&amp;pid=compress_gpoint&wmode=1";

$w = clean_xss_tags($_POST['w']);

if($w == 'u') {
	$backup_use = clean_xss_tags($_POST['backup_use']);
	// 테이블 백업
	if($backup_use == 'y') {
		$backup_point_table = G5_TABLE_PREFIX . 'point_' . date('YmdHis');
		
		$sql = "DROP TABLE IF EXISTS {$backup_point_table}";
		sql_query($sql);
		
		$sql = "
			CREATE TABLE IF NOT EXISTS {$backup_point_table} (
				po_id int(11) NOT NULL auto_increment,
				mb_id varchar(20) NOT NULL default '',
				po_datetime datetime NOT NULL default '0000-00-00 00:00:00',
				po_content varchar(255) NOT NULL default '',
				po_point int(11) NOT NULL default '0',
				po_use_point int(11) NOT NULL default '0',
				po_expired tinyint(4) NOT NULL default '0',
				po_expire_date date NOT NULL default '0000-00-00',
				po_mb_point int(11) NOT NULL default '0',
				po_rel_table varchar(20) NOT NULL default '',
				po_rel_id varchar(20) NOT NULL default '',
				po_rel_action varchar(255) NOT NULL default '',
				PRIMARY KEY  (po_id),
				KEY index1 (mb_id,po_rel_table,po_rel_id,po_rel_action),
				KEY index2 (po_expire_date)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8
		";
		sql_query($sql);
		
		$sql = "INSERT INTO {$backup_point_table} SELECT * FROM {$g5['point_table']}";
		sql_query($sql);
	}
	
	$zip_date = $_POST['zip_date'];
	$zdate 	= clean_xss_tags(str_replace('-', '', $zip_date));
	$limit 	= clean_xss_tags($_POST['zip_count']);
	$items	= clean_xss_tags($_POST['zip_item']);
	
	$pdate = $zdate . '000000';
	
	$where = " po_datetime < date_format({$pdate}, '%Y-%m-%d 23:59:59') ";
	$sql = "
		SELECT mb_id, count(po_point) as cnt, sum(po_point) as sum 
		FROM {$g5['point_table']} 
		WHERE {$where}
		GROUP BY mb_id HAVING cnt > '{$items}'
		ORDER BY cnt desc
	";
	if($limit != 0) $sql .= " LIMIT {$limit} ";
	
	$result = sql_query($sql);
	
	for($i=0, $pcnt = 0, $mcnt = 0; $row = sql_fetch_array($result); $i++) {
		$wh = $where . " and mb_id = '{$row['mb_id']}' ";
		
		// 압축대상 내역은 삭제처리
		$delete = "DELETE FROM {$g5['point_table']} WHERE {$wh}";
		sql_query($delete);
		
		// 압축 레코드 입력
		insert_point($row['mb_id'], $row['sum'], date("Y년 m월 d일") . ' 포인트내역 압축', '@pointzip', $row['mb_id'], $member['mb_id'].'-'.uniqid(''));
		
		// 압축한 건수를 더함
		$pcnt += $row['cnt'];
		$mcnt++;
	}
}

/**
 * submit 버튼
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="압축하기" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= '</div>';

$atpl->assign(array(
	'frm_submit' 	=> $frm_submit,
));