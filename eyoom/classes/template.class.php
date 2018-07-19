<?php
class Template extends Template_
{
	public $compile_check	= true;
	public $compile_ext		= 'php';
	public $compile_key		= '';
	public $skin			= '';
	public $def_skin		= 'basic';
	public $notice			= false;
	public $path_digest		= false;

	public $prefilter		= 'adjustPath';
	public $postfilter		= 'removeTmpCode';
	public $permission		= 0777;
	public $safe_mode		= false;
	public $auto_constant	= false;

	public $caching			= true;
	public $cache_expire	= 0;

	// 템플릿 환경설정 및 기본 템플릿 파일 정의하기
	public function __construct($skin='') {
		global $default,$config,$member,$group,$g5,$mb,$eyoom, $eb;
		if($skin) $this->skin = $skin; else $this->skin = $this->def_skin;
		$this->eb = $eb;

		// 템플릿 기본설정
		$this->template_dir	= EYOOM_PATH."/theme";
		$this->compile_dir	= G5_DATA_PATH."/_complie";
		$this->cache_dir	= G5_DATA_PATH."/_cache";
		$this->prefilter	= 'adjustPath';
		$this->cfg			= $eyoom;

		//  템플릿 파일 정의
		$this->define(array(
			'head_pc'	=> 'layout/head_pc.html',
			'head_mo'	=> 'layout/head_mo.html',
			'head_bs'	=> 'layout/head_bs.html',
			'tail_pc'	=> 'layout/tail_pc.html',
			'tail_mo'	=> 'layout/tail_mo.html',
			'tail_bs'	=> 'layout/tail_bs.html',
			'side_pc'	=> 'layout/side_pc.html',
			'side_mo'	=> 'layout/side_mo.html',
			'side_bs'	=> 'layout/side_bs.html',
			'tail_sub'	=> 'layout/tail_sub.html',
			'switcher'	=> 'layout/switcher.html',
			'index_pc'	=> 'main/index_pc.html',
			'index_mo'	=> 'main/index_mo.html',
			'index_bs'	=> 'main/index_bs.html',
			'misc_pc'	=> 'layout/misc_pc.html',
			'misc_mo'	=> 'layout/misc_mo.html',
			'misc_bs'	=> 'layout/misc_bs.html',
		));

		// 중요변수 기본할당
		$this->assign(array(
			'default'	=>	$default,
			'config'	=>	$config,
			'member'	=>	$member,
			'group'		=>	$group,
			'mb'		=>	$mb,
			'eyoom'		=>	$eyoom,
		));
	}

	// 사용자정의 템플릿 정의
	public function define_template($folder,$skin,$skin_name) {
		$this->define(array(
			'pc' => 'skin_pc/' . $folder . '/' . $skin . '/' . $skin_name,
			'mo' => 'skin_mo/' . $folder . '/' . $skin . '/' . $skin_name,
			'bs' => 'skin_bs/' . $folder . '/' . $skin . '/' . $skin_name,
		));
	}

	// 마이크로 타임 얻기
	public function getMicroTime() {
		$time	= explode(" ", microtime());
		$usec	= (double)$time[0];
		$sec	= (double)$time[1];
		return $sec + $usec;
	}

	// 영카트5를 이윰파일로 컨트롤 하기
	public function eyoom_control() {
		$path = $this->get_filename_from_url();
		$file = EYOOM_SHOP_PATH.'/'.$path['filename'];
		return $this->check_shopfile($file);
	}

	// 파일이 있는지 검사
	protected function check_shopfile($file) {
		if ($file) {
			if(file_exists($file)) {
				return $file;
			}
		} else return false;
	}

	// 파일 후킹 - 이윰빌더로 강제 파일 지정하기
	public function exchange_file() {
		global $is_admin, $eyoom;

		$path = $this->get_filename_from_url();

		// 게시물 이동/복사 - File Hooking
		if($is_admin && $this->pattern_match_url("/bbs\/move/i")) {
			return EYOOM_CORE_PATH.'/board/'.$path['filename'];
		}
		// 그룹 최근게시물 - File Hooking
		if($this->pattern_match_url("/bbs\/group/i")) {
			return EYOOM_CORE_PATH.'/board/'.$path['filename'];
		}
		// SNS 연동
		if($this->pattern_match_url("/bbs\/sns_send/i")) {
			return EYOOM_CORE_PATH.'/board/'.$path['filename'];
		}
		// 새글삭제하기 - File Hooking
		if($this->pattern_match_url("/bbs\/new_delete/i")) {
			return EYOOM_CORE_PATH.'/new/'.$path['filename'];
		}
		// 쪽지보내기 기능 - File Hooking
		if($this->pattern_match_url("/bbs\/memo_form_update/i")) {
			return EYOOM_CORE_PATH.'/member/'.$path['filename'];
		}
		// 이메일 보내기 기능 - File Hooking
		if($this->pattern_match_url("/bbs\/register_email/i")) {
			return EYOOM_CORE_PATH.'/member/'.$path['filename'];
		}
		// 설문조사 결과보기 기능 - File Hooking
		if($this->pattern_match_url("/bbs\/poll_result/i") && $eyoom['use_gnu_poll'] == 'n') {
			return EYOOM_CORE_PATH.'/poll/'.$path['filename'];
		}
	}

	// URL로 부터 파일명 추출
	public function get_filename_from_url() {
		global $eb;
		
		$file_tmp = explode("/",$_SERVER['SCRIPT_NAME']);
		$cnt = count($file_tmp);
		$path['dirname'] 	= $file_tmp[($cnt-2)];
		$path['filename'] 	= $file_tmp[($cnt-1)];

		return $path;
	}

	// 지정된 패턴과 일치여부 체크
	private function pattern_match_url($pattern) {
		if(preg_match($pattern, $_SERVER['SCRIPT_NAME'])) {
			return true;
		} else return false;
	}
}