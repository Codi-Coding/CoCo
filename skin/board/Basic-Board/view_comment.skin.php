<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$boset['view_skin'] = (isset($boset['view_skin']) && $boset['view_skin']) ? $boset['view_skin'] : 'basic';
$view_skin_url = $board_skin_url.'/view/'.$boset['view_skin'];
$view_skin_path = $board_skin_path.'/view/'.$boset['view_skin'];

include_once($view_skin_path.'/view_comment.skin.php');

?>