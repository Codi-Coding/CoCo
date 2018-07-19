<?php
$sub_menu = "800800";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

check_demo();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택수정") {

	auth_check($auth[$sub_menu], 'w');
	
	$rm = 0;
	$rc = 0;
	
	$leave_mb_id 	= array();
	$recover_mb_id 	= array();
    for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        // 대상 회원아이디
        $mb_id 			= get_text($_POST['mb_id'][$k]);

        // 대상 그누레벨
        $mb_level 		= get_text($_POST['mb_level'][$k]) * 1;

        // 이전 그누레벨
        $mb_prev_level 	= get_text($_POST['mb_prev_level'][$k]) * 1;

        // 현재 이윰 레벨
        $level 			= get_text($_POST['level'][$k]) * 1;

        // 현재 이윰 레벨 경험치
        $level_point 	= get_text($_POST['level_point'][$k]) * 1;

		/**
		 * 관리자 계정이거나 레벨의 변동사항이 없으면 패스
		 */
        if ($mb_id == $config['cf_admin'] || $mb_level == $mb_prev_level) continue;

		/**
		 * 대상 그누레벨이 1이라면 회원탈퇴 처리
		 */
		if ($mb_level == 1) {
			$leave_mb_id[$rm] = $mb_id;
			$rm++;
		} else if ($mb_level > 1) {
			/**
			 * 탈퇴된 계정을 정상 계정으로 부활
			 */
			if ($mb_prev_level == 1) {
				$recover_mb_id[$rc] = $mb_id;
				$rc++;
			}
			
			/**
			 * 이전 그누레벨과 대상 그누레벨의 차이
			 */
			$level_min_point['set_level'] = $eb->get_level_point_from_gnulevel($mb_level);
			$level_min_point['old_level'] = $eb->get_level_point_from_gnulevel($mb_prev_level);
			
			$eyoom_point = $level_point + ($level_min_point['set_level'] - $level_min_point['old_level']);
			$eyoom_level = $eb->get_eyoomlevel_from_point($eyoom_point);
			
			// 이윰 멤버 테이블에 적용
			$sql = "update {$g5['eyoom_member']} set level = '{$eyoom_level}', level_point = '{$eyoom_point}' where mb_id = '{$mb_id}' ";
			sql_query($sql);
			
			// 그누레벨 적용
			$sql = "update {$g5['member_table']} set mb_level = '{$mb_level}' where mb_id = '{$mb_id}' ";
			sql_query($sql);
		}
		
		// 해당 회원 자동 탈퇴처리
		if ($rm) {
			$sql = "update {$g5['member_table']} set mb_leave_date = '" . G5_TIME_YMDHIS ."' where find_in_set(mb_id, '".implode(',', $leave_mb_id)."') ";
			sql_query($sql);
		}
		
		// 해당 회원 자동 부활
		if ($rm) {
			$sql = "update {$g5['member_table']} set mb_leave_date = '' where find_in_set(mb_id, '".implode(',', $leave_mb_id)."') ";
			sql_query($sql);
		}
		
    }
    $msg = "정상적으로 수정하였습니다.";

} else {
	alert("잘못된 접근입니다.");
}

alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=member_list&amp;'.$qstr);