<?php
if (!defined('_GNUBOARD_')) exit;

// 스킨디렉토리를 SELECT 형식으로 얻음
if (!function_exists('get_skin_select')) {
	function get_skin_select($skin_gubun, $id, $name, $selected='', $event='') {
		$skins = get_skin_dir($skin_gubun);
		$str = "<select id=\"$id\" name=\"$name\" $event>\n";
		for ($i=0; $i<count($skins); $i++) {
			if ($i == 0) $str .= "<option value=\"\">선택</option>";
			$str .= option_selected($skins[$i], $selected);
		}
		$str .= "</select>";
		return $str;
	}
}

// 스킨경로를 얻는다
if (!function_exists('get_skin_dir')) {
	function get_skin_dir($skin, $skin_path=G5_SKIN_PATH) {
		global $g5;

		$result_array = array();

		$dirname = $skin_path.'/'.$skin.'/';
		$handle = opendir($dirname);
		while ($file = readdir($handle)) {
			if($file == '.'||$file == '..') continue;

			if (is_dir($dirname.$file)) $result_array[] = $file;
		}
		closedir($handle);
		sort($result_array);

		return $result_array;
	}
}

// 회원권한을 SELECT 형식으로 얻음
if (!function_exists('get_member_level_select')) {
	function get_member_level_select($name, $start_id=0, $end_id=10, $selected="", $event="") {
		global $g5;

		$str = "\n<select id=\"{$name}\" name=\"{$name}\"";
		if ($event) $str .= " $event";
		$str .= ">\n";
		for ($i=$start_id; $i<=$end_id; $i++) {
			$str .= '<option value="'.$i.'"';
			if ($i == $selected)
				$str .= ' selected="selected"';
			$str .= ">{$i}</option>\n";
		}
		$str .= "</select>\n";
		return $str;
	}
}

// 회원아이디를 SELECT 형식으로 얻음
if (!function_exists('get_member_id_select')) {
	function get_member_id_select($name, $level, $selected="", $event="") {
		global $g5;

		$sql = " select mb_id from {$g5['member_table']} where mb_level >= '{$level}' ";
		$result = sql_query($sql);
		$str = '<select id="'.$name.'" name="'.$name.'" '.$event.'><option value="">선택안함</option>';
		for ($i=0; $row=sql_fetch_array($result); $i++)
		{
			$str .= '<option value="'.$row['mb_id'].'"';
			if ($row['mb_id'] == $selected) $str .= ' selected';
			$str .= '>'.$row['mb_id'].'</option>';
		}
		$str .= '</select>';
		return $str;
	}
}

// 입력 폼 안내문
if (!function_exists('help')) {
	function help($help="")	{
		global $g5;

		$str  = '<span class="frm_info">'.str_replace("\n", "<br>", $help).'</span>';

		return $str;
	}
}

// 스킨경로를 얻는다
function apms_skin_dir_list($dirname, $len='') {

    $result_array = array();

    $dirname = $dirname.'/';

	if(!is_dir($dirname)) return;

	$handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if($file == "."||$file == "..") continue;

        if (is_dir($dirname.$file)) $result_array[] = $file;
    }
    closedir($handle);
    sort($result_array);

    return $result_array;
}

// 폴더내 파일을 얻는다
function apms_skin_file_list($file_path, $ext='php') {

	$arr = array();

    $file_path = $file_path.'/';

	if(!is_dir($file_path)) return;

	$handle = opendir($file_path);
	while ($file = readdir($handle)) {

		if($file == "."||$file == "..") continue;

		if($ext) {
			$tmp = apms_get_ext($file);
			if($tmp == $ext) {
				$name = explode(".".$ext, $file);
				$arr[] = $name[0];
			}
		} else {
			$arr[] = $file;
		}
	}
	closedir($handle);
	sort($arr);

	return $arr;
}

function apms_carousel_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>슬라이더</option>'.PHP_EOL;
	$options .= '<option value="1"'.get_selected('1', $value).'>페이드</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>상단이동</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>하단이동</option>'.PHP_EOL;
	$options .= '<option value="4"'.get_selected('4', $value).'>효과없음</option>'.PHP_EOL;

	return $options;
}

