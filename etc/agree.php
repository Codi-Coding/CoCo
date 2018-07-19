<?php
include_once("./_common.php");
/// $g5['title'] = "고객 센타 > 이용 약관";
$group[gr_subject] = "고객 센타";
$g5['title'] = "이용 약관";
include_once("./_head.php");

if(!$g5['use_member_register']) {
    echo "<center><font color=#000000>(* $g5[msg_nouse_member_register])</font></center><br>";
}
?>

<table width="97%" border=0 cellspacing=0 cellpadding=5 style="margin:10px; border:1px solid #dddddd; font-size:0.85em">
<tr><td width="100%" valign="top">
<?php $trans = array("\r\n" => "<br>\n"); ?>
<?php echo  strtr($config[cf_stipulation], $trans) ?>
</td></tr></table>

<?php
include_once("./_tail.php");
?>
