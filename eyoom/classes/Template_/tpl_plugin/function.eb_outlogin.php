<?php

function eb_outlogin($skin_dir='basic')
{
    global $config, $member, $eyoom, $g5, $urlencode, $is_admin, $is_member, $memo_not_read, $eyoomer, $respond, $tpl, $tpl_name, $eb, $levelinfo, $levelset;

    if (array_key_exists('mb_nick', $member)) {
        $nick  = cut_str($member['mb_nick'], $config['cf_cut_name']);
    }
    if (array_key_exists('mb_point', $member)) {
        $point = number_format($member['mb_point']);
    }

    if ($is_member) {
        $is_auth = false;
        $sql = " select count(*) as cnt from {$g5['auth_table']} where mb_id = '{$member['mb_id']}' ";
        $row = sql_fetch($sql);
        if ($row['cnt'])
            $is_auth = true;
    }

    $outlogin_url        = login_url($urlencode);
    $outlogin_action_url = G5_HTTPS_BBS_URL.'/login_check.php';

    if ($is_member) {
		$outlogin = "outlogin.skin.2.html";

		// Eyoom Member 추가
		if(!$eyoomer['mb_id']) {
			sql_query(" insert into {$g5['eyoom_member']} set mb_id = '{$wr_mb_id}' ");
		}

		// 내글 반응이 음수라면 0 으로 셋팅
		$respond = $eyoomer['respond'];
		if($respond < 0) {
			$respond = 0;
			sql_query("update {$g5['eyoom_member']} set respond = 0 where mb_id='{$member['mb_id']}'");
		}
		
		// 프로필 사진 정보 
		$_photo = G5_DATA_PATH."/member/profile/".$eyoomer['photo'];
		if(file_exists($_photo) && $eyoomer['photo']) {
			$profile_photo = '<img src="'.G5_DATA_URL.'/member/profile/'.$eyoomer['photo'].'">';
		} else {
			$profile_photo = '<i class="fa fa-user"></i>';
		}

		// 레벨 진행바
		$lvinfo = $eb->eyoom_level_info($member);
		$lvset = $member['mb_level'] . '|' . $eyoomer['level'];
		$lv = $eb->level_info($lvset);

	} else {
		$outlogin = "outlogin.skin.1.html";
	}
	
	// 소셜로그인
	if ($eyoom['use_social_login'] == 'y') { // 편리님 제공 소셜로그인
		if((defined('G5_NAVER_OAUTH_CLIENT_ID') && G5_NAVER_OAUTH_CLIENT_ID) || (defined('G5_KAKAO_OAUTH_REST_API_KEY') && G5_KAKAO_OAUTH_REST_API_KEY) || (defined('G5_FACEBOOK_CLIENT_ID') && G5_FACEBOOK_CLIENT_ID) || (defined('G5_GOOGLE_CLIENT_ID') && G5_GOOGLE_CLIENT_ID)) {
			$social_oauth_url = G5_PLUGIN_URL.'/oauth/login.php?service=';
		}
	} else if ($config['cf_social_login_use']) {
		$social_pop_once = false;
		
		$self_url = G5_BBS_URL."/login.php";
		
		//새창을 사용한다면
		if( G5_SOCIAL_USE_POPUP ) {
		    $self_url = G5_SOCIAL_LOGIN_URL.'/popup.php';
		}
	}

	$tpl->define(array(
		'pc'		=> 'skin_pc/outlogin/' . $skin_dir . '/'.$outlogin,
		'mo'		=> 'skin_mo/outlogin/' . $skin_dir . '/'.$outlogin,
		'bs'		=> 'skin_bs/outlogin/' . $skin_dir . '/'.$outlogin,
		'oauth_pc'	=> 'skin_pc/outlogin/' . $skin_dir . '/social_button.skin.html',
		'oauth_mo'	=> 'skin_mo/outlogin/' . $skin_dir . '/social_button.skin.html',
		'oauth_bs'	=> 'skin_bs/outlogin/' . $skin_dir . '/social_button.skin.html',
	));

	$tpl->assign(array(
		"is_admin" => $is_admin,
		"is_auth" => $is_auth,
		"nick" => $nick,
		"point" => $point,
		"lvinfo" => $lvinfo,
		"lv" => $lv,
		"levelset" => $levelset,
		"respond" => $respond,
		"eyoomer" => $eyoomer,
		"eyoom" => $eyoom,
		"config" => $config,
		"profile_photo" => $profile_photo,
		"memo_not_read" => $memo_not_read,
		"outlogin_url" => $outlogin_url,
		"outlogin_action_url" => $outlogin_action_url,
		"social_oauth_url" => $social_oauth_url,
		"self_url" => $self_url,
		"social_pop_once" => $social_pop_once,
	));
	$tpl->print_($tpl_name);

}
?>