function apms_rank_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>최근순</option>'.PHP_EOL;
	$options .= '<option value="asc"'.get_selected('asc', $value).'>등록순</option>'.PHP_EOL;
	$options .= '<option value="date"'.get_selected('date', $value).'>날짜순</option>'.PHP_EOL;
	$options .= '<option value="hit"'.get_selected('hit', $value).'>조회순</option>'.PHP_EOL;
	$options .= '<option value="comment"'.get_selected('comment', $value).'>댓글순</option>'.PHP_EOL;
	$options .= '<option value="good"'.get_selected('good', $value).'>추천순</option>'.PHP_EOL;
	$options .= '<option value="nogood"'.get_selected('nogood', $value).'>비추천순</option>'.PHP_EOL;
	$options .= '<option value="like"'.get_selected('like', $value).'>추천-비추천순</option>'.PHP_EOL;
	$options .= '<option value="download"'.get_selected('download', $value).'>다운로드순</option>'.PHP_EOL;
	$options .= '<option value="link"'.get_selected('link', $value).'>링크방문순</option>'.PHP_EOL;
	$options .= '<option value="poll"'.get_selected('poll', $value).'>설문참여순</option>'.PHP_EOL;
	$options .= '<option value="lucky"'.get_selected('lucky', $value).'>럭키포인트순</option>'.PHP_EOL;
	$options .= '<option value="update"'.get_selected('update', $value).'>업데이트순</option>'.PHP_EOL;
	$options .= '<option value="rdm"'.get_selected('rdm', $value).'>무작위(랜덤)</option>'.PHP_EOL;

	return $options;
}

function apms_member_options($value) {

	$options = '<option value="point"'.get_selected('point', $value).'>적립포인트</option>'.PHP_EOL;
	$options .= '<option value="up"'.get_selected('up', $value).'>사용포인트</option>'.PHP_EOL;
	$options .= '<option value="np"'.get_selected('np', $value).'>보유포인트</option>'.PHP_EOL;
	$options .= '<option value="level"'.get_selected('level', $value).'>레벨</option>'.PHP_EOL;
	$options .= '<option value="follow"'.get_selected('follow', $value).'>팔로우</option>'.PHP_EOL;
	$options .= '<option value="like"'.get_selected('like', $value).'>좋아요</option>'.PHP_EOL;
	$options .= '<option value="post"'.get_selected('post', $value).'>글등록</option>'.PHP_EOL;
	$options .= '<option value="comment"'.get_selected('comment', $value).'>댓글등록</option>'.PHP_EOL;
	$options .= '<option value="chulsuk"'.get_selected('chulsuk', $value).'>출석체크</option>'.PHP_EOL;
	$options .= '<option value="new"'.get_selected('new', $value).'>신규가입</option>'.PHP_EOL;
	$options .= '<option value="recent"'.get_selected('recent', $value).'>최근접속</option>'.PHP_EOL;
	$options .= '<option value="connect"'.get_selected('connect', $value).'>현재접속</option>'.PHP_EOL;

	return $options;
}

function apms_item_rank_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>최근순</option>'.PHP_EOL;
	$options .= '<option value="hp"'.get_selected('hp', $value).'>높은가격</option>'.PHP_EOL;
	$options .= '<option value="lp"'.get_selected('lp', $value).'>낮은가격</option>'.PHP_EOL;
	$options .= '<option value="qty"'.get_selected('qty', $value).'>판매순</option>'.PHP_EOL;
	$options .= '<option value="use"'.get_selected('use', $value).'>후기순</option>'.PHP_EOL;
	$options .= '<option value="hit"'.get_selected('hit', $value).'>조회순</option>'.PHP_EOL;
	$options .= '<option value="comment"'.get_selected('comment', $value).'>댓글순</option>'.PHP_EOL;
	$options .= '<option value="good"'.get_selected('good', $value).'>추천순</option>'.PHP_EOL;
	$options .= '<option value="nogood"'.get_selected('nogood', $value).'>비추천순</option>'.PHP_EOL;
	$options .= '<option value="like"'.get_selected('like', $value).'>추천-비추천순</option>'.PHP_EOL;
	$options .= '<option value="star"'.get_selected('star', $value).'>평균별점순</option>'.PHP_EOL;
	$options .= '<option value="rdm"'.get_selected('rdm', $value).'>무작위(랜덤)</option>'.PHP_EOL;

	return $options;
}

function apms_item_type_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>전체아이템</option>'.PHP_EOL;
	$options .= '<option value="1"'.get_selected('1', $value).'>히트아이템</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>추천아이템</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>신규아이템</option>'.PHP_EOL;
	$options .= '<option value="4"'.get_selected('4', $value).'>인기아이템</option>'.PHP_EOL;
	$options .= '<option value="5"'.get_selected('5', $value).'>할인아이템</option>'.PHP_EOL;

	return $options;
}

