<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit; // 개별 페이지 접근 불가

// 폼전송 모드일 때 출력 방지
if ($smode) return;

// PC/모바일 링크 생성
$href = $thema->get_href($tpl_name);

$print_version = (defined('G5_IS_SHOP_ADMIN_PAGE') && defined('G5_YOUNGCART_VER')) ? 'Cart Version '.G5_YOUNGCART_VER : 'Version '.G5_GNUBOARD_VER;

// 템플릿에 변수 할당
@include_once(EYOOM_ADMIN_INC_PATH.'/atpl.assign.php');

// 템플릿 출력
$atpl_tail = 'tail_' . $tpl_name;
$atpl->print_($atpl_tail);