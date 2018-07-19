1. 사용법

1.1 tail.sub.php 파일 열기
1.2  <?php include_once(G5_ANALYTICS_PATH."/analyticstracking.php") ?>  코드 추가

2. extend -> analytics.config.php 파일 열기
2.1 
define('NAVER_ANALYTICS_CODE', 'navercode');	//네이버 애널리틱스 코드
define('GOOGLE_ANALYTICS_CODE', 'googlecode');	//구글 애널리틱스 코드
 
위 두 상수에 구글과 네이버 애널리틱스 코드를 넣어준다.