function apms_color_options($value) {

	$options = '<option value="color"'.get_selected('color', $value).'>자동컬러</option>'.PHP_EOL;
	$options .= '<option value="red"'.get_selected('red', $value).'>Red</option>'.PHP_EOL;
	$options .= '<option value="darkred"'.get_selected('darkred', $value).'>DarkRed</option>'.PHP_EOL;
	$options .= '<option value="crimson"'.get_selected('crimson', $value).'>Crimson</option>'.PHP_EOL;
	$options .= '<option value="orangered"'.get_selected('orangered', $value).'>OrangeRed</option>'.PHP_EOL;
	$options .= '<option value="orange"'.get_selected('orange', $value).'>Orange</option>'.PHP_EOL;
	$options .= '<option value="green"'.get_selected('green', $value).'>Green</option>'.PHP_EOL;
	$options .= '<option value="lightgreen"'.get_selected('lightgreen', $value).'>LightGreen</option>'.PHP_EOL;
	$options .= '<option value="deepblue"'.get_selected('deepblue', $value).'>DeepBlue</option>'.PHP_EOL;
	$options .= '<option value="skyblue"'.get_selected('skyblue', $value).'>SkyBlue</option>'.PHP_EOL;
	$options .= '<option value="blue"'.get_selected('blue', $value).'>Blue</option>'.PHP_EOL;
	$options .= '<option value="navy"'.get_selected('navy', $value).'>Navy</option>'.PHP_EOL;
	$options .= '<option value="violet"'.get_selected('violet', $value).'>Violet</option>'.PHP_EOL;
	$options .= '<option value="yellow"'.get_selected('yellow', $value).'>Yellow</option>'.PHP_EOL;
	$options .= '<option value="lightgray"'.get_selected('lightgray', $value).'>LightGray</option>'.PHP_EOL;
	$options .= '<option value="gray"'.get_selected('gray', $value).'>Gray</option>'.PHP_EOL;
	$options .= '<option value="darkgray"'.get_selected('darkgray', $value).'>DarkGray</option>'.PHP_EOL;
	$options .= '<option value="black"'.get_selected('black', $value).'>Black</option>'.PHP_EOL;
	$options .= '<option value="white"'.get_selected('white', $value).'>White</option>'.PHP_EOL;

	return $options;
}

function apms_tab_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>일반탭</option>'.PHP_EOL;
	$options .= '<option value="-box"'.get_selected('-box', $value).'>박스탭</option>'.PHP_EOL;
	$options .= '<option value="-btn"'.get_selected('-btn', $value).'>버튼탭</option>'.PHP_EOL;
	$options .= '<option value="-line"'.get_selected('-line', $value).'>상하라인</option>'.PHP_EOL;
	$options .= '<option value="-top"'.get_selected('-top', $value).'>상단라인</option>'.PHP_EOL;
	$options .= '<option value="-bottom"'.get_selected('-bottom', $value).'>하단라인</option>'.PHP_EOL;

	return $options;
}

function apms_shadow_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>그림자 없음</option>'.PHP_EOL;
	$options .= '<option value="1"'.get_selected('1', $value).'>그림자1</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>그림자2</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>그림자3</option>'.PHP_EOL;
	$options .= '<option value="4"'.get_selected('4', $value).'>그림자4</option>'.PHP_EOL;

	return $options;
}

function apms_grade_options($value) {

	$options = '<option value="10"'.get_selected('10', $value).'>10</option>'.PHP_EOL;
	$options .= '<option value="9"'.get_selected('9', $value).'>9</option>'.PHP_EOL;
	$options .= '<option value="8"'.get_selected('8', $value).'>8</option>'.PHP_EOL;
	$options .= '<option value="7"'.get_selected('7', $value).'>7</option>'.PHP_EOL;
	$options .= '<option value="6"'.get_selected('6', $value).'>6</option>'.PHP_EOL;
	$options .= '<option value="5"'.get_selected('5', $value).'>5</option>'.PHP_EOL;
	$options .= '<option value="4"'.get_selected('4', $value).'>4</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>3</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>2</option>'.PHP_EOL;
	$options .= '<option value="1"'.get_selected('1', $value).'>1</option>'.PHP_EOL;
	return $options;
}

