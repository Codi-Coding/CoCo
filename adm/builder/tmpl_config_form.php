<?php
$sub_menu = "350902";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '템플릿 기본 스킨 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
<input type="hidden" name="cf_admin" value="<?php echo $config['cf_admin'] ?>">
<!--<input type="hidden" name="cf_id" value="<?php echo $config2w_config['cf_id'] ?>">-->
<input type="hidden" name="cf_id" value="<?php echo $g5['tmpl']; ?>">

<section id="anc_cf_basic">
    <div style="float:right;margin-right:19px"><?php if($g5['work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_def['cf_templete']?></div>
    <h2 class="h2_frm">템플릿 기본 스킨 설정</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table style="border:1px solid #ddd">
        <caption>기본 스킨 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_new_skin">최근게시물 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_tmpl_skin_select('new', 'cf_new_skin', 'cf_new_skin', $config2w_config['cf_new_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_search_skin">검색 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_tmpl_skin_select('search', 'cf_search_skin', 'cf_search_skin', $config2w_config['cf_search_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_connect_skin">접속자 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_tmpl_skin_select('connect', 'cf_connect_skin', 'cf_connect_skin', $config2w_config['cf_connect_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_faq_skin">FAQ 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_tmpl_skin_select('faq', 'cf_faq_skin', 'cf_faq_skin', $config2w_config['cf_faq_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_qa_skin">QA 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_tmpl_skin_select('qa', 'cf_qa_skin', 'cf_qa_skin', $config2w_config['cf_qa_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_co_skin">내용 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_tmpl_skin_select('content', 'cf_co_skin', 'cf_co_skin', $config2w_config['cf_co_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_member_skin">회원 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_tmpl_skin_select('member', 'cf_member_skin', 'cf_member_skin', $config2w_config['cf_member_skin'], 'required'); ?>
            </td>
        </tr>
	<?php if(defined('G5_USE_SHOP') && G5_USE_SHOP) { ?>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_shop_skin">쇼핑몰 스킨</label></th>
            <td>
                <?php echo get_tmpl_skin_select('shop', 'cf_shop_skin', 'cf_shop_skin', $config2w_config['cf_shop_skin'], ''); ?>
            </td>
        </tr>
	<?php } ?>
	<?php if(defined('G5_USE_CONTENTS') && G5_USE_CONTENTS) { ?>
        <tr>
            <th scope="row" style="padding-left:3px"><label for="cf_contents_skin">컨텐츠몰 스킨</label></th>
            <td>
                <?php echo get_tmpl_skin_select('contents', 'cf_contents_skin', 'cf_contents_skin', $config2w_config['cf_contents_skin'], ''); ?>
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
