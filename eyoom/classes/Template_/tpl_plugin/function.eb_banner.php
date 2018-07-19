<?php

/* Return Banner Data Function */

function eb_banner($loccd) {
	global $g5, $theme, $shop_theme, $eb, $member;

	$link_path = G5_DATA_URL.'/banner/';
	
	if(!$member['mb_level']) $member['mb_level'] = 1;

	// 배너위치로 등록된 배너 불러오기
	if (defined('_SHOP_')) $theme = $shop_theme;
	$sql = "select * from {$g5['eyoom_banner']} where bn_view_level <= '{$member['mb_level']}' and bn_theme='{$theme}' and bn_location = '" . $loccd . "' and bn_state = '1' order by bn_regdt desc";
	$result = sql_query($sql, false);
	
	$this_date = date('Ymd');
	for($i=0; $row=sql_fetch_array($result); $i++) {
		if($row['bn_period'] == '2') {
			if($this_date >= $row['bn_start'] && $this_date <= $row['bn_end']) {
				$banner[$i][$row['bn_no']] = $row;
			} else continue;
		} else {
			$banner[$i][$row['bn_no']] = $row;
		}
	}
	
	$max_num = count($banner)-1;
	mt_srand ((double) microtime() * 1000000);
	$num = mt_rand(0, $max_num);
	$bn = $banner[$num];
	$bn_no = key($bn);
	$data = $banner[$num][$bn_no];
	unset($banner);

	if($data) {
		if($data['bn_type'] == 'intra') {
			$img = $data['bn_img'];
			$data['image'] = $link_path.$theme .'/'. $img;

			if($data['bn_link'] == '') $data['bn_link'] = 'nolink';

			$data['tag_img'] = '<img class="img-responsive full-width" src="'.$data['image'].'" align="absmiddle">';

			if ( $data['bn_link'] != '' && $data['bn_link'] != 'nolink' ){
				$tocken = $eb->encrypt_md5($bn_no . "||" . $_SERVER['REMOTE_ADDR'] . "||" . $data['bn_link']);
				$data['html'] = '<a id="banner_' . $data['bn_no'] . '" href="' . G5_BBS_URL . '/banner.php?tocken=' . $tocken . '" target="' . $data['bn_target'] . '">';
				$data['html'] .= $data['tag_img'];
				$data['html'] .= '</a>';
			} else {
				$data['html'] = $data['tag_img'];
			}
		} else if($data['bn_type'] == 'extra') {
			$data['html'] = stripslashes($data['bn_code']);
		}
		$banner[] = $data;
	}

	sql_query("update {$g5['eyoom_banner']} set bn_exposed = bn_exposed + 1 where bn_no = '{$bn_no}'");

	return $banner;
}

?>