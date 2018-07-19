<?php
include_once('./_common.php');

if (!$board['bo_table']) {
   alert(aslang('alert', 'is_board'), G5_URL); //존재하지 않는 게시판입니다.
}

check_device($board['bo_device']);

if (isset($write['wr_is_comment']) && $write['wr_is_comment']) {
    goto_url('./board.php?bo_table='.$bo_table.'&amp;wr_id='.$write['wr_parent'].'#c_'.$wr_id);
}

if (!$bo_table) {
    //$msg = "bo_table 값이 넘어오지 않았습니다.\\n\\nboard.php?bo_table=code 와 같은 방식으로 넘겨 주세요.";
    alert(aslang('alert', 'is_bo_table'));
}

// 글검색 권한
if ($stx && $sfl && $member['mb_level'] < $board['as_search']) {
	$slvl = 'xp_grade'.$board['as_search'];
	//$msg = $xp[$slvl]."(".$board['as_search'].")등급이상 회원만 글검색 및 검색글 보기가 가능합니다.";
	alert(aslang('alert', 'is_bo_search', array($xp[$slvl], $board['as_search'])), './board.php?bo_table='.$bo_table);
}

// 목록보이기
$board['bo_use_list_view'] = ($board['bo_use_list_view'] == "1" || (!G5_IS_MOBILE && $board['bo_use_list_view'] == "2") || (G5_IS_MOBILE && $board['bo_use_list_view'] == "3")) ? true : false;

// 공지
$bo_notice_arr = explode(',', trim($board['bo_notice']));

