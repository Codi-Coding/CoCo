<?php
// 회원정보 찾기 안내 메일입니다. 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 메일제목
$subject = "[".$config['cf_title']."] 요청하신 회원정보 찾기 안내 메일입니다.";

?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>회원정보 찾기 안내</title>
</head>

<body>

<div style="margin:30px auto;width:600px;border:10px solid #f7f7f7">
	<div style="border:1px solid #dedede">
		<h1 style="padding:30px 30px 0;background:#f7f7f7;color:#555;font-size:1.4em">
			회원정보 찾기 안내
		</h1>
		<span style="display:block;padding:10px 30px 30px;background:#f7f7f7;text-align:right">
			<a href="<?php echo G5_URL;?>" target="_blank"><?php echo $config['cf_title'];?></a>
		</span>
		<p style="margin:20px 0 0;padding:30px 30px 30px;border-bottom:1px solid #eee;line-height:1.7em">
			<?php echo addslashes($mb['mb_name']);?> (<?php echo addslashes($mb['mb_nick']);?>) 회원님은 <?php echo G5_TIME_YMDHIS;?> 에 회원정보 찾기 요청을 하셨습니다.<br>
			저희 사이트는 관리자라도 회원님의 비밀번호를 알 수 없기 때문에, 비밀번호를 알려드리는 대신 새로운 비밀번호를 생성하여 안내 해드리고 있습니다.<br>
			아래에서 변경될 비밀번호를 확인하신 후, <span style="color:#ff3061"><strong>비밀번호 변경</strong> 링크를 클릭 하십시오.</span><br>
			비밀번호가 변경되었다는 인증 메세지가 출력되면, 홈페이지에서 회원아이디와 변경된 비밀번호를 입력하시고 로그인 하십시오.<br>
			로그인 후에는 정보수정 메뉴에서 새로운 비밀번호로 변경해 주십시오.
		</p>
		<p style="margin:0;padding:30px 30px 30px;border-bottom:1px solid #eee;line-height:1.7em">
			<span style="display:inline-block;width:100px">회원아이디</span> <?php echo $mb['mb_id'];?><br>
			<span style="display:inline-block;width:100px">변경될 비밀번호</span> <strong style="color:#ff3061"><?php echo $change_password;?></strong>
		</p>
		<a href="<?php echo $href;?>" target="_blank" style="display:block;padding:30px 0;background:#484848;color:#fff;text-decoration:none;text-align:center">비밀번호 변경</a>
	</div>
</div>

</body>
</html>
