<?php
$tmpl[$i] = $arr[$i];
$tmpl_name[$i] = "쇼핑몰 - G5";
$line1 = "
- 그누보드5 기반 쇼핑몰입니다.
";
$line2 = "
";
$line3 = "
";
$sql = " desc {$g5['g5_shop_default_table']}";
$result = @sql_query($sql);
?>

<span style="font-size:16px; font-weight:bold">[<?php echo $tmpl[$i]?>]</span>
<span style="font-size:14px; font-weight:normal; float:right"><?php echo $tmpl_name[$i]?></span>

<div style="margin-top:8px; line-height:150%">
<?php echo $line1?>
<br>
<?php echo $line2?>
<br>
<?php echo $line3?>
<br>
<?php if($result) {?>
<span style="float:right; margin-left:10px; font-size:14px; font-weight:normal; padding:5px 7px; border:1px solid #ddd; border-radius:3px; background:#eee"><a href="./<?php echo $tmpl[$i]?>/uninstall/index.php">삭제</a></span>
<?php if(defined('G5_USE_SHOP') && G5_USE_SHOP) { ?>
<span style="float:right; font-size:14px; font-weight:normal; padding:5px 7px; border:1px solid #ddd; border-radius:3px; background:#eee"><a href="./<?php echo $tmpl[$i]?>/use_config.php?use_shop=false">이용하지 않음</a></span>
<?php } else { ?>
<span style="float:right; font-size:14px; font-weight:normal; padding:5px 7px; border:1px solid #ddd; border-radius:3px; background:#eee"><a href="./<?php echo $tmpl[$i]?>/use_config.php?use_shop=true">이용</a></span>
<?php } ?>
<span style="font-size:12px; font-weight:normal; color:#777">*설치되어 있슴</span>
<?php if(defined('G5_USE_SHOP') && G5_USE_SHOP) { ?>
<span style="font-size:12px; font-weight:normal; color:#777; padding-left:10px">*이용</span>
<?php } else { ?>
<span style="font-size:12px; font-weight:normal; color:#777; padding-left:10px">*이용하지 않음</span>
<?php } ?>
<?php } else { ?>
<span style="float:right; font-size:14px; font-weight:normal; padding:5px 7px; border:1px solid #ddd; border-radius:3px; background:#eee"><a href="./<?php echo $tmpl[$i]?>/index.php">설치</a></span>
<span style="font-size:12px; font-weight:normal; color:#777">*설치되어 있지 않음</span>
<?php } ?>
</div>
