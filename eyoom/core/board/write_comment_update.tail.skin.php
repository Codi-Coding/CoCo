<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($w == 'c') {
    if(defined('G5_SLACK_USE') && G5_SLACK_USE === true && is_file(G5_SLACK_PATH.'/slack.class.php')) {
        include_once(G5_SLACK_PATH.'/slack.class.php');
        
	    $slack = new SLACK();
	
	    $slack->setChannel("#{$config['cf_slack_channel']}"); // 메세지를 전송할 Slack 채널명
	    $slack->setUsername('[댓글] '.$wr_name);
	    $slack->setMessage($wr_content, G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr['wr_parent'].'#c_'.$comment_id);
	
	
	    $result = $slack->send();
    }
}
?>