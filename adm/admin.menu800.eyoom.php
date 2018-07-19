<?php
if (!defined('_EYOOM_IS_ADMIN_')) {

	if ($eb->version_score(str_replace("EyoomBuilder_", "", _EYOOM_VESION_)) >= $eb->version_score('1.3.0')) {
		$menu['menu800'] = array (
		    array('800000', '이윰관리자모드', EYOOM_ADMIN_INC_URL.'/eyoom3_admin.php', 'eyoom_config'),
		    array('800100', '이윰관리자모드 사용하기', EYOOM_ADMIN_INC_URL.'/eyoom3_admin.php', 'eyb_admin')
		);
	}
	return;
}

$menu['menu800'] = array (
    array('800000', '테마관리', G5_ADMIN_URL.'/eyoom_admin/config_form.php', 'eyoom_config'),
    array('800100', '테마환경설정', G5_ADMIN_URL.'/eyoom_admin/config_form.php', 'eyb_config'),
    array('800200', '게시판설정', G5_ADMIN_URL.'/eyoom_admin/board_list.php', 'eyb_board'),
    array('800300', '홈페이지메뉴설정', G5_ADMIN_URL.'/eyoom_admin/menu_list.php', 'eyb_menu'),
    array('800400', '쇼핑몰메뉴설정', G5_ADMIN_URL.'/eyoom_admin/shopmenu_list.php', 'eyb_shopmenu'),
    array('800500', '배너/광고관리', G5_ADMIN_URL.'/eyoom_admin/banner_list.php', 'eyb_banner'),
    array('800600', 'EB슬라이더관리', G5_ADMIN_URL.'/eyoom_admin/ebslider_list.php', 'eyb_ebslider'),
    array('800610', 'EB컨텐츠관리', G5_ADMIN_URL.'/eyoom_admin/ebcontents_list.php', 'eyb_ebcontents'),
    array('800620', 'EB최신글관리', G5_ADMIN_URL.'/eyoom_admin/eblatest_list.php', 'eyb_eblatest'),
    array('800700', '태그관리', G5_ADMIN_URL.'/eyoom_admin/tag_list.php', 'eyb_tag'),
    array('800800', '회원레벨관리', G5_ADMIN_URL.'/eyoom_admin/member_list.php', 'eyb_member'),
	array('800900', '이윰레벨 환경설정', G5_ADMIN_URL.'/eyoom_admin/level_config.php', 'eyb_level')
);
?>