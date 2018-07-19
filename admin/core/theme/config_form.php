<?php
$sub_menu = '800100';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

/**
 * 폼 action url
 */
$action_url = EYOOM_ADMIN_URL . "/?dir=theme&amp;pid=config_form_update&amp;smode=1";

/**
 * 앵커버튼
 */
$anchor_config = "skin_bs/theme/basic/config_form_anchor.skin.html";
adm_pg_anchor('anc_cf_domain', 		$anchor_config);
adm_pg_anchor('anc_cf_alias', 		$anchor_config);
adm_pg_anchor('anc_cf_skin', 		$anchor_config);
adm_pg_anchor('anc_cf_func', 		$anchor_config);
adm_pg_anchor('anc_cf_layout', 		$anchor_config);
adm_pg_anchor('anc_cf_tag', 		$anchor_config);

/**
 * submit 버튼
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= ' <a href="' . G5_URL . '" class="btn-e btn-e-lg btn-e-dark">메인으로</a> ';
$frm_submit .= '</div>';

/**
 * 스킨 디렉토리 읽어오기
 */
$skins['outlogin'] 	= $eb->get_skin_dir('outlogin', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['connect'] 	= $eb->get_skin_dir('connect', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['popular'] 	= $eb->get_skin_dir('popular', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['poll'] 		= $eb->get_skin_dir('poll', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['visit'] 	= $eb->get_skin_dir('visit', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['new'] 		= $eb->get_skin_dir('new', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['member'] 	= $eb->get_skin_dir('member', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['faq'] 		= $eb->get_skin_dir('faq', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['qa'] 		= $eb->get_skin_dir('qa', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['search'] 	= $eb->get_skin_dir('search', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['shop'] 		= $eb->get_skin_dir('shop', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['newwin'] 	= $eb->get_skin_dir('newwin', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['mypage'] 	= $eb->get_skin_dir('mypage', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['signature'] = $eb->get_skin_dir('signature', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['respond'] 	= $eb->get_skin_dir('respond', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['push'] 		= $eb->get_skin_dir('push', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);
$skins['tag'] 		= $eb->get_skin_dir('tag', EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);

/**
 * 아이콘 폴더
 */
$icons['gnuboard']	= $eb->get_skin_dir('gnuboard', EYOOM_THEME_PATH.'/'.$this_theme.'/image/level_icon');
$icons['eyoom']		= $eb->get_skin_dir('eyoom', EYOOM_THEME_PATH.'/'.$this_theme.'/image/level_icon');

$atpl->assign(array(
	'frm_submit' 	=> $frm_submit,
	'eyoom_config' => $_eyoom,
	'skins' => $skins,
	'icons' => $icons,
));