<?php
/* Return ebcontents Data Function */
function eb_contents($code) {
	global $g5, $theme, $shop_theme, $member, $tpl, $tpl_name, $is_admin;

	$link_path = G5_DATA_URL.'/ebcontents';

	if(!$member['mb_level']) $member['mb_level'] = 1;

	if (defined('_SHOP_')) $theme = $shop_theme;
	$ecinfo = sql_fetch("select * from {$g5['eyoom_ebcontents']} where ec_code = '{$code}' and ec_theme = '{$theme}' ");

	// 활성화 되어 있다면 아이템 정보를 가져오기
	if ($ecinfo['ec_state'] == '1') {
		// 이미지 슬라이더 
		$sql = "select * from {$g5['eyoom_ebcontents_item']} where ec_code = '{$code}' and ci_view_level <= '{$member['mb_level']}' and ci_theme = '{$theme}' and ci_state = '1' order by ci_sort asc ";
		$result = sql_query($sql, false);

		$this_date = date('Ymd');
		for($i=0; $row=sql_fetch_array($result); $i++) {
			if($row['ci_period'] == '2') {
				if($this_date >= $row['ci_start'] && $this_date <= $row['ci_end']) {
					$contents[$i] = $row;
				} else continue;
			} else {
				$contents[$i] = $row;
			}
			
			// 링크 처리
			$ci_link 	= unserialize($row['ci_link']);
			$ci_target 	= unserialize($row['ci_target']);
			$link = &$contents[$i]['link'];
			if (is_array($ci_link)) {
				foreach ($ci_link as $k => $href) {
					$href_var = 'href_' . ($k+1);
					$target_var = 'target_' . ($k+1);
					$contents[$i][$href_var] = $href;
					$contents[$i][$target_var] = $ci_target[$k];
					
					$link[$k]['href'] = $url;
					$link[$k]['target'] = $ci_target[$k];
				}
			}

			
			// 이미지
			$ci_img = unserialize($row['ci_img']);
			$image = &$contents[$i]['image'];
			if (is_array($ci_img)) {
				foreach ($ci_img as $k => $filename) {
					$img_var = 'img_' . ($k+1);
					$src_var = 'src_' . ($k+1);
					$img_url = $link_path . '/' . $row['ci_theme'] . '/' . $filename;
					$contents[$i][$img_var] = $filename;
					$contents[$i][$src_var] = $img_url;
					
					$image[$k]['img'] = $img_name;
					$image[$k]['src'] = $img_url;
				}
			}
		}
	}

	if ($ecinfo['ec_no']) {
		$tpl->define(array(
			'pc'	=> 'skin_pc/ebcontents/' . $ecinfo['ec_skin'] . '/ebcontents.skin.html',
			'mo'	=> 'skin_mo/ebcontents/' . $ecinfo['ec_skin'] . '/ebcontents.skin.html',
			'bs'	=> 'skin_bs/ebcontents/' . $ecinfo['ec_skin'] . '/ebcontents.skin.html',
		));
		$tpl->assign(array(
			"code" 		=> $code,
			"theme" 	=> $theme,
			"contents" 	=> $contents,
			"ecinfo"	=> $ecinfo,
			"is_admin" 	=> $is_admin,
		));
	
		 $tpl->print_($tpl_name);
	}
}