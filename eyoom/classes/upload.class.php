<?php
class upload extends qfile
{
	public $path = '';

	public function __construct() { }

	private function check_directory() {
		$path = $this->path;
		if(!@is_dir($path)) {
			@mkdir($path, G5_DIR_PERMISSION);
			@chmod($path, G5_DIR_PERMISSION);
		}
	}

	// 이미지 업로드 함수
	public function upload_image($key) {
		$this->check_directory();
		if (is_uploaded_file($_FILES[$key]['tmp_name'])) {
			$permit = array("jpg","gif","png","jpeg");
			$ext = strtolower($this->get_file_ext($_FILES[$key]['name']));
			if (!in_array($ext,$permit)) {
				alert($_FILES[$key]['name'] . '은(는) jpg/jpeg/gif/png 파일이 아닙니다.');
			} else {
				$filename = md5(time().$_FILES[$key]['name']);

				$dest_file = $this->path.$filename.'.'.$ext;
				move_uploaded_file($_FILES[$key]['tmp_name'], $dest_file);
				chmod($dest_file, G5_FILE_PERMISSION);
				$info['o_name'] = $_FILES[$key]['tmp_name'];
				$info['c_name'] = $filename.'.'.$ext;
				$info['d_file'] = $dest_file;
				$info['ext'] 	= $ext;
				return $info;
			}
		} else return false;
	}

	/*
		$thumb[width] = 가로;
		$thumb[height] = 세로;
		$thumb[delete] = y or n; //$dest_file 삭제여부
	*/
	public function upload_make_thumb($key, $thumb=array()) {
		$this->check_directory();
		$upload = $this->upload_image($key);
		if(!$upload) return false;
		
		if (file_exists($upload['d_file'])) {
			$size = getimagesize($upload['d_file']);
			switch ($size['mime']) {
				case "image/jpeg"	: $source = @imagecreatefromjpeg($upload['d_file']); break;
				case "image/gif"	: $source = @imagecreatefromgif($upload['d_file']); break;
				case "image/png"	: $source = @imagecreatefrompng($upload['d_file']); break;
			}
			$width = $thumb['width'];
			if(!$thumb['height']) {
				$height = $width*($size[1]/$size[0]);
			} else {
				$height = $thumb['height'];
			}
			
			$dest = @imagecreatetruecolor($width, $height);
			$out_name = md5($upload['c_name']).'.'.$upload['ext'];
			$out_file = $this->path.$out_name;
			@imagecopyresampled($dest, $source, 0, 0, 0, 0, $width , $height, $size[0], $size[1]);
			
			// 사진의 방향정보를 활용하여 회전하기
		    $exif = exif_read_data($upload['d_file']);
		    if(!empty($exif['Orientation'])) {
		        switch($exif['Orientation']) {
		            case 8: $dest = imagerotate($dest,90,0); break;
		            case 3: $dest = imagerotate($dest,180,0); break;
		            case 6: $dest = imagerotate($dest,-90,0);  break;
		        }
		    }
		    
		    // 이미지 타입에 따라 처리
	        if ($upload['ext'] == "jpg" || $upload['ext'] == "jpeg") {
	            @imagejpeg($dest, $out_file);
	        } else if ($upload['ext'] == "png") {
	            @imagepng($dest, $out_file);
	        } else if ($upload['ext'] == "bmp" || $upload['ext'] == "wbmp") {
	            @imagewbmp($dest, $out_file);
	        } else if ($upload['ext'] == "gif") {
	            @imagegif($dest, $out_file);
	        }
			@imagedestroy($dest);
			@imagedestroy($source);
			if($thumb['delete'] == 'y')	@unlink($upload['d_file']);
			$upload['t_file'] = $out_file;
			$upload['f_name'] = $out_name;
			
			return $upload;

		} else return false;
	}
}