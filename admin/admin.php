<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

// 관리자 공통설정 파일
@include_once(EYOOM_ADMIN_PATH.'/admin.common.php');

// 관리자 헤더 디자인 출력
@include_once(EYOOM_ADMIN_PATH.'/admin.head.php');

// 관리자 기능 페이지 로딩
@include_once(EYOOM_ADMIN_PATH.'/admin.index.php');

// 관리자 테일 디자인 출력
@include_once(EYOOM_ADMIN_PATH.'/admin.tail.php');