<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(gettype($options) == 'string') $options = explode('|', $options);
$img_width = $options[0];
$img_height = $options[1];
$slide_control_height = $options[2];
if(!$img_width) $img_width = 739;
if(!$img_height) $img_height = 214;
if(!$slide_control_height) $slide_control_height = 40; /// default
?>
<style>
a img {
border : 0;
}
div.m_wrap {
width : <?php echo $img_width?>px;
margin : 0 auto;
text-align : left;
}
div#m_top div#nav {
float : left;
clear : both;
width : <?php echo $img_width?>px;
height : 52px;
margin : 22px 0 0;
}
div#m_top div#nav ul {
float : left;
width : <?php echo $img_width?>px;
height : 52px;
list-style-type : none;
}
div#nav ul li {
float : left;
height : 52px;
}
div#nav ul li a {
border : 0;
height : 52px;
display : block;
line-height : 52px;
text-indent : -9999px;
}
div#m_header {
margin : 0;
width:<?php echo $img_width?>px;
height:<?php echo $img_height?>px;
border:0px solid #dddddd;
}
div#video-header {
height : <?php echo $img_height?>px;
margin : -1px 0 0;
}
div#m_header div.m_wrap {
height : <?php echo $img_height?>px;
}
div#m_header div#slide-holder {
/* z-index : -1; */
width : <?php echo $img_width?>px;
height : <?php echo $img_height?>px;
position : absolute;
}
div#m_header div#slide-holder div#slide-runner {
width : <?php echo $img_width?>px;
height : <?php echo $img_height?>px;
overflow : hidden;
position : absolute;
}
div#m_header div#slide-holder img {
margin : 0;
display : none;
position : absolute;
}
div#m_header div#slide-holder div#slide-controls {
left : 0;
top : <?php echo ($img_height-$slide_control_height)?>px;
width : <?php echo $img_width?>px;
height : <?php echo $slide_control_height?>px;
display : none;
position : absolute;
}
div#m_header div#slide-holder div#slide-controls p.text {
float : left;
color : #fff;
display : inline;
font-size : 13px;
line-height : 16px;
margin : 15px 0 0 20px;
text-transform : uppercase;
}
div#m_header div#slide-holder div#slide-controls p#slide-nav {
float : right;
height : 24px;
display : inline;
margin : 11px 15px 0 0;
}
div#m_header div#slide-holder div#slide-controls p#slide-nav a {
float : left;
width : 15px;
height : 15px;
display : inline-block;
color: #86a2b8;
font-size : 12px;
margin : 1px;
line-height : 15px;
font-weight : bold;
text-align : center;
text-decoration : none;
background-position : 0 0;
background-repeat : no-repeat;
}
div#m_header div#slide-holder div#slide-controls p#slide-nav a.on {
background-position : 0 -15px;
color : #ffffff;
}
div#m_header div#slide-holder div#slide-controls p#slide-nav a {
background-image : url(<?php echo $latest_skin_url?>/images/slide-nav.png);
}
</style>
<script type="text/javascript" src="<?php echo $latest_skin_url?>/js/scripts.js"></script>
<style>
	a.ab:link, a.ab:visited {
	color : #fff;
	text-decoration : none;
	}
</style>

<div id="m_header"><div class="m_wrap">
 <div id="slide-holder">
	<div id="slide-runner">
	<?php for ($i=0; $i<count($list); $i++) { 
		$imagepath = $list[$i][file][0][path]."/".$list[$i][file][0][file];
		$noimage = $latest_skin_url."/img/noimage.gif";
	?>
	<a href="<?php echo set_http($list[$i]['href'])?>" style='color:#fff;border:0px;' target='_self'><img id="slide-img-<?php echo ($i+1)?>" src="<?php echo $imagepath?>" width="<?php echo $img_width?>" height="<?php echo $img_height?>" alt="<?php echo $list[$i][wr_subject]?>" /></a>
	<?php } ?>

	<div id="slide-controls">
	 <p id="slide-nav"></p>
	</div>
</div>
 </div>
 <script type="text/javascript">
	if(!window.slider) var slider={};slider.data=[
	<?php for ($i=0; $i<count($list); $i++) { ?>
	{"id":"slide-img-<?php echo ($i+1)?>","client":"<?php echo $list[$i][subject]?>","desc":""}<?if(($i+1) != count($list)){?>,<?php } ?>
	<?php } ?>
	];
 </script>
</div></div>
