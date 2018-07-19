<?php // 굿빌더 ?>
<?php
    if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

    /// if($i == 0) {
    if($i == 0 and $upload[$i][file]) {
        /// make a thumb
        if($_POST[make_thumb] == 1) {

            $dest_file = "$g5[path]/data/file/$bo_table/" . $upload[$i][file];

	    $thumb_path = "$g5[path]/data/file/$bo_table/thumb";
            @mkdir($thumb_path, 0707);
            @chmod($thumb_path, 0707);

	    $thumb = $thumb_path.'/'.$wr_id;

            if($board[bo_1] and $board[bo_2] and $board[bo_3])
            {
               $image_width = $board[bo_1];
               $image_height = $board[bo_2];
               $image_quality = $board[bo_3];
            }
            else
            {
               $image_width = $g5[default_thumb_width];
               $image_height = $g5[default_thumb_height];
               $image_quality = $g5[default_thumb_quality];
            }

	    /// if (!file_exists($thumb)) {
	        if (preg_match("/\.(jp[e]?g|gif|png)$/i", $dest_file) && file_exists($dest_file)) {
	            $size = getimagesize($dest_file);
	            if ($size[2] == 1)
	                $src = imagecreatefromgif($dest_file);
	            else if ($size[2] == 2)
	                $src = imagecreatefromjpeg($dest_file);
	            else if ($size[2] == 3)
	                $src = imagecreatefrompng($dest_file);
	            else
	                break;

	            $rate = $image_width / $size[0];
	            $height = (int)($size[1] * $rate);

	            $dst = imagecreatetruecolor($image_width, $height);

	            imagecopyresampled($dst, $src, 0, 0, 0, 0, $image_width, $height, $size[0], $size[1]);
	            imagepng($dst, $thumb, intval($image_quality/11)); /// 0~100 -> 0~9
	            chmod($thumb, 0606);
	        }
	    /// }

        } /// make a thumb
    } // if $i
?>
