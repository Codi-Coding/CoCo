<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 아이콘 치환자 : 아이콘 또는 icon
$icon_txt = "아이콘";

?>
<style>
body { background:#fff; }
a { color:#333; margin:7px; text-align:center; width:30px; line-height:30px; display:inline-block; text-decoration:none;}
a:hover { color:crimson; text-decoration:none; }
.icon-box { margin:10px 10px 30px; }
.as-box { background:#333; color:#fff; padding:10px 15px; }
.as-box-head b { font-family:tahoma; font-size:16px; }
.input-box { 
	position:fixed;left:0;top:0;width:100%; border:0; background:rgb(223, 17, 25); padding:10px; text-align:center; z-index:2; 
	-webkit-box-shadow: -5px 2px 10px 2px rgba(0,0,0,0.3);
	-moz-box-shadow: -5px 2px 10px 2px rgba(0,0,0,0.3);
	box-shadow: -5px 2px 10px 2px rgba(0,0,0,0.3);
}
</style>
<?php if(!$fid) { ?>
	<div class="input-box">
		<input type="text" id="fa_content" name="fa_content" value="" class="frm_input" placeholder="아이콘 선택 후 복사해서 붙여넣어 주세요." style="width:80%; height:24px;">
	</div>
	<div style="height:45px;"></div>
<?php } ?>

<div id="web-application">
	<div class="as-box as-box-head">
		<b>Web Application Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['web']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['web'][$i];?>');"><i class="fa fa-<?php echo $fas['web'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="accessibility">
	<div class="as-box as-box-head">
		<b>Accessibility Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['access']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['access'][$i];?>');"><i class="fa fa-<?php echo $fas['access'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="hand">
	<div class="as-box as-box-head">
		<b>Hand Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['hand']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['hand'][$i];?>');"><i class="fa fa-<?php echo $fas['hand'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="transportation">
	<div class="as-box as-box-head">
		<b>Transportation Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['trans']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['trans'][$i];?>');"><i class="fa fa-<?php echo $fas['trans'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="transportation">
	<div class="as-box as-box-head">
		<b>Gender Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['gender']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['gender'][$i];?>');"><i class="fa fa-<?php echo $fas['gender'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="filetype">
	<div class="as-box as-box-head">
		<b>File Type Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['file']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['file'][$i];?>');"><i class="fa fa-<?php echo $fas['file'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="spinner">
	<div class="as-box as-box-head">
		<b>Spinner Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['spin']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['spin'][$i];?>');"><i class="fa fa-<?php echo $fas['spin'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="form-control">
	<div class="as-box as-box-head">
		<b>Form Control Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['form']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['form'][$i];?>');"><i class="fa fa-<?php echo $fas['form'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="payment">
	<div class="as-box as-box-head">
		<b>Payment Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['pay']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['pay'][$i];?>');"><i class="fa fa-<?php echo $fas['pay'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="chart">
	<div class="as-box as-box-head">
		<b>Chart Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['chart']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['chart'][$i];?>');"><i class="fa fa-<?php echo $fas['chart'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="currency">
	<div class="as-box as-box-head">
		<b>Currency Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['cur']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['cur'][$i];?>');"><i class="fa fa-<?php echo $fas['cur'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="text-editor">
	<div class="as-box as-box-head">
		<b>Text Editor Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['edit']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['edit'][$i];?>');"><i class="fa fa-<?php echo $fas['edit'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="directional">
	<div class="as-box as-box-head">
		<b>Directional Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['direct']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['direct'][$i];?>');"><i class="fa fa-<?php echo $fas['direct'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="video-player">
	<div class="as-box as-box-head">
		<b>Video Player Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['video']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['video'][$i];?>');"><i class="fa fa-<?php echo $fas['video'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="brand">
	<div class="as-box as-box-head">
		<b>Brand Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['brand']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['brand'][$i];?>');"><i class="fa fa-<?php echo $fas['brand'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div id="medical">
	<div class="as-box as-box-head">
		<b>Medical Icons</b>
	</div>
	<div class="icon-box">
		<?php for($i=0; $i < count($fas['medical']); $i++) { ?>
			<a href="javascript:insert_icon('<?php echo $fas['medical'][$i];?>');"><i class="fa fa-<?php echo $fas['medical'][$i];?> fa-2x"></i></a>
		<?php } ?>
	</div>
</div>

<div class="btn_confirm01 btn_confirm">
	<button onclick="window.close();" type="button">닫기</button>
</div>

<br>

<script> 
	function insert_icon(icon){
		<?php if($fid) { ?>
			var fa = "{<?php echo $icon_txt;?>:" + icon + "}";
			$("#<?php echo $fid;?>",opener.document).val(fa);
			<?php if($sid) { ?>
				opener.document.getElementById("<?php echo $sid;?>").innerHTML = "<i class=\"fa fa-" + icon + "\"></i>";
			<?php } ?>
			window.close();
		<?php } else { ?>
			var fa = document.getElementById("fa_content");
			fa.value = "{<?php echo $icon_txt;?>:" + icon + "}";
			fa.focus();
		<?php } ?>
	}
</script>
