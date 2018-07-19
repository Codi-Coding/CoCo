<?php
include_once("./_common.php");

$view = get_view($write, $board, $board_skin_url);

if (strstr($sfl, "subject"))
    $view[subject] = search_font($stx, $view[subject]);

$html = 0;
if (strstr($view[wr_option], "html1"))
    $html = 1;
else if (strstr($view[wr_option], "html2"))
    $html = 2;

$view[content] = conv_content($view[wr_content], $html);
if (strstr($sfl, "content"))
    $view[content] = search_font($stx, $view[content]);
$view[content] = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 name='target_resize_image[]' onclick='image_window(this)' style='cursor:pointer;' \\2 \\3", $view[content]);
?>
<!doctype html>
<html>
<head>
<title><?php echo $view[subject]?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo $board_skin_url?>/style.css">
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
	/*overflow:hidden;*/
}
.small { font-size:10px; font-family:Verdana; }
-->
#table10 img{ width:93px; height:93px;}
</style>
<!--뮤직부분-->
<script src="<?php echo $board_skin_url?>/audiojs/audio.min.js"></script>
<!--<link rel="stylesheet" href="<?php echo $board_skin_url?>/includes/index.css" media="screen">-->
<link rel="stylesheet" href="<?php echo $board_skin_url?>/style.css" media="screen">
<script>
  audiojs.events.ready(function() {
    audiojs.createAll();
  });
</script>
<!--뮤직부분 끝-->
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<table width="97%" border="0" id="table1" cellspacing="0" cellpadding="3" style="margin:10px auto">
	<tr>
		<td valign="top">
		<div align="center">
		<table width="100%" border="0" id="table7" cellspacing="0" cellpadding="0">
			<tr>
				<td bgcolor=#fff>
				<table width="100%" border="0" id="table9" cellspacing="0" cellpadding="0">
					<tr>
						<td width=70>
						<table border="0" width="68" id="table10" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
							<tr>
								<?php 
									// 파일 출력
										if ($view[file][0][view]) {
											echo "<td bgcolor='#FFFFFF'>".$view[file][0][view]."</td>";
										} else {
											echo "<td bgcolor='#FFFFFF' height='68' class='small' align='center'>NO IMG</td>";
										}
								?>
							</tr>
						</table>
						</td>
						<td width=10>&nbsp;</td>
						<td valign="top">
						<table border="0" width="100%" id="table11" cellspacing="1">
							<tr>
								<td>
								<table border="0" id="table13" cellspacing="1">
									<tr>
										<td><b><font size="2" color="#000000"><?php echo $view[subject]?></font></b></td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td>
								<table border="0" id="table12" cellspacing="1">
									<tr>
										<td><font color="#F40242">제작자</font>: </td>
										<td><?php echo $view[wr_1]?></td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td height="5">
				</td>
			</tr>
			<tr>
				<td height="30">
				<?php 
			 	if($view["wr_link1"]){
					$music_sir = $view["wr_link1"];
				}elseif($view[file][1][file]){
					$music_sir = G5_URL."/data/file/".$bo_table."/".$view[file][1][file];
				}
				?>
				<br>
				<audio src="<?php echo $music_sir?>" preload="none"></audio>
				<?php if ($view['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $view['comment_cnt'];?><span class="sound_only">개</span><?php } ?>
				</td>
			</tr>
			<tr>
				<td height="15">
				</td>
			</tr>
			<tr>
				<td>
				<table width="342" height="330" border="0" style="width:100%" id="table8" cellspacing="1" bgcolor="#E5E5E5">
					<tr>
						<td bgcolor="#FFFFFF" valign="top"><DIV id="scrollbox0" style="width: 98%; height: 100%; overflow: auto; border: 0 solid black; padding: 5px; background-color: #FFFFFF"><?php echo $view[content];?></DIV>
						</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</div>
		</td>
	</tr>
	<tr>
		<td align="center"><a href="javascript:window.close()"><img src="<?php echo $board_skin_url?>/img/btn_close2.gif" onmouseover="this.src='<?php echo $board_skin_url?>/img/btn_close2_on.gif'" onmouseout="this.src='<?php echo $board_skin_url?>/img/btn_close2.gif'" border="0"></a></td>
	</tr>
</table>

</body>
</html>
<script type="text/javascript" src="<?php echo "$g5[legacy_url]/js/board.js"?>"></script>
<script type="text/javascript">
window.onload=function() {
    resizeBoardImage(68);
    drawFont();
}
</script>
