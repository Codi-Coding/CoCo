<?php
if (!defined('_GNUBOARD_')) exit;

@ini_set('memory_limit', '-1');

// 게시글리스트 썸네일 생성
function get_list_thumbnail($bo_table, $wr_id, $thumb_width, $thumb_height, $is_create=false, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3')
{
    global $g5, $config;
    $filename = $alt = "";
    $edt = false;

    $sql = " select bf_file, bf_content from {$g5['board_file_table']}
                where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_type between '1' and '3' order by bf_no limit 0, 1 ";
    $row = sql_fetch($sql);

    if($row['bf_file']) {
        $filename = $row['bf_file'];
        $filepath = G5_DATA_PATH.'/file/'.$bo_table;
        $alt = get_text($row['bf_content']);
    } else {
        $write_table = $g5['write_prefix'].$bo_table;
        $sql = " select wr_content from $write_table where wr_id = '$wr_id' ";
        $write = sql_fetch($sql);
        $matches = get_editor_image($write['wr_content'], false);
        $edt = true;

        for($i=0; $i<count($matches[1]); $i++)
        {
            // 이미지 path 구함
            $p = @parse_url($matches[1][$i]);
            if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
                $data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
            else
                $data_path = $p['path'];

            $srcfile = G5_PATH.$data_path;

            if(preg_match("/\.({$config['cf_image_extension']})$/i", $srcfile) && is_file($srcfile)) {
                $size = @getimagesize($srcfile);
                if(empty($size))
                    continue;

                $filename = basename($srcfile);
                $filepath = dirname($srcfile);

                preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
                $alt = get_text($malt[1]);

                break;
            }
        }
    }

    if(!$filename)
        return false;

    $tname = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

    if($tname) {
        if($edt) {
            // 오리지날 이미지
            $ori = G5_URL.$data_path;
            // 썸네일 이미지
            $src = G5_URL.str_replace($filename, $tname, $data_path);
        } else {
            $ori = G5_DATA_URL.'/file/'.$bo_table.'/'.$filename;
            $src = G5_DATA_URL.'/file/'.$bo_table.'/'.$tname;
        }
    } else {
        return false;
    }

    $thumb = array("src"=>$src, "ori"=>$ori, "alt"=>$alt);

    return $thumb;
}

// Exif 출력정보 생성
function apms_get_view_exif($exif, $srcfile, $txt) {

	if(empty($exif)) return;

	$list = array();

	if(isset($exif['Model']) && $exif['Model']) {
		$list[] = astxt($txt['model'], array($exif['Model'])); //카메라모델명
	}

	if(isset($exif['LensModel']) && $exif['LensModel']) {
		$list[] = astxt($txt['lensmodel'], array($exif['LensModel'])); //렌즈모델
	} else if(isset($exif['UndefinedTag:0xA434']) && $exif['UndefinedTag:0xA434']) {
		$list[] = astxt($txt['lensmodel'], array($exif['UndefinedTag:0xA434'])); //렌즈모델
	} else if(isset($exif['LensInfo']) && $exif['LensInfo']) {
		$list[] = astxt($txt['lensinfo'], array($exif['LensInfo'])); //렌즈정보
	}

	if(isset($exif['DateTimeOriginal']) && $exif['DateTimeOriginal']) {
		$list[] = astxt($txt['datetime'], array($exif['DateTimeOriginal'])); //촬영일시
	}

	if(isset($exif['ExposureProgram'])) {
		switch($exif['ExposureProgram']) {
			case '0'	: $expomode = $txt['exposure1']; break; //자동모드
			case '1'	: $expomode = $txt['exposure2']; break; //수동모드
			case '2'	: $expomode = $txt['exposure3']; break; //프로그램모드
			case '3'	: $expomode = $txt['exposure4']; break; //조리개모드
			case '4'	: $expomode = $txt['exposure5']; break; //셔터스피드모드
			default		: $expomode = ''; break; //Unknown
		}
		if($expomode) {
			$list[] = astxt($txt['exposure'], array($expomode)); //촬영모드
		}
	}

	if(isset($exif['ExposureTime']) && $exif['ExposureTime']) {
		$list[] = astxt($txt['expostime'], array($exif['ExposureTime'])); //셔터속도
	}

	if(isset($exif['COMPUTED']['ApertureFNumber']) && $exif['COMPUTED']['ApertureFNumber']) {
		$list[] = astxt($txt['aperture'], array($exif['COMPUTED']['ApertureFNumber'])); //조리개
	}

	if(isset($exif['ISOSpeedRatings']) && $exif['ISOSpeedRatings']) {
		$list[] = astxt($txt['iso'], array($exif['ISOSpeedRatings'])); //ISO
	}

	if(isset($exif['WhiteBalance'])) {
		switch($exif['WhiteBalance']) {
			case '0'	: $whitebal = $txt['whitebal1']; break; //Auto
			case '1'	: $whitebal = $txt['whitebal2']; break; //Manual
			default		: $whitebal = ''; break; //Unknown
		}
		if($whitebal) {
			$list[] = astxt($txt['whitebal'], array($whitebal)); //화이트밸런스
		}
	}

	if(isset($exif['MeteringMode'])) {
		switch($exif['MeteringMode']) {
			case '0'	: $metering = ''; break; //Unknown
			case '1'	: $metering = $txt['metering1']; break; //Average
			case '2'	: $metering = $txt['metering2']; break; //Center weighted averaget
			case '3'	: $metering = $txt['metering3']; break; //Spot
			case '4'	: $metering = ''; break; //Unknown
			case '5'	: $metering = $txt['metering4']; break; //Multi Segment
			case '6'	: $metering = $txt['metering5']; break; //Partial
			default		: $metering = ''; break; //Unknown
		}
		if($metering) {
			$list[] = astxt($txt['metering'], array($metering)); //측광모드
		}
	}

	if(isset($exif['ExposureBiasValue']) && $exif['ExposureBiasValue']) {
		list($expobias1, $expobias2) = explode("/", $exif['ExposureBiasValue']);
		if($expobias2 > 0) {
			$expobias = ($expobias1 / $expobias2);
			$list[] = astxt($txt['ev'], array(sprintf("%2.2f" , $expobias))); //노출보정
		}
	}

	if(isset($exif['FocalLength']) && $exif['FocalLength']) {
		list($focal1, $focal2) = explode("/", $exif['FocalLength']);
		if($focal2 > 0) {
			$list[] = astxt($txt['focal'], array(round($focal1 / $focal2))); //초점거리
		}
	}

	if(isset($exif['FocalLengthIn35mmFilm']) && $exif['FocalLengthIn35mmFilm']) {
		$list[] = astxt($txt['35mm'], array($exif['FocalLengthIn35mmFilm'])); //35mm풀프레임환산 초점거리
	}

	if(isset($exif['Flash'])) {
		switch($exif['Flash']) {
			case '16'	: $flash = $txt['flash1']; break; //Off Compulsory
			case '73'	: $flash = $txt['flash2']; break; //On Compulsory Red-eye reduction
			case '9'	: $flash = $txt['flash3']; break; //On Compulsory
			case '7'	: $flash = $txt['flash4']; break; //On
			default		: $flash = ''; break;
		}
		if($flash) {
			$list[] = astxt($txt['flash'], array($flash)); //플래시
		}
	}

	// Exif
	$exif_item = '';
	$list_cnt = count($list);
	for($i=0; $i < $list_cnt; $i++) {
		
		if(!$list[$i]) continue;

		$exif_item .= '<li>'.$list[$i].'</li>'.PHP_EOL;
	}

	//출력
	$exif_list = '';
	if($exif_item) {

		// IPTC
		$picinfo = array();
		@getimagesize($srcfile, $picinfo); 

		$iptc_item = '';
		if(isset($picinfo['APP13'])) {
			$iptc = iptcparse($picinfo['APP13']);
			if (is_array($iptc)) { 
				$title = $iptc['2#005'][0];
				$description = $iptc['2#120'][0];
				$date = $iptc['2#055'][0];
				if($date) {
					$year = substr($date, 0, 4);
					$month = substr($date, 4, 2);
					$day = substr($date, -2);
					//$datetaken = date('l F jS Y', mktime(0, 0, 0, $month, $day, $year));
					$date = date($txt['datetype'], mktime(0, 0, 0, $month, $day, $year));
					$date = astxt($txt['date'], array($date));
				}
				$city = $iptc["2#090"][0];
				$country = $iptc["2#101"][0];
				$creator = $iptc["2#080"][0];
				$tag = (isset($iptc["2#025"]) && !empty($iptc["2#025"])) ? implode(', ', $iptc["2#025"]) : '';

				if($title) { //타이틀
					$iptc_item .= '<li>'.astxt($txt['title'], array($title)).'</li>'.PHP_EOL;
				}

				if($description) { //설명
					$iptc_item .= '<li>'.astxt($txt['desc'], array($description)).'</li>'.PHP_EOL;
				}

				if($creator) { //크리에이터
					$iptc_item .= '<li>'.astxt($txt['creator'], array($creator, $date)).'</li>'.PHP_EOL;
				}

				if($tag) { //태그
					$iptc_item .= '<li>'.astxt($txt['tag'], array($tag)).'</li>';
				}
			}
		}

		$exif_list .= '<div class="exif-data">'.PHP_EOL;
		if($iptc_item) { //IPTC INFO
			$exif_list .= '<ul class="iptc-list">'.PHP_EOL;
			$exif_list .= $iptc_item;
			$exif_list .= '</ul>'.PHP_EOL;
		}
		$exif_list .= '<ul class="exif-list">'.PHP_EOL;
		$exif_list .= $exif_item;
		$exif_list .= '</ul>'.PHP_EOL;
		$exif_list .= '</div>'.PHP_EOL;
	}

	return $exif_list;
}

// 게시글보기 썸네일 생성
function get_view_thumbnail($contents, $thumb_width=0)
{
    global $board, $config;

    if (!$thumb_width)
        $thumb_width = $board['bo_image_width'];

    // $contents 중 img 태그 추출
    $matches = get_editor_image($contents, true);

    if(empty($matches))
        return $contents;

	// Exif
	$exif = array();

	$is_exif = false;
	if(isset($board['as_exif']) && $board['as_exif']) {
		$extxt = load_aslang('exif');
		$is_exif = true;
	}

	// View Original
	$is_view = (isset($board['as_lightbox']) && $board['as_lightbox']) ? $board['as_lightbox'] : 0;
	
	// Lightbox
	if($is_view == "1" || $is_view == "3") {
		apms_script('lightbox');
	}

    for($i=0; $i<count($matches[1]); $i++) {

		$img_tag = $matches[0][$i];
        $img = $matches[1][$i];

        preg_match("/src=[\'\"]?([^>\'\"]+[^>\'\"]+)/i", $img, $m);
        $src = $m[1];
        preg_match("/style=[\"\']?([^\"\'>]+)/i", $img, $m);
        $style = $m[1];

		//높이는 체크안함
		preg_match("/width:\s*(\d+)px/", $style, $m);
        $width = $m[1];
		if(!$width) {
			preg_match("/width=[\"\']?([^\"\'>]+)/i", $img, $m);
			$width = $m[1];
		}
		preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $img, $m);
        $alt = get_text($m[1]);
		if($is_view == "4") { //사용안함
		    $link = 1;
		} else {
			preg_match("/link=[\"\']?([^\"\']*)[\"\']?/", $img, $m); // APMS 추가
		    $link = get_text($m[1]);
		}
		preg_match("/align=[\"\']?([^\"\']*)[\"\']?/", $img, $m); // APMS 추가
        $align = get_text($m[1]);
        preg_match("/class=[\"\']?([^\"\']*)[\"\']?/", $img, $m); // APMS 추가
        $class = get_text($m[1]);

		// 이미지 속성정리
		$img_attr = '';
		if($align) $img_attr .= ' align="'.$align.'"';
		if($width) $img_attr .= ' style="width:'.$width.'px;"';

        // 이미지 path 구함
        $p = @parse_url($src);
        if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
            $data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
        else
            $data_path = $p['path'];

        $srcfile = G5_PATH.$data_path;

		$itemprop = ($i == 0) ? ' itemprop="image" content="'.$src.'"' : '';

		// Exif
		unset($exif);
		$exif_info = '';

        if(is_file($srcfile)) {
            $size = @getimagesize($srcfile);
            if(empty($size))
                continue;

            // jpg 이면 exif 체크
            if($size[2] == 2 && function_exists('exif_read_data')) {
                $degree = 0;
                $exif = @exif_read_data($srcfile);
                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                        case 8:
                            $degree = 90;
                            break;
                        case 3:
                            $degree = 180;
                            break;
                        case 6:
                            $degree = -90;
                            break;
                    }

                    // 세로사진의 경우 가로, 세로 값 바꿈
                    if($degree == 90 || $degree == -90) {
                        $tmp = $size;
                        $size[0] = $tmp[1];
                        $size[1] = $tmp[0];
                    }
                }

				// Exif 정보 체크
				if($is_exif) {
					$exif_info = apms_get_view_exif($exif, $srcfile, $extxt);
				}
			}

            // 원본 width가 thumb_width보다 작다면 썸네일생성 안함
            if($size[0] <= $thumb_width) {

				$thumb_tag = '<img'.$itemprop.' src="'.$src.'" alt="'.$alt.'" class="img-tag '.$class.'"'.$img_attr.'/>';

				// 원본이 600보다 클 경우 $img_tag에 editor 경로가 있으면 원본보기 링크 추가
				if(!$link && $size[0] > 600 && preg_match("/\.({$config['cf_image_extension']})$/i", basename($srcfile))) {
					if($is_view == "1" || $is_view == "3") {
						$caption = ($alt) ? ' data-title="'.$alt.'"' : '';
						$thumb_tag = '<a href="'.$src.'" data-lightbox="view-lightbox"'.$caption.' target="_blank">'.$thumb_tag.'</a>';
					} else if (strpos($img_tag, G5_DATA_DIR.'/'.G5_EDITOR_DIR) || strpos($img_tag, G5_DATA_DIR.'/file')) {
						$thumb_tag = '<a href="'.G5_BBS_URL.'/view_image.php?fn='.urlencode(str_replace(G5_URL, "", $src)).'" target="_blank" class="view_image">'.$thumb_tag.'</a>';
					} else {
						$thumb_tag = '<a href="'.G5_BBS_URL.'/view_img.php?img='.urlencode($src).'" target="_blank" class="view_image">'.$thumb_tag.'</a>';
					}
				}

				// Exif 정보출력
				if($exif_info) {
					$thumb_tag = '<div class="img-exif">'.$thumb_tag.''.$exif_info.'</div>'.PHP_EOL;
				}

				$contents = str_replace($img_tag, $thumb_tag, $contents);

				continue;
			}

            // Animated GIF 체크
            $is_animated = false;
            if($size[2] == 1) {
                $is_animated = is_animated_gif($srcfile);
            }

            // 썸네일 높이
            $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
            $filename = basename($srcfile);
            $filepath = dirname($srcfile);

            // 썸네일 생성
            if(!$is_animated)
                $thumb_file = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, false);
            else
                $thumb_file = $filename;

            if(!$thumb_file)
                $thumb_file = $filename;

			// 이미지
			$thumb_tag = '<img'.$itemprop.' src="'.G5_URL.str_replace($filename, $thumb_file, $data_path).'" alt="'.$alt.'" class="img-tag '.$class.'"'.$img_attr.'/>';

            // 원본이 600보다 클 경우 $img_tag에 editor 경로가 있으면 원본보기 링크 추가
			if(!$link && $size[0] > 600 && preg_match("/\.({$config['cf_image_extension']})$/i", $filename)) {
				if($is_view == "1" || $is_view == "3") {
					$caption = ($alt) ? ' data-title="'.$alt.'"' : '';
					$thumb_tag = '<a href="'.$src.'" data-lightbox="view-lightbox"'.$caption.' target="_blank">'.$thumb_tag.'</a>';
				} else if (strpos($img_tag, G5_DATA_DIR.'/'.G5_EDITOR_DIR) || strpos($img_tag, G5_DATA_DIR.'/file')) {
					$thumb_tag = '<a href="'.G5_BBS_URL.'/view_image.php?fn='.urlencode(str_replace(G5_URL, "", $src)).'" target="_blank" class="view_image">'.$thumb_tag.'</a>';
				} else {
					$thumb_tag = '<a href="'.G5_BBS_URL.'/view_img.php?img='.urlencode($src).'" target="_blank" class="view_image">'.$thumb_tag.'</a>';
				}
			}

			// Exif 정보출력
			if($exif_info) {
				$thumb_tag = '<div class="img-exif">'.$thumb_tag.''.$exif_info.'</div>'.PHP_EOL;
			}

            $contents = str_replace($img_tag, $thumb_tag, $contents);

		} else {

			$thumb_tag = '<img'.$itemprop.' src="'.$src.'" alt="'.$alt.'" class="img-tag '.$class.'"'.$img_attr.'/>';

			if($link || $is_view > 1) {
				;
			} else {
				if($is_view == "1") {
					$caption = ($alt) ? ' data-title="'.$alt.'"' : '';
					$thumb_tag = '<a href="'.$src.'" data-lightbox="view-lightbox"'.$caption.' target="_blank">'.$thumb_tag.'</a>';
				} else {
					$thumb_tag = '<a href="'.G5_BBS_URL.'/view_img.php?img='.urlencode($src).'" target="_blank" class="view_image">'.$thumb_tag.'</a>';
				}
			}

			$contents = str_replace($img_tag, $thumb_tag, $contents);
		}
    }

    return $contents;
}

