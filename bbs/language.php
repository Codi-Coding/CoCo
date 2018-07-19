<?php
	if (!defined('_GNUBOARD_')) exit;
	if($g5['language'] != 'kr') {
		global $mlang;
		$lang_msg = $mlang->alert_message($msg, $g5['language']);
		$msg = $lang_msg ? $lang_msg:$msg;
	}
?>