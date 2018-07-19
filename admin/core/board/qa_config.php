<?php
$sub_menu = "300500";
if (!defined('_EYOOM_IS_ADMIN_')) exit;
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

$action_url = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=qa_config_update&amp;smode=1';

$qaconfig = get_qa_config();

for ($i=1; $i<=5; $i++) {
	$qa_extra[$i]['qa_subject']	= $qaconfig['qa_' . $i . '_subj'];
	$qa_extra[$i]['qa_value'] 	= $qaconfig['qa_' . $i];
}

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'qaconfig' 	=> $qaconfig,
	'qa_extra' 	=> $qa_extra,
));