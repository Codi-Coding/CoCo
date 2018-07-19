<?php
if (!defined('_GNUBOARD_')) exit;

include_once(EYOOM_CLASS_PATH.'/Template_/Template_.class.php');
include_once(EYOOM_CLASS_PATH.'/qfile.class.php');
include_once(EYOOM_CLASS_PATH.'/theme.class.php');
include_once(EYOOM_CLASS_PATH.'/eyoom.class.php');
include_once(EYOOM_CLASS_PATH.'/upload.class.php');
include_once(EYOOM_CLASS_PATH.'/latest.class.php');
include_once(EYOOM_CLASS_PATH.'/language.class.php');
include_once(EYOOM_CLASS_PATH.'/shop.class.php');

// 클래스 오브젝트 생성
$qfile	= new qfile;
$thema	= new theme;
$eb		= new eyoom;
$upload	= new upload;
$latest	= new latest;
$mlang	= new language;
$shop	= new shop($theme,$eyoom,$tpl_name,$tpl);