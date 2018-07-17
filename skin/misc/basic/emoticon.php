<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 이모티콘 구분자 : 이모티콘 또는 emo
$emo_txt = "이모티콘";

?>
<style>
body { margin:0; padding:0 }
.emoticon-head { padding:10px; font-family:tahoma; }
.emoticon-box { text-align:center; margin:10px; }
.emoticon-img { width:50px; height:50px; margin:10px 10px 0px 0px; cursor:pointer; border:1px solid #ddd; }
</style>
<form name="femo" method="get" style="margin:0px;">
<div class="emoticon-head bg-navy">
<b class="font-14">
	<i class="fa fa-smile-o fa-lg"></i>
	EMOTICON
</b>
<?php if($eskin_cnt) { ?>
	&nbsp;
	<select class="black" name="eskin" onchange="location='<?php echo G5_BBS_URL;?>/emoticon.php?edir='+encodeURIComponent(this.value)+'&fid=<?php echo urlencode($fid);?>'">
		<option value="">Basic</option>
		<?php for($i=0; $i < $eskin_cnt; $i++) { ?>
			<option value="<?php echo $eskin[$i];?>"<?php echo get_selected($edir,$eskin[$i]);?>><?php echo ucfirst($eskin[$i]);?></option>
		<?php } ?>
	</select>
<?php } ?>
</div>
</form>

<div class="emoticon-box">
	<?php for($i=0; $i < count($emoticon); $i++) { ?>
		<img src="<?php echo $emoticon[$i]['url'];?>" onclick="emoticon_insert('<?php echo $emoticon[$i]['name'];?>');" class="emoticon-img" alt="">
	<?php } ?>
</div>

<br>

<div class="btn_confirm01 btn_confirm">
	<button onclick="window.close();" type="button">닫기</button>
</div>

<br>

<script> 
	function emoticon_insert(emo){
		img = "{<?php echo $emo_txt;?>:" + emo + ":50}";
		<?php if($fid == 'wr_content' || $fid == 'me_memo') { ?>
			opener.document.getElementById("<?php echo $fid;?>").value += img;
		<?php } else { ?>
			opener.document.getElementById("<?php echo $fid;?>").value = img;
		<?php } ?>
		<?php if($sid) { ?>
			opener.document.getElementById("<?php echo $sid;?>").innerHTML = "<img src=\"<?php echo G5_URL;?>/img/emoticon/" + emo + "\">";
		<?php } ?>
		self.close();
	}
</script>
