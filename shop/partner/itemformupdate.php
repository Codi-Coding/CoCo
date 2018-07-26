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

@mkdir(G5_DATA_PATH."/item", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/item", G5_DIR_PERMISSION);

// input vars 체크
check_input_vars();

if (!$_POST['pt_it'])
    alert("서비스종류를 선택해 주십시오.");

if(in_array($pt_it, $g5['apms_automation'])) {
	$it_sc_type = 1;
	$it_sc_method = 0;
	$it_sc_price = 0;
	$it_sc_minimum = 0;
	$it_sc_qty = 0;
}

$upload_max_filesize = number_format($default['pt_upload_size']) . ' 바이트';

//파트너 등록정보
$pt = array();
$pt = apms_partner($member['mb_id']);

// 등록제한 체크
$is_regit = 0;
$new_upoint = 0;
if(!$is_auth) {

	$upoint_where = '';
	if($ca_id) $upoint_where .= " ca_id = '$ca_id' ";
	if($upoint_where && $ca_id2) $upoint_where .= " or ";
	if($ca_id2) $upoint_where .= " ca_id = '$ca_id2' ";
	if($upoint_where && $ca_id3) $upoint_where .= " or ";
	if($ca_id3) $upoint_where .= " ca_id = '$ca_id3' ";

	// 등록제한 체크 - 가장 작은 등록제한설정을 가져옴
	if($pt['pt_limit']) { // 회원별 체크값
		$uplimit = $pt['pt_limit'];
	} else {
		$row = sql_fetch("select pt_limit from {$g5['g5_shop_category_table']} where $upoint_where and pt_limit > 0 order by pt_limit limit 1");
		$uplimit = $row['pt_limit'];
	}

	if($uplimit) { // 제한값이 있으면...
		$chk_day = date("Ymd",strtotime(G5_SERVER_TIME)); 
		$row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where date_format(it_time, '%Y%m%d') = '$chk_day' ");
		if($row['cnt'] && $row['cnt'] >= $uplimit) {
		    alert("선택하신 분류에서는 하루에 최대 ".$uplimit."개까지만 등록이 가능합니다.\\n\\n등록갯수 초과로 오늘은 더이상 등록할 수 없습니다.");
		}
	}

	// 등록비 체크	-가장 큰 등록비를 가져옴
	$row1 = sql_fetch("select pt_point from {$g5['g5_shop_category_table']} where $upoint_where order by pt_point desc limit 1");

	$upoint = $pt['pt_point'] + $row1['pt_point'];

	if($upoint) {
		$new_upoint = $upoint * (-1); //부호 전환
		if($w == "u") {
			//기존 내역
			$row2 = sql_fetch("select po_point from {$g5['point_table']} where mb_id = '{$member['mb_id']}' and po_rel_table = '@regit' and po_rel_id = '{$member['mb_id']}' and po_rel_action = '$it_id' order by po_id desc limit 1");
			$old_upoint = $row2['po_point'];
			if($old_upoint) {
				if($new_upoint != $old_upoint) { // 서로 값이 다르면...
					$now_point = $member['mb_point'] - $old_upoint + $new_upoint;
					if($now_point < 0) { //포인트가 부족하면
						$now_point = $now_point * (-1);
					    alert("보유포인트 부족으로 등록할 수 없습니다.\\n\\n{$now_point} 포인트가 더 있어야 등록할 수 있습니다.");
					}
					$is_regit = 2;
				}
			} else {
				$now_point = $member['mb_point'] + $new_upoint;
				if($now_point < 0) { //포인트가 부족하면
					$now_point = $now_point * (-1);
				    alert("보유포인트 부족으로 등록할 수 없습니다.\\n\\n{$now_point} 포인트가 더 있어야 등록할 수 있습니다.");
				}
				$is_regit = 1;
			}
		} else {
			$now_point = $member['mb_point'] + $new_upoint;
			if($now_point < 0) { //포인트가 부족하면
				$now_point = $now_point * (-1);
			    alert("보유포인트 부족으로 등록할 수 없습니다.\\n\\n{$now_point} 포인트가 더 있어야 등록할 수 있습니다.");
			}
			$is_regit = 1;
		}
	}
}

// 파일정보
if($w == "u") {
    $sql = " select it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10
                from {$g5['g5_shop_item_table']}
                where it_id = '$it_id' ";
    $file = sql_fetch($sql);

    $it_img1    = $file['it_img1'];
    $it_img2    = $file['it_img2'];
    $it_img3    = $file['it_img3'];
    $it_img4    = $file['it_img4'];
    $it_img5    = $file['it_img5'];
    $it_img6    = $file['it_img6'];
    $it_img7    = $file['it_img7'];
    $it_img8    = $file['it_img8'];
    $it_img9    = $file['it_img9'];
    $it_img10   = $file['it_img10'];
}

$it_img_dir = G5_DATA_PATH.'/item';

// 파일삭제
if ($it_img1_del) {
    $file_img1 = $it_img_dir.'/'.$it_img1;
    @unlink($file_img1);
    delete_item_thumbnail(dirname($file_img1), basename($file_img1));
    $it_img1 = '';
}
if ($it_img2_del) {
    $file_img2 = $it_img_dir.'/'.$it_img2;
    @unlink($file_img2);
    delete_item_thumbnail(dirname($file_img2), basename($file_img2));
    $it_img2 = '';
}
if ($it_img3_del) {
    $file_img3 = $it_img_dir.'/'.$it_img3;
    @unlink($file_img3);
    delete_item_thumbnail(dirname($file_img3), basename($file_img3));
    $it_img3 = '';
}
if ($it_img4_del) {
    $file_img4 = $it_img_dir.'/'.$it_img4;
    @unlink($file_img4);
    delete_item_thumbnail(dirname($file_img4), basename($file_img4));
    $it_img4 = '';
}
if ($it_img5_del) {
    $file_img5 = $it_img_dir.'/'.$it_img5;
    @unlink($file_img5);
    delete_item_thumbnail(dirname($file_img5), basename($file_img5));
    $it_img5 = '';
}
if ($it_img6_del) {
    $file_img6 = $it_img_dir.'/'.$it_img6;
    @unlink($file_img6);
    delete_item_thumbnail(dirname($file_img6), basename($file_img6));
    $it_img6 = '';
}
if ($it_img7_del) {
    $file_img7 = $it_img_dir.'/'.$it_img7;
    @unlink($file_img7);
    delete_item_thumbnail(dirname($file_img7), basename($file_img7));
    $it_img7 = '';
}
if ($it_img8_del) {
    $file_img8 = $it_img_dir.'/'.$it_img8;
    @unlink($file_img8);
    delete_item_thumbnail(dirname($file_img8), basename($file_img8));
    $it_img8 = '';
}
if ($it_img9_del) {
    $file_img9 = $it_img_dir.'/'.$it_img9;
    @unlink($file_img9);
    delete_item_thumbnail(dirname($file_img9), basename($file_img9));
    $it_img9 = '';
}
if ($it_img10_del) {
    $file_img10 = $it_img_dir.'/'.$it_img10;
    @unlink($file_img10);
    delete_item_thumbnail(dirname($file_img10), basename($file_img10));
    $it_img10 = '';
}

// 이미지업로드
if ($_FILES['it_img1']['name']) {
    if($w == 'u' && $it_img1) {
        $file_img1 = $it_img_dir.'/'.$it_img1;
        @unlink($file_img1);
        delete_item_thumbnail(dirname($file_img1), basename($file_img1));
    }
    $it_img1 = it_img_upload($_FILES['it_img1']['tmp_name'], $_FILES['it_img1']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img2']['name']) {
    if($w == 'u' && $it_img2) {
        $file_img2 = $it_img_dir.'/'.$it_img2;
        @unlink($file_img2);
        delete_item_thumbnail(dirname($file_img2), basename($file_img2));
    }
    $it_img2 = it_img_upload($_FILES['it_img2']['tmp_name'], $_FILES['it_img2']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img3']['name']) {
    if($w == 'u' && $it_img3) {
        $file_img3 = $it_img_dir.'/'.$it_img3;
        @unlink($file_img3);
        delete_item_thumbnail(dirname($file_img3), basename($file_img3));
    }
    $it_img3 = it_img_upload($_FILES['it_img3']['tmp_name'], $_FILES['it_img3']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img4']['name']) {
    if($w == 'u' && $it_img4) {
        $file_img4 = $it_img_dir.'/'.$it_img4;
        @unlink($file_img4);
        delete_item_thumbnail(dirname($file_img4), basename($file_img4));
    }
    $it_img4 = it_img_upload($_FILES['it_img4']['tmp_name'], $_FILES['it_img4']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img5']['name']) {
    if($w == 'u' && $it_img5) {
        $file_img5 = $it_img_dir.'/'.$it_img5;
        @unlink($file_img5);
        delete_item_thumbnail(dirname($file_img5), basename($file_img5));
    }
    $it_img5 = it_img_upload($_FILES['it_img5']['tmp_name'], $_FILES['it_img5']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img6']['name']) {
    if($w == 'u' && $it_img6) {
        $file_img6 = $it_img_dir.'/'.$it_img6;
        @unlink($file_img6);
        delete_item_thumbnail(dirname($file_img6), basename($file_img6));
    }
    $it_img6 = it_img_upload($_FILES['it_img6']['tmp_name'], $_FILES['it_img6']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img7']['name']) {
    if($w == 'u' && $it_img7) {
        $file_img7 = $it_img_dir.'/'.$it_img7;
        @unlink($file_img7);
        delete_item_thumbnail(dirname($file_img7), basename($file_img7));
    }
    $it_img7 = it_img_upload($_FILES['it_img7']['tmp_name'], $_FILES['it_img7']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img8']['name']) {
    if($w == 'u' && $it_img8) {
        $file_img8 = $it_img_dir.'/'.$it_img8;
        @unlink($file_img8);
        delete_item_thumbnail(dirname($file_img8), basename($file_img8));
    }
    $it_img8 = it_img_upload($_FILES['it_img8']['tmp_name'], $_FILES['it_img8']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img9']['name']) {
    if($w == 'u' && $it_img9) {
        $file_img9 = $it_img_dir.'/'.$it_img9;
        @unlink($file_img9);
        delete_item_thumbnail(dirname($file_img9), basename($file_img9));
    }
    $it_img9 = it_img_upload($_FILES['it_img9']['tmp_name'], $_FILES['it_img9']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img10']['name']) {
    if($w == 'u' && $it_img10) {
        $file_img10 = $it_img_dir.'/'.$it_img10;
        @unlink($file_img10);
        delete_item_thumbnail(dirname($file_img10), basename($file_img10));
    }
    $it_img10 = it_img_upload($_FILES['it_img10']['tmp_name'], $_FILES['it_img10']['name'], $it_img_dir.'/'.$it_id);
}

if ($w == "" || $w == "u")
{
    // 다음 입력을 위해서 옵션값을 쿠키로 한달동안 저장함
    //@setcookie("ck_ca_id",  $ca_id,  time() + 86400*31, $default[de_cookie_dir], $default[de_cookie_domain]);
    //@setcookie("ck_maker",  stripslashes($it_maker),  time() + 86400*31, $default[de_cookie_dir], $default[de_cookie_domain]);
    //@setcookie("ck_origin", stripslashes($it_origin), time() + 86400*31, $default[de_cookie_dir], $default[de_cookie_domain]);
    @set_cookie("ck_ca_id", $ca_id, time() + 86400*31);
    @set_cookie("ck_ca_id2", $ca_id2, time() + 86400*31);
    @set_cookie("ck_ca_id3", $ca_id3, time() + 86400*31);
    @set_cookie("ck_maker", stripslashes($it_maker), time() + 86400*31);
    @set_cookie("ck_origin", stripslashes($it_origin), time() + 86400*31);
}


// 관련상품을 우선 삭제함
sql_query(" delete from {$g5['g5_shop_item_relation_table']} where it_id = '$it_id' ");

// 관련상품의 반대도 삭제
sql_query(" delete from {$g5['g5_shop_item_relation_table']} where it_id2 = '$it_id' ");

if($is_auth) {
	// 이벤트상품을 우선 삭제함
	sql_query(" delete from {$g5['g5_shop_event_item_table']} where it_id = '$it_id' ");
}

// 선택옵션
sql_query(" delete from {$g5['g5_shop_item_option_table']} where io_type = '0' and it_id = '$it_id' "); // 기존선택옵션삭제

$option_count = (isset($_POST['opt_id']) && is_array($_POST['opt_id'])) ? count($_POST['opt_id']) : array();
if($option_count) {
    // 옵션명
    $opt1_cnt = $opt2_cnt = $opt3_cnt = 0;
    for($i=0; $i<$option_count; $i++) {
        $_POST['opt_id'][$i] = preg_replace(G5_OPTION_ID_FILTER, '', $_POST['opt_id'][$i]);

		$opt_val = explode(chr(30), $_POST['opt_id'][$i]);
        if($opt_val[0])
            $opt1_cnt++;
        if($opt_val[1])
            $opt2_cnt++;
        if($opt_val[2])
            $opt3_cnt++;
    }

    if($opt1_subject && $opt1_cnt) {
        $it_option_subject = $opt1_subject;
        if($opt2_subject && $opt2_cnt)
            $it_option_subject .= ','.$opt2_subject;
        if($opt3_subject && $opt3_cnt)
            $it_option_subject .= ','.$opt3_subject;
    }
}

// 추가옵션
sql_query(" delete from {$g5['g5_shop_item_option_table']} where io_type = '1' and it_id = '$it_id' "); // 기존추가옵션삭제

$supply_count = (isset($_POST['spl_id']) && is_array($_POST['spl_id'])) ? count($_POST['spl_id']) : array();
if($supply_count) {
    // 추가옵션명
    $arr_spl = array();
    for($i=0; $i<$supply_count; $i++) {
        $_POST['spl_id'][$i] = preg_replace(G5_OPTION_ID_FILTER, '', $_POST['spl_id'][$i]);

		$spl_val = explode(chr(30), $_POST['spl_id'][$i]);
        if(!in_array($spl_val[0], $arr_spl))
            $arr_spl[] = $spl_val[0];
    }

    $it_supply_subject = implode(',', $arr_spl);
}

// 상품요약정보
$value_array = array();
for($i=0; $i<count($_POST['ii_article']); $i++) {
    $key = $_POST['ii_article'][$i];
    $val = $_POST['ii_value'][$i];
    $value_array[$key] = $val;
}
$it_info_value = addslashes(serialize($value_array));

// 포인트 비율 값 체크
if(($it_point_type == 1 || $it_point_type == 2) && $it_point > 99)
    alert("포인트 비율을 0과 99 사이의 값으로 입력해 주십시오.");

$it_name = strip_tags(trim($_POST['it_name']));
if ($it_name == "")
    alert("제목 또는 상품명을 입력해 주십시오.");

// 추가값
$is_reserve = ($default['pt_reserve_end'] > 0 && $default['pt_reserve_day'] > 0 && $default['pt_reserve_cache'] > 0) ? true : false;
$is_reserve = ($is_reserve && ($is_admin == 'super' || $default['pt_reserve_use'] == "1")) ? true : false;

if($pt_reserve_use && $is_reserve) {
	if(!$pt_reserve) {
		$pt_reserve_time = "{$pt_reserve_date} {$pt_reserve_hour}:{$pt_reserve_minute}:00";
		$pt_reserve = strtotime($pt_reserve_time);
		$it_use = 0;
	}
} else {
	$pt_reserve_use = 0;
	$pt_reserve = 0;
}

if($pt_end_date && $default['pt_reserve_cache'] > 0) {
	$pt_end_time = "{$pt_end_date} {$pt_end_hour}:{$pt_end_minute}:00";
	$pt_end = strtotime($pt_end_time);
} else {
	$pt_end = 0;
}

$pt_review_sql = ($is_auth || $default['pt_review_use']) ? " pt_review_use = '$pt_review_use', " : "";
$pt_comment_sql = ($is_auth || $default['pt_comment_use']) ? " pt_comment_use = '$pt_comment_use', " : "";
$pt_syndi_sql = ($is_admin == 'super') ? " pt_syndi = '$pt_syndi', pt_commission = '$pt_commission', pt_incentive = '$pt_incentive', " : "";

$admin_sql = '';
if($is_auth) { 
	$admin_sql =  " it_type1			= '$it_type1', 
					it_type2			= '$it_type2', 
					it_type3			= '$it_type3', 
					it_type4			= '$it_type4', 
					it_type5			= '$it_type5', 
					it_sell_email		= '$it_sell_email',
		            it_head_html        = '$it_head_html',
		            it_tail_html        = '$it_tail_html',
		            it_mobile_head_html = '$it_mobile_head_html',
		            it_mobile_tail_html = '$it_mobile_tail_html',
		            it_order            = '$it_order',
		            it_tel_inq          = '$it_tel_inq',
		            it_nocoupon         = '$it_nocoupon',
		            it_cust_price       = '$it_cust_price',
					it_stock_sms		= '$it_stock_sms',
					pt_id				= '$pt_id',
					";
}

$sql_common = " ca_id               = '$ca_id',
                ca_id2              = '$ca_id2',
                ca_id3              = '$ca_id3',
                it_name             = '$it_name',
                it_maker            = '$it_maker',
                it_origin           = '$it_origin',
                it_brand            = '$it_brand',
                it_model            = '$it_model',
                it_option_subject   = '$it_option_subject',
                it_supply_subject   = '$it_supply_subject',
				it_basic            = '$it_basic',
                it_explan           = '$it_explan',
                it_explan2          = '".strip_tags(trim($_POST['it_explan']))."',
                it_mobile_explan    = '$it_mobile_explan',
                it_price            = '$it_price',
                it_point            = '$it_point',
                it_point_type       = '$it_point_type',
                it_supply_point     = '$it_supply_point',
                it_notax            = '$it_notax',
                it_use              = '$it_use',
                it_soldout          = '$it_soldout',
                it_stock_qty        = '$it_stock_qty',
                it_noti_qty         = '$it_noti_qty',
                it_sc_type          = '$it_sc_type',
                it_sc_method        = '$it_sc_method',
                it_sc_price         = '$it_sc_price',
                it_sc_minimum       = '$it_sc_minimum',
                it_sc_qty           = '$it_sc_qty',
                it_buy_min_qty      = '$it_buy_min_qty',
                it_buy_max_qty      = '$it_buy_max_qty',
                it_ip               = '{$_SERVER['REMOTE_ADDR']}',
                it_info_gubun       = '$it_info_gubun',
                it_info_value       = '$it_info_value',
                it_img1             = '$it_img1',
                it_img2             = '$it_img2',
                it_img3             = '$it_img3',
                it_img4             = '$it_img4',
                it_img5             = '$it_img5',
                it_img6             = '$it_img6',
                it_img7             = '$it_img7',
                it_img8             = '$it_img8',
                it_img9             = '$it_img9',
                it_img10            = '$it_img10',
                it_1_subj           = '$it_1_subj',
                it_2_subj           = '$it_2_subj',
                it_3_subj           = '$it_3_subj',
                it_4_subj           = '$it_4_subj',
                it_5_subj           = '$it_5_subj',
                it_6_subj           = '$it_6_subj',
                it_7_subj           = '$it_7_subj',
                it_8_subj           = '$it_8_subj',
                it_9_subj           = '$it_9_subj',
                it_10_subj          = '$it_10_subj',
                it_1                = '$it_1',
                it_2                = '$it_2',
                it_3                = '$it_3',
                it_4                = '$it_4',
                it_5                = '$it_5',
                it_6                = '$it_6',
                it_7                = '$it_7',
                it_8                = '$it_8',
                it_9                = '$it_9',
                it_10               = '$it_10',
				$admin_sql
				pt_it				= '$pt_it',
                pt_img				= '$pt_img',
                pt_ccl				= '$pt_ccl',
				pt_order			= '$pt_order',
				pt_show				= '$pt_show',
				pt_tag				= '$pt_tag',
                pt_link1			= '$pt_link1',
                pt_link2			= '$pt_link2',
				$pt_review_sql
				$pt_comment_sql
				pt_day				= '$pt_day',
				pt_end				= '$pt_end',
				pt_reserve			= '$pt_reserve',
				pt_reserve_use		= '$pt_reserve_use',
				$pt_syndi_sql
				pt_explan	        = '$pt_explan',
                pt_mobile_explan    = '$pt_mobile_explan',
				pt_msg1			    = '$pt_msg1',
                pt_msg2			    = '$pt_msg2',
                pt_msg3			    = '$pt_msg3'
				";

if ($w == "")
{
    $it_id = $_POST['it_id'];

    if (!trim($it_id)) {
        alert('코드가 없으므로 추가하실 수 없습니다.');
    }

    $t_it_id = preg_replace("/[A-Za-z0-9\-_]/", "", $it_id);
    if($t_it_id)
        alert('코드는 영문자, 숫자, -, _ 만 사용할 수 있습니다.');

	$pt_num = time();
    if(!$is_auth) $sql_common .= " , pt_id = '".$member['mb_id']."' "; //파트너 아이디 등록
    $sql_common .= " , it_time = '".G5_TIME_YMDHIS."' ";
    $sql_common .= " , it_update_time = '".G5_TIME_YMDHIS."' ";
    $sql = " insert {$g5['g5_shop_item_table']}
                set it_id = '$it_id',
					pt_num = '$pt_num',
					$sql_common	";
    sql_query($sql);

}
else if ($w == "u")
{
    $sql_common .= " , it_update_time = '".G5_TIME_YMDHIS."' ";
    $sql = " update {$g5['g5_shop_item_table']}
                set $sql_common
              where it_id = '$it_id' ";
    sql_query($sql);

}
/*
else if ($w == "d")
{
    if ($is_admin != 'super')
    {
        $sql = " select it_id from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b
                  where a.it_id = '$it_id'
                    and a.ca_id = b.ca_id
                    and b.ca_mb_id = '{$member['mb_id']}' ";
        $row = sql_fetch($sql);
        if (!$row['it_id'])
            alert("\'{$member['mb_id']}\' 님께서 삭제 할 권한이 없는 상품입니다.");
    }

    itemdelete($it_id);
}
*/

if ($w == "" || $w == "u")
{
    // 관련상품 등록
    $it_id2 = explode(",", $it_list);
    for ($i=0; $i<count($it_id2); $i++)
    {
        if (trim($it_id2[$i]))
        {
            $sql = " insert into {$g5['g5_shop_item_relation_table']}
                        set it_id  = '$it_id',
                            it_id2 = '$it_id2[$i]',
                            ir_no = '$i' ";
            sql_query($sql, false);

            // 관련상품의 반대로도 등록
            $sql = " insert into {$g5['g5_shop_item_relation_table']}
                        set it_id  = '$it_id2[$i]',
                            it_id2 = '$it_id',
                            ir_no = '$i' ";
            sql_query($sql, false);
        }
    }

    // 이벤트상품 등록
	if($is_auth) {
		$ev_id = explode(",", $ev_list);
		for ($i=0; $i<count($ev_id); $i++)
		{
			if (trim($ev_id[$i]))
			{
				$sql = " insert into {$g5['g5_shop_event_item_table']}
							set ev_id = '$ev_id[$i]',
								it_id = '$it_id' ";
				sql_query($sql, false);
			}
		}
	}
}

// 선택옵션등록
if($option_count) {
    $comma = '';
    $sql = " INSERT INTO {$g5['g5_shop_item_option_table']}
                    ( `io_id`, `io_type`, `it_id`, `io_price`, `io_stock_qty`, `io_noti_qty`, `io_use` )
                VALUES ";
    for($i=0; $i<$option_count; $i++) {
        $sql .= $comma . " ( '{$_POST['opt_id'][$i]}', '0', '$it_id', '{$_POST['opt_price'][$i]}', '{$_POST['opt_stock_qty'][$i]}', '{$_POST['opt_noti_qty'][$i]}', '{$_POST['opt_use'][$i]}' )";
        $comma = ' , ';
    }

    sql_query($sql);
}

// 추가옵션등록
if($supply_count) {
    $comma = '';
    $sql = " INSERT INTO {$g5['g5_shop_item_option_table']}
                    ( `io_id`, `io_type`, `it_id`, `io_price`, `io_stock_qty`, `io_noti_qty`, `io_use` )
                VALUES ";
    for($i=0; $i<$supply_count; $i++) {
        $sql .= $comma . " ( '{$_POST['spl_id'][$i]}', '1', '$it_id', '{$_POST['spl_price'][$i]}', '{$_POST['spl_stock_qty'][$i]}', '{$_POST['spl_noti_qty'][$i]}', '{$_POST['spl_use'][$i]}' )";
        $comma = ' , ';
    }

    sql_query($sql);
}

// 태그 및 파일 등록
$file_upload_msg = '';
if ($w == "" || $w == "u") {
	//태그등록
	$it_time = G5_TIME_YMDHIS;
	if($w == "u") {
		$row = sql_fetch("select it_time from {$g5['g5_shop_item_table']} where it_id = '{$it_id}' ");
		$it_time = $row['it_time'];
	}

	apms_add_tag($it_id, $pt_tag, $it_time);

	//파일등록
	$file_upload_msg = apms_upload_file('item', $it_id);

	// 네이버 신디
	if ($is_admin == 'super' && $it_use && $pt_syndi) {
		apms_naver_syndi_ping($it_id);
	}
}

// 등록비 기존 삭제
if($is_regit = "2") { 
	if(!delete_point($member['mb_id'], '@regit', $member['mb_id'], $it_id)) {
		insert_point($member['mb_id'], $old_upoint * (-1), "{$it_id} 등록 취소");
	}
} 

// 등록비 신규 등록
if($is_regit) { 
	insert_point($member['mb_id'], $new_upoint, "{$it_id} 등록", "@regit", $member['mb_id'], $it_id);
}

// 썸네일 업데이트
$it = apms_it($it_id);
$it['chk_img'] = true;
$it_thumb = apms_it_thumbnail($it, 0, 0, false, true);
$it_thumb = ($it_thumb) ? $it_thumb : 1;
sql_query(" update {$g5['g5_shop_item_table']} set pt_thumb = '".addslashes($it_thumb)."' where it_id = '{$it_id}' ", false);

$qstr = "$qstr&amp;sca=$sca&amp;page=$page";

if ($w == "u") {
    //goto_url("./itemform.php?w=u&amp;it_id=$it_id&amp;$qstr");
    goto_url("./?ap=item&amp;w=u&amp;it_id=$it_id&amp;fn=$fn&amp;$qstr");
} 

echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
?>
<script>
    if (confirm("계속 입력하시겠습니까?")) {
        //location.href = "<?php echo "./itemform.php?it_id=$it_id&amp;sort1=$sort1&amp;sort2=$sort2&amp;sel_ca_id=$sel_ca_id&amp;sel_field=$sel_field&amp;search=$search&amp;page=$page"?>";
        //location.href = "<?php echo "./itemform.php?".str_replace('&amp;', '&', $qstr); ?>";
        location.href = "<?php echo "./?ap=item&".str_replace('&amp;', '&', $qstr); ?>";
	} else {
        location.href = "<?php echo "./?ap=list&".str_replace('&amp;', '&', $qstr); ?>";
	}
</script>
