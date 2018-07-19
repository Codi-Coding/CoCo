<?php
class language extends qfile
{
	public $language;
	public $alert_file;
	public $theme_file;

	public function __construct() {
	}

	// 들어온 메세지를 번역된 언어로 변경
	public function alert_message($msg,$lang) {
		global $theme, $lang_alert;
		$code = trim($this->get_langcode($msg));
		$alert_file	= G5_DATA_PATH.'/language/alert.'.$lang.'.php';
		if(file_exists($alert_file)) {
			if($code) {
				return $lang_alert[$code];
			} else {
				// 이곳에 상세비교 코딩이 있어야 할 부분
				return false;
			}
		} else return false;
	}

	// 입력된 메세지를 CODE로 변환
	protected function get_langcode($msg) {
		global $theme;
		$alert_kr_file	= G5_DATA_PATH.'/language/alert.kr.php';
		if(file_exists($alert_kr_file)) {
			include($alert_kr_file);
			return array_search($msg, $lang_alert);
		} else return false;
	}
}