<?php
if (!defined('_GNUBOARD_')) exit;

include_once(EYOOM_CLASS_PATH.'/template.class.php');

if($eyoom['countdown_skin']) $eyoom['countdown_skin'] = 'basic';

$tpl = new Template('countdown');

$tpl->assign(array(
	'date' => $cd_date,
));

$tpl->define(array(
	'countdown' =>  'basic/index.html'
));

$tpl->print_('countdown');
exit;