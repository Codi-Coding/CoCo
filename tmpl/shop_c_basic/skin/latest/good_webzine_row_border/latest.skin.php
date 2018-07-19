<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$img_width  = $options[0];
$img_height = $options[1];
if(!$img_width) $img_width   = 78; //이미지 가로 크기
if(!$img_height) $img_height = 54; //이미지 세로 크기
?>

<link rel="stylesheet" href="<?php echo $latest_skin_url ?>/style.css">

<div class="lt_gallery_wz_row">
    <strong class="lt_title"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject ?></a></strong><!-- cache problem -->
    <ul>
    <?php
    for ($i=0; $i<count($list); $i++) {
        if(0) { ///
        $org_img = G5_DATA_PATH."/file/$bo_table/".urlencode($list[$i]['file'][0]['file']); 
        $img[$i] = G5_DATA_PATH."/file/$bo_table/thumb/".$list[$i]['wr_id'];
        $href = $list[$i]['href']; 
        $img_url = G5_DATA_URL."/file/$bo_table/thumb/".$list[$i]['wr_id'];

        if(!file_exists( $img[$i]) ) $img[$i]=$org_img;

        if (!file_exists( $img[$i]) || !$list[$i]['file'][0]['file']) {
            $img[$i] = "$latest_skin_path/img/no_image.gif"; /// no use
            $img_url = "$latest_skin_url/img/no_image.gif";
        }
        } /// if 0

        $href = $list[$i]['href']; 
        $img = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $img_width, $img_height);
        $no_img = "$latest_skin_url/img/no_image.gif";

        if($img['src']) {
            $img_src = $img['src'];
        } else {
            $img_src = $no_img;
        }
    ?>
        <li>
            <table width=100% border=0 cellspacing=0 cellpadding=0><tr><td style="width:<?php echo $img_width ?>px;vertical-align:top">
            <span class="left"><a href="<?php echo $href?>" target="_self"><img src="<?php echo $img_src?>" width="<?php echo $img_width ?>" alt="<?php echo $list[$i]['wr_subject']?>"></a></span>
            </td><td style="vertical-align:top;padding-top:3px">
            <span class="right"><a href="<?php echo $href?>" target="_self"><font class="title">[<?php echo $list[$i]['wr_subject']?>]</font><br>&nbsp;<?php echo cut_str(stripslashes(strip_tags($list[$i]['wr_content'])), $subject_len, ' ...')?></a></span>
            </td></tr></table>
        </li>
        <br>
    <?php } ?>
    </ul>
    <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>
</div>
