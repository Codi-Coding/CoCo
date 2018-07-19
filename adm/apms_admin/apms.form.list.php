<?php
$sub_menu = '400200';
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

// 액션이 있으면
if($act) {

	check_admin_token();

	if($act == "add") {
		$_POST = array_map_deep('trim', $_POST);

		$sql = " insert into {$g5['apms_form']}
					set pi_show             = '{$_POST['pi_show']}',
						pi_order            = '{$_POST['pi_order']}',
						pi_file             = '{$_POST['pi_file']}',
						pi_name		        = '{$_POST['pi_name']}',
						pi_use		        = '{$_POST['pi_use']}' ";
		sql_query($sql);

	} else if($act == "del") {
        $sql = " delete from {$g5['apms_form']} where pi_id = '$pi_id' ";
        sql_query($sql);

	} else if($act == "edit") {
		$count = count($_POST['pi_id']);
		for ($i=0; $i<$count; $i++) {
			$_POST = array_map_deep('trim', $_POST);

		    if(!$_POST['pi_id'][$i])
			    continue;

			$sql = " update {$g5['apms_form']}
						set pi_show             = '{$_POST['pi_show'][$i]}',
							pi_order            = '{$_POST['pi_order'][$i]}',
							pi_file             = '{$_POST['pi_file'][$i]}',
							pi_name		        = '{$_POST['pi_name'][$i]}',
							pi_use		        = '{$_POST['pi_use'][$i]}'
					  where pi_id = '{$_POST['pi_id'][$i]}' ";
			sql_query($sql);
		}
	}

	goto_url("./apms.form.list.php");
}

$sql = " select * from {$g5['apms_form']} order by pi_show desc, pi_order, pi_id ";
$result = sql_query($sql);

$g5['title'] = "등록폼 관리";
include_once(G5_ADMIN_PATH.'/admin.head.php');

$formlist = array();
$formlist = apms_form_list();

$colspan = 6;
?>
<script src="<?php echo G5_ADMIN_URL ?>/apms_admin/apms.admin.js"></script>
<div class="local_desc01 local_desc">
    <p>등록폼은 php 파일만 가능하며, /skin/apms/form 폴더에 업로드 되어 있어야만 폼파일 선택목록에 출력됩니다.</p>
</div>

<form name="fformadd" id="fformadd" method="post" action="./apms.form.list.php" onsubmit="return fformadd_submit(this);">
<input type="hidden" name="token" value="">
<input type="hidden" name="act" value="add">

<div id="formadd" class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 추가</caption>
    <thead>
    <tr>
        <th scope="col">사용</th>
        <th scope="col">순서</th>
		<th scope="col">폼파일</th>
        <th scope="col">폼이름</th>
        <th scope="col">파트너사용</th>
        <th scope="col">비고</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="td_mng">
            <input type="checkbox" name="pi_show" value="1" id="pi_show">
        </td>
        <td class="td_mng">
            <input type="text" name="pi_order" value="" id="pi_order" class="frm_input" size="4">
        </td>
		<td class="td_img">
            <select name="pi_file" id="pi_file">
				<?php echo apms_form_list_option($formlist);?>
            </select>
        </td>
        <td>
            <input type="text" name="pi_name" value="" id="pi_name" required class="required frm_input" size="50">
        </td>
        <td class="td_mng">
            <input type="checkbox" name="pi_use" value="1" id="pi_use">
        </td>
        <td class="td_mng">

        </td>
	</tr>
    </tbody>
    </table>
</div>
<div class="btn_list01 btn_list" style="text-align:center;">
	<input type="submit" value="등록하기">
</div>
</form>

<div class="local_desc01 local_desc">
    <p><strong>주의!</strong> 사용이 체크되어 있어야 출력되며, 등록폼 설정 작업 후 반드시 <strong>확인</strong>을 누르셔야 저장됩니다.</p>
</div>

<form name="fformlist" id="fformlist" method="post" action="./apms.form.list.php" onsubmit="return fformlist_submit(this);">
<input type="hidden" name="token" value="<?php echo $token ?>">
<input type="hidden" name="act" value="edit">

<div id="formlist" class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">사용</th>
        <th scope="col">순서</th>
		<th scope="col">폼파일</th>
        <th scope="col">폼이름</th>
        <th scope="col">파트너사용</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
    <tr>
        <td class="td_mng">
            <input type="hidden" name="pi_id[<?php echo $i; ?>]" value="<?php echo $row['pi_id'];?>">
            <input type="checkbox" name="pi_show[<?php echo $i; ?>]" value="1" id="pi_show_<?php echo $i; ?>"<?php echo ($row['pi_show'] ? ' checked' : ''); ?>>
        </td>
        <td class="td_mng">
            <input type="text" name="pi_order[<?php echo $i; ?>]" value="<?php echo $row['pi_order'] ?>" id="pi_order_<?php echo $i; ?>" class="frm_input" size="4">
        </td>
		<td class="td_img">
            <select name="pi_file[<?php echo $i; ?>]" id="pi_file_<?php echo $i; ?>">
				<?php echo apms_form_list_option($formlist, $row['pi_file']);?>
            </select>
        </td>
        <td>
            <input type="text" name="pi_name[<?php echo $i; ?>]" value="<?php echo $row['pi_name'] ?>" id="pi_name_<?php echo $i; ?>" required class="required frm_input" size="50">
        </td>
        <td class="td_mng">
            <input type="checkbox" name="pi_use[<?php echo $i; ?>]" value="1" id="pi_use_<?php echo $i; ?>"<?php echo ($row['pi_use'] ? ' checked' : ''); ?>>
        </td>
        <td class="td_mng">
            <a href="./apms.form.list.php?pi_id=<?php echo $row['pi_id'];?>&act=del" class="btn_del_form">삭제</a>
        </td>
    </tr>
    <?php
    }

    if ($i==0)
        echo '<tr id="empty_form_list"><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" name="act_button" value="확인" class="btn_submit">
    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/categorylist.php" class="btn">분류목록</a>
</div>

</form>

<script>
	var form_del = function(href) {
		if(confirm("등록폼을 삭제하시겠습니까?")) {
			apms_token(href);
		}
		return false;
	}

	$(function() {
		$(".btn_del_form").click(function() {
			form_del(this.href);
			return false;
		});
	});

	function fformadd_submit(f) {
		if(!confirm("등록폼을 추가하시겠습니까?")) {
			return false;
		}
	}

	function fformlist_submit(f) {
		return true;
	}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