function apms_term_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>사용안함</option>'.PHP_EOL;
	$options .= '<option value="day"'.get_selected('day', $value).'>일자지정</option>'.PHP_EOL;
	$options .= '<option value="today"'.get_selected('today', $value).'>오늘</option>'.PHP_EOL;
	$options .= '<option value="yesterday"'.get_selected('yesterday', $value).'>어제</option>'.PHP_EOL;
	$options .= '<option value="week"'.get_selected('week', $value).'>주간</option>'.PHP_EOL;
	$options .= '<option value="month"'.get_selected('month', $value).'>이번달</option>'.PHP_EOL;
	$options .= '<option value="prev"'.get_selected('prev', $value).'>지난달</option>'.PHP_EOL;

	return $options;
}

function apms_post_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>전체글</option>'.PHP_EOL;
	$options .= '<option value="1"'.get_selected('1', $value).'>이미지글만</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>동영상글만</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>이미지+동영상글</option>'.PHP_EOL;
	$options .= '<option value="4"'.get_selected('4', $value).'>텍스트글만</option>'.PHP_EOL;

	return $options;
}

function apms_post_type_options($value) {

	$options = '<option value=""'.get_selected('', $value).'>일반글</option>'.PHP_EOL;
	$options .= '<option value="1"'.get_selected('1', $value).'>댓글</option>'.PHP_EOL;
	$options .= '<option value="2"'.get_selected('2', $value).'>원글</option>'.PHP_EOL;
	$options .= '<option value="3"'.get_selected('3', $value).'>답글</option>'.PHP_EOL;
	$options .= '<option value="4"'.get_selected('4', $value).'>별점글</option>'.PHP_EOL;
	$options .= '<option value="5"'.get_selected('5', $value).'>설문글</option>'.PHP_EOL;
	$options .= '<option value="6"'.get_selected('6', $value).'>퀴즈글</option>'.PHP_EOL;

	return $options;
}

function apms_cols_options($value, $opt='') {

	if(!$opt) $opt = '4,3,2,1,4,6,12';

	$cols = explode(",", $opt);

	$options = '';
	for($i=0; $i < count($cols); $i++) {

		$num = (int)$cols[$i];

		if(!$num) continue;

		$col = (int)(12 / $num);
		$options .= '<option value="'.$col.'"'.get_selected($col, $value).'>'.$num.'</option>'.PHP_EOL;
	}

	return $options;
}

function apms_skin_options($path, $dir, $value, $opt) {

	$path = $path.'/'.$dir;
	$skin = ($opt) ? apms_skin_file_list($path, $opt) : apms_skin_dir_list($path);
	$options = '';
	for ($i=0; $i<count($skin); $i++) {
		$options .= "<option value=\"".$skin[$i]."\"".get_selected($value, $skin[$i]).">".$skin[$i]."</option>\n";
	} 

	return $options;
}

// 상품타입복수체크용
function apms_item_type_checkbox($wset) {

	$str = '<label><input type="checkbox" name="wset[type1]" value="1"'.get_checked('1', $wset['type1']).'> <img src="'.G5_SHOP_URL.'/img/icon_hit.gif" alt=""></label> &nbsp;'.PHP_EOL;
	$str .= '<label><input type="checkbox" name="wset[type2]" value="1"'.get_checked('1', $wset['type2']).'> <img src="'.G5_SHOP_URL.'/img/icon_rec.gif" alt=""></label> &nbsp;'.PHP_EOL;
	$str .= '<label><input type="checkbox" name="wset[type3]" value="1"'.get_checked('1', $wset['type3']).'> <img src="'.G5_SHOP_URL.'/img/icon_new.gif" alt=""></label> &nbsp;'.PHP_EOL;
	$str .= '<label><input type="checkbox" name="wset[type4]" value="1"'.get_checked('1', $wset['type4']).'> <img src="'.G5_SHOP_URL.'/img/icon_best.gif" alt=""></label> &nbsp;'.PHP_EOL;
	$str .= '<label><input type="checkbox" name="wset[type5]" value="1"'.get_checked('1', $wset['type5']).'> <img src="'.G5_SHOP_URL.'/img/icon_discount.gif" alt=""></label> &nbsp;'.PHP_EOL;
	$str .= '<label><input type="checkbox" name="wset[main]" value="1"'.get_checked('1', $wset['main']).'> 메인</label>'.PHP_EOL;

	return $str;
}

?>