<?php
if (!defined('_GNUBOARD_')) exit;

/***
	할당된 변수는 템플릿 스킨파일(/eyoom/theme/*.html)에서 바로 사용가능
	예) $config['abc'] => <!--{config.abc}--> 또는 {config.abc}

	이곳에서 할당하지 않은 변수 사용은 "$" 를 "_"로 변경하여 사용가능
	예) $bo_table => <!--{_bo_table}--> 또는 {_bo_table}
	
	Super Global 변수는 할당하지 않고 스킨파일 어디에서도 바로 사용 가능
	-> $_GET, $_POST, $_SERVER, $_ENV, $_SESSION, $_COOKIE
	예) $_GET['abc'] => <!--{_GET.abc}--> 또는 {_GET.abc}
***/

// 변수 할당하기 
$tpl->assign(array(
	"g5"			=> $g5,
	"board"			=> $board,
	"eyoomer"		=> $eyoomer,
	"mb"			=> $mb,
	"user"			=> $user,
	"menu"			=> $menu,
	"sidemenu"		=> $sidemenu,
	"connect"		=> $connect,
	"newwin"		=> $newwin,
	"list"			=> $list,
	"colspan"		=> $colspan,
	"href"			=> $href,
	"width"			=> $width,
	"view"			=> $view,
	"view_file"		=> $view_file,
	"view_link"		=> $view_link,
	"view_sns"		=> $view_sns,
	"cmt_list"		=> $comment,
	"cmt_sns"		=> $comment_sns,
	"wr_link"		=> $wr_link,
	"wr_file"		=> $wr_file,
	"fm"			=> $fm,
	"files"			=> $files,
	"thumbs"		=> $thumbs,
	"qaconfig"		=> $qaconfig,
	"rel_list"		=> $rel_list,
	"answer"		=> $answer,
	"write"			=> $write,
	"loop"			=> $loop1,
	"memo"			=> $memo,
	"subinfo"		=> $subinfo,
	"mobile_tail"	=> $mobile_tail,
	"page"			=> $page,
	"cpage"			=> $cpage,
	"lvuser"		=> $lvuser,
	"lv"			=> $lv,
	"levelset"		=> $levelset,
	"eyoom_board"	=> $eyoom_board,
	"eb"			=> $eb,
	"latest"		=> $latest,
	"shop"			=> $shop,
	"ca"			=> $ca,
	"it"			=> $it,
	"use"			=> $use,
	"qa"			=> $qa,
	"switcher"		=> $switcher,
	"lang_alert"	=> $lang_alert,
	"lang_theme"	=> $lang_theme,
	"short_url"		=> $short_url,
	"wmode"			=> $_wmode,
	"ycard"			=> $ycard,
	"mb_ycard"		=> $mb_ycard,
	"rating"		=> $rating,
	"mb_rating"		=> $mb_rating,
	"side_layout"	=> $side_layout,
));