<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 1;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

$data_path = G5_DATA_URL."/file/$bo_table";
$image_ok = 1; /// 첨부 이미지 출력하지 않으려면 0로 변경.
$num_of_images = 1; /// 첨부 이미지 출력 갯수. 'all'로 지정하면 전체 출력.
$content_len = 160; /// 본문 출력 스트링 길이 (멀티 바이트 지원)

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<style>
.sort_link {
    float:right;
    padding-right:10px;
    font-weight:normal;
    color:#383838;
    font-size:0.95em;
    letter-spacing:-0.1em;
}
.sort_link a {
    color:#383838;
}
/*
.sort_info {
    padding:0 10px;
    font-size:12px
}
*/
.sort_info {
    float:left;
    padding-left:10px;
    font-size:12px
}
.sort_info_right {
    float:right;
    padding-left:3px;
    padding-right:10px;
    font-size:12px
}
</style>

<h2 id="container_title"><?php echo _t($board['bo_subject']) ?><span class="sound_only"> <?php echo _t('목록'); ?></span></h2>

<!-- 게시판 목록 시작 -->
<div id="bo_list<?php if ($is_admin) echo "_admin"; ?>">

    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo _t($board['bo_subject']) ?> <?php echo _t('카테고리'); ?></h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>

    <div class="bo_fx">
        <div id="bo_list_total">
            <span><?php echo _t('Total'); ?> <?php echo number_format($total_count) ?><?php echo _t('건'); ?></span>
            <?php echo $page ?> <?php echo _t('페이지'); ?>
        </div>

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01"><?php echo _t('RSS'); ?></a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin"><?php echo _t('관리자'); ?></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo _t('글쓰기'); ?></a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tbl_head01 tbl_wrap">
        <table>
        <thead>
        <tr>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
                <label for="chkall"><?php echo _t('현재 페이지 게시물 전체'); ?></label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </th>
            <?php } ?>
            <th scope="col" class="sort_link">
            <?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?><?php echo _t('날짜'); ?></a> &nbsp; | &nbsp; 
            <?php echo subject_sort_link('wr_hit', $qstr2, 1) ?><?php echo _t('조회'); ?></a>  
            <?php if ($is_good) { ?> &nbsp; | &nbsp; <?php echo subject_sort_link('wr_good', $qstr2, 1) ?><?php echo _t('추천'); ?></a><?php } ?>
            <?php if ($is_nogood) { ?> &nbsp; | &nbsp; <?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?><?php echo _t('비추천'); ?></a><?php } ?>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
                        $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);

                        if($thumb['src']) {
                            /// $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
                            $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
                        } else {
                            $img_content = '<span style="width:'.$board['bo_gallery_width'].'px;height:'.$board['bo_gallery_height'].'px">no image</span>';
                        }
        ?>
        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td><?php } ?>
            <!--
            <td>
                <a href='<?php echo $list[$i]['href']?>'><?php echo $img_content?></a>
            </td>
            -->
            <td width="100%" valign="top">
            <ul class="ul00">
            <li class="li00">
                <ul class="ul10">
                <li class="li10">
                <?php
                echo $list[$i]['icon_reply'];
                if ($is_category && $list[$i]['ca_name']) {
                ?>
                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                <?php } ?>

                <a href="<?php echo $list[$i]['href'] ?>">
                    <b><?php echo $list[$i]['subject'] ?></b>
                    <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?>
                    <?php
                    // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                    // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                    if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                    if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                    if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                    if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                    if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];

                    ?>
                </a>
                </li>
                <li class="li11">
                <?php echo $list[$i]['datetime2'];?>
                </li>
                <br/>
                <span class="sort_info">
                <?php echo $list[$i]['name']?>
                </span>
                <span class="sort_info_right">
                조회: <?php echo $list[$i]['wr_hit'] ?><?php if ($is_good) { ?>, 추천: <?php echo $list[$i]['wr_good'] ?><?php } ?><?php if ($is_nogood) { ?>, 비추천: <?php echo $list[$i]['wr_nogood'] ?><?php } ?>
                </span>
                </ul>
            </li>
            <li class="li01">
                <a href="<?php echo $list[$i]['href'] ?>">&nbsp;
                <?php echo mb_substr(strip_tags($list[$i]['content']), 0, $content_len, 'utf-8'); ?>
                <?php if(mb_strlen(strip_tags($list[$i]['content']), 'utf-8') > $content_len) echo " ....."; ?>
                </a>
                <br><br>
                <!--<a href='<?php echo $list[$i]['href']?>'><?php echo $img_content?></a>-->
                <?php if($image_ok) { ?>
                <span>
                <?
	                if($num_of_images == 'all') $num_of_images = count($list[$i][file]);
                        for ($j=0; $j<$num_of_images; $j++) {
                            if ($list[$i][file][$j][file]) 
                                echo "<div style='padding-bottom:5px'><a href='{$list[$i]['href']}'><img src='$data_path/" . $list[$i][file][$j][file] . "' alt='{$list[$i][file][$j][source]}'></a></div>";
                        }
                ?>
                </span>
                <?php } /// image_ok ?>
            </li>
            </ul>
            </td>
            <!--<td class="td_date"><?php ///echo $list[$i]['datetime2'] ?></td>-->
        </tr>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">'._t('게시물이 없습니다.').'</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <ul class="btn_bo_adm">
            <?php if ($list_href) { ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01"> <?php echo _t('목록'); ?></a></li>
            <?php } ?>
            <?php if ($is_checkbox) { ?>
            <li><input type="submit" name="btn_submit" value="<?php echo _t('선택삭제'); ?>" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="<?php echo _t('선택복사'); ?>" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="<?php echo _t('선택이동'); ?>" onclick="document.pressed=this.value"></li>
            <?php } ?>
        </ul>

        <ul class="btn_bo_user">
            <li><?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo _t('글쓰기'); ?></a><?php } ?></li>
        </ul>
    </div>
    <?php } ?>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p><?php echo _t('자바스크립트를 사용하지 않는 경우'); ?><br><?php echo _t('별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.'); ?></p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages; ?>

