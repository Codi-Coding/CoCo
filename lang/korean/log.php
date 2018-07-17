<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/*
 *  Amina Log Language
 *
 *  Copyright (c) 2015 Amina
 *  http://amina.co.kr
 *
 */

$aslang = array("lang"  => "log"

, "login_point"			=> "[0:date] 첫로그인"

// 1.7.1
, "expire_point"		=> "포인트 소멸"
, "del_recmd_point"		=> "[0:mb_id]님의 회원자료 삭제로 인한 추천인 포인트 반환"
, "delivery_point"		=> "주문번호 [0:od_id] ([1:it_id] : [2:ct_id]) 구매완료"
, "lucky_point_wr"		=> "[0:bo_subject] [1:wr_id] 럭키포인트!"
, "lucky_point_it"		=> "아이템([0:it_id]) 럭키포인트!"
, "read_point"			=> "[0:bo_subject] [1:wr_id] 글읽기" //제목 : [2:wr_subject]


);

?>