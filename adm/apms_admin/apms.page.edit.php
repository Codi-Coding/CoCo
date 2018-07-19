<?php
include_once('./_common.php');

$id = apms_escape_string($id);

if(!$id) {
	alert_close('값이 넘어오지 않았습니다.');
}

$row = sql_fetch(" select * from {$g5['apms_page']} where id = '{$id}' ", false);
if(!$row['id']) {
	alert_close('등록된 문서가 아닙니다.');
}

if($act == 'ok') {
	check_admin_token();

	// 업데이트
	sql_query(" update {$g5['apms_page']} set as_content = '{$_POST['as_content']}', as_mobile_content = '{$_POST['as_mobile_content']}' where id = '{$id}' ", false);

	// 이동
	goto_url(G5_ADMIN_URL.'/apms_admin/apms.page.edit.php?id='.$id);
}

include_once(G5_EDITOR_LIB);
include_once(G5_PATH.'/head.sub.php');
?>	
<script src="<?php echo G5_ADMIN_URL ?>/admin.js"></script>
<form id="peditform" name="peditform" method="post" onsubmit="return update_submit(this);">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="act" value="ok">

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 기본 설정</caption>
        <colgroup>
            <col class="grid_2">
            <col>
        </colgroup>
        <tbody>
		<tr>
            <th scope="row">안내사항</th>
            <td>
				<a href="<?php echo G5_BBS_URL;?>/helper.php" target="_blank" class="btn_frmline win_scrap">동영상등록</a>
				<a href="<?php echo G5_BBS_URL;?>/helper.php?act=map" target="_blank" class="btn_frmline win_scrap">구글지도</a>
			</td>
		</tr>
		<tr>
            <th scope="row"><label for="as_content">PC 페이지</label></th>
            <td>
                <?php echo editor_html("as_content", get_text($row['as_content'], 0)); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="as_mobile_content">모바일 페이지</label></th>
            <td>
                <?php echo editor_html("as_mobile_content", get_text($row['as_mobile_content'], 0)); ?>
            </td>
        </tr>
        </tbody>
        </table>
	</div>

	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit" accesskey="s">
		<button type="button" onclick="self.close();" class="btn_frmline">닫기</button>
	</div>
</form>
<script>
	function update_submit(f) {

		<?php echo get_editor_js("as_content"); ?>
		<?php echo get_editor_js("as_mobile_content"); ?>

		return true;
	}

	var win_w = screen.width;
	var win_h = screen.height - 40;
	window.moveTo(0, 0);
	window.resizeTo(win_w, win_h);
</script>

<?php include_once(G5_PATH.'/tail.sub.php'); ?>