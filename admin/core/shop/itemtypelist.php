<?php
$sub_menu = '400610';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$doc = strip_tags($doc);

$action_url = EYOOM_ADMIN_URL . '/?dir=shop&amp;pid=itemtypelistupdate&amp;smode=1';

/*
$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and (ca_id like '$sel_ca_id%' or ca_id2 like '$sel_ca_id%' or ca_id3 like '$sel_ca_id%') ";
}

if ($sel_field == "")  $sel_field = "it_name";
*/

$where = " where ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " $where (ca_id like '$sca%' or ca_id2 like '$sca%' or ca_id3 like '$sca%') ";
}

if ($sfl == "")  $sfl = "it_name";

if (!$sst)  {
    $sst  = "it_id";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";

$sql_common = "  from {$g5['g5_shop_item_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select it_id,
                 it_name,
                 it_type1,
                 it_type2,
                 it_type3,
                 it_type4,
                 it_type5
          $sql_common
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

$sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
$result1 = sql_query($sql1);

for ($i=0; $row1=sql_fetch_array($result1); $i++) {
    $len = strlen($row1['ca_id']) / 2 - 1;
    $nbsp = "";
    $cate[$i] = $row1;
    $cate[$i]['len'] = $len;
    for ($j=0; $j<$len; $j++) $nbsp .= "&nbsp;&nbsp;&nbsp;";
    $cate[$i]['nbsp'] = $nbsp;
}

// 리스트
$k = 0;
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
    
    $list[$i] = $row;
    
    $list[$i]['href'] = $href;
    $list[$i]['image'] = str_replace('"', "'", get_it_image($row['it_id'], 160, 160));
	
	$list_num = $total_count - ($page - 1) * $rows;
    $list[$i]['num'] = $list_num - $k;
    $k++;
}


$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="일괄수정" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">';
$frm_submit .= '</div>';

// Paging 
$paging = $thema->pg_pages($tpl_name,"./?dir=shop&amp;pid=itemtypelist&amp;".$qstr."&amp;page=");

$atpl->assign(array(
	'cate'  => $cate,
	'frm_submit'  => $frm_submit,
));

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";