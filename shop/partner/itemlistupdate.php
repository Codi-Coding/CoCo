<?php
include_once('./_common.php');

if($is_guest) {
	alert('파트너만 이용가능합니다.', APMS_PARTNER_URL.'/login.php');
}

$is_auth = ($is_admin == 'super') ? true : false;
$is_partner = (IS_SELLER) ? true : false;

if($is_auth || $is_partner) {
	; // 통과
} else {
	alert('판매자(셀러) 파트너만 이용가능합니다.', APMS_PARTNER_URL);
}

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택수정") {

    for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

		$sql_chk = '';
		if($_POST['it_use'][$k] || $_POST['it_soldout'][$k]) { //판매 또는 품절 중이면 예약글 해제하기
			$sql_chk .= "pt_reserve_use = '0', pt_reserve = '0', ";
		}

        $sql = "update {$g5['g5_shop_item_table']}
                   set it_use         = '{$_POST['it_use'][$k]}',
                       it_soldout     = '{$_POST['it_soldout'][$k]}',
                       pt_show		  = '{$_POST['pt_show'][$k]}',
					   $sql_chk	
                       it_update_time = '".G5_TIME_YMDHIS."'
                 where it_id   = '{$_POST['it_id'][$k]}' ";
        sql_query($sql);
    }
} else if ($_POST['act_button'] == "선택삭제") {

	include_once(G5_LIB_PATH.'/apms.partner.lib.php');
	include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');

	function myshop_item_delete($it_id) {
		global $g5, $is_auth;

		//거래내역이 있으면 그냥 통과
		if(!$is_auth) {
			$ct = sql_fetch(" select it_id from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and od_id <> '' and ct_status != '쇼핑' ");
			if($ct['it_id']) return;
		}

		//삭제시작
        $sql = " select it_explan, it_mobile_explan, it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10, pt_thumb
                    from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
		$it = sql_fetch($sql);

		// 상품 이미지 삭제
		$dir_list = array();
		for($i=1; $i<=10; $i++) {
			$file = G5_DATA_PATH.'/item/'.$it['it_img'.$i];
			if(is_file($file) && $it['it_img'.$i]) {
				@unlink($file);
				$dir = dirname($file);
				delete_item_thumbnail($dir, basename($file));

				if(!in_array($dir, $dir_list))
					$dir_list[] = $dir;
			}
		}

		// 이미지디렉토리 삭제
		//for($i=0; $i<count($dir_list); $i++) {
		//    if(is_dir($dir_list[$i]))
		//        rmdir($dir_list[$i]);
		//}

		// 상, 하단 이미지 삭제
		@unlink(G5_DATA_PATH."/item/$it_id"."_h");
		@unlink(G5_DATA_PATH."/item/$it_id"."_t");

		// 장바구니 삭제
		sql_query(" delete from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '쇼핑' ");

		// 이벤트삭제
		sql_query(" delete from {$g5['g5_shop_event_item_table']} where it_id = '$it_id' ");

		// 사용후기삭제
		sql_query(" delete from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' ");

		// 상품문의삭제
		sql_query(" delete from {$g5['g5_shop_item_qa_table']} where it_id = '$it_id' ");

		// 관련상품삭제
		sql_query(" delete from {$g5['g5_shop_item_relation_table']} where it_id = '$it_id' or it_id2 = '$it_id' ");

		// 옵션삭제
		sql_query(" delete from {$g5['g5_shop_item_option_table']} where it_id = '$it_id' ");

        //------------------------------------------------------------------------
        // HTML 내용에서 에디터에 올라간 이미지의 경로를 얻어 삭제함
        //------------------------------------------------------------------------

		// 에디터 이미지 삭제
		apms_editor_image($it['it_explan'], 'del');
		apms_editor_image($it['it_mobile_explan'], 'del');
		apms_editor_image($it['pt_explan'], 'del');
		apms_editor_image($it['pt_mobile_explan'], 'del');

		// 동영상 이미지 삭제
		apms_video_thumbnail($it['pt_thumb']);

        //------------------------------------------------------------------------

		// 상품 삭제
		sql_query(" delete from {$g5['g5_shop_item_table']} where it_id = '$it_id' ");

		// 댓글삭제
		apms_delete_comment($it_id);

		// 태그삭제
		apms_delete_tag($it_id);

		// 파일삭제
		apms_delete_file('item', $it_id);

		// 폴더삭제
		apms_delete_dir($it_id);
	}

    for ($i=0; $i<count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        // 삭제함수
		$it_id = $_POST['it_id'][$k];
		myshop_item_delete($it_id);
    }
}

goto_url("./?ap=list&amp;sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>
