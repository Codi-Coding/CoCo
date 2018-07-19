<?php
$sub_menu = '400200';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

auth_check($auth[$sub_menu], "d");

check_admin_token();

switch($_POST['mode']) {
	case "update":
		if($_POST['ca_id'] === '1') $_POST['ca_id'] = '';

		if($_POST['subca_name']) {
			
			if (!$_POST['subca_skin']) {
				alert("출력스킨을 선택해 주세요.");
			}
			
			if (!$_POST['subca_mobile_skin']) {
				alert("모바일 출력스킨을 선택해 주세요.");
			}

			$ca_id = clean_xss_tags(trim($_POST['ca_id']));
			if ( $ca_id === 0 || (strlen($ca_id) == 1 && $ca_id == '0') ) $ca_id = '';
			$len = strlen($ca_id);
		    if ($len == 10)  alert("분류를 더 이상 추가할 수 없습니다.\\n\\n5단계 분류까지만 가능합니다.");
		
		    $len2 = $len + 1;
		
		    $sql = " select MAX(SUBSTRING(ca_id,$len2,2)) as max_subid from {$g5['g5_shop_category_table']} where SUBSTRING(ca_id,1,$len) = '$ca_id' ";
		    $row = sql_fetch($sql);
		
		    $subid = base_convert($row['max_subid'], 36, 10);
		    $subid += 36;
		    if ($subid >= 36 * 36) {
		        //alert("분류를 더 이상 추가할 수 없습니다.");
		        // 빈상태로
		        $subid = "  ";
		    }
		    $subid = base_convert($subid, 10, 36);
		    $subid = substr("00" . $subid, -2);
		    $subid = $ca_id . $subid;
		
		    $sublen = strlen($subid);
		    
		    $length = strlen($ca_id)+2;
			$where = " ca_id like '{$ca_id}%' and length(ca_id)=$length ";
			
			$sql = "select max(ca_order) as max from {$g5['g5_shop_category_table']} where $where";
		    $row2 = sql_fetch($sql);
			$ca_order = $row2['max'] + 1;
			
			$set = "
				ca_id					= '{$subid}',
				ca_order				= '{$ca_order}',
				ca_name					= '{$_POST['subca_name']}',
				ca_mb_id				= '{$_POST['subca_mb_id']}',
				ca_skin					= '{$_POST['subca_skin']}',
				ca_mobile_skin			= '{$_POST['subca_mobile_skin']}',
				ca_img_width			= '{$_POST['subca_img_width']}',
				ca_img_height			= '{$_POST['subca_img_height']}',
				ca_mobile_img_width		= '{$_POST['subca_mobile_img_width']}',
				ca_mobile_img_height	= '{$_POST['subca_mobile_img_height']}',
				ca_list_mod				= '{$_POST['subca_list_mod']}',
				ca_list_row				= '{$_POST['subca_list_row']}',
				ca_mobile_list_mod		= '{$_POST['subca_mobile_list_mod']}',
				ca_mobile_list_row		= '{$_POST['subca_mobile_list_row']}',
				ca_sell_email			= '{$_POST['subca_sell_email']}',
				ca_use					= '{$_POST['subca_use']}',
				ca_stock_qty			= '{$_POST['subca_stock_qty']}',
				ca_explan_html			= '{$_POST['subca_explan_html']}',
				ca_head_html			= '{$_POST['subca_head_html']}',
				ca_tail_html			= '{$_POST['subca_tail_html']}',
				ca_mobile_head_html		= '{$_POST['subca_mobile_head_html']}',
				ca_mobile_tail_html		= '{$_POST['subca_mobile_tail_html']}',
				ca_include_head			= '{$_POST['subca_include_head']}',
				ca_include_tail			= '{$_POST['subca_include_tail']}',
				ca_cert_use				= '{$_POST['subca_cert_use']}',
				ca_adult_use			= '{$_POST['subca_adult_use']}',
				ca_nocoupon				= '{$_POST['subca_nocoupon']}'
			";
			$insert = "insert into {$g5['g5_shop_category_table']} set $set";
			sql_query($insert,false);

		}
		
		if ($_POST['ca_name']) {
			if (!$_POST['ca_order']) alert("출력순서는 0값을 입력할 수 없습니다.");
			
			// 출력순서 중복값 예외처리
			if($_POST['ca_order'] != $_POST['ca_order_prev']) {
				$_code = substr($_POST['ca_id'],0,-2);
				if($_code) $where = " ca_id like '{$_code}%' and length(ca_id)='".strlen($_POST['ca_id'])."' ";
				else $where = " length(ca_id)=2 ";
				
				if ($_POST['ca_order_prev'] > $_POST['ca_order']) {
					$where .= " and ca_order >= {$_POST['ca_order']} and ca_order < {$_POST['ca_order_prev']} ";
					$sql = "update {$g5['g5_shop_category_table']} set ca_order = ca_order + 1 where $where ";
				} else if ($_POST['ca_order_prev'] < $_POST['ca_order']) {
					$where .= " and ca_order <= {$_POST['ca_order']} and ca_order > {$_POST['ca_order_prev']} ";
					$sql = "update {$g5['g5_shop_category_table']} set ca_order = ca_order - 1 where $where ";
				}
				sql_query($sql, false);
			}
			$set = "
				ca_order				= '{$_POST['ca_order']}',
				ca_name					= '{$_POST['ca_name']}',
				ca_mb_id				= '{$_POST['ca_mb_id']}',
				ca_skin					= '{$_POST['ca_skin']}',
				ca_mobile_skin			= '{$_POST['ca_mobile_skin']}',
				ca_img_width			= '{$_POST['ca_img_width']}',
				ca_img_height			= '{$_POST['ca_img_height']}',
				ca_mobile_img_width		= '{$_POST['ca_mobile_img_width']}',
				ca_mobile_img_height	= '{$_POST['ca_mobile_img_height']}',
				ca_list_mod				= '{$_POST['ca_list_mod']}',
				ca_list_row				= '{$_POST['ca_list_row']}',
				ca_mobile_list_mod		= '{$_POST['ca_mobile_list_mod']}',
				ca_mobile_list_row		= '{$_POST['ca_mobile_list_row']}',
				ca_sell_email			= '{$_POST['ca_sell_email']}',
				ca_use					= '{$_POST['ca_use']}',
				ca_stock_qty			= '{$_POST['ca_stock_qty']}',
				ca_explan_html			= '{$_POST['ca_explan_html']}',
				ca_head_html			= '{$_POST['ca_head_html']}',
				ca_tail_html			= '{$_POST['ca_tail_html']}',
				ca_mobile_head_html		= '{$_POST['ca_mobile_head_html']}',
				ca_mobile_tail_html		= '{$_POST['ca_mobile_tail_html']}',
				ca_include_head			= '{$_POST['ca_include_head']}',
				ca_include_tail			= '{$_POST['ca_include_tail']}',
				ca_cert_use				= '{$_POST['ca_cert_use']}',
				ca_adult_use			= '{$_POST['ca_adult_use']}',
				ca_nocoupon				= '{$_POST['ca_nocoupon']}'
			";

			$update = "update {$g5['g5_shop_category_table']} set $set where ca_id='{$_POST['ca_id']}' ";
			sql_query($update,false);

			// 보이기, 감추기 서브에도 일괄적용
			if($_POST['ca_use'] == '0') {
				$sql = "update {$g5['g5_shop_category_table']} set ca_use = '{$_POST['ca_use']}' where ca_id like '{$_POST['ca_id']}%' ";
				sql_query($sql,false);
			}
		}
		
		$back = EYOOM_ADMIN_URL . "/?dir=shop&pid=categorylist";
		if ($_POST['ca_id']) {
			$back .= "&id={$_POST['ca_id']}";
		}
		$msg = "카테고리 설정을 적용하였습니다.";
		break;

	case "delete":
		if(!$_POST['ca_id']) alert("잘못된 접근입니다.");
		$sql = "delete from {$g5['g5_shop_category_table']} where ca_id like '{$_POST['ca_id']}%' ";
		sql_query($sql,false);
		$back = EYOOM_ADMIN_URL . "/?dir=shop&pid=categorylist";
		$msg = "선택한 카테고리 및 하위 카테고리를 삭제하였습니다.";
		break;
}


?>
<meta charset="utf-8">
<script>
alert("<?php echo $msg;?>");
parent.document.location.href='<?php echo $back;?>';
</script>