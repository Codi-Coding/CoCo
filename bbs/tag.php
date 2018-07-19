<?php
include_once('./_common.php');

if (isset($_REQUEST['sort']))  {
    $sort = trim($_REQUEST['sort']);
    $sort = preg_replace("/[\<\>\'\"\%\=\(\)\s]/", "", $sort);
} else {
    $sort = '';
}

//태그삭제, 리카운트
if($is_admin == 'super' && $opt) {

	if($opt == 'del') {
		$cn = $_POST['chk_id'];
		$cnt = count($cn);
		for($i=0; $i < $cnt; $i++) {
			$n = $cn[$i];
			$id = $_POST['id'][$n];

			if(!$id) continue;

			//태그삭제
			sql_query(" delete from {$g5['apms_tag']} where id = '$id' ", false);

			//로그없는 태그도 삭제
			sql_query(" delete from {$g5['apms_tag']} where cnt = '0' ", false);

			//태그로그
			sql_query(" delete from {$g5['apms_tag_log']} where tag_id = '$id' ", false);
		}

		$go_url = './tag.php';
		if($sort) $go_url .= '?sort='.$sort;
	
		goto_url($go_url);

	} else if($opt == 'cnt') {

		// 등록일이 없는 태그로그 삭제
        sql_query(" delete from {$g5['apms_tag_log']} where it_time = '0000-00-00 00:00:00' ", false);

		$result = sql_query(" select * from {$g5['apms_tag']} ", false);
	    while ($row = sql_fetch_array($result)) {
			$cnt = sql_fetch(" select count(*) as cnt from {$g5['apms_tag_log']} where tag_id = '{$row['id']}' ", false);			
			if($row['cnt'] != $cnt['cnt']) {
				sql_query("update {$g5['apms_tag']} set cnt = '{$cnt['cnt']}' where id = '{$row['id']}'", false);
			}
		}

		$go_url = './tag.php';
		goto_url($go_url);
	}
}

// Page ID
$pid = ($pid) ? $pid : 'tag';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$tag_skin_path = get_skin_path('tag', (G5_IS_MOBILE ? $config['as_mobile_tag_skin'] : $config['as_tag_skin']));
$tag_skin_url  = get_skin_url('tag', (G5_IS_MOBILE ? $config['as_mobile_tag_skin'] : $config['as_tag_skin']));

// 스킨 체크
list($tag_skin_path, $tag_skin_url) = apms_skin_thema('tag', $tag_skin_path, $tag_skin_url); 

// 설정값 불러오기
$is_tag_sub = false;
@include_once($tag_skin_path.'/config.skin.php');

$g5['title'] = '태그박스';

