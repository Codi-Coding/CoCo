http://www.g4m.kr 

관련 문의는 질문답변란을 이용해 주세요. 이하 존칭 생략합니다.


- 설치 
m/*, extend/* 파일을 그누보드 설치 디렉토리에 업로드
m/install/ 을 웹에서 접속한다. 모바일에 필요한 추가 필드가 생성된다. 설치 완료후 install은 삭제하거나 이름을 변경한다.

설치 완료

- 모바일로 자동 이동하기 

pc버전 그누보드/index.php 파일

include_once "./_common.php"; 아래에 추가할것

//모바일 자동 이동
$chk_mobile = chkMobile();
if($_GET['from'] == 'mobile'){
    //새션 생성 이유는 모바일기기에서 PC버전 갔을경우 index.php을 다시 접속했을때 모바일로 오지않고 pc버전 유지하기 위해서이다.
    set_session("frommoblie", "1");
}
 
//모바일페이지로 이동,
if($chk_mobile == true && !$_SESSION['frommoblie']){
    header("location:/{$g4['g4m_path'] }");
}

 - PC 버전 하단에 모바일 링크 제공
 그누보드/tail.php 에 추가 또는 사이트에 맞게 아래 내용을 추가할것
  
  <a href="<?php echo $g4[path]?>/m/?from=pc">모바일</a> 

PC버전 이동 링크클릭시 모바일 자동이동이 해제 되는데 위 링크는 frommoblie세션을 삭제해 모바일로 PC접버전 접속시 자동으로 모바일로 이동되게 한다.

- 모바일 index.php 상단에 아래 추가  include_once "./_common.php"; 아래에 추가할것
//모바일 기기에서 PC버전 페이지의 모바일가기 링크 클릭하면 세션을 삭제.
if($_GET['from'] == 'pc'){
    set_session("frommoblie", "");
}

- 그룹메뉴 출력하지 않기
m/head.php 파일 65라인
<?php
//gr_m_sort 를 정렬에 사용한다.
$hide_group = "group_1"; //출력하지 않을 그룹 id 입력, 여러 그룹일 경우 쉼표(,)로 구분
echo group_menu($hide_group);
?>

설명대로 수정한다.

- 게시판 출력하지 않기 
그룹 출력과 무관하게 index.php파일에서는 모든 게시판이 출력된다. 
각 게시판 모바일설정(M)에 들어가서 모바일 출력 설정을 수정한다.
