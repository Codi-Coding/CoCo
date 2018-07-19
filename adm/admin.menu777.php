<?php

// 가이드북
$apms_guidebook = (is_file(G5_BBS_PATH.'/manual/menu.php')) ? array('777999', '가이드북', ''.G5_BBS_URL.'/guide.php', 'ats_guide', 1) : array('','','','');

// 이용내역
$apms_uselog = (defined('G5_USE_SHOP') && G5_USE_SHOP) ? array('777007', '이용내역', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=uselog', 'ats_uselog', 1) : array('','','','');

$menu['menu777'] = array (
	array('777001', '테마관리', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=thema', 'ats_thema'),
	array('777001', '기본설정', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=thema', 'ats_thema'),
	array('777002', '메뉴설정', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=menu', 'ats_menu'),
	array('777004', '기본문서', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=bpage', 'ats_bpage'),
	array('777005', '일반문서', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=npage', 'ats_npage'),
	array('777006', '잠금관리', ''.G5_ADMIN_URL.'/apms_admin/apms.admin.php?ap=shingo', 'ats_shingo'),
	$apms_uselog,
	$apms_guidebook,
);
?>