function thumbnail($filename, $source_path, $target_path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3')
{
    global $g5;

    if(!$thumb_width && !$thumb_height)
        return;

    $source_file = "$source_path/$filename";

    if(!is_file($source_file)) // 원본 파일이 없다면
        return;

    $size = @getimagesize($source_file);
    if($size[2] < 1 || $size[2] > 3) // gif, jpg, png 에 대해서만 적용
        return;

    if (!is_dir($target_path)) {
        @mkdir($target_path, G5_DIR_PERMISSION);
        @chmod($target_path, G5_DIR_PERMISSION);
    }

    // 디렉토리가 존재하지 않거나 쓰기 권한이 없으면 썸네일 생성하지 않음
    if(!(is_dir($target_path) && is_writable($target_path)))
        return '';

    // Animated GIF는 썸네일 생성하지 않음
    if($size[2] == 1) {
        if(is_animated_gif($source_file))
            return basename($source_file);
    }

    $ext = array(1 => 'gif', 2 => 'jpg', 3 => 'png');

    $thumb_filename = preg_replace("/\.[^\.]+$/i", "", $filename); // 확장자제거
    $thumb_file = "$target_path/thumb-{$thumb_filename}_{$thumb_width}x{$thumb_height}.".$ext[$size[2]];

    $thumb_time = @filemtime($thumb_file);
    $source_time = @filemtime($source_file);

    if (is_file($thumb_file)) {
        if ($is_create == false && $source_time < $thumb_time) {
            return basename($thumb_file);
        }
    }

    // 원본파일의 GD 이미지 생성
    $src = null;
    $degree = 0;

    if ($size[2] == 1) {
        $src = @imagecreatefromgif($source_file);
        $src_transparency = @imagecolortransparent($src);
    } else if ($size[2] == 2) {
        $src = @imagecreatefromjpeg($source_file);

        if(function_exists('exif_read_data')) {
            // exif 정보를 기준으로 회전각도 구함
            $exif = @exif_read_data($source_file);
            if(!empty($exif['Orientation'])) {
                switch($exif['Orientation']) {
                    case 8:
                        $degree = 90;
                        break;
                    case 3:
                        $degree = 180;
                        break;
                    case 6:
                        $degree = -90;
                        break;
                }

                // 회전각도 있으면 이미지 회전
                if($degree) {
                    $src = @imagerotate($src, $degree, 0);

                    // 세로사진의 경우 가로, 세로 값 바꿈
                    if($degree == 90 || $degree == -90) {
                        $tmp = $size;
                        $size[0] = $tmp[1];
                        $size[1] = $tmp[0];
                    }
                }
            }
        }
    } else if ($size[2] == 3) {
        $src = @imagecreatefrompng($source_file);
        @imagealphablending($src, true);
    } else {
        return;
    }

    if(!$src)
        return;

    $is_large = true;
    // width, height 설정
    if($thumb_width) {
        if(!$thumb_height) {
            $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
        } else {
            if($size[0] < $thumb_width || $size[1] < $thumb_height)
                $is_large = false;
        }
    } else {
        if($thumb_height) {
            $thumb_width = round(($thumb_height * $size[0]) / $size[1]);
        }
    }

    $dst_x = 0;
    $dst_y = 0;
    $src_x = 0;
    $src_y = 0;
    $dst_w = $thumb_width;
    $dst_h = $thumb_height;
    $src_w = $size[0];
    $src_h = $size[1];

    $ratio = $dst_h / $dst_w;

    if($is_large) {
        // 크롭처리
        if($is_crop) {
            switch($crop_mode)
            {
                case 'center':
                    if($size[1] / $size[0] >= $ratio) {
                        $src_h = round($src_w * $ratio);
                        $src_y = round(($size[1] - $src_h) / 2);
                    } else {
                        $src_w = round($size[1] / $ratio);
                        $src_x = round(($size[0] - $src_w) / 2);
                    }
                    break;
                default:
                    if($size[1] / $size[0] >= $ratio) {
                        $src_h = round($src_w * $ratio);
                    } else {
                        $src_w = round($size[1] / $ratio);
                    }
                    break;
            }

            $dst = imagecreatetruecolor($dst_w, $dst_h);

            if($size[2] == 3) {
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            } else if($size[2] == 1) {
                $palletsize = imagecolorstotal($src);
                if($src_transparency >= 0 && $src_transparency < $palletsize) {
                    $transparent_color   = imagecolorsforindex($src, $src_transparency);
                    $current_transparent = imagecolorallocate($dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                    imagefill($dst, 0, 0, $current_transparent);
                    imagecolortransparent($dst, $current_transparent);
                }
            }
        } else { // 비율에 맞게 생성
            $dst = imagecreatetruecolor($dst_w, $dst_h);
            $bgcolor = imagecolorallocate($dst, 255, 255, 255); // 배경색
            if($src_w > $src_h) {
                $tmp_h = round(($dst_w * $src_h) / $src_w);
                $dst_y = round(($dst_h - $tmp_h) / 2);
                $dst_h = $tmp_h;
            } else {
                $tmp_w = round(($dst_h * $src_w) / $src_h);
                $dst_x = round(($dst_w - $tmp_w) / 2);
                $dst_w = $tmp_w;
            }

            if($size[2] == 3) {
                $bgcolor = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                imagefill($dst, 0, 0, $bgcolor);
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            } else if($size[2] == 1) {
                $palletsize = imagecolorstotal($src);
                if($src_transparency >= 0 && $src_transparency < $palletsize) {
                    $transparent_color   = imagecolorsforindex($src, $src_transparency);
                    $current_transparent = imagecolorallocate($dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                    imagefill($dst, 0, 0, $current_transparent);
                    imagecolortransparent($dst, $current_transparent);
                } else {
                    imagefill($dst, 0, 0, $bgcolor);
                }
            } else {
                imagefill($dst, 0, 0, $bgcolor);
            }
        }
    } else {
        $dst = imagecreatetruecolor($dst_w, $dst_h);
        $bgcolor = imagecolorallocate($dst, 255, 255, 255); // 배경색

        if($src_w < $dst_w) {
            if($src_h >= $dst_h) {
                if( $src_h > $src_w ){
                    $tmp_w = round(($dst_h * $src_w) / $src_h);
                    $dst_x = round(($dst_w - $tmp_w) / 2);
                    $dst_w = $tmp_w;
                } else {
                    $dst_x = round(($dst_w - $src_w) / 2);
                    $src_h = $dst_h;
                }
            } else {
                $dst_x = round(($dst_w - $src_w) / 2);
                $dst_y = round(($dst_h - $src_h) / 2);
                $dst_w = $src_w;
                $dst_h = $src_h;
            }
        } else {
            if($src_h < $dst_h) {
                if( $src_w > $dst_w ){
                    $tmp_h = round(($dst_w * $src_h) / $src_w);
                    $dst_y = round(($dst_h - $tmp_h) / 2);
                    $dst_h = $tmp_h;
                } else {
                    $dst_y = round(($dst_h - $src_h) / 2);
                    $dst_h = $src_h;
                    $src_w = $dst_w;
                }
            }
        }

        if($size[2] == 3) {
            $bgcolor = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefill($dst, 0, 0, $bgcolor);
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        } else if($size[2] == 1) {
            $palletsize = imagecolorstotal($src);
            if($src_transparency >= 0 && $src_transparency < $palletsize) {
                $transparent_color   = imagecolorsforindex($src, $src_transparency);
                $current_transparent = imagecolorallocate($dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($dst, 0, 0, $current_transparent);
                imagecolortransparent($dst, $current_transparent);
            } else {
                imagefill($dst, 0, 0, $bgcolor);
            }
        } else {
            imagefill($dst, 0, 0, $bgcolor);
        }
    }

    imagecopyresampled($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

    // sharpen 적용
    if($is_sharpen && $is_large) {
        $val = explode('/', $um_value);
        UnsharpMask($dst, $val[0], $val[1], $val[2]);
    }

    if($size[2] == 1) {
        imagegif($dst, $thumb_file);
    } else if($size[2] == 3) {
        if(!defined('G5_THUMB_PNG_COMPRESS'))
            $png_compress = 5;
        else
            $png_compress = G5_THUMB_PNG_COMPRESS;

        imagepng($dst, $thumb_file, $png_compress);
    } else {
        if(!defined('G5_THUMB_JPG_QUALITY'))
            $jpg_quality = 90;
        else
            $jpg_quality = G5_THUMB_JPG_QUALITY;

        imagejpeg($dst, $thumb_file, $jpg_quality);
    }

    chmod($thumb_file, G5_FILE_PERMISSION); // 추후 삭제를 위하여 파일모드 변경

    imagedestroy($src);
    imagedestroy($dst);

    return basename($thumb_file);
}

function UnsharpMask($img, $amount, $radius, $threshold)    {

/*
출처 : http://vikjavev.no/computing/ump.php
New:
- In version 2.1 (February 26 2007) Tom Bishop has done some important speed enhancements.
- From version 2 (July 17 2006) the script uses the imageconvolution function in PHP
version >= 5.1, which improves the performance considerably.


Unsharp masking is a traditional darkroom technique that has proven very suitable for
digital imaging. The principle of unsharp masking is to create a blurred copy of the image
and compare it to the underlying original. The difference in colour values
between the two images is greatest for the pixels near sharp edges. When this
difference is subtracted from the original image, the edges will be
accentuated.

The Amount parameter simply says how much of the effect you want. 100 is 'normal'.
Radius is the radius of the blurring circle of the mask. 'Threshold' is the least
difference in colour values that is allowed between the original and the mask. In practice
this means that low-contrast areas of the picture are left unrendered whereas edges
are treated normally. This is good for pictures of e.g. skin or blue skies.

Any suggenstions for improvement of the algorithm, expecially regarding the speed
and the roundoff errors in the Gaussian blur process, are welcome.

*/

////////////////////////////////////////////////////////////////////////////////////////////////
////
////                  Unsharp Mask for PHP - version 2.1.1
////
////    Unsharp mask algorithm by Torstein Hønsi 2003-07.
////             thoensi_at_netcom_dot_no.
////               Please leave this notice.
////
///////////////////////////////////////////////////////////////////////////////////////////////



    // $img is an image that is already created within php using
    // imgcreatetruecolor. No url! $img must be a truecolor image.

    // Attempt to calibrate the parameters to Photoshop:
    if ($amount > 500)    $amount = 500;
    $amount = $amount * 0.016;
    if ($radius > 50)    $radius = 50;
    $radius = $radius * 2;
    if ($threshold > 255)    $threshold = 255;

    $radius = abs(round($radius));     // Only integers make sense.
    if ($radius == 0) {
        return $img; imagedestroy($img);        }
    $w = imagesx($img); $h = imagesy($img);
    $imgCanvas = imagecreatetruecolor($w, $h);
    $imgBlur = imagecreatetruecolor($w, $h);


    // Gaussian blur matrix:
    //
    //    1    2    1
    //    2    4    2
    //    1    2    1
    //
    //////////////////////////////////////////////////


    if (function_exists('imageconvolution')) { // PHP >= 5.1
            $matrix = array(
            array( 1, 2, 1 ),
            array( 2, 4, 2 ),
            array( 1, 2, 1 )
        );
        $divisor = array_sum(array_map('array_sum', $matrix));
        $offset = 0;

        imagecopy ($imgBlur, $img, 0, 0, 0, 0, $w, $h);
        imageconvolution($imgBlur, $matrix, $divisor, $offset);
    }
    else {

    // Move copies of the image around one pixel at the time and merge them with weight
    // according to the matrix. The same matrix is simply repeated for higher radii.
        for ($i = 0; $i < $radius; $i++)    {
            imagecopy ($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h); // left
            imagecopymerge ($imgBlur, $img, 1, 0, 0, 0, $w, $h, 50); // right
            imagecopymerge ($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50); // center
            imagecopy ($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h);

            imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 33.33333 ); // up
            imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 25); // down
        }
    }

    if($threshold>0){
        // Calculate the difference between the blurred pixels and the original
        // and set the pixels
        for ($x = 0; $x < $w-1; $x++)    { // each row
            for ($y = 0; $y < $h; $y++)    { // each pixel

                $rgbOrig = ImageColorAt($img, $x, $y);
                $rOrig = (($rgbOrig >> 16) & 0xFF);
                $gOrig = (($rgbOrig >> 8) & 0xFF);
                $bOrig = ($rgbOrig & 0xFF);

                $rgbBlur = ImageColorAt($imgBlur, $x, $y);

                $rBlur = (($rgbBlur >> 16) & 0xFF);
                $gBlur = (($rgbBlur >> 8) & 0xFF);
                $bBlur = ($rgbBlur & 0xFF);

                // When the masked pixels differ less from the original
                // than the threshold specifies, they are set to their original value.
                $rNew = (abs($rOrig - $rBlur) >= $threshold)
                    ? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))
                    : $rOrig;
                $gNew = (abs($gOrig - $gBlur) >= $threshold)
                    ? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))
                    : $gOrig;
                $bNew = (abs($bOrig - $bBlur) >= $threshold)
                    ? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))
                    : $bOrig;



                if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) {
                        $pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew);
                        ImageSetPixel($img, $x, $y, $pixCol);
                    }
            }
        }
    }
    else{
        for ($x = 0; $x < $w; $x++)    { // each row
            for ($y = 0; $y < $h; $y++)    { // each pixel
                $rgbOrig = ImageColorAt($img, $x, $y);
                $rOrig = (($rgbOrig >> 16) & 0xFF);
                $gOrig = (($rgbOrig >> 8) & 0xFF);
                $bOrig = ($rgbOrig & 0xFF);

                $rgbBlur = ImageColorAt($imgBlur, $x, $y);

                $rBlur = (($rgbBlur >> 16) & 0xFF);
                $gBlur = (($rgbBlur >> 8) & 0xFF);
                $bBlur = ($rgbBlur & 0xFF);

                $rNew = ($amount * ($rOrig - $rBlur)) + $rOrig;
                    if($rNew>255){$rNew=255;}
                    elseif($rNew<0){$rNew=0;}
                $gNew = ($amount * ($gOrig - $gBlur)) + $gOrig;
                    if($gNew>255){$gNew=255;}
                    elseif($gNew<0){$gNew=0;}
                $bNew = ($amount * ($bOrig - $bBlur)) + $bOrig;
                    if($bNew>255){$bNew=255;}
                    elseif($bNew<0){$bNew=0;}
                $rgbNew = ($rNew << 16) + ($gNew <<8) + $bNew;
                    ImageSetPixel($img, $x, $y, $rgbNew);
            }
        }
    }
    imagedestroy($imgCanvas);
    imagedestroy($imgBlur);

    return true;

}

function is_animated_gif($filename) {
    if(!($fh = @fopen($filename, 'rb')))
        return false;
    $count = 0;
    // 출처 : http://www.php.net/manual/en/function.imagecreatefromgif.php#104473
    // an animated gif contains multiple "frames", with each frame having a
    // header made up of:
    // * a static 4-byte sequence (\x00\x21\xF9\x04)
    // * 4 variable bytes
    // * a static 2-byte sequence (\x00\x2C) (some variants may use \x00\x21 ?)

    // We read through the file til we reach the end of the file, or we've found
    // at least 2 frame headers
    while(!feof($fh) && $count < 2) {
        $chunk = fread($fh, 1024 * 100); //read 100kb at a time
        $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00(\x2C|\x21)#s', $chunk, $matches);
   }

    fclose($fh);
    return $count > 1;
}
?>