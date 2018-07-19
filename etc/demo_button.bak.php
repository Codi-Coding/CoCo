<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<?php ///if($is_admin && defined('DEMO_BUTTON') && DEMO_BUTTON) { ?>
<?php if(defined('DEMO_BUTTON') && DEMO_BUTTON) { ?>
<link rel="stylesheet" href="<?php echo G5_URL?>/css/demo_button.css">

<div id="demo">
<form method=post>
<div><?php echo BUILDER_NAME.' '.BUILDER_VERSION_NUMBER.' '.BUILDER_VERSION_CLASS.' '?>데모 템플릿 (<?php if(G5_IS_MOBILE) echo 'mobile'; else echo 'pc'; ?>)</div>
<a href='<?php echo G5_URL?>/?tmpl=basic&device=pc'>PC 기본 템플릿</a> &nbsp; 
<?php if(G5_IS_MOBILE) { ?>
<select name=mobile_tmpl>
<?php } else { ?>
<select name=tmpl>
<?php } ?>
<option value="">Default 설정값
<?php
if(G5_IS_MOBILE) {
    for ($i = 0; $i < count($mobile_tmpl_arr); $i++) {
          if($mobile_tmpl_arr[$i] == $g5['mobile_tmpl']) $selected = " selected";
          else $selected = "";
          echo '<option value="'.$mobile_tmpl_arr[$i].'"'.$selected.'>'.$i.'. '.$mobile_tmpl_arr[$i].PHP_EOL;
    }
} else {
    for ($i = 0; $i < count($tmpl_arr); $i++) {
          if($tmpl_arr[$i] == $g5['tmpl']) $selected = " selected";
          else $selected = "";
          echo '<option value="'.$tmpl_arr[$i].'"'.$selected.'>'.$i.'. '.$tmpl_arr[$i].PHP_EOL;
    }
}
?>
</select>
<input type=submit value="선택">
 &nbsp; <a href='<?php echo G5_URL?>/?tmpl=basic&device=mobile'>모바일 기본 템플릿</a>
</form>
</div>
<?php } ?>