<fieldset id="bo_sch">
    <!--<legend><?php echo _t('게시물 검색'); ?></legend>-->

    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only"><?php echo _t('검색대상'); ?></label>
    <select name="sfl">
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>><?php echo _t('제목'); ?></option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>><?php echo _t('내용'); ?></option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>><?php echo _t('제목+내용'); ?></option>
        <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>><?php echo _t('회원아이디'); ?></option>
        <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>><?php echo _t('회원아이디(코)'); ?></option>
        <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>><?php echo _t('글쓴이'); ?></option>
        <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>><?php echo _t('글쓴이(코)'); ?></option>
    </select>
    <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="<?php echo _t('검색어(필수)'); ?>" required id="stx" class="required frm_input" size="15" maxlength="20">
    <input type="submit" value="<?php echo _t('검색'); ?>" class="btn_submit">
    </form>
</fieldset>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "<?php echo _t('할 게시물을 하나 이상 선택하세요.'); ?>");
        return false;
    }

    if(document.pressed == "<?php echo _t('선택복사'); ?>") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "<?php echo _t('선택이동'); ?>") {
        select_copy("move");
        return;
    }

    if(document.pressed == "<?php echo _t('선택삭제'); ?>") {
        if (!confirm("<?php echo _t('선택한 게시물을 정말 삭제하시겠습니까?'); ?>\n\n<?php echo _t('한번 삭제한 자료는 복구할 수 없습니다'); ?>\n\n<?php echo _t('답변글이 있는 게시글을 선택하신 경우'); ?>\n<?php echo _t('답변글도 선택하셔야 게시글이 삭제됩니다.'); ?>"))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "<?php echo _t('복사'); ?>";
    else
        str = "<?php echo _t('이동'); ?>";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<script>
// 이미지 등비율 리사이징
$(window).load(function() {
    view_image_resize();
});

var now = new Date();
var timeout = false;
var millisec = 200;
var tid;

$(window).resize(function() {
    now = new Date();
    if (timeout === false) {
        timeout = true;

        if(tid != null)
            clearTimeout(tid);

        tid = setTimeout(resize_check, millisec);
    }
});

function resize_check() {
    if (new Date() - now < millisec) {
        if(tid != null)
            clearTimeout(tid);

        tid = setTimeout(resize_check, millisec);
    } else {
        timeout = false;
        view_image_resize();
    }
}

$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });
});

function view_image_resize()
{
    var $img = $("#bo_list<?php if ($is_admin) echo "_admin"; ?> img");
    var img_wrap = $("#bo_list<?php if ($is_admin) echo "_admin"; ?>").width();
    var win_width = $(window).width() - 65;
    var res_width = 0;

    if(img_wrap < win_width)
        res_width = img_wrap;
    else
        res_width = win_width;

    $img.each(function() {
        var img_width = $(this).width();
        var img_height = $(this).height();
        var this_width = $(this).data("width");
        var this_height = $(this).data("height");

        if(this_width == undefined) {
            $(this).data("width", img_width); // 원래 이미지 사이즈
            $(this).data("height", img_height);
            this_width = img_width;
            this_height = img_height;
        }

        if(this_width > res_width) {
            $(this).width(res_width);
            var res_height = Math.round(res_width * $(this).data("height") / $(this).data("width"));
            $(this).height(res_height);
        } else {
            $(this).width(this_width);
            $(this).height(this_height);
        }
    });
}

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("<?php echo _t('이 글을 비추천하셨습니다.'); ?>");
                } else {
                    $tx.text("<?php echo _t('이 글을 추천하셨습니다.'); ?>");
                }
            }
        }, "json"
    );
}
</script>
<!-- 게시판 목록 끝 -->
