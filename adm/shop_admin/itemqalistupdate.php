<?php
$sub_menu = '400660';
include_once('./_common.php');

check_demo();

check_admin_token();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택삭제") {

    auth_check($auth[$sub_menu], 'd');

    for ($i=0; $i<count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

		// 자료 불러오기
		$row = sql_fetch(" select it_id, iq_question, iq_answer from {$g5['g5_shop_item_qa_table']} where iq_id = '{$_POST['iq_id'][$k]}' ");

		// 에디터로 첨부된 이미지 삭제
		apms_editor_image($row['iq_question'], 'del');
		apms_editor_image($row['iq_answer'], 'del');

		// 삭제
        sql_query(" delete from {$g5['g5_shop_item_qa_table']} where iq_id = '{$_POST['iq_id'][$k]}' ");

		// 상품의 질답 감소
		sql_query(" update {$g5['g5_shop_item_table']} set pt_qa = pt_qa - 1 where it_id = '{$row['it_id']}' ", false);
	}
}

goto_url("./itemqalist.php?sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>
