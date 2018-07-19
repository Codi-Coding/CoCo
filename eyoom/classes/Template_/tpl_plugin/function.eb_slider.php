<?php
/* Return ebslider Data Function */
function eb_slider($code) {
	global $g5, $theme, $shop_theme, $eb, $member, $tpl, $tpl_name, $is_admin;

	$link_path = G5_DATA_URL.'/ebslider';

	if(!$member['mb_level']) $member['mb_level'] = 1;

	if (defined('_SHOP_')) $theme = $shop_theme;
	$esinfo = sql_fetch("select * from {$g5['eyoom_ebslider']} where es_code = '{$code}' and es_theme = '{$theme}' ");

	// 활성화 되어 있다면 아이템 정보를 가져오기
	if ($esinfo['es_state'] == '1') {
		// 유튜브 동영상 슬라이더
		$sql = "select * from {$g5['eyoom_ebslider_ytitem']} where es_code = '{$code}' and ei_view_level <= '{$member['mb_level']}' and ei_theme = '{$theme}' and ei_state = '1' order by ei_sort asc ";
		$result = sql_query($sql, false);

		$this_date = date('Ymd');
		for($i=0; $row=sql_fetch_array($result); $i++) {
			if($row['ei_period'] == '2') {
				if($this_date >= $row['ei_start'] && $this_date <= $row['ei_end']) {
					$yt_video[$i] = $row;
				} else continue;
			} else {
				$yt_video[$i] = $row;
			}

			$slider[$i]['img_url'] = $link_path . "/{$row['ei_theme']}/{$row['ei_img']}";
		}
		
		// 이미지 슬라이더
		$sql = "select * from {$g5['eyoom_ebslider_item']} where es_code = '{$code}' and ei_view_level <= '{$member['mb_level']}' and ei_theme = '{$theme}' and ei_state = '1' order by ei_sort asc ";
		$result = sql_query($sql, false);

		$this_date = date('Ymd');
		for($i=0; $row=sql_fetch_array($result); $i++) {
			if($row['ei_period'] == '2') {
				if($this_date >= $row['ei_start'] && $this_date <= $row['ei_end']) {
					$slider[$i] = $row;
				} else continue;
			} else {
				$slider[$i] = $row;
			}
			
			// 동영상이 있는지 체크
			if (isset($yt_video) && is_array($yt_video)) {
				$slider[$i]['exist_video'] = true;
			}
			
			$slider[$i]['img_url'] = $link_path . "/{$row['ei_theme']}/{$row['ei_img']}";
		}
	}

	if ($esinfo['es_no']) {
		$tpl->define(array(
			'pc'	=> 'skin_pc/ebslider/' . $esinfo['es_skin'] . '/ebslider.skin.html',
			'mo'	=> 'skin_mo/ebslider/' . $esinfo['es_skin'] . '/ebslider.skin.html',
			'bs'	=> 'skin_bs/ebslider/' . $esinfo['es_skin'] . '/ebslider.skin.html',
		));
		$tpl->assign(array(
			"code" 		=> $code,
			"theme" 	=> $theme,
			"slider" 	=> $slider,
			"yt_video" => $yt_video,
			"esinfo" 	=> $esinfo,
			"is_admin" 	=> $is_admin,
		));
	
		 $tpl->print_($tpl_name);
	}
}