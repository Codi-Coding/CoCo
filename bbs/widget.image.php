<?php
define('G5_IS_ADMIN', true);
include_once('./_common.php');

if (($mode == 'del' || $mode == 'up') && !$is_designer) {
    alert("관리자만 가능합니다.");
}

switch($type) {
	case 'banner'	: $title = 'Banner Box'; $filedir = '/apms/banner/'; break;
	case 'title'	: $title = 'Title Box'; $filedir = '/apms/title/'; break;
	case 'image'	: $title = 'Image Box'; $filedir = '/apms/image/'; break;
	default			: $title = 'Background Box'; $filedir = '/apms/background/'; break;
}

// 폴더생성
if(!is_dir(G5_DATA_PATH.$filedir)) {
	@mkdir(G5_DATA_PATH.$filedir, G5_DIR_PERMISSION);
	@chmod(G5_DATA_PATH.$filedir, G5_DIR_PERMISSION);
}

if($mode == "del") {
	@unlink(G5_DATA_PATH.$filedir.$filename);
} else if ($mode == "up") {
	if(!$_FILES['upload_file']['tmp_name']) alert("파일을 등록해 주세요.");

	if (!preg_match("/(\.(jpg|gif|png))$/i", $_FILES['upload_file']['name'])) {
		alert('JPG, GIF, PNG 파일만 등록이 가능합니다.');
	}

	if(strlen($_FILES['upload_file']['name']) > 40) {
		alert('확장자 포함해서 파일명을 40자 이내로 등록할 수 있습니다.'); 
	}
	if (!preg_match("/([-A-Za-z0-9_])$/", $_FILES['upload_file']['name'])) { 
		alert('파일명은 10자 이내로 공백없이 영문자, 숫자, -, _ 만 사용 가능합니다.'); 
	}

	list($thumb) = explode('-', $_FILES['upload_file']['name']);
	if($thumb == 'thumb') {
		alert('파일명이 thumb- 일 경우 썸네일 파일로 인식되기 때문에 등록할 수 없습니다.'); 
	}

	if (is_uploaded_file($_FILES['upload_file']['tmp_name'])) {
		$dest_file = G5_DATA_PATH.$filedir.$_FILES['upload_file']['name'];

		// 기존파일 삭제
		@unlink($dest_file);

		// 파일등록
		@move_uploaded_file($_FILES['upload_file']['tmp_name'], $dest_file);

		// 퍼미션변경
		@chmod($dest_file, G5_FILE_PERMISSION);
	}

	goto_url(G5_BBS_URL.'/widget.image.php?fid='.urlencode($fid).'&amp;type='.$type);
}

$action_url = G5_HTTPS_BBS_URL.'/widget.image.php';

include_once(G5_PATH.'/head.sub.php');
?>
<style>
	body { margin:0 0 30px; padding:0; font:normal 12px dotum; -webkit-text-size-adjust:100%; background:#fafafa;}
	a, a:hover { text-decoration:none; }
	h2 { padding:15px; text-align:center; color:#fff; background:#000; font-size:18px; font-family:tahoma; font-weight:bold; margin:0; }
	ul { padding:0px; margin:15px; list-style:none; }
	ul li { float:left; padding:10px; margin:0px; position:relative; }
	ul li img { display:block; cursor:pointer; border:4px solid #efefef; width:80px; height:80px; }
	ul li img:hover { border:4px solid #000; }
	p.del { color:#ccc !important; margin:0px; padding:5px 0px 0px; text-align:center; }
	p.del a { color:#ccc !important; }
	p.del a:hover { color:orangered !important; }
	.uploader { background:#eee; text-align:center; padding:15px; }
	.upload-css { position:absolute; top:45px; line-height:20px; font-size:10px; font-family:verdana; text-align:center; background:#000; font-weight:bold; color:#fff; width:88px; }
	.bg-none { display:block; width:80px; height:80px; line-height:80px; text-align:center; cursor:pointer; background:#ddd; color:#fff; font-size:60px; border:4px solid #efefef; }
	.left { float:left; }
</style>
<h2><?php echo $title;?></h2>

<form id="widgetForm" name="widgetForm" method="post" enctype="multipart/form-data" action="<?php echo $action_url;?>">
	<input type="hidden" name="fid" value="<?php echo $fid;?>">
	<input type="hidden" name="type" value="<?php echo $type;?>">
	<input type="hidden" name="mode" value="up">
	<div class="uploader">
		<input type="file" name="upload_file" value="">
		<button type="submit" class="btn_frmline">등록하기</button>
	</div>
</form>

<ul class="widget-wrap">
	<li>
		<span class="img-select" title="none"><b class="bg-none"><i class="fa fa-times"></i></b></span>
		<p class="del"></p>
	</li>
	<?php
		//출력하기
		$srow = thema_switcher('file', G5_DATA_PATH.$filedir, '', "jpg|png|gif");
		for($i=0; $i < count($srow); $i++) {
			//썸네일은 제외 : 접두어가 thumb- 로 시작
			list($thumb) = explode('-', $srow[$i]['name']);
			if($thumb == 'thumb') {
				continue;			
			}
	?>
	<li>
		<img src="<?php echo G5_DATA_URL.$filedir.$srow[$i]['name'];?>" alt="<?php echo $srow[$i]['name'];?>" class="img-select">
		<p class="del">
			<a href="<?php echo G5_BBS_URL;?>/widget.image.php?mode=del&amp;fid=<?php echo urlencode($fid);?>&amp;filename=<?php echo urlencode($srow[$i]['name']);?>&amp;type=<?php echo $type;?>" title="삭제" class="del-file">
				<i class="fa fa-times"></i>
			</a>
		</p>
	</li>
	<?php } ?>
</ul>
<div style="clear:both;"></div>
<p align="center">
	<button type="button" onclick="self.close();" class="btn_frmline">창닫기</button>
</p>
<script>
	jQuery(document).ready(function($) {
		$('.del-file').click(function() {
			if(confirm("삭제하시겠습니까?")) {
				location.href = this.href;
			}
			return false;
		});

		$('.img-select').click(function() {
			$("#<?php echo $fid;?>",opener.document).val(this.src); 
			return false;
		});
	});
</script>
<?php include_once(G5_PATH."/tail.sub.php"); ?>