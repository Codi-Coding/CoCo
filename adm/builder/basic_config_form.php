<?php // 굿빌더 ?>
<?php
$sub_menu = "350202";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "기본 설정";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;

if (!isset($config2w_def['cf_contact_info'])) {
    sql_query(" ALTER TABLE `{$g5['config2w_def_table']}` 
    ADD `cf_contact_info` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_description`,
    ADD `cf_google_map_pos` VARCHAR(255) NOT NULL DEFAULT '',
    ADD `cf_google_map_api_key` VARCHAR(255) NOT NULL DEFAULT '',
    ADD `cf_google_captcha_api_key` VARCHAR(255) NOT NULL DEFAULT '',
    ADD `cf_google_captcha_api_secret` VARCHAR(255) NOT NULL DEFAULT '' ", false);
}

?>
<form name="fconfigform" id="fconfigform" method="post" action="./basic_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<!--<div style="float:right"><?php if($g5['work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_def['cf_templete']?></div>-->
<h2>페이지 기본 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
	<td>헤더 로고명</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_header_logo' value='<?php echo $config2w_def['cf_header_logo']?>'> <?php echo help("페이지 상단 좌측의 헤더 로고명을 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>사이트 이름</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_site_name' value='<?php echo $config2w_def['cf_site_name']?>'> 
	<?php echo help("페이지 하단의 사이트 (또는 회사) 이름을 입력하십시요.")?>
	<?php echo help("(* 미사용: '환경 설정' -> '기본 환경 설정'의 '홈 페이지 제목'을 대신 사용)")?>
	</td>
</tr>
<tr class='ht2'>
	<td>사이트 주소</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_site_addr' value='<?php echo $config2w_def['cf_site_addr']?>'> <?php echo help("페이지 하단의 사이트 주소를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>우편 번호</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_zip' value='<?php echo $config2w_def['cf_zip']?>'> <?php echo help("페이지 하단의 우편 번호를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>전화 번호</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_tel' value='<?php echo $config2w_def['cf_tel']?>'> <?php echo help("페이지 하단의 전화 번호를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>팩스</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_fax' value='<?php echo $config2w_def['cf_fax']?>'> <?php echo help("페이지 하단의 팩스 번호를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>이메일</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_email' value='<?php echo $config2w_def['cf_email']?>'> <?php echo help("페이지 하단의 이메일 주소를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>대표</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_site_owner' value='<?php echo $config2w_def['cf_site_owner']?>'> <?php echo help("페이지 하단의 대표를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>사업자 등록 번호</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_biz_num' value='<?php echo $config2w_def['cf_biz_num']?>'> <?php echo help("페이지 하단의 사업자 등록 번호를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>통신 판매업 신고 번호</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_ebiz_num' value='<?php echo $config2w_def['cf_ebiz_num']?>'> <?php echo help("페이지 하단의 통신 판매업 신고 번호를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>개인 정보 관리 책임자</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_info_man' value='<?php echo $config2w_def['cf_info_man']?>'> <?php echo help("페이지 하단의 개인 정보 관리 책임자를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>개인 정보 관리 책임자 이메일</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_info_email' value='<?php echo $config2w_def['cf_info_email']?>'> <?php echo help("페이지 하단의 개인 정보 관리 책임자 이메일을 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>저작권 명시</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_copyright' value='<?php echo $config2w_def['cf_copyright']?>'> <?php echo help("페이지 하단의 저작권 표시를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>Keywords</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_keywords' value='<?php echo $config2w_def['cf_keywords']?>'> <?php echo help("HTML 페이지 내의 meta keywords로 사용될 키워드들을 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>Description</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_description' value='<?php echo $config2w_def['cf_description']?>'> <?php echo help("HTML 페이지 내의 meta description으로 사용될 페이지 소개 내용을 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>방문 및 상담 연락 정보</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_contact_info' value='<?php echo $config2w_def['cf_contact_info']?>'> <?php echo help("상담 신청 정보를 입력하십시요. (주소; 전화 번호; 이메일; 상담 환영 메시지)")?></td>
</tr>
<tr class='ht2'>
	<td>구글 맵 위치</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_google_map_pos' value='<?php echo $config2w_def['cf_google_map_pos']?>'> <?php echo help("Google Map Position을 입력하십시요. (위도, 경도)")?></td>
</tr>
<tr class='ht2'>
	<td>구글 맵 API Key</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_google_map_api_key' value='<?php echo $config2w_def['cf_google_map_api_key']?>'> <?php echo help("Google Map API Key를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>구글 캡차 API Key</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_google_captcha_api_key' value='<?php echo $config2w_def['cf_google_captcha_api_key']?>'> <?php echo help("Google Captcha API Key를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>구글 캡차 API Secret</td>
	<td valign=middle><input type=text class="frm_input" size='40' name='cf_google_captcha_api_secret' value='<?php echo $config2w_def['cf_google_captcha_api_secret']?>'> <?php echo help("Google Captcha API Secret를 입력하십시요.")?></td>
</tr>
</table>
</section>

<!--
<section class="cbox">
<h2>메뉴 기본 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
	<td>메인 메뉴 최대 갯수</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_max_menu' value='<?php echo $config2w['cf_max_menu']?>'> <?php echo help("메인 메뉴 최대 갯수를 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>서브 메뉴 최대 갯수</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_max_submenu' value='<?php echo $config2w['cf_max_submenu']?>'> <?php echo help("서브 메뉴 최대 갯수를 입력하십시요.")?></td>
</tr>
</table>
</section>

<section class="cbox">
<h2>화면 기본 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
	<td>화면 좌측 폭</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_width_main_left' value='<?php echo $config2w['cf_width_main_left']?>'> <?php echo help("화면 좌측 폭을 입력하십시요.")?>
	<input type=checkbox name='cf_hide_left' value='1' <?php if($config2w['cf_hide_left']) echo "checked"; ?>> 서브 페이지 화면에서 감춤 (중앙 폭 증가)
	</td>
</tr>
<tr class='ht2'>
	<td>화면 중앙 폭</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_width_main' value='<?php echo $config2w['cf_width_main']?>'> <?php echo help("화면 중앙 폭을 입력하십시요.")?></td>
</tr>
<tr class='ht2'>
	<td>화면 우측 폭</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_width_main_right' value='<?php echo $config2w['cf_width_main_right']?>'> <?php echo help("화면 우측 폭을 입력하십시요.")?>
	<input type=checkbox name='cf_hide_right' value='1' <?php if($config2w['cf_hide_right']) echo "checked"; ?>> 서브 페이지 화면에서 감춤 (중앙 폭 증가)
	</td>
</tr>
<tr class='ht2'>
	<td>상단 스킨 최대 갯수</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_max_head' value='<?php echo $config2w['cf_max_head']?>'> <?php echo help("상단 스킨 최대 갯수를 입력하십시요. 가능한 최대 크기는 20입니다. 가능한 최대 갯수를 증가시키려면 데이타 베이스 테이블을 조정해야 합니다.")?></td>
</tr>
<tr class='ht2'>
	<td>좌측 스킨 최대 갯수</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_max_main_left' value='<?php echo $config2w['cf_max_main_left']?>'> <?php echo help("좌측 스킨 최대 갯수를 입력하십시요. 가능한 최대 크기는 20입니다. 가능한 최대 갯수를 증가시키려면 데이타 베이스 테이블을 조정해야 합니다.")?></td>
</tr>
<tr class='ht2'>
	<td>중앙 스킨 최대 갯수</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_max_main' value='<?php echo $config2w['cf_max_main']?>'> <?php echo help("중앙 스킨 최대 갯수를 입력하십시요. 가능한 최대 갯수는 40입니다. 가능한 최대 갯수를 증가시키려면 데이타 베이스 테이블을 조정해야 합니다.")?></td>
</tr>
<tr class='ht2'>
	<td>우측 스킨 최대 갯수</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_max_main_right' value='<?php echo $config2w['cf_max_main_right']?>'> <?php echo help("우측 스킨 최대 갯수를 입력하십시요. 가능한 최대 크기는 20입니다. 가능한 최대 갯수를 증가시키려면 데이타 베이스 테이블을 조정해야 합니다.")?></td>
</tr>
<tr class='ht2'>
	<td>하단 스킨 최대 갯수</td>
	<td valign=middle><input type=text class="frm_input" size='15' name='cf_max_tail' value='<?php echo $config2w['cf_max_tail']?>'> <?php echo help("하단 스킨 최대 갯수를 입력하십시요. 가능한 최대 크기는 20입니다. 가능한 최대 갯수를 증가시키려면 데이타 베이스 테이블을 조정해야 합니다.")?></td>
</tr>
</table>
</section>
-->

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>

</form>

<script language="javascript">
function fconfigform_submit(f)
{
    f.action = "./basic_config_form_update.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
