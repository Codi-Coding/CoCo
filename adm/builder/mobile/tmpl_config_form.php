<?php
$sub_menu = "350904";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '모바일 템플릿 기본 스킨 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
<input type="hidden" name="cf_admin" value="<?php echo $config['cf_admin'] ?>">
<!--<input type="hidden" name="cf_id" value="<?php echo $config2w_m_config['cf_id'] ?>">-->
<input type="hidden" name="cf_id" value="<?php echo $g5['mobile_tmpl']; ?>">

<section id="anc_cf_basic">
    <div style="float:right;margin-right:19px"><?php if($g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['mobile_work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_m_def['cf_mobile_templete']?></div>
    <h2 class="h2_frm">모바일 템플릿 기본 스킨 설정</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table style="border:1px solid #ddd">
        <caption>기본 스킨 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_mobile_new_skin">모바일<br>최근게시물 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_tmpl_skin_select('new', 'cf_mobile_new_skin', 'cf_mobile_new_skin', $config2w_m_config['cf_mobile_new_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_mobile_search_skin">모바일 검색 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_tmpl_skin_select('search', 'cf_mobile_search_skin', 'cf_mobile_search_skin', $config2w_m_config['cf_mobile_search_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_mobile_connect_skin">모바일 접속자 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_tmpl_skin_select('connect', 'cf_mobile_connect_skin', 'cf_mobile_connect_skin', $config2w_m_config['cf_mobile_connect_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_mobile_faq_skin">모바일 FAQ 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_tmpl_skin_select('faq', 'cf_mobile_faq_skin', 'cf_mobile_faq_skin', $config2w_m_config['cf_mobile_faq_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_mobile_qa_skin">모바일 QA 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_tmpl_skin_select('qa', 'cf_mobile_qa_skin', 'cf_mobile_qa_skin', $config2w_m_config['cf_mobile_qa_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_mobile_co_skin">모바일 내용 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_tmpl_skin_select('content', 'cf_mobile_co_skin', 'cf_mobile_co_skin', $config2w_m_config['cf_mobile_co_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_mobile_member_skin">모바일<br>회원 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_tmpl_skin_select('member', 'cf_mobile_member_skin', 'cf_mobile_member_skin', $config2w_m_config['cf_mobile_member_skin'], 'required'); ?>
            </td>
        </tr>
	<?php if(defined('G5_USE_SHOP') && G5_USE_SHOP) { ?>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_mobile_shop_skin">모바일 쇼핑몰 스킨</label></th>
            <td>
                <?php echo get_mobile_tmpl_skin_select('shop', 'cf_mobile_shop_skin', 'cf_mobile_shop_skin', $config2w_m_config['cf_mobile_shop_skin'], ''); ?>
            </td>
        </tr>
	<?php } ?>
	<?php if(defined('G5_USE_CONTENTS') && G5_USE_CONTENTS) { ?>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_mobile_contents_skin">모바일 컨텐츠몰 스킨</label></th>
            <td>
                <?php echo get_mobile_tmpl_skin_select('contents', 'cf_mobile_contents_skin', 'cf_mobile_contents_skin', $config2w_m_config['cf_mobile_contents_skin'], ''); ?>
            </td>
        </tr>
	<?php } ?>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

</form>

<script>
function fconfigform_submit(f)
{
    f.action = "./tmpl_config_form_update.php";
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
