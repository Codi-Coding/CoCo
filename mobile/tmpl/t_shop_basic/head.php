<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_MOBILE_TMPL_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>

<header id="hd">
    <?php if ((!$bo_table || $w == 's' ) && defined('_INDEX_')) { ?><h1><?php echo $config['cf_title'] ?></h1><?php } ?>

    <div id="skip_to_container"><a href="#container"><?php echo _t('본문 바로가기'); ?></a></div>

    <?php if(defined('_INDEX_')) { // index에서만 실행
        include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
    } ?>

    <?php if($config2w_m['cf_use_common_logo']) { ?>
    <div id="logo"><a href="<?php echo G5_URL; ?>/"><img src="<?php echo G5_IMG_URL ?>/mobile_logo.png" alt="<?php echo $config['cf_title']; ?> <?php echo _t('메인'); ?>"></a></div>
    <?php } else { ?>
    <div id="logo"><a href="<?php echo G5_URL; ?>/"><img src="<?php echo $g5['mobile_tmpl_url']; ?>/images/logo.png" alt="<?php echo $config['cf_title']; ?> <?php echo _t('메인'); ?>"></a></div>
    <?php } ?>

    <!-- 분류 -->
    <!--<a href="<?php echo G5_SHOP_URL; ?>/category.php" target="_blank" id="hd_ct">분류</a>-->
    <!--<div id="hd_ct">
        <a href="<?php echo G5_SHOP_URL; ?>/category.php" target="_blank"><?php echo _t('분류'); ?></a>
    </div>-->
    <!-- 분류 끝 -->

    <!-- 메뉴 -->
        <button type="button" id="gnb_open" class="hd_opener"><?php echo _t('메뉴'); ?><span class="sound_only"> <?php echo _t('열기'); ?></span></button>

        <?php if($g5['use_builder_menu']) { ?>
        <?php
        // 메뉴설정파일
        include_once("$g5[mobile_tmpl_path]/menu/menu.php");
        include_once("$g5[mobile_tmpl_path]/menu/menu_aux.php");
        ?>
        <div id="gnb" class="hd_div">
            <ul id="gnb_1dul">
                <?php for($i = 0; $i < count($menu_list); $i++) { ?>
                <li class="gnb_1dli">
                        <a href="<?php echo $menu_list[$i][1]?>" class="gnb_1da"><?php echo _t($menu_list[$i][0])?></a>
                        <?php if($i > 0) { ?>
                        <?php if(count($menu[$i]) > 0) { ?>
                        <ul class="gnb_2dul">
                        <?php for($j = 0; $j < count($menu[$i]); $j++) { ?>
                                <li class="gnb_2dli">
                                        <a href="<?php echo $menu[$i][$j][1]?>" class="gnb_2da"><span></span><?php echo _t($menu[$i][$j][0])?></a>
                                </li>
                        <?php } ?>
                        </ul>
                        <?php } ?>
                        <?php } ?>
                </li>
                <?php } ?>
            </ul>
            <button type="button" id="gnb_close" class="hd_closer"><span class="sound_only"><?php echo _t('메뉴'); ?> </span><?php echo _t('닫기'); ?></button>
        </div>
        <?php } else { ?>
        <div id="gnb" class="hd_div">
            <ul id="gnb_1dul">
            <?php
            $sql = " select *
                        from {$g5['menu_table']}
                        where me_mobile_use = '1'
                          and length(me_code) = '2'
                        order by me_order, me_id ";
            $result = sql_query($sql, false);

            for($i=0; $row=sql_fetch_array($result); $i++) {
                if(!preg_match('|^http://|', $row['me_link'])) $row['me_link'] = G5_URL.$row['me_link'];
            ?>
                <li class="gnb_1dli">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo _t($row['me_name']) ?></a>
                    <?php
                    $sql2 = " select *
                                from {$g5['menu_table']}
                                where me_mobile_use = '1'
                                  and length(me_code) = '4'
                                  and substring(me_code, 1, 2) = '{$row['me_code']}'
                                order by me_order, me_id ";
                    $result2 = sql_query($sql2);

                    for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                        if(!preg_match('|^http://|', $row2['me_link'])) $row2['me_link'] = G5_URL.$row2['me_link'];
                        if($k == 0)
                            echo '<ul class="gnb_2dul">'.PHP_EOL;
                    ?>
                        <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><span></span><?php echo _t($row2['me_name']) ?></a></li>
                    <?php
                    }

                    if($k > 0)
                        echo '</ul>'.PHP_EOL;
                    ?>
                </li>
            <?php
            }

            if ($i == 0) {  ?>
                <li id="gnb_empty"><?php echo _t('메뉴 준비 중입니다.'); ?><?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php"><?php echo _t('관리자모드').' &gt; '._t('환경설정').' &gt; '._t('메뉴설정'); ?></a><?php echo _t('에서 설정하세요.'); ?><?php } ?></li>
            <?php } ?>
            </ul>
            <button type="button" id="gnb_close" class="hd_closer"><span class="sound_only"><?php echo _t('메뉴'); ?> </span><?php echo _t('닫기'); ?></button>
        </div>
        <?php } /// if else ?>
    <!-- 메뉴 끝 -->

    <!-- 게시판 검색 -->
        <button type="button" id="hd_sch_open_bbs" class="hd_opener"><?php echo _t('게시판검색'); ?><span class="sound_only"> <?php echo _t('열기'); ?></span></button>

        <div id="hd_sch_bbs" class="hd_div">
            <h2><?php echo _t('사이트 내 전체검색'); ?></h2>
            <form name="fsearchbox" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);" method="get">
            <input type="hidden" name="sfl" value="wr_subject||wr_content">
            <input type="hidden" name="sop" value="and">
            <input type="text" name="stx" id="sch_stx" placeholder="<?php echo _t('검색어(필수)'); ?>" required class="required" maxlength="20">
            <input type="submit" value="<?php echo _t('검색'); ?>" id="sch_submit">
            </form>

            <script>
            function fsearchbox_submit(f)
            {
                if (f.stx.value.length < 2) {
                    alert("<?php echo _t('검색어는 두글자 이상 입력하십시오.'); ?>");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                var cnt = 0;
                for (var i=0; i<f.stx.value.length; i++) {
                    if (f.stx.value.charAt(i) == ' ')
                        cnt++;
                }

                if (cnt > 1) {
                    alert("<?php echo _t('빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.'); ?>");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                f.stx.style.display = 'none'; /// chrome 버그. 추가
                return true;
            }
            </script>
            <button type="button" id="sch_close" class="hd_closer"><span class="sound_only"><?php echo _t('검색'); ?> </span><?php echo _t('닫기'); ?></button>
        </div>
    <!-- 게시판 검색 끝 -->

        <script>
        $(function () {
            $(".hd_opener").on("click", function() {
                var $this = $(this);
                var $hd_layer = $this.next(".hd_div");

                if($hd_layer.is(":visible")) {
                    $hd_layer.hide();
                    $this.find("span").text("<?php echo _t('열기'); ?>");
                } else {
                    var $hd_layer2 = $(".hd_div:visible");
                    $hd_layer2.prev(".hd_opener").find("span").text("<?php echo _t('열기'); ?>");
                    $hd_layer2.hide();

                    $hd_layer.show();
                    $this.find("span").text("<?php echo _t('닫기'); ?>");
                }
            });

            $(".hd_closer").on("click", function() {
                var idx = $(".hd_closer").index($(this));
                $(".hd_div:visible").hide();
                $(".hd_opener:eq("+idx+")").find("span").text("<?php echo _t('열기'); ?>");
            });
        });
        </script>

    <!-- 상품 검색 -->
    <button type="button" id="hd_sch_open"><?php echo _t('상품검색'); ?><span class="sound_only"> <?php echo _t('열기'); ?></span></button>

    <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
    <aside id="hd_sch">
        <div class="sch_inner">
            <h2><?php echo _t('상품 검색'); ?></h2>
            <label for="sch_str" class="sound_only"><?php echo _t('상품명'); ?><strong class="sound_only"> <?php echo _t('필수'); ?></strong></label>
            <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required class="frm_input">
            <input type="submit" value="<?php echo _t('검색'); ?>" class="btn_submit">
            <button type="button" class="pop_close"><span class="sound_only"><?php echo _t('검색'); ?> </span><?php echo _t('닫기'); ?></button>
        </div>
    </aside>
    </form>
    <script>
        $(function (){
        var $hd_sch = $("#hd_sch");
        $("#hd_sch_open").click(function(){
            $hd_sch.css("display","block");
        });
        $("#hd_sch .pop_close").click(function(){
            $hd_sch.css("display","none");
        });
    });

    function search_submit(f) {
        if (f.q.value.length < 2) {
            alert("<?php echo _t('검색어는 두글자 이상 입력하십시오.'); ?>");
            f.q.select();
            f.q.focus();
            return false;
        }

        f.q.style.display = 'none'; /// chrome 버그. 추가
        return true;
    }
    </script>
    <!-- 상품 검색 끝 -->

    <ul id="hd_mb">
        <?php if ($is_member) { ?>
        <?php if ($is_admin) {  ?>
        <li><a href="<?php echo G5_ADMIN_URL ?>/shop_admin/"><b><?php echo _t('관리자'); ?></b></a></li>
        <li><a href="<?php echo G5_ADMIN_URL ?>/builder/mobile/basic_tmpl_config_form.php"><b><?php echo _t('빌더관리'); ?></b></a></li>
        <?php }  ?>
        <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php"><?php echo _t('정보수정'); ?></a></li>
        <li><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop"><?php echo _t('로그아웃'); ?></a></li>
        <?php } else { ?>
        <li><a href="<?php echo G5_BBS_URL ?>/register.php" id="snb_join"><?php echo _t('회원가입'); ?></a></li>
        <li><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><?php echo _t('로그인'); ?></a></li>
        <?php } ?>
        <li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php"><?php echo _t('마이페이지'); ?></a></li>
        <li><a href="<?php echo G5_SHOP_URL; ?>/cart.php"><?php echo _t('장바구니'); ?></a></li>
        <li><a href="<?php echo G5_SHOP_URL; ?>/personalpay.php"><?php echo _t('개인결제'); ?></a></li>
        <li><a href="<?php echo G5_SHOP_URL; ?>/couponzone.php"><?php echo _t('쿠폰존'); ?></a></li>
        <li><a href="<?php echo G5_BBS_URL; ?>/faq.php"><?php echo _t('FAQ'); ?></a></li>
        <li><a href="<?php echo G5_BBS_URL; ?>/qalist.php"><?php echo _t('1:1문의'); ?></a></li>
        <?php if(!$default['de_root_index_use']) { ?>
        <li><a href="<?php echo G5_BBS_URL; ?>/group.php?gr_id=board"><?php echo _t('커뮤니티'); ?></a></li>
        <?php } ?>
    </ul>

</header>

<div id="container">
    <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><h1 id="container_title"><?php echo _t($g5['title']) ?></h1><?php } ?>
