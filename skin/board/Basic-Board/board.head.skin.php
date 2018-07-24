<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 버튼컬러
$btn1 = (isset($boset['btn1']) && $boset['btn1']) ? $boset['btn1'] : 'black';
$btn2 = (isset($boset['btn2']) && $boset['btn2']) ? $boset['btn2'] : 'color';

// 보드상단출력
$is_bo_content_head = false;

?>