// 그룹접근 사용
if (isset($group['gr_use_access']) && $group['gr_use_access']) {
	if ($is_guest) {
		//$msg = "비회원은 이 게시판에 접근할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.";
		alert(aslang('alert', 'is_bo_guest'), './login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr));
	}

	// 그룹관리자 이상이라면 통과
	if ($is_admin == "super" || $is_admin == "group") {
		;
	} else {
		// 그룹접근
		$sql = " select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$board['gr_id']}' and mb_id = '{$member['mb_id']}' ";
		$row = sql_fetch($sql);
		if (!$row['cnt']) {
			//$msg = '접근 권한이 없으므로 글읽기가 불가합니다.\\n\\n궁금하신 사항은 관리자에게 문의 바랍니다.';
			alert(aslang('alert', 'is_bo_group'), G5_URL);
		}
	}
}

// wr_id 값이 있으면 글읽기
if (isset($wr_id) && $wr_id) {
    // 글이 없을 경우 해당 게시판 목록으로 이동
    if (!$write['wr_id']) {
        //$msg = '글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동된 경우입니다.';
        alert(aslang('alert', 'is_bo_id'), './board.php?bo_table='.$bo_table);
    }

    // 로그인된 회원의 권한이 설정된 읽기 권한보다 작다면
    if ($member['mb_level'] < $board['bo_read_level']) {
        if ($is_member)
            alert(aslang('alert', 'is_bo_read1'), G5_URL); //글을 읽을 권한이 없습니다.
        else
            alert(aslang('alert', 'is_bo_read2'), './login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr)); //글을 읽을 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.
    }

    // 본인확인을 사용한다면
    if ($config['cf_cert_use'] && !$is_admin) {
        // 인증된 회원만 가능
        if ($board['bo_use_cert'] != '' && $is_guest) {
			//이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.
            alert(aslang('alert', 'is_bo_cert1'), './login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr));
        }

        if ($board['bo_use_cert'] == 'cert' && !$member['mb_certify']) {
			//이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 본인확인을 해주시기 바랍니다.
            alert(aslang('alert', 'is_bo_cert2'), G5_URL);
        }

        if ($board['bo_use_cert'] == 'adult' && !$member['mb_adult']) {
			//이 게시판은 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 본인확인을 다시 해주시기 바랍니다.
            alert(aslang('alert', 'is_bo_adult'), G5_URL);
        }

        if ($board['bo_use_cert'] == 'hp-cert' && $member['mb_certify'] != 'hp') {
			//이 게시판은 휴대폰 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 휴대폰 본인확인을 해주시기 바랍니다.
            alert(aslang('alert', 'is_bo_hp1'), G5_URL);
        }

        if ($board['bo_use_cert'] == 'hp-adult' && (!$member['mb_adult'] || $member['mb_certify'] != 'hp')) {
			//이 게시판은 휴대폰 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 휴대폰 본인확인을 다시 해주시기 바랍니다.
            alert(aslang('alert', 'is_bo_hp2'), G5_URL);
        }
    }

    // 자신의 글이거나 관리자라면 통과
    if (($write['mb_id'] && $write['mb_id'] === $member['mb_id']) || $is_admin) {
        ;
    } else {
        // 비밀글이라면
        if (strstr($write['wr_option'], "secret"))
        {
            // 회원이 비밀글을 올리고 관리자가 답변글을 올렸을 경우
            // 회원이 관리자가 올린 답변글을 바로 볼 수 없던 오류를 수정
            $is_owner = false;
            if ($write['wr_reply'] && $member['mb_id'])
            {
                $sql = " select mb_id from {$write_table}
                            where wr_num = '{$write['wr_num']}'
                            and wr_reply = ''
                            and wr_is_comment = 0 ";
                $row = sql_fetch($sql);
                if ($row['mb_id'] === $member['mb_id'])
                    $is_owner = true;
            }

            $ss_name = 'ss_secret_'.$bo_table.'_'.$write['wr_num'];

            if (!$is_owner)
            {
                //$ss_name = "ss_secret_{$bo_table}_{$wr_id}";
                // 한번 읽은 게시물의 번호는 세션에 저장되어 있고 같은 게시물을 읽을 경우는 다시 비밀번호를 묻지 않습니다.
                // 이 게시물이 저장된 게시물이 아니면서 관리자가 아니라면
                //if ("$bo_table|$write['wr_num']" != get_session("ss_secret"))
                if (!get_session($ss_name))
                    goto_url('./password.php?w=s&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr);
            }

            set_session($ss_name, TRUE);
        }
    }

    // 한번 읽은글은 브라우저를 닫기전까지는 카운트를 증가시키지 않음
    $ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
    if (!get_session($ss_name))
    {
        sql_query(" update {$write_table} set wr_hit = wr_hit + 1 where wr_id = '{$wr_id}' ");

        // 자신의 글이면 통과
        if ($write['mb_id'] && $write['mb_id'] === $member['mb_id']) {
            ;
        } else if ($is_guest && $board['bo_read_level'] == 1 && $write['wr_ip'] == $_SERVER['REMOTE_ADDR']) {
            // 비회원이면서 읽기레벨이 1이고 등록된 아이피가 같다면 자신의 글이므로 통과
            ;
        } else {
			// 공지글 읽기 포인트 체크
			if(!empty($bo_notice_arr) && in_array($wr_id, $bo_notice_arr)) {
				$board['bo_read_point'] = 0;
			}

            // 글읽기 포인트가 설정되어 있다면
			if($config['cf_use_point'] && $board['bo_read_point'] && $is_member) {
				if ($member['mb_point'] + $board['bo_read_point'] < 0) {
					//보유하신 포인트('.number_format($member['mb_point']).')가 없거나 모자라서 글읽기('.number_format($board['bo_read_point']).')가 불가합니다.\\n\\n포인트를 모으신 후 다시 글읽기 해 주십시오.	
					alert(aslang('alert', 'is_bo_read3', array(number_format($member['mb_point']), number_format($board['bo_read_point']))));
				}

				//$board['bo_subject'] $wr_id 글읽기
				insert_point($member['mb_id'], $board['bo_read_point'], aslang('log', 'read_point', array($board['bo_subject'], $wr_id, $write['wr_subject'])), $bo_table, $wr_id, '읽기'); 
			}
		}

		// 새글DB 업데이트
		apms_board_new('as_hit', $bo_table, $wr_id);

        set_session($ss_name, TRUE);
    }

	$is_seometa = 'view'; //SEO
    $g5['title'] = strip_tags(conv_subject($write['wr_subject'], 255))." > ".((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']);
} else {
    if ($member['mb_level'] < $board['bo_list_level']) {
        if ($member['mb_id'])
            alert(aslang('alert', 'is_bo_list1'), G5_URL); //목록을 볼 권한이 없습니다.
        else
            alert(aslang('alert', 'is_bo_list2'), './login.php?'.$qstr.'&url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.($qstr?'&amp;':''))); //목록을 볼 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.
    }

    // 본인확인을 사용한다면
    if ($config['cf_cert_use'] && !$is_admin) {
        // 인증된 회원만 가능
        if ($board['bo_use_cert'] != '' && $is_guest) {
			//이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.
            alert(aslang('alert', 'is_bo_cert1'), './login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr));
        }

        if ($board['bo_use_cert'] == 'cert' && !$member['mb_certify']) {
			//이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 본인확인을 해주시기 바랍니다.
            alert(aslang('alert', 'is_bo_cert2'), G5_URL);
        }

        if ($board['bo_use_cert'] == 'adult' && !$member['mb_adult']) {
			//이 게시판은 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 본인확인을 다시 해주시기 바랍니다.
            alert(aslang('alert', 'is_bo_adult'), G5_URL);
        }

        if ($board['bo_use_cert'] == 'hp-cert' && $member['mb_certify'] != 'hp') {
			//이 게시판은 휴대폰 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 휴대폰 본인확인을 해주시기 바랍니다.
            alert(aslang('alert', 'is_bo_hp1'), G5_URL);
        }

        if ($board['bo_use_cert'] == 'hp-adult' && (!$member['mb_adult'] || $member['mb_certify'] != 'hp')) {
			//이 게시판은 휴대폰 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 휴대폰 본인확인을 다시 해주시기 바랍니다.
            alert(aslang('alert', 'is_bo_hp2'), G5_URL);
        }
    }

    if (!isset($page) || (isset($page) && $page == 0)) $page = 1;

    $g5['title'] = ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']).' '.$page.' '.$aslang['bo_page']; //페이지
}

// 테마설정
$at = apms_gr_thema();
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

// 보드설정
$boset = array();
$boset = apms_boset();

//목록에 공지출력 기본값
$sql_apms_where = '';
$sql_apms_orderby = '';
$is_notice_list = true;
$is_link_video = true;
$is_bo_content_head = true;
$is_show_list = ($member['mb_level'] >= $board['bo_list_level'] && $board['bo_use_list_view'] && !APMS_PIM || empty($wr_id)) ? true : false;

//데모에서 보드스킨 미리보기
if($is_demo) { 
	if(isset($pvbl) && $pvbl) 
		set_session('blist', $pvbl);
	
	if(isset($pvbv) && $pvbl) 
		set_session('bview', $pvbv);

	$tmp_pvbl = get_session('blist');
	if($tmp_pvbl && is_dir($board_skin_path.'/list/'.$tmp_pvbl)) {
		$boset['list_skin'] = $pvbl = $tmp_pvbl;
		@include_once($board_skin_path.'/list/'.$tmp_pvbl.'/setup.demo.php');
	}

	$tmp_pvbv = get_session('bview');
	if($tmp_pvbv && is_dir($board_skin_path.'/view/'.$tmp_pvbv)) {
		$boset['view_skin'] = $pvbv = $tmp_pvbv;
		@include_once($board_skin_path.'/view/'.$tmp_pvbv.'/setup.demo.php');
	}
}

@include_once($board_skin_path.'/board.head.skin.php');

include_once(G5_PATH.'/head.sub.php');

//공지제외
$bo_notice_cnt = 0;
if($is_show_list) {
	if(!empty($bo_notice_arr)) {
		//$sql_apms_where .= " and wr_id not in (".implode(', ', $bo_notice_arr).") ";
		//$bo_notice_cnt = count($bo_notice_arr);
	}
}

$width = $board['bo_table_width'];
if ($width <= 100)
    $width .= '%';
else
    $width .='px';

// IP보이기 사용 여부
$ip = "";
$is_ip_view = $board['bo_use_ip_view'];
if ($is_admin) {
    $is_ip_view = true;
    if (array_key_exists('wr_ip', $write)) {
        $ip = $write['wr_ip'];
    }
} else {
    // 관리자가 아니라면 IP 주소를 감춘후 보여줍니다.
    if (isset($write['wr_ip'])) {
        $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $write['wr_ip']);
    }
}

// 분류 사용
$is_category = false;
$category_name = '';
if ($board['bo_use_category']) {
    $is_category = true;
    if (array_key_exists('ca_name', $write)) {
        $category_name = $write['ca_name']; // 분류명
    }
}

// 추천 사용
$is_good = false;
if ($board['bo_use_good'])
    $is_good = true;

// 비추천 사용
$is_nogood = false;
if ($board['bo_use_nogood'])
    $is_nogood = true;

// 최고관리자 또는 그룹관리자라면
$admin_href = ($is_designer || $is_admin === 'group') ? G5_ADMIN_URL.'/board_form.php?w=u&amp;bo_table='.$bo_table : ''; 
$setup_href = ($is_demo || $is_designer || $is_admin === 'group') ? G5_BBS_URL.'/board.setup.php?bo_table='.$bo_table : '';

include_once(G5_BBS_PATH.'/board_head.php');
@include_once($board_skin_path.'/board.skin.php');

// 게시물 아이디가 있다면 게시물 보기를 INCLUDE
if (isset($wr_id) && $wr_id) {
	// 공지글인지 체크
	$is_view_notice = (!empty($bo_notice_arr) && in_array($wr_id, $bo_notice_arr)) ? true : false;
    include_once(G5_BBS_PATH.'/view.php');
}

// 전체목록보이기 사용이 "예" 또는 wr_id 값이 없다면 목록을 보임
//if ($board['bo_use_list_view'] || empty($wr_id))
if ($is_show_list)
    include_once (G5_BBS_PATH.'/list.php');

include_once(G5_BBS_PATH.'/board_tail.php');

echo "\n<!-- 사용스킨 : ".(G5_IS_MOBILE ? $board['bo_mobile_skin'] : $board['bo_skin'])." -->\n";

include_once(G5_PATH.'/tail.sub.php');
?>
