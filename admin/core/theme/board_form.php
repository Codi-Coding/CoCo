<?php
$sub_menu = "800200";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=board_form_update&amp;smode=1';

/**
 * 텝메뉴 앵커 설정
 */
$anchor_skin = "skin_bs/theme/basic/board_form_anchor.skin.html";
adm_pg_anchor('anc_bo_common', 		$anchor_skin);
adm_pg_anchor('anc_bo_blind', 		$anchor_skin);
adm_pg_anchor('anc_bo_rating', 		$anchor_skin);
adm_pg_anchor('anc_bo_tag', 		$anchor_skin);
adm_pg_anchor('anc_bo_automove', 	$anchor_skin);
adm_pg_anchor('anc_bo_addon', 		$anchor_skin);
adm_pg_anchor('anc_bo_cmtbest', 	$anchor_skin);
adm_pg_anchor('anc_bo_exif', 		$anchor_skin);
adm_pg_anchor('anc_bo_cmtpoint', 	$anchor_skin);
adm_pg_anchor('anc_bo_adopt', 		$anchor_skin);

/**
 * 이윰 게시판 스킨
 */
$bo_skin = $eb->get_skin_dir('board',EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);

/**
 * 태그 작성 레벨은 글쓰기 권한의 레벨과 같거나 높아야 함
 */
if(!isset($eyoom_board['bo_tag_level']) || $eyoom_board['bo_tag_level'] < $board['bo_write_level']) $eyoom_board['bo_tag_level'] = $board['bo_write_level'];

/**
 * EXIF 상세설정값
 */
if(!$eyoom_board['bo_exif_detail']) {
	$exif_detail = $exif->get_exif_default();
} else {
	$exif_detail = unserialize(stripslashes($eyoom_board['bo_exif_detail']));
}

$i=0;
foreach($exif_item as $key => $val) {
	$exif_data[$i]['key'] 		= $key;
	$exif_data[$i]['entity'] 	= $val;
	$exif_data[$i]['item'] 		= $exif_detail[$key]['item'];
	$exif_data[$i]['use'] 		= $exif_detail[$key]['use'];
	$i++;
}

/**
 * 버튼셋
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= ' <a href="' . EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=board_list&amp;page='.$page.'&amp;thema='.$this_theme.'" class="btn-e btn-e-lg btn-e-dark">목록</a> ';
if ($w == 'u') {
	$frm_submit .= ' <a href="'.G5_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'&amp;theme='.$this_theme.'" class="btn-e btn-e-lg btn-e-dark">게시판 바로가기</a> ';
}
$frm_submit .= '</div>';

$atpl->assign(array(
	'bo_skin' 		=> $bo_skin,
	'eyoom_board' 	=> $eyoom_board,
	'frm_submit' 	=> $frm_submit,
	'bo_automove' 	=> $bo_automove,
	'binfo' 		=> $binfo,
	'exif_data' 	=> $exif_data,
));