<?php // 굿빌더 ?>
<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

/// 높이는 제한 없슴
/*$table_width = 367;*/
$table_width = 387;
$image_width = 320;
$pop_top = 150;
/*$pop_left = 350;*/
$pop_left = 300;

for ($i=0; $i<count($list); $i++) {

  $img = G5_URL."/data/file/$bo_table/".urlencode($list[$i][file][0][file]);
  if (!file_exists($img) || !$list[$i][file][0][file]) echo "";

  if ($list[$i][wr_1] == "1") { 
     if($list[$i][wr_link1])
        $list_link = $list[$i][wr_link1]; 
     else
        $list_link = $list[$i][href];

    $html = 0;
    if (strstr($list[$i][wr_option], "html1"))
        $html = 1;
    else if (strstr($list[$i][wr_option], "html2"))
        $html = 2;

    $content = conv_content(_t($list[$i][wr_content]), $html);
    /// 편집기의 bbs 기준 상대 경로를 홈에 맞게 조정
    $content = strtr($content, array(' src="../data/geditor' => ' src="data/geditor', ' src="../data/cheditor4' => ' src="data/cheditor4'));
?>
<script language="JavaScript">
<!--
function setCookie( name, value, expiredays ) { 
var todayDate = new Date(); 
todayDate.setDate( todayDate.getDate() + expiredays ); 
document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
} 

function closeWin() { 
if ( document.notice_form.chkbox.checked ){ 
setCookie( "mainpopup", "done" , 1 ); 
} 
document.getElementById("popup").style.visibility = "hidden";
document.getElementById("popup").style.display = "none";
}
//--> 
</script>
<SCRIPT language=javascript>
<!--  
clicked = false;
function startDrag(cx,cy) {
        clicked = true;
        pleft=parseInt(document.getElementById("popup").style.left);
   ptop=parseInt(document.getElementById("popup").style.top);
        dragxcoor=cx;        
   dragycoor=cy;        
}
                
function stopDrag() { 
        clicked = false;
}
        
function dragBox(evt) {
e = evt || event;
        if (clicked == true) {
      newx = pleft+e.clientX-dragxcoor;
           newy = ptop+e.clientY-dragycoor;
                document.getElementById("popup").style.left=newx;
                document.getElementById("popup").style.top=newy;
                return false;
   }
}
document.onmousemove = dragBox;
//-->
</SCRIPT>
<div id="popup" style="background:#fff; position:absolute; left:<?php echo $pop_left?>px; top:<?php echo $pop_top?>px; z-index:1200; visibility:hidden; display:table; cursor:move; line-height:1.5" onmousedown="startDrag(event.clientX,event.clientY)" onmouseup="stopDrag()">
<table border='0' cellspacing='0' cellpadding='0' style="background:#f5f5f5; border:1px solid #aaa">
  <tr> 
    <td colspan=4 height=31 align=center><font size=2><b><?php ///echo get_text($list[$i][wr_subject])?></b></font></td>
  </tr>
  <tr> 
    <td width='10' height='1'></td>
    <td colspan='2' valign='top' style='padding:2px'>
      <?php if ($list[$i][wr_2] == "") { ?>
      <a href="<?php echo $list_link?>" target="<?php echo $list[$i][wr_3]?>"><img src="<?php echo $img?>" width="<?php echo $table_width?>" border='0' onclick="closeWin();"></a>
      <?php } else { ?>
      <table width='<?php echo $table_width?>' border='0' cellspacing='0' cellpadding='0' style="background:#fff; border:1px solid #ccc">
      <tr>
      <td colspan=3 height='10'></td>
      </tr>
      <tr>
      <td width='23' height='1'></td>
      <td valign='top'> 
      <table width=100% border=0 cellspacing=0 cellpadding=0 align=center>
      <tr><td height=25><div onclick="closeWin();"><a href="<?php echo $list_link?>" target="<?php echo $list[$i][wr_3]?>">♣&nbsp;<b><?php echo get_text(_t($list[$i][wr_subject]))?></b></a></div></td><td align=right><?php echo $list[$i][datetime]?></td></tr>
      <tr><td height=1 colspan=2 bgcolor=#CCCCCC></td></tr>
      <tr><td height=2 colspan=2 bgcolor=#EFEFEF></td></tr>
      <tr><td valign=top height=<?php echo $image_width?> colspan=2 style=padding-top:10px;>
      <?php if ($list[$i][wr_2] == "1") { ?>
      <a href="<?php echo $list_link?>" target="<?php echo $list[$i][wr_3]?>"><img src="<?php echo $img?>" width="<?php echo $image_width?>" style='border:1px solid #ffffff' onmouseover="this.style.borderColor='#aa0000"' onmouseout="this.style.borderColor='#ffffff'" onclick="closeWin();"></a>
      <?php } else if ($list[$i][wr_2] == "2") { ?>
      <?php echo $content?>
      <?php } else if ($list[$i][wr_2] == "3") { ?>
      <a href="<?php echo $list_link?>" target="<?php echo $list[$i][wr_3]?>"><img src="<?php echo $img?>" width="<?php echo $image_width?>" style='border:1px solid #ffffff' onmouseover="this.style.borderColor='#aa0000'" onmouseout="this.style.borderColor='#ffffff'" onclick="closeWin();"></a>
      <br><br>
      <?php echo $content?>
      <?php } ?>
      </td>
      </tr>
      <tr>
      <td colspan=2 height='10'></td>
      </tr>
      </table>
      </td>
      <td width='24' height='8'></td>
      </tr>
      </table>
      <?php } ?>
    </td>
    <td width='10' height='1'></td>
  </tr>
  <tr> 
    <td width='10' height='31'></td>
    <td colspan='2'>	
    <form name="notice_form">
       <table width='100%' border='0' cellspacing='0' cellpadding='0'>
       <tr>
       <td width="4"></td>
       <td width="18"><a href="#"><input type="checkbox" name="chkbox" value="checkbox" onclick="closeWin();"></a></td>
       <td align='left'><?php echo _t('오늘은 이 창을 다시 열지 않음'); ?></td>
       <td width="70"><a href="javascript:closeWin();"><img src='<?php echo $latest_skin_url?>/img/btn_close.gif' width='66' height='20' align='absmiddle' border='0'></a></td>
       <td width="2"></td>
       </tr>
       </table>
    </form>
    </td>
    <td width='10' height='31'></td>
  </tr>
</table>
</div> 
<script language="Javascript">
cookiedata = document.cookie; 
if ( cookiedata.indexOf("mainpopup=done") < 0 ){ 
document.getElementById("popup").style.visibility = "visible";
} 
else {
document.getElementById("popup").style.visibility = "hidden"; 
document.getElementById("popup").style.display = "none"; 
}
</script>
<?php break; /// popup 1 개 표시 후 종료 ?>
<?php }?>
<?php }?>
