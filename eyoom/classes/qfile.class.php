<?php
class qfile
{
	public function __construct() {
		$this->tmp_path	= G5_DATA_PATH . '/tmp';
		
		// eyoom3 테마체크 URL 정의
		define('EYOOM3_SITE','http://eyoom.net');
		define('EYOOM3_AJAX_URL', EYOOM3_SITE.'/eyoom/eyoom3.ajax.php');
	}

	// 파일 확장자 가져오기
	public function get_file_ext($filename) {
		$temp = explode(".",$filename);
		return $temp[count($temp) - 1];
	}

	// 배열을 지정한 파일로 저장 - 폴더에 웹서버의 쓰기 권한이 있어야 함
	public function save_file($outvar, $filename, $info=array(), $int=false) {
		$fp = @fopen($filename, 'w');
		$contents  = "<?php\n";
		$contents .= "\tif (!defined('_GNUBOARD_')) exit;\n";
		$contents .= "\t\$" . $outvar . " = array(\n";
		if($info != NULL) {
			foreach($info as $key => $value) {
				if(!is_array($value)) {
					// 키값으로 정수를 허용하지 않는다면
					if(!$int) {
						if(!is_int($key)) {
							$contents .= "\t\t\"" . $key . "\" => \"" . addslashes($value) . "\",\n";
						}
					} else $contents .= "\t\t\"" . $key . "\" => \"" . addslashes($value) . "\",\n";
				} else {
					$arr = '';
					foreach($value as $k => $v) {
						if(!$int) {
							if(!is_int($key)) {
								$arr .= "\"" . $k . "\" => \"" . addslashes($v) . "\","; 
							}
						} else $arr .= "\"" . $k . "\" => \"" . addslashes($v) . "\","; 
					}
					if($arr) {
						$arr = substr($arr,0,-1);
						$contents .= "\t\t\"" . $key . "\" => array(" . $arr . "),\n";
					}
				}
			}
		}
		
		$contents .= "\t);\n";
		$contents .= "?>";
		@fwrite($fp, $contents);
		@fclose($fp);
		@chmod($filename, 0644);
	}

	// 지정한 파일 삭제하기
	public function del_file($filename) {
		if(file_exists($filename)) {
			unlink($filename);
			return false;
		}
	}
	
	// 테마파일 삭제하기
	public function del_tmfile($filename) {
		global $g5, $tm;
		if(!$this->del_file($filename)) {
			$sql = "update {$g5['eyoom_theme']} set tm_name='{$tm['tm_name']}' where tm_code='{$tm['tm_code']}'";
			sql_query($sql,false);
			return false;
		}
	}

	// 특정폴더에 있는 파일 중 일정시간(초)이 지난 파일만 삭제하기
	public function del_timeover_file($path,$second=3600,$match='') {
		if(is_dir($path)) {
			$dir = @dir($path);
			$now = time();

			while($entry = $dir->read()) {
				if ($entry == "." || $entry == ".." || is_dir($entry) || ($match && !preg_match("/".$match."/",$entry))) continue;
				else {
					unset($ctime);
					$file = $path . "/" . $entry;
					$ctime = filectime($file);
					if(($now-$ctime)>$second) @unlink($file);
				}
			}
		}
	}

	// 특정폴더에 있는 모든 파일 및 폴더 삭제하기
	public function del_all_file($path) {
		$dir = opendir($path);
		while (false !== ($filename = readdir($dir))) {
			if($filename == "." || $filename == "..") continue;
			$dest = $path.'/'.$filename;
			if (is_dir($dest)) {
				$this->del_all_file($dest);
				@rmdir($dest);
			} else {
				@unlink($dest);
			}
		}
		@rmdir($path);
	}

	// 디렉토리 전체 복사 - 하위 디렉토리 및 파일까지 모두
	// system(), exec() shell_exec() 등이 웹호스팅 환경에 따라 실행이 안되는 경우를 위해 
	public function copy_dir($src_dir, $dest_dir) {
		if($src_dir == $dest_dir) return false;
		if(!is_dir($src_dir)) return false;
		if(!is_dir($dest_dir)) {
			@mkdir($dest_dir, 0707);
			@chmod($dest_dir, 0707);
		}

		$dir = opendir($src_dir);
		while (false !== ($filename = readdir($dir))) {
			if($filename == "." || $filename == "..") continue;
			$files[] = $filename;
		}

		for($i=0; $i<count($files); $i++) {
			$src_file = $src_dir.'/'.$files[$i];
			$dest_file = $dest_dir.'/'.$files[$i];
			if(is_file($src_file)) {
				copy($src_file, $dest_file);
				@chmod($dest_file, 0707);
			}
			if(is_dir($src_file)) {
				$this->copy_dir($src_file, $dest_file);
			}
		}
	}
}