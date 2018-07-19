<?php
if (!defined('_GNUBOARD_')) exit;

// 암호화 시스템 적용
if(defined('__MSS_API_INCLUDED__')) {
	if(!isset($mssapi)) $mssapi = new CMSSAPI;

	if($mssapi->use_pwenc && $mb_password) {
		$mb_no = $mssapi->getRecord($g5[member_table],"mb_id='$mb_id'","mb_no");

		$mb_password = $mssapi->get_pwenc_str($g5[member_table],$mb_no,get_encrypt_string($mb_password));

		sql_query("update $g5[member_table] set mb_password='$mb_password' where mb_no='$mb_no'");
	}

	if($mssapi->use_infoenc) {
		if(!isset($mb_no)) $mb_no = $mssapi->getRecord($g5[member_table],"mb_id='$mb_id'","mb_no");

		$POST_DATA = $mssapi->getInfoEncryptData($g5[member_table],$_POST,$mb_no,true);
		$mssapi->updateTable($g5[member_table],$POST_DATA,"mb_no='$mb_no'");
	}

}