if($is_tag_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $tag_skin_path;
$skin_url = $tag_skin_url;

// 검색결과
if($q || $stx) {
	$q = ($stx) ? $stx : $q;
	$q = strip_tags($q);
	$q = get_search_string($q); // 특수문자 제거

    $op1 = '';

    // 검색어를 구분자로 나눈다. 여기서는 공백
    $s = explode(',', strip_tags($q));

    // 검색필드를 구분자로 나눈다. 여기서는 +
    $field = array('tag');

    $str = '(';
    for ($i=0; $i<count($s); $i++) {
        if (trim($s[$i]) == '') continue;

        $search_str = $s[$i];

        // 인기검색어
        //insert_popular($field, $search_str);

        $str .= $op1;
        $str .= "(";

        $op2 = '';
        // 필드의 수만큼 다중 필드 검색 가능 (필드1+필드2...)
        for ($k=0; $k<count($field); $k++) {
            $str .= $op2;
			
			if($eq) { //포함일 경우
				if (preg_match("/[a-zA-Z]/", $search_str))
					$str .= "INSTR(LOWER({$field[$k]}), LOWER('{$search_str}'))";
				else
					$str .= "INSTR({$field[$k]}, '{$search_str}')";
			} else { //일치
				$str .= "{$field[$k]} = '{$search_str}'";
			}
            $op2 = " or ";
        }
        $str .= ")";

        $op1 = " or ";

    }
    $str .= ")";

    $sql_search = $str;

	$sql_common = "from {$g5['apms_tag_log']} where $str group by it_id, bo_table, wr_id";

	$row = sql_query(" select count(*) as cnt $sql_common ");
	$total_cnt = @sql_num_rows($row);

    $rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];

	$total_count = $total_cnt;
	$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
	$page = ($page > 1) ? $page : 1; // 페이지가 없으면 첫 페이지 (1 페이지)
	$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	$result = sql_query(" select * $sql_common order by id desc limit $start_rows, $rows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		if(IS_YC && $row['it_id']) {
			$post = sql_fetch(" select * from {$g5['g5_shop_item_table']} where it_id = '{$row['it_id']}' ", false);
			$list[$i]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
			$list[$i]['subject'] = apms_get_text($post['it_name']);
			$list[$i]['content'] = apms_cut_text($post['it_explan'], 300);
			$list[$i]['hit'] = $post['it_hit'];
			$list[$i]['date'] = strtotime($post['it_time']);
			$list[$i]['comment'] = $post['pt_comment'];
			$list[$i]['img'] = apms_it_thumbnail($post, 0, 0);
		} else {
			$post = sql_fetch(" select * from {$g5['write_prefix']}{$row['bo_table']} where wr_id = '{$row['wr_id']}' ", false);
			$list[$i]['href'] = G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row['wr_id'];
			$list[$i]['subject'] = apms_get_text($post['wr_subject']);

			// 비밀글은 검색 불가
            if (strstr($post['wr_option'], 'secret'))
                $post['wr_content'] = '[비밀글 입니다.]';

			$list[$i]['content'] = apms_cut_text($post['wr_content'], 300);
			$list[$i]['img'] = apms_wr_thumbnail($row['bo_table'], $post, 0, 0);
			$list[$i]['hit'] = $post['wr_hit'];
			$list[$i]['comment'] = $post['wr_comment'];
			$list[$i]['date'] = strtotime($post['wr_datetime']);
		}
	}

	$write_page_rows = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
	$list_page = $_SERVER['PHP_SELF'].'?q='.urlencode($q).'&amp;eq='.$eq.'&amp;page=';

	$skin_file = $skin_path.'/tag.search.skin.php';

} else {
	$rank = 10; //랭킹묶음
	$trow = 100; //페이지당 출력 태그수

	//등록태그 현황
	$row = sql_fetch(" select count(*) as cnt from {$g5['apms_tag']} where cnt > 0 ");
	$total_cnt = $row['cnt'];

	$total_count = $total_cnt;
	$total_page  = ceil($total_count / $trow);  // 전체 페이지 계산
	if($page > $total_page) {
		$start_row = $trow = 0;
	} else {
		$page = ($page > 1) ? $page : 1; // 페이지가 없으면 첫 페이지 (1 페이지)
		$start_row = ($page - 1) * $trow; // 시작 열을 구함
	}

	if($sort == 'index') {
		$idx = '';
		$result = sql_query(" select * from {$g5['apms_tag']} where cnt > 0 order by type, idx, tag, cnt desc limit $start_row, $trow ");
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row;
			$list[$i]['href'] = './tag.php?q='.urlencode($row['tag']);
			$list[$i]['is_sp'] = ($idx != $row['idx']) ? true : false;
			$idx = $row['idx'];
		}
	} else if($sort == 'popular') {
		$result = sql_query(" select * from {$g5['apms_tag']} where cnt > 0 order by cnt desc, type, idx, tag limit $start_row, $trow ");
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row;
			$list[$i]['rank'] = ($page > 1) ? $i + $start_row + 1 : $i + 1;
			$list[$i]['href'] = './tag.php?q='.urlencode($row['tag']);
			$list[$i]['is_sp'] = ($i%$rank == 0) ? true : false;
			$list[$i]['last'] = $i + $rank + $start_row;
		}
	} else {
		$idx = '';
		$result = sql_query(" select * from {$g5['apms_tag']} where cnt > 0 order by year(lastdate) desc, month(lastdate) desc, cnt desc, type, idx, tag limit $start_row, $trow ");
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$row['date'] = strtotime(date('Y-m-01 00:00:00', strtotime($row['lastdate'])));
			$list[$i] = $row;
			$list[$i]['href'] = './tag.php?q='.urlencode($row['tag']);
			$list[$i]['is_sp'] = ($idx != $row['date']) ? true : false;
			$idx = $row['date'];
		}
	}

	$list_cnt = count($list);
	$write_page_rows = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
	$list_page = ($sort) ? $_SERVER['PHP_SELF'].'?sort='.$sort.'&amp;page=' : $_SERVER['PHP_SELF'].'?page=';

	$skin_file = $skin_path.'/tag.skin.php';
}

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('tag_mobile') : apms_skin_set('tag');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=tag&amp;ts='.urlencode(THEMA);
}

include_once($skin_file);

if($is_admin == 'super') {
	echo '<br><p align="center"><a href="./tag.php?opt=cnt">태그 리카운트 실행</a></p>'.PHP_EOL;
}

if($is_tag_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>