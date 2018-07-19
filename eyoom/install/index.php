<?php
include_once ('../../config.php');
include_once ('./install.head.php');
include_once('../classes/qfile.class.php');
$dbconfig_file = '../..'.G5_DATA_PATH.'/'.G5_DBCONFIG_FILE;
include_once($dbconfig_file);

$theme_path = '../theme/';
$qfile = new qfile;

$handle = @opendir($theme_path);
while ($file = @readdir($handle)) {
	if($file == '.'||$file == '..') continue;
	$result_array[] = $file;
}
@closedir($handle);

if(count($result_array) > 0) {
?>
<h1>EYOOM BUILDER <b>INSTALLATION</b></h1>

<form name="installform" action="./install.php" method="post" onsubmit="return check_form(this);">
<div class="ins_inner">
    <p>
        <strong>이윰빌더는 영카트5 기반의 CMS(Contents Management System)입니다. </strong><br>
		<ul>
			<li>이윰빌더는 영카트5 원본을 전혀 수정하지 않기 때문에 향후 영카트5의 업그레이드가 용이합니다.</li>
			<li>또한 이윰빌더는 프로그램영역과 디자인 영역이 분리되어 있어 테마의 수정, 변경 및 제작을 쉽게 하실 수 있습니다.</li>
			<li>이윰빌더의 라이센스는 영카트5의 라이센스에 종속됩니다.</li>
		</ul>

		<p>
		<input type="hidden" name="ins_theme" value="<?php echo $ins_type; ?>">
		<input type="hidden" name="cm_key" id="cm_key" value="">
		<input type="hidden" name="cm_salt" id="cm_salt" value="">
		<input type="hidden" name="tm_name" id="tm_name" value="">
		<input type="hidden" name="tm_shop" id="tm_shop" value="">
		<input type="hidden" name="tm_community" id="tm_community" value="">
		<input type="hidden" name="tm_mainside" id="tm_mainside" value="">
		<input type="hidden" name="tm_subside" id="tm_subside" value="">
		<strong>중요 [테마 라이센스키 입력]</strong><br>
		
		<ul>
			<li>설치할 테마의 라이센스키를 아래에 입력해 주세요.</li>
		</ul>
		
		<input type="text" name="tm_key" id="tm_key" value="" style="width:99%;padding:5px;border:2px solid #333;" placeholder="테마 라이센스키">
		<br><br>
		</p>

		<div class="caution"><b>※ 알림</b> <br>
		- 이윰빌더를 재설치하는 경우, 기존 테이블 정보를 그대로 유지할지 초기화시킬지 선택해 주세요.<br>
		- 처음 설치 시, 아래 체크박스를 체크하지 말고 바로 [설치하기] 를 진행해 주세요.
		</div>
		<div style="border:1px solid #ddd; padding:20px;background:#eee;margin:10px 0;">
			<input type="checkbox" name="table_rest" id="table_reset" value="y"> <label for="table_reset">이윰빌더 테이블 (<?php echo G5_TABLE_PREFIX;?>eyoom_xxxx)의 정보를 초기화합니다. (<b style='color:#f30;'>중요</b> : 체크 시, 이윰빌더용 테이블이 초기화됩니다. 반드시 이윰빌더 관련 테이블을 백업하신 후 진행해 주세요.)</label>
		</div>
    </p>
</div>

<div class="ins_inner">
    <div class="inner_btn">
        <input type="submit" value="설치하기">
    </div>
</div>
</form>

<?php
} else {
?>
<h1><b>INSTALLATION</b></h1>

<div class="ins_inner">
    <p>
        <strong>Theme Error : 설치할 테마가 존재하지 않습니다.</strong><br><br>

		<div class="caution">
		<?php 
			if(count($result_array) == 0) {
		?>
		- 먼저 이윰빌더 베이직 테마를 업로드해 주셔야 합니다.<br>
		- 이윰빌더는 무료로 4종류의 베이직 테마를 제공하고 있습니다.<br>
		- 이윰빌더 베이직 테마는 <a href="http://eyoom.net/shop/list.php?ca_id=1010" target="_blank">이윰넷 > 이유몰 > 테마</a> 에서 최신 버전의 Basic 테마를 자유롭게 다운로드 받으실 수 있습니다.<br><br>
		<?php
			}
		?>
    </p>
</div>

<?php
}
include_once ('./install.tail.php');
?>