<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
?>

<link rel="stylesheet" href="<?php echo $board_skin_url ?>/style.css">



<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">



    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption><?php echo $board['bo_subject'] ?> 목록</caption>
        <thead>
        <tr>
            <th scope="col">번호</th>
			<?php if ($is_checkbox) { ?>
            <th scope="col"></th>
			<?php } ?>
            <th scope="col">이미지</th>
            <th scope="col">행사 안내</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
         ?>
        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <td class="td_num">
            <?php
            if ($list[$i]['is_notice']) // 공지사항
                echo '<strong>공지</strong>';
            else if ($wr_id == $list[$i]['wr_id'])
                echo "<span class=\"bo_current\">열람중</span>";
            else
                echo $list[$i]['num'];
             ?>
            </td>
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td>
            <?php } ?>
			<td class="td_web_img">
				<a href="<?php echo $list[$i]['href'] ?>">
				<?php
				$thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 100, 80);

                if($thumb['src']) {
					$img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="100" height="80" border="0"';
                } else {
                    $img_content = 'no_image';
                }
				echo $img_content;
				?>
				</a>
			</td>
            <td class="td_subject">
			    <p>
			    <?php echo $list[$i]['icon_reply']; ?>
                <a href="<?php echo $list[$i]['href'] ?>">
                    <?php echo $list[$i]['subject'] ?>
 <?php if($member['mb_level'] > 7) {?>                       <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?><? } ?>
                </a>

                <?php
                // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];
                ?>
				</p>
				<p>
					<?php
                    if ($is_category && $list[$i]['ca_name'] && !$list[$i]['is_notice']) { 
                     ?>
                    <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo "[".$list[$i]['ca_name']."]"; ?></a>
					<span class="bo_line">|</span>
                    <?php } ?>
					<span class="bo_img_subject">주최: </span><?php echo $list[$i]['wr_1'] ?> <span class="bo_line">|</span>       
					<span class="bo_img_subject">기간: </span><?php echo $list[$i]['wr_2'] ?><span class="bo_line">|</span>  
					<span class="bo_img_subject">참가비: </span><?php echo $list[$i]['wr_4'] ?>원 <span class="bo_line">|</span>  
					<span class="bo_img_subject">상태: </span><?php echo $list[$i]['wr_10'] ?>   
<?php if($member['mb_level'] > 7) {?>   		<span class="bo_line">|</span>			<span class="bo_img_subject">조회 </span><?php echo $list[$i]['wr_hit'] ?> <?php } ?>
	                <?php if ($is_good) { ?><span class="bo_line">|</span><span class="bo_img_subject">추천 </span><strong><?php echo $list[$i]['wr_good'] ?></strong><?php } ?>
		            <?php if ($is_nogood) { ?><span class="bo_line">|</span><span class="bo_img_subject">비추천 </span><strong><?php echo $list[$i]['wr_nogood'] ?></strong><?php } ?>
				</p>
				<p><?php echo $wr_content = cut_str(strip_tags($list[$i][wr_content]), 100, '…'); ?></p>
            </td>
            
            
            
        </tr>